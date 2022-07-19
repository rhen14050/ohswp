<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
Use App\UserApprover;
use DataTables;
use App\RapidXUser;


class UserApproverController extends Controller
{
    //===== DISPLAY DATATABLES OF CONTRACTORS =====//
public function view_user_approver()
{
    $user_approver = UserApprover::all();
    // $test = ContractorContactPerson::all();
    //  return $test;

    return DataTables::of($user_approver)
    ->addColumn('fullname',function($user_approver){
        $result = $user_approver->rapidx_user_details->name;
        return $result;
    })

    ->addColumn('username',function($user_approver){
        $result = $user_approver->rapidx_user_details->username;
        return $result;
    })

    ->addColumn('emp_email',function($user_approver){
        $result = $user_approver->rapidx_user_details->email;
        return $result;
    })

    ->addColumn('status', function($user_approver){
        $result = "<center>";
        if($user_approver->status == 0){
            $result .= '<span class="badge badge-pill badge-success">Active</span>';
        }
        else{
            $result .= '<span class="badge badge-pill badge-danger">Inactive</span>';
        }
            $result .= '</center>';
            return $result;
    })
        ->addColumn('action', function ($user_approver) {
            $result = "";
            //===== DISPLAY EDIT BUTTON IN CONTRACTOR DATATABLES =====//
            $result .= '<button class="btn btn-primary text-center actionEditApprover" approver-id="' . $user_approver->id . '" data-toggle="modal" data-target="#modalEditApprover" data-keyboard="false"><i class="nav-icon fas fa-edit"></i> Edit</button>&nbsp;';

            //===== CHECK IF CONTRACTOR IS ACTIVE OR INACTIVE TO DISPLAY ACTIVATION AND DEACTIVATION BUTTON =====//
            //===== IF ACTIVE, DISPLAY DEACTIVATION BUTTON =====//
            //===== IF INACTIVE, DISPLAY ACTIVATION BUTTON =====//
            if ($user_approver->status == 0) {
                $result .= '<button class="btn btn-danger text-center actionDeactivateApprover" approver-id="' . $user_approver->id . '"  data-toggle="modal" data-target="#modalDeactivateApprover" data-keyboard="false">Deactivate</button>';
            } else {
                $result .= '<button class="btn btn-success text-center actionActivateApprover" approver-id="' . $user_approver->id . '"  data-toggle="modal" data-target="#modalActivateApprover" data-keyboard="false">Activate</button>';
            }
            return $result;
        })
        ->rawColumns(['status', 'action','classification'])
        ->make(true);

    }


     //=====
     public function load_rapidx_user_list(Request $request)
     {
         $users = RapidXUser::where('user_stat', 1)->orderBy('name','asc')->whereNotIn('name',['Admin','Test QAD Admin Approver'])->get();
         return response()->json(['users' => $users]);
     }

     //============================== ADD USER ==============================
    public function add_user_approver(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();

        $rules = [
            'classification' => 'required|string|max:255',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        }
        else{
            DB::beginTransaction();
            try{
                $approver_id = UserApprover::insert([
                    'employee_no' => $request->employee_no,
                    'rapidx_id' => $request->rapidx_user,
                    'classification' => $request->classification,
                    'status' => '0',
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                DB::commit();
                return response()->json(['result' => "1"]);
            }
            catch(\Exception $e) {
                DB::rollback();
                return response()->json(['result' => $e]);
            }
        }
    }

    public function deactivate_approver(Request $request)
{
    date_default_timezone_set('Asia/Manila');
    session_start();

    $data = $request->all();

    UserApprover::where('id', $request->approver_id)
        ->update([
            'status' => 1
        ]);

    return response()->json(['result' => "1"]);
}

//===== ACTIVATE APPROVER FUNCTION ====//
public function activate_approver(Request $request)
{
      date_default_timezone_set('Asia/Manila');
      session_start();

      $data = $request->all();

      UserApprover::where('id', $request->approver_id)
      ->update([
          'status' => 0
      ]);

    return response()->json(['result' => "1"]);
 }
  //===== ACTIVATE APPROVER FUNCTION END ====//

  //============================== GET USER BY ID TO EDIT ==============================
  public function get_approver_by_id(Request $request){
    $approver = UserApprover::with('rapidx_user_details')->where('id', $request->approver_id)->get(); // get all users where id is equal to the user-id attribute of the dropdown-item of actions dropdown(Edit)
    // return $approver;

    return response()->json(['user' => $approver]);  // pass the $user(variable) to ajax as a response for retrieving and pass the values on the inputs
}

  //============================== EDIT USER ==============================
  public function edit_approver(Request $request){
    date_default_timezone_set('Asia/Manila');

    $data = $request->all(); // collect all input fields

    $validator = Validator::make($data, [
        'classification' => 'required|string|max:255',
        'employee_no' => 'required|string|max:255',
    ]);

    if($validator->fails()) {
        return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
    }
    else{
        /* DB::beginTransaction();*/
        try{
            UserApprover::where('id', $request->approver_id)
            ->update([ // The update method expects an array of column and value pairs representing the columns that should be updated.
                'rapidx_id' => $request->rapidx_user,
                'employee_no' => $request->employee_no,
                'classification' => $request->classification,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            /*DB::commit();*/
            return response()->json(['result' => "1"]);
        }
        catch(\Exception $e) {
            DB::rollback();
            // throw $e;
            return response()->json(['result' => "0", 'tryCatchError' => $e]);
        }
    }
}

}
