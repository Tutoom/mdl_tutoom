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
$string['modulename_help'] = 'Tutoom le permite crear desde dentro de Moodle enlaces a reuniones en línea en tiempo real usando Tutoom, un sistema de conferencias web para educación a distancia.';

$string['message_account_id_not_set'] = 'Necesitas configurar el id de la cuenta Tutoom de tu organización en la sección de configuraciones generales del plugin.';
$string['missingidandcmid'] = 'El ID de Tutoom es incorrecto. Por favor, dirígase a su curso y seleccione su actividad para entrar correctamente a Tutoom.';

// Initial config.
$string['config_account_id'] = 'ID de tu cuenta Tutoom';
$string['config_account_id_description'] = 'ID de la cuenta Tuttom de tu organización.';
$string['config_account_secret'] = 'Clave secreta Tutoom';
$string['config_account_secret_description'] = 'Clave secreta de tu cuenta de Tutoom de tu organización';
$string['config_general'] = 'Configuración general';
$string['config_general_description'] = 'Estas configuraciones seran usadas <b>siempre</b>';

// Initial form.
$string['tutoomname'] = 'Nombre';
$string['mod_form_block_room'] = 'Configuración de Actividades/Salones';
$string['mod_form_field_welcome'] = 'Mensaje de Bienvenida';
$string['mod_form_field_welcome_default_message'] = 'Bienvenido a la clase. Sientete libre de hacer cualquier pregunta.';

// Room info.
$string['view_conference_action_start'] = 'Iniciar sesión';
$string['view_conference_action_join'] = 'Unirse a la sesión';
$string['view_conference_action_end'] = 'Finalizar sesión';
$string['view_message_conference_room_ready'] = 'Esta conferencia esta lista. Puedes unirte a la sesión ahora.';
$string['view_message_conference_in_progress'] = 'La sala aún no ha iniciado';
$string['view_message_conference_has_ended'] = 'Esta conferencia finalizo.';
$string['view_message_conference_in_this_room'] = 'en esta sala.';
$string['view_message_session_status_on'] = 'EN LINEA';
$string['view_message_session_status_off'] = 'DESCONECTADO';
$string['view_message_session_started_at'] = 'Sesión inicio a las ';
$string['view_message_session_has_user'] = 'Hay ';
$string['view_message_session_has_users'] = 'Hay ';
$string['view_message_user'] = 'usuario';
$string['view_message_users'] = 'usuarios';
$string['view_section_title_recordings'] = 'Grabaciones';
$string['view_message_norecordings'] = 'No hay grabaciones para mostrar.';
$string['recording_title'] = 'Grabaciones';
$string['recording_playback'] = 'Reproducción';
$string['recording_name'] = 'Nombre';
$string['recording_description'] = 'Descripción';
$string['recording_preview'] = 'Previsualización';
$string['recording_date'] = 'Fecha';
$string['recording_time'] = 'Hora';
$string['recording_duration'] = 'Duración';
$string['recording_toolbar'] = 'Herramientas';
$string['recording_text_empty'] = 'No hay grabaciones por el momento...';
$string['message_loading'] = 'Porfavor espere...';
$string['pagination_previous'] = 'Anterior';
$string['pagination_next'] = 'Siguiente';

$string['privacy:metadata'] = 'Tutoom no almacena ningún dato personal.';
