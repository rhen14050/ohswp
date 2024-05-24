<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\WorkPermitInformation;
use App\Contractor;
use App\ContractorContactPerson;
use App\Worker;
use App\Tools;
use App\UserApprover;
use App\RapidXUser;
use App\RapidXDepartment;
use App\SystemOnePhoneDirectory;
use App\ApproverEmailRecipient;
use App\OhsRequirements;
use DataTables;
use Carbon\Carbon;
use App\Mail\ApproverMail;


use Illuminate\Support\Facades\Mail;
// use Mail;
// use Auth;

class WorkPermitController extends Controller
{

    public function get_total_urgent_work_list(){
        $totalWorkUrgent = WorkPermitInformation::where('logdel', 0 )
        ->where('classification', 1)
        ->get();

        $totalWorkUrgent = count($totalWorkUrgent);
        return response()->json(['totalUrgentWork' => $totalWorkUrgent]);
    }

    public function get_total_normal_work_list(){
        $totalWorkNormal = WorkPermitInformation::where('logdel', 0)
        ->where('classification', 0)
        ->get();

        $totalWorkNormal = count($totalWorkNormal);
        return response()->json(['totalNormalWork' => $totalWorkNormal]);
    }

    public function get_contractorID(Request $request){
        $contractors = Contractor::all();
        return response()->json(['contractor' => $contractors]);
    }

    public function get_contact_person_in_charge(Request $request){
        $contact_persons = ContractorContactPerson::where('company_id', $request->contractorId)
        ->where('classification', 0)
        ->get();

        return response()->json(['contact_person' => $contact_persons]);
    }

    public function get_contact_safety_officer_in_charge(Request $request){
        $contact_persons = ContractorContactPerson::where('company_id', $request->contractorId)
        ->where('classification', 1)
        ->get();

        return response()->json(['contact_person' => $contact_persons]);
    }


//===== DISPLAY DATATABLES OF CONTRACTORS =====//
public function view_work_permit(Request $request)
{
    session_start();
    $rapidx_user_id = $_SESSION['rapidx_user_id'];
    $rapidx_user_name = $_SESSION['rapidx_name'];


        // return $approver;

    // $workpermit = WorkPermitInformation::with([
    //     'approver_in_charge',
    //     'approver_in_charge.safety_officer_in_charge',
    //     'approver_in_charge.over_all_safety_officer',
    //     'approver_in_charge.hrd_manager',
    //     'approver_in_charge.ems_manager',
    //     'contractor_id_name'
    //     ])
        //     ->where('logdel', 0)
    //     ->orderBy('id', 'DESC')
    //     ->get();

    $approver = ApproverEmailRecipient::
    with([
        'work_permit_details',
        'work_permit_details.contractor_id_name'
    ])
    // ->whereHas('work_permit_details', function ($query) {

    //    $query->where('logdel','=',1);
    // })
    ->where('logdel', 0)
    ->where('safety_officer_in_charge_id', $rapidx_user_id)
    ->orWhere('over_all_safety_officer_id', $rapidx_user_id)
    ->orWhere('hrd_manager_id', $rapidx_user_id)
    ->orWhere('ems_manager_id', $rapidx_user_id)
    ->orWhere('project_in_charge', $rapidx_user_name)
    ->orderBy('id', 'DESC')
    ->get();

    // return $approver;

    // if($approver != ''){
        $approver = collect($approver)
        ->whereIn('work_permit_details.logdel',['0'])
        ;

        if(isset($request->approved)){
            $approver = collect($approver)->whereIn('work_permit_details.status',['8','14']);
        }

        if(isset($request->forApproval)){
            $approver = collect($approver)->whereIn('work_permit_details.status',['0','1','2','3','4','5','6','7']);
        }
    // }


    // return $approver;

    // if(isset($request->forMyApproval)){
    //     $approver = ApproverEmailRecipient::whereHas('work_permit_details', function($q) use ($rapidx_user_id){
    //         $q->where('hrd_manager_id','LIKE', $rapidx_user_id);
    //     })->get();

    //     // return $approver;
    // }


        // //first approver
        // $pic_approver = $approver[0]->pic_apprv_date_time;
        // // $pic_approver = date('F d, Y h:i:s A',strtotime($pic_approver));

        // $soic_approver = $approver[0]->soic_apprv_date_time;
        // // $soic_approver = date('F d, Y h:i:s A',strtotime($soic_approver));

        // $oaso_approver = $approver[0]->oaso_apprv_date_time;
        // // $oaso_approver = date('F d, Y h:i:s A',strtotime($oaso_approver));

        // $hrd_approver = $approver[0]->hrd_apprv_date_time;
        // // $hrd_approver = date('F d, Y h:i:s A',strtotime($hrd_approver));
        // //first approver


        // //second approver
        // $soic_approver2 = $approver[0]->soic_apprv_date_time2;
        // // $soic_approver2 = date('F d, Y h:i:s A',strtotime($soic_approver2));

        // $ems_approver = $approver[0]->ems_apprv_date_time;
        // // $ems_approver = date('F d, Y h:i:s A',strtotime($ems_approver));

        // $oaso_approver2 = $approver[0]->oaso_apprv_date_time2;
        // // $oaso_approver2 = date('F d, Y h:i:s A',strtotime($oaso_approver2));

        // $hrd_approver2 = $approver[0]->hrd_apprv_date_time2;
        // // $hrd_approver2 = date('F d, Y h:i:s A',strtotime($hrd_approver2));



    return DataTables::of($approver)

    ->addColumn('status', function ($approver) {
        $result = "";
        $result = '<center>';
        // if($approver != ''){
            if($approver->work_permit_details->status == 0){
                $result .= '<span class="badge badge-pill badge-warning">Approval of</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">Person in-Charge</span>';
            }else if($approver->work_permit_details->status == 1){
                $result .= '<span class="badge badge-pill badge-warning">Approval of</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">Safety Officer in-Charge</span>';
            }else if($approver->work_permit_details->status == 2){
                $result .= '<span class="badge badge-pill badge-warning">Approval of</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">Over-all Safety Officer</span>';
            }
            else if($approver->work_permit_details->status == 3){
                $result .= '<span class="badge badge-pill badge-warning">Approval of</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">HRD Manager</span>';
            }
            else if($approver->work_permit_details->status == 4){
                $result .= '<span class="badge badge-pill badge-success">Work Permit Approved</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">Waiting for Clearance</span>';
            }
            else if($approver->work_permit_details->status == 5){
                $result .= '<span class="badge badge-pill badge-success">Work Permit Cleared</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">Approval of EMS Manager</span>';
            }
            else if($approver->work_permit_details->status == 6){
                $result .= '<span class="badge badge-pill badge-success">Work Permit Approved</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">Approval of</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">Over-All Safety Officer</span>';

            }
            else if($approver->work_permit_details->status == 7){
                $result .= '<span class="badge badge-pill badge-success">Work Permit Approved</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">Approval of HRD Manager-</span>';
            }
            else if($approver->work_permit_details->status == 8){
                $result .= '<span class="badge badge-pill badge-success">Work Permit Done</span>';
            }
            else if($approver->work_permit_details->status == 9){
                $result .= '<span class="badge badge-pill badge-secondary">Work Permit Extended</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">For Approval of Over-all Safety Officer</span>';
            }

            else if($approver->work_permit_details->status == 10){
                $result .= '<span class="badge badge-pill badge-success">Work Permit Extended</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">Waiting for Clearance</span>';
            }

            else if($approver->work_permit_details->status == 11){
                $result .= '<span class="badge badge-pill badge-success">Work Permit Cleared</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">Approval of EMS Manager</span>';
            }

            else if($approver->work_permit_details->status == 12){
                $result .= '<span class="badge badge-pill badge-success">Work Permit Approved</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">Approval of</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">Over-All Safety Officer</span>';

            }

            else if($approver->work_permit_details->status == 13){
                $result .= '<span class="badge badge-pill badge-success">Work Permit Approved</span>';
                $result .='<br>';
                $result .= '<span class="badge badge-pill badge-warning">Approval of HRD Manager-</span>';
            }

            else if($approver->work_permit_details->status == 14){
                $result .= '<span class="badge badge-pill badge-success">Work Permit Done</span>';
                $result .= '<span class="badge badge-pill badge-success">Work Permit Extended</span>';
            }
        // }else{
        //     $result .= '';
        // }
            return $result;
    })
    // ->addColumn('classification', function ($approver){
    //     $result = "";
    //     $result = '<center>';
    //     if($approver->classification == 0){
    //         $result = '<center><span class="badge badge-pill badge-primary">Normal</span></center>';
    //     } else if ($approver->classification == 1) {
    //         $result = '<center><span class="badge badge-pill badge-danger">Urgent</span></center>';
    //     }
    //     return $result;

    // })
    ->addColumn('approver', function ($approver){
        $result = "";
        $result = '<center>';
        // if($approver != ''){
            switch($approver->work_permit_details->status){
                case 0:
                {

                    $result .= '<span class="badge badge-pill badge-warning"> '.$approver->project_in_charge.'</span>';
                    $result .= '<br>';

                    $result .= '<span class="badge badge-pill badge-light"> '.$approver->safety_officer_in_charge->name.'</span>';
                    $result .= '<br>';

                    $result .= '<span class="badge badge-pill badge-light"> '.$approver->over_all_safety_officer->name.'</span>';
                    $result .= '<br>';

                    $result .= '<span class="badge badge-pill badge-light"> '.$approver->hrd_manager->name.'</span>';

                    break;
                }

                case 1:
                {

                    $result .= '<span class="badge badge-pill badge-success"> '.$approver->project_in_charge.'</span>';
                    $result .= '<br>';
                    $result .= ''.$approver->pic_apprv_date_time.'';
                    $result .= '<br>';

                    $result .= '<span class="badge badge-pill badge-warning"> '.$approver->safety_officer_in_charge->name.'</span>';
                    $result .= '<br>';

                    $result .= '<span class="badge badge-pill badge-light"> '.$approver->over_all_safety_officer->name.'</span>';
                    $result .= '<br>';
                    $result .= '<span class="badge badge-pill badge-light"> '.$approver->hrd_manager->name.'</span>';
                    break;
                }
                case 2:
                    {

                        $result .= '<span class="badge badge-pill badge-success"> '.$approver->project_in_charge.'</span>';
                        $result .= '<br>';
                        $result .= ''.$approver->pic_apprv_date_time.'';
                        $result .= '<br>';

                        $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                        $result .= '<br>';
                        $result .= ''.$approver->soic_apprv_date_time.'';
                        $result .= '<br>';

                        $result .= '<span class="badge badge-pill badge-warning"> '.$approver->over_all_safety_officer->name.'</span>';
                        $result .= '<br>';

                        $result .= '<span class="badge badge-pill badge-light"> '.$approver->hrd_manager->name.'</span>';
                        break;
                    }
                    case 3:
                        {

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->project_in_charge.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->pic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->soic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->oaso_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-warning"> '.$approver->hrd_manager->name.'</span>';


                            break;
                        }

                case 4:
                    {

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->project_in_charge.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->pic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->soic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->oaso_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->hrd_manager->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->hrd_apprv_date_time.'';

                        break;
                    }
                case 5:
                    {
                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->project_in_charge.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->pic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->soic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->oaso_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->hrd_manager->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->hrd_apprv_date_time.'';
                        break;
                    }
                case 6:
                    {

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->project_in_charge.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->pic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->soic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->oaso_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->hrd_manager->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->hrd_apprv_date_time.'';
                        break;
                    }
                case 7:
                    {
                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->project_in_charge.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->pic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->soic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->oaso_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->hrd_manager->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->hrd_apprv_date_time.'';
                        break;
                    }
                case 8:
                    {
                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->project_in_charge.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->pic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->soic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->oaso_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->hrd_manager->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->hrd_apprv_date_time.'';
                        break;
                    }

                    case 9:
                        {
                            // $result .= '<span class="badge badge-pill badge-secondary">Work Permit Extended</span>';
                            // $result .= '<br>';
                            $result .= '<span class="badge badge-pill badge-warning"> '.$approver->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';

                            break;
                        }
                    case 10:
                        {
                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->project_in_charge.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->pic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            // $result .= ' '.$soic_approver  .'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                            // $result .= ' '.$oaso_approver  .'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->hrd_manager->name.'</span>';
                            // $result .= ' '.$hrd_approver  .'';
                            // $result .= '<br>';
                            // $result .= '<span class="badge badge-pill badge-warning"> '.$approver->safety_officer_in_charge->name.'</span>';
                            break;
                        }
                    case 11:
                        {
                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->project_in_charge.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->pic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->soic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->wp_extended_apprv_date_time_oaso.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->hrd_manager->name.'</span>';
                            // $result .= '<br>';
                            // $result .= ''.$approver->hrd_apprv_date_time.'';
                            break;
                        }
                    case 12:
                        {
                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->project_in_charge.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->pic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->soic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->wp_extended_apprv_date_time_oaso.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->hrd_manager->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->hrd_apprv_date_time.'';
                            break;
                        }
                    case 13:
                        {
                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->project_in_charge.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->pic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->soic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->wp_extended_apprv_date_time_oaso.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->hrd_manager->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->hrd_apprv_date_time.'';
                            break;
                        }
                    case 14:
                        {
                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->project_in_charge.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->pic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->soic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->wp_extended_apprv_date_time_oaso.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->hrd_manager->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->hrd_apprv_date_time.'';
                            break;
                        }
            }
        // }else{
        //     $result .= '';
        // }


        return $result;

    })

    ->addColumn('start_date', function ($approver){
        // if($approver != ''){
            $status = $approver->work_permit_details->status;
            if ($status > 8){
                $result = "";
                $date = $approver->work_permit_details->prolong_start_date;
                $result .= Carbon::parse($date)->format('M d, Y');

                return $result;
            }else{
                $result = "";
                $date = $approver->work_permit_details->start_date;
                $result .= Carbon::parse($date)->format('M d, Y');

                return $result;
            }
        // }else{
        //     $result .= '';
        // }
    })

    ->addColumn('end_date', function ($approver){
        // $result = "";
        // $date = $approver->work_permit_details->end_date;
        // $result .= Carbon::parse($date)->format('M d, Y');

        // return $result;

        // if($approver != ''){
            $status = $approver->work_permit_details->status;
            if ($status > 8){
                $result = "";
                $date = $approver->work_permit_details->prolong_end_date;
                $result .= Carbon::parse($date)->format('M d, Y');

                return $result;
            }else{
                $result = "";
                $date = $approver->work_permit_details->end_date;
                $result .= Carbon::parse($date)->format('M d, Y');

                return $result;
            }
        // }else{
        //     $result .= '';
        // }
    })

    ->addColumn('clearance', function ($approver){
        $result = "";
        $result = '<center>';
        // if($approver != ''){
            switch($approver->work_permit_details->status)
            {
                case 4:
                {
                    $result .= '<span class="badge badge-pill badge-warning"> '.$approver->safety_officer_in_charge->name.'</span>';
                    $result .= '<br>';

                    $result .= '<span class="badge badge-pill badge-light"> '.$approver->ems_manager->name.'</span>';
                    $result .= '<br>';
                    $result .= '<span class="badge badge-pill badge-light"> '.$approver->over_all_safety_officer->name.'</span>';
                    $result .= '<br>';
                    $result .= '<span class="badge badge-pill badge-light"> '.$approver->hrd_manager->name.'</span>';
                    break;
                }

                case 5:
                    {

                        $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                        $result .= '<br>';
                        $result .= ''.$approver->soic_apprv_date_time2.'';
                        $result .= '<br>';

                        $result .= '<span class="badge badge-pill badge-warning"> '.$approver->ems_manager->name.'</span>';
                        $result .= '<br>';
                        $result .= '<span class="badge badge-pill badge-light"> '.$approver->over_all_safety_officer->name.'</span>';
                        $result .= '<br>';
                        $result .= '<span class="badge badge-pill badge-light"> '.$approver->hrd_manager->name.'</span>';
                        break;
                    }

                case 6:
                    {
                        $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                        $result .= '<br>';
                        $result .= ''.$approver->soic_apprv_date_time2.'';
                        $result .= '<br>';

                        $result .= '<span class="badge badge-pill badge-success"> '.$approver->ems_manager->name.'</span>';
                        $result .= '<br>';
                        $result .= ''.$approver->ems_apprv_date_time.'';
                        $result .= '<br>';

                        $result .= '<span class="badge badge-pill badge-warning"> '.$approver->over_all_safety_officer->name.'</span>';
                        $result .= '<br>';
                        $result .= '<span class="badge badge-pill badge-light"> '.$approver->hrd_manager->name.'</span>';
                        break;
                    }

                case 7:
                    {
                        $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                        $result .= '<br>';
                        $result .= ''.$approver->soic_apprv_date_time2.'';
                        $result .= '<br>';

                        $result .= '<span class="badge badge-pill badge-success"> '.$approver->ems_manager->name.'</span>';
                        $result .= '<br>';
                        $result .= ''.$approver->ems_apprv_date_time.'';
                        $result .= '<br>';

                        $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                        $result .= '<br>';
                        $result .= ''.$approver->oaso_apprv_date_time2.'';
                        $result .= '<br>';

                        $result .= '<span class="badge badge-pill badge-warning"> '.$approver->hrd_manager->name.'</span>';

                        break;
                    }

                case 8:
                    {
                        $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                        $result .= '<br>';
                        $result .= ''.$approver->soic_apprv_date_time2.'';
                        $result .= '<br>';

                        $result .= '<span class="badge badge-pill badge-success"> '.$approver->ems_manager->name.'</span>';
                        $result .= '<br>';
                        $result .= ''.$approver->ems_apprv_date_time.'';
                        $result .= '<br>';

                        $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                        $result .= '<br>';
                        $result .= ''.$approver->oaso_apprv_date_time2.'';
                        $result .= '<br>';

                        $result .= '<span class="badge badge-pill badge-success"> '.$approver->hrd_manager->name.'</span>';
                        $result .= '<br>';
                        $result .= ''.$approver->hrd_apprv_date_time2.'';
                        $result .= '<br>';

                        break;
                    }

                    case 10:
                        {
                            $result .= '<span class="badge badge-pill badge-warning"> '.$approver->safety_officer_in_charge->name.'</span>';
                            // $result .= ' '.$soic_approver2  .'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-light"> '.$approver->ems_manager->name.'</span>';
                            // $result .= ' '.$ems_approver  .'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-light"> '.$approver->over_all_safety_officer->name.'</span>';
                            // $result .= ' '.$oaso_approver2  .'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-light"> '.$approver->hrd_manager->name.'</span>';
                            // $result .= ' '.$hrd_approver2  .'';

                            break;
                        }

                    case 11:
                        {

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->wp_extended_apprv_soic.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-warning"> '.$approver->ems_manager->name.'</span>';
                            // $result .= ' '.$ems_approver  .'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-light"> '.$approver->over_all_safety_officer->name.'</span>';
                            // $result .= ' '.$oaso_approver2  .'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-light"> '.$approver->hrd_manager->name.'</span>';
                            // $result .= ' '.$hrd_approver2  .'';
                            break;
                        }

                    case 12:
                        {
                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->wp_extended_apprv_soic.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->ems_manager->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->wp_extended_apprv_ems.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-warning"> '.$approver->over_all_safety_officer->name.'</span>';
                            // $result .= ' '.$oaso_approver2  .'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-light"> '.$approver->hrd_manager->name.'</span>';
                            // $result .= ' '.$hrd_approver2  .'';

                            break;
                        }

                    case 13:
                        {
                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->wp_extended_apprv_soic.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->ems_manager->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->wp_extended_apprv_ems.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->wp_extended_apprv_oaso.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-warning"> '.$approver->hrd_manager->name.'</span>';
                            // $result .= ' '.$hrd_approver2  .'';

                            break;
                        }

                    case 14:
                        {
                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->wp_extended_apprv_soic.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->ems_manager->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->wp_extended_apprv_ems.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->wp_extended_apprv_oaso.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-success"> '.$approver->hrd_manager->name.'</span>';
                            $result .= '<br>';
                            $result .= ''.$approver->wp_extended_apprv_hrd.'';
                            $result .= '<br>';
                            // $result .= ' '.$hrd_approver2  .'';
                            break;
                        }
            }
        // }else{
        //     $result .= '';
        // }
        return $result;
    })

    ->addColumn('action', function ($approver) use ($rapidx_user_id,$rapidx_user_name) {
        $result = "";
        $result = '<center>';
        // if($approver != ''){
            $result .= '<button class="text-muted btn actionShowWorkPermit" workpermit-id="' . $approver->work_permit_details->counter . '" data-toggle="modal" data-target="#modalViewRequest" data-keyboard="false"><i class="fa fa-eye" style="color: #40E0D0;"></i> </button>&nbsp;';
            $result .='<br>';
            if($approver->work_permit_details->status < 4){

                $result .= '<button class="btn btn-secondary btn-sm text-center actionEditWorkPermit" workpermit-id="' . $approver->work_permit_details->counter . '" data-toggle="modal" data-target="#modalEditWorkPermit" data-keyboard="false"><i class="fas fa-edit"></i> Edit</button>';
                $result .='<br>';
                $result .='<br>';

            }

            if($approver->work_permit_details->status >= 1 || $approver->work_permit_details->status == 8 ){
                // $result .='<br>';
                // $result .='<br>';
            }else{
                $result .= '<button class="btn btn-danger btn-sm text-center actionDeleteWorkPermit" workpermit-id="' . $approver->work_permit_details->counter . '" data-toggle="modal" data-target="#modalDeleteWorkPermit" data-keyboard="false"><i class="fa fa-trash"></i> Delete</button>';
                $result .='<br>';
                $result .='<br>';
            }

            $result .= "<a href = 'export/" .$approver->work_permit_details->counter. "'><button class='btn btn-info btn-sm'><i class='fas fa-file-export'></i>  Export Work Permit</button></a>";
            // <button class="btn btn-primary"><i class="fas fa-file-export">
            $result .='<br>';
            $result .='<br>';

            if($approver->work_permit_details->status <= 8 ){

                $result .= '<button class="btn btn-primary btn-sm text-center actionExtendWorkPermit" workpermit-id="' . $approver->work_permit_details->counter . '" data-toggle="modal" data-target="#modalExtendWorkPermit" data-keyboard="false"><i class="far fa-calendar-plus"></i> Extend Work Permit</button>';
            }
            // $result .='<br>';

                switch($approver->work_permit_details->status){
                    case 0:{
                        if($approver->project_in_charge == $rapidx_user_name){
                            $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $approver->work_permit_details->counter . '" status="1" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Approve</button>';
                            // $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Disapprove</button>';

                        }
                        break;

                    }
                    case 1:{
                        $variable = OhsRequirements::with([
                            'ohs_requirements_id'
                        ])
                        ->where('counter',$approver->work_permit_details->counter)
                        ->first();
                        // return $variable;

                        if ($variable->ohs_requirement1 != null || $variable->ohs_requirement2 != null
                            || $variable->ohs_requirement3 != null || $variable->ohs_requirement4 != null || $variable->ohs_requirement5 != null || $variable->ohs_requirement6 != null
                            || $variable->ohs_requirement7 != null || $variable->ohs_requirement8 != null || $variable->ohs_requirement9 != null || $variable->ohs_requirement10 != null
                            || $variable->ohs_requirement11 != null || $variable->ohs_requirement12 != null || $variable->ohs_requirement13 != null || $variable->ohs_requirement14 != null
                            || $variable->ohs_requirement15 != null || $variable->ohs_requirement16 != null || $variable->ohs_requirement17 != null || $variable->ohs_requirement18 != null
                            || $variable->ohs_requirement19 != null || $variable->ohs_requirement20 != null || $variable->ohs_requirement21 != null){
                            if($approver->safety_officer_in_charge_id == $rapidx_user_id){
                                $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $approver->work_permit_details->counter . '" status="2" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Approve</button>';
                                // $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Disapprove</button>';
                            }
                        }else{
                            if($approver->safety_officer_in_charge_id == $rapidx_user_id || $approver->project_in_charge == $rapidx_user_name){
                                $result .= '<br><br><span class="badge badge-pill badge-warning">Call the "Person in Charge" <br> to update the "OHS Requirements" <br> so that the Approve Button appears.</span>';
                            }
                        }
                        break;

                    }
                    case 2:{
                        if($approver->over_all_safety_officer_id == $rapidx_user_id){
                            $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $approver->work_permit_details->counter . '" status="3" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Approve</button>';
                            // $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Disapprove</button>';

                        }
                        break;

                    }
                    case 3:{

                        if($approver->hrd_manager_id == $rapidx_user_id){
                            $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $approver->work_permit_details->counter . '" status="4" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Approve</button>';
                            // $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Disapprove</button>';

                        }
                        break;

                    }
                    case 4:{

                        if($approver->safety_officer_in_charge_id == $rapidx_user_id){
                            $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $approver->work_permit_details->counter . '" status="5" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Clear</button>';
                            $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionWorkPermitNotClear"" style="width:105px;margin:2%;" workpermit-id="' . $approver->work_permit_details->counter . '" status="4" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Not Clear</button>';
                            // $result .= '<button type="button" class="btn btn-outline-primary btn-sm far fa-calendar-plus text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">   Extended</button>';
                            // if ()
                        }
                        break;

                    }
                    case 5:{

                        if($approver->ems_manager_id == $rapidx_user_id){
                            $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $approver->work_permit_details->counter . '" status="6" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Approve</button>';
                            // $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Disapprove</button>';

                        }
                        break;

                    }
                    case 6:{

                        if($approver->over_all_safety_officer_id == $rapidx_user_id){
                            $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $approver->work_permit_details->counter . '" status="7" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Approve</button>';
                            // $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Disapprove</button>';

                        }
                        break;

                    }
                    case 7:{

                        if($approver->hrd_manager_id == $rapidx_user_id){
                            $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $approver->work_permit_details->counter . '" status="8" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Approve</button>';
                            // $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Disapprove</button>';

                        }
                        break;

                    }

                    case 9:{

                        if($approver->over_all_safety_officer_id == $rapidx_user_id){
                            $result .= '<button type="button" class="btn btn-outline-secondary btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:150px;margin:2%;" workpermit-id="' . $approver->work_permit_details->counter . '" status="10" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">Approve Extended Work Permit</button>';

                        }
                        break;

                    }

                    case 10:{

                        if($approver->safety_officer_in_charge_id == $rapidx_user_id){
                            $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:150px;margin:2%;" workpermit-id="' . $approver->work_permit_details->counter . '" status="11" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">Approve</button>';

                        }
                        break;

                    }

                    case 11:{

                        if($approver->ems_manager_id == $rapidx_user_id){
                            $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:150px;margin:2%;" workpermit-id="' . $approver->work_permit_details->counter . '" status="12" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">Approve</button>';

                        }
                        break;

                    }

                    case 12:{
                        if($approver->over_all_safety_officer_id == $rapidx_user_id){
                            $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:150px;margin:2%;" workpermit-id="' . $approver->work_permit_details->counter . '" status="13" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">Approve</button>';
                        }
                        break;

                    }

                    case 13:{
                        if($approver->hrd_manager_id == $rapidx_user_id){
                            $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:150px;margin:2%;" workpermit-id="' . $approver->work_permit_details->counter . '" status="14" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">Approve</button>';
                        }
                        break;
                    }
                }
        // }else{
        //     $result .= '';
        // }

        return $result;

    })

    ->addColumn('attach_file', function($approver){
        $result = "<center>";
        // if($approver != ''){
            if($approver->work_permit_details->attach_file == "No File Uploaded"){
                $result .= '<span class="badge badge-pill badge-danger">No file uploaded!</span>';
            }
            else{

                $result .= "<a href='download_attach_file/" . $approver->work_permit_details->id . "' > $approver->work_permit_details->attach_file </a>";
            }
        // }else{
        //     $result .= '';
        // }
            $result .= '</center>';
            return $result;
    })

    ->rawColumns(['status', 'action','classification','approver','clearance','start_date','end_date','attach_file'])
    ->make(true);


}
//===== DISPLAY DATATABLES OF CONTRACTORS END =====//}

    //===== ADD WORK PERMIT FUNCTION ====//
    public function add_work_permit(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();
        //  return $data;


        $validator = Validator::make($data, [
            'work_classification' => 'required',
            //  'txtperson_in_charge'=>'required',
            'division' => 'required',
            //  'txt_activity' =>'required',
            // //  'txt_description'=>'required',
            //  'txt_localnumber' => 'required',
            //  'txt_location' =>'required',
            'dd_contractor'=>'required',
            'dd_contractor_person_in_charge' => 'required',
            'dd_contractor_safety_officer_in_charge' =>'required',
            // //  'project_duration'=>'required',
            // //  'work_schedule' => 'required',
            'start_date' =>'required',
            'end_date' =>'required',
            'start_time'=>'required',
            'end_time'=>'required',

            //  'work_time'=>'required'
            //  'add_worker' =>'required',
            //  'add_position' => 'required',
            //  'add_contractors_ohs_training_date' => 'required',
            //  'add_skills_training_certificate_date' => 'required',
            //  'certificate_submission_date' => 'required',
            //  'add_tools_name' => 'required',
            //  'add_tools_quantity' => 'required',
            //  'add_other_requirements' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
            $data1 = array();
            //  $data1 = $request->inside_pmi_type.",".$request->outside_pmi.",".$request->HeightsPmi.",".$request->HotWorksPmi.",".$request->ConfineSpacePmi;

            if($request->inside_pmi_type != ""){
                $data1[]=$request->inside_pmi_type;
            }
            if($request->outside_pmi != ""){
                $data1[]=$request->outside_pmi;
            }
            if($request->HeightsPmi != ""){
                $data1[]=$request->HeightsPmi;
            }
            if($request->HotWorksPmi != ""){
                $data1[]=$request->HotWorksPmi;
            }
            if($request->ConfineSpacePmi != ""){
                $data1[]=$request->ConfineSpacePmi;
            }

            $data2 = implode(", ", $data1);

            if($request->inside_pmi_type == "" && $request->outside_pmi == "" && $request->HeightsPmi == "" && $request->HotWorksPmi == "" && $request->ConfineSpacePmi == ""){
                // return null;
            }

            $data3 = array();

            if($request->fire_alarm_system != ""){
                $data3[]=$request->fire_alarm_system;
            }
            if($request->emergency_lighting != ""){
                $data3[]=$request->emergency_lighting;
            }
            if($request->paging_system_speaker != ""){
                $data3[]=$request->paging_system_speaker;
            }
            if($request->emergency_exit_door != ""){
                $data3[]=$request->emergency_exit_door;
            }
            if($request->fire_extinguisher_fire_hose != ""){
                $data3[]=$request->fire_extinguisher_fire_hose;
            }
            if($request->none_name != ""){
                $data3[]=$request->none_name;
            }

            $data4 = implode(", ", $data3);

            // DB::beginTransaction();
            // try {
                if($request->hasFile('attach_file')){
                    // return 'if';
                    $original_filename = $request->file('attach_file')->getClientOriginalName();
                    // return $original_filename;

                    Storage::putFileAs('public/attach_file', $request->attach_file,  $original_filename);

                    WorkPermitInformation::insert([
                        // 'permit_number' =>                     '----',
                        'classification' =>                    $request->work_classification,
                        'work_permit_type' =>                  $data2,
                        'division' =>                          $request->division,
                        'person_in_charge' =>                  $request->txtperson_in_charge,
                        'department' =>                        $request->txtperson_in_charge_department,
                        'activity' =>                          $request->txt_activity,
                        // 'description' =>                       $request->txt_description,
                        'local_number' =>                      $request->txt_localnumber,
                        'location' =>                          $request->txt_location,
                        'contractor_id' =>                     $request->dd_contractor,
                        'contractor_pic_id' =>                 $request->dd_contractor_person_in_charge,
                        'contractor_soic_id' =>                $request->dd_contractor_safety_officer_in_charge,
                        'work_schedule' =>                     $request->txt_work_schedule,
                        'start_date' =>                        $request->start_date,
                        'end_date' =>                          $request->end_date,
                        'start_time' =>                        $request->start_time,
                        'end_time' =>                          $request->end_time,
                        'status' =>                            '0',
                        'created_at'    =>                    NOW(),
                        'counter' =>                           $request->counter,
                        'attach_file' =>                       $original_filename,
                        'logdel' => 0
                    ]);


                    if($request->add_worker_details_counter > 0){
                        Worker::insert([
                            'name' => $request->add_worker_name,
                            'position' => $request->add_worker_position,
                            'training_date' => $request->add_ohs_training_date,
                            'training_certificate_date' => $request->add_skills_training_date,
                            'training_submission_date' => $request->add_certificate_submission_date,
                            'counter' => $request->counter,
                            'logdel' => 0
                        ]);


                        for($index = 2; $index <= $request->add_worker_details_counter; $index++){
                            Worker::insert([
                                'name' => $request->input("add_worker_name_$index"),
                                'position' => $request->input("add_worker_position_$index"),
                                'training_date' => $request->input("add_ohs_training_date_$index"),
                                'training_certificate_date' => $request->input("add_skills_training_date_$index"),
                                'training_submission_date' => $request->input("add_certificate_submission_date_$index"),
                                'counter' => $request->counter,
                                'logdel' => 0

                            ]);

                        }
                    }

                    if($request->add_tools_details_counter > 0){
                        Tools::insert([
                            'name' => $request->add_tools_name,
                            'quantity' => $request->add_tools_quantity,
                            'other_requirements' => $request->add_other_requirements,
                            'affected_safety_devices' => $data4,
                            'counter' => $request->counter,
                            'logdel' => 0
                        ]);


                        for($indexx = 2; $indexx <= $request->add_tools_details_counter; $indexx++){
                            Tools::insert([
                                'name' => $request->input("add_tools_name_$indexx"),
                                'quantity' => $request->input("add_tools_quantity_$indexx"),
                                'other_requirements' => $request->input("add_other_requirements_$indexx"),
                                'affected_safety_devices' => $data4,
                                'counter' => $request->counter,
                                'logdel' => 0
                            ]);

                        }
                    }



                    ApproverEmailRecipient::insert([
                        'project_in_charge' => $request->project_in_charge,
                        'safety_officer_in_charge_id' => $request->safety_officer_in_charge,
                        'over_all_safety_officer_id' => $request->over_all_safety_officer,
                        'hrd_manager_id' => $request->hrd_manager,
                        'ems_manager_id' => $request->ems_manager,
                        'counter' => $request->counter,
                        'logdel' => 0

                    ]);

                    OhsRequirements::insert([
                        'counter'          => $request->counter,
                        'ohs_requirement1' => $request->discuss_pmi_ehs,
                        'ohs_requirement2' => $request->discuss_approved_ohs,
                        'ohs_requirement3' => $request->bring_and_wear,
                        'ohs_requirement4' => $request->certified_skilled_workers,
                        'ohs_requirement5' => $request->full_body_harness,
                        'ohs_requirement6' => $request->scaffold_strenght,
                        'ohs_requirement7' => $request->scafold_stability,
                        'ohs_requirement8' => $request->strictly_no_passage,
                        'ohs_requirement9' => $request->provide_appropriate_barricade,
                        'ohs_requirement10' => $request->provide_appropriate_safety_net,
                        'ohs_requirement11' => $request->insulated_ppe,
                        'ohs_requirement12' => $request->no_lifting_activity,
                        'ohs_requirement13' => $request->strictly_tools,
                        'ohs_requirement14' => $request->fire_extinguisher,
                        'ohs_requirement15' => $request->stricty_no_flammable,
                        'ohs_requirement16' => $request->fire_blanket,
                        'ohs_requirement17' => $request->gas_cylinder,
                        'ohs_requirement18' => $request->strictly_observed_buddy,
                        'ohs_requirement19' => $request->conduct_daily,
                        'ohs_requirement20' => $request->practice_safety_first,
                        'ohs_requirement21' => $request->others_participate
                    ]);
                    //  DB::commit();
                        return response()->json(['result' => "1"]);
                }else{
                    // return 'else';
                    WorkPermitInformation::insert([
                        // 'permit_number' =>                     '----',
                        'classification' =>                    $request->work_classification,
                        'work_permit_type' =>                  $data2,
                        'division' =>                          $request->division,
                        'person_in_charge' =>                  $request->txtperson_in_charge,
                        'department' =>                        $request->txtperson_in_charge_department,
                        'activity' =>                          $request->txt_activity,
                        // 'description' =>                       $request->txt_description,
                        'local_number' =>                      $request->txt_localnumber,
                        'location' =>                          $request->txt_location,
                        'contractor_id' =>                     $request->dd_contractor,
                        'contractor_pic_id' =>                 $request->dd_contractor_person_in_charge,
                        'contractor_soic_id' =>                $request->dd_contractor_safety_officer_in_charge,
                        'work_schedule' =>                     $request->txt_work_schedule,
                        'start_date' =>                        $request->start_date,
                        'end_date' =>                          $request->end_date,
                        'start_time' =>                        $request->start_time,
                        'end_time' =>                          $request->end_time,
                        'status' =>                            '0',
                        'created_at'    =>                    NOW(),
                        'counter' =>                           $request->counter,
                        'attach_file' =>                        'No File Uploaded',
                        'logdel' => 0
                    ]);


                    if($request->add_worker_details_counter > 0){
                        Worker::insert([
                            'name' => $request->add_worker_name,
                            'position' => $request->add_worker_position,
                            'training_date' => $request->add_ohs_training_date,
                            'training_certificate_date' => $request->add_skills_training_date,
                            'training_submission_date' => $request->add_certificate_submission_date,
                            'counter' => $request->counter,
                            'logdel' => 0

                        ]);


                        for($index = 2; $index <= $request->add_worker_details_counter; $index++){
                            Worker::insert([
                                'name' => $request->input("add_worker_name_$index"),
                                'position' => $request->input("add_worker_position_$index"),
                                'training_date' => $request->input("add_ohs_training_date_$index"),
                                'training_certificate_date' => $request->input("add_skills_training_date_$index"),
                                'training_submission_date' => $request->input("add_certificate_submission_date_$index"),
                                'counter' => $request->counter,
                                'logdel' => 0

                            ]);

                        }
                    }

                    if($request->add_tools_details_counter > 0){
                        Tools::insert([
                            'name' => $request->add_tools_name,
                            'quantity' => $request->add_tools_quantity,
                            'other_requirements' => $request->add_other_requirements,
                            'affected_safety_devices' => $data4,
                            'counter' => $request->counter,
                            'logdel' => 0
                        ]);


                        for($indexx = 2; $indexx <= $request->add_tools_details_counter; $indexx++){
                            Tools::insert([
                                'name' => $request->input("add_tools_name_$indexx"),
                                'quantity' => $request->input("add_tools_quantity_$indexx"),
                                'other_requirements' => $request->input("add_other_requirements_$indexx"),
                                'affected_safety_devices' => $data4,
                                'counter' => $request->counter,
                                'logdel' => 0
                            ]);
                        }
                    }

                    ApproverEmailRecipient::insert([
                        'project_in_charge' => $request->project_in_charge,
                        'safety_officer_in_charge_id' => $request->safety_officer_in_charge,
                        'over_all_safety_officer_id' => $request->over_all_safety_officer,
                        'hrd_manager_id' => $request->hrd_manager,
                        'ems_manager_id' => $request->ems_manager,
                        'counter' => $request->counter,
                        'logdel' => 0
                    ]);

                    OhsRequirements::insert([
                        'counter'          => $request->counter,
                        'ohs_requirement1' => $request->discuss_pmi_ehs,
                        'ohs_requirement2' => $request->discuss_approved_ohs,
                        'ohs_requirement3' => $request->bring_and_wear,
                        'ohs_requirement4' => $request->certified_skilled_workers,
                        'ohs_requirement5' => $request->full_body_harness,
                        'ohs_requirement6' => $request->scaffold_strenght,
                        'ohs_requirement7' => $request->scafold_stability,
                        'ohs_requirement8' => $request->strictly_no_passage,
                        'ohs_requirement9' => $request->provide_appropriate_barricade,
                        'ohs_requirement10' => $request->provide_appropriate_safety_net,
                        'ohs_requirement11' => $request->insulated_ppe,
                        'ohs_requirement12' => $request->no_lifting_activity,
                        'ohs_requirement13' => $request->strictly_tools,
                        'ohs_requirement14' => $request->fire_extinguisher,
                        'ohs_requirement15' => $request->stricty_no_flammable,
                        'ohs_requirement16' => $request->fire_blanket,
                        'ohs_requirement17' => $request->gas_cylinder,
                        'ohs_requirement18' => $request->strictly_observed_buddy,
                        'ohs_requirement19' => $request->conduct_daily,
                        'ohs_requirement20' => $request->practice_safety_first,
                        'ohs_requirement21' => $request->others_participate

                    ]);
                    return response()->json(['result' => "1"]);
                }
            // DB::commit();
            // return response()->json(['result' => "1"]);
            // } catch (\Exception $e) {
            //   DB::rollback();
            //   return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
            // }
        }
    }
        // }
        //  }
        //===== ADD WORK PERMIT FUNCTION END ====//

    public function download_attach_file(Request $request, $id){
        $attach_file = WorkPermitInformation::where('id', $id)->first();

        // return $attach_file;

        $file =  storage_path() . "/app/public/attach_file/" . $attach_file->attach_file;

        // return $file;


        return Response::download($file, $attach_file->attach_file);
    }

        //EDIT WORK PERMIT FUNCTION
        public function get_work_permit_id_to_edit(Request $request)
        {
            $workpermit = WorkPermitInformation:: with([
                'contractor_person_in_charge',
                'contractor_safety_officer_in_charge',
                'contractor_id'
                ])
                ->where('counter', $request->work_permit_id)->get();

                // return $workpermit;

                $worker = Worker::where('counter',$request->work_permit_id)->get();
                $tools = Tools::where('counter', $request->work_permit_id)->get();


                // return count($tools);

                $resulta = '';

                for($index = 0; $index < count($tools); $index++){
                    $resulta .=  $tools[$index]->name;
                }

                // return $resulta;

                $approver = ApproverEmailRecipient::with([
                    'safety_officer_in_charge',
                    'over_all_safety_officer',
                    'hrd_manager',
                    'ems_manager'

                ])
                ->where('counter',$request->work_permit_id)->get();


                // ->where('id', 1)->get();
                $start_date = $workpermit[0]->start_date;
                $end_date = $workpermit[0]->end_date;
                $start_time = $workpermit[0]->start_time;
                $end_time = $workpermit[0]->end_time;
                // $time = $workpermit[0]->time;

                $start_date = Carbon::parse($start_date)->format('F d,  Y');
                $end_date = Carbon::parse($end_date)->format('F d,  Y');
                $start_time = Carbon::parse($start_time)->format('h:i A');
                $end_time = Carbon::parse($end_time)->format('h:i A');

                $workpermit[0]->work_permit_type;

                $exploded_work_permit_type = explode(",",$workpermit[0]->work_permit_type);
                // return $exploded_work_permit_type;



                // return $ohs_result;

                // return $workpermit;
            //  $res = $workpermit->contractor_person_in_charge->name;


            return response()->json(['permit_number' => $workpermit, 'startDate' => $start_date, 'endDate' => $end_date, 'worker'=> $worker, 'tools'=> $tools, 'approver'=> $approver, 'resulta' => $resulta, 'start_time' => $start_time, 'end_time' => $end_time, 'exploded_work_type' => $exploded_work_permit_type]);

        }
        //VIWE WORK PERMIT FUNCTION END

//VIEW WORK PERMIT FUNCTION
    public function get_work_permit_id_to_view(Request $request)
    {
        $workpermit = WorkPermitInformation:: with([
            'contractor_person_in_charge',
            'contractor_safety_officer_in_charge',
            'contractor_id'
            ])
            ->where('counter', $request->work_permit_id)->get();

        // return $workpermit;

        $worker = Worker::where('counter',$request->work_permit_id)->get();
        $tools = Tools::where('counter', $request->work_permit_id)->get();
        $ohs_req =  OhsRequirements::where('counter', $request->work_permit_id)->get();

        // return $ohs_req;

        $resulta = '';

        for($index = 0; $index < count($tools); $index++){
            $resulta .=  $tools[$index]->name;
        }

        // return $resulta;

        $approver = ApproverEmailRecipient::with([
            'safety_officer_in_charge',
            'over_all_safety_officer',
            'hrd_manager',
            'ems_manager'

        ])
        ->where('counter',$request->work_permit_id)->get();


        // ->where('id', 1)->get();
        $start_date = $workpermit[0]->start_date;
        $end_date = $workpermit[0]->end_date;
        $start_time = $workpermit[0]->start_time;
        $end_time = $workpermit[0]->end_time;
        // $time = $workpermit[0]->time;

        $start_date = Carbon::parse($start_date)->format('F d,  Y');
        $end_date = Carbon::parse($end_date)->format('F d,  Y');
        $start_time = Carbon::parse($start_time)->format('h:i A');
        $end_time = Carbon::parse($end_time)->format('h:i A');


        // return $workpermit;
    //  $res = $workpermit->contractor_person_in_charge->name;


    return response()->json(['permit_number' => $workpermit, 'startDate' => $start_date, 'endDate' => $end_date, 'worker'=> $worker, 'tools'=> $tools, 'approver'=> $approver, 'resulta' => $resulta, 'start_time' => $start_time, 'end_time' => $end_time, 'ohs_req' => $ohs_req]);

}
//VIWE WORK PERMIT FUNCTION END


//   public function get_project_in_charge(Request $request){
//     $user_approvers = UserApprover::with(['rapidx_user_details'])->where('classification','Project In-Charge')->where('status', 0)->get();
// // return $user_approvers;
//     return response()->json(['user_approvers' => $user_approvers]);
// }

        public function get_safety_officer_in_charge(Request $request){
        $user_approvers = UserApprover::with(['rapidx_user_details'])->where('classification','Safety Officer In-Charge')->where('status', 0)->get();
        // return $user_approvers;
        return response()->json(['user_approvers' => $user_approvers]);
        }

        public function get_overall_safety_officer(Request $request){
        $user_approvers = UserApprover::with(['rapidx_user_details'])->where('classification','Over-all Safety Officer')->where('status', 0)->get();
        // return $user_approvers;
        return response()->json(['user_approvers' => $user_approvers]);
        }

        public function get_hrd_manager(Request $request){
        $user_approvers = UserApprover::with(['rapidx_user_details'])->where('classification','HRD Manager')->where('status', 0)->get();
        // return $user_approvers;
        return response()->json(['user_approvers' => $user_approvers]);

        }

        public function get_ems_manager(Request $request){
        $user_approvers = UserApprover::with(['rapidx_user_details'])->where('classification','EMS Manager')->where('status', 0)->get();
        // return $user_approvers;
        return response()->json(['user_approvers' => $user_approvers]);
        }

        public function get_rapidx_user(Request $request){
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $get_user = RapidXUser::where('id', $rapidx_user_id)->get();
        // return $get_user;
        return response()->json(["get_user" => $get_user]);
        }

        public function get_rapidx_user_department(Request $request){
        session_start();
        $rapidx_department_id = $_SESSION['rapidx_department_id'];
        $get_user_department = RapidXDepartment::where('department_id', $rapidx_department_id)->get();
        // return $get_user;
        return response()->json(["get_user_department" => $get_user_department]);
        }

    // ============================== CASH ADVANCE GET LOCAL NO. ==============================
        public function get_local_no(){
            $phone_dir = SystemOnePhoneDirectory::where('category', 1)
            ->where('logdel',0)
            ->get();
            // return $phone_dir;
            return response()->json(['phone_dir' => $phone_dir]);
        }

        public function get_counter(){
            $counter = WorkPermitInformation::all();

            if(count($counter) >= 1 ){
                for ($i=0; $i<count($counter); $i++){
                    $counter_counter = $counter[$i]->counter;
                }
                $counter_strike = $counter_counter + 1;
            }else{
                $counter_strike = 1;
            }


            return response()->json(['counter' => $counter_strike]);
        }

//======================================================================
    public function approved_work_permit(Request $request){


        date_default_timezone_set('Asia/Manila');

        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $rapidx_username = $_SESSION['rapidx_username'];

        $data = $request->all(); // collect all input fields

        // return $data;

        WorkPermitInformation::where('counter', $request->work_permit_id)
        ->update([
            'status' => $request->status,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        //     // return $test;
        $approved_work_permit = WorkPermitInformation::
            with(['approver_in_charge','contractor_id_name'])
            ->where('counter', $request->work_permit_id)
            ->get();


        $permit_number = $approved_work_permit[0]->permit_number;

        $contractor_worker = Worker::where('counter', $request->work_permit_id)->get();
        $approver = ApproverEmailRecipient::all();

        // return $approver;

        $get_data = ['data' => $approved_work_permit , 'worker_data' => $contractor_worker];

        // return $get_data;
            // return $approved_work_permit[0]->status;
            if($approved_work_permit[0]->status == 1){


                $send_email = $approved_work_permit[0]->approver_in_charge->safety_officer_in_charge_id;
                // $email_send = $approver[0]->safety_officer_in_charge_id;
                // $email_send1 = $approver[0]->hrd_manager;

                $recipients = RapidXUser::where('id', $send_email)->get();

                $date_now = date("ym");
                $div = $approved_work_permit[0]->division;

                $texts = "POWP";
                $work_permit_number = WorkPermitInformation::where('permit_number', '!=', null)
                ->orderBy('permit_number_extension', 'DESC')
                ->get();

                if(count($work_permit_number) > 1){

                    $exploded_work_permit_number = explode("-",$work_permit_number[0]->permit_number_extension);
                }

                // return $work_permit_number;

                if( count($work_permit_number) == 0){
                    //statis 001
                    // return 'if';
                    $num = "001";
                    // return $num;
                            $div = $approved_work_permit[0]->division;
                            $work_permit1 = $texts .= "-";
                            $work_permit2 = $work_permit1 .= $div;
                            $work_permit3 = $work_permit2 .= "-";
                            $work_permit4 = $work_permit3 .= $date_now;
                            $work_permit5 = $work_permit4 .= "-";
                            $work_permit6 = $work_permit5 .= $num;

                            $work_permit_date = $date_now."-".$num;


                    WorkPermitInformation::with('approver_in_charge')->where('counter', $request->work_permit_id)
                    ->update([
                        'permit_number' => $work_permit6,
                        'permit_number_extension' => $work_permit_date
                    ]);

                    $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                    ->update([
                        'pic_apprv_date_time' => NOW()
                    ]);


                }else if( count($work_permit_number) >= 1 && $exploded_work_permit_number[0] != $date_now){

                    $num = "001";
                    $div = $approved_work_permit[0]->division;

                            $work_permit1 = $texts .= "-";
                            $work_permit2 = $work_permit1 .= $div;
                            $work_permit3 = $work_permit2 .= "-";
                            $work_permit4 = $work_permit3 .= $date_now;
                            $work_permit5 = $work_permit4 .= "-";
                            $work_permit6 = $work_permit5 .= $num;

                            $work_permit_date = $date_now."-".$num;


                    WorkPermitInformation::with('approver_in_charge')->where('counter', $request->work_permit_id)
                    ->update([
                        'permit_number' => $work_permit6,
                        'permit_number_extension' => $work_permit_date
                    ]);

                    $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                    ->update([
                        'pic_apprv_date_time' => NOW()
                    ]);
                }
                else{
                    // return 'else';
                    $work_permit_num =  $work_permit_number[0]->permit_number_extension;

                    $str2 = explode("-",$work_permit_num);
                    // return $str2;
                    $str_date = $str2[0];
                    $str2[1] = $str2[1] + 1;
                    $strx[1] = str_pad($str2[1],3,'0',STR_PAD_LEFT);
                    // $str2[1] = $div;

                    // $texts = "POWP";
                    // $div= $div; // division sa db
                    $work_permit_detailss = $texts.'-'.$div.'-'.$str_date.'-'.$strx[1];

                    $str3 = implode('-',$str2);
                    // $work_permit_date = $date_now."-".$num;

                    $work_permit_counter = $strx[1];
                    $work_permit_date = $str2[0];
                    $work_permit_number = $work_permit_date.'-'.$work_permit_counter;

                    // return $work_permit_detailss;

                    WorkPermitInformation::with('approver_in_charge')->where('counter', $request->work_permit_id)
                    ->update([
                        'permit_number' => $work_permit_detailss,
                        'permit_number_extension' => $work_permit_number
                    ]);


                }

                Mail::send('emails.Approver', $get_data, function($message) use ($recipients) {
                    $message->to($recipients[0]->email)
                    // ->cc($to_cc)
                    ->bcc('mrronquez@pricon.ph')
                    ->subject('OHS Work Permit - ' . Carbon::now()->toFormattedDateString());

                    // $message->attach($path);
                });

                $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                ->update([
                    'pic_apprv_date_time' => NOW()
                ]);


            }
            else if($approved_work_permit[0]->status == 2){
                $send_email = $approved_work_permit[0]->approver_in_charge->over_all_safety_officer_id;
                $recipients = RapidXUser::where('id', $send_email)->get();

                // return $recipients;
                Mail::send('emails.Approver', $get_data, function($message) use ($recipients,$permit_number) {
                    $message->to($recipients[0]->email)
                    // ->cc($to_cc)
                    ->bcc('mrronquez@pricon.ph')
                    ->subject('OHS Work Permit - ' . $permit_number);

                    // $message->attach($path);
                });

                $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                ->update([
                    'soic_apprv_date_time' => NOW()
                ]);

            }

            else if($approved_work_permit[0]->status == 3){
                $send_email = $approved_work_permit[0]->approver_in_charge->hrd_manager_id;
                $recipients = RapidXUser::where('id', $send_email)->get();

                // return $recipients;
                Mail::send('emails.Approver', $get_data, function($message) use ($recipients,$permit_number) {
                    $message->to($recipients[0]->email)
                    // ->cc($to_cc)
                    ->bcc('mrronquez@pricon.ph')
                    ->subject('OHS Work Permit - ' . $permit_number);

                });


                $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                ->update([
                    'oaso_apprv_date_time' => NOW()
                ]);
            }

            else if($approved_work_permit[0]->status == 4 ){
                $send_email = $approved_work_permit[0]->approver_in_charge->safety_officer_in_charge_id;
                $recipients = RapidXUser::where('id', $send_email)->get();


                $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                ->update([
                    'hrd_apprv_date_time' => NOW()
                ]);

                // return $recipients;
                Mail::send('emails.Approver', $get_data, function($message) use ($recipients,$permit_number) {
                    $message->to($recipients[0]->email)
                    // ->cc($to_cc)
                    ->bcc('mrronquez@pricon.ph')
                    ->subject('OHS Work Permit - ' . $permit_number);
                });

                Mail::send('emails.email_to_guards', $get_data, function($message) use ($recipients,$permit_number) {
                    $message->to($recipients[0]->email)
                    // ->cc($to_cc)
                    ->bcc('mrronquez@pricon.ph')
                    ->bcc('rpesposo@pricon.ph')
                    ->bcc('edpamaong@pricon.ph')
                    ->bcc('mrdepidep@pricon.ph')
                    ->bcc('nvmanuel@pricon.ph')
                    ->subject('OHS Work Permit -'.$permit_number);


                    // $message->attach($path);
                });
            }

            else if($approved_work_permit[0]->status == 5){
                $send_email = $approved_work_permit[0]->approver_in_charge->ems_manager_id;
                $recipients = RapidXUser::where('id', $send_email)->get();

                Mail::send('emails.Approver', $get_data, function($message) use ($recipients,$permit_number) {
                    $message->to($recipients[0]->email)
                    ->bcc('mrronquez@pricon.ph')
                    ->subject('OHS Work Permit - ' . $permit_number);
                });

                WorkPermitInformation::with('approver_in_charge')->where('counter', $request->work_permit_id)
                ->update(['clearance_status_clear' => $request->clear_status ]);

                $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                    ->update([
                        'soic_apprv_date_time2' => NOW()
                    ]);
            }

            else if($approved_work_permit[0]->status == 6){
                $send_email = $approved_work_permit[0]->approver_in_charge->over_all_safety_officer_id;
                $recipients = RapidXUser::where('id', $send_email)->get();

                Mail::send('emails.Approver', $get_data, function($message) use ($recipients,$permit_number) {
                    $message->to($recipients[0]->email)
                    // ->cc($to_cc)
                    ->bcc('mrronquez@pricon.ph')
                    ->subject('OHS Work Permit - ' . $permit_number);

                });

                $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                ->update([
                    'ems_apprv_date_time' => NOW()
                ]);
            }

            else if($approved_work_permit[0]->status == 7){
                $send_email = $approved_work_permit[0]->approver_in_charge->hrd_manager_id;
                $recipients = RapidXUser::where('id', $send_email)->get();

                Mail::send('emails.Approver', $get_data, function($message) use ($recipients,$permit_number) {
                    $message->to($recipients[0]->email)

                    ->bcc('mrronquez@pricon.ph')
                    ->subject('OHS Work Permit - ' . $permit_number);

                });

                $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                    ->update([
                        'oaso_apprv_date_time2' => NOW()
                    ]);
            }

            else if($approved_work_permit[0]->status == 8){
                $ids = ApproverEmailRecipient::where('counter', $request->work_permit_id)->get();
                $recipients = RapidXUser::whereIn('id', [$ids[0]->project_in_charge, $ids[0]->safety_officer_in_charge_id, $ids[0]->over_all_safety_officer_id, $ids[0]->hrd_manager_id, $ids[0]->ems_manager_id])->pluck('email')->toArray();

                Mail::send('emails.work_permit_done', $get_data, function($message) use ($recipients,$permit_number) {
                    $message->to($recipients)
                    ->bcc('mrronquez@pricon.ph')
                    ->subject('OHS Work Permit -'.$permit_number.' is now completed!');
                });

                $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                ->update([
                    'hrd_apprv_date_time2' => NOW()
                ]);
            }

            else if($approved_work_permit[0]->status == 10){
                $ids = ApproverEmailRecipient::where('counter', $request->work_permit_id)->get();
                $extended_recipients = RapidXUser::whereIn('id', [$ids[0]->safety_officer_in_charge_id])->pluck('email')->toArray();
                // $recipients = RapidXUser::whereIn('id', [$ids[0]->project_in_charge, $ids[0]->safety_officer_in_charge_id, $ids[0]->over_all_safety_officer_id, $ids[0]->hrd_manager_id, $ids[0]->ems_manager_id])->pluck('email')->toArray();

                Mail::send('emails.work_permit_extended_for_approval2', $get_data, function($message) use ($extended_recipients) {
                    $message->to($extended_recipients)
                    ->bcc('mrronquez@pricon.ph')
                    ->subject('OHS Work Permit Extended For Approval');

                });

                $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                ->update([
                    'wp_extended_apprv_date_time_oaso' => NOW()
                ]);

            }

            else if($approved_work_permit[0]->status == 11){
                $ids = ApproverEmailRecipient::where('counter', $request->work_permit_id)->get();
                $extended_recipients = RapidXUser::whereIn('id', [$ids[0]->ems_manager])->pluck('email')->toArray();
                // $recipients = RapidXUser::whereIn('id', [$ids[0]->project_in_charge, $ids[0]->safety_officer_in_charge_id, $ids[0]->over_all_safety_officer_id, $ids[0]->hrd_manager_id, $ids[0]->ems_manager_id])->pluck('email')->toArray();

                Mail::send('emails.work_permit_extended_for_approval2', $get_data, function($message) use ($extended_recipients) {
                    $message->to($extended_recipients)
                    ->bcc('mrronquez@pricon.ph')
                    ->subject('OHS Work Permit Extended For Approval');

                });
                $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                ->update([
                    'wp_extended_apprv_soic' => NOW()
                ]);

            }

            else if($approved_work_permit[0]->status == 12){
                $ids = ApproverEmailRecipient::where('counter', $request->work_permit_id)->get();
                $extended_recipients = RapidXUser::whereIn('id', [$ids[0]->over_all_safety_officer_id])->pluck('email')->toArray();
                // $recipients = RapidXUser::whereIn('id', [$ids[0]->project_in_charge, $ids[0]->safety_officer_in_charge_id, $ids[0]->over_all_safety_officer_id, $ids[0]->hrd_manager_id, $ids[0]->ems_manager_id])->pluck('email')->toArray();

                Mail::send('emails.work_permit_extended_for_approval2', $get_data, function($message) use ($extended_recipients) {
                    $message->to($extended_recipients)
                    ->bcc('mrronquez@pricon.ph')
                    ->subject('OHS Work Permit Extended For Approval');

                });
                $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                ->update([
                    'wp_extended_apprv_ems' => NOW()
                ]);


            }

            else if($approved_work_permit[0]->status == 13){
                $ids = ApproverEmailRecipient::where('counter', $request->work_permit_id)->get();
                $extended_recipients = RapidXUser::whereIn('id', [$ids[0]->hrd_manager_id])->pluck('email')->toArray();
                // $recipients = RapidXUser::whereIn('id', [$ids[0]->project_in_charge, $ids[0]->safety_officer_in_charge_id, $ids[0]->over_all_safety_officer_id, $ids[0]->hrd_manager_id, $ids[0]->ems_manager_id])->pluck('email')->toArray();


                Mail::send('emails.work_permit_extended_for_approval2', $get_data, function($message) use ($extended_recipients) {
                    $message->to($extended_recipients)
                    ->bcc('mrronquez@pricon.ph')
                    ->subject('OHS Work Permit Extended For Approval');

                });

                $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                ->update([
                    'wp_extended_apprv_oaso' => NOW()
                ]);


            }

            else if($approved_work_permit[0]->status == 14){
                $ids = ApproverEmailRecipient::where('counter', $request->work_permit_id)->get();
                // $extended_recipients = RapidXUser::whereIn('id', [$ids[0]->hrd_manager_id])->pluck('email')->toArray();
                $recipients = RapidXUser::whereIn('id', [$ids[0]->project_in_charge, $ids[0]->safety_officer_in_charge_id, $ids[0]->over_all_safety_officer_id, $ids[0]->hrd_manager_id, $ids[0]->ems_manager_id])->pluck('email')->toArray();


                Mail::send('emails.work_permit_done', $get_data, function($message) use ($recipients) {
                    $message->to($recipients)
                    ->bcc('mrronquez@pricon.ph')
                    ->subject('OHS Work Permit Done');

                });

                $approver_date_time = ApproverEmailRecipient::where('counter', $request->work_permit_id)
                ->update([
                    'wp_extended_apprv_hrd' => NOW()
                ]);


            }

            return response()->json(['result' => 1]);
            // return ('si chris may pakana nito');


    }

        public function not_clear_work_permit(Request $request){
            $data = $request->all(); // collect all input fields

            $validator = Validator::make($data, [
                'work_permit_id' => 'required',
                'status'          => 'required',
            ]);


            if($validator->passes()){
                // if (safety_officer_in_charge_MOC1)
                WorkPermitInformation::with('approver_in_charge')->where('counter', $request->work_permit_id)
                ->update(['status' => 4 ]);


                ApproverEmailRecipient::where('id', $request->work_permit_id)
                ->update([
                    'safety_officer_in_charge_remark' => $request->disapprove_remarks
                    // 'safety_officer_in_charge_MOC1' => $request->moc1,
                    // 'safety_officer_in_charge_MOC2' => $request->moc2,
                    // 'safety_officer_in_charge_MOC3' => $request->moc3
                ]);

                return response()->json(['result' => "1"]);
            }
            else{
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }

        }

        public function add_ohs_requirements(Request $request){
            $data = $request->all(); // collect all input fields

            $validator = Validator::make($data, [

            ]);


            if($validator->passes()){
                // if (safety_officer_in_charge_MOC1)

                // $get_ohs_req = OhsRequirements::where('id', $request->id)
                // ->get();

                // // return $get_ohs_req;

                // if(count($get_ohs_req) > 0 ){
                //     OhsRequirements::where('id', $request->id)->delete();
                // }

                OhsRequirements::where('counter', $request->ohs_requirements_counter)
                ->update([
                    // 'counter'          => $request->ohs_requirements_counter,
                    'ohs_requirement1' => $request->discuss_pmi_ehs,
                    'ohs_requirement2' => $request->discuss_approved_ohs,
                    'ohs_requirement3' => $request->bring_and_wear,
                    'ohs_requirement4' => $request->certified_skilled_workers,
                    'ohs_requirement5' => $request->full_body_harness,
                    'ohs_requirement6' => $request->scaffold_strenght,
                    'ohs_requirement7' => $request->scafold_stability,
                    'ohs_requirement8' => $request->strictly_no_passage,
                    'ohs_requirement9' => $request->provide_appropriate_barricade,
                    'ohs_requirement10' => $request->provide_appropriate_safety_net,
                    'ohs_requirement11' => $request->insulated_ppe,
                    'ohs_requirement12' => $request->no_lifting_activity,
                    'ohs_requirement13' => $request->strictly_tools,
                    'ohs_requirement14' => $request->fire_extinguisher,
                    'ohs_requirement15' => $request->stricty_no_flammable,
                    'ohs_requirement16' => $request->fire_blanket,
                    'ohs_requirement17' => $request->gas_cylinder,
                    'ohs_requirement18' => $request->strictly_observed_buddy,
                    'ohs_requirement19' => $request->conduct_daily,
                    'ohs_requirement20' => $request->practice_safety_first,
                    'ohs_requirement21' => $request->others_participate

                ]);


                // return 'qqweqwe';
                return response()->json(['result' => "1"]);
            }
            else{
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }

        }

        public function edit_ohs_work_permit(Request $request){
            $data = $request->all(); // collect all input fields

            $validator = Validator::make($data, [
                // 'edit_plc_category' => 'required|string|max:255'
            ]);

            // return $data;



            if($validator->fails()) {
                return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
            }
            else{

                $data_x = array();
                //  $data1 = $request->inside_pmi_type.",".$request->outside_pmi.",".$request->HeightsPmi.",".$request->HotWorksPmi.",".$request->ConfineSpacePmi;

                if($request->edit_inside_pmi_type != ""){
                    $data_x[]=$request->edit_inside_pmi_type;
                }
                if($request->edit_outside_pmi != ""){
                    $data_x[]=$request->edit_outside_pmi;
                }
                if($request->edit_heights_pmi != ""){
                    $data_x[]=$request->edit_heights_pmi;
                }
                if($request->edit_hot_works_pmi != ""){
                    $data_x[]=$request->edit_hot_works_pmi;
                }
                if($request->edit_confine_space_pmi != ""){
                    $data_x[]=$request->edit_confine_space_pmi;
                }

                $data_y = implode(", ", $data_x);

                WorkPermitInformation::where('id', $request->work_permit_id)
                    ->update([ // The update method expects an array of column and value pairs representing the columns that should be updated.
                        'classification' =>                    $request->edit_work_classification,
                        'work_permit_type' =>                  $data_y,
                        'division' =>                          $request->edit_division,
                        // 'person_in_charge' =>                  $request->edit_txtperson_in_charge, //christian may 22, 2024
                        'department' =>                        $request->edit_txtperson_in_charge_department,
                        'activity' =>                          $request->edit_txt_activity,
                        // 'description' =>                       $request->txt_description,
                        'local_number' =>                      $request->edit_txt_localnumber,
                        'location' =>                          $request->edit_txt_location,
                        'contractor_id' =>                     $request->edit_dd_contractor,
                        'contractor_pic_id' =>                 $request->edit_dd_contractor_person_in_charge,
                        'contractor_soic_id' =>                $request->edit_dd_contractor_safety_officer_in_charge,
                        'work_schedule' =>                     $request->edit_txt_work_schedule,
                        'start_date' =>                        $request->edit_start_date,
                        'end_date' =>                          $request->edit_end_date,
                        'start_time' =>                        $request->edit_start_time,
                        'end_time' =>                          $request->edit_end_time,
                        'moc1'      =>                         $request->moc1,
                        'moc2'      =>                         $request->moc2,
                        'moc3'      =>                         $request->moc3
                        // 'status' =>                            '0',
                        //  'approver'    =>                       '----',
                        // 'counter' =>                           $request->counter,
                        // 'logdel' => 0
                    ]);

                    ApproverEmailRecipient::where('id', $request->work_permit_id)
                    ->update([
                        'project_in_charge' => $request->edit_project_in_charge,
                        'safety_officer_in_charge_id' => $request->edit_safety_officer_in_charge,
                        'over_all_safety_officer_id' => $request->edit_over_all_safety_officer,
                        'hrd_manager_id' => $request->edit_hrd_manager,
                        'ems_manager_id' => $request->edit_ems_manager,
                        // 'counter' => $request->counter,
                        'logdel' => 0

                    ]);

                    // Worker::where('id', $request->work_permit_id)
                    // ->update([

                    //     'name' => $worker_name,
                    //     // 'position' => $worker_position,
                    //     // 'training_date' => $ohs_training_date,
                    //     // 'training_certificate_date' => $skills_training_date,
                    //     // 'training_submission_date' => $certificate_submission_date,
                    //     'counter' => $request->counter,
                    //     'logdel' => 0

                    //  ]);
        }
        return response()->json(['result' => "1"]);
    }

    //============================== DELETE WORK PERMIT ==============================
    public function delete_work_permit(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all(); // collect all input fields

        try{
            WorkPermitInformation::where('id', $request->delete_work_permit_id)
            ->update([ // The update method expects an array of column and value pairs representing the columns that should be updated.
                'logdel' => 1, // deleted
                // 'last_updated_by' => $_SESSION['user_id'], // to track edit operation
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            /*DB::commit();*/
            return response()->json(['result' => "1"]);
        }
        catch(\Exception $e) {
            DB::rollback();
            // throw $e;
            return response()->json(['result' => "0", 'tryCatchError' => $e->getMessage()]);
        }
    } // DELETE WORK PERMIT END

    public function get_work_permit_id_to_extend(Request $request)
    {
        $workpermit = WorkPermitInformation:: with([
            'contractor_person_in_charge',
            'contractor_safety_officer_in_charge',
            'contractor_id'
            ])
            ->where('counter', $request->extend_work_permit_id)->get();

            // return $workpermit;

        return response()->json(['permit_number' => $workpermit]);

    }

    public function extend_work_permit(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all(); // collect all input fields

        $work_permit_detailss = WorkPermitInformation::
            with(['approver_in_charge','contractor_id_name'])
            ->where('counter', $request->extend_work_permit_id)
            ->get();

        // return 'qwe';

        $get_data = ['data' => $work_permit_detailss];

        $ids = ApproverEmailRecipient::where('counter', $request->extend_work_permit_id)->get();


        $extended_recipients = RapidXUser::whereIn('id', [$ids[0]->over_all_safety_officer_id])->pluck('email')->toArray();


            Mail::send('emails.work_permit_extended_for_approval', $get_data, function($message) use ($extended_recipients) {
                $message->to($extended_recipients)
                ->bcc('mrronquez@pricon.ph')
                ->bcc('rpesposo@pricon.ph')
                ->bcc('edpamaong@pricon.ph')
                ->bcc('mrdepidep@pricon.ph')
                ->bcc('nvmanuel@pricon.ph')
                ->subject('OHS Work Permit Extended For Approval');

            });

            WorkPermitInformation::where('id', $request->extend_work_permit_id)
            ->update([ // The update method expects an array of column and value pairs representing the columns that should be updated.
                'prolong_start_date' => $request->prolong_start_date,
                'prolong_start_time' => $request->prolong_start_time,
                'prolong_end_date' => $request->prolong_end_date,
                'prolong_end_time' => $request->prolong_end_time,
                // 'reason' => $request->prolong_work_permit_reason,
                'status' => 9,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            /*DB::commit();*/
            return response()->json(['result' => "1"]);


    } // EXTEND WORK PERMIT END

        //===== DISPLAY DATATABLES OF CONTRACTORS =====//
        public function view_all_work_permit(Request $request)
        {
            session_start();
            $rapidx_user_id = $_SESSION['rapidx_user_id'];
            $rapidx_user_name = $_SESSION['rapidx_name'];


            // return $rapidx_user_id;

                // return $approver;

            // $workpermit = WorkPermitInformation::with([
            //     'approver_in_charge',
            //     'approver_in_charge.safety_officer_in_charge',
            //     'approver_in_charge.over_all_safety_officer',
            //     'approver_in_charge.hrd_manager',
            //     'approver_in_charge.ems_manager',
            //     'contractor_id_name'

            //     ])
            //     ->where('logdel', 0)
            //     ->orderBy('id', 'DESC')
            //     ->get();
            $workpermit = WorkPermitInformation::with([
                'approver_in_charge',
                'approver_in_charge.safety_officer_in_charge',
                'approver_in_charge.over_all_safety_officer',
                'approver_in_charge.hrd_manager',
                'approver_in_charge.ems_manager',
                'contractor_id_name'
                ])
                ->orderBy('id','DESC')
                ->get();

                $approver = ApproverEmailRecipient::with([
                    'work_permit_details',
                    'work_permit_details.contractor_id_name'
                ])
                ->where('logdel', 0)
                ->where('safety_officer_in_charge_id', $rapidx_user_id)
                ->orWhere('over_all_safety_officer_id', $rapidx_user_id)
                ->orWhere('hrd_manager_id', $rapidx_user_id)
                ->orWhere('ems_manager_id', $rapidx_user_id)
                ->orWhere('project_in_charge', $rapidx_user_name)
                ->orderBy('id', 'DESC')
                ->get();


            if(isset($request->approved)){
                $approver = collect($approver)->whereIn('work_permit_details.status',['8','14']);
            }

            if(isset($request->forApproval)){
                $approver = collect($approver)->whereIn('work_permit_details.status',['0','1','2','3','4','5','6','7']);
            }

            // if(isset($request->forMyApproval)){
            //     $approver = ApproverEmailRecipient::whereHas('work_permit_details', function($q) use ($rapidx_user_id){
            //         $q->where('hrd_manager_id','LIKE', $rapidx_user_id);
            //     })->get();

            //     // return $approver;
            // }


            return DataTables::of($workpermit)

            ->addColumn('status', function ($workpermit) {
                $result = "";
                $result = '<center>';
                    if($workpermit->status == 0){
                        $result .= '<span class="badge badge-pill badge-warning">Approval of</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">Person in-Charge</span>';
                    }else if($workpermit->status == 1){
                        $result .= '<span class="badge badge-pill badge-warning">Approval of</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">Safety Officer in-Charge</span>';
                    }else if($workpermit->status == 2){
                        $result .= '<span class="badge badge-pill badge-warning">Approval of</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">Over-all Safety Officer</span>';
                    }
                    else if($workpermit->status == 3){
                        $result .= '<span class="badge badge-pill badge-warning">Approval of</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">HRD Manager</span>';
                    }
                    else if($workpermit->status == 4){
                        $result .= '<span class="badge badge-pill badge-success">Work Permit Approved</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">Waiting for Clearance</span>';
                    }
                    else if($workpermit->status == 5){
                        $result .= '<span class="badge badge-pill badge-success">Work Permit Cleared</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">Approval of EMS Manager</span>';
                    }
                    else if($workpermit->status == 6){
                        $result .= '<span class="badge badge-pill badge-success">Work Permit Approved</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">Approval of</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">Over-All Safety Officer</span>';

                    }
                    else if($workpermit->status == 7){
                        $result .= '<span class="badge badge-pill badge-success">Work Permit Approved</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">Approval of HRD Manager-</span>';
                    }
                    else if($workpermit->status == 8){
                        $result .= '<span class="badge badge-pill badge-success">Work Permit Done</span>';
                    }
                    else if($workpermit->status == 9){
                        $result .= '<span class="badge badge-pill badge-secondary">Work Permit Extended</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">For Approval of Over-all Safety Officer</span>';
                    }

                    else if($workpermit->status == 10){
                        $result .= '<span class="badge badge-pill badge-success">Work Permit Extended</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">Waiting for Clearance</span>';
                    }

                    else if($workpermit->status == 11){
                        $result .= '<span class="badge badge-pill badge-success">Work Permit Cleared</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">Approval of EMS Manager</span>';
                    }

                    else if($workpermit->status == 12){
                        $result .= '<span class="badge badge-pill badge-success">Work Permit Approved</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">Approval of</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">Over-All Safety Officer</span>';

                    }

                    else if($workpermit->status == 13){
                        $result .= '<span class="badge badge-pill badge-success">Work Permit Approved</span>';
                        $result .='<br>';
                        $result .= '<span class="badge badge-pill badge-warning">Approval of HRD Manager-</span>';
                    }

                    else if($workpermit->status == 14){
                        $result .= '<span class="badge badge-pill badge-success">Work Permit Done</span>';
                        $result .= '<span class="badge badge-pill badge-success">Work Permit Extended</span>';
                    }

                    return $result;
            })
            //  ->addColumn('classification', function ($workpermit){
            //      $result = "";
            //      $result = '<center>';
            //      if($approver->classification == 0){
            //          $result = '<center><span class="badge badge-pill badge-primary">Normal</span></center>';
            //      } else if ($approver->classification == 1) {
            //          $result = '<center><span class="badge badge-pill badge-danger">Urgent</span></center>';
            //      }
            //      return $result;

            //  })
            ->addColumn('approver', function ($workpermit){
                $result = "";
                $result = '<center>';
                if($workpermit->approver_in_charge != ''){
                    switch($workpermit->status){
                        case 0:
                        {

                            $result .= '<span class="badge badge-pill badge-warning"> '.$workpermit->approver_in_charge->project_in_charge.'</span>';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                            break;
                        }

                        case 1:
                        {

                            $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->project_in_charge.'</span>';
                            $result .= '<br>';
                            $result .= ''.$workpermit->approver_in_charge->pic_apprv_date_time.'';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-warning"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';
                            $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                            break;
                        }
                        case 2:
                            {

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->project_in_charge.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->pic_apprv_date_time.'';
                                $result .= '<br>';



                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-warning"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                break;
                            }
                            case 3:
                                {

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->project_in_charge.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->pic_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->oaso_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-warning"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                break;

                                }

                        case 4:
                            {

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->project_in_charge.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->pic_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->oaso_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->hrd_apprv_date_time.'';

                                break;
                            }
                        case 5:
                            {
                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->project_in_charge.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->pic_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->oaso_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->hrd_apprv_date_time.'';

                                break;
                            }
                        case 6:
                            {

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->project_in_charge.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->pic_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->oaso_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->hrd_apprv_date_time.'';

                                break;
                            }
                        case 7:
                            {
                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->project_in_charge.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->pic_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->oaso_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->hrd_apprv_date_time.'';

                                break;
                            }
                        case 8:
                            {
                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->project_in_charge.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->pic_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->oaso_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->hrd_apprv_date_time.'';

                                break;
                            }

                            case 9:
                                {
                                    // $result .= '<span class="badge badge-pill badge-secondary">Work Permit Extended</span>';
                                    // $result .= '<br>';
                                    $result .= '<span class="badge badge-pill badge-warning"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                    $result .= '<br>';

                                    break;
                                }
                            case 10:
                                {
                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->project_in_charge.'</span>';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                    $result .= '<br>';
                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                    $result .= '<br>';
                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                    // $result .= '<br>';
                                    // $result .= '<span class="badge badge-pill badge-warning"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                    break;
                                }
                            case 11:
                                {
                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->project_in_charge.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->pic_apprv_date_time.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->wp_extended_apprv_date_time_oaso.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                    // $result .= '<br>';
                                    // $result .= ''.$workpermit->approver_in_charge->hrd_apprv_date_time.'';

                                    break;
                                }
                            case 12:
                                {
                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->project_in_charge.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->pic_apprv_date_time.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->wp_extended_apprv_date_time_oaso.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->hrd_apprv_date_time.'';
                                    break;
                                }
                            case 13:
                                {
                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->project_in_charge.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->pic_apprv_date_time.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->wp_extended_apprv_date_time_oaso.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->hrd_apprv_date_time.'';
                                    break;
                                }
                            case 14:
                                {
                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->project_in_charge.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->pic_apprv_date_time.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->wp_extended_apprv_date_time_oaso.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->hrd_apprv_date_time.'';
                                    break;
                                }
                    }
                }

                return $result;

            })

            ->addColumn('start_date', function ($workpermit){
                // $result = "";
                // $date = $workpermit->start_date;
                // $result .= Carbon::parse($date)->format('M d, Y');

                // return $result;

                $status = $workpermit->status;
                if ($status > 8){
                    $result = "";
                    $date = $workpermit->prolong_start_date;
                    $result .= Carbon::parse($date)->format('M d, Y');

                    return $result;
                }else{
                    $result = "";
                    $date = $workpermit->start_date;
                    $result .= Carbon::parse($date)->format('M d, Y');

                    return $result;
                }

            })

            ->addColumn('end_date', function ($workpermit){
                // $result = "";
                // $date = $workpermit->end_date;
                // $result .= Carbon::parse($date)->format('M d, Y');

                // return $result;

                $status = $workpermit->status;
                if ($status > 8){
                    $result = "";
                    $date = $workpermit->prolong_end_date;
                    $result .= Carbon::parse($date)->format('M d, Y');

                    return $result;
                }else{
                    $result = "";
                    $date = $workpermit->end_date;
                    $result .= Carbon::parse($date)->format('M d, Y');

                    return $result;
                }

            })

            ->addColumn('clearance', function ($workpermit){
                $result = "";
                $result = '<center>';
                if($workpermit->approver_in_charge != ''){

                    switch($workpermit->status)
                    {
                        case 4:
                        {
                            $result .= '<span class="badge badge-pill badge-warning"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                            $result .= '<br>';

                            $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->ems_manager->name.'</span>';
                            $result .= '<br>';
                            $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                            $result .= '<br>';
                            $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                            break;
                        }

                        case 5:
                            {

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time2.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-warning"> '.$workpermit->approver_in_charge->ems_manager->name.'</span>';
                                $result .= '<br>';


                                $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                break;
                            }

                        case 6:
                            {
                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time2.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->ems_manager->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->ems_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-warning"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                $result .= '<br>';
                                $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                break;
                            }

                        case 7:
                            {
                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time2.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->ems_manager->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->ems_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->oaso_apprv_date_time2.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-warning"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                break;
                            }

                        case 8:
                            {
                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->soic_apprv_date_time2.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->ems_manager->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->ems_apprv_date_time.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->oaso_apprv_date_time2.'';
                                $result .= '<br>';

                                $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                $result .= '<br>';
                                $result .= ''.$workpermit->approver_in_charge->hrd_apprv_date_time2.'';

                                break;
                            }

                            case 10:
                                {
                                    $result .= '<span class="badge badge-pill badge-warning"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->ems_manager->name.'</span>';
                                    $result .= '<br>';
                                    $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                    $result .= '<br>';
                                    $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                    break;
                                }

                            case 11:
                                {

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->wp_extended_apprv_soic.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-warning"> '.$workpermit->approver_in_charge->ems_manager->name.'</span>';
                                    $result .= '<br>';
                                    $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                    $result .= '<br>';
                                    $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                    break;
                                }

                            case 12:
                                {
                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->wp_extended_apprv_soic.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->ems_manager->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->wp_extended_apprv_ems.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-warning"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-light"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                    break;
                                }

                            case 13:
                                {
                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->wp_extended_apprv_soic.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->ems_manager->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->wp_extended_apprv_ems.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->wp_extended_apprv_oaso.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-warning"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';
                                    break;
                                }

                            case 14:
                                {
                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->safety_officer_in_charge->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->wp_extended_apprv_soic.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->ems_manager->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->wp_extended_apprv_ems.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->wp_extended_apprv_oaso.'';
                                    $result .= '<br>';

                                    $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->hrd_manager->name.'</span>';

                                    // $result .= '<span class="badge badge-pill badge-success"> '.$workpermit->approver_in_charge->over_all_safety_officer->name.'</span>';
                                    $result .= '<br>';
                                    $result .= ''.$workpermit->approver_in_charge->wp_extended_apprv_hrd.'';
                                    $result .= '<br>';
                                    break;
                                }
                    }
                }

                return $result;
            })

            ->addColumn('action', function ($workpermit) use ($rapidx_user_id,$rapidx_user_name) {
                $result = "";
                $result = '<center>';
                // $result .= '<button class="text-muted btn actionShowWorkPermit" workpermit-id="' . $workpermit->counter . '" data-toggle="modal" data-target="#modalViewRequest" data-keyboard="false"><i class="fa fa-eye" style="color: #40E0D0;"></i> </button>&nbsp;';
                // $result .='<br>';
                // if($workpermit->status < 4){

                    // $result .= '<button class="btn btn-secondary btn-sm text-center actionEditWorkPermit" workpermit-id="' . $workpermit->counter . '" data-toggle="modal" data-target="#modalEditWorkPermit" data-keyboard="false"><i class="fas fa-edit"></i> Edit</button>';
                // }

                // if($workpermit->status <= 8){
                //     $result .= '<button class="btn btn-danger btn-sm text-center actionDeleteWorkPermit" workpermit-id="' . $workpermit->counter . '" data-toggle="modal" data-target="#modalDeleteWorkPermit" data-keyboard="false"><i class="fa fa-trash"></i> Delete</button>';
                //     $result .='<br>';
                //     $result .='<br>';
                // }

                $result .= "<a href = 'export/" .$workpermit->counter. "'><button class='btn btn-info btn-sm'><i class='fas fa-file-export'></i>  Export Work Permit</button></a>";
                // <button class="btn btn-primary"><i class="fas fa-file-export">
                // $result .='<br>';
                // $result .='<br>';

                // if($workpermit->status <= 8 ){

                //     $result .= '<button class="btn btn-primary btn-sm text-center actionExtendWorkPermit" workpermit-id="' . $workpermit->counter . '" data-toggle="modal" data-target="#modalExtendWorkPermit" data-keyboard="false"><i class="far fa-calendar-plus"></i> Extend Work Permit</button>';
                // }
                // $result .='<br>';
                if($workpermit->approver_in_charge != ''){
                    switch($workpermit->status){
                        case 0:{
                            if($workpermit->approver_in_charge->project_in_charge == $rapidx_user_name){
                                $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="1" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Approve</button>';
                                // $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Disapprove</button>';

                            }
                            break;

                        }
                        case 1:{
                            $variable = OhsRequirements::with([
                                'ohs_requirements_id'
                            ])
                            ->where('counter',$workpermit->counter)
                            ->first();
                            //  return $variable;

                            if ($variable->ohs_requirement1 != null || $variable->ohs_requirement2 != null
                            || $variable->ohs_requirement3 != null || $variable->ohs_requirement4 != null || $variable->ohs_requirement5 != null || $variable->ohs_requirement6 != null
                            || $variable->ohs_requirement7 != null || $variable->ohs_requirement8 != null || $variable->ohs_requirement9 != null || $variable->ohs_requirement10 != null
                            || $variable->ohs_requirement11 != null || $variable->ohs_requirement12 != null || $variable->ohs_requirement13 != null || $variable->ohs_requirement14 != null
                            || $variable->ohs_requirement15 != null || $variable->ohs_requirement16 != null || $variable->ohs_requirement17 != null || $variable->ohs_requirement18 != null
                            || $variable->ohs_requirement19 != null || $variable->ohs_requirement20 != null || $variable->ohs_requirement21 != null){
                                if($workpermit->approver_in_charge->safety_officer_in_charge_id == $rapidx_user_id){
                                    $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="2" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Approve</button>';
                                    // $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Disapprove</button>';
                                }
                                // return $variable;
                            }
                            break;
                        }
                        case 2:{
                            if($workpermit->approver_in_charge->over_all_safety_officer_id == $rapidx_user_id){
                                $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="3" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Approve</button>';
                                // $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Disapprove</button>';

                            }
                            break;

                        }
                        case 3:{

                            if($workpermit->approver_in_charge->hrd_manager_id == $rapidx_user_id){
                                $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="4" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Approve</button>';
                                // $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Disapprove</button>';

                            }
                            break;

                        }
                        case 4:{

                            if($workpermit->approver_in_charge->safety_officer_in_charge_id == $rapidx_user_id){
                                $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="5" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Clear</button>';
                                $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionWorkPermitNotClear"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="4" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Not Clear</button>';
                                // $result .= '<button type="button" class="btn btn-outline-primary btn-sm far fa-calendar-plus text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">   Extended</button>';
                                // if ()
                            }
                            break;

                        }
                        case 5:{

                            if($workpermit->approver_in_charge->ems_manager_id == $rapidx_user_id){
                                $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="6" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Approve</button>';
                                // $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Disapprove</button>';

                            }
                            break;

                        }
                        case 6:{

                            if($workpermit->approver_in_charge->over_all_safety_officer_id == $rapidx_user_id){
                                $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="7" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Approve</button>';
                                // $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Disapprove</button>';

                            }
                            break;

                        }
                        case 7:{

                            if($workpermit->approver_in_charge->hrd_manager_id == $rapidx_user_id){
                                $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="8" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">  Approve</button>';
                                // $result .= '<button type="button" class="btn btn-outline-danger btn-sm fa fa-thumbs-down text-center actionDisapproveWorkPermit"" style="width:105px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="0" data-toggle="modal" data-target="#modalDisapprovedWorkPermit" data-keyboard="false">  Disapprove</button>';

                            }
                            break;

                        }

                        case 9:{

                            if($workpermit->approver_in_charge->over_all_safety_officer_id == $rapidx_user_id){
                                $result .= '<button type="button" class="btn btn-outline-secondary btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:150px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="10" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">Approve Extended Work Permit</button>';

                            }
                            break;

                        }

                        case 10:{

                            if($workpermit->approver_in_charge->safety_officer_in_charge_id == $rapidx_user_id){
                                $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:150px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="11" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">Approve</button>';

                            }
                            break;

                        }

                        case 11:{

                            if($workpermit->approver_in_charge->ems_manager_id == $rapidx_user_id){
                                $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:150px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="12" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">Approve</button>';

                            }
                            break;

                        }

                        case 12:{

                            if($workpermit->approver_in_charge->over_all_safety_officer_id == $rapidx_user_id){
                                $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:150px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="13" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">Approve</button>';

                            }
                            break;

                        }

                        case 13:{

                            if($workpermit->approver_in_charge->hrd_manager_id == $rapidx_user_id){
                                $result .= '<button type="button" class="btn btn-outline-success btn-sm fa fa-thumbs-up text-center actionApproveWorkPermit"" style="width:150px;margin:2%;" workpermit-id="' . $workpermit->counter . '" status="14" data-toggle="modal" data-target="#modalApproveWorkPermit" data-keyboard="false">Approve</button>';

                            }
                            break;

                        }

                    }
                }

                return $result;


            })

            ->addColumn('attach_file', function($workpermit){
                $result = "<center>";

                if($workpermit->attach_file == "No File Uploaded"){
                    $result .= '<span class="badge badge-pill badge-danger">No file uploaded!</span>';
                }
                else{

                    $result .= "<a href='download_attach_file/" . $workpermit->id . "' > $workpermit->attach_file </a>";
                }
                    $result .= '</center>';
                    return $result;
            })

            ->rawColumns(['status', 'action','classification','approver','clearance','start_date','end_date','attach_file'])
            ->make(true);


    }
    //===== DISPLAY DATATABLES OF CONTRACTORS END =====//}



}
