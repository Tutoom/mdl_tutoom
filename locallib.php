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

