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
 * Plugin strings are defined here.
 *
 * @package   mod_tutoom
 * @category  string
 * @copyright 2022 onwards, Tutoom Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['modulename'] = 'Tutoom';
$string['pluginname'] = 'Tutoom';
$string['pluginadministration'] = '';
$string['modulenameplural'] = 'Tutoom';
$string['modulename_help'] = 'Tutoom lets you create from within Moodle links to real-time on-line meetings using Tutoom, a web conferencing system for distance education.';

$string['message_account_id_not_set'] = 'You need to set your organization Tutoom account id in the general plugin settings section.';
$string['missingidandcmid'] = 'Tutoom ID is incorrect. Please, go to your course and select your activity to correctly enter Tutoom.';

$string['index_error_noinstances'] = 'There are no instances of Tutoom';

// Capabilities.
$string['tutoom:joinasmoderator'] = 'Join as moderator a Tutoom meeting';
$string['tutoom:addinstance'] = 'Add a new Tutoom room/activity';

// Initial config.
$string['config_account_id'] = 'Tutoom account ID';
$string['config_account_id_description'] = 'The ID of your organization Tutoom account.';
$string['config_account_secret'] = 'Tutoom secret key';
$string['config_account_secret_description'] = 'The secret key of your organization Tutoom account';
$string['config_general'] = 'General configuration';
$string['config_general_description'] = 'These settings are <b>always</b> used';
$string['config_activity_logs'] = 'Write activity logs';
$string['config_activity_logs_description'] = 'This option save logs when a room is created, deleted and user join to the room.';
$string['config_recording'] = 'Recording';
$string['config_recording_description'] = 'These settings are feature specific';
$string['config_recording_enabled'] = 'Recording enabled by default';
$string['config_recording_enabled_description'] = "Session can be recorded by default. Can be editable in the Tuttom activity settings";
$string['config_recording_auto_start'] = 'Recording auto start';
$string['config_recording_auto_start_description'] = "If the option is checked, rooms will start recording when moderator get in.";

// Initial form.
$string['tutoomname'] = 'Name';
$string['mod_form_block_room'] = 'Activity/Room settings';
$string['mod_form_field_welcome'] = 'Welcome message';
$string['mod_form_field_welcome_default_message'] = 'Welcome to the class. Feel free to ask any question.';
$string['mod_form_field_record'] = 'Session can be recorded';
$string['mod_form_field_room_type'] = 'Room type';
$string['mod_form_field_room_type_help'] = 'Select the room type for this Tutoom.';

$string['room_type_room_with_recordings'] = 'Room with recordings';
$string['room_type_room_only'] = 'Room only';
$string['room_type_recording_only'] = 'Recording only';

// Room info.
$string['view_conference_action_start'] = 'Start session';
$string['view_conference_action_join'] = 'Join session';
$string['view_conference_action_end'] = 'End session';
$string['view_message_room_not_initalized'] = 'The room has not started.';
$string['view_message_room_ended'] = 'This room has ended. Click <u id="tutoom-refresh-main-section" style="cursor: pointer;">here</u> to reload the page.';
$string['view_message_conference_in_this_room'] = 'in this room';
$string['view_message_session_status_on'] = 'ONLINE';
$string['view_message_session_status_off'] = 'OFFLINE';
$string['view_message_session_started_at'] = 'Started at';
$string['view_message_session_has_user'] = 'There is';
$string['view_message_session_has_users'] = 'There are';
$string['view_message_user'] = 'user';
$string['view_message_users'] = 'users';
$string['view_section_title_recordings'] = 'Recordings';
$string['view_message_norecordings'] = 'There are no recording to show.';
$string['recording_title'] = 'Recordings';
$string['recording_playback'] = 'Playback';
$string['recording_name'] = 'Name';
$string['recording_description'] = 'Description';
$string['recording_preview'] = 'Preview';
$string['recording_date'] = 'Date';
$string['recording_time'] = 'Time';
$string['recording_duration'] = 'Duration';
$string['recording_toolbar'] = 'Toolbar';
$string['recording_text_empty'] = 'No recordings so far...';
$string['recording_loading'] = 'Getting recordings...';
$string['message_loading'] = 'Please wait...';
$string['pagination_previous'] = 'Previous';
$string['pagination_next'] = 'Next';

// Errors.
$string['view_page_error_general'] = 'There are no rooms available. Please contact your administrator for more information.';

$string['privacy:metadata:tutoom'] = 'In order to create and join Tutoom sessions, user data needs to be exchanged with the server.';
$string['privacy:metadata:tutoom:email'] = 'The email of the user accessing to Moodle.';
$string['privacy:metadata:tutoom:fullname'] = 'The fullname of the user accessing to Moodle.';
$string['privacy:metadata:tutoom:coursename'] = 'The course name of the user';
$string['privacy:metadata:tutoom:role'] = 'The role of the user accessing to Moodle.';
