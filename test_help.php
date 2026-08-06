<?php
/**
 * Test help page for local_timeshift.
 *
 * @package    local_timeshift
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

require_login();
require_capability('moodle/site:config', context_system::instance());

echo $OUTPUT->help_icon('dragdrop', 'local_timeshift');
