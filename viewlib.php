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

use mod_tutoom\meeting;
use mod_tutoom\recording;
use mod_tutoom\local\config;

defined('MOODLE_INTERNAL') || die;
require_once(__DIR__ . '/classes/meeting.php');

/**
 * Displays the general view.
 *
 * @param string $id
 * @param object $moduleinstance
 * @param bool $is_moderator
 * @return void
 */
function tutoom_view_render($id, $moduleinstance, $ismoderator) {
    global $OUTPUT, $CFG;

    $config = get_config("mod_tutoom");
    $accountid = $config->account_id;

    $defaulterror = array(
        'error' => true,
        'name' => $moduleinstance->name,
    );

    if (!isset($accountid) || $accountid == '') {
        $error = array_merge($defaulterror, array('errorcode' => 500));
        echo $OUTPUT->render_from_template("mod_tutoom/view_page", $error);
        return;
    }

    $tutoomid = $moduleinstance->id;
    $meetingid = $moduleinstance->meetingid;
    $courseid = $moduleinstance->course;
    $typeroom = $moduleinstance->type;
    $isroomwithrecordings = $typeroom === strval(TUTOOM_TYPE_ALL);
    $isroomonly = $typeroom === strval(TUTOOM_TYPE_ROOM_ONLY);
    $isrecordingonly = $typeroom === strval(TUTOOM_TYPE_RECORDING_ONLY);

    $showrecordings = $isroomwithrecordings || $isrecordingonly;
    $showroominformation = $isroomwithrecordings || $isroomonly;

    $data = array(
        'name' => $moduleinstance->name,
        "ismoderator" => $ismoderator,
        "id" => $id,
        "baseurl" => $CFG->wwwroot.'/mod/tutoom/tutoom_ajax.php',
        "showrecordings" => $showrecordings,
        "showroominformation" => $showroominformation,
    );

    // If recordings is enabled, getting the count of recordings.
    if($showrecordings) {
        $getcountrecordingsinfo = recording::get_count_recordings($courseid);

        if(isset($getcountrecordingsinfo->error)){
            $errorcode = $getcountrecordingsinfo->error->errorCode;
            $error = array_merge($defaulterror, array('errorcode' => $errorcode));
            echo $OUTPUT->render_from_template("mod_tutoom/view_page", $error);
            return;
        }

        $countrecordings = (int) $getcountrecordingsinfo->count;
        $limitrecordings = (int) $getcountrecordingsinfo->limit;

        $data = array_merge($data, array(
            "countrecordings" => $countrecordings,
            "limitrecordings" => $limitrecordings
        ));

        // Recording is empty.
        if($countrecordings === 0){
            $data = array_merge($data, array(
                "isemptyrecordings" => true,
            ));
        }

    }

    if (isset($meetingid) && $meetingid !== null) {
        $meeetinginfo = meeting::get_meeting_info($meetingid, $tutoomid);

        if (isset($meeetinginfo->isFinished) && $meeetinginfo->isFinished) {
            $data["meetingid"] = null;
            echo $OUTPUT->render_from_template("mod_tutoom/view_page", $data);
            return;
        }

        if(isset($meeetinginfo->error)){
            $errorcode = $meeetinginfo->error->errorCode;
            $error = array_merge($defaulterror, array('errorcode' => $errorcode));
            echo $OUTPUT->render_from_template("mod_tutoom/view_page", $error);
            return;
        }

        $participantcount = $meeetinginfo->participantsCount;
        $meetingdate = $meeetinginfo->meetingDate;

        $data["meetingid"] = $meetingid;
        $data["meetingdate"] = $meetingdate;
        $data["participantscount"] = $participantcount;
        $data["istextpluralparticipant"] = $participantcount > 1;
    }
    else {
        $data["meetingid"] = null;
    }

    echo $OUTPUT->render_from_template("mod_tutoom/view_page", $data);
}
