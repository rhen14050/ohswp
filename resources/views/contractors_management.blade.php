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
                        <h1>Contractors</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Contractor Management</li>
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
                                        <a class="nav-link active" id="user-management-tab" data-toggle="tab" href="#user-management" role="tab" aria-controls="user-management" aria-selected="true">Contractor Management Tab</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contractorContact-tab" data-toggle="tab" href="#contractorContact" role="tab" aria-controls="contractorContact" aria-selected="false">Contractor Contact Management Tab</a>
                                    </li>
                                    {{-- <button class="btn float-right reload" style="float: right;"><i class="fas fa-sync-alt"></i></button> --}}
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="user-management" role="tabpanel" aria-labelledby="user-management-tab">
                                    <div class="text-right mt-4">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddContractor"
                                    style="float: right;"><i class="fa fa-plus fa-md"></i> Add
                                    Contractor</button></div><br><br>

                                <div class="table-responsive">
                                    <table id="contractorsTable"
                                        class="table table-sm table-bordered table-striped table-hover text-center"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%">Contractor Company</th>
                                                <th style="width: 10%">Status</th>
                                                <th style="width: 10%">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="contractorContact" role="tabpanel" aria-labelledby="contractorContact-tab">
                                <div class="text-right mt-4">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddContractorContact"
                                        style="float: right;"><i class="fa fa-plus fa-md"></i> Add
                                        Contractor Contact</button></div><br> <br>

                                <div class="table-responsive">
                                    <table id="contractorcontactTable" class="table table-sm table-bordered table-striped table-hover text-center" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%">Name</th>
                                                <th style="width: 10%">Contractor Company</th>
                                                <th style="width: 10%">Email</th>
                                                <th style="width: 10%">Classification</th>
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

    {{-- ADD CONTRACTOR MODAL --}}
    <div class="modal fade" id="modalAddContractor">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-plus fa-md" aria-hidden="true"></i>&nbsp;&nbsp;Add
                        Contractor
                    </h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="addContractorForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Company</label>
                                    <input class="form-control" type="text" name="contractor_company"
                                        id="contractorNameId" style="width: 100%;" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>E-Signature</label>
                                    <input type="file" class="form-control" id="addEsignatureId" name="add_esignature"
                                        style="width: 100%; height: 100%;" readonly>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="margin-right: auto;" class="btn btn-default"
                            data-dismiss="modal">Close</button>

                        <button type="submit" id="btnAddContractor" class="btn btn-primary"><i id="btnAddContractorIcon"
                                class="fa fa-upload"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ADD CONTRACTOR MODAL END --}}


    <!-- EDIT MODAL START -->
    <div class="modal fade" id="modalEditContractor">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-user"></i> Edit Contractor</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="EditContractor">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                <label>Contractor Company</label>
                                    <input type="hidden" class="form-control" name="contractor_id" id="editContractorId">
                                    <input type="text" class="form-control" name="edit_contractor_name" id="txtEditCCompany" autocomplete="off">
                                </div>

                                {{-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>E-Signature</label>
                                            <input type="file" class="form-control" id="EditESignature" name="edit_esignature"
                                                style="width: 100%; height: 100%;" readonly>
                                        </div>
                                    </div>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnEditContractor" class="btn btn-primary"><i id="iBtnEditContractorIcon" class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- EDIT MODAL END -->

      <!-- DEACTIVATE CONTRACTOR MODAL START -->
      <div class="modal fade" id="modalDeactivateContractor">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="far fa-file"></i>&nbsp;&nbsp;Deactivate Contractor</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="deactivateContractor">
                    @csrf
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <label class="text-secondary mt-2">Are you sure you want to deactivate this Contractor?</label>
                            <input type="hidden" class="form-control" name="contractor_id" id="deactivateContractorID">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnDeactivateContractor" class="btn btn-primary"><i id="deactivateIcon"
                                class="fa fa-check"></i> Deactivate</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- DEACTIVATE CONTRACTOR MODAL END -->



    <!-- ACTIVATE CONTRACTOR MODAL START -->
    <div class="modal fade" id="modalActivateContractor">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="far fa-file"></i>&nbsp;&nbsp;Activate Contractor</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="activateContractor">
                    @csrf
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">

                            <label class="text-secondary mt-2">Activate this Contractor?</label>
                            <input type="hidden" class="form-control" name="contractor_id" id="activateContractorID">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnActivateContractor" class="btn btn-primary"><i id="activateIcon"
                                class="fa fa-check"></i> Activate</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- ACTIVATE CONTRACTOR MODAL END -->

    {{-- CONTRACTOR MANAGEMENT TAB --}}

    {{-- ADD CONTRACTOR CONTACT MODAL --}}
    <div class="modal fade" id="modalAddContractorContact">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-plus fa-md" aria-hidden="true"></i>&nbsp;&nbsp;Add
                        Contractor Contact
                    </h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addContractorContactForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" type="text" name="contractor_name"
                                        id="contractor_nameID" style="width: 100%;">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Contractor</label>
                                    <select class="form-control select2bs4 selectContractor" name="contractor"
                                        id="selContractor" style="width: 100%;" autocomplete="off">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="text" name="contractor_email"
                                    id="contractor_emailID" style="width: 100%;" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Classification</label>
                                <select class="form-control select2bs4"name="Classification" id="Class">
                                    <option value="0">Person In-Charge</option>
                                    <option value="1">Safety Officer In-Charge</option>
                                  </select>
                        </div>
                        </div>

                        {{-- <div class="col-sm-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control select2bs4"name="Status" id="Stat">
                                    <option value="0">Active</option>
                                    <option value="1">Inactive</option>
                                  </select>
                        </div>
                        </div> --}}

                        {{-- <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>E-Signature</label>
                                    <input type="file" class="form-control" id="addEsignatureId" name="add_esignature"
                                        style="width: 100%; height: 100%;" readonly>
                                </div>
                            </div>
                        </div> --}}

                    </div>
                    <div class="modal-footer">
                        <button type="button" style="margin-right: auto;" class="btn btn-default"
                            data-dismiss="modal">Close</button>

                        <button type="submit" id="btnAddContact" class="btn btn-primary"><i id="btnAddContactIcon"
                                class="fa fa-upload"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ADD CONTRACTOR CONTACT MODAL END --}}

      <!-- EDIT CONTRACTOR CONTACT START -->
      <div class="modal fade" id="modalEditContractorContact">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-user"></i> Edit Contractor Contact</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="EditContractorContact">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                <label>Contractor Name</label>
                                    <input type="hidden" class="form-control" name="contact_id" id="editContactId">
                                    <input type="text" class="form-control" name="contractor_contact_name" id="txtEditContractorContact" autocomplete="off">
                                </div>


                                <div class="form-group">
                                    <label>Contractor email</label>
                                        <input type="text" class="form-control" name="contractor_contact_email" id="txtEditContractorEmail" autocomplete="off">
                                    </div>


                                 <div class="form-group">
                                    <label>Classification</label>
                                        <select class="form-control select2bs4"name="Contact_Classification" id="txtEditClassification">
                                        <option value="0">Person In-Charge</option>
                                        <option value="1">Safety Officer In-Charge</option>
                                        </select>
                                    </div>


                                {{-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>E-Signature</label>
                                            <input type="file" class="form-control" id="EditESignature" name="edit_esignature"
                                                style="width: 100%; height: 100%;" readonly>
                                        </div>
                                    </div>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnEditContractorContact" class="btn btn-primary"><i id="iBtnEditContractorContactIcon" class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- EDIT CONTRACTOR CONTACT END -->

    <!-- DEACTIVATE CONTRACTOR CONTACT MODAL START -->
    <div class="modal fade" id="modalDeactivateContact">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="far fa-file"></i>&nbsp;&nbsp;Deactivate Contact</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="deactivateContact">
                    @csrf
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <label class="text-secondary mt-2">Are you sure you want to deactivate this Contact?</label>
                            <input type="hidden" class="form-control" name="contact_id" id="deactivateContactID">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnDeactivateContact" class="btn btn-primary"><i id="deactivateContactIcon"
                                class="fa fa-check"></i> Deactivate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DEACTIVATE CONTRACTOR CONTACT MODAL END -->


    <!-- ACTIVATE CONTRACTOR CONTACT MODAL START -->
    <div class="modal fade" id="modalActivateContact">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="far fa-file"></i>&nbsp;&nbsp;Activate Contractor</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="activateContact">
                    @csrf
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">

                            <label class="text-secondary mt-2">Activate this Contractor?</label>
                            <input type="hidden" class="form-control" name="contact_id" id="activateContactID">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnActivateContact" class="btn btn-primary"><i id="activateContactIcon"
                                class="fa fa-check"></i> Activate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ACTIVATE CONTRACTOR CONTACT MODAL END -->

@endsection


@section('js_content')
    <script type="text/javascript">
     GetContractor($(".selectContractor"));
        $(document).ready(function() {
            bsCustomFileInput.init();
        });
        //===== CONTRACTOR DATATABLE =====//
        dataTableContractors = $("#contractorsTable").DataTable({
            "processing": false,
            "serverSide": true,
            "responsive": true,
            // "scrollX": true,
            "ajax": {
                url: "view_contractors",
            },
            "columns": [

                {
                    "data": "company",
                    orderable: false
                },
                {
                    "data": "status",
                    orderable: false
                },
                {
                    "data": "action",
                    orderable: false,
                    searchable: false
                }
            ],
        });
        //===== CONTRACTOR DATATABLE =====//


        //===== ADD CONTRACTOR =====//
        $('#btnAddContractor').on('click', function(event) {
            event.preventDefault(); // to stop the form submission
            AddContractor();
        });
        //===== ADD CONTRACTOR END =====//

          // DEACTIVATE CONTRACTOR
          $(document).on('click', '.actionDeactivateContractor', function() {

            let contractorId = $(this).attr('contractor-id');

        $("#deactivateContractorID").val(contractorId);
        });
        $("#deactivateContractor").submit(function(event) {
        event.preventDefault();
        DeactivateContractor();
        });
        // DEACTIVATE CONTRACTOR END

         // ACTIVATE CONTRACTOR
         $(document).on('click', '.actionActivateContractor', function() {

            let contractorId = $(this).attr('contractor-id');

            $("#activateContractorID").val(contractorId);
        });

        $("#activateContractor").submit(function(event) {
            event.preventDefault();
            ActivateContractor();
        });
        // ACTIVATE CONTRACTOR END

        // EDIT CONTRACTOR
        $(document).on('click', '.actionEditContractor', function() {

            let contractorId = $(this).attr('contractor-id');
            $("#editContractorId").val(contractorId);

            // console.log(contractorId);
            GetContractorByIdToEdit(contractorId);

            // $("#txtEditCCompany").removeClass('is-invalid');
            // $("#txtEditCCompany").attr('title', '');

            });

            $("#EditContractor").submit(function(event) {
            event.preventDefault(); // to stop the form submission
            EditContractor();
            });
        // EDIT CONTRACTOR

        //============================== VIEW CONTRACTOR CONTACTS DATATABLES  START ==============================
        dataTableContractorsContact = $("#contractorcontactTable").DataTable({
                "processing" : false,
                "serverSide" : true,
                // "responsive": true,
                // "scrollX": true,
                // "scrollX": "100%",
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ records",
                    "lengthMenu":     "Show _MENU_ records",
                },
                "ajax" : {
                    url: "view_contractors_contact", // this will be pass in the uri called view_users_archive that handles datatables of view_users_archive() method inside UserController
                },
                "columns":[
                    { "data" : "name",orderable:false},
                    { "data" : "contractor_id.company",orderable:false},
                    { "data" : "email",orderable:false},
                    { "data" : "classification",orderable:false},
                    { "data" : "status",orderable:false},
                    { "data" : "action",orderable:false,searchable:false}
                ],
            }); // VIEW CONTRACTOR CONTACTS DATATABLES END

        //===== ADD CONTACT START =====//
        $('#btnAddContact').on('click', function(event){
            event.preventDefault();
            AddContractorContact();
        });
        //===== ADD CONTACT END =====//

        //EDIT CONTRACTOR CONTACT
        $(document).on('click', '.actionEditContractorContact', function() {

        let contactId = $(this).attr('contact-id');
        $("#editContactId").val(contactId);

        console.log(contactId);
        GetContractorContactIdToEdit(contactId);

        $("#txtEditContractorContact").removeClass('is-invalid');
        $("#txtEditContractorContact").attr('title', '');

        $("#txtEditContractorEmail").removeClass('is-invalid');
        $("#txtEditContractorEmail").attr('title', '');

        $("#txtEditClassification").removeClass('is-invalid');
        $("#txtEditClassification").attr('title', '');

        });

        $("#EditContractorContact").submit(function(event) {
        event.preventDefault(); // to stop the form submission
        EditContractorContact();
        });
        //EDIT CONTRACTOR CONTACT

        //DEACTIVATE CONTRACTOR CONTACT
         $(document).on('click', '.actionDeactivateContact', function() {

        let contactID = $(this).attr('contact-id');

        $("#deactivateContactID").val(contactID);
        });
        $("#deactivateContact").submit(function(event) {
        event.preventDefault();
        DeactivateContractorContact();
        });
        //DEACTIVATE CONTRACTOR CONTACT END

        // ACTIVATE CONTRACTOR CONTACT
        $(document).on('click', '.actionActivateContact', function() {

        let contactID = $(this).attr('contact-id');

        $("#activateContactID").val(contactID);
        });

        $("#activateContact").submit(function(event) {
        event.preventDefault();
        ActivateContractorContact();
        });
        // ACTIVATE CONTRACTOR CONTACT END

    </script>

@endsection
