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

namespace mod_tutoom;

defined('MOODLE_INTERNAL') || die;
require_once(__DIR__ . '../../locallib.php');
require_once($CFG->libdir . '/filelib.php');

use curl;
use stdClass;
use mod_tutoom\local\config;

/**
 * Class to describe Tutoom Recordings.
 *
 * @package   mod_tutoom
 * @copyright 2022 onwards, Tutoom Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class recording {
    public function __construct() {
    }

    /**
     * Return list of recordings. It can return empty list too.
     *
     * @param string $externalid
     * @param int $page
     * @return stdClass
     */
    public static function get_recordings(string $externalid, int $page = 1): stdClass {
        $cfg = config::get_options();
        $apiurl = $cfg["tutoom_backend_api_url"];

        $config = get_config("mod_tutoom");
        $accountid = $config->account_id;
        $accountsecret = $config->account_secret;

        $results = new stdClass();

        $requesttimestamp = time();
        $checksumrequest = json_decode("{
            \"accountId\": \"$accountid\",
            \"checksum\": \"\",
            \"externalId\": \"$externalid\",
            \"limit\": 5,
            \"page\": $page,
            \"requestTimestamp\": $requesttimestamp
        }");

        $params = tuttom_generate_checksum('get', "recordings", $checksumrequest, $accountsecret);
        $paramstourl = http_build_query($params, '&amp;', '&');

        $url = $apiurl . "recordings" . "?" . $paramstourl;

        $curl = new curl();
        $curl->setopt(array(
            'CURLOPT_RETURNTRANSFER' => true,
            'CURLOPT_HTTPHEADER' => array('Content-Type: application/json')
        ));
        $response = $curl->get($url);
        $info = $curl->get_info();

        if ($info['http_code'] >= 300){
            $results->error = json_decode($response);
        } else {
            $results = json_decode($response);
        }

        return $results;
    }

    /**
     * Return count of recordings.
     *
     * @param string $externalid
     * @return stdClass
     */
    public static function get_count_recordings(string $externalid): stdClass {
        $cfg = config::get_options();
        $apiurl = $cfg["tutoom_backend_api_url"];

        $config = get_config("mod_tutoom");
        $accountid = $config->account_id;
        $accountsecret = $config->account_secret;

        $results = new stdClass();

        $requesttimestamp = time();
        $checksumrequest = json_decode("{
            \"accountId\": \"$accountid\",
            \"checksum\": \"\",
            \"externalId\": \"$externalid\",
            \"requestTimestamp\": $requesttimestamp
        }");

        $params = tuttom_generate_checksum('get', "recordings/count", $checksumrequest, $accountsecret);
        $paramstourl = http_build_query($params, '&amp;', '&');

        $url = $apiurl . "recordings/count" . "?" . $paramstourl;

        $curl = new curl();
        $curl->setopt(array(
            'CURLOPT_RETURNTRANSFER' => true,
            'CURLOPT_HTTPHEADER' => array('Content-Type: application/json')
        ));
        $response = $curl->get($url);
        $info = $curl->get_info();

        if ($info['http_code'] >= 300){
            $results->error = json_decode($response);
        } else {
            $results = json_decode($response);
        }

        return $results;
    }

    /**
     * Generate a url to connect to a tutoom meeting.
     *
     * @param string $meetingid
     * @return string
     */
    public static function join_playback(string $meetingid): string {
        global $USER;

        $cfg = config::get_options();
        $playbackurl = $cfg["playback_app_url"];

        $config = get_config("mod_tutoom");
        $accountid = $config->account_id;
        $accountsecret = $config->account_secret;

        $userid = $USER->id;
        $userfullname = "$USER->firstname $USER->lastname";

        $requesttimestamp = time();
        $checksumrequest = json_decode("{
            \"accountId\": \"$accountid\",
            \"checksum\": \"\",
            \"meetingId\": \"$meetingid\",
            \"name\": \"$userfullname\",
            \"requestTimestamp\": $requesttimestamp,
            \"userId\": \"$userid\"
        }");

        $params = tuttom_generate_checksum('get', 'join', $checksumrequest, $accountsecret);
        $queryparams = tuttom_generate_params_to_url($params);

        $joinurl = $playbackurl . '/join?' . $queryparams;

        return $joinurl;
    }
}
