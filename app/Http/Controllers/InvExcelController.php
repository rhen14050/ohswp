<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExports;

// use App\Model\BasemoldWip;
// use App\Model\FgsRecieve;
// use App\Model\ReworkVisual;
use App\WorkPermitInformation;
use App\Contractor;
use App\ApproverEmailRecipient;
use App\Worker;
use App\OhsRequirements;
use App\Tools;
use App\ContractorContactPerson;






class InvExcelController extends Controller
{
    //

    public function export(Request $request, $id)
    {


    // $work_permit = WorkPermitInformation::where('id',$id)->first();
    $workpermit_soic = WorkPermitInformation:: with([
        'contractor_person_in_charge',
        'contractor_safety_officer_in_charge',
        'contractor_details',
        'approver_in_charge'
        ])
        ->where('id',$id)
        ->first();

    $ohs_requirements = OhsRequirements::where('id',$id)->first();
    $worker = Worker::where('counter',$id)->get();
    $tools = Tools::where('counter',$id)->get();

    $user_approver = ApproverEmailRecipient::with(['project_in_charge_details','safety_officer_in_charge','over_all_safety_officer','hrd_manager','ems_manager'])
    ->where('id', $id)
    ->get();
    // $user_approver = ApproverEmailRecipient::all();


    $e_signature = [
        'project_in_charge'              => $user_approver[0]->project_in_charge_details->employee_number,
        'safety_officer_in_charge_id'              => $user_approver[0]->safety_officer_in_charge->employee_number,
        'over_all_safety_officer_id'           => $user_approver[0]->over_all_safety_officer->employee_number,
        'hrd_manager_id'                   => $user_approver[0]->hrd_manager->employee_number,
        'ems_manager_id'             => $user_approver[0]->ems_manager->employee_number
    ];

    $work_permit_per_dept_iss = WorkPermitInformation::where('division', 'ISS')->get();
    $work_permit_per_dept_ess = WorkPermitInformation::where('division', 'ESS')->get();
    $work_permit_per_dept_hrd = WorkPermitInformation::where('division', 'HRD')->get();
    $work_permit_per_dept_fac = WorkPermitInformation::where('division', 'FAC')->get();
    $work_permit_per_dept_ems = WorkPermitInformation::where('division', 'EMS')->get();
    $work_permit_per_dept_log = WorkPermitInformation::where('division', 'LOG')->get();
    $work_permit_per_dept_ts = WorkPermitInformation::where('division', 'TS')->get();
    $work_permit_per_dept_yf = WorkPermitInformation::where('division', 'YF')->get();
    $work_permit_per_dept_cn = WorkPermitInformation::where('division', 'CN')->get();
    $work_permit_per_dept_pps_ts = WorkPermitInformation::where('division', 'PPS-TS')->get();
    $work_permit_per_dept_pps_cn = WorkPermitInformation::where('division', 'PPS-CN')->get();

    $permit =  $workpermit_soic->permit_number;


    $date = date('Ymd',strtotime(NOW()));

        return Excel::download(new UsersExports($date,$workpermit_soic,$ohs_requirements,$worker,$tools,$user_approver,$e_signature), 'OHS Work Permit - '.$permit.'.xlsx');
    }
}
