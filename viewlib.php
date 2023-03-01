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

    if (!isset($accountid) || $accountid == '') {
        echo $OUTPUT->render_from_template("mod_tutoom/view_page", array('errorcode' => 500));
        return;
    }

    $meetingid = $moduleinstance->meetingid;

    $recordings = array();
    $data = array(
        'name' => $moduleinstance->name,
        "meetingid" => $meetingid,
        "ismoderator" => $ismoderator,
        "recordings" => $recordings,
        "id" => $id,
        "baseurl" => $CFG->wwwroot.'/mod/tutoom/tutoom_ajax.php'
    );

    if (isset($meetingid)) {
        $meeetinginfo = meeting::get_meeting_info($meetingid, $moduleinstance->id);

        if(isset($meeetinginfo->error)){
            $errorcode = $meeetinginfo->error->errorCode;
            echo $OUTPUT->render_from_template("mod_tutoom/view_page", array('errorcode' => $errorcode));
            return;
        }

        $participantcount = $meeetinginfo->participantsCount;
        $seconds = $meeetinginfo->creationTimestamp->{"_seconds"};

        $data["meetingdate"] = date("g:i A", $seconds * 1000);
        $data["participantscount"] = $participantcount;
        $data["istextpluralparticipant"] = $participantcount > 1;
    }

    echo $OUTPUT->render_from_template("mod_tutoom/view_page", $data);
}
