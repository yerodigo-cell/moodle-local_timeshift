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

defined('MOODLE_INTERNAL') || die();

// Only add settings in the course administration tree.
if ($hassiteconfig) {
    // Note: We don't necessarily need a global admin setting tree if we just want a course tool.
    // However, if we want an admin page, we can add it here.
    // Let's create an empty settings file since it was specified in the structure.
    // For a local plugin that works at course level, often the link is added via local_timeshift_extend_navigation_course
    // inside lib.php, but settings.php is loaded for site admin block. We can leave this empty or add a simple setting.
    $settings = new admin_settingpage('local_timeshift', get_string('pluginname', 'local_timeshift'));
    // We add a link to the tool instead of real settings, or we just leave the settings page empty.
    $ADMIN->add('localplugins', $settings);
}