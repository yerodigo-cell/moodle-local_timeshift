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
 * Timeshift (local_timeshift)
 *
 * @package     local_timeshift
 * @copyright   2026 EduPlugins Studio
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['action_changeavailability'] = 'Verfügbarkeit ändern';
$string['action_deleteactivities'] = 'Löschen';
$string['action_findreplace'] = 'Suchen & Ersetzen in Namen';
$string['action_setallowfromdate'] = 'Eröffnungsdatum festlegen';
$string['action_setcutoffdate'] = 'Abgabeschluss festlegen';
$string['action_setduedate'] = 'Fälligkeitsdatum festlegen';
$string['action_setrestrictions'] = 'Einschränkungen festlegen';
$string['action_shift_dates_all'] = 'Diese Aktion verschiebt die Daten für alle Aktivitäten.';
$string['action_shift_dates_selected'] = 'Diese Aktion verschiebt die Daten für {$a} Aktivitäten.';
$string['action_shiftdates'] = 'Daten verschieben';
$string['actionsforselected'] = 'Aktionen für die Auswahl';
$string['activitiesselected_plural'] = ' Aktivitäten ausgewählt';
$string['activitiesselected_singular'] = ' Aktivität ausgewählt';
$string['activity'] = 'Aktivität';
$string['activityname'] = 'Aktivitätsname';
$string['addtodates'] = 'Zu Daten hinzufügen';
$string['allowfromdate'] = 'Eröffnungsdatum';
$string['allstatuses'] = 'Alle Status';
$string['alltypes'] = 'Alle Typen';
$string['apply'] = 'Anwenden';
$string['applyreplace'] = 'Ersetzen anwenden';
$string['btn_cancel'] = 'Abbrechen';
$string['btn_discard'] = 'Verwerfen';
$string['bulkshiftall'] = 'Massenverschiebung von Daten (Alle)';
$string['cancel'] = 'Abbrechen';
$string['clearselection'] = 'Auswahl aufheben';
$string['confirmdiscard'] = 'Verwerfen bestätigen';
$string['currentdate'] = 'Aktuelles Datum:';
$string['cutoffdate'] = 'Abgabeschluss';
$string['days'] = 'Tage';
$string['direction'] = 'Richtung';
$string['discard'] = 'Verwerfen';
$string['discardchangeswarning'] = 'Möchten Sie wirklich alle nicht gespeicherten Änderungen verwerfen?';
$string['dragdrop_filter_warning'] = 'Die Drag-and-Drop-Neuanordnung ist deaktiviert, während Filter aktiv sind. Bitte löschen Sie zuerst die Filter.';
$string['duedate'] = 'Fälligkeitsdatum';
$string['error_date_due_greater_than_cutoff'] = 'Das Fälligkeitsdatum darf nicht nach dem Abgabeschluss liegen.';
$string['error_date_open_greater_than_due'] = 'Das Eröffnungsdatum darf nicht nach dem Fälligkeitsdatum liegen.';
$string['errorajax'] = 'AJAX-Fehler beim Aktualisieren der Datensätze.';
$string['errorupdate'] = 'Fehler beim Aktualisieren der Datenbankeinträge.';
$string['example'] = 'Beispiel:';
$string['find'] = 'Suchen';
$string['go_to_settings'] = 'Zu den Einstellungen';
$string['hidden'] = 'Verborgen';
$string['license_activated'] = 'Lizenz erfolgreich aktiviert.';
$string['license_conn_error'] = 'Verbindungsfehler: ';
$string['license_empty'] = 'Der Lizenzschlüssel ist leer.';
$string['license_inactive_ajax'] = 'Inaktive Lizenz. Bitte aktivieren Sie Ihre Lizenz in den Plugin-Einstellungen, um Änderungen zu speichern.';
$string['license_inactive_desc'] = 'Um Timeshift zu nutzen, aktivieren Sie bitte Ihre Lizenz in den Plugin-Einstellungen.';
$string['license_inactive_title'] = 'Inaktive Lizenz';
$string['license_invalid'] = 'Ungültige oder abgelaufene Lizenz.';
$string['license_key'] = 'Lizenzschlüssel';
$string['license_key_desc'] = 'Geben Sie Ihren Lizenzschlüssel ein, um Timeshift zu aktivieren.';
$string['license_status_active'] = 'Aktive Lizenz';
$string['license_status_invalid'] = 'Ungültige Lizenz';
$string['license_status_unset'] = 'Lizenz nicht konfiguriert';
$string['license_validated'] = 'Lizenz erfolgreich validiert.';
$string['modal_delete_cannot_undo'] = 'Diese Aktion kann nicht rückgängig gemacht werden.';
$string['modal_delete_confirm'] = 'Ja, zum Löschen markieren';
$string['modal_delete_title'] = 'Aktivitäten löschen';
$string['modal_delete_warning'] = 'Sind Sie sicher, dass Sie die ausgewählten Aktivitäten löschen möchten? Dadurch werden sie dauerhaft aus dem Kurs entfernt und alle zugehörigen Noten und Abgaben der Teilnehmer gelöscht.';
$string['modal_shift_selected_warning'] = 'Diese Aktion verschiebt die Daten für die <strong>{$a} ausgewählten Aktivitäten</strong>.';
$string['modal_shift_warning'] = 'Diese Aktion verschiebt die Daten für <strong>alle {$a} Aktivitäten</strong>.';
$string['modulename'] = 'Modul';
$string['months'] = 'Monate';
$string['newallowfromdate'] = 'Neues Eröffnungsdatum';
$string['newavailability'] = 'Neue Verfügbarkeit';
$string['newcutoffdate'] = 'Neuer Abgabeschluss';
$string['newdate'] = 'Neues Datum:';
$string['newduedate'] = 'Neues Fälligkeitsdatum';
$string['notice'] = 'Hinweis';
$string['opendate'] = 'Eröffnungsdatum';
$string['pagedescription'] = 'Timeshift';
$string['pagedescription_help'] = 'Verwalten Sie Eröffnungsdaten, Schließungsdaten und Einschränkungen für alle Kursaktivitäten.<br><br>Verwenden Sie die Filter, um bestimmte Elemente zu finden oder Änderungen massenhaft anzuwenden.<br><br>Sie können Drag & Drop verwenden, um Elemente neu anzuordnen. Leere Abschnitte werden nicht angezeigt.';
$string['pagetitle'] = 'Timeshift';
$string['pending_deletion'] = 'Ausstehende Löschung';
$string['pluginname'] = 'Timeshift';
$string['previewchanges'] = 'Änderungen in der Vorschau anzeigen';
$string['privacy:metadata'] = 'Das Timeshift Plugin speichert keine persönlichen Daten.';
$string['pro_installed'] = 'Sie haben die <strong>Pro</strong>-Version installiert! Genießen Sie alle Funktionen ohne Einschränkungen.';
$string['replacementtext'] = 'Ersatztext...';
$string['replacewith'] = 'Ersetzen durch';
$string['restrictions'] = 'Einschränkungen';
$string['savechanges'] = 'Änderungen speichern';
$string['saving'] = 'Speichern...';
$string['searchbyname'] = 'Nach Namen suchen';
$string['section'] = 'Abschnitt';
$string['selectwhattoshift'] = 'Wählen Sie aus, was verschoben werden soll';
$string['shiftby'] = 'Verschieben um';
$string['shiftdays'] = 'Tage hinzufügen/subtrahieren';
$string['shiftmodaltitle'] = 'Massenverschiebung von Daten';
$string['shiftmodaltitle_help'] = 'Verwenden Sie dieses Tool, um alle Aktivitätsdaten um eine bestimmte Anzahl von Tagen vor- oder zurückzuverschieben. Dies ist äußerst nützlich, wenn ein Kurs aus einem vorherigen Semester oder Jahr wiederverwendet wird.<br><br><b>Hinweis:</b> Wenn für eine Aktivität kein Datum konfiguriert ist, wird diese Aktion nicht darauf angewendet.';
$string['status'] = 'Status';
$string['stealth'] = 'Unsichtbar';
$string['subtractfromdates'] = 'Von Daten subtrahieren';
$string['success'] = 'Erfolg';
$string['successsaved'] = 'Änderungen erfolgreich gespeichert.';
$string['taskverifylicense'] = 'Lizenzstatus überprüfen';
$string['texttofind'] = 'Zu suchender Text...';
$string['totalactivities'] = 'Gesamte Aktivitäten:';
$string['type'] = 'Typ';
$string['visible'] = 'Sichtbar';
$string['weeks'] = 'Wochen';
