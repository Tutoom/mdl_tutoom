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

$string['index_error_noinstances'] = 'No hay instancias de Tutoom';

// Capabilities.
$string['tutoom:joinasmoderator'] = 'Únase como moderador a una reunión de Tutoom';
$string['tutoom:addinstance'] = 'Agregar una nueva sala/actividad de Tutoom';

// Initial config.
$string['config_account_id'] = 'ID de tu cuenta Tutoom';
$string['config_account_id_description'] = 'ID de la cuenta Tuttom de tu organización.';
$string['config_account_secret'] = 'Clave secreta Tutoom';
$string['config_account_secret_description'] = 'Clave secreta de tu cuenta de Tutoom de tu organización';
$string['config_general'] = 'Configuración general';
$string['config_general_description'] = 'Estas configuraciones seran usadas <b>siempre</b>';
$string['config_activity_logs'] = 'Escribir registros de actividad';
$string['config_activity_logs_description'] = 'Esta opción guarda registros cuando se crea una sala, elimina una sala y accede un usuario a la sala.';
$string['config_recording'] = 'Grabaciones';
$string['config_recording_description'] = 'Estos ajustes son caracteristicas específicos';
$string['config_recording_enabled'] = 'Grabación habilitada por defecto';
$string['config_recording_enabled_description'] = "La sesión se puede grabar de forma predeterminada. Se puede editar en la configuración de la actividad de Tutoom";
$string['config_recording_auto_start'] = 'Grabación automática';
$string['config_recording_auto_start_description'] = "Si la opción está marcada, la grabación iniciará automáticamente cuando ingrese el moderador.";

// Initial form.
$string['tutoomname'] = 'Nombre';
$string['mod_form_block_room'] = 'Configuración de Actividades/Salones';
$string['mod_form_field_welcome'] = 'Mensaje de Bienvenida';
$string['mod_form_field_welcome_default_message'] = 'Bienvenido a la clase. Sientete libre de hacer cualquier pregunta.';
$string['mod_form_field_record'] = 'Grabar la sesión';
$string['mod_form_field_room_type'] = 'Tipo de reunión';
$string['mod_form_field_room_type_help'] = 'Seleccione el tipo de habitación para este Tutoom.';

$string['room_type_room_with_recordings'] = 'Reunión con grabaciones';
$string['room_type_room_only'] = 'Solo reunión';
$string['room_type_recording_only'] = 'Solo grabaciones';

// Room info.
$string['view_conference_action_start'] = 'Iniciar sesión';
$string['view_conference_action_join'] = 'Unirse a la sesión';
$string['view_conference_action_end'] = 'Finalizar sesión';
$string['view_message_room_not_initalized'] = 'La sala aún no ha iniciado.';
$string['view_message_room_ended'] = 'Esta sala ha terminado. Haz clic <u id="tutoom-refresh-main-section" style="cursor: pointer;">aquí</u> para recargar la página.';
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
$string['recording_loading'] = 'Recuperando las grabaciones...';
$string['message_loading'] = 'Porfavor espere...';
$string['pagination_previous'] = 'Anterior';
$string['pagination_next'] = 'Siguiente';

// Errors.
$string['view_page_error_general'] = 'No hay salas disponibles. Por favor contacte a su administrador para mayor información.';

$string['privacy:metadata:tutoom'] = 'Para crear y unirse a sesiones de Tutoom, los datos de usuario deben intercambiarse con el servidor.';
$string['privacy:metadata:tutoom:email'] = 'El correo electrónico del usuario que accede a Moodle.';
$string['privacy:metadata:tutoom:fullname'] = 'El nombre completo del usuario que accede a Moodle.';
$string['privacy:metadata:tutoom:coursename'] = 'El nombre del curso del usuario.';
$string['privacy:metadata:tutoom:role'] = 'El rol del usuario que accede a Moodle.';
