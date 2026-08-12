<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * TimeShift Lite (local_timeshift)
 *
 * @package     local_timeshift
 * @copyright   2026 EduPlugins Studio
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
// phpcs:disable moodle.Files.LineLength.TooLong
// phpcs:disable moodle.Files.LineLength.MaxExceeded
// phpcs:disable moodle.Commenting.MissingDocblock.File
require_once($CFG->dirroot . '/local/timeshift/classes/manager.php');

$courseid = required_param('courseid', PARAM_INT);

require_login($courseid);
$context = context_course::instance($courseid);
require_capability('moodle/course:update', $context);

$course = $DB->get_record('course', ['id' => $courseid], '*', MUST_EXIST);

$PAGE->set_url(new moodle_url('/local/timeshift/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_title(get_string('pagetitle', 'local_timeshift'));
$PAGE->set_heading($course->fullname);

$activities = \local_timeshift\manager::get_course_activities($courseid);

// Preload availability JS to prevent infinite loading in Moodle 4.1 ModalForms due to YUI restrictions.
$modinfo = get_fast_modinfo($course);
$cms = $modinfo->get_cms();
$firstcm = reset($cms);
if ($firstcm) {
    \core_availability\frontend::include_all_javascript($course, $firstcm);
}

echo $OUTPUT->header();

$iconurl = new moodle_url('/local/timeshift/pix/icon.png');
$helpicon = $OUTPUT->help_icon('pagedescription', 'local_timeshift');

$activitiesbysection = [];
foreach ($activities as $act) {
    $sec = $act->sectionnum;
    if (!isset($activitiesbysection[$sec])) {
        $activitiesbysection[$sec] = [
            'secnum' => $sec,
            'secname' => s($act->sectionname),
            'activities' => [],
        ];
    }

    // Format dates for input type datetime-local (YYYY-MM-DDThh:mm).
    $allowfrom = !empty($act->allowfromdate) ? date('Y-m-d\TH:i', $act->allowfromdate) : '';
    $due = !empty($act->duedate) ? date('Y-m-d\TH:i', $act->duedate) : '';
    $cutoff = !empty($act->cutoffdate) ? date('Y-m-d\TH:i', $act->cutoffdate) : '';

    $iconhtml = '';
    if (!empty($act->iconurl)) {
        // Determine icon color based on Moodle 4 module categories.
        $modpurposes = [
            // Assessment.
            'assign' => 'assessment', 'quiz' => 'assessment', 'workshop' => 'assessment', 'certificatebeautiful' => 'assessment', 'coursecertificate' => 'assessment',
            // Communication.
            'choice' => 'communication', 'feedback' => 'communication', 'chat' => 'communication', 'bigbluebuttonbn' => 'communication', 'zoom' => 'communication',
            // Content.
            'book' => 'content', 'folder' => 'content', 'label' => 'content', 'page' => 'content', 'qbank' => 'content', 'resource' => 'content', 'url' => 'content', 'emubook' => 'content', 'videotrack' => 'content', 'codeframe' => 'content',
            // Collaboration.
            'data' => 'collaboration', 'database' => 'collaboration', 'forum' => 'collaboration', 'glossary' => 'collaboration', 'wiki' => 'collaboration', 'diary' => 'collaboration',
            // Interactive content.
            'h5pactivity' => 'interactive_content', 'imscp' => 'interactive_content', 'lesson' => 'interactive_content', 'scorm' => 'interactive_content',
            // Administration & Other.
            'attendance' => 'administration', 'lti' => 'other',
            // Custom.
            'hvp' => 'hvp_black',
        ];
        $purposecolors = [
            'assessment' => '#fa0086',
            'communication' => '#fe5701',
            'content' => '#00a5ad',
            'collaboration' => '#6f46f7',
            'interactive_content' => '#3c73b8',
            'hvp_black' => '#212529',
            'administration' => '#5d63f6',
            'other' => '#6c757d',
            'default' => '#6c757d',
        ];
        $purpose = isset($modpurposes[$act->modname]) ? $modpurposes[$act->modname] : 'default';
        $iconbg = $purposecolors[$purpose];

        if ($act->modname === 'hvp') {
            // HVP plugin comes with its own colored square icon, so we don't wrap it or invert it.
            $iconhtml = '<img src="' . $act->iconurl . '" alt="' . $act->modname . ' icon" style="width: 32px; height: 32px; border-radius: 6px;">';
        } else {
            $iconbglight = $iconbg . '26'; // 15% opacity hex alpha
            $iconhtml = '<div style="background-color: ' . $iconbglight . '; width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">';
            $iconhtml .= '<div style="background-color: ' . $iconbg . '; width: 20px; height: 20px; -webkit-mask-image: url(' . $act->iconurl . '); -webkit-mask-size: contain; -webkit-mask-repeat: no-repeat; mask-image: url(' . $act->iconurl . '); mask-size: contain; mask-repeat: no-repeat;"></div>';
            $iconhtml .= '</div>';
        }
    }

    $displayname = isset($act->modfullname) ? $act->modfullname : ucfirst($act->modname);
    // Explicitly handle H5pactivity just in case the localized string still says H5P activity.
    if (strtolower($displayname) === 'h5pactivity' || strtolower($displayname) === 'h5p activity') {
        $displayname = 'H5p';
    }
    if ($act->modname === 'label') {
        $displayname = 'Label';
    }

    $hasdates = false;
    $allowdisabled = false;
    $cutoffdisabled = false;
    // Dates editable for assign/quiz/forum. Others can be extended later.
    if ($act->modname === 'assign' || $act->modname === 'quiz' || $act->modname === 'forum') {
        $hasdates = true;
        $allowdisabled = ($act->modname === 'forum');
        $cutoffdisabled = ($act->modname === 'quiz');
    }

    $activitiesbysection[$sec]['activities'][] = [
        'cmid' => $act->cmid,
        'instance' => $act->instance,
        'modname' => $act->modname,
        'iconhtml' => $iconhtml,
        'displayname' => $displayname,
        'name' => s($act->name),
        'hasdates' => $hasdates,
        'allowdisabled' => $allowdisabled,
        'cutoffdisabled' => $cutoffdisabled,
        'allowfrom' => $allowfrom,
        'due' => $due,
        'cutoff' => $cutoff,
    ];
}

$templatedata = [
    'iconurl' => $iconurl->out(false),
    'helpicon' => $helpicon,
    'totalactivities' => count($activities),
    'courseid' => $courseid,
    'sections' => array_values($activitiesbysection),
];

echo $OUTPUT->render_from_template('local_timeshift/main_view', $templatedata);

echo $OUTPUT->footer();
