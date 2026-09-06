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

$string['action_changeavailability'] = 'تغيير الإتاحة';
$string['action_deleteactivities'] = 'حذف';
$string['action_findreplace'] = 'بحث واستبدال في الأسماء';
$string['action_setallowfromdate'] = 'تعيين تاريخ الفتح';
$string['action_setcutoffdate'] = 'تعيين تاريخ الانقطاع';
$string['action_setduedate'] = 'تعيين تاريخ الاستحقاق';
$string['action_setrestrictions'] = 'تعيين القيود';
$string['action_shift_dates_all'] = 'سيؤدي هذا الإجراء إلى إزاحة التواريخ لجميع الأنشطة.';
$string['action_shift_dates_selected'] = 'سيؤدي هذا الإجراء إلى إزاحة التواريخ لـ {$a} من الأنشطة.';
$string['action_shiftdates'] = 'إزاحة التواريخ';
$string['actionsforselected'] = 'إجراءات للمحدد';
$string['activitiesselected_plural'] = ' أنشطة محددة';
$string['activitiesselected_singular'] = ' نشاط محدد';
$string['activity'] = 'النشاط';
$string['activityname'] = 'اسم النشاط';
$string['addtodates'] = 'إضافة للتواريخ';
$string['allowfromdate'] = 'تاريخ الفتح';
$string['allstatuses'] = 'جميع الحالات';
$string['alltypes'] = 'جميع الأنواع';
$string['apply'] = 'تطبيق';
$string['applyreplace'] = 'تطبيق الاستبدال';
$string['btn_cancel'] = 'إلغاء الأمر';
$string['btn_discard'] = 'إلغاء';
$string['bulkshiftall'] = 'إزاحة جماعية للتواريخ (الكل)';
$string['cancel'] = 'إلغاء';
$string['clearselection'] = 'مسح التحديد';
$string['confirmdiscard'] = 'تأكيد الإلغاء';
$string['currentdate'] = 'التاريخ الحالي:';
$string['cutoffdate'] = 'تاريخ الانقطاع';
$string['days'] = 'أيام';
$string['direction'] = 'الاتجاه';
$string['discard'] = 'تجاهل';
$string['discardchangeswarning'] = 'هل أنت متأكد أنك تريد إلغاء جميع التغييرات غير المحفوظة؟';
$string['dragdrop_filter_warning'] = 'تم تعطيل إعادة الترتيب بالسحب والإفلات أثناء تنشيط عوامل التصفية. يرجى مسح عوامل التصفية أولاً.';
$string['duedate'] = 'تاريخ الاستحقاق';
$string['error_date_due_greater_than_cutoff'] = 'لا يمكن أن يكون تاريخ الاستحقاق أكبر من تاريخ القطع.';
$string['error_date_open_greater_than_due'] = 'لا يمكن أن يكون تاريخ الفتح أكبر من تاريخ الاستحقاق.';
$string['errorajax'] = 'خطأ AJAX أثناء تحديث السجلات.';
$string['errorupdate'] = 'خطأ في تحديث سجلات قاعدة البيانات.';
$string['example'] = 'مثال:';
$string['find'] = 'بحث';
$string['go_to_settings'] = 'الذهاب إلى الإعدادات';
$string['hidden'] = 'مخفي';
$string['license_activated'] = 'تم تفعيل الترخيص بنجاح.';
$string['license_conn_error'] = 'خطأ في الاتصال: ';
$string['license_empty'] = 'مفتاح الترخيص فارغ.';
$string['license_inactive_ajax'] = 'ترخيص غير نشط. يرجى تفعيل ترخيصك في إعدادات الإضافة لحفظ التغييرات.';
$string['license_inactive_desc'] = 'لاستخدام Timeshift، يرجى تفعيل ترخيصك في إعدادات الإضافة.';
$string['license_inactive_title'] = 'ترخيص غير نشط';
$string['license_invalid'] = 'ترخيص غير صالح أو منتهي الصلاحية.';
$string['license_key'] = 'مفتاح الترخيص';
$string['license_key_desc'] = 'أدخل مفتاح الترخيص الخاص بك لتفعيل Timeshift.';
$string['license_status_active'] = 'ترخيص نشط';
$string['license_status_invalid'] = 'ترخيص غير صالح';
$string['license_status_unset'] = 'الترخيص غير مكوّن';
$string['license_validated'] = 'تم التحقق من الترخيص بنجاح.';
$string['modal_delete_cannot_undo'] = 'لا يمكن التراجع عن هذا الإجراء.';
$string['modal_delete_confirm'] = 'نعم، وضع علامة للحذف';
$string['modal_delete_title'] = 'حذف الأنشطة';
$string['modal_delete_warning'] = 'هل أنت متأكد أنك تريد حذف الأنشطة المحددة؟ سيؤدي هذا إلى إزالتها نهائيًا من المقرر الدراسي وحذف جميع درجات وتسليمات الطلاب المرتبطة بها.';
$string['modal_shift_selected_warning'] = 'سيؤدي هذا الإجراء إلى إزاحة التواريخ للأنشطة المحددة (<strong>{$a}</strong>).';
$string['modal_shift_warning'] = 'سيؤدي هذا الإجراء إلى إزاحة التواريخ لجميع الأنشطة (<strong>{$a}</strong>).';
$string['modulename'] = 'الوحدة';
$string['months'] = 'أشهر';
$string['newallowfromdate'] = 'تاريخ الفتح الجديد';
$string['newavailability'] = 'الإتاحة الجديدة';
$string['newcutoffdate'] = 'تاريخ الانقطاع الجديد';
$string['newdate'] = 'التاريخ الجديد:';
$string['newduedate'] = 'تاريخ الاستحقاق الجديد';
$string['notice'] = 'ملاحظة';
$string['opendate'] = 'تاريخ الفتح';
$string['pagedescription'] = 'Timeshift';
$string['pagedescription_help'] = 'إدارة تواريخ الفتح، تواريخ الإغلاق، والقيود لجميع أنشطة المقرر الدراسي.<br><br>استخدم الفلاتر للعثور على عناصر معينة أو تطبيق التغييرات بشكل جماعي.<br><br>يمكنك السحب والإفلات لإعادة ترتيب العناصر. لن يتم عرض الأقسام الفارغة.';
$string['pagetitle'] = 'Timeshift';
$string['pending_deletion'] = 'في انتظار الحذف';
$string['pluginname'] = 'Timeshift';
$string['previewchanges'] = 'معاينة التغييرات';
$string['privacy:metadata'] = 'لا يقوم المكون الإضافي Timeshift بتخزين أي بيانات شخصية.';
$string['pro_installed'] = 'لقد قمت بتثبيت إصدار <strong>Pro</strong>! استمتع بجميع الميزات بلا حدود.';
$string['replacementtext'] = 'نص الاستبدال...';
$string['replacewith'] = 'استبدال بـ';
$string['restrictions'] = 'القيود';
$string['savechanges'] = 'حفظ التغييرات';
$string['saving'] = 'جارٍ الحفظ...';
$string['searchbyname'] = 'البحث بالاسم';
$string['section'] = 'القسم';
$string['selectwhattoshift'] = 'حدد ما سيتم إزاحته';
$string['shiftby'] = 'مقدار الإزاحة';
$string['shiftdays'] = 'إضافة/طرح أيام';
$string['shiftmodaltitle'] = 'إزاحة جماعية للتواريخ';
$string['shiftmodaltitle_help'] = 'استخدم هذه الأداة لتقديم أو تأخير تواريخ جميع الأنشطة بعدد معين من الأيام. هذا مفيد للغاية عند إعادة استخدام مقرر دراسي من فصل أو عام سابق.<br><br><b>ملاحظة:</b> إذا لم يتم تكوين تاريخ لنشاط ما، فلن يتم تطبيق هذا الإجراء عليه.';
$string['status'] = 'الحالة';
$string['stealth'] = 'مخفي (Stealth)';
$string['subtractfromdates'] = 'طرح من التواريخ';
$string['success'] = 'نجاح';
$string['successsaved'] = 'تم حفظ التغييرات بنجاح.';
$string['taskverifylicense'] = 'التحقق من حالة الترخيص';
$string['texttofind'] = 'النص المراد البحث عنه...';
$string['totalactivities'] = 'إجمالي الأنشطة:';
$string['type'] = 'النوع';
$string['visible'] = 'مرئي';
$string['weeks'] = 'أسابيع';
