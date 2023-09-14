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
 * Edit Form
 *
 * @package    block_featured_courses
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Class block_featured_courses_edit_form
 *
 * @package    block_featured_courses
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_featured_courses_edit_form extends block_edit_form {

    /**
     * Form definition
     *
     * @param object $mform
     * @throws coding_exception|moodle_exception
     */
    protected function specific_definition($mform): void {

        // Section header title according to language file.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Title of the block.
        $mform->addElement('text', 'config_title', get_string('config:title', 'block_featured_courses'));
        $mform->setDefault('config_title', get_string('pluginname', 'block_featured_courses'));
        $mform->setType('config_title', PARAM_TEXT);

        $courses = (core_course_category::get(0))->get_courses(['recursive' => true]);
        $courseitems = [];
        foreach ($courses as $c) {
            $courseitems[$c->id] = " {$c->get_formatted_name()} ($c->id)";
        }

        $repeatarray = [
            $mform->createElement(
                'searchableselector',
                'config_selectedcourses',
                get_string('config:selectedcourses', 'block_featured_courses'),
                $courseitems, false),
            $mform->createElement('submit', 'delete', get_string('delete'))
        ];
        $repeatedoptions['config_selectedcourses']['type'] = PARAM_RAW;
        $numbcourses = empty($this->block->config->selectedcourses) ? 1 : count($this->block->config->selectedcourses);
        $this->repeat_elements(
            $repeatarray,
            $numbcourses,
            $repeatedoptions,
            'selectcourses_repeats',
            'selectcourse_add_fields',
            3,
            get_string('addmorecourses', 'block_featured_courses'),
            false,
            'delete'
        );

        // Add unique id to searchable selectors.
        foreach ($mform->_elements as $idx => $elem) {
            if ($elem instanceof MoodleQuickForm_searchableselector) {
                $elem->_attributes['id'] = $elem->_attributes['id'] . $idx;
            }
        }
    }
}
