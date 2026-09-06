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

$string['action_changeavailability'] = 'Изменить доступность';
$string['action_deleteactivities'] = 'Удалить';
$string['action_findreplace'] = 'Найти и заменить в названиях';
$string['action_setallowfromdate'] = 'Установить дату открытия';
$string['action_setcutoffdate'] = 'Установить дату закрытия';
$string['action_setduedate'] = 'Установить срок сдачи';
$string['action_setrestrictions'] = 'Установить ограничения';
$string['action_shift_dates_all'] = 'Это действие сдвинет даты для всех элементов курса.';
$string['action_shift_dates_selected'] = 'Это действие сдвинет даты для {$a} элементов курса.';
$string['action_shiftdates'] = 'Сдвинуть даты';
$string['actionsforselected'] = 'Действия для выбранных';
$string['activitiesselected'] = '{$a} activities selected';
$string['activitiesselected_plural'] = ' элементов курса выбрано';
$string['activitiesselected_singular'] = ' элемент курса выбран';
$string['activity'] = 'Элемент курса';
$string['activityname'] = 'Название элемента курса';
$string['addtodates'] = 'Добавить к датам';
$string['ajaxerror'] = 'AJAX HTTP Error';
$string['allowfromdate'] = 'Дата открытия';
$string['allstatuses'] = 'Все статусы';
$string['alltypes'] = 'Все типы';
$string['apply'] = 'Применить';
$string['applyreplace'] = 'Применить замену';
$string['back'] = 'Назад';
$string['btn_cancel'] = 'Отмена';
$string['btn_discard'] = 'Отменить';
$string['bulkshiftall'] = 'Массовый сдвиг дат (Все)';
$string['buy_pro'] = 'Get the Pro version here!';
$string['cancel'] = 'Отмена';
$string['clearselection'] = 'Очистить выделение';
$string['confirmdiscard'] = 'Подтвердить отмену';
$string['currentdate'] = 'Текущая дата:';
$string['cutoffdate'] = 'Дата закрытия';
$string['days'] = 'Дни';
$string['direction'] = 'Направление';
$string['discard'] = 'Отменить изменения';
$string['discardchangeswarning'] = 'Вы уверены, что хотите отменить все несохраненные изменения?';
$string['domore'] = 'Узнать о Pro';
$string['dragdrop_filter_warning'] = 'Перетаскивание отключено при активных фильтрах. Пожалуйста, сначала очистите фильтры.';
$string['duedate'] = 'Срок сдачи';
$string['error'] = 'Error';
$string['error_date_due_greater_than_cutoff'] = 'Срок сдачи не может быть позже крайнего срока.';
$string['error_date_open_greater_than_due'] = 'Дата открытия не может быть позже срока сдачи.';
$string['errorajax'] = 'Ошибка AJAX при обновлении записей.';
$string['errorupdate'] = 'Ошибка обновления записей базы данных.';
$string['example'] = 'Пример:';
$string['find'] = 'Найти';
$string['go_to_settings'] = 'Перейти к настройкам';
$string['hidden'] = 'Скрыто';
$string['license_activated'] = 'Лицензия успешно активирована.';
$string['license_conn_error'] = 'Ошибка подключения: ';
$string['license_empty'] = 'Лицензионный ключ пуст.';
$string['license_inactive_ajax'] = 'Неактивная лицензия. Пожалуйста, активируйте вашу лицензию в настройках плагина, чтобы сохранить изменения.';
$string['license_inactive_desc'] = 'Для использования Timeshift активируйте вашу лицензию в настройках плагина.';
$string['license_inactive_title'] = 'Неактивная лицензия';
$string['license_invalid'] = 'Недействительная или просроченная лицензия.';
$string['license_key'] = 'Лицензионный ключ';
$string['license_key_desc'] = 'Введите ваш лицензионный ключ для активации Timeshift.';
$string['license_status_active'] = 'Активная лицензия';
$string['license_status_invalid'] = 'Недействительная лицензия';
$string['license_status_unset'] = 'Лицензия не настроена';
$string['license_validated'] = 'Лицензия успешно проверена.';
$string['lite_installed'] = 'Installed successfully. Save time managing your course activities!';
$string['modal_delete_cannot_undo'] = 'Это действие нельзя отменить.';
$string['modal_delete_confirm'] = 'Да, пометить на удаление';
$string['modal_delete_title'] = 'Удалить элементы курса';
$string['modal_delete_warning'] = 'Вы уверены, что хотите удалить выбранные элементы курса? Это навсегда удалит их из курса и удалит все связанные оценки студентов и ответы.';
$string['modal_shift_selected_warning'] = 'Это действие сдвинет даты для <strong>{$a} выбранных элементов курса</strong>.';
$string['modal_shift_warning'] = 'Это действие сдвинет даты для <strong>всех {$a} элементов курса</strong>.';
$string['modulename'] = 'Модуль';
$string['months'] = 'Месяцы';
$string['newallowfromdate'] = 'Новая дата открытия';
$string['newavailability'] = 'Новая доступность';
$string['newcutoffdate'] = 'Новая дата закрытия';
$string['newdate'] = 'Новая дата:';
$string['newduedate'] = 'Новый срок сдачи';
$string['notice'] = 'Уведомление';
$string['opendate'] = 'Дата открытия';
$string['pagedescription'] = 'Timeshift';
$string['pagedescription_help'] = 'Управляйте датами открытия, датами закрытия и ограничениями для всех элементов курса.<br><br>Используйте фильтры, чтобы найти определенные элементы или применить изменения массово.<br><br>Вы можете использовать перетаскивание, чтобы изменить порядок элементов. Пустые разделы не будут показаны.';
$string['pagetitle'] = 'Timeshift';
$string['pending_deletion'] = 'Ожидает удаления';
$string['pluginname'] = 'Timeshift';
$string['pluginname_help'] = 'Manage course dates';
$string['previewchanges'] = 'Предварительный просмотр изменений';
$string['privacy:metadata'] = 'Плагин Timeshift не хранит никаких личных данных.';
$string['pro_description'] = 'Откройте расширенные функции для более эффективного управления вашими курсами.';
$string['pro_feature_availability_desc'] = 'Изменяйте статус видимости, скрытый режим или скрывайте десятки активностей мгновенно.';
$string['pro_feature_availability_title'] = 'Управление доступностью';
$string['pro_feature_deletion_desc'] = 'Выбирайте и удаляйте активности массово с подтверждением безопасности.';
$string['pro_feature_deletion_title'] = 'Безопасное удаление';
$string['pro_feature_dragdrop_desc'] = 'Переупорядочивайте активности в разделах с помощью современного интерфейса Drag & Drop.';
$string['pro_feature_dragdrop_title'] = 'Drag and Drop';
$string['pro_feature_filtering_desc'] = 'Находите нужные активности за секунды с помощью фильтрации по типу или статусу.';
$string['pro_feature_filtering_title'] = 'Мощная фильтрация';
$string['pro_feature_findreplace_desc'] = 'Находите и изменяйте текст в названиях всех активностей. Идеально для обновления годов.';
$string['pro_feature_findreplace_title'] = 'Найти и заменить';
$string['pro_feature_restrictions_desc'] = 'Назначайте или удаляйте ограничения доступа массово через интуитивное меню.';
$string['pro_feature_restrictions_title'] = 'Управление ограничениями';
$string['pro_feature_shift_desc'] = 'Сдвигайте даты начала, окончания и сроки сдачи всех ваших активностей вперед или назад за секунды.';
$string['pro_feature_shift_title'] = 'Массовый сдвиг';
$string['pro_installed'] = 'У вас установлена версия <strong>Pro</strong>! Наслаждайтесь всеми функциями без ограничений.';
$string['pro_subtitle'] = 'Забудьте о редактировании каждой активности. TimeShift экономит вам часы настройки.';
$string['pro_title'] = 'Обновить до Timeshift Pro';
$string['pro_title_part1'] = 'Создано для';
$string['pro_title_part2'] = 'Продуктивности';
$string['replacementtext'] = 'Текст для замены...';
$string['replacewith'] = 'Заменить на';
$string['restrictions'] = 'Ограничения';
$string['savechanges'] = 'Сохранить изменения';
$string['saving'] = 'Сохранение...';
$string['searchbyname'] = 'Поиск по названию';
$string['section'] = 'Раздел';
$string['selectwhattoshift'] = 'Выберите, что сдвинуть';
$string['shiftby'] = 'Сдвинуть на';
$string['shiftdays'] = 'Добавить/Вычесть дни';
$string['shiftmodaltitle'] = 'Массовый сдвиг дат';
$string['shiftmodaltitle_help'] = 'Используйте этот инструмент, чтобы сдвинуть все даты элементов курса вперед или назад на определенное количество дней. Это чрезвычайно полезно при повторном использовании курса из предыдущего семестра или года.<br><br><b>Примечание:</b> Если для элемента курса не настроена дата, это действие к нему не применяется.';
$string['status'] = 'Статус';
$string['stealth'] = 'Невидимый';
$string['subtractfromdates'] = 'Вычесть из дат';
$string['success'] = 'Успешно';
$string['successsaved'] = 'Изменения успешно сохранены.';
$string['taskverifylicense'] = 'Проверить статус лицензии';
$string['texttofind'] = 'Текст для поиска...';
$string['timeshift:manage'] = 'Manage Timeshift';
$string['totalactivities'] = 'Всего элементов курса:';
$string['type'] = 'Тип';
$string['upgrade_button'] = 'Обновить до Pro';
$string['visible'] = 'Видимый';
$string['weeks'] = 'Недели';
