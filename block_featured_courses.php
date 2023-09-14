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
 * Newblock block caps.
 *
 * @package    block_featured_courses
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use block_featured_courses\output\featured_courses;

/**
 * Class block_featured_courses
 *
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_featured_courses extends block_base {

    /**
     * Init function
     *
     * @throws coding_exception
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_featured_courses');
    }

    /**
     * Update the block title from config values
     */
    public function specialization() {
        if (!empty($this->config->title)) {
            $this->title = $this->config->title;
        }
    }

    /**
     * Content for the block
     *
     * @return stdClass|string|null
     * @throws coding_exception
     * @throws dml_exception
     */
    public function get_content() {
        global $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }
        $this->content = '';

        if ($this->config && !empty($this->config->selectedcourses)) {
            $this->content = new stdClass();
            $this->content->footer = '';

            $courseRenderer = new featured_courses($this->config->selectedcourses);
            switch ($this->config->courselayout){
                case 0;
                    $this->content->text = $OUTPUT->render($courseRenderer);
                    break;
                case 1:
                    $this->content->text =
                        $OUTPUT->render_from_template('core_course/view-cards', $courseRenderer->export_for_template($OUTPUT));
                    break;
                case 2:
                    $this->content->text =
                        $OUTPUT->render_from_template('tool_moodlenet/view-cards', $courseRenderer->export_for_template($OUTPUT));
                    break;
            }
        }
        return $this->content;
    }

    /**
     * All applicable formats
     *
     * @return array
     */
    public function applicable_formats(): array {
        return array('all' => true);
    }

    /**
     * Multiple blocks ?
     *
     * @return bool
     */
    public function instance_allow_multiple(): bool {
        return true;
    }

    /**
     * Has configuration ?
     *
     * @return bool
     */
    public function has_config(): bool {
        return false;
    }
}
