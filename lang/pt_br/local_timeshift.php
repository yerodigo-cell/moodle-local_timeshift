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

$string['action_changeavailability'] = 'Alterar disponibilidade';
$string['action_deleteactivities'] = 'Excluir';
$string['action_findreplace'] = 'Localizar e substituir em nomes';
$string['action_setallowfromdate'] = 'Definir data de abertura';
$string['action_setcutoffdate'] = 'Definir data limite';
$string['action_setduedate'] = 'Definir data de entrega';
$string['action_setrestrictions'] = 'Definir restrições';
$string['action_shift_dates_all'] = 'Esta ação mudará as datas de todas as atividades.';
$string['action_shift_dates_selected'] = 'Esta ação mudará as datas de {$a} atividades.';
$string['action_shiftdates'] = 'Mudar datas';
$string['actionsforselected'] = 'Ações para os selecionados';
$string['activitiesselected'] = '{$a} activities selected';
$string['activitiesselected_plural'] = ' atividades selecionadas';
$string['activitiesselected_singular'] = ' atividade selecionada';
$string['activity'] = 'Atividade';
$string['activityname'] = 'Nome da atividade';
$string['addtodates'] = 'Adicionar às datas';
$string['ajaxerror'] = 'AJAX HTTP Error';
$string['allowfromdate'] = 'Data de abertura';
$string['allstatuses'] = 'Todos os status';
$string['alltypes'] = 'Todos os tipos';
$string['apply'] = 'Aplicar';
$string['applyreplace'] = 'Aplicar substituição';
$string['back'] = 'Back';
$string['btn_cancel'] = 'Cancelar';
$string['btn_discard'] = 'Descartar';
$string['bulkshiftall'] = 'Mudar datas em massa (Todas)';
$string['buy_pro'] = 'Get the Pro version here!';
$string['cancel'] = 'Cancelar';
$string['clearselection'] = 'Limpar seleção';
$string['confirmdiscard'] = 'Confirmar descarte';
$string['currentdate'] = 'Data atual:';
$string['cutoffdate'] = 'Data limite';
$string['days'] = 'Dias';
$string['direction'] = 'Direção';
$string['discard'] = 'Descartar';
$string['discardchangeswarning'] = 'Tem certeza que deseja descartar todas as alterações não salvas?';
$string['domore'] = 'Discover Pro';
$string['dragdrop_filter_warning'] = 'A reorganização por arrastar e soltar está desativada enquanto os filtros estão ativos. Por favor, limpe os filtros primeiro.';
$string['duedate'] = 'Data de entrega';
$string['error'] = 'Error';
$string['error_date_due_greater_than_cutoff'] = 'A data de entrega não pode ser maior que a data limite.';
$string['error_date_open_greater_than_due'] = 'A data de abertura não pode ser maior que a data de entrega.';
$string['errorajax'] = 'Erro AJAX ao atualizar os registros.';
$string['errorupdate'] = 'Erro ao atualizar os registros do banco de dados.';
$string['example'] = 'Exemplo:';
$string['find'] = 'Localizar';
$string['go_to_settings'] = 'Ir para Configurações';
$string['hidden'] = 'Oculto';
$string['license_activated'] = 'Licença ativada com sucesso.';
$string['license_conn_error'] = 'Erro de conexão: ';
$string['license_empty'] = 'A chave de licença está vazia.';
$string['license_inactive_ajax'] = 'Licença inativa. Por favor, ative sua licença nas configurações do plugin para salvar as alterações.';
$string['license_inactive_desc'] = 'Para usar o Timeshift, ative sua licença nas configurações do plugin.';
$string['license_inactive_title'] = 'Licença Inativa';
$string['license_invalid'] = 'Licença inválida ou expirada.';
$string['license_key'] = 'Chave de Licença';
$string['license_key_desc'] = 'Insira sua chave de licença para ativar o Timeshift.';
$string['license_status_active'] = 'Licença Ativa';
$string['license_status_invalid'] = 'Licença Inválida';
$string['license_status_unset'] = 'Licença não configurada';
$string['license_validated'] = 'Licença validada com sucesso.';
$string['lite_installed'] = 'Installed successfully. Save time managing your course activities!';
$string['modal_delete_cannot_undo'] = 'Esta ação não pode ser desfeita.';
$string['modal_delete_confirm'] = 'Sim, marcar para exclusão';
$string['modal_delete_title'] = 'Excluir atividades';
$string['modal_delete_warning'] = 'Tem certeza que deseja excluir as atividades selecionadas? Isso as removerá permanentemente do curso e excluirá todas as notas e envios dos alunos associados.';
$string['modal_shift_selected_warning'] = 'Esta ação mudará as datas das <strong>{$a} atividades selecionadas</strong>.';
$string['modal_shift_warning'] = 'Esta ação mudará as datas de <strong>todas as {$a} atividades</strong>.';
$string['modulename'] = 'Módulo';
$string['months'] = 'Meses';
$string['newallowfromdate'] = 'Nova data de abertura';
$string['newavailability'] = 'Nova disponibilidade';
$string['newcutoffdate'] = 'Nova data limite';
$string['newdate'] = 'Nova data:';
$string['newduedate'] = 'Nova data de entrega';
$string['notice'] = 'Aviso';
$string['opendate'] = 'Data de abertura';
$string['pagedescription'] = 'Timeshift';
$string['pagedescription_help'] = 'Gerencie datas de abertura, datas de fechamento e restrições para todas as atividades do curso.<br><br>Use os filtros para encontrar itens específicos ou aplicar alterações em massa.<br><br>Você pode usar arrastar e soltar para reordenar os elementos. Seções vazias não serão exibidas.';
$string['pagetitle'] = 'Timeshift';
$string['pending_deletion'] = 'Exclusão pendente';
$string['pluginname'] = 'Timeshift';
$string['pluginname_help'] = 'Manage course dates';
$string['previewchanges'] = 'Visualizar alterações';
$string['privacy:metadata'] = 'O plugin Timeshift não armazena nenhum dado pessoal.';
$string['pro_description'] = 'Unlock advanced features to manage your course activities more efficiently.';
$string['pro_feature_availability_desc'] = 'Change visibility status, stealth mode, or hide dozens of activities quickly.';
$string['pro_feature_availability_title'] = 'Availability Management';
$string['pro_feature_deletion_desc'] = 'Select and delete activities in bulk with security confirmation to prevent accidental data loss.';
$string['pro_feature_deletion_title'] = 'Secure Deletion';
$string['pro_feature_dragdrop_desc'] = 'Reorder activities within your sections and topics using a modern Drag & Drop interface.';
$string['pro_feature_dragdrop_title'] = 'Drag and Drop';
$string['pro_feature_filtering_desc'] = 'Find the exact activities you want to modify in seconds by filtering by type or status.';
$string['pro_feature_filtering_title'] = 'Powerful Filtering';
$string['pro_feature_findreplace_desc'] = 'Find and modify text in the names of all activities. Perfect for updating years ("Exam 2026" to "Exam 2027").';
$string['pro_feature_findreplace_title'] = 'Find and Replace';
$string['pro_feature_restrictions_desc'] = 'Assign or remove access restrictions in bulk with an intuitive, centralized menu.';
$string['pro_feature_restrictions_title'] = 'Restrictions Control';
$string['pro_feature_shift_desc'] = 'Shift due, start, and close dates of all your activities or specific selections forward or backward in seconds.';
$string['pro_feature_shift_title'] = 'Bulk Shift';
$string['pro_installed'] = 'Você tem a versão <strong>Pro</strong> instalada! Aproveite todos os recursos sem limites.';
$string['pro_subtitle'] = 'Forget editing activity by activity. TimeShift saves you hours of configuration.';
$string['pro_title'] = 'Upgrade to Timeshift Pro';
$string['pro_title_part1'] = 'Designed for';
$string['pro_title_part2'] = 'Productivity';
$string['replacementtext'] = 'Texto de substituição...';
$string['replacewith'] = 'Substituir por';
$string['restrictions'] = 'Restrições';
$string['savechanges'] = 'Salvar alterações';
$string['saving'] = 'Salvando...';
$string['searchbyname'] = 'Pesquisar por nome';
$string['section'] = 'Seção';
$string['selectwhattoshift'] = 'Selecione o que mudar';
$string['shiftby'] = 'Mudar em';
$string['shiftdays'] = 'Adicionar/Subtrair dias';
$string['shiftmodaltitle'] = 'Mudar datas em massa';
$string['shiftmodaltitle_help'] = 'Use esta ferramenta para adiantar ou atrasar as datas de todas as atividades em um número específico de dias. Isso é extremamente útil ao reutilizar um curso de um semestre ou ano anterior.<br><br><b>Nota:</b> Se uma atividade não tiver uma data configurada, esta ação não se aplicará a ela.';
$string['status'] = 'Status';
$string['stealth'] = 'Invisível';
$string['subtractfromdates'] = 'Subtrair das datas';
$string['success'] = 'Sucesso';
$string['successsaved'] = 'Alterações salvas com sucesso.';
$string['taskverifylicense'] = 'Verificar o status da licença';
$string['texttofind'] = 'Texto a localizar...';
$string['timeshift:manage'] = 'Manage Timeshift';
$string['totalactivities'] = 'Total de atividades:';
$string['type'] = 'Tipo';
$string['upgrade_button'] = 'Upgrade to Pro';
$string['visible'] = 'Visível';
$string['weeks'] = 'Semanas';
