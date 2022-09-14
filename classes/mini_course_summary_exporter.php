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
 * Course summary exporter with a specific purpose.
 *
 * @package    block_featured_courses
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_featured_courses;

use core_course\external\course_summary_exporter;
use core_course_category;
use moodle_exception;
use moodle_url;
use renderer_base;

/**
 * Class mini_course_summary_exporter
 *
 * @package block_featured_courses
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */
class mini_course_summary_exporter extends course_summary_exporter {

    /**
     * Only a subset of the usual.
     *
     * @return array|array[]
     */
    public static function define_other_properties(): array {
        return array(
            'fullnamedisplay' => array(
                'type' => PARAM_TEXT,
            ),
            'viewurl' => array(
                'type' => PARAM_URL,
            ),
            'courseimage' => array(
                'type' => PARAM_RAW,
            ),
            'showshortname' => array(
                'type' => PARAM_BOOL
            ),
            'coursecategory' => array(
                'type' => PARAM_TEXT
            )
        );
    }

    /**
     * Define related variables
     *
     * @return string[]
     */
    protected static function define_related(): array {
        // We cache the context so it does not need to be retrieved from the course.
        return array('context' => '\\context');
    }

    /**
     * Get other useful values
     *
     * @param renderer_base $output
     * @return array
     * @throws moodle_exception
     */
    protected function get_other_values(renderer_base $output): array {
        global $CFG;
        $courseimage = self::get_course_image($this->data);
        if (!$courseimage) {
            $courseimage = $output->get_generated_image_for_id($this->data->id);
        }
        $coursecategory = core_course_category::get($this->data->category, MUST_EXIST, true);
        $urlparam = array('id' => $this->data->id);
        $courseurl = new moodle_url('/course/view.php', $urlparam);
        if (!empty($CFG->enablesyllabus) && class_exists('\\local_syllabus\\locallib\utils')) {
            $courseurl = \local_syllabus\locallib\utils::get_syllabus_page_url($urlparam);
        }
        return array(
            'fullnamedisplay' => get_course_display_name_for_list($this->data),
            'viewurl' => $courseurl->out(false),
            'courseimage' => $courseimage,
            'showshortname' => (bool) ($CFG->courselistshortnames ?? false),
            'coursecategory' => $coursecategory->name
        );
    }

}
