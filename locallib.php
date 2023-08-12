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
 * Prints an instance of mod_tutoom.
 *
 * @package   mod_tutoom
 * @copyright 2022 onwards, Tutoom Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

global $CFG;

require_once(__DIR__ . '/lib.php');

/** @var TUTOOM_TYPE_ALL integer set to 0 defines an instance type that inclueds room and recordings */
const TUTOOM_TYPE_ALL = 0;
/** @var TUTOOM_TYPE_ROOM_ONLY integer set to 1 defines an instance type that inclueds only room */
const TUTOOM_TYPE_ROOM_ONLY = 1;
/** @var TUTOOM_TYPE_RECORDING_ONLY integer set to 2 defines an instance type that inclueds only recordings */
const TUTOOM_TYPE_RECORDING_ONLY = 2;

/**
 * Helper generates a random password.
 *
 * @param integer $length
 * @param string $unique
 *
 * @return string
 */
function tutoom_random_string($length = 8, $unique = "") {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    do {
        $password = substr(str_shuffle($chars), 0, $length);
    } while ($unique == $password);

    return $password;
}

/**
 * Helper function returns a sha1 encoded string that is unique and will be used as a seed for classid.
 *
 * @return string
 */
function tutoom_unique_classid_seed() {
    global $DB;
    do {
        $encodedseed = sha1(tutoom_random_string(12));
        $classid = (string)$DB->get_field('tutoom', 'classid', array('classid' => $encodedseed));
    } while ($classid == $encodedseed);
    return $encodedseed;
}

/**
 * Helper function renders general settings if the feature is enabled.
 *
 * @param object $renderer
 *
 * @return void
 */
function tutoom_settings_general(&$renderer) {
    $renderer->render_group_header('general');
    $renderer->render_group_element_text('account_id', '');
    $renderer->render_group_element_text('account_secret', '');
    $renderer->render_group_element_checkbox('activity_logs', 0);

    $renderer->render_group_header('recording');
    $renderer->render_group_element_checkbox('recording_enabled', 1);
    $renderer->render_group_element_checkbox('recording_auto_start', 0);
}

/**
 * Function to generate checksum.
 *
 * @param string $method
 * @param string $pathname
 * @param object $bodyorparams
 * @param string $secret
 * @return object
 */
function tuttom_generate_checksum($method, $pathname, $bodyorparams, $secret) {
    $checksum = strtolower($method) . $pathname;
    $firstkey = true;

    foreach ($bodyorparams as $key => $param) {
        if ($key == 'checksum') {
            continue;
        }

        $checksum .= ($firstkey ? '' : '&') . $key . '=' . $param;

        if ($firstkey) {
            $firstkey = false;
        }
    }

    $checksum .= $secret;

    $checksum = sha1($checksum);

    $bodyorparams->checksum = $checksum;

    return $bodyorparams;
}

/**
 * Returns a params string for use like query it when fetching to API.
 *
 * @param object $bodyorparams
 * @return string
 */
function tuttom_generate_params_to_url($bodyorparams) {
    $params = '';
    $firstkey = true;
    foreach ($bodyorparams as $key => $param) {
        $params .= ($firstkey ? '' : '&') . $key . '=' . $param;

        if ($firstkey) {
            $firstkey = false;
        }
    }

    return $params;
}

/**
 * Helper function returns an array with the profiles (with features per profile) for the different types
 * of tutoom instances.
 *
 * @return array
 */
function tutoom_get_room_type_profiles() {
    $instanceprofiles = array(
        TUTOOM_TYPE_ALL => array(
            'id' => TUTOOM_TYPE_ALL,
            'name' => get_string('room_type_room_with_recordings', 'mod_tutoom'),
            'features' => array()),
        TUTOOM_TYPE_ROOM_ONLY => array(
            'id' => TUTOOM_TYPE_ROOM_ONLY,
            'name' => get_string('room_type_room_only', 'mod_tutoom'),
            'features' => array()),
        TUTOOM_TYPE_RECORDING_ONLY => array(
            'id' => TUTOOM_TYPE_RECORDING_ONLY,
            'name' => get_string('room_type_recording_only', 'mod_tutoom'),
            'features' => array()),
    );
    return $instanceprofiles;
}

/**
 * Helper function returns an array with the profiles (with features per profile) for the different types
 * of bigbluebuttonbn instances.
 *
 * @param array $profiles
 * @return array
 */
function tutoom_get_name_of_room_type() {
    $profiles = tutoom_get_room_type_profiles();

    $profilesarray = array();
    foreach ($profiles as $key => $profile) {
        $profilesarray[$profile['id']] = $profile['name'];
    }
    return $profilesarray;
}
