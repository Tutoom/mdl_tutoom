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
     * @param string $classid
     * @param int $page
     * @return stdClass
     */
    public static function get_recordings(string $classid, int $page = 1): stdClass {
        global $CFG;

        $cfg = config::get_options();
        $apiurl = $cfg["api_url"];

        $accountid = $CFG->tutoom_account_id;
        $accountsecret = $CFG->tutoom_account_secret;
        $results = new stdClass();

        $requesttimestamp = time();
        $checksumrequest = json_decode("{
            \"accountId\": \"$accountid\",
            \"checksum\": \"\",
            \"externalClassId\": \"$classid\",
            \"limit\": 5,
            \"page\": $page,
            \"requestTimestamp\": $requesttimestamp
        }");

        $params = tuttom_generate_checksum('get', "recordings", $checksumrequest, $accountsecret);
        $paramstourl = http_build_query($params, '&amp;', '&');

        $url = $apiurl . "recordings" . "?" . $paramstourl;

        $curl = new curl();
        $curl->setopt(array(
            'CURLOPT_FAILONERROR' => true,
            'CURLOPT_RETURNTRANSFER' => true,
            'CURLOPT_HTTPHEADER' => array('Content-Type: application/json')
        ));
        $response = $curl->get($url);
        $info = $curl->get_info();

        if ($curl->error || $info['http_code'] >= 300){
            $results->error = strlen($curl->error) > 0 ? $curl->error : $response;
        } else {
            $results->data = json_decode($response);
        }

        return $results;
    }
}
