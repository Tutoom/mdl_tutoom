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

namespace mod_tutoom\output;

use plugin_renderer_base;

/**
 * Renderer for the mod_tutoom plugin.
 *
 * @package   mod_tutoom
 * @copyright 2022 onwards, Tutoom Inc
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {
    /**
     * @var $settings stores the settings as they come from settings.php
     */
    private $settings;

    /**
     * Constructor.
     *
     * @param object $settings
     */
    public function __construct(&$settings) {
        $this->settings = $settings;
    }

    /**
     * Render the header for a group.
     *
     * @param string $name
     * @param string $itemname
     * @param string $itemdescription
     *
     * @return void
     */
    public function render_group_header($name, $itemname = null, $itemdescription = null) {
        if ($itemname === null) {
            $itemname = get_string('config_' . $name, 'tutoom');
        }
        if ($itemdescription === null) {
            $itemdescription = get_string('config_' . $name . '_description', 'tutoom');
        }
        $item = new \admin_setting_heading('tutoom_config_' . $name, $itemname, $itemdescription);
        $this->settings->add($item);
    }

    /**
     * Render a text element in a group.
     *
     * @param string    $name
     * @param object    $default
     * @param string    $type
     *
     * @return Object
     */
    public function render_group_element_text($name, $default = null, $type = PARAM_RAW) {
        $item = new \admin_setting_configtext(
            'mod_tutoom/' . $name,
            get_string('config_' . $name, 'tutoom'),
            get_string('config_' . $name . '_description', 'tutoom'),
            $default,
            $type
        );
        $this->settings->add($item);
    }

    /**
     * Render a checkbox element in a group.
     *
     * @param string    $name
     * @param object    $default
     *
     * @return Object
     */
    public function render_group_element_checkbox($name, $default = null) {
        $item = new \admin_setting_configcheckbox(
            'mod_tutoom/' . $name,
            get_string('config_' . $name, 'tutoom'),
            get_string('config_' . $name . '_description', 'tutoom'),
            $default
        );
        $this->settings->add($item);
    }

    /**
     * Render a multiselect element in a group.
     *
     * @param string    $name
     * @param object    $defaultsetting
     * @param object    $choices
     *
     * @return Object
     */
    public function render_group_element_configmultiselect($name, $defaultsetting, $choices) {
        $item = new \admin_setting_configmultiselect(
            'mod_tutoom/' . $name,
            get_string('config_' . $name, 'tutoom'),
            get_string('config_' . $name . '_description', 'tutoom'),
            $defaultsetting,
            $choices
        );
        $this->settings->add($item);
    }

    /**
     * Render a select element in a group.
     *
     * @param string    $name
     * @param object    $defaultsetting
     * @param object    $choices
     *
     * @return Object
     */
    public function render_group_element_configselect($name, $defaultsetting, $choices) {
        $item = new \admin_setting_configselect(
            'mod_tutoom/' . $name,
            get_string('config_' . $name, 'tutoom'),
            get_string('config_' . $name . '_description', 'tutoom'),
            $defaultsetting,
            $choices
        );
        $this->settings->add($item);
    }
}
