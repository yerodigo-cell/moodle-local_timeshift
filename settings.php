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

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_timeshift', get_string('pluginname', 'local_timeshift'));

    global $CFG;
    $logourl = $CFG->wwwroot . '/local/timeshift/pix/icon.png';

    $pluginname = get_string('pluginname', 'local_timeshift');
    $liteinstalled = get_string('lite_installed', 'local_timeshift');
    $buypro = get_string('buy_pro', 'local_timeshift');

    $html = '<div style="text-align:center; padding:20px; background-color: #f8f9fa; ' .
            'border: 1px solid #dee2e6; border-radius: 8px; margin-bottom: 20px;">
                <img src="' . $logourl . '" alt="' . $pluginname . ' Logo" ' .
                'style="max-width:150px; margin-bottom:15px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);"/>
                <h3 style="color: #495057;">' . $pluginname . '</h3>
                <p style="color: #495057; font-size: 16px;">' . $liteinstalled . '</p>
                <div style="margin-top: 20px;">
                    <a href="https://edupluginsstudio.com/timeshift-pro.html#pricing" target="_blank" ' .
                    'style="display: inline-block; padding: 10px 20px; background-color: #0d6efd; color: #fff; ' .
                    'text-decoration: none; border-radius: 5px; font-weight: bold; ' .
                    'box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2); transition: background-color 0.3s;">' . $buypro . '</a>
                </div>
             </div>';

    $settings->add(new admin_setting_heading('local_timeshift_lite_info', '', $html));

    $ADMIN->add('localplugins', $settings);
}
