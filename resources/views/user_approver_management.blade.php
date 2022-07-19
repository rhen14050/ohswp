@php $layout = 'layouts.super_user_layout'; @endphp

@auth
    @php
    if (Auth::user()->user_level_id == 1) {
        $layout = 'layouts.super_user_layout';
    } elseif (Auth::user()->user_level_id == 2) {
        $layout = 'layouts.admin_layout';
    } elseif (Auth::user()->user_level_id == 3) {
        $layout = 'layouts.user_layout';
    }
    @endphp
@endauth

{{-- Here I removed the @auth because the dashboard isn't loading properly --}}
@extends($layout)
@section('title', 'Contractor Management')

@section('content_page')

<style type="text/css">
    table{
        color: black;
    }

    table.table tbody td{
        vertical-align: middle;
        text-align: center;
    }
</style>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>User Approver</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">User Approver Management</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            {{-- <div class="card-header">
                                <h3 class="card-title">Contractor Management</h3>
                                <button class="btn float-right reload"><i class="fas fa-sync-alt"></i></button>

                            </div> --}}
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="user-management-tab" data-toggle="tab" href="#user-management" role="tab" aria-controls="user-management" aria-selected="true">User Approver Management Tab</a>
                                    </li>
                                    {{-- <button class="btn float-right reload" style="float: right;"><i class="fas fa-sync-alt"></i></button> --}}
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="user-management" role="tabpanel" aria-labelledby="user-management-tab">
                                    <div class="text-right mt-4">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddUserApprover"
                                    style="float: right;"><i class="fa fa-plus fa-md"></i> Add
                                    User Approver</button></div><br><br>

                                <div class="table-responsive">
                                    <table id="userApproverTable"
                                        class="table table-sm table-bordered table-striped table-hover text-center"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%">Employee No.</th>
                                                <th style="width: 10%">Name</th>
                                                <th style="width: 10%">Classification</th>
                                                <th style="width: 10%">Username</th>
                                                <th style="width: 10%">Email</th>
                                                <th style="width: 10%">Status</th>
                                                <th style="width: 10%">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

   <!-- ADD MODAL START -->
   <div class="modal fade" id="modalAddUserApprover">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title"><i class="fa fa-user-plus"></i> Add User Approver</h4>
                <button type="button" style="color: #fff;" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="formAddUserApprover">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Employee No.</label>
                                <input type="text" class="form-control" name="employee_no" id="txtAddUserEmployeeNo" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Name</label>
                                <select class="form-control sel-rapidx-user-list select2bs4" id="selectAddRapidxUser" name="rapidx_user"></select>
                            </div>

                            <div class="form-group">
                                <label>Classification</label>
                                <select class="form-control" name="classification" id="selectAddUserPosition" style="width: 100%;">
                                    <option selected disabled value="">-SELECT-</option>
                                    <option value="Over-all Safety Officer">Over-all Safety Officer</option>
                                    <option value="HRD Manager">HRD Manager</option>
                                    <option value="Safety Officer In-Charge">Safety Officer In-Charge</option>
                                    <option value="EMS Manager">EMS Manager</option>
                                    {{-- <option value="Supervisor">Project in Charge</option> --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="btnAddUserApprover" class="btn btn-primary"><i id="iBtnAddUserApproverIcon" class="fa fa-check"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- ADD MODAL END -->


    <!-- EDIT MODAL START -->
    <div class="modal fade" id="modalEditApprover">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-user-plus"></i> Edit User Approver</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="EditApprover">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Employee No.</label>
                                    <input type="text" class="form-control" name="employee_no" id="txtEditUserEmployeeNo">
                                </div>

                                <div class="col-sm-12">
                                    <input type="hidden" class="form-control" name="approver_id" id="txtApproverID">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <select class="form-control sel-rapidx-user-list select2bs4 selectUser" id="selectEditRapidxUser" name="rapidx_user"></select>
                                    </div>

                                    <div class="form-group">
                                        <label>Classification</label>
                                        <select class="form-control selectClassification" name="classification" id="selectEditUserClassification" style="width: 100%;">
                                            <option selected disabled value="">-SELECT-</option>
                                            <option value="Over-all Safety Officer">Over-all Safety Officer</option>
                                            <option value="HRD Manager">HRD Manager</option>
                                            <option value="Safety Officer In-Charge">Safety Officer In-Charge</option>
                                            <option value="EMS Manager">EMS Manager</option>
                                            {{-- <option value="Supervisor">Project In Charge</option> --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnEditApprover" class="btn btn-primary"><i id="iBtnEditApproverIcon" class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- EDIT MODAL END -->

      <!-- DEACTIVATE CONTRACTOR MODAL START -->
      <div class="modal fade" id="modalDeactivateApprover">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="far fa-file"></i>&nbsp;&nbsp;Deactivate Contractor</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="deactivateApprover">
                    @csrf
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <label class="text-secondary mt-2">Are you sure you want to deactivate this Approve?</label>
                            <input type="hidden" class="form-control" name="approver_id" id="deactivateApproverID">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnDeactivateApprover" class="btn btn-primary"><i id="deactivateApproverIcon"
                                class="fa fa-check"></i> Deactivate</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- DEACTIVATE CONTRACTOR MODAL END -->


    <!-- ACTIVATE CONTRACTOR MODAL START -->
    <div class="modal fade" id="modalActivateApprover">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="far fa-file"></i>&nbsp;&nbsp;Activate Approver</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="activateApprover">
                    @csrf
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">

                            <label class="text-secondary mt-2">Activate this Approver?</label>
                            <input type="hidden" class="form-control" name="approver_id" id="activateApproverID">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnActivateApprover" class="btn btn-primary"><i id="activateApproverIcon"
                                class="fa fa-check"></i> Activate</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- ACTIVATE CONTRACTOR MODAL END -->

@endsection


@section('js_content')
    <script type="text/javascript">


$(document).ready(function () {

            bsCustomFileInput.init();
            //Initialize Select2 Elements
            // $('.select2').select2();

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $('.sel-rapidx-user-list').select2({
                theme: "bootstrap4"
            });

    LoadRapidXUserList($('.sel-rapidx-user-list'));

    //============================== VIEW WORK PERMIT DATATABLES  START ==============================
    dataTableUserApprover = $("#userApproverTable").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "scrollX": true,
                // "scrollX": "100%",
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ records",
                    "lengthMenu":     "Show _MENU_ records",
                },
                "ajax" : {
                    url: "view_user_approver", // this will be pass in the uri called view_users_archive that handles datatables of view_users_archive() method inside UserController
                },
                "columns":[
                    { "data" : "employee_no",orderable:false},
                    { "data" : "fullname",orderable:false},
                    { "data" : "classification",orderable:false},
                    { "data" : "username",orderable:false},
                    { "data" : "emp_email",orderable:false},
                    { "data" : "status",orderable:false},
                    { "data" : "action",orderable:false,searchable:false}
                ],
            }); // VIEW CONTRACTOR CONTACTS DATATABLES END

        //===== CONTRACTOR DATATABLE =====//


        //===== ADD USER APPROVER =====//
        $('#btnAddUserApprover').on('click', function(event) {
            event.preventDefault(); // to stop the form submission
            AddUserApprover();
        });
        //===== ADD USER APPROVER END =====//

          // DEACTIVATE APPROVER
          $(document).on('click', '.actionDeactivateApprover', function() {

            let approverID = $(this).attr('approver-id');

        $("#deactivateApproverID").val(approverID);
        });
        $("#deactivateApprover").submit(function(event) {
        event.preventDefault();
        DeactivateApprover();
        });
        // DEACTIVATE APPROVER END

         // ACTIVATE APPROVER
         $(document).on('click', '.actionActivateApprover', function() {

            let approverID = $(this).attr('approver-id');

            $("#activateApproverID").val(approverID);
        });

        $("#activateApprover").submit(function(event) {
            event.preventDefault();
            ActivateApprover();
        });
        // ACTIVATE APPROVER END

       //============================== EDIT USER ==============================
            // actionEditUser is generated by datatables and open the modalEditUser(modal) to collect the id of the specified rows
            $(document).on('click', '.actionEditApprover', function(){
                // the user-id (attr) is inside the datatables of UserController that will be use to collect the user-id
                let approverID = $(this).attr('approver-id');

                // after clicking the actionEditUser(button) the userId will be pass to the txtEditUserId(input=hidden) and when the form is submitted this will be pass to ajax and collect user-id that will be use to query the user-id in the UserController to update the user
                $("#txtApproverID").val(approverID);

                // COLLECT THE userId AND PASS TO INPUTS, BASED ON THE CLICKED ROWS
                // GetUserByIdToEdit() function is inside User.js and pass the userId as an argument when passing the ajax that will be use to query the user-id of get_user_by_id() method inside UserController and pass the fetched user based on that query as $user(variable) to pass the values in the inputs of modalEditUser and also to validate the fetched values, inside GetUserByIdToEdit under User.js
                GetApproverById(approverID);
            });

            // The EditUser(); function is inside public/js/my_js/User.js
            // after the submission, the ajax request will pass the formEditUser(form) of its data(input) in the uri(edit_user)
            // then the controller will handle that uri to use specific method called edit_user() inside UserController
            $("#EditApprover").submit(function(event){
                event.preventDefault();
                EditApprover();
            });

        });

    </script>

@endsection
