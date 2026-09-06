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

$string['action_changeavailability'] = 'Modifica disponibilità';
$string['action_deleteactivities'] = 'Elimina';
$string['action_findreplace'] = 'Trova e Sostituisci nei Nomi';
$string['action_setallowfromdate'] = 'Imposta Data di Apertura';
$string['action_setcutoffdate'] = 'Imposta Data Limite';
$string['action_setduedate'] = 'Imposta Data di Scadenza';
$string['action_setrestrictions'] = 'Imposta Restrizioni';
$string['action_shift_dates_all'] = 'Questa azione sposterà le date per tutte le attività.';
$string['action_shift_dates_selected'] = 'Questa azione sposterà le date per {$a} attività.';
$string['action_shiftdates'] = 'Sposta Date';
$string['actionsforselected'] = 'Azioni per i selezionati';
$string['activitiesselected'] = '{$a} activities selected';
$string['activitiesselected_plural'] = ' attività selezionate';
$string['activitiesselected_singular'] = ' attività selezionata';
$string['activity'] = 'Attività';
$string['activityname'] = 'Nome Attività';
$string['addtodates'] = 'Aggiungi alle date';
$string['ajaxerror'] = 'AJAX HTTP Error';
$string['allowfromdate'] = 'Data di Apertura';
$string['allstatuses'] = 'Tutti gli stati';
$string['alltypes'] = 'Tutti i tipi';
$string['apply'] = 'Applica';
$string['applyreplace'] = 'Applica Sostituzione';
$string['back'] = 'Indietro';
$string['btn_cancel'] = 'Annulla';
$string['btn_discard'] = 'Annulla modifiche';
$string['bulkshiftall'] = 'Sposta Date in Blocco (Tutte)';
$string['buy_pro'] = 'Get the Pro version here!';
$string['cancel'] = 'Annulla';
$string['clearselection'] = 'Cancella Selezione';
$string['confirmdiscard'] = 'Conferma annullamento';
$string['currentdate'] = 'Data Attuale:';
$string['cutoffdate'] = 'Data Limite';
$string['days'] = 'Giorni';
$string['direction'] = 'Direzione';
$string['discard'] = 'Annulla';
$string['discardchangeswarning'] = 'Sei sicuro di voler annullare tutte le modifiche non salvate?';
$string['domore'] = 'Scopri Pro';
$string['dragdrop_filter_warning'] = 'Il riordino tramite trascinamento è disabilitato mentre i filtri sono attivi. Si prega di cancellare prima i filtri.';
$string['duedate'] = 'Data di Scadenza';
$string['error'] = 'Error';
$string['error_date_due_greater_than_cutoff'] = 'La data di scadenza non può essere successiva alla data limite.';
$string['error_date_open_greater_than_due'] = 'La data di apertura non può essere successiva alla data di scadenza.';
$string['errorajax'] = 'Errore AJAX durante l\'aggiornamento dei record.';
$string['errorupdate'] = 'Errore durante l\'aggiornamento dei record nel database.';
$string['example'] = 'Esempio:';
$string['find'] = 'Trova';
$string['go_to_settings'] = 'Vai alle Impostazioni';
$string['hidden'] = 'Nascosto';
$string['license_activated'] = 'Licenza attivata con successo.';
$string['license_conn_error'] = 'Errore di connessione: ';
$string['license_empty'] = 'La chiave di licenza è vuota.';
$string['license_inactive_ajax'] = 'Licenza inattiva. Si prega di attivare la licenza nelle impostazioni del plugin per salvare le modifiche.';
$string['license_inactive_desc'] = 'Per utilizzare Timeshift, si prega di attivare la licenza nelle impostazioni del plugin.';
$string['license_inactive_title'] = 'Licenza Inattiva';
$string['license_invalid'] = 'Licenza non valida o scaduta.';
$string['license_key'] = 'Chiave di Licenza';
$string['license_key_desc'] = 'Inserisci la tua chiave di licenza per attivare Timeshift.';
$string['license_status_active'] = 'Licenza Attiva';
$string['license_status_invalid'] = 'Licenza Non Valida';
$string['license_status_unset'] = 'Licenza non configurata';
$string['license_validated'] = 'Licenza convalidata con successo.';
$string['lite_installed'] = 'Installed successfully. Save time managing your course activities!';
$string['modal_delete_cannot_undo'] = 'Questa azione non può essere annullata.';
$string['modal_delete_confirm'] = 'Sì, segna per l\'eliminazione';
$string['modal_delete_title'] = 'Elimina Attività';
$string['modal_delete_warning'] = 'Sei sicuro di voler eliminare le attività selezionate? Questo le rimuoverà definitivamente dal corso e cancellerà tutti i voti e le consegne degli studenti associati.';
$string['modal_shift_selected_warning'] = 'Questa azione sposterà le date per le <strong>{$a} attività selezionate</strong>.';
$string['modal_shift_warning'] = 'Questa azione sposterà le date per <strong>tutte le {$a} attività</strong>.';
$string['modulename'] = 'Modulo';
$string['months'] = 'Mesi';
$string['newallowfromdate'] = 'Nuova Data di Apertura';
$string['newavailability'] = 'Nuova Disponibilità';
$string['newcutoffdate'] = 'Nuova Data Limite';
$string['newdate'] = 'Nuova Data:';
$string['newduedate'] = 'Nuova Data di Scadenza';
$string['notice'] = 'Avviso';
$string['opendate'] = 'Data di Apertura';
$string['pagedescription'] = 'Timeshift';
$string['pagedescription_help'] = 'Gestisci le date di apertura, di chiusura e le restrizioni per tutte le attività del corso.<br><br>Usa i filtri per trovare elementi specifici o applicare modifiche in blocco.<br><br>Puoi usare il trascinamento per riordinare gli elementi. Le sezioni vuote non verranno mostrate.';
$string['pagetitle'] = 'Timeshift';
$string['pending_deletion'] = 'In attesa di eliminazione';
$string['pluginname'] = 'Timeshift';
$string['pluginname_help'] = 'Manage course dates';
$string['previewchanges'] = 'Anteprima delle Modifiche';
$string['privacy:metadata'] = 'Il plugin Timeshift non memorizza alcun dato personale.';
$string['pro_description'] = 'Sblocca funzioni avanzate per gestire le attività dei tuoi corsi in modo più efficiente.';
$string['pro_feature_availability_desc'] = 'Cambia lo stato di visibilità, la modalità furtiva o nascondi decine di attività rapidamente.';
$string['pro_feature_availability_title'] = 'Gestione Disponibilità';
$string['pro_feature_deletion_desc'] = 'Seleziona ed elimina le attività in blocco con conferma di sicurezza per evitare perdite accidentali di dati.';
$string['pro_feature_deletion_title'] = 'Eliminazione Sicura';
$string['pro_feature_dragdrop_desc'] = 'Riordina le attività all\'interno delle tue sezioni e argomenti usando una moderna interfaccia Drag & Drop.';
$string['pro_feature_dragdrop_title'] = 'Drag and Drop';
$string['pro_feature_filtering_desc'] = 'Trova le attività esatte che desideri modificare in pochi secondi filtrando per tipo o stato.';
$string['pro_feature_filtering_title'] = 'Filtri Potenti';
$string['pro_feature_findreplace_desc'] = 'Trova e modifica il testo nei nomi di tutte le attività. Perfetto per aggiornare gli anni ("Esame 2026" a "Esame 2027").';
$string['pro_feature_findreplace_title'] = 'Trova e Sostituisci';
$string['pro_feature_restrictions_desc'] = 'Assegna o rimuovi restrizioni di accesso in blocco con un menu intuitivo e centralizzato.';
$string['pro_feature_restrictions_title'] = 'Controllo Restrizioni';
$string['pro_feature_shift_desc'] = 'Sposta le date di scadenza, inizio e chiusura di tutte le attività o di selezioni specifiche in avanti o all\'indietro in pochi secondi.';
$string['pro_feature_shift_title'] = 'Spostamento di Massa';
$string['pro_installed'] = 'Hai installato la versione <strong>Pro</strong>! Goditi tutte le funzionalità senza limiti.';
$string['pro_subtitle'] = 'Dimentica la modifica attività per attività. TimeShift ti fa risparmiare ore di configurazione.';
$string['pro_title'] = 'Passa a Timeshift Pro';
$string['pro_title_part1'] = 'Progettato per la';
$string['pro_title_part2'] = 'Produttività';
$string['replacementtext'] = 'Testo sostitutivo...';
$string['replacewith'] = 'Sostituisci con';
$string['restrictions'] = 'Restrizioni';
$string['savechanges'] = 'Salva Modifiche';
$string['saving'] = 'Salvataggio...';
$string['searchbyname'] = 'Cerca per nome';
$string['section'] = 'Sezione';
$string['selectwhattoshift'] = 'Seleziona cosa spostare';
$string['shiftby'] = 'Sposta di';
$string['shiftdays'] = 'Aggiungi/Sottrai Giorni';
$string['shiftmodaltitle'] = 'Sposta Date in Blocco';
$string['shiftmodaltitle_help'] = 'Usa questo strumento per spostare in avanti o indietro le date di tutte le attività di un numero specifico di giorni. Questo è estremamente utile quando si riutilizza un corso di un semestre o di un anno precedente.<br><br><b>Nota:</b> Se un\'attività non ha una data configurata, questa azione non verrà applicata ad essa.';
$string['status'] = 'Stato';
$string['stealth'] = 'Invisibile';
$string['subtractfromdates'] = 'Sottrai dalle date';
$string['success'] = 'Successo';
$string['successsaved'] = 'Modifiche salvate con successo.';
$string['taskverifylicense'] = 'Verifica lo stato della licenza';
$string['texttofind'] = 'Testo da trovare...';
$string['timeshift:manage'] = 'Manage Timeshift';
$string['totalactivities'] = 'Totale attività:';
$string['type'] = 'Tipo';
$string['upgrade_button'] = 'Passa a Pro';
$string['visible'] = 'Visibile';
$string['weeks'] = 'Settimane';
