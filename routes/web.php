<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/contractors_management', function () {
    return view('contractors_management');
})->name('contractors_management');

Route::get('/work_permit_management', function () {
    return view('work_permit_management');
})->name('work_permit_management');

Route::get('/user_approver_management', function () {
    return view('user_approver_management');
})->name('user_approver_management');

//===== DASHBOARD =====//
Route::get('/get_total_contractor', 'ContractorController@get_total_contractor');
Route::get('/get_total_urgent_work_list', 'WorkPermitController@get_total_urgent_work_list');
Route::get('/get_total_normal_work_list', 'WorkPermitController@get_total_normal_work_list');


//===== CONTRACTOR CONTROLLER (CONTRACTOR MANAGEMENT TAB) =====//
Route::post('/add_contractor', 'ContractorController@add_contractor');
Route::get('/view_contractors', 'ContractorController@view_contractors');
Route::get('/get_contractor', 'ContractorController@get_contractor');
Route::post('/edit_contractor', 'ContractorController@edit_contractor');
Route::get('/get_id_edit_contractor', 'ContractorController@get_id_edit_contractor');
Route::post('/deactivate_contractor', 'ContractorController@deactivate_contractor');
Route::post('/activate_contractor', 'ContractorController@activate_contractor');


//===CONTRACTOR CONTROLLER (CONTACT MANAGEMENT TAB) ===
Route::post('/add_contractor_contact', 'ContractorController@add_contractor_contact');
Route::get('/view_contractors_contact', 'ContractorController@view_contractors_contact');
Route::post('/edit_contractor_contact', 'ContractorController@edit_contractor_contact');
Route::get('/get_id_edit_contractor_contact', 'ContractorController@get_id_edit_contractor_contact');
Route::post('/deactivate_contractor_contact', 'ContractorController@deactivate_contractor_contact');
Route::post('/activate_contractor_contact', 'ContractorController@activate_contractor_contact');



//===== WORK PERMIT CONTROLLER =====//
Route::get('/view_work_permit', 'WorkPermitController@view_work_permit');
Route::get('/get_contractorID', 'WorkPermitController@get_contractorID');
Route::post('/add_work_permit', 'WorkPermitController@add_work_permit');
Route::post('/add_work_permit', 'WorkPermitController@add_work_permit');
Route::get('/get_contact_person_in_charge', 'WorkPermitController@get_contact_person_in_charge');
Route::get('/get_contact_safety_officer_in_charge', 'WorkPermitController@get_contact_safety_officer_in_charge');
Route::get('/get_work_permit_id_to_view', 'WorkPermitController@get_work_permit_id_to_view');
// Route::get('/get_project_in_charge', 'WorkPermitController@get_project_in_charge');
Route::get('/get_safety_officer_in_charge', 'WorkPermitController@get_safety_officer_in_charge');
Route::get('/get_overall_safety_officer', 'WorkPermitController@get_overall_safety_officer');
Route::get('/get_hrd_manager', 'WorkPermitController@get_hrd_manager');
Route::get('/get_ems_manager', 'WorkPermitController@get_ems_manager');
Route::get('/get_rapidx_user', 'WorkPermitController@get_rapidx_user');
Route::get('/get_rapidx_user_department', 'WorkPermitController@get_rapidx_user_department');
Route::get('/get_local_no', 'WorkPermitController@get_local_no');
Route::get('/get_counter', 'WorkPermitController@get_counter');
Route::get('/get_work_permit_id_to_edit', 'WorkPermitController@get_work_permit_id_to_edit');
Route::post('/approved_work_permit', 'WorkPermitController@approved_work_permit')->name('approved_work_permit');
Route::post('/not_clear_work_permit', 'WorkPermitController@not_clear_work_permit')->name('not_clear_work_permit');
Route::post('/add_ohs_requirements', 'WorkPermitController@add_ohs_requirements');
Route::post('/edit_ohs_work_permit', 'WorkPermitController@edit_ohs_work_permit');
Route::post('/delete_work_permit', 'WorkPermitController@delete_work_permit');
Route::get('/download_attach_file/{id}', 'WorkPermitController@download_attach_file');


Route::post('/extend_work_permit', 'WorkPermitController@extend_work_permit');
Route::get('/get_work_permit_id_to_extend', 'WorkPermitController@get_work_permit_id_to_extend');



//===== USER APPROVER CONTROLLER CONTROLLER =====//
Route::get('/view_user_approver', 'UserApproverController@view_user_approver');
Route::post('/add_user_approver', 'UserApproverController@add_user_approver');
Route::post('/deactivate_approver', 'UserApproverController@deactivate_approver');
Route::post('/activate_approver', 'UserApproverController@activate_approver');
Route::get('/load_rapidx_user_list', 'UserApproverController@load_rapidx_user_list');
Route::post('/edit_approver', 'UserApproverController@edit_approver');
Route::get('/get_approver_by_id', 'UserApproverController@get_approver_by_id');


Route::get('/export/{id}', 'InvExcelController@export');
Route::get('/export_summary/{year_id}/{selected_month}', 'ExportSummaryReportController@export_summary');



Route::get('/view_all_work_permit', 'WorkPermitController@view_all_work_permit');


// USER CONTROLLER
// Route::post('/sign_in', 'UserController@sign_in')->name('sign_in');
// Route::post('/sign_out', 'UserController@sign_out')->name('sign_out');
// Route::post('/change_pass', 'UserController@change_pass')->name('change_pass');
// Route::post('/change_user_stat', 'UserController@change_user_stat')->name('change_user_stat');
// Route::get('/view_users', 'UserController@view_users');
// Route::post('/add_user', 'UserController@add_user');
// Route::get('/get_user_by_id', 'UserController@get_user_by_id');
// Route::get('/get_user_list', 'UserController@get_user_list');
// Route::get('/get_user_by_batch', 'UserController@get_user_by_batch');
// Route::get('/get_user_by_stat', 'UserController@get_user_by_stat');
// Route::post('/edit_user', 'UserController@edit_user');
// Route::post('/reset_password', 'UserController@reset_password');
// Route::get('/generate_user_qrcode', 'UserController@generate_user_qrcode');
// Route::post('/import_user', 'UserController@import_user');
