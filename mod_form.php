<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * The main mod_tutoom configuration form.
 *
 * @package     mod_tutoom
 * @copyright 2022 onwards, Tutoom Inc.
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/moodleform_mod.php');

/**
 * Module instance settings form.
 *
 * @package   mod_tutoom
 * @copyright 2022 onwards, Tutoom Inc
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_tutoom_mod_form extends moodleform_mod {
    /**
     * Defines forms elements
     */
    public function definition() {
        global $CFG, $DB;

        $config = get_config("mod_tutoom");
        $recordingenabled = (int) $config->recording_enabled;

        $course = null;
        $courseid = optional_param('course', 0, PARAM_INT);

        if ($courseid) {
            $course = get_course($courseid);
        }
        if (!$course) {
            $cm = get_coursemodule_from_id(
                'tutoom',
                optional_param('update', 0, PARAM_INT),
                0,
                false,
                MUST_EXIST
            );
            $course = $DB->get_record(
                'course',
                array('id' => $cm->course),
                '*',
                MUST_EXIST
            );
        }

        $mform = $this->_form;

        $this->tutoom_mform_add_block_profiles($mform);

        // Adding the "general" fieldset, where all the common settings are shown.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adding the standard "name" field.
        $mform->addElement('text', 'name', get_string('tutoomname', 'mod_tutoom'), array('size' => '64'));

        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }

        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

        // Adding the standard "intro" and "introformat" fields.
        if ($CFG->branch >= 29) {
            $this->standard_intro_elements();
        } else {
            moodleform_mod::standard_intro_elements();
        }

        // Adding the rest of mod_tutoom settings, spreading all them into this fieldset
        // ... or adding more fieldsets ('header' elements) if needed for better logic.
        $mform->addElement('header', 'room', get_string('mod_form_block_room', 'mod_tutoom'));
        $mform->addElement(
            'textarea',
            'welcomemessage',
            get_string('mod_form_field_welcome', 'mod_tutoom'),
            'wrap="virtual" rows="5" cols="60"'
        );
        $mform->setDefault('welcomemessage', get_string('mod_form_field_welcome_default_message', 'mod_tutoom'));

        $mform->addElement('checkbox', 'record', get_string('mod_form_field_record', 'mod_tutoom'));
        $mform->setDefault("record", $recordingenabled);

        // Add standard elements.
        $this->standard_coursemodule_elements();

        // Add standard buttons.
        $this->add_action_buttons();
    }

    /**
     * Function for showing the block for selecting profiles.
     *
     * @param MoodleQuickForm $mform
     * @return void
     */
    private function tutoom_mform_add_block_profiles(MoodleQuickForm &$mform): void {
        $mform->addElement('select', 'type', get_string('mod_form_field_room_type', 'mod_tutoom'),
            tutoom_get_name_of_room_type());
        $mform->addHelpButton('type', 'mod_form_field_room_type', 'mod_tutoom');
    }
}
