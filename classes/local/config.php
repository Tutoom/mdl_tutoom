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

namespace mod_tutoom\local;

/**
 * Handles the global configuration based on config.php.
 *
 * @package   mod_tutoom
 * @copyright 2022 onwards, Tutoom Inc
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class config {
    /** @var string Default tutoom api url */
    public const TUTOOM_BACKEND_API_URL = 'https://api.tutoom.com/v1.1/';

    /** @var string Default tutoom app url */
    public const TUTOOM_APP_URL = 'https://tutoom.app';

    /** @var string Default tutoom playback app url */
    public const TUTOOM_PLAYBACK_APP_URL = 'https://playback.tutoom.app/api/v1';

    /** @var string Defines name of moderator role */
    public const MODERATOR_ROLE = 'MODERATOR';

    /** @var string Defines name of viewer role */
    public const VIEWER_ROLE = 'VIEWER';

    /**
     * Returns configuration default values.
     *
     * @return array
     */
    public static function defaultvalues() {
        return array(
            'tutoom_backend_api_url' => self::TUTOOM_BACKEND_API_URL,
            'tutoom_app_url' => self::TUTOOM_APP_URL,
            'playback_app_url' => self::TUTOOM_PLAYBACK_APP_URL,
            'moderator_role' => self::MODERATOR_ROLE,
            'viewer_role' => self::VIEWER_ROLE,
        );
    }

    /**
     * Returns default value for an specific setting.
     *
     * @param string $setting
     * @return string
     */
    public static function defaultvalue($setting) {
        $defaultvalues = self::defaultvalues();
        if (!array_key_exists($setting, $defaultvalues)) {
            return;
        }
        return $defaultvalues[$setting];
    }

    /**
     * Returns value for an specific setting.
     *
     * @param string $setting
     * @return string
     */
    public static function get($setting) {
        return self::defaultvalue($setting);
    }

    /**
     * Wraps current settings in an array.
     *
     * @return array
     */
    public static function get_options() {
        return array(
            'tutoom_backend_api_url' => self::get("tutoom_backend_api_url"),
            'tutoom_app_url' => self::get("tutoom_app_url"),
            'playback_app_url' => self::get("playback_app_url"),
            'moderator_role' => self::get("moderator_role"),
            'viewer_role' => self::get("viewer_role"),
        );
    }
}
