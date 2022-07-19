<?php

namespace App\Http\Controllers;

use App\User;
use App\Model\OQCStamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DataTables;
use Mail;
use App\Jobs\SendUserPasswordJob;
use Auth;
use QrCode;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CSVUserImport;

class UserController extends Controller
{
    // Sign In
    public function sign_in(Request $request){
        $user_data = array(
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'status' => "1"
        );

        $validator = Validator::make($user_data, [
            'username' => 'required',
            'password' => 'required|alphaNum|min:8'
        ]);

        if($validator->passes()){
            if(Auth::attempt($user_data)){
                if(Auth::user()->is_password_changed == 0){
                    return response()->json(['result' => "2"]);
                }
                else{
                    return response()->json(['result' => "1"]);
                }
            }
            else{
                return response()->json(['result' => "0", 'error_message' => 'Login Failed!', 'error' => $validator->messages()]);
            }
        }
        else{
            return response()->json(['result' => "0", 'error' => $validator->messages()]);
        }
    }

    // Sign Out
    public function sign_out(Request $request){
        Auth::logout();
        return response()->json(['result' => "1"]);
    }

    // Change Password
    public function change_pass(Request $request){        
        date_default_timezone_set('Asia/Manila');
        $user_data = array(
            'username' => $request->username,
            'password' => $request->password,
            'new_password' => $request->new_password,
            'confirm_password' => $request->confirm_password,
        );

        $validator = Validator::make($user_data, [
            'username' => 'required',
            'password' => 'required|alphaNum|min:8',
            'new_password' => 'required|alphaNum|min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|alphaNum|min:8'
        ]);

        if($validator->passes()){

            if(Auth::attempt($user_data)){
                try{
                    User::where('id', Auth::user()->id)
                        ->increment('update_version', 1, 
                            [
                                'is_password_changed' => 1,
                                'password' => Hash::make($request->new_password),
                                'last_updated_by' => Auth::user()->id,
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]
                        );
                    DB::commit();
                    return response()->json(['result' => "1"]);
                }
                catch(\Exception $e) {
                    DB::rollback();
                    // throw $e;
                    return response()->json(['result' => "0"]);
                }  
                
                return response()->json(['result' => 1]);
            }
            else{
                return response()->json(['result' => "0", 'error' => 'Login Failed!']);
            }
        }
        else{
            return response()->json(['result' => "0", 'error' => $validator->messages()]);
        }
    }

    // Change User Status
    public function change_user_stat(Request $request){        
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => 'required',
            'status' => 'required',
        ]);

        if($validator->passes()){
            try{
                User::where('id', $request->user_id)
                    ->increment('update_version', 1, 
                        [
                            'status' => $request->status,
                            'last_updated_by' => Auth::user()->id,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]
                    );
                DB::commit();
                return response()->json(['result' => "1"]);
            }
            catch(\Exception $e) {
                DB::rollback();
                // throw $e;
                return response()->json(['result' => "0"]);
            }  
            
            return response()->json(['result' => 1]);
        }
        else{
            return response()->json(['result' => "0", 'error' => $validator->messages()]);
        }
    }

    // Reset Password
    public function reset_password(Request $request){        
        date_default_timezone_set('Asia/Manila');

        // $password = 'pmi1234' . Str::random(10);
        $password = 'pmi12345';

        try{
            User::where('id', $request->user_id)
                ->increment('update_version', 1, 
                    [
                        'is_password_changed' => 0,
                        'password' => Hash::make($password),
                        'last_updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]
                );

            $has_email = 0;
            $user = User::where('id', $request->user_id)->get();

            if(count($user) > 0 && $user[0]->email != ""){
                $has_email = 1;
                // $has_email = 0;
                $subject = 'PATS User Reset Password';
                $email = $user[0]->email;
                $message = 'This is a notification from PATS. Your PATS user password account was successfully reset.';

                dispatch(new SendUserPasswordJob($subject, $message, $user[0]->username, $password, $email));
            }
            DB::commit();
            return response()->json(['result' => "1", 'user' => $user, 'has_email' => $has_email, 'password' => $password]);
        }
        catch(\Exception $e) {
            DB::rollback();
            // throw $e;
            return response()->json(['result' => "0"]);
        } 
    }

    //View Users
	public function view_users(){
    	$users = User::with([
                    'user_level',
                ])
                ->get();

        return DataTables::of($users)
            ->addColumn('label1', function($user){
                $result = "";

                if($user->status == 1){
                    $result .= '<span class="badge badge-pill badge-success">Active</span>';
                }
                else{
                    $result .= '<span class="badge badge-pill badge-danger">Inactive</span>';
                }

                return $result;
            })
            ->addColumn('action1', function($user){
                $result = '<center><div class="btn-group">
                          <button type="button" class="btn btn-primary dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Action">
                            <i class="fa fa-cog"></i> 
                          </button>
                          <div class="dropdown-menu dropdown-menu-right">';
                if($user->status == 1){
                	$result .= '<button class="dropdown-item aEditUser" type="button" user-id="' . $user->id . '" style="padding: 1px 1px; text-align: center;" data-toggle="modal" data-target="#modalEditUser" data-keyboard="false">Edit</button>';

                    $result .= '<button class="dropdown-item aChangeUserStat" type="button" user-id="' . $user->id . '" status="2" style="padding: 1px 1px; text-align: center;" data-toggle="modal" data-target="#modalChangeUserStat" data-keyboard="false">Deactivate</button>';

                    $result .= '<button class="dropdown-item aResetUserPass" user-id="' . $user->id . '" type="button" style="padding: 1px 1px; text-align: center;" data-toggle="modal" data-target="#modalResetUserPass" data-keyboard="false">Reset Password</button>';

                    // $result .= '<button class="dropdown-item aGenUserBarcode" user-id="' . $user->id . '" employee-id="' . $user->employee_id . '" type="button" style="padding: 1px 1px; text-align: center;" data-toggle="modal" data-target="#modalGenUserBarcode">Generate Barcode</button>';
                }
                else{
                    $result .= '<button class="dropdown-item aChangeUserStat" type="button" style="padding: 1px 1px; text-align: center;" user-id="' . $user->id . '" status="1" data-toggle="modal" data-target="#modalChangeUserStat" data-keyboard="false">Activate</button>';
                }
                            
                $result .= '</div>
                        </div></center>';

                return $result;
            })
            ->addColumn('checkbox', function($user){
                return '<center><input type="checkbox" class="chkUser" user-id="' . $user->id . '"></center>';
            })
            ->rawColumns(['label1', 'action1', 'checkbox'])
            ->make(true);
    }

    // Add User
    public function add_user(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();

        $email = '';
        $has_email = 0;
        // $password = 'pmi1234' . Str::random(10);
        $password = 'pmi12345';

        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'user_level_id' => 'required|string|max:255',
        ];

        if(isset($request->with_email)){
            $rules['email'] = 'required|string|max:255|unique:users';
            $has_email = 1;
            // $has_email = 0;
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        }
        else{
            DB::beginTransaction();

            // try{
                $user_id = User::insertGetId([
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($password),
                    'is_password_changed' => 0,
                    'status' => 1,
                    'user_level_id' => $request->user_level_id,
                    'created_by' => Auth::user()->id,
                    'last_updated_by' => Auth::user()->id,
                    'update_version' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                if(isset($request->send_email)){
                    $subject = 'PATS User Registration';
                    $email = $request->email;
                    $message = 'This is a notification from PATS. Your PATS user account was successfully registered.';

                    dispatch(new SendUserPasswordJob($subject, $message, $request->username, $password, $email));
                }

                DB::commit();

                return response()->json(['result' => "1", 'password' => $password, 'has_email' => $has_email, 'username' => $request->username]);
            // }
            // catch(\Exception $e) {
            //     DB::rollback();
            //     // throw $e;
            //     return response()->json(['result' => "0"]);
            // }
        }
    }

    // Get User By Id
    public function get_user_by_id(Request $request){
        $user = User::where('id', $request->user_id)->get();

        return response()->json(['user' => $user]);
    }

    public function get_user_list(Request $request){
        $users = User::all();

        return response()->json(['users' => $users]);
    }

    // Get User By Batch
    public function get_user_by_batch(Request $request){
        $users;

        if($request->user_id == 0){
            $users = User::all();
        }
        else{
            $users = User::whereIn('id', $request->user_id)->get();
        }
        $qrcode = [];

        if($users->count() > 0){
            for($index = 0; $index < $users->count(); $index++){
                $qrcode[] = "data:image/png;base64," . base64_encode(QrCode::format('png')
                                    ->size(200)->errorCorrection('H')
                                    ->generate($users[$index]->employee_id));
            }
        }

        return response()->json(['users' => $users, 'qrcode' => $qrcode]);
    }

    // Get User By Status
    public function get_user_by_stat(Request $request){
        $user = User::where('status', $request->status)->get();
        return response()->json(['user' => $user]);
    }

    // Edit User
    public function edit_user(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();

        // $password = 'pmi1234' . Str::random(10);
        $password = 'pmi12345';

        if(isset($request->with_email)){
            $validator = Validator::make($data, [
                'name' => 'required|string|max:255|unique:users,name,'. $request->user_id,
                'username' => 'required|string|max:255|unique:users,username,'. $request->user_id,
                'email' => 'required|string|max:255|unique:users,email,'. $request->user_id,
                'user_level_id' => 'required|string|max:255|',
            ]);
        }
        else{
            $validator = Validator::make($data, [
                'name' => 'required|string|max:255|unique:users,name,'. $request->user_id,
                'username' => 'required|string|max:255|unique:users,username,'. $request->user_id,
                'user_level_id' => 'required|string|max:255|',
            ]);
        }

        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        }
        else{
            DB::beginTransaction();

            try{
                User::where('id', $request->user_id)
                ->increment('update_version', 1,
                [
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'user_level_id' => $request->user_level_id,
                    'last_updated_by' => Auth::user()->id,
                    'update_version' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                
                DB::commit();

                return response()->json(['result' => "1"]);
            }
            catch(\Exception $e) {
                DB::rollback();
                // throw $e;
                return response()->json(['result' => "0"]);
            }
        }
    }

    public function generate_user_qrcode(Request $request){
        // action: 1-Add, 2-Edit, 3-Generate Only
        
        // $user = [];
        // if($request->action == "1" || $request->action == "3"){
        //     $user = User::where('employee_id', $request->qrcode)->get();
        // }
        // else if($request->action == "2"){
        //     $user = User::where('employee_id', $request->qrcode)
        //                 ->where('id', '!=', $request->user_id)
        //                 ->get();   
        // }

        // $user = User::where('id', $request->user_id)->get();

        // $qrcode = $user[0]->barcode;

        try{
            if(isset($request->qrcode)){
                $user = User::where('employee_id', $request->qrcode)->get();

                $qrcode = QrCode::format('png')
                        ->size(200)->errorCorrection('H')
                        ->generate($request->qrcode);

                return response()->json(['result' => "1", 'qrcode' => "data:image/png;base64," . base64_encode($qrcode), 'user' => $user]);
            }
            else{
                return response()->json(['result' => "0"]);
            }
        }
        catch(\Exception $e){
            return response()->json(['result' => "0"]);
        }

        // if(count($user) <= 0){
        //     try{
        //         if(isset($request->qrcode)){
        //             $qrcode = QrCode::format('png')
        //                     ->size(200)->errorCorrection('H')
        //                     ->generate($request->qrcode);

        //             return response()->json(['result' => "1", 'qrcode' => "data:image/png;base64," . base64_encode($qrcode)]);
        //         }
        //         else{
        //             return response()->json(['result' => "0"]);
        //         }
        //     }
        //     catch(\Exception $e){
        //         return response()->json(['result' => "0"]);
        //     }
        // }
        // else{
        //     return response()->json(['result' => "2"]);
        // }
    }

    public function import_user(Request $request)
    {
        $collections = Excel::toCollection(new CSVUserImport, request()->file('import_file'));

        // $password = 'pmi1234' . Str::random(10);
        $password = 'pmi12345';
        $user_level_id = 3;

        DB::beginTransaction();
        try{
            for($index = 1; $index < count($collections[0]); $index++){
                if($collections[0][$index][4] == 0){
                    $user_level_id = 2;
                }
                else{
                    $user_level_id = 3;
                }

                $user_id = User::insertGetId([
                    'name' => $collections[0][$index][0],
                    'username' => $collections[0][$index][1],
                    'email' => $collections[0][$index][2],
                    'employee_id' => $collections[0][$index][3],
                    'password' => Hash::make($password),
                    'position' => $collections[0][$index][4],
                    'user_level_id' => $user_level_id,
                    'is_password_changed' => 0,
                    'status' => 1,
                    'created_by' => Auth::user()->id,
                    'last_updated_by' => Auth::user()->id,
                    'update_version' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                if(trim($collections[0][$index][5]) != ""){
                    OQCStamp::insert([
                        'user_id' => $user_id,
                        'oqc_stamp' => $collections[0][$index][5],
                        'created_by' => Auth::user()->id,
                        'last_updated_by' => Auth::user()->id,
                        'update_version' => 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }

            DB::commit();

            return response()->json(['result' => "1"]);
        }    
        catch(\Exception $e) {
            DB::rollback();
            return response()->json(['result' => $e]);
        }
    }
}
