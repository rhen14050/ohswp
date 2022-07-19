<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Contractor;
use App\ContractorContactPerson;
use DataTables;

class ContractorController extends Controller
{
   //============================== GET TOTAL USERS FOR DASHBOARD ==============================
   public function get_total_contractor(){
    $contractor = Contractor::where('status', 0)->get();

    $totalContractor = count($contractor);
    return response()->json(['totalContractors' => $totalContractor]);
}



public function get_contractor(Request $request)
{
    $contractors = Contractor::all();
    return response()->json(['contractor' => $contractors]);
}

 //===== DISPLAY DATATABLES OF CONTRACTORS =====//
    public function view_contractors()
    {
        $contractors = Contractor::all();
        // $test = ContractorContactPerson::all();
        //  return $test;

        return DataTables::of($contractors)
            ->addColumn('status', function ($contractor) {
                $result = "";
                if ($contractor->status == 0) {
                    $result .= '<center><span class="badge badge-pill badge-success">Active</span></center>';
                } else {
                    $result .= '<center><span class="badge badge-pill badge-secondary">Inactive</span></center>';
                }
                return $result;
            })
            ->addColumn('action', function ($contractor) {
                $result = "";
                //===== DISPLAY EDIT BUTTON IN CONTRACTOR DATATABLES =====//
                $result .= '<button class="btn btn-primary text-center actionEditContractor" contractor-id="' . $contractor->id . '" data-toggle="modal" data-target="#modalEditContractor" data-keyboard="false"><i class="fas fa-edit"></i> Edit</button>&nbsp;';

                //===== CHECK IF CONTRACTOR IS ACTIVE OR INACTIVE TO DISPLAY ACTIVATION AND DEACTIVATION BUTTON =====//
                //===== IF ACTIVE, DISPLAY DEACTIVATION BUTTON =====//
                //===== IF INACTIVE, DISPLAY ACTIVATION BUTTON =====//
                if ($contractor->status == 0) {
                    $result .= '<button class="btn btn-danger text-center actionDeactivateContractor" contractor-id="' . $contractor->id . '"  data-toggle="modal" data-target="#modalDeactivateContractor" data-keyboard="false">Deactivate</button>';
                } else {
                    $result .= '<button class="btn btn-success text-center actionActivateContractor" contractor-id="' . $contractor->id . '"  data-toggle="modal" data-target="#modalActivateContractor" data-keyboard="false">Activate</button>';
                }
                return $result;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    //===== DISPLAY DATATABLES OF CONTRACTORS END =====//

    //===== ADD CONTRACTOR FUNCTION ====//
    public function add_contractor(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $validator = Validator::make($data, [
            'contractor_company' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {

        //  if ($request->hasFile('add_esignature')) {

             // $generated_filename = "JO_RequestV2_attachment_" . date('YmdHis');
            //  $original_filename = $request->file('add_esignature')->getClientOriginalName();
            //  $file_extension = $request->file('add_esignature')->getClientOriginalExtension();
             // $jo_request_attachment_filename = $generated_filename . "." . $file_extension;

                try {
                    // Storage::putFileAs('public/e_signatures/', $request->add_esignature, $original_filename);

                    Contractor::insert([
                        'company' => $request->contractor_company,
                        // 'e_signature' => $original_filename,
                        'status' => 0
                    ]);

                    DB::commit();
                    return response()->json(['result' => "1"]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['result' => "0"]);
                }
            //  }
        }
    }
 //===== ADD CONTRACTOR FUNCTION END ====//

        //===== DEACTIVATE CONTRACTOR FUNCTION ====//
        public function deactivate_contractor(Request $request)
        {
            date_default_timezone_set('Asia/Manila');
            session_start();

            $data = $request->all();

            Contractor::where('id', $request->contractor_id)
                ->update([
                    'status' => 1
                ]);

            return response()->json(['result' => "1"]);
        }

        //===== DEACTIVATE CONTRACTOR FUNCTION END ====//

        //===== ACTIVATE CONTRACTOR FUNCTION ====//
        public function activate_contractor(Request $request)
        {
            date_default_timezone_set('Asia/Manila');
            session_start();

            $data = $request->all();


            Contractor::where('id', $request->contractor_id)
            ->update([
                'status' => 0
            ]);

            // dump($request->contractor_id);

            return response()->json(['result' => "1"]);
        }
        //===== ACTIVATE CONTRACTOR FUNCTION END ====//

        //EDIT CONTRACTOR BY ID FUNCTION
        public function get_id_edit_contractor(Request $request)
        {
            $contractor = Contractor::where('id', $request->contractor_id)->get();

            return response()->json(['contractor_name' => $contractor]);
        }
        //EDIT CONTRACTOR BY ID FUNCTION END

        //EDIT CONTRACTOR FUNCTION
        public function edit_contractor(Request $request)
        {
            date_default_timezone_set('Asia/Manila');
            session_start();

            $data = $request->all();

            $validator = Validator::make($data, [
                'edit_contractor_name' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
            } else {
                // if (Contractor::where('company', $request->contractor_name)->exists()) {
                //     return response()->json(['result' => 0]);
                // } else {


                    // if ($request->hasFile('edit_esignature')) {

                        // $generated_filename = "JO_RequestV2_attachment_" . date('YmdHis');
                        // $original_filename = $request->file('edit_esignature')->getClientOriginalName();
                        // $file_extension = $request->file('edit_esignature')->getClientOriginalExtension();
                        // $jo_request_attachment_filename = $generated_filename . "." . $file_extension;

                        try {
                            // Storage::putFileAs('public/e_signatures/', $request->edit_esignature, $original_filename);

                            Contractor::where('id', $request->contractor_id)
                            ->update([
                            'company' => $request->edit_contractor_name,
                            // 'e_signature'=> $original_filename
                        ]);

                            DB::commit();
                            return response()->json(['result' => "1"]);

                        } catch (\Exception $e) {
                            DB::rollback();
                            return response()->json(['result' => "0"]);
                        }
                    // }
                    // else{
                    //     Contractor::where('id', $request->contractor_id)
                    //     ->update([
                    //     'company' => $request->contractor_name,
                    //     ]);

                    //     return response()->json(['result' => "1"]);

                    // }

                // }
            }
        }

        //EDIT CONTRACTOR END

        //============================== VIEW CONTRACTORS CONTACT DATATABLES ==============================
        public function view_contractors_contact(){
            // $contractors = ContractorContactPerson::with([
            //             'contractor_id',
            //         ])->where('status', 0) // 1-deleted, show all deleted users
            //         ->get();

                $contractors = ContractorContactPerson::with('contractor_id')->get();

                return DataTables::of($contractors)
                ->addColumn('status', function ($contractors) {
                    $result = "";
                    if ($contractors->status == 0) {
                        $result .= '<center><span class="badge badge-pill badge-success">Active</span></center>';
                    } else {
                        $result .= '<center><span class="badge badge-pill badge-secondary">Inactive</span></center>';
                    }
                    return $result;
                })
                        ->addColumn('action', function ($contractors) {
                            $result = "";
                            //===== DISPLAY EDIT BUTTON IN CONTRACTOR DATATABLES =====//
                            $result .= '<button class="btn btn-primary text-center actionEditContractorContact" contact-id="' . $contractors->id . '" data-toggle="modal" data-target="#modalEditContractorContact" data-keyboard="false"><i class="nav-icon fas fa-edit"></i> Edit</button>&nbsp;';

                            //===== CHECK IF CONTRACTOR IS ACTIVE OR INACTIVE TO DISPLAY ACTIVATION AND DEACTIVATION BUTTON =====//
                            //===== IF ACTIVE, DISPLAY DEACTIVATION BUTTON =====//
                            //===== IF INACTIVE, DISPLAY ACTIVATION BUTTON =====//
                            if ($contractors->status == 0) {
                                $result .= '<button class="btn btn-danger text-center actionDeactivateContact" contact-id="' . $contractors->id . '"  data-toggle="modal" data-target="#modalDeactivateContact" data-keyboard="false">Deactivate</button>';
                            } else {
                                $result .= '<button class="btn btn-success text-center actionActivateContact" contact-id="' . $contractors->id . '"  data-toggle="modal" data-target="#modalActivateContact" data-keyboard="false">Activate</button>';
                            }
                            return $result;
                        })
                        ->addColumn('classification', function ($contractor){
                            $result = "";
                            if($contractor->classification == 0){
                                $result = "Person In-Charge";
                            } else if ($contractor->classification == 1) {
                                $result = "Safety Officer In-Charge";
                            }
                            return $result;

                        })
                        ->rawColumns(['status', 'action','classification'])
                        ->make(true);
        } //VIEW CONTRACTORS CONTRACT DATATABLES END

        //===== ADD CONTRACTOR CONTACT FUNCTION ====//
        public function add_contractor_contact(Request $request)
        {
            //  date_default_timezone_set('Asia/Manila');
            //  session_start();

            $data = $request->all();

            //  return $data;

            $validator = Validator::make($data, [
                'contractor_name' => 'required',
                'contractor' => 'required',
                'contractor_email' => 'required',
                'Classification' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
            } else {

            //      // if ($request->hasFile('add_esignature')) {

            //          // $generated_filename = "JO_RequestV2_attachment_" . date('YmdHis');
            //          // $original_filename = $request->file('add_esignature')->getClientOriginalName();
            //          // $file_extension = $request->file('add_esignature')->getClientOriginalExtension();
            //          // $jo_request_attachment_filename = $generated_filename . "." . $file_extension;

                    try {
            //              // Storage::putFileAs('public/e_signatures/', $request->add_esignature, $original_filename);

                        ContractorContactPerson::insert([
                            'name' => $request->contractor_name,
                            'company_id' => $request->contractor,
                            'email' => $request->contractor_email,
                            'Classification' => $request->Classification,
                            'status' => 0
                        ]);

                        DB::commit();
                        return response()->json(['result' => "1"]);

                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json(['result' => "0"]);
                    }
                }
                }
        //  }
        //===== ADD CONTRACTOR CONTACT FUNCTION END ====//

        //===== DEACTIVATE CONTRACTOR CONTACT FUNCTION ====//
        public function deactivate_contractor_contact(Request $request)
        {
            date_default_timezone_set('Asia/Manila');
            session_start();

            $data = $request->all();

            ContractorContactPerson::where('id', $request->contact_id)
                ->update([
                    'status' => 1
                ]);

            return response()->json(['result' => "1"]);
        }

        //===== DEACTIVATE CONTRACTOR CONTACT FUNCTION END ====//

        //===== ACTIVATE CONTRACTOR CONTACT FUNCTION ====//
        public function activate_contractor_contact(Request $request)
        {
            date_default_timezone_set('Asia/Manila');
            session_start();

            $data = $request->all();

            ContractorContactPerson::where('id', $request->contact_id)
            ->update([
                'status' => 0
            ]);

            return response()->json(['result' => "1"]);
        }
        //===== ACTIVATE CONTRACTOR CONTACT FUNCTION END ====//

        //EDIT CONTRACTOR BY ID FUNCTION
        public function get_id_edit_contractor_contact(Request $request)
        {
            $contractor = ContractorContactPerson::where('id', $request->contact_id)->get();

            return response()->json(['contractor_contact_name' => $contractor]);

        }
        //EDIT CONTRACTOR BY ID FUNCTION END

        //EDIT CONTRACTOR FUNCTION
        public function edit_contractor_contact(Request $request)
        {
            date_default_timezone_set('Asia/Manila');
            session_start();

            $data = $request->all();

            $validator = Validator::make($data, [
                'contractor_contact_name',
                'contractor_contact_email',
                'Contact_Classification',
            ]);

            if ($validator->fails()) {
                return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
            } else {

                        try {
                            ContractorContactPerson::where('id', $request->contact_id)
                            ->update([
                            'name' => $request->contractor_contact_name,
                            'email' => $request->contractor_contact_email,
                            'classification' => $request->Contact_Classification,
                        ]);

                            DB::commit();
                            return response()->json(['result' => "1"]);

                        } catch (\Exception $e) {
                            DB::rollback();
                            return response()->json(['result' => "0"]);
                        }
                    }

        }
        //EDIT CONTRACTOR CONTACT FUNCTION END

        }




