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
 * Upgrade steps for the mod_tutoom plugin.
 *
 * @package   mod_tutoom
 * @copyright 2022 onwards, Tutoom Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function xmldb_tutoom_upgrade($oldversion) {
    global $CFG, $DB;
    $dbman = $DB->get_manager();
    if ($oldversion < 2023080900) {


        // Define field urlapp to be dropped from tutoom.
        $table1 = new xmldb_table('tutoom');
        $field1 = new xmldb_field('urlapp');

        // Conditionally launch drop field urlapp.
        if ($dbman->field_exists($table1, $field1)) {
            $dbman->drop_field($table1, $field1);
        }

        // Define field record to be added to tutoom.
        $table2 = new xmldb_table('tutoom');
        $field2 = new xmldb_field('record', XMLDB_TYPE_INTEGER, '1', null, null, null, '0', 'welcomemessage');

        // Conditionally launch add field record.
        if (!$dbman->field_exists($table2, $field2)) {
            $dbman->add_field($table2, $field2);
        }

        // Define field type to be added to tutoom.
        $table3 = new xmldb_table('tutoom');
        $field3 = new xmldb_field('type', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0', 'id');

        // Conditionally launch add field type.
        if (!$dbman->field_exists($table3, $field3)) {
            $dbman->add_field($table3, $field3);
        }

        // Define table tutoom_logs to be created.
        $table_logs = new xmldb_table('tutoom_logs');

        // Adding fields to table tutoom_logs.
        $table_logs->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table_logs->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table_logs->add_field('tutoomid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table_logs->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table_logs->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table_logs->add_field('meetingid', XMLDB_TYPE_CHAR, '256', null, XMLDB_NOTNULL, null, null);
        $table_logs->add_field('log', XMLDB_TYPE_CHAR, '32', null, XMLDB_NOTNULL, null, null);
        $table_logs->add_field('meta', XMLDB_TYPE_TEXT, null, null, null, null, null);

        // Adding keys to table tutoom_logs.
        $table_logs->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Adding indexes to table tutoom_logs.
        $table_logs->add_index('courseid', XMLDB_INDEX_NOTUNIQUE, ['courseid']);
        $table_logs->add_index('log', XMLDB_INDEX_NOTUNIQUE, ['log']);
        $table_logs->add_index('logrow', XMLDB_INDEX_NOTUNIQUE, ['courseid', 'tutoomid', 'userid', 'log']);
        $table_logs->add_index('userlog', XMLDB_INDEX_NOTUNIQUE, ['userid', 'log']);

        // Conditionally launch create table for tutoom_logs.
        if (!$dbman->table_exists($table_logs)) {
            $dbman->create_table($table_logs);
        }

        // Tutoom savepoint reached.
        upgrade_mod_savepoint(true, 2023080900, 'tutoom');
    }
    
    return true;
}
