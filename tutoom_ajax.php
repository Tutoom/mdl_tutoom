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
 * File to connect to Tutoom Backend.
 *
 * @package   mod_tutoom
 * @copyright 2022 onwards, Tutoom Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use mod_tutoom\meeting;
use mod_tutoom\recording;
use mod_tutoom\local\config;

require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/classes/meeting.php');
require_once(__DIR__ . '/classes/recording.php');

global $PAGE, $USER, $SESSION, $DB;

$params['action'] = optional_param('action', '', PARAM_TEXT);
$params['callback'] = optional_param('callback', '', PARAM_TEXT);
$params['id'] = optional_param('id', '', PARAM_TEXT);
$params['idx'] = optional_param('idx', '', PARAM_TEXT);
$params['meetingId'] = optional_param('meetingId', '', PARAM_TEXT);
$params['logoutUrl'] = optional_param('logoutUrl', '', PARAM_TEXT);
$params['signed_parameters'] = optional_param('signed_parameters', '', PARAM_TEXT);
$params['updatecache'] = optional_param('updatecache', 'false', PARAM_TEXT);
$params['meta'] = optional_param('meta', '', PARAM_TEXT);
$params['mobil'] = optional_param('mobil', 0, PARAM_INT);
$params['fullname'] = optional_param('fullname', '', PARAM_TEXT);
$params['page'] = optional_param('page', 0, PARAM_INT);

if (!$params['mobil']) {
    require_login(null, true);
    require_sesskey();
}

if (empty($params['action'])) {
    header('HTTP/1.0 400 Bad Request. Parameter [' . $params['action'] . '] was not included');
    return;
}

try {
    header('Content-Type: application/json; charset=utf-8');

    $action = strtolower($params['action']);

    $id = (int) $params['id'];

    $cm = get_coursemodule_from_id('tutoom', $id, 0, false, MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

    $moduleinstance = $DB->get_record('tutoom', array('id' => $cm->instance), '*', MUST_EXIST);

    $modulecontext = context_module::instance($cm->id);

    $cfg = config::get_options();
    $moderator = $cfg["moderator_role"];
    $viewer = $cfg["viewer_role"];
    $role = has_capability('mod/tutoom:joinasmoderator', $modulecontext) ? $moderator : $viewer;

    $fullname = $params['mobil'] ? $params['fullname'] : "$USER->firstname $USER->lastname";

    $meetingid = $moduleinstance->meetingid;
    $classid = $moduleinstance->classid;

    if ($action == 'get_meeting') {
        if (isset($meetingid)) {
            $meeetinginfo = meeting::get_meeting_info($meetingid, $moduleinstance->id);
            echo json_encode($meeetinginfo);
        }

        return;
    }

    if ($action == 'start_meeting') {
        $coursename = $course->fullname;
        $welcomemessage = $moduleinstance->welcomemessage;
        $logouturl = $params['logoutUrl'];

        $response = meeting::create_meeting($classid, $logouturl, $coursename, $welcomemessage, $moduleinstance->id);
        echo json_encode($response);

        return;
    }

    if ($action == 'join_meeting') {
        $appurl = $moduleinstance->urlapp;
        $joinurl = meeting::join_meeting($meetingid, $fullname, $role, $appurl);
        echo json_encode($joinurl);

        return;
    }

    if ($action == 'end_meeting') {
        $incomingmeetingid = $params['meetingId'];
        $coursename = $course->fullname;
        $logouturl = $params['logoutUrl'];

        if (isset($meetingid) && $meetingid == $incomingmeetingid) {
            $response = meeting::end_meeting($incomingmeetingid, $moduleinstance->id);
            echo json_encode($response);

            return;
        }
    }

    if ($action == 'get_recordings') {
        $courseid = $course->id;
        $page = $params['page'] ?? 1;

        $recordings = recording::get_recordings($classid, $page);
        echo json_encode($recordings);

        return;
    }

    header('HTTP/1.0 400 Bad request. The action ' . $action . ' doesn\'t exist');
} catch (Exception $e) {
    echo ($e);
    header('HTTP/1.0 500 Internal Server Error. ' . $e->getMessage());
}
