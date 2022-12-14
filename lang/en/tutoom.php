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

// Initial config.
$string['config_account_id'] = 'Tutoom account ID';
$string['config_account_id_description'] = 'The ID of your organization Tutoom account.';
$string['config_account_secret'] = 'Tutoom secret key';
$string['config_account_secret_description'] = 'The secret key of your organization Tutoom account';
$string['config_general'] = 'General configuration';
$string['config_general_description'] = 'These settings are <b>always</b> used';

// Initial form.
$string['tutoomname'] = 'Name';
$string['mod_form_block_room'] = 'Activity/Room settings';
$string['mod_form_field_welcome'] = 'Welcome message';
$string['mod_form_field_welcome_default_message'] = 'Welcome to the class. Feel free to ask any question.';

// Room info.
$string['view_conference_action_start'] = 'Start session';
$string['view_conference_action_join'] = 'Join session';
$string['view_conference_action_end'] = 'End session';
$string['view_message_conference_room_ready'] = 'This conference room is ready. You can join the session now.';
$string['view_message_conference_in_progress'] = 'The room has not started';
$string['view_message_conference_has_ended'] = 'This conference has ended.';
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
$string['message_loading'] = 'Please wait...';
$string['pagination_previous'] = 'Previous';
$string['pagination_next'] = 'Next';

$string['privacy:metadata'] = 'Tutoom do not store any personal data.';
