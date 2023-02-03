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

/**
 * Privacy class for requesting user data.
 *
 * @package   mod_tutoom
 * @copyright 2022 onwards, Tutoom Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_tutoom\privacy;

use \core_privacy\local\metadata\collection;

class provider implements
    // This plugin has data.
    \core_privacy\local\metadata\provider {

    /**
     * Returns metadata.
     *
     * @param collection $collection The initialised collection to add items to.
     * @return collection A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection): collection {
        // Personal information has to be passed to Tutoom.
        // This includes the user email, fullname, role and course name.
        $collection->add_external_location_link('tutoom', [
                'email' => 'privacy:metadata:tutoom:email',
                'fullname' => 'privacy:metadata:tutoom:fullname',
                'coursename' => 'privacy:metadata:tutoom:coursename',
                'role' => 'privacy:metadata:tutoom:role',
            ], 'privacy:metadata:tutoom');

        return $collection;
    }
}
