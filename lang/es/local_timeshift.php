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
 * TimeShift Pro (local_timeshift)
 *
 * @package     local_timeshift
 * @copyright   2026 EduPlugins Studio
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'TimeShift Pro';
$string['pagetitle'] = 'Timeshift Pro';
$string['savechanges'] = 'Guardar Cambios';
$string['modulename'] = 'Módulo';
$string['activityname'] = 'Nombre de la Actividad';
$string['duedate'] = 'Fecha de Entrega / Cierre';
$string['allowfromdate'] = 'Permitir Entregas / Apertura';
$string['shiftmodaltitle'] = 'Desplazamiento Masivo de Fechas';
$string['shiftdays'] = 'Añadir/Restar Días';
$string['successsaved'] = 'Cambios guardados con éxito.';
$string['errorupdate'] = 'Error al actualizar los registros en la base de datos.';
$string['searchbyname'] = 'Buscar por nombre';
$string['alltypes'] = 'Todos los tipos';
$string['shiftmodaltitle_help'] = 'Utilice esta herramienta para adelantar o atrasar todas las fechas de entrega y apertura por un número específico de días. Esto es muy útil cuando se reutiliza un curso de un semestre o año anterior.';
$string['pagedescription'] = 'Gestiona las fechas de apertura, cierre y restricciones de todas las actividades del curso. Utiliza los filtros para buscar elementos específicos o aplica cambios de forma masiva.';
$string['status'] = 'Estado';
$string['visible'] = 'Visible';
$string['hidden'] = 'Oculto';
$string['stealth'] = 'Sigiloso';
$string['allstatuses'] = 'Todos los estados';
$string['bulkshiftall'] = 'Desplazamiento Masivo (Todos)';
$string['type'] = 'Tipo';
$string['activity'] = 'Actividad';
$string['opendate'] = 'Fecha de Apertura';
$string['cutoffdate'] = 'Fecha Límite';
$string['restrictions'] = 'Restricciones';
$string['actionsforselected'] = 'Acciones para seleccionados';
$string['clearselection'] = 'Limpiar Selección';
$string['discard'] = 'Descartar';
$string['totalactivities'] = 'Total de actividades:';
$string['activitiesselected_singular'] = ' actividad seleccionada';
$string['activitiesselected_plural'] = ' actividades seleccionadas';
$string['action_shiftdates'] = 'Desplazar Fechas';
$string['action_setallowfromdate'] = 'Establecer Fecha de Apertura';
$string['action_setduedate'] = 'Establecer Fecha de Entrega';
$string['action_setcutoffdate'] = 'Establecer Fecha Límite';
$string['action_findreplace'] = 'Buscar y Reemplazar en Nombres';
$string['action_changeavailability'] = 'Cambiar Disponibilidad';
$string['action_setrestrictions'] = 'Establecer Restricciones';
$string['action_deleteactivities'] = 'Eliminar';
$string['modal_shift_warning'] = 'Esta acción desplazará las fechas de <strong>todas las {$a} actividades</strong>.';
$string['modal_shift_selected_warning'] = 'Esta acción desplazará las fechas de las <strong>{$a} actividades seleccionadas</strong>.';
$string['selectwhattoshift'] = 'Seleccionar qué desplazar';
$string['shiftby'] = 'Desplazar por';
$string['days'] = 'Días';
$string['direction'] = 'Dirección';
$string['addtodates'] = 'Sumar a las fechas';
$string['subtractfromdates'] = 'Restar de las fechas';
$string['example'] = 'Ejemplo:';
$string['currentdate'] = 'Fecha Actual:';
$string['newdate'] = 'Nueva Fecha:';
$string['cancel'] = 'Cancelar';
$string['previewchanges'] = 'Previsualizar Cambios';
$string['find'] = 'Buscar';
$string['texttofind'] = 'Texto a buscar...';
$string['replacewith'] = 'Reemplazar con';
$string['replacementtext'] = 'Texto de reemplazo...';
$string['applyreplace'] = 'Aplicar Reemplazo';
$string['newavailability'] = 'Nueva Disponibilidad';
$string['newallowfromdate'] = 'Nueva Fecha de Apertura';
$string['newduedate'] = 'Nueva Fecha de Entrega';
$string['newcutoffdate'] = 'Nueva Fecha Límite';
$string['apply'] = 'Aplicar';
$string['modal_delete_title'] = 'Eliminar Actividades';
$string['modal_delete_warning'] = '¿Está seguro de que desea eliminar las actividades seleccionadas? Esto las eliminará permanentemente del curso y borrará todas las calificaciones y entregas de estudiantes asociadas.';
$string['modal_delete_cannot_undo'] = 'Esta acción no se puede deshacer.';
$string['modal_delete_confirm'] = 'Sí, marcar para eliminación';
$string['pending_deletion'] = 'Eliminación Pendiente';
