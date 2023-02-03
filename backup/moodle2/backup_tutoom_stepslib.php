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
 * Class for the structure used for backup Tutoom.
 *
 * @package   mod_tutoom
 * @copyright 2022 onwards, Tutoom Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Define all the backup steps that will be used by the backup_tutoom_activity_task.
 *
 * @package   mod_tutoom
 * @copyright 2022 onwards, Tutoom Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_tutoom_activity_structure_step extends backup_activity_structure_step {
    /**
     * Define the complete tutoom structure for backup, with file and id annotations.
     *
     * @return object
     */
    protected function define_structure() {

        // Define each element separated.
        $tutoom = new backup_nested_element('tutoom', array('id'), array(
            'course',
            'name',
            'timecreated',
            'timemodified',
            'intro',
            'introformat',
            'classid',
            'meetingid',
            'welcomemessage',
            'urlapp'
        ));

        // Define sources.
        $tutoom->set_source_table('tutoom', array('id' => backup::VAR_ACTIVITYID));

        // Define file annotations.
        $tutoom->annotate_files('mod_tutoom', 'intro', null);

        // Return the root element (tutoom), wrapped into standard activity structure.
        return $this->prepare_activity_structure($tutoom);
    }
}
