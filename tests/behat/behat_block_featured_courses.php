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
 * File containing a class allowing set editing mode on either on moodle 3 & moodle 4.
 *
 * @package     block_featured_courses
 * @copyright   2022 - CALL Learning
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author      Martin CORNU-MANSUY <martin@call-learning>
 */

/**
 * A patch to make "I turn editing mode on" compatible with moodle 3.
 *
 * @package     block_featured_courses
 * @copyright   2022 - CALL Learning
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author      Martin CORNU-MANSUY <martin@call-learning>
 */
class behat_block_featured_courses extends behat_base {

    /**
     * Turn on editing mode in moodle compatible with version 3 and 4.
     *
     * @Given I set editing mode on
     */
    public function i_set_editing_mode_on() {
        global $CFG;
        require_once($CFG->dirroot . "/lib/environmentlib.php");
        $release = intval(get_config('', 'release')[0]);
        echo $release;
        if (normalize_version($release) > 3) {
            $this->execute('behat_navigation::i_turn_editing_mode_on', []);
        } else {
            $this->execute('behat_general::i_click_on', ["Customise this page", "button"]);
        }
    }
}
