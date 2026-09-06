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

$string['action_changeavailability'] = 'Changer la disponibilité';
$string['action_deleteactivities'] = 'Supprimer';
$string['action_findreplace'] = 'Rechercher & Remplacer dans les noms';
$string['action_setallowfromdate'] = 'Définir la date d\'ouverture';
$string['action_setcutoffdate'] = 'Définir la date limite';
$string['action_setduedate'] = 'Définir la date d\'échéance';
$string['action_setrestrictions'] = 'Définir les restrictions';
$string['action_shift_dates_all'] = 'Cette action décalera les dates de toutes les activités.';
$string['action_shift_dates_selected'] = 'Cette action décalera les dates de {$a} activités.';
$string['action_shiftdates'] = 'Décaler les dates';
$string['actionsforselected'] = 'Actions pour la sélection';
$string['activitiesselected'] = '{$a} activities selected';
$string['activitiesselected_plural'] = ' activités sélectionnées';
$string['activitiesselected_singular'] = ' activité sélectionnée';
$string['activity'] = 'Activité';
$string['activityname'] = 'Nom de l\'activité';
$string['addtodates'] = 'Ajouter aux dates';
$string['ajaxerror'] = 'AJAX HTTP Error';
$string['allowfromdate'] = 'Date d\'ouverture';
$string['allstatuses'] = 'Tous les statuts';
$string['alltypes'] = 'Tous les types';
$string['apply'] = 'Appliquer';
$string['applyreplace'] = 'Appliquer le remplacement';
$string['back'] = 'Retour';
$string['btn_cancel'] = 'Annuler';
$string['btn_discard'] = 'Abandonner';
$string['bulkshiftall'] = 'Décalage en masse des dates (Toutes)';
$string['buy_pro'] = 'Get the Pro version here!';
$string['cancel'] = 'Annuler';
$string['clearselection'] = 'Effacer la sélection';
$string['confirmdiscard'] = 'Confirmer l\'abandon';
$string['currentdate'] = 'Date actuelle :';
$string['cutoffdate'] = 'Date limite';
$string['days'] = 'Jours';
$string['direction'] = 'Direction';
$string['discard'] = 'Ignorer';
$string['discardchangeswarning'] = 'Êtes-vous sûr de vouloir abandonner toutes les modifications non enregistrées ?';
$string['domore'] = 'Découvrir Pro';
$string['dragdrop_filter_warning'] = 'La réorganisation par glisser-déposer est désactivée lorsque les filtres sont actifs. Veuillez d\'abord effacer les filtres.';
$string['duedate'] = 'Date d\'échéance';
$string['error'] = 'Error';
$string['error_date_due_greater_than_cutoff'] = 'La date de remise ne peut pas être postérieure à la date limite.';
$string['error_date_open_greater_than_due'] = 'La date d\'ouverture ne peut pas être postérieure à la date de remise.';
$string['errorajax'] = 'Erreur AJAX lors de la mise à jour des enregistrements.';
$string['errorupdate'] = 'Erreur lors de la mise à jour des enregistrements de la base de données.';
$string['example'] = 'Exemple :';
$string['find'] = 'Rechercher';
$string['go_to_settings'] = 'Aller aux paramètres';
$string['hidden'] = 'Caché';
$string['license_activated'] = 'Licence activée avec succès.';
$string['license_conn_error'] = 'Erreur de connexion : ';
$string['license_empty'] = 'La clé de licence est vide.';
$string['license_inactive_ajax'] = 'Licence inactive. Veuillez activer votre licence dans les paramètres du plugin pour enregistrer les modifications.';
$string['license_inactive_desc'] = 'Pour utiliser Timeshift, veuillez activer votre licence dans les paramètres du plugin.';
$string['license_inactive_title'] = 'Licence inactive';
$string['license_invalid'] = 'Licence invalide ou expirée.';
$string['license_key'] = 'Clé de licence';
$string['license_key_desc'] = 'Entrez votre clé de licence pour activer Timeshift.';
$string['license_status_active'] = 'Licence active';
$string['license_status_invalid'] = 'Licence invalide';
$string['license_status_unset'] = 'Licence non configurée';
$string['license_validated'] = 'Licence validée avec succès.';
$string['lite_installed'] = 'Installed successfully. Save time managing your course activities!';
$string['modal_delete_cannot_undo'] = 'Cette action est irréversible.';
$string['modal_delete_confirm'] = 'Oui, marquer pour suppression';
$string['modal_delete_title'] = 'Supprimer des activités';
$string['modal_delete_warning'] = 'Êtes-vous sûr de vouloir supprimer les activités sélectionnées ? Cela les retirera définitivement du cours et supprimera toutes les notes et soumissions des étudiants associées.';
$string['modal_shift_selected_warning'] = 'Cette action décalera les dates pour les <strong>{$a} activités sélectionnées</strong>.';
$string['modal_shift_warning'] = 'Cette action décalera les dates pour <strong>toutes les {$a} activités</strong>.';
$string['modulename'] = 'Module';
$string['months'] = 'Mois';
$string['newallowfromdate'] = 'Nouvelle date d\'ouverture';
$string['newavailability'] = 'Nouvelle disponibilité';
$string['newcutoffdate'] = 'Nouvelle date limite';
$string['newdate'] = 'Nouvelle date :';
$string['newduedate'] = 'Nouvelle date d\'échéance';
$string['notice'] = 'Avis';
$string['opendate'] = 'Date d\'ouverture';
$string['pagedescription'] = 'Timeshift';
$string['pagedescription_help'] = 'Gérez les dates d\'ouverture, de fermeture et les restrictions pour toutes les activités du cours.<br><br>Utilisez les filtres pour trouver des éléments spécifiques ou appliquer des modifications en masse.<br><br>Vous pouvez utiliser le glisser-déposer pour réorganiser les éléments. Les sections vides ne seront pas affichées.';
$string['pagetitle'] = 'Timeshift';
$string['pending_deletion'] = 'En attente de suppression';
$string['pluginname'] = 'Timeshift';
$string['pluginname_help'] = 'Manage course dates';
$string['previewchanges'] = 'Aperçu des modifications';
$string['privacy:metadata'] = 'Le plugin Timeshift ne stocke aucune donnée personnelle.';
$string['pro_description'] = 'Débloquez des fonctionnalités avancées pour gérer plus efficacement les activités de vos cours.';
$string['pro_feature_availability_desc'] = 'Modifiez le statut de visibilité, le mode furtif ou masquez des dizaines d\'activités rapidement.';
$string['pro_feature_availability_title'] = 'Gestion de la Disponibilité';
$string['pro_feature_deletion_desc'] = 'Sélectionnez et supprimez des activités en masse avec confirmation de sécurité pour éviter toute perte de données accidentelle.';
$string['pro_feature_deletion_title'] = 'Suppression Sécurisée';
$string['pro_feature_dragdrop_desc'] = 'Réorganisez les activités au sein de vos sections et thèmes à l\'aide d\'une interface moderne de Glisser-Déposer.';
$string['pro_feature_dragdrop_title'] = 'Glisser-Déposer';
$string['pro_feature_filtering_desc'] = 'Trouvez les activités exactes que vous souhaitez modifier en quelques secondes en filtrant par type ou par statut.';
$string['pro_feature_filtering_title'] = 'Filtrage Puissant';
$string['pro_feature_findreplace_desc'] = 'Recherchez et modifiez le texte dans les noms de toutes les activités. Parfait pour la mise à jour des années ("Examen 2026" en "Examen 2027").';
$string['pro_feature_findreplace_title'] = 'Rechercher et Remplacer';
$string['pro_feature_restrictions_desc'] = 'Attribuez ou supprimez des restrictions d\'accès en masse grâce à un menu centralisé et intuitif.';
$string['pro_feature_restrictions_title'] = 'Contrôle des Restrictions';
$string['pro_feature_shift_desc'] = 'Décaler les dates d\'échéance, de début et de fin de toutes vos activités ou de sélections spécifiques en avant ou en arrière en quelques secondes.';
$string['pro_feature_shift_title'] = 'Décalage en Masse';
$string['pro_installed'] = 'Vous avez la version <strong>Pro</strong> installée ! Profitez de toutes les fonctionnalités sans limites.';
$string['pro_subtitle'] = 'Oubliez la modification activité par activité. TimeShift vous fait gagner des heures de configuration.';
$string['pro_title'] = 'Passer à Timeshift Pro';
$string['pro_title_part1'] = 'Conçu pour la';
$string['pro_title_part2'] = 'Productivité';
$string['replacementtext'] = 'Texte de remplacement...';
$string['replacewith'] = 'Remplacer par';
$string['restrictions'] = 'Restrictions';
$string['savechanges'] = 'Enregistrer les modifications';
$string['saving'] = 'Enregistrement...';
$string['searchbyname'] = 'Rechercher par nom';
$string['section'] = 'Section';
$string['selectwhattoshift'] = 'Sélectionner quoi décaler';
$string['shiftby'] = 'Décaler de';
$string['shiftdays'] = 'Ajouter/Soustraire des jours';
$string['shiftmodaltitle'] = 'Décalage en masse des dates';
$string['shiftmodaltitle_help'] = 'Utilisez cet outil pour avancer ou reculer les dates de toutes les activités d\'un nombre spécifique de jours. C\'est extrêmement utile lors de la réutilisation d\'un cours d\'un semestre ou d\'une année précédente.<br><br><b>Remarque :</b> Si une activité n\'a pas de date configurée, cette action ne s\'y appliquera pas.';
$string['status'] = 'Statut';
$string['stealth'] = 'Furtif';
$string['subtractfromdates'] = 'Soustraire des dates';
$string['success'] = 'Succès';
$string['successsaved'] = 'Modifications enregistrées avec succès.';
$string['taskverifylicense'] = 'Vérifier l\'état de la licence';
$string['texttofind'] = 'Texte à rechercher...';
$string['timeshift:manage'] = 'Manage Timeshift';
$string['totalactivities'] = 'Total des activités :';
$string['type'] = 'Type';
$string['upgrade_button'] = 'Passer à Pro';
$string['visible'] = 'Visible';
$string['weeks'] = 'Semaines';
