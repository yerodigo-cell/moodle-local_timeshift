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
 * TimeShift Pro (local_timeshift)
 *
 * @package     local_timeshift
 * @copyright   2026 EduPlugins Studio
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_timeshift;

/**
 * Manager class
 */
class manager {
    /**
     * Retrieves all supported activities of a course with their current dates.
     *
     * @param int $courseid The course ID
     * @return array Array of activity objects
     */
    public static function get_course_activities($courseid) {
        global $DB;

        $course = $DB->get_record('course', ['id' => $courseid], '*', MUST_EXIST);
        $modinfo = get_fast_modinfo($course);
        $activities = [];

        foreach ($modinfo->cms as $cm) {
            if ($cm->deletioninprogress) {
                continue;
            }

            $modname = $cm->modname;

            // Subsections and question banks are structural/backend modules without typical dates, so we exclude them.
            if ($modname === 'subsection' || $modname === 'qbank') {
                continue;
            }

            $instanceid = $cm->instance;

            $duedate = 0;
            $allowfromdate = 0;
            $cutoffdate = 0;

            if ($modname === 'assign') {
                $assign = $DB->get_record('assign', ['id' => $instanceid], 'duedate, allowsubmissionsfromdate, cutoffdate');
                if ($assign) {
                    $duedate = $assign->duedate;
                    $allowfromdate = $assign->allowsubmissionsfromdate;
                    if (isset($assign->cutoffdate)) {
                        $cutoffdate = $assign->cutoffdate;
                    }
                }
            } else if ($modname === 'quiz') {
                $quiz = $DB->get_record('quiz', ['id' => $instanceid], 'timeclose, timeopen');
                if ($quiz) {
                    $duedate = $quiz->timeclose;
                    $allowfromdate = $quiz->timeopen;
                }
            } else if ($modname === 'forum') {
                $forum = $DB->get_record('forum', ['id' => $instanceid]);
                if ($forum && isset($forum->duedate)) {
                    $duedate = $forum->duedate;
                }
                if ($forum && isset($forum->cutoffdate)) {
                    $cutoffdate = $forum->cutoffdate;
                }
            }

            $status = 0; // Hidden.
            if ($cm->visible) {
                $status = isset($cm->visibleoncoursepage) && !$cm->visibleoncoursepage ? 2 : 1;
            }
            
            $sectionname = get_section_name($course, $cm->sectionnum);

            $activities[$cm->id] = (object)[
                'cmid' => $cm->id,
                'modname' => $modname,
                'modfullname' => $cm->get_module_type_name(),
                'instance' => $instanceid,
                'name' => $cm->name,
                'status' => $status,
                'iconurl' => $cm->get_icon_url()->out(),
                'duedate' => $duedate,
                'allowfromdate' => $allowfromdate,
                'cutoffdate' => $cutoffdate,
                'availability' => $cm->availability,
                'sectionname' => $sectionname,
                'sectionnum' => $cm->sectionnum,
            ];
        }

        return $activities;
    }

    /**
     * Safely updates the name and dates of an activity.
     *
     * @param int $cmid The course module ID
     * @param string $modname The module name
     * @param int $instanceid The module instance ID
     * @param string $newname The new name of the activity
     * @param int|null $duedate The new due date
     * @param int|null $allowfromdate The new allow from date
     * @param int|null $status The visibility status
     * @param int|null $cutoffdate The new cutoff date
     * @param string|null $availability The new availability JSON string
     * @return bool True if successful
     */
    public static function update_activity(
        $cmid,
        $modname,
        $instanceid,
        $newname,
        $duedate,
        $allowfromdate,
        $status = null,
        $cutoffdate = null,
        $availability = null
    ) {
        global $DB;

        // 0. Update availability
        if ($availability !== null) {
            $availval = ($availability === '') ? null : $availability;
            $DB->set_field('course_modules', 'availability', $availval, ['id' => $cmid]);
        }

        // 0. Update visibility
        if ($status !== null) {
            $visible = ($status == 1 || $status == 2) ? 1 : 0;
            $visibleoncoursepage = ($status == 2) ? 0 : 1;

            $DB->set_field('course_modules', 'visible', $visible, ['id' => $cmid]);
            $DB->set_field('course_modules', 'visibleold', $visible, ['id' => $cmid]);
            // Check if column exists (Moodle 3.3+).
            $columns = $DB->get_columns('course_modules');
            if (array_key_exists('visibleoncoursepage', $columns)) {
                $DB->set_field('course_modules', 'visibleoncoursepage', $visibleoncoursepage, ['id' => $cmid]);
            }
        }

        $oldname = null;

        // 1. Update the name in the module specific table
        if (!empty($newname)) {
            $table = $modname;
            if ($DB->get_manager()->table_exists($table)) {
                $record = $DB->get_record($table, ['id' => $instanceid], '*', IGNORE_MISSING);
                if ($record) {
                    $oldname = $record->name;
                    if ($oldname !== $newname) {
                        $record->name = $newname;
                        $DB->update_record($table, $record);
                    }
                }
            }
        }

        // 2. Update dates according to the module type
        if ($modname === 'assign') {
            $assign = $DB->get_record('assign', ['id' => $instanceid], '*', IGNORE_MISSING);
            if ($assign) {
                $needsupdate = false;
                if ($duedate !== null) {
                    $assign->duedate = $duedate;
                    $needsupdate = true;
                }
                if ($allowfromdate !== null) {
                    $assign->allowsubmissionsfromdate = $allowfromdate;
                    $needsupdate = true;
                }
                if ($cutoffdate !== null && isset($assign->cutoffdate)) {
                    $assign->cutoffdate = $cutoffdate;
                    $needsupdate = true;
                }

                if ($needsupdate) {
                    $DB->update_record('assign', $assign);
                }
            }
        } else if ($modname === 'quiz') {
            $quiz = $DB->get_record('quiz', ['id' => $instanceid], '*', IGNORE_MISSING);
            if ($quiz) {
                $needsupdate = false;
                if ($duedate !== null) {
                    $quiz->timeclose = $duedate;
                    $needsupdate = true;
                }
                if ($allowfromdate !== null) {
                    $quiz->timeopen = $allowfromdate;
                    $needsupdate = true;
                }

                if ($needsupdate) {
                    $DB->update_record('quiz', $quiz);
                }
            }
        } else if ($modname === 'forum') {
            $forum = $DB->get_record('forum', ['id' => $instanceid], '*', IGNORE_MISSING);
            if ($forum) {
                $needsupdate = false;
                if (isset($forum->duedate) && $duedate !== null) {
                    $forum->duedate = $duedate;
                    $needsupdate = true;
                }
                if (isset($forum->cutoffdate) && $cutoffdate !== null) {
                    $forum->cutoffdate = $cutoffdate;
                    $needsupdate = true;
                }

                if ($needsupdate) {
                    $DB->update_record('forum', $forum);
                }
            }
        }

        // Universal Calendar Sync
        // Automatically create missing events, update existing ones, and safely rename them.
        $cm = $DB->get_record('course_modules', ['id' => $cmid], 'course', IGNORE_MISSING);
        if (!$cm) {
            return false;
        }
        $courseid = $cm->course;

        if ($modname === 'assign') {
            if ($duedate !== null) {
                self::sync_calendar_event($modname, $instanceid, $courseid, 'due', $duedate, $oldname, $newname);
            }
            if ($allowfromdate !== null) {
                self::sync_calendar_event(
                    $modname,
                    $instanceid,
                    $courseid,
                    'allowsubmissionsfrom',
                    $allowfromdate,
                    $oldname,
                    $newname
                );
            }
            if ($cutoffdate !== null) {
                self::sync_calendar_event($modname, $instanceid, $courseid, 'cutoff', $cutoffdate, $oldname, $newname);
            }
        } else if ($modname === 'quiz') {
            if ($duedate !== null) {
                self::sync_calendar_event($modname, $instanceid, $courseid, 'close', $duedate, $oldname, $newname);
            }
            if ($allowfromdate !== null) {
                self::sync_calendar_event($modname, $instanceid, $courseid, 'open', $allowfromdate, $oldname, $newname);
            }
        } else if ($modname === 'forum') {
            if ($duedate !== null) {
                self::sync_calendar_event($modname, $instanceid, $courseid, 'due', $duedate, $oldname, $newname);
            }
            if ($cutoffdate !== null) {
                self::sync_calendar_event($modname, $instanceid, $courseid, 'cutoff', $cutoffdate, $oldname, $newname);
            }
        }

        return true;
    }

    /**
     * Safely updates, creates or deletes a calendar event for a given activity instance.
     *
     * @param string $modname The module name
     * @param int $instanceid The module instance ID
     * @param int $courseid The course ID
     * @param string $eventtype The calendar event type (e.g. 'due', 'open')
     * @param int $timestamp The event timestamp (0 to delete)
     * @param string $oldname The original activity name
     * @param string $newname The new activity name
     * @return void
     */
    private static function sync_calendar_event($modname, $instanceid, $courseid, $eventtype, $timestamp, $oldname, $newname) {
        global $DB;

        $events = $DB->get_records('event', [
            'modulename' => $modname,
            'instance' => $instanceid,
            'eventtype' => $eventtype,
        ]);

        if ($timestamp > 0) {
            if ($events) {
                foreach ($events as $event) {
                    $updated = false;
                    if ($event->timestart != $timestamp) {
                        $event->timestart = $timestamp;
                        $updated = true;
                    }
                    if (!empty($newname) && !empty($oldname) && $newname !== $oldname) {
                        if (strpos($event->name, $oldname) !== false) {
                            $event->name = str_replace($oldname, $newname, $event->name);
                        } else {
                            // Fallback if strpos fails (e.g. Moodle didn't store the exact old name).
                            $namesuffix = '';
                            if ($eventtype === 'due' || $eventtype === 'close') {
                                $namesuffix = ' is due';
                            } else if ($eventtype === 'open' || $eventtype === 'allowsubmissionsfrom') {
                                $namesuffix = ' opens';
                            } else if ($eventtype === 'cutoff') {
                                $namesuffix = ' cutoff';
                            }
                            $event->name = $newname . $namesuffix;
                        }
                        $updated = true;
                    }

                    if ($updated) {
                        $event->timemodified = time();
                        $DB->update_record('event', $event);
                    }
                }
            } else {
                // Event does not exist, so create it manually.
                $name = !empty($newname) ? $newname : (!empty($oldname) ? $oldname : ucfirst($modname));

                if ($eventtype === 'due' || $eventtype === 'close') {
                    $name .= ' is due';
                } else if ($eventtype === 'open' || $eventtype === 'allowsubmissionsfrom') {
                    $name .= ' opens';
                } else if ($eventtype === 'cutoff') {
                    $name .= ' cutoff';
                }

                $newevent = new \stdClass();
                $newevent->name = $name;
                $newevent->description = '';
                $newevent->format = 1;
                $newevent->courseid = $courseid;
                $newevent->groupid = 0;
                $newevent->userid = 0;
                $newevent->repeatid = 0;
                $newevent->modulename = $modname;
                $newevent->instance = $instanceid;
                $newevent->eventtype = $eventtype;
                $newevent->timestart = $timestamp;
                $newevent->timeduration = 0;
                $newevent->visible = 1;
                $newevent->sequence = 1;
                $newevent->timemodified = time();

                $columns = $DB->get_columns('event');
                if (array_key_exists('priority', $columns)) {
                    $newevent->priority = null;
                }
                if (array_key_exists('type', $columns)) {
                    // CALENDAR_EVENT_TYPE_ACTION is 1.
                    $newevent->type = 1;
                }

                if (class_exists('\core\uuid')) {
                    $newevent->uuid = \core\uuid::generate();
                } else {
                    $newevent->uuid = md5(uniqid('', true));
                }

                $DB->insert_record('event', $newevent);
            }
        } else {
            // Timestamp is 0, delete events.
            if ($events) {
                foreach ($events as $event) {
                    $DB->delete_records('event', ['id' => $event->id]);
                }
            }
        }
    }
}
