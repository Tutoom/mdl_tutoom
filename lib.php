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
 * Library of interface functions and constants.
 *
 * @package   mod_tutoom
 * @copyright 2022 onwards, Tutoom Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/locallib.php');

global $CFG;

if (!defined('PHPUNIT_TEST') || !PHPUNIT_TEST) {
    if (!isset($CFG->tutoom)) {
        $CFG->tutoom = array();
    }

    if (file_exists(dirname(__FILE__) . '/config.php')) {
        require_once(dirname(__FILE__) . '/config.php');
    }
}

/** @var TUTOOM_LOG_EVENT_CREATE_MEETING string defines the tutoom create event */
const TUTOOM_LOG_EVENT_CREATE_MEETING = 'CREATE_MEETING';
/** @var TUTOOM_LOG_EVENT_JOIN_MEETING string defines the tutoom join event */
const TUTOOM_LOG_EVENT_JOIN_MEETING = 'JOIN_MEETING';
/** @var TUTOOM_LOG_EVENT_END_MEETING string defines the tutoom end event */
const TUTOOM_LOG_EVENT_END_MEETING = 'END_MEETING';

/**
 * Return if the plugin supports $feature.
 *
 * @param string $feature Constant representing the feature.
 * @return true | null True if the feature is supported, null otherwise.
 */
function tutoom_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:
            return true;
        default:
            return null;
    }
}

/**
 * Saves a new instance of the mod_tutoom into the database.
 *
 * Given an object containing all the necessary data, (defined by the form
 * in mod_form.php) this function will create a new instance and return the id
 * number of the instance.
 *
 * @param object $moduleinstance An object from the form.
 * @param mod_tutoom_mod_form $mform The form.
 * @return int The id of the newly inserted record.
 */
function tutoom_add_instance($tutoom, $mform = null) {
    global $DB;

    $tutoom->timecreated = time();
    $tutoom->id = $DB->insert_record('tutoom', $tutoom);
    $tutoom->classid = tutoom_unique_classid_seed();

    $DB->set_field('tutoom', 'classid', $tutoom->classid, array('id' => $tutoom->id));

    return $tutoom->id;
}

/**
 * Updates an instance of the mod_tutoom in the database.
 *
 * Given an object containing all the necessary data (defined in mod_form.php),
 * this function will update an existing instance with new data.
 *
 * @param object $moduleinstance An object from the form in mod_form.php.
 * @param mod_tutoom_mod_form $mform The form.
 * @return bool True if successful, false otherwise.
 */
function tutoom_update_instance($tutoom, $mform = null) {
    global $DB;

    $tutoom->timemodified = time();
    $tutoom->id = $tutoom->instance;

    return $DB->update_record('tutoom', $tutoom);
}

/**
 * Removes an instance of the mod_tutoom from the database.
 *
 * @param int $id Id of the module instance.
 * @return bool True if successful, false on failure.
 */
function tutoom_delete_instance($id) {
    global $DB;

    $exists = $DB->get_record('tutoom', array('id' => $id));
    if (!$exists) {
        return false;
    }

    $DB->delete_records('tutoom', array('id' => $id));

    return true;
}

/**
 * Register a tutoom event
 *
 * @param object $tutoom
 * @param string $event
 * @param string $meta
 *
 * @return bool Success/Failure
 */
function tutoom_log($tutoom, $event, $meta = null) {
    global $DB, $USER;

    $log = new stdClass();

    // Default values.
    $log->courseid = $tutoom->course;
    $log->tutoomid = $tutoom->id;
    $log->userid = $USER->id;
    $log->timecreated = time();
    $log->meetingid = $tutoom->meetingid;
    $log->log = $event;
    $log->meta = $meta;

    $log->id = $DB->insert_record('tutoom_logs', $log);

    return $log->id;
}