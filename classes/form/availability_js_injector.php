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

namespace local_timeshift\form;

/**
 * Custom QuickForm element to inject availability JS at render time.
 *
 * @package    local_timeshift
 * @copyright  2026 EduPlugins Studio
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
global $CFG;
require_once($CFG->libdir . '/formslib.php');
require_once('HTML/QuickForm/static.php');

class availability_js_injector extends \HTML_QuickForm_static {
    /** @var \stdClass Course object. */
    public $course;

    /** @var \cm_info Course module object. */
    public $cm;

    /**
     * Render the element.
     *
     * @return string
     */
    public function toHtml() { // phpcs:ignore moodle.NamingConventions.ValidFunctionName.LowercaseMethod
        if ($this->course && $this->cm) {
            \core_availability\frontend::include_all_javascript($this->course, $this->cm);
        }
        return '';
    }
}
