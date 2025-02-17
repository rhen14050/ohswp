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

    // print_r(Auth::user());


    @endphp
@endauth

{{-- Here I removed the @auth because the dashboard isn't loading properly --}}
@extends($layout)
@section('title', 'Contractor Management')

@section('content_page')
    <style type="text/css">
        table {
            color: black;
        }

        table.table tbody td {
            vertical-align: middle;
            text-align: center;
        }

    </style>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Work Permit</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Work Permit Management</li>
                            {{-- <input type="text" value= {{ $rapidx_user_id }}> --}}
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
                                <h3 class="card-title">Work Permit Management</h3>
                                <button class="btn float-right reload"><i class="fas fa-sync-alt"></i></button>
                            </div> --}}
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">

                                    <li class="nav-item">
                                        <a class="nav-link active" id="work-management-tab" data-toggle="tab"
                                            href="#work-management" role="tab" aria-controls="work-management"
                                            aria-selected="true">Work Permit Management Tab</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="allWorkPermit-tab" data-toggle="tab"
                                            href="#allWorkPermitId" role="tab" aria-controls="allWorkPermitId"
                                            aria-selected="true">All Work Permit</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" id="archive-tab" data-toggle="tab" href="#archive" role="tab" aria-controls="archive" aria-selected="false">Archive Tab</a>
                                    </li> --}}

                                </ul>
                                <div class="tab-content" id="myTabContent" style="height: 666px; overflow-y: scroll;">
                                    <div class="tab-pane fade show active" id="work-management" role="tabpanel"
                                        aria-labelledby="work-management-tab">
                                        <div class="mt-4">
                                            <button class="btn btn-primary" data-toggle="modal"
                                                data-target="#modalAddWorkPermit" id="btnAddWorkPermitModal"
                                                style="float: right;"><i class="fas fa-folder-plus"></i> Add
                                                Work Permit</button>

                                                <button class="btn btn-primary mr-2" data-toggle="modal"
                                                data-target="#modalExportSummary"
                                                style="float: right;"><i class="fas fa-download"></i> Export Summary
                                                </button>

                                                <div style="float:left;">
                                                    <div class="form-group">
                                                        <input type="checkbox" id="filterApprovedWpId" name="for_approval">
                                                        <label for="filterApprovedWpId" class="form-control-label text-secondary">Approved</label>
                                                    </div>

                                                    <div class="form-group" style="margin-top: -25px;">
                                                        <input type="checkbox" id="fiterForApproval" name="for_approval_work_permit">
                                                        <label for="fiterForApproval" class="form-control-label text-secondary">For Approval</label>
                                                    </div>

                                                    {{-- <div class="form-group" style="margin-top: -25px;">
                                                        <input type="checkbox" id="filterForMyApproval" name="for_my_approval_work_permit">
                                                        <label for="filterForMyApproval" class="form-control-label text-secondary">For My Approval</label>
                                                    </div> --}}
                                                </div>

                                        </div><br><br>

                                        <div class="table-responsive">
                                            <table id="workpermitTable"
                                                class="table table-sm table-bordered table-striped table-hover text-center"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%">Status</th>
                                                        <th style="width: 10%">Permit Number</th>
                                                        <th style="width: 15%">Contractor</th>
                                                        <th style="width: 20%">Activity</th>
                                                        <th style="width: 7%">Start Date</th>
                                                        <th style="width: 7%">End Date</th>
                                                        <th style="width: 5%">Attach File</th>
                                                        <th style="width: 10%">Person In-Charge</th>
                                                        <th style="width: 5%">Permit Approval</th>
                                                        <th style="width: 5%">Permit Clearance</th>
                                                        <th style="width: 10%">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
{{-- chan tanga --}}

                                    <div class="tab-pane fade" id="allWorkPermitId" role="tabpanel"
                                            aria-labelledby="allWorkPermit-tab">
                                        <div class="text-right mt-4"></div><br> <br>

                                        <div class="table-responsive">
                                            <table id="seeAllWorkPermitDataTables"
                                                class="table table-sm table-bordered table-striped table-hover text-center"
                                                style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%">Status</th>
                                                        <th style="width: 10%">Permit Number</th>
                                                        <th style="width: 15%">Contractor</th>
                                                        <th style="width: 20%">Activity</th>
                                                        <th style="width: 7%">Start Date</th>
                                                        <th style="width: 7%">End Date</th>
                                                        <th style="width: 5%">Attach File</th>
                                                        <th style="width: 10%">Person In-Charge</th>
                                                        <th style="width: 5%">Permit Approval</th>
                                                        <th style="width: 5%">Permit Clearance</th>
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

    <!-- MODALS -->
    <div class="modal fade" id="modalExportSummary">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title"><i class="fab fa-stack-overflow"></i> Export Summary</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Select Year:</label>
                            <select name="select_year" id="selectYearId">
                                <?php
                                    $year_now = date('Y');

                                    for($i = 2022; $i <= $year_now; $i++){
                                        echo "<option value =".$i.">
                                            ".$i."
                                            </option>";
                                    }
                                ?>
                            </select>

                            <label>Select Month:</label>
                            <select name="select_month" id="selectMonthId">
                                <option value="01">January</option>
                                <option value="02">Febuary</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                                </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                <button type="submit" id="btnExportSummary" class="btn btn-dark"><i id="BtnExportSummaryIcon" class="fa fa-check"></i> Export</button>
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
  <!-- /.modal -->

    {{-- {{-- <!-- EXTEND WORK PERMIT START --> --}}
    <div class="modal fade" id="modalExtendWorkPermit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title"><i class="far fa-calendar-plus"></i>&nbsp;&nbsp;Extend Work Permit</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="ExtendWorkPermitForm">
                    @csrf
                    <div class="row">

                        <div class="modal-body">
                            <div>
                                <input type="hidden" class="counterclass" name="extend_work_permit_id"
                                id="txtExtendWorkPermitID">
                                <input type="hidden" class="counterclass" name="counter" id="counterID">


                                <label>Prolong Start Date:</label>
                                <input class="ml-2" type="date" id="prolongStartDateId" name="prolong_start_date" style="width:60%;">

                            </div>

                            <div>
                                <label>Prolong End Date:</label>
                                <input class="ml-3" type="date" id="prolongEndDateId" name="prolong_end_date" style="width:60%;">
                            </div>

                            <div>
                                <label>Prolong Start Time:</label>
                                <input class="ml-2" type="time" id="prolongStartTimeId" name="prolong_start_time" style="width:60%;">
                            </div>


                            <div>
                                <label>Prolong End Time:</label>
                                <input class="ml-3" type="time" id="prolongEndTimeId" name="prolong_end_time" style="width:60%;">
                            </div>


                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnExtendWorkPermitId" class="btn btn-info"><i
                                id="extendWorkPermitIcon" class="fa fa-check"></i> Extend</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- EXTEND WORK PERMIT END -->

    {{-- ADD WORK PERMIT MODAL --}}
    <div class="modal fade" id="modalAddWorkPermit">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-plus fa-md" aria-hidden="true"></i>&nbsp;&nbsp;Add Work Permit</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal"aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addWorkPermitForm">
                    @csrf
                    <div class="modal-body">
                        <div class="card ">
                            <div class="card-header">

                                {{-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="hidden" class="counterclass" name="counter" id="counterID">
                                            <label>Work Classification Type</label><br>
                                            <input type="radio" id="workClassificationID" name="work_classification" value="1">
                                            <label class="form-control-label text-secondary">Urgent</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" id="workClassificationID" name="work_classification" value="0">
                                            <label class="form-control-label text-secondary">Normal</label>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="row">
                                    <div class="form-group col-sm-12 flex-column d-flex">
                                        <input type="hidden" class="counterclass" name="counter" id="counterID">
                                        <input type="hidden" class="counterclass" name="work_permit_id" id="workPermitId">

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Work Classification Type: </strong></span>
                                            </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input radioBtn" type="radio" id="workClassificationID" name="work_classification" value="1">
                                                <label class="form-check-label" for="inlineRadio1">Urgent</label>
                                            </div>&nbsp;&nbsp;&nbsp;
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input radioBtn" type="radio" id="workClassificationID" name="work_classification" value="0">
                                                <label class="form-check-label" for="inlineRadio2">Normal</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default" for="division"><strong>Choose Your Division: </strong></span>
                                            </div>
                                            <select name="division" id="division" style="width: 30%;" required>
                                                <option selected disabled value="">-- Select Division --</option>
                                                <option value="ISS">ISS</option>
                                                <option value="ESS">ESS</option>
                                                <option value="HRD">HRD</option>
                                                <option value="SEC">SEC</option>
                                                <option value="FAC">FAC</option>
                                                <option value="EMS">EMS</option>
                                                <option value="LOG">LOG</option>
                                                <option value="TS-F1">TS-F1</option>
                                                <option value="YF">YF</option>
                                                <option value="CN">CN</option>
                                                <option value="PPS-TS">PPS-TS</option>
                                                <option value="PPS-CN">PPS-CN</option>
                                                <option value="FIN">FIN</option>
                                                <option value="BC">Battery Connector</option>
                                                <option value="TS-F3">TS-F3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <label><Strong>*Work Schedule</Strong></label><br>
                                <div class="row">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Start Date:</strong></span>
                                            </div>
                                            <input type="date" id="startDateID" name="start_date" style="width:75%;">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Start Working Time: </strong></span>
                                            </div>
                                            <input type="time" id="startTimeID" name="start_time" style="width:55%;">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>End Date:&nbsp;&nbsp;</strong></span>
                                            </div>
                                            <input type="date" id="endDateID" name="end_date" style="width:75%;">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>End Working Time:&nbsp;&nbsp;&nbsp;</strong></span>
                                            </div>
                                            <input type="time" id="endTimeID" name="end_time" style="width:55%;">
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row justify-content-between"> --}}
                                    {{-- <div class="form-group col-sm-3 flex-column d-flex">
                                        <label>Start Date</label><br>
                                        <input type="date" id="startDateID" name="start_date">
                                    </div> --}}

                                    {{-- <div class="form-group col-sm-3 flex-column d-flex">
                                        <label>End Date</label><br>
                                        <input type="date" id="endDateID" name="end_date">
                                    </div> --}}

                                    {{-- <div class="form-group col-sm-3 flex-column d-flex">
                                        <label>Start Working Time</label><br>
                                        <input type="time" id="startTimeID" name="start_time">
                                    </div> --}}

                                    {{-- <div class="form-group col-sm-3 flex-column d-flex">
                                        <label>End Working Time</label><br>
                                        <input type="time" id="endTimeID" name="end_time">
                                    </div> --}}
                                {{-- </div> --}}
                                {{-- <label class="" for="division">Choose Your Division:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="division" id="division">
                                        <option value="ADMIN">ADMIN</option>
                                        <option value="YF">YF</option>
                                        <option value="TS">TS</option>
                                        <option value="LOG">LOG</option>
                                        <option value="QAD">QAD</option>
                                    </select>
                                </label> --}}

                                <label>*Work Permit Type</label><br>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-4">
                                        <div class="form-group">
                                            <input type="checkbox" id="insidePmiTypeID" name="inside_pmi_type" value="OHS Work Permit Inside PMI Bldg">
                                            <label for="insidePmiTypeID" class="form-control-label text-secondary">OHS Work Permit Inside PMI Bldg.</label>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <div class="form-group">
                                            <input type="checkbox" id="outsidePmiTypeID" name="outside_pmi" value="OHS Work Permit Outside PMI Bldg">
                                            <label for="outsidePmiTypeID" class="form-control-label text-secondary">OHS Work Permit Outside PMI Bldg.</label><br>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <div class="form-group">
                                            <input type="checkbox" id="heightsPmiID" name="HeightsPmi" value="Working at HEIGHTS Permit">
                                            <label for="heightsPmiID" class="form-control-label text-secondary">Working at HEIGHTS Permit</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-between text-left" style="margin-top:-35px;">
                                    <div class="form-group col-sm-4">
                                        <div class="form-group">
                                            <input type="checkbox" id="hotWorksPmiID" name="HotWorksPmi" value="HOT Works Permit">
                                            <label for="hotWorksPmiID" class="form-control-label text-secondary"> HOT Works Permit</label>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <div class="form-group">
                                            <input type="checkbox" id="confineSpacePmiID" name="ConfineSpacePmi" value="Confine Space Works Permit">
                                            <label for="confineSpacePmiID" class="form-control-label text-secondary">Confine Space Works Permit</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <div class="form-group"></div>
                                    </div>
                                </div>

                                {{-- <label>Work Permit Type</label><br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="checkbox" id="insidePmiTypeID" name="inside_pmi_type" value="OHS Work Permit Inside PMI Bldg">
                                            <label for="insidePmiTypeID" class="form-control-label text-secondary"> OHS Work Permit Inside PMI Bldg.</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                            <input type="checkbox" id="outsidePmiTypeID" name="outside_pmi" value="OHS Work Permit Outside PMI Bldg">
                                            <label for="outsidePmiTypeID" class="form-control-label text-secondary"> OHS Work Permit Outside PMI Bldg.</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>

                                            <input type="checkbox" id="heightsPmiID" name="HeightsPmi" value="Working at HEIGHTS Permit">
                                            <label for="heightsPmiID" class="form-control-label text-secondary"> Working at HEIGHTS Permit</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                            <input type="checkbox" id="hotWorksPmiID" name="HotWorksPmi" value="HOT Works Permit">
                                            <label for="hotWorksPmiID" class="form-control-label text-secondary"> HOT Works Permit</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                            <input type="checkbox" id="confineSpacePmiID" name="ConfineSpacePmi" value="Confine Space Works Permit">
                                            <label for="confineSpacePmiID" class="form-control-label text-secondary">Confine Space Works Permit</label>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="row">
                                    <div class="form-group col-6">
                                        <label>Person in-Charge</label>
                                        <input type="text" class="form-control" id="txtPersonInChargeID" name="txtperson_in_charge" readonly>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Department</label>
                                        <input type="text" class="form-control" id="txtPersonInChargeDepartmentID" name="txtperson_in_charge_department" readonly>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Activity</label>
                                        <input type="text" class="form-control" id="txtActivityID" name="txt_activity" autocomplete="off">
                                    </div>

                                    <div class="form-group col-6">
                                        <label>Local No.</label>
                                        <select class="form-control select2bs4 selectLocalNo" id="txtLocalnumberID" name="txt_localnumber"></select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Location</label>
                                        <input type="text" class="form-control" id="txtLocationID" name="txt_location" autocomplete="off">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Work Schedule</label>
                                        <input type="text" class="form-control" id="txtWorkScheduleId" name="txt_work_schedule" autocomplete="off">
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Contractor</label>
                                        <select class="form-control select2bs4 selectContractorID" name="dd_contractor" id="selContractorID" style="width: 100%;">
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Contractor Person in-Charge</label>
                                        <select class="form-control select2bs4 selectContractorPIC" name="dd_contractor_person_in_charge" id="contractorPersonInChargeID" style="width: 100%;">
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Contractor Safety Officer in-Charge</label>
                                        <select class="form-control select2bs4 selectContractorSOIC" name="dd_contractor_safety_officer_in_charge" id="contractorSafetyOfficerInChargeID" style="width: 100%;">
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="row">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Person in-Charge:</strong></span>
                                            </div>
                                            <input type="text" class="form-control" id="txtPersonInChargeID" name="txtperson_in_charge" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Department:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></span>
                                            </div>
                                            <input type="text" class="form-control" id="txtPersonInChargeDepartmentID" name="txtperson_in_charge_department" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Activity:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></span>
                                            </div>
                                            <input type="text" class="form-control" id="txtActivityID" name="txt_activity" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Local No.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></span>
                                            </div>
                                            <select class="form-control select2bs4 selectLocalNo" id="txtLocalnumberID" name="txt_localnumber"></select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Location:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></span>
                                            </div>
                                            <input type="text" class="form-control" id="txtLocationID" name="txt_location" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Work Schedule:</strong></span>
                                            </div>
                                            <input type="text" class="form-control" id="txtWorkScheduleId" name="txt_work_schedule" autocomplete="off">
                                        </div>
                                    </div>

                                </div>

                                <label>*Contractor</label><br>
                                <div class="row">
                                    <div class="form-group col-sm-3 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Contractor:</strong></span>
                                            </div>
                                            <select class="form-control select2bs4 selectContractorID" name="dd_contractor" id="selContractorID"></select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-4 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Person in-Charge:</strong></span>
                                            </div>
                                            <select class="form-control select2bs4 selectContractorPIC" name="dd_contractor_person_in_charge" id="contractorPersonInChargeID"></select>
                                            </div>
                                    </div>
                                    <div class="form-group col-sm-5 flex-column d-flex">
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Safety Officer in-Charge:</strong></span>
                                            </div>
                                            <select class="form-control select2bs4 selectContractorSOIC" name="dd_contractor_safety_officer_in_charge" id="contractorSafetyOfficerInChargeID"></select>
                                        </div>
                                    </div>
                                </div>


                                <div class="card" id="workerDetailsCard">
                                    <div class="card-header">
                                        <h3 class="card-title" style="margin-top: 8px;"><strong>Worker Details</strong></h3>
                                        <input type="text" class="form-control form-control-sm" placeholder="Edit Data" name="edit_data" id="editData" value="" style="display: none;">
                                        <button type="button" class="btn btn-sm btn-info float-right" id="add_worker_details_row"><i class="fa fa-plus"></i> Add Row</button>
                                        <button type="button" class="btn btn-sm btn-danger float-right mr-2  d-none" id="remove_worker_details_row"><i class="fas fa-times"></i> Remove Row</button>
                                    </div>
                                        <div class="card-body">
                                            <div id="divWorkerDetails">
                                                {{-- <input type="hidden" name="txt_max_row" id="txt_max_row" value="1"> --}}
                                                {{-- <input type="hidden" name="escapee_cause_action_code" id="escapee_cause_action_code" value="1"> --}}
                                                <input type="hidden" name="add_worker_details_counter" id="worker_details_counter" value="1">
                                                <h6><span class="badge badge-secondary"># 1.</span></h6>
                                                <div class="row">

                                                    <div class="col-md-12">

                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Worker Name</i></span>
                                                            </div>
                                                                <input type="text" class="form-control mr-3" id="addWorkerNameId" name="add_worker_name" autocomplete="off">

                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Worker Position</i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="addWorkerPositionId" name="add_worker_position" autocomplete="off">

                                                        </div>

                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Contractors OHS Training Date</i></span>
                                                            </div>
                                                            <input type="date" class="form-control mr-3" id="addOhsTrainingDateId" name="add_ohs_training_date">

                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Contractors OHS Training Date</i></span>
                                                            </div>
                                                            <input type="date" class="form-control" id="addSkillsTrainingDate" name="add_skills_training_date">

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 61%;" >
                                                                <span class="input-group-text w-100" id="basic-addon1">Certificate Submission Date</i></span>
                                                            </div>
                                                            <input type="date" class="form-control" id="addCertificateSubmissionDate" name="add_certificate_submission_date">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                </div>

                                <div class="card" id="toolsDetailsCard">
                                    <div class="card-header">
                                        <h3 class="card-title" style="margin-top: 8px;"><strong>Tools / Equipment Details</strong></h3>
                                        <input type="text" class="form-control form-control-sm" placeholder="Edit Data" name="edit_data" id="editData" value="" style="display: none;">
                                        <button type="button" class="btn btn-sm btn-info float-right" id="add_tools_details_row"><i class="fa fa-plus"></i> Add Row</button>
                                        <button type="button" class="btn btn-sm btn-danger float-right mr-2  d-none" id="remove_tools_details_row"><i class="fas fa-times"></i> Remove Row</button>
                                    </div>
                                        <div class="card-body">
                                            <div id="divToolsDetails">
                                                <input type="hidden" name="add_tools_details_counter" id="tools_details_counter" value="1">
                                                <h6><span class="badge badge-secondary"># 1.</span></h6>
                                                <div class="row">

                                                    <div class="col-md-12">

                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 8%;">
                                                                <span class="input-group-text w-20" id="basic-addon1">Tool Name</i></span>
                                                            </div>
                                                                <input type="text" class="form-control mr-3" id="addToolsNameId" name="add_tools_name" autocomplete="off">

                                                            <div class="input-group-prepend" style="width: 7%;">
                                                                <span class="input-group-text w-35" id="basic-addon1">Quantity</i></span>
                                                            </div>
                                                            <input type="text" class="form-control mr-3" id="addToolsQuantityId" name="add_tools_quantity" autocomplete="off">

                                                            <div class="input-group-prepend" style="width: 15%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Other Requirements</i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="addOtherRequirementsId" name="add_other_requirements" autocomplete="off">

                                                        </div>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                </div>

                                <div class="card" id="attachmentCard">
                                    <div class="card-header">
                                        <h4 class="card-title" style="margin-top: 8px;"><strong>Upload Attachment</strong></h4>
                                    </div>
                                        <div class="card-body">
                                            <div id="attachmentFile">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="file" class ="" name="attach_file" id="txtAddUploadedFile" accept=".xlsx, .xls, .csv, application/pdf">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                                <div class="card" id="affectedDevicesCard">
                                    <div class="card-header">
                                        <h4 class="card-title" style="margin-top: 8px;"><strong>Affected Safety Devices</strong></h4>
                                    </div>
                                        <div class="card-body">
                                            <div id="affectedSafetyDevices">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                            <input type="checkbox" id="fireAlarmSystemID" name="fire_alarm_system" value="Fire Alarm System"><label for="fireAlarmSystemID" class="form-control-label text-secondary">&nbsp;Fire Alarm System</label>&nbsp;&nbsp;&nbsp;
                                                            <input type="checkbox" id="EmergencyLightingID" name="emergency_lighting" value="Emergency Lighting"><label for="EmergencyLightingID" class="form-control-label text-secondary">&nbsp;Emergency Lighting</label>&nbsp;&nbsp;&nbsp;
                                                            <input type="checkbox" id="pagingSystemSpeakerID" name="paging_system_speaker" value="Paging System; Speaker etc"><label for="pagingSystemSpeakerID" class="form-control-label text-secondary">Paging System; Speaker</label>&nbsp;&nbsp;&nbsp;
                                                            <input type="checkbox" id="emergencyExitDoorID" name="emergency_exit_door" value="Emergency Exit Door"><label for="emergencyExitDoorID" class="form-control-label text-secondary"> Emergency Exit Door</label>&nbsp;&nbsp;&nbsp;
                                                            <input type="checkbox" id="fireExtinguisherFireHoseID" name="fire_extinguisher_fire_hose" value="Fire extinguisher Fire hose"><label for="fireExtinguisherFireHoseID" class="form-control-label text-secondary">&nbsp;Fire extinguisher, Fire hose</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="checkbox" id="noneID" name="none_name" value="None"><label for="noneID" class="form-control-label text-secondary">&nbsp;None</label>

                                                        {{-- <div class= "form-group col-md-12">
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                                <div class="card" id="selectApproverCard">
                                    <div class="card-header">
                                        <h4 class="card-title" style="margin-top: 8px;"><strong>Select Approver for Work Permit:</strong></h4>
                                    </div>
                                        <div class="card-body">
                                            <div id="selectApproverCard">

                                                    <div class="row">
                                                        <div class="form-group col-sm-12 flex-column">

                                                            <div class="input-group">
                                                                <input type="text" class="form-control mr-3" style="width: 10%;" id="txtAddProjectInCharge" name="project_in_charge" readonly>
                                                                <select class="select2bs4 selectAddSafetyofficerInCharge" id="selectSafetyofficerInCharge" name="safety_officer_in_charge"></select>
                                                                <select class="select2bs4 selectAddOverAllSafetyOfficer" id="selectOverAllSafetyOfficer" name="over_all_safety_officer"></select>

                                                                <div class="input-group">
                                                                    <select class="select2bs4 selectAddHrdManager" id="selectHrdManager" name="hrd_manager"></select>
                                                                    <select class="select2bs4 selectAddEmsManager" id="selectEmsManager" name="ems_manager"></select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                            </div>
                                        </div>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" style="margin-right: auto;" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="btnAddWorkPermit" class="btn btn-dark"><i id="btnAddWorkPermitIcon" class="fa fa-upload"></i> Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ADD WORK PERMIT MODAL END --}}

    {{-- EDIT WORK PERMIT MODAL START --}}
    <div class="modal fade" id="modalEditWorkPermit">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-plus fa-md" aria-hidden="true"></i>&nbsp;&nbsp;
                        Edit Work Permit
                    </h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editWorkPermitForm">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header">

                                <div class="row">
                                    <div class="form-group col-sm-12 flex-column d-flex">
                                        <input type="hidden" class="counterclass" name="counter" id="counterID">
                                        <input type="hidden" class="counterclass" name="work_permit_id" id="editWorkPermitId">

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Work Classification Type: </strong></span>
                                            </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input radioBtn" type="radio" id="editWorkClassificationID" name="edit_work_classification" value="1">
                                                <label class="form-check-label" for="inlineRadio1">Urgent</label>
                                            </div>&nbsp;&nbsp;&nbsp;
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input radioBtn" type="radio" id="editWorkClassificationIDN" name="edit_work_classification" value="0">
                                                <label class="form-check-label" for="inlineRadio2">Normal</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default" for="division"><strong>Choose Your Division: </strong></span>
                                            </div>
                                            <select name="edit_division" id="editDivisionId" style="width: 30%;">
                                                <option selected disabled value="">-- Select Division --</option>
                                                <option value="ISS">ISS</option>
                                                <option value="ESS">ESS</option>
                                                <option value="HRD">HRD</option>
                                                <option value="FAC">FAC</option>
                                                <option value="EMS">EMS</option>
                                                <option value="LOG">LOG</option>
                                                <option value="TS">TS</option>
                                                <option value="YF">YF</option>
                                                <option value="CN">CN</option>
                                                <option value="PPS-TS">PPS-TS</option>
                                                <option value="PPS-CN">PPS-CN</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <label><Strong>*Work Schedule</Strong></label><br>
                                <div class="row">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Start Date:</strong></span>
                                            </div>
                                            <input type="date" id="editStartDateID" name="edit_start_date" style="width:75%;">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Start Working Time: </strong></span>
                                            </div>
                                            <input type="time" id="editStartTimeID" name="edit_start_time" style="width:55%;">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>End Date:&nbsp;&nbsp;</strong></span>
                                            </div>
                                            <input type="date" id="editEndDateID" name="edit_end_date" style="width:75%;">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>End Working Time:&nbsp;&nbsp;&nbsp;</strong></span>
                                            </div>
                                            <input type="time" id="editEndTimeID" name="edit_end_time" style="width:55%;">
                                        </div>
                                    </div>
                                </div>

                                <label>*Work Permit Type</label><br>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-4">
                                        <div class="form-group">
                                            <input type="checkbox" id="editInsidePmiTypeID" name="edit_inside_pmi_type" value="OHS Work Permit Inside PMI Bldg">
                                            <label for="editInsidePmiTypeID" class="form-control-label text-secondary">OHS Work Permit Inside PMI Bldg.</label>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <div class="form-group">
                                            <input type="checkbox" id="editOutsidePmiTypeID" name="edit_outside_pmi" value="OHS Work Permit Outside PMI Bldg">
                                            <label for="editOutsidePmiTypeID" class="form-control-label text-secondary">OHS Work Permit Outside PMI Bldg.</label><br>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <div class="form-group">
                                            <input type="checkbox" id="editHeightsPmiID" name="edit_heights_pmi" value="Working at HEIGHTS Permit">
                                            <label for="editHeightsPmiID" class="form-control-label text-secondary">Working at HEIGHTS Permit</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-between text-left" style="margin-top:-35px;">
                                    <div class="form-group col-sm-4">
                                        <div class="form-group">
                                            <input type="checkbox" id="editHotWorksPmiID" name="edit_hot_works_pmi" value="HOT Works Permit">
                                            <label for="editHotWorksPmiID" class="form-control-label text-secondary"> HOT Works Permit</label>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <div class="form-group">
                                            <input type="checkbox" id="editConfineSpacePmiID" name="edit_confine_space_pmi" value="Confine Space Works Permit">
                                            <label for="editConfineSpacePmiID" class="form-control-label text-secondary">Confine Space Works Permit</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <div class="form-group"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Person in-Charge:</strong></span>
                                            </div>
                                            <input type="text" class="form-control" id="editTxtPersonInChargeID" name="edit_txtperson_in_charge" autocomplete="off">                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Department:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></span>
                                            </div>
                                            <input type="text" class="form-control" id="editTxtPersonInChargeDepartmentID" name="edit_txtperson_in_charge_department" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Activity:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></span>
                                            </div>
                                            <input type="text" class="form-control" id="editTxtActivityID" name="edit_txt_activity" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Local No.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></span>
                                            </div>
                                            <select class="form-control select2bs4 selectLocalNo" id="editTxtLocalnumberID" name="edit_txt_localnumber"></select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Location:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></span>
                                            </div>
                                            <input type="text" class="form-control" id="editTxtLocationID" name="edit_txt_location" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><strong>Work Schedule:</strong></span>
                                            </div>
                                            <input type="text" class="form-control" id="editTxtWorkScheduleId" name="edit_txt_work_schedule" autocomplete="off">
                                        </div>
                                    </div>
                                </div>


                                    {{-- Start --}}
                                    <label>*Contractor</label><br>
                                    <div class="row">


                                            <div class="form-group col-sm-3 flex-column d-flex">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroup-sizing-default"><strong>Contractor:</strong></span>
                                                    </div>
                                                    <select class="form-control select2bs4 selectContractorID" name="edit_dd_contractor" id="editSelContractorID"></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4 flex-column d-flex">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroup-sizing-default"><strong>Person in-Charge:</strong></span>
                                                    </div>
                                                    <select class="form-control select2bs4 selectContractorPIC" name="edit_dd_contractor_person_in_charge" id="editContractorPersonInChargeID"></select>
                                                    </div>
                                            </div>
                                            <div class="form-group col-sm-5 flex-column d-flex">
                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroup-sizing-default"><strong>Safety Officer in-Charge:</strong></span>
                                                    </div>
                                                    <select class="form-control select2bs4 selectContractorSOIC" name="edit_dd_contractor_safety_officer_in_charge" id="editContractorSafetyOfficerInChargeID"></select>
                                                </div>
                                            </div>

                                    </div>
                                    {{-- End --}}

                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label>*Management of Change</label><br>
                                        <div class="form-group col-sm-12">
                                            <label class="form-control-label text-secondary" style="margin-right: 25%">1. Requires
                                                change in process or equipment? </label>
                                            <input style="margin-left:67%" type="radio" id="moc1Id" name="moc1" value="1">
                                            <label class="form-control-label text-secondary">Yes</label>
                                            <input style="margin-left:20%" type="radio" id="moc1Id" name="moc1" value="0">
                                            <label class="form-control-label text-secondary">No</label>
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label class="form-control-label text-secondary">2. Re-lay outing involves electrical
                                                rewriting or lighting, transfer or passage way or emergency exit, transfer/provision
                                                of new exhaust/ ventilation system, re-piping of gas/water supply?</label>
                                            <input style="margin-left:67%" type="radio" id="moc2Id" name="moc2" value="1">
                                            <label class="form-control-label text-secondary">Yes</label>
                                            <input style="margin-left:20%" type="radio" id="moc2Id" name="moc2" value="0">
                                            <label class="form-control-label text-secondary">No</label>
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label class="form-control-label text-secondary">3. Involves construction of new
                                                infrastructure and/or installation of new facility/equipment? </label><br>
                                            <input style="margin-left:67%" type="radio" id="moc3Id" name="moc3" value="1">
                                            <label class="form-control-label text-secondary">Yes</label>
                                            <input style="margin-left:20%" type="radio" id="moc3Id" name="moc3" value="0">
                                            <label class="form-control-label text-secondary">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12 flex-column d-flex">
                                    <label class="form-control-label">*Select Approver for Work Permit:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mr-3" style="width: 10%;" id="editTxtAddProjectInCharge" name="edit_project_in_charge" autocomplete="off">
                                        <select class="select2bs4 selectAddSafetyofficerInCharge" id="editSelectSafetyofficerInCharge" name="edit_safety_officer_in_charge"></select>
                                        <select class="select2bs4 selectAddOverAllSafetyOfficer" id="editSelectOverAllSafetyOfficer" name="edit_over_all_safety_officer"></select>
                                        <select class="select2bs4 selectAddHrdManager" id="editSelectHrdManager" name="edit_hrd_manager"></select>
                                        <select class="select2bs4 selectAddEmsManager" id="editSelectEmsManager" name="edit_ems_manager"></select>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="margin-right: auto;" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="btnEditWorkPermit" class="btn btn-primary"><i id="btnEditWorkPermitIcon" class="fa fa-upload"></i> Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- EDIT WORK PERMIT MODAL END --}}

    <!-- APPROVE MODAL START -->
    <div class="modal fade" id="modalApproveWorkPermit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title"><i class="fa fa-thumbs-up"> </i> System Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formApproveWorkPermit">
                    @csrf
                    <div class="modal-body">
                        <label id="lblChangeUserApproverStatLabel"></label>
                        <input type="hidden" name="work_permit_id" id="approvedWorkPermitID">
                        <input type="hidden" name="status" id="approvedWorkPermitStat">
                        <input type = "hidden" name="clear_status" id ="clearStatusId" value="status_clear">

                        <div class="row">
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-12">
                                    <h5> Are you sure you want to approve the Work Permit? </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnApprove" class="btn btn-success"><i id="iBtnApproveIcon"
                                class="fa fa-thumbs-up"> </i> Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- APPROVE MODAL END -->

    <!-- NOT CLEAR REMARK MODAL START -->
    <div class="modal fade" id="modalDisapprovedWorkPermit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title"><i class="fa fa-thumbs-down"> </i> System Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formDisapprovedWorkPermit">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-12">
                                    <h5> Are you sure you want to disapprove the Work Permit request? </h5>
                                    {{-- <label class="col-form-label">Remark(s):</label> --}}
                                    <input type="hidden" name="work_permit_id" id="notClearWorkPermitID">
                                    <input type="hidden" name="status" id="notClearWorkPermitStat">
                                    <input type = "hidden" name="not_clear_status" id ="notClearStatusId" value = "status_not_clear">
                                    <textarea type="text" class="form-control" id="txtDisapproveRemarks"
                                        name="disapprove_remarks" placeholder="Actions Required"></textarea><br>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnDisapproveRemark" class="btn btn-danger"><i
                                id="iBtnDisapproveRemarkIcon" class="fa fa-thumbs-down"> </i> Disapprove</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- NOT CLEAR REMARK MODAL END -->


    {{-- {{-- <!-- DEACTIVATE WORK PERMIT START --> --}}
    <div class="modal fade" id="modalDeleteWorkPermit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title"><i class="far fa-file"></i>&nbsp;&nbsp;Delete Work Permit</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteWorkPermitForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <label class="text-secondary mt-2">Are you sure you want to delete this work permit?</label>
                            <input type="hidden" class="form-control" name="delete_work_permit_id"
                                id="txtDeleteWorkPermitID">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnDeleteWorkPermit" class="btn btn-danger"><i
                                id="deleteWorkPermitIcon" class="fa fa-check"></i> Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- DEACTIVATE WORK PERMIT END -->


    {{-- -----------------------------------MODAL VIEW REQUEST------------------------------------------- --}}
    <div class="modal fade" id="modalViewRequest" data-backdrop="static">
        <div class="modal-dialog modal-xl" style="width:100%;max-width:1750px;">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-eye"></i> Work Permit Request Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formViewWPRequest">
                @csrf

                <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Request Details</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">


                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Work
                                                    Classificication</span>
                                            </div>
                                            <input type="text" class="form-control" name="classification_number"
                                                id="txtClassificatiodID" readonly>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Permit No.</span>
                                            </div>
                                            <input type="text" class="form-control" name="permit_number"
                                                id="txtpermitNumberID" readonly>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Name of PMI
                                                    In-Charge</span>
                                            </div>
                                            <input type="text" class="form-control" name="person_in_charge"
                                                id="txtPersonInCharge" readonly>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Department</span>
                                            </div>

                                            <input type="text" class="form-control" name="pmi_in_charge_department"
                                                id="txtPmiInChargeDeparmentID" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Local No.</span>
                                            </div>

                                            <input type="text" class="form-control" name="pmi_in_charge_localno"
                                                id="txtPmiInChargeLocalnoID" readonly>

                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Name of
                                                    Project/Activity</span>
                                            </div>
                                            <input type="text" class="form-control" name="activity_name"
                                                id="txtActivityNameID" readonly>
                                        </div>
                                    </div>
                                </div>


                                {{-- <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Project/Activity
                                                    Description</span>
                                            </div>

                                            <input type="text" class="form-control" name="description_name"
                                                id="txtDescription" readonly>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Project
                                                    Duration</span>
                                            </div>

                                            <input type="text" class="form-control" name="project_duration"
                                                id="txtProjectDurationID" readonly>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Start Working
                                                    Time</span>
                                            </div>
                                            <input type="text" class="form-control" name="start_working_time"
                                                id="txtStartWorkingTimeID" readonly>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-6">


                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Contractor
                                                    Company</span>
                                            </div>

                                            <input type="text" class="form-control" name="contractors_company_name"
                                                id="txtContractorsCompanyNameID" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Contractor Person
                                                    In-Charge</span>
                                            </div>

                                            <input type="text" class="form-control" name="contractors_person_in_charge"
                                                id="txtContractorsPersonInChargeID" readonly>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Contractor Safety
                                                    In-Charge</span>
                                            </div>

                                            <input type="text" class="form-control" name="contractors_safety_in_charge"
                                                id="txtContractorsSafetyInChargeID" readonly>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Work Location</span>
                                            </div>

                                            <input type="text" class="form-control" name="pmi_in_charge_location"
                                                id="txtPmiInChargeLocationID" readonly>

                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-60">
                                                <span class="input-group-text w-100" id="basic-addon1">Work Permit
                                                    Type</span>
                                            </div>

                                            <input type="text" class="form-control" name="work_permit_type_name"
                                                id="txtWorkPermitTypeID" readonly>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Work Schedule</span>
                                            </div>
                                            <input type="text" class="form-control" name="work_schedule"
                                                id="txtWorkScheduleID" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Work Date</span>
                                            </div>
                                            <input type="text" class="form-control" name="work_date" id="txtWorkDateID"
                                                readonly>
                                        </div>
                                    </div>
                                </div>


                                {{-- <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Start Working
                                                    Time</span>
                                            </div>
                                            <input type="text" class="form-control" name="start_working_time"
                                                id="txtStartWorkingTimeID" readonly>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">End Working
                                                    Time</span>
                                            </div>
                                            <input type="text" class="form-control" name="end_working_time"
                                                id="txtEndWorkingTimeID" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Worker's Details</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Worker(s)
                                                        Name</span>
                                                </div>
                                                <input type="text" class="form-control" name="worker_name"
                                                    id="txtWorkerNameID" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Worker(s)
                                                        Position</span>
                                                </div>
                                                <input type="text" class="form-control" name="worker_position"
                                                    id="txtWorkerPositionID" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Tool(s) Details</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Tool(s) Name</span>
                                                </div>
                                                <input type="text" class="form-control" name="tool_name" id="txtToolNameID"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Quantity</span>
                                                </div>
                                                <input type="text" class="form-control" name="tool_quantity"
                                                    id="txtToolQuantityID" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Other
                                                        Requirement(s)</span>
                                                </div>
                                                <input type="text" class="form-control" name="other_requirements"
                                                    id="txtOtherRequirementsID" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-60">
                                                    <span class="input-group-text w-100" id="basic-addon1">Affected Safety
                                                        Device(s)</span>
                                                </div>
                                                <input type="text" class="form-control" name="affected_safety_devices"
                                                    id="txtAffectedSafetyDevicesID" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Approvers</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Person
                                                        In-Charge</span>
                                                </div>
                                                <input type="text" class="form-control" name="project_in_charge"
                                                    id="txtProjectInCharge" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Safety Officer
                                                        In-Charge</span>
                                                </div>
                                                <input type="text" class="form-control" name="safety_officer_in_charge"
                                                    id="txtSafetyOfficerInCharge" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Over-all Safety
                                                        Officer</span>
                                                </div>
                                                <input type="text" class="form-control" name="over_all_safety_officer"
                                                    id="txtOverAllSafetyOfficer" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">HR / Administration</span>
                                                </div>
                                                <input type="text" class="form-control" name="hrd_manager" id="txtHrdManager"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Pollution Control Officer</span>
                                                </div>
                                                <input type="text" class="form-control" name="ems_manager" id="txtEmsManager"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <label>OHS Requirements (Please Check applicable item; Must complied before/during conduct
                                        of work) (PMI SO In charge to fill up)</label>
                                </div>
                            </div>

                            <input type="hidden" class="counterclass" name="ohs_requirements_counter" id="ohsRequirementsCounterID">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="checkbox" class="darren_bugok" id="discussPmiEhsID" name="discuss_pmi_ehs" value="1"><label
                                        for="discussPmiEhsID">&nbsp;&nbsp; 1. Discuss PMI EHS Policies and applicable health and
                                        safety programs.</label><br>
                                    <label class="form-control-label text-secondary" style="margin-left: 4%;">1.1 Observe proer
                                        waste segregation & disposal.</label><br>
                                    <label class="form-control-label text-secondary" style="margin-left: 4%;">1.2 Material
                                        trimmings and debris should be brough along upon conducting the project.</label><br>
                                    <label class="form-control-label text-secondary" style="margin-left: 4%;">1.3 Isolate/cover
                                        & provide vacuum for those activities that will produce so much dust &ventillation for
                                        strong odor. </label><br>
                                    <label class="form-control-label text-secondary" style="margin-left: 4%;">1.4 Seek EMS
                                        assessment first prior used of chemicals (if there's any).</label><br>
                                    <input type="checkbox" class="darren_bugok" id="discussApprovedOhsID" name="discuss_approved_ohs" value="1"><label
                                        for="discussApprovedOHSId">&nbsp;&nbsp; 2. Discuss approved OHS Work Permit to all
                                        listed workers for the project before start of work; Secure copy of approved OHS Work
                                        Permit in the area;</label><br>
                                    <input type="checkbox" class="darren_bugok" id="bringAndWearId" name="bring_and_wear" value="1"><label for="">&nbsp;&nbsp; 3.
                                        Bring and wear basic Personal Protective Equipment (PPE), (1)Safety Shoes (2) Hard Hat
                                        (3) Goggles/Eye Protection Device (4) Reflective Safety Vest. </label><br>
                                    <input type="checkbox" class="darren_bugok" id="certifiedSkilledWorkersId" name="certified_skilled_workers" value="1"><label for="">&nbsp;&nbsp; 4.
                                        Certified skilled workers are required to work only- Welder,Technician,Crane/Forklift
                                        Operator,Rigger,etc.;Submit Certificate to PMI. </label><br>
                                    <input type="checkbox" class="darren_bugok" id="fullBodyHarnessId" name="full_body_harness" value="1"><label for="">&nbsp;&nbsp; 5.
                                        Full body harness must be worn at all times; Fall arrester/protection must be anchored
                                        on a sturdy location; Safety/support lifelines installed.</label><br>
                                    <input type="checkbox" class="darren_bugok" id="scaffoldStrenghtId" name="scaffold_strenght" value="1"><label for="">&nbsp;&nbsp; 6.
                                        Scaffold strength is 4 times anticipated load. Guard railing installed. Platform is
                                        level; Wheeled type of scaffolds have wheel locking mechanism.</label><br>
                                    <input type="checkbox" class="darren_bugok" id="scaffoldStabilityId" name="scafold_stability" value="1"><label for="">&nbsp;&nbsp; 7.
                                        Scaffold stability ensured and checked. Bracing and support adequate; Ensure firmness
                                        and rigidity of bracing, planks and rolling tower.</label><br>
                                    <input type="checkbox" class="darren_bugok" id="strictlyNoPassageId" name="strictly_no_passage" value="1"><label for="">&nbsp;&nbsp; 8.
                                        Strictly no passage of workers/people underneath the scaffolding;</label><br>
                                    <input type="checkbox" class="darren_bugok" id="provideAppropriateBarricade" name="provide_appropriate_barricade" value="1"><label for="">&nbsp;&nbsp; 9.
                                        Provide appropriate Barricade/enclosure of the area and post appropriate
                                        caution/signages; Do not obstruct emergency device.</label><br>
                                    <input type="checkbox" class="darren_bugok" id="provideAppropriateSafetyNet" name="provide_appropriate_safety_net" value="1"><label for="">&nbsp;&nbsp;
                                        10. Provide appropriate Safety net if working overhead. </label><br>
                                    <input type="checkbox" class="darren_bugok" id="insulatedPpeId" name="insulated_ppe" value="1"><label for="">&nbsp;&nbsp;
                                        11. Insulated PPE must worn at all times. Tools must be insulated; Ensure proper
                                        grounding for electrical works; Implement Lock Out/Tag Out. </label><br>
                                    <input type="checkbox" class="darren_bugok" id="noLiftingActivity" name="no_lifting_activity" value="1"><label for="">&nbsp;&nbsp;
                                        12. No lifting activity of heavy loads if raining or during high/strong winds when
                                        working outside. </label><br>
                                    <input type="checkbox" class="darren_bugok" id="strictlyToolsId" name="strictly_tools" value="1"><label for="">&nbsp;&nbsp;
                                        13. Strictly tools and equipmentto be brought inside and used must in good functioning
                                        condition. Have permits for Generator Sets and Cranes. </label><br>
                                    <input type="checkbox" class="darren_bugok" id="fireExtinguisherId" name="fire_extinguisher" value="1"><label for="">&nbsp;&nbsp;
                                        14. Fire extinguisher must be available in the area and operable; Workers know how to
                                        use the Fire Extinguishers.</label><br>
                                    <input type="checkbox" class="darren_bugok" id="strictlyNoFlammableId" name="stricty_no_flammable" value="1"><label for="">&nbsp;&nbsp;
                                        15. Strictly No flammable and combustible items in the project and surrounding area when
                                        hotworks is conducted; Area have good ventilation.</label><br>
                                    <input type="checkbox" class="darren_bugok" id="fireBlanketId" name="fire_blanket" value="1"><label for="">&nbsp;&nbsp;
                                        16. Fire blanket/welding mat must be available; Firewatch must be present all the times.
                                        Heat/smoke detectors in the area are disabled and protected.</label><br>
                                    <input type="checkbox" class="darren_bugok" id="gasCylinderId" name="gas_cylinder" value="1"><label for="">&nbsp;&nbsp;
                                        17. Gas cylinders must be properly placed, stored in upwright position and with safety
                                        caps.</label><br>
                                    <input type="checkbox" class="darren_bugok" id="strictlyObservedBuddyId" name="strictly_observed_buddy" value="1"><label for="">&nbsp;&nbsp;
                                        18. Strictly observed buddy system during conduct of work; For Confine Space Work,
                                        please comply the AREA CONTROL CHECK ITEMS:</label><br>
                                    <input type="checkbox" class="darren_bugok" id="conductDailyId" name="conduct_daily" value="1"><label for="">&nbsp;&nbsp;
                                        19. Conduct daily/weekly tool box meeting; Safety In-Charge to conduct compliance
                                        inspection; Strictly NO Smoking inside PMI Premises.</label><br>
                                    <input type="checkbox" class="darren_bugok" id="practiceSafetyFirstId" name="practice_safety_first" value="1"><label for="">&nbsp;&nbsp;
                                        20. Practice safety first and Discipline; Observe proper behaviour at hallways and
                                        common areas; Maintain Good Housekeeping/5S always.</label><br>
                                    <input type="checkbox" class="darren_bugok" id="othersParticipateId" name="others_participate" value="1"><label for="">&nbsp;&nbsp;
                                        21. Others :Participate in company wide safety program such as emergency
                                        drills.</label><br>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" style="margin-right: auto;" class="btn btn-default"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" id="btnSubmitContractorNeed" class="btn btn-primary"><i
                                        id="btnSubmitContractorNeedIcon" class="fa fa-upload"></i> Submit</button>
                            </div>
                </div>
            </div>
        </div>
    </div>



    @endsection

    @section('js_content')
        <script type="text/javascript">
            GetContractorID($(".selectContractorID"));

            workPermitTabValidation($('#sessionUsername').val());

            //Initialize Select2 Elements
            // $('.selectAddProjectInCharge').select2({
            //             theme: 'bootstrap4'
            //         });
            GetLocalNo($(".selectLocalNo"));

            $('.selectAddSafetyofficerInCharge').select2({
                theme: 'bootstrap4'
            });
            $('.selectAddOverAllSafetyOfficer').select2({
                theme: 'bootstrap4'
            });
            $('.selectAddHrdManager').select2({
                theme: 'bootstrap4'
            });
            $('.selectAddEmsManager').select2({
                theme: 'bootstrap4'
            });


            $('input[name="none_name"]').on('change', function() {
                if ($(this).is(":checked")) {
                    $('#fireAlarmSystemID').attr('disabled', true);
                    $('#EmergencyLightingID').attr('disabled', true);
                    $('#pagingSystemSpeakerID').attr('disabled', true);
                    $('#emergencyExitDoorID').attr('disabled', true);
                    $('#fireExtinguisherFireHoseID').attr('disabled', true);

                } else {
                    $('#fireAlarmSystemID').attr('disabled', false);
                    $('#EmergencyLightingID').attr('disabled', false);
                    $('#pagingSystemSpeakerID').attr('disabled', false);
                    $('#emergencyExitDoorID').attr('disabled', false);
                    $('#fireExtinguisherFireHoseID').attr('disabled', false);
                }

            });

            $('input[name="fire_extinguisher_fire_hose"]').on('change', function() {
                if ($(this).is(":checked")) {
                    $('#noneID').attr('disabled', true);

                } else {
                    $('#noneID').attr('disabled', false);
                }

            });

            $('input[name="emergency_exit_door"]').on('change', function() {
                if ($(this).is(":checked")) {
                    $('#noneID').attr('disabled', true);

                } else {
                    $('#noneID').attr('disabled', false);
                }

            });

            $('input[name="paging_system_speaker"]').on('change', function() {
                if ($(this).is(":checked")) {
                    $('#noneID').attr('disabled', true);

                } else {
                    $('#noneID').attr('disabled', false);
                }

            });


            $('input[name="fire_alarm_system"]').on('change', function() {
                if ($(this).is(":checked")) {
                    $('#noneID').attr('disabled', true);

                } else {
                    $('#noneID').attr('disabled', false);
                }

            });

            $('input[name="emergency_lighting"]').on('change', function() {
                if ($(this).is(":checked")) {
                    $('#noneID').attr('disabled', true);

                } else {
                    $('#noneID').attr('disabled', false);
                }

            });


            // GetProjectInChargeApprover($(".selectAddProjectInCharge"));
            GetSafetyOfficerInChargeApprover($(".selectAddSafetyofficerInCharge"));
            GetOverAllSafetyOfficer($(".selectAddOverAllSafetyOfficer"));
            GetHrdManager($(".selectAddHrdManager"));
            GetEmsManager($(".selectAddEmsManager"));

            $('#startDateID').attr('disabled', true);
            $('#endDateID').attr('disabled', true);
            $('#workTimeID').attr('disabled', true);
            $('#insidePmiTypeID').attr('disabled', true);
            $('#outsidePmiTypeID').attr('disabled', true);
            $('#heightsPmiID').attr('disabled', true);
            $('#hotWorksPmiID').attr('disabled', true);
            $('#confineSpacePmiID').attr('disabled', true);
            $('#txtPersonInChargeID').attr('disabled', true);
            $('#txtPersonInChargeDepartmentID').attr('disabled', true);
            $('#txtActivityID').attr('disabled', true);
            // $('#txtDescriptionID').attr('disabled', true);
            $('#txtWorkScheduleId').attr('disabled', true);
            $('#txtLocalnumberID').attr('disabled', true);
            $('#txtLocationID').attr('disabled', true);
            $('#selContractorID').attr('disabled', true);
            $('#contractorPersonInChargeID').attr('disabled', true);
            $('#contractorSafetyOfficerInChargeID').attr('disabled', true);


            $('input[name="work_classification"]').on('change', function() {

                $('#startDateID').attr('disabled', false);
                $('#endDateID').attr('disabled', false);
                $('#workTimeID').attr('disabled', false);
                $('#insidePmiTypeID').attr('disabled', false);
                $('#outsidePmiTypeID').attr('disabled', false);
                $('#heightsPmiID').attr('disabled', false);
                $('#hotWorksPmiID').attr('disabled', false);
                $('#confineSpacePmiID').attr('disabled', false);
                $('#txtPersonInChargeID').attr('disabled', false);
                $('#txtPersonInChargeDepartmentID').attr('disabled', false);
                $('#txtActivityID').attr('disabled', false);
                // $('#txtDescriptionID').attr('disabled', false);
                $('#txtLocalnumberID').attr('disabled', false);
                $('#txtLocationID').attr('disabled', false);
                $('#txtWorkScheduleId').attr('disabled', false);
                $('#selContractorID').attr('disabled', false);
                $('#contractorPersonInChargeID').attr('disabled', false);
                $('#contractorSafetyOfficerInChargeID').attr('disabled', false);
                // $.datepicker._clearDate('#startDateID');

                var checked = $('input[name="work_classification"]:checked').val();
                // console.log(checked);
                if (checked == 1) {
                    var someDate = new Date();
                    someDate.setDate(someDate.getDate()); //number  of days to add, e.x. 15 days
                    var dateFormated = someDate.toISOString().substr(0, 10);


                    // var today = new Date().toISOString().split('T')[0];
                    // document.getElementsByName("start_date")[0].setAttribute('min', dateFormated);
                    // document.getElementsByName("start_date")[0].setAttribute('max', dateFormated);
                    var date = someDate.getFullYear() + '-' + (someDate.getMonth() + 1) + '-' + someDate.getDate();
                    var newDate = moment(date).format('YYYY-MM-DD');
                    $('#startDateID').val(newDate);
                    // document.getElementsByName("start_date")[0].setAttribute('min', dateFormated);
                    // document.getElementsByName("start_date")[0].setAttribute('max', dateFormated);
                    // $('#startDateID').attr('disabled',true);
                    // console.log(res);
                    document.getElementsByName("end_date")[0].setAttribute('min', dateFormated);

                } else if (checked == 0) {
                    var someDate = new Date();
                    someDate.setDate(someDate.getDate() + 2); //number  of days to add, e.x. 15 days
                    var dateFormated = someDate.toISOString().substr(0, 10);

                    // var today = new Date().toISOString().split('T')[0];
                    // document.getElementsByName("start_date")[0].setAttribute('min', dateFormated);
                    // document.getElementsByName("end_date")[0].setAttribute('min', dateFormated);

                }

            });
                 //=============== ADD WORKER DETAILS =====================//

            let workerDetails = 1;
            $('#add_worker_details_row').click(function(){
                let workerDetailsForEdit =  $('#worker_details_counter').val();
                let editData = $('#editData').val();

                if(editData != 0){
                    workerDetailsForEdit++;
                    if(workerDetailsForEdit > 1){
                        $('#remove_worker_details_row').removeClass('d-none');
                    }
                    console.log('Add row workerDetailsForEdit ', workerDetailsForEdit);

                    var html =  '     <div class="divHeader_'+workerDetailsForEdit+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ workerDetailsForEdit +'.</span></h6></div>';
                        html += '	  <div class="row mt-2 generatedDiv"  id="row_'+workerDetailsForEdit+'">';

                            html += '<div class="col-md-12">';

                                html += '<div class="input-group input-group-sm mb-3">';
                                    html += '<div class="input-group-prepend" style="width: 30%;">';
                                    html += '<span class="input-group-text w-100" id="basic-addon1">Worker Name</i></span>';
                                    html += '</div>';
                                    html += '<input type="text" class="form-control mr-3" id="addWorkerNameId_'+workerDetails+'" name="add_worker_name_'+workerDetails+'" autocomplete="off">';

                                    html += '<div class="input-group-prepend" style="width: 30%;">';
                                    html += '<span class="input-group-text w-100" id="basic-addon1">Worker Position</i></span>';
                                    html += '</div>';
                                    html += ' <input type="text" class="form-control" id="addWorkerPositionId_'+workerDetails+'" name="add_worker_position_'+workerDetails+'" autocomplete="off">';
                                html += '</div>';


                            html += '</div>';

                            html += '<div class="input-group input-group-sm mb-3">';
                                    html += '<div class="input-group-prepend" style="width: 30%;">';
                                    html += '<span class="input-group-text w-100" id="basic-addon1">Contractors OHS Training Date</i></span>';
                                    html += '</div>';
                                    html += '<input type="date" class="form-control mr-3" id="addOhsTrainingDateId_'+workerDetails+'" name="add_ohs_training_date_'+workerDetails+'">';

                                    html += '<div class="input-group-prepend" style="width: 30%;">';
                                    html += '<span class="input-group-text w-100" id="basic-addon1">Contractors OHS Training Date</i></span>';
                                    html += '</div>';
                                    html += '<input type="date" class="form-control" id="addSkillsTrainingDate_'+workerDetails+'" name="add_skills_training_date_'+workerDetails+'">';
                                html += '</div>'


                            html += '</div>';

                            html += '<div class="col-md-6">';
                                    html += '<div class="input-group input-group-sm mb-3">';
                                        html += '<div class="input-group-prepend" style="width: 61%;">';
                                        html += '<span class="input-group-text w-100" id="basic-addon1">Certificate Submission Date</i></span>';
                                        html += '</div>';
                                        html += '<input type="date" class="form-control" id="addCertificateSubmissionDate_'+workerDetails+'" name="add_certificate_submission_date_'+workerDetails+'">';
                                    html += '</div>';

                            html += '</div>';



                        html += '   </div>';
                    $('#worker_details_counter').val(workerDetailsForEdit);
                    $('#divWorkerDetails').append(html);
                }else{
                    workerDetails++;
                    if(workerDetails > 1){
                        $('#remove_worker_details_row').removeClass('d-none');
                    }
                    console.log('Add row workerDetails ', workerDetails);

                    let worker_details_counter = $("input[name='worker_details_counter']", $('#divWorkerDetails')).val();
                    var html =  '     <div class="divHeader_'+workerDetails+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ workerDetails +'.</span></h6></div>';
                        html += '	  <div class="row mt-2 generatedDiv"  id="row_'+workerDetails+'">';

                            html += '<div class="col-md-12">';

                                html += '<div class="input-group input-group-sm mb-3">';
                                    html += '<div class="input-group-prepend" style="width: 30%;">';
                                    html += '<span class="input-group-text w-100" id="basic-addon1">Worker Name</i></span>';
                                    html += '</div>';
                                    html += '<input type="text" class="form-control mr-3" id="addWorkerNameId_'+workerDetails+'" name="add_worker_name_'+workerDetails+'" autocomplete="off">';

                                    html += '<div class="input-group-prepend" style="width: 30%;">';
                                    html += '<span class="input-group-text w-100" id="basic-addon1">Worker Position</i></span>';
                                    html += '</div>';
                                    html += ' <input type="text" class="form-control" id="addWorkerPositionId_'+workerDetails+'" name="add_worker_position_'+workerDetails+'" autocomplete="off">';
                                html += '</div>';

                                html += '<div class="input-group input-group-sm mb-3">';
                                    html += '<div class="input-group-prepend" style="width: 30%;">';
                                    html += '<span class="input-group-text w-100" id="basic-addon1">Contractors OHS Training Date</i></span>';
                                    html += '</div>';
                                    html += '<input type="date" class="form-control mr-3" id="addOhsTrainingDateId_'+workerDetails+'" name="add_ohs_training_date_'+workerDetails+'">';

                                    html += '<div class="input-group-prepend" style="width: 30%;">';
                                    html += '<span class="input-group-text w-100" id="basic-addon1">Contractors OHS Training Date</i></span>';
                                    html += '</div>';
                                    html += '<input type="date" class="form-control" id="addSkillsTrainingDate_'+workerDetails+'" name="add_skills_training_date_'+workerDetails+'">';
                                html += '</div>'


                            html += '</div>';

                            html += '<div class="col-md-6">';
                                    html += '<div class="input-group input-group-sm mb-3">';
                                        html += '<div class="input-group-prepend" style="width: 61%;">';
                                        html += '<span class="input-group-text w-100" id="basic-addon1">Certificate Submission Date</i></span>';
                                        html += '</div>';
                                        html += '<input type="date" class="form-control" id="addCertificateSubmissionDate_'+workerDetails+'" name="add_certificate_submission_date_'+workerDetails+'">';
                                    html += '</div>';

                            html += '</div>';

                        html += '   </div>';
                    $('#worker_details_counter').val(workerDetails);
                    $('#divWorkerDetails').append(html);
                }
            });

            $("#workerDetailsCard").on('click', '#remove_worker_details_row', function(e){
                let workerDetailsForEdit =  $('#worker_details_counter').val();

                if($('#editData').val() == 1){
                    if(workerDetailsForEdit > 1){
                        $('.divHeader_'+workerDetailsForEdit).remove();
                        $('#workerDetailsCard').find('#row_'+workerDetailsForEdit).remove();
                        console.log('Total of workerDetailsForEdit before removing row: ', workerDetailsForEdit);
                        workerDetailsForEdit--;
                        $('#worker_details_counter').val(workerDetailsForEdit).trigger('change');
                        console.log('Total of workerDetailsForEdit after removing row: ' + workerDetailsForEdit);

                    }

                    if(workerDetailsForEdit < 2){
                        $('#remove_worker_details_row').addClass('d-none');
                    }
                }else{
                    if(workerDetails > 1){
                        $('.divHeader_'+workerDetails).remove();
                        $('#workerDetailsCard').find('#row_'+workerDetails).remove();
                        console.log('Total of workerDetails before removing row: ', workerDetails);
                        workerDetails--;
                        $('#worker_details_counter').val(workerDetails).trigger('change');
                        console.log('Total of workerDetails after removing row: ' + workerDetails);
                    }

                    if(workerDetails < 2){
                        $('#remove_worker_details_row').addClass('d-none');
                    }
                }

            });

            //=============== ADD WORKER DETAILS END =====================//

            //============================= ADD TOOLS DETAILS =============================
            let toolsDetails = 1;
            $('#add_tools_details_row').click(function(){
                let toolsDetailsForEdit =  $('#tools_details_counter').val();
                let editData = $('#editData').val();

                if(editData != 0){
                    toolsDetailsForEdit++;
                    if(toolsDetailsForEdit > 1){
                        $('#remove_tools_details_row').removeClass('d-none');
                    }
                    console.log('Add row toolsDetailsForEdit ', toolsDetailsForEdit);

                    var html =  '     <div class="divHeader_'+toolsDetailsForEdit+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ toolsDetailsForEdit +'.</span></h6></div>';
                        html += '	  <div class="row mt-2 generatedDiv"  id="row_'+toolsDetailsForEdit+'">';


                            html += '<div class="col-md-12">';

                                html += '<div class="input-group input-group-sm mb-3">';
                                    html += '<div class="input-group-prepend" style="width: 8%;">';
                                    html += '<span class="input-group-text w-20" id="basic-addon1">Tool Name</i></span>';
                                    html += '</div>';
                                    html += '<input type="text" class="form-control mr-3" id="addToolsNameId_'+toolsDetails+'" name="add_tools_name_'+toolsDetails+'" autocomplete="off">';

                                    html += '<div class="input-group-prepend" style="width: 7%;">';
                                    html += '<span class="input-group-text w-35" id="basic-addon1">Quantity</i></span>';
                                    html += '</div>';
                                    html += ' <input type="text" class="form-control mr-3" id="addToolsQuantityId_'+toolsDetails+'" name="add_tools_quantity_'+toolsDetails+'" autocomplete="off">';

                                    html += '<div class="input-group-prepend" style="width: 15%;">';
                                    html += '<span class="input-group-text w-100" id="basic-addon1">Other Requirements</i></span>';
                                    html += '</div>';
                                    html += ' <input type="text" class="form-control" id="addOtherRequirementsId_'+toolsDetails+'" name="add_other_requirements_'+toolsDetails+'" autocomplete="off">';
                                html += '</div>';


                            html += '</div>';


                        html += '   </div>';
                    $('#tools_details_counter').val(toolsDetailsForEdit);
                    $('#divToolsDetails').append(html);
                }else{
                    toolsDetails++;
                    if(toolsDetails > 1){
                        $('#remove_tools_details_row').removeClass('d-none');
                    }
                    console.log('Add row toolsDetails ', toolsDetails);

                    let tools_details_counter = $("input[name='tools_details_counter']", $('#divToolsDetails')).val();
                    // let customerClaimId = $("input[name='customer_claim_id'", $("#formCustomerClaim")).val();
                    // console.log('customerClaimId ', customerClaimId);
                    var html =  '     <div class="divHeader_'+toolsDetails+' generatedDivHeader"><h6s><span class="badge badge-secondary"> # '+ toolsDetails +'.</span></h6s></div>';
                        html += '	  <div class="row mt-2 generatedDiv"  id="row_'+toolsDetails+'">';

                            html += '<div class="col-md-12">';

                                html += '<div class="input-group input-group-sm mb-3">';
                                    html += '<div class="input-group-prepend" style="width: 8%;">';
                                    html += '<span class="input-group-text w-100" id="basic-addon1">Tool Name</i></span>';
                                    html += '</div>';
                                    html += '<input type="text" class="form-control mr-3" id="addToolsNameId_'+toolsDetails+'" name="add_tools_name_'+toolsDetails+'" autocomplete="off">';

                                    html += '<div class="input-group-prepend" style="width: 7%;">';
                                    html += '<span class="input-group-text w-100" id="basic-addon1">Quantity</i></span>';
                                    html += '</div>';
                                    html += ' <input type="text" class="form-control mr-3" id="addToolsQuantityId_'+toolsDetails+'" name="add_tools_quantity_'+toolsDetails+'" autocomplete="off">';

                                    html += '<div class="input-group-prepend" style="width: 15%;">';
                                    html += '<span class="input-group-text w-100" id="basic-addon1">Other Requirements</i></span>';
                                    html += '</div>';
                                    html += ' <input type="text" class="form-control mr-3" id="addOtherRequirementsId_'+toolsDetails+'" name="add_other_requirements_'+toolsDetails+'" autocomplete="off">';
                                html += '</div>';


                            html += '</div>';


                        html += '   </div>';
                    $('#tools_details_counter').val(toolsDetails);
                    $('#divToolsDetails').append(html);
                }
            });

            $("#toolsDetailsCard").on('click', '#remove_tools_details_row', function(e){
                let toolsDetailsForEdit =  $('#tools_details_counter').val();

                if($('#editData').val() == 1){
                    if(toolsDetailsForEdit > 1){
                        $('.divHeader_'+toolsDetailsForEdit).remove();
                        $('#toolsDetailsCard').find('#row_'+toolsDetailsForEdit).remove();
                        console.log('Total of toolsDetailsForEdit before removing row: ', toolsDetailsForEdit);
                        toolsDetailsForEdit--;
                        $('#tools_details_counter').val(toolsDetailsForEdit).trigger('change');
                        console.log('Total of toolsDetailsForEdit after removing row: ' + toolsDetailsForEdit);

                    }

                    if(toolsDetailsForEdit < 2){
                        $('#remove_tools_details_row').addClass('d-none');
                    }
                }else{
                    if(toolsDetails > 1){
                        $('.divHeader_'+toolsDetails).remove();
                        $('#toolsDetailsCard').find('#row_'+toolsDetails).remove();
                        console.log('Total of toolsDetails before removing row: ', toolsDetails);
                        toolsDetails--;
                        $('#tools_details_counter').val(toolsDetails).trigger('change');
                        console.log('Total of toolsDetails after removing row: ' + toolsDetails);
                    }

                    if(toolsDetails < 2){
                        $('#remove_tools_details_row').addClass('d-none');
                    }
                }

            });


            //============================= ADD TOOLS DETAILS END   =============================


            //===== ADD WORK PERMIT =====//
            $('#btnAddWorkPermit').on('click', function(event) {
                event.preventDefault(); // to stop the form submission
                AddWorkPermit();
            });
            //===== ADD WORK PERMITT END =====//

            $('#selContractorID').on('change', function() {
                $('.selectContractorID').val($(this).find(":selected").val());
                var contractorId = $(".selectContractorID").val();

                // console.log(contractorId);

                $.ajax({
                    url: 'get_contact_person_in_charge',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        contractorId: $('#selContractorID').val()
                    },
                    beforeSend: function() {

                    },
                    success: function(response) {
                        result = '';
                        if (response['contact_person'].length > 0) { // true
                            result =
                                '<option value="0" selected disabled> Select Contractor Person in-Charge </option>';
                            for (let index = 0; index < response['contact_person'].length; index++) {
                                result += '<option value="' + response['contact_person'][index].id + '">' +
                                    response['contact_person'][index].name + '</option>';
                            }
                        } else {
                            result = '<option value="0" selected disabled> No record found </option>';
                        }
                        $('.selectContractorPIC').html(result);
                    }
                });

            });

            $('#selContractorID').on('change', function() {
                $('.selectContractorID').val($(this).find(":selected").val());
                var contractorId = $(".selectContractorID").val();

                // console.log(contractorId);

                $.ajax({
                    url: 'get_contact_safety_officer_in_charge',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        contractorId: $('#selContractorID').val()
                    },
                    beforeSend: function() {

                    },
                    success: function(response) {
                        result = '';
                        if (response['contact_person'].length > 0) { // true
                            result =
                                '<option value="0" selected disabled> Select Contractor Safety Officer in-Charge </option>';
                            for (let index = 0; index < response['contact_person'].length; index++) {
                                result += '<option value="' + response['contact_person'][index].id + '">' +
                                    response['contact_person'][index].name + '</option>';
                            }
                        } else {
                            result = '<option value="0" selected disabled> No record found </option>';
                        }
                        $('.selectContractorSOIC').html(result);
                    }
                });



            });

             // DEACTIVATE WORK PERMIT
            $(document).on('click', '.actionDeleteWorkPermit', function() {

                let workPermitId = $(this).attr('workpermit-id');

                $("#txtDeleteWorkPermitID").val(workPermitId);
            });
            $("#deleteWorkPermitForm").submit(function(event) {
                event.preventDefault();
                DeleteWorkPermit();
            });
            // // DEACTIVATE WORK PERMIT END

            // ============================== APPROVE BUTTON ==============================
            // actionApproveRemark is generated by datatables and open the modalApproveRemark(modal) to collect and change the id & status of the specified rows
            $(document).on('click', '.actionApproveWorkPermit', function() {
                let userApproverStat = $(this).attr(
                'status'); // the status will collect the value (1-, 2-, 3-, 4-, 5-, 6- 7-)
                let work_permitID = $(this).attr(
                'workpermit-id'); // the cash_advance-id(attr) is inside the datatables of UserController that will be use to collect the cash_advance-id

                // console.log(work_permitID);
                // console.log(userApproverStat);


                $("#approvedWorkPermitStat").val(
                userApproverStat); // collect the user status id the default is 2, this will be use to change the user status when the formApproveCashAdvanceRemark(form) is submitted
                $("#approvedWorkPermitID").val(
                work_permitID); // after clicking the actionApproveRemark(button) the userId will be pass to the approvedCashAdvanceUserId(input=hidden) and when the form is submitted this will be pass to ajax and collect cash_advance-id that will be use to query the cash_advance-id in the CashAdvanceController to update the status of the user
            });
            // The ChangeUserStatus(); function is inside public/js/my_js/User.js
            // after the submission, the ajax request will pass the formChangeUserStat(form) of data(input) in the uri(change_user_stat)
            // then the controller will handle that uri to use specific method called change_user_stat() inside UserController
            $("#formApproveWorkPermit").submit(function(event) {
                event.preventDefault();
                ApprovedWorkPermit();
            });

            // ============================== DISAPPROVE BUTTON ==============================
            $(document).on('click', '.actionWorkPermitNotClear', function() {
                let not_clearWP = $(this).attr(
                'status'); // the status will collect the value (1-, 2-, 3-, 4-, 5-, 6- 7-)
                let not_clear_WP = $(this).attr(
                'workpermit-id'); // the cash_advance-id(attr) is inside the datatables of CashAdvanceController that will be use to collect the cash_advance-id
                // let remarks = $(this).attr('remarks'); // the cash_advance-id(attr) is inside the datatables of CashAdvanceController that will be use to collect the cash_advance-id

                // console.log(not_clearWP);
                // console.log(not_clear_WP);
                $("#notClearWorkPermitStat").val(
                not_clearWP); // collect the user status id the default is 2, this will be use to change the user status when the formApproveCashAdvanceRemark(form) is submitted
                $("#notClearWorkPermitID").val(
                not_clear_WP); // after clicking the actionApproveRemark(button) the userId will be pass to the approvedCashAdvanceUserId(input=hidden) and when the form is submitted this will be pass to ajax and collect cash_advance-id that will be use to query the cash_advance-id in the CashAdvanceController to update the status of the user
                // $("#classification_remarks").val(remarks); // after clicking the actionDisapproveRemark(button) the userId will be pass to the approvedCashAdvanceUserId(input=hidden) and when the form is submitted this will be pass to ajax and collect cash_advance-id that will be use to query the cash_advance-id in the CashAdvanceController to update the status of the user
            });


            $("#formDisapprovedWorkPermit").submit(function(event) {
                event.preventDefault();
                DisapproveWorkPermit();
            });

            $("#filterApprovedWpId").on('click', function(){
                dataTableWorkPermit.draw();
            });

            $("#fiterForApproval").on('click', function(){
                dataTableWorkPermit.draw();
            });

            //============================== VIEW WORK PERMIT DATATABLES  START ==============================
            dataTableWorkPermit = $("#workpermitTable").DataTable({
                "processing": false,
                "serverSide": true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // "scrollX": true,
                // "scrollX": "100%",
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ records",
                    "lengthMenu": "Show _MENU_ records",
                },
                "ajax": {
                    url: "view_work_permit", // this will be pass in the uri called view_users_archive that handles datatables of view_users_archive() method inside UserController
                    data: function (param){
                        if($('#filterApprovedWpId').is(':checked')){
                            param.approved = $("#filterApprovedWpId").val();
                        }

                        if($('#fiterForApproval').is(':checked')){
                            param.forApproval = $("#fiterForApproval").val();
                        }
                    }
                },
                "columns": [{
                    "data": "status",
                        orderable: false
                    },
                    {
                        "data": "work_permit_details.permit_number",
                        orderable: false
                    },
                    {
                        "data": "work_permit_details.contractor_id_name.company",
                        orderable: false
                    },
                    {
                        "data": "work_permit_details.activity",
                        orderable: false
                    },
                    {
                        "data": "start_date",
                        orderable: false
                    },
                    {
                        "data": "end_date",
                        orderable: false
                    },
                    {
                        "data": "work_permit_details.attach_file",
                        orderable: false
                    },
                    {
                        "data": "work_permit_details.person_in_charge",
                        orderable: false
                    },
                    {
                        "data": "approver",
                    },
                    {
                        "data": "clearance",
                    },
                    {
                        "data": "action",
                        orderable: false,
                        searchable: false
                    }
                ],
                // "pageLength": 5
            }); // VIEW CONTRACTOR CONTACTS DATATABLES END

             //============================== VIEW WORK PERMIT DATATABLES  START ==============================
             dataTableSeeAllWorkPermit = $("#seeAllWorkPermitDataTables").DataTable({
                "processing": false,
                "serverSide": true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // "scrollX": true,
                // "scrollX": "100%",
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ records",
                    "lengthMenu": "Show _MENU_ records",
                },
                "ajax": {
                    url: "view_all_work_permit", // this will be pass in the uri called view_users_archive that handles datatables of view_users_archive() method inside UserController
                    data: function (param){
                        if($('#filterApprovedWpId').is(':checked')){
                            param.approved = $("#filterApprovedWpId").val();
                        }

                        if($('#fiterForApproval').is(':checked')){
                            param.forApproval = $("#fiterForApproval").val();
                        }

                        if($('#filterForMyApproval').is(':checked')){
                            param.forMyApproval = $("#filterForMyApproval").val();
                        }
                    }
                },
                "columns": [{
                    "data": "status",
                        orderable: false
                    },
                    {
                        "data": "permit_number",
                        orderable: false
                    },
                    {
                        "data": "contractor_id_name.company",
                        orderable: false
                    },
                    {
                        "data": "activity",
                        orderable: false
                    },
                    {
                        "data": "start_date",
                        orderable: false
                    },
                    {
                        "data": "end_date",
                        orderable: false
                    },
                    {
                        "data": "attach_file",
                        orderable: false
                    },
                    {
                        "data": "person_in_charge",
                        orderable: false
                    },
                    {
                        "data": "approver",
                        orderable: false

                    },
                    {
                        "data": "clearance",
                    },
                    {
                        "data": "action",
                        orderable: false,
                        searchable: false
                    }
                ],
                // "pageLength": 5
            }); // VIEW CONTRACTOR CONTACTS DATATABLES END


            //SHOW WORK PERMIT DETAILS
            $(document).on('click', '.actionShowWorkPermit', function() {

                // $("#modalEditContractorContact").modal('show');
                let workpermitID = $(this).attr('workpermit-id');
                $("#workPermitID").val(workpermitID);
                $("#ohsRequirementsCounterID").val(workpermitID)
                // console.log(workpermitID);
                GetWorkPermitIdToView(workpermitID);

                $("#txtpermitNumberID").removeClass('is-invalid');
                $("#txtpermitNumberID").attr('title', '');

                $("#txtClassificatiodID").removeClass('is-invalid');
                $("#txtClassificatiodID").attr('title', '');

                $("#txtWorkPermitTypeID").removeClass('is-invalid');
                $("#txtWorkPermitTypeID").attr('title', '');


                $("#txtPersonInCharge").removeClass('is-invalid');
                $("#txtPersonInCharge").attr('title', '');

                $("#txtActivityNameID").removeClass('is-invalid');
                $("#txtActivityNameID").attr('title', '');

                $("#txtDescription").removeClass('is-invalid');
                $("#txtDescription").attr('title', '');

                $("#txtContractorsCompanyNameID").removeClass('is-invalid');
                $("#txtContractorsCompanyNameID").attr('title', '');

                $("#txtContractorsPersonInChargeID").removeClass('is-invalid');
                $("#txtContractorsPersonInChargeID").attr('title', '');

                $("#txtContractorsSafetyInChargeID").removeClass('is-invalid');
                $("#txtContractorsSafetyInChargeID").attr('title', '');

                $("#txtPmiInChargeDeparmentID").removeClass('is-invalid');
                $("#txtPmiInChargeDeparmentID").attr('title', '');

                $("#txtPmiInChargeLocalnoID").removeClass('is-invalid');
                $("#txtPmiInChargeLocalnoID").attr('title', '');

                $("#txtPmiInChargeLocationID").removeClass('is-invalid');
                $("#txtPmiInChargeLocationID").attr('title', '');

                $("#txtProjectDurationID").removeClass('is-invalid');
                $("#txtProjectDurationID").attr('title', '');

                $("#txtWorkScheduleID").removeClass('is-invalid');
                $("#txtWorkScheduleID").attr('title', '');

                $("#txtWorkDateID").removeClass('is-invalid');
                $("#txtWorkDateID").attr('title', '');

                $("#txtWorkTimeID").removeClass('is-invalid');
                $("#txtWorkTimeID").attr('title', '');
            });

            // $("#EditContractorContact").submit(function(event) {
            //     event.preventDefault(); // to stop the form submission
            // });
            //SHOW WORK PERMIT DETAILS

            $(document).on('click', '.actionEditWorkPermit', function() {

            // $("#modalEditContractorContact").modal('show');
            let workpermitID = $(this).attr('workpermit-id');
            $("#editWorkPermitId").val($(this).attr('workpermit-id'));
            // console.log(workpermitID);

            // console.log(editWorkPermitId);
            // $('#workPermitId').val(result[0].department_name);

            GetWorkPermitIdToEdit(workpermitID);

            $("#editWorkPermitForm").submit(function(event){
                event.preventDefault();
                EditWordPermit();
            });
        });

        //EXTEND WORK PERMIT
        $(document).on('click', '.actionExtendWorkPermit', function() {

        // $("#modalEditContractorContact").modal('show');
        let workpermitID = $(this).attr('workpermit-id');
        $("#txtExtendWorkPermitID").val($(this).attr('workpermit-id'));
        // console.log($("#workPermitId").val(workpermitID));

        // console.log(editWorkPermitId);
        // $('#workPermitId').val(result[0].department_name);

        GetWorkPermitIdToExtend(workpermitID);

            $("#ExtendWorkPermitForm").submit(function(event){
                event.preventDefault();
                ExtendWorkPermit();
            });
        });

            // ================================= AUTO ADD REQUESTOR BY USER =================================
            $('#btnAddWorkPermitModal').on('click', function() {
                $.ajax({
                    url: "get_rapidx_user",
                    method: "get",
                    dataType: "json",
                    beforeSend: function() {},
                    success: function(response) {
                        let result = response['get_user'];
                        // console.log(result[0].name);
                        $('#txtAddProjectInCharge').val(result[0].name);
                        $('#txtPersonInChargeID').val(result[0].name);
                    },
                });

                $.ajax({
                    url: "get_rapidx_user_department",
                    method: "get",
                    dataType: "json",
                    beforeSend: function() {},
                    success: function(response) {
                        let result = response['get_user_department'];
                        $('#txtPersonInChargeDepartmentID').val(result[0].department_name);
                    },
                });

                $.ajax({
                    url: 'get_counter',
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        $(".counterclass").val(response['counter']);
                        // console.log(response);
                    }
                });
            });

            $('#btnSubmitContractorNeed').on('click', function(event){
                event.preventDefault();
                if ($('input:checkbox').is(':checked')){
                    AddOhsRequirements();
                }else{
                    alert('Magandang buhay,\nKamusta/Kumusta ka na Kaibigan! \n\n            Mangyaring Suriin muna ang naaangkop para sa manggagawang pupunta sa Pricon Microelectronics, Inc \nat kapag napili na ang dapat pilian, mangyaring ipasa na \nito para magpatuloy ang pag-aapruba sa napiling \nSafety Officer in-charge nang iyong Work Permit. \n\n Nagmamahal,\nDah!</3');
                    return false;
                }
                // $('#formViewWPRequest').serialize();
                // console.log($('#formViewWPRequest').serialize());
            });

            $('#btnExportSummary').on('click', function(){

                // console.log($('#formViewWPRequest').serialize());
                let year_id = $('#selectYearId').val();
                let selected_month = $('#selectMonthId').val();

                window.location.href = `export_summary/${year_id}/${selected_month}`;
                // console.log(year_id);
                // console.log(selected_month);
                $('#modalExportSummary').modal('hide');


            });

        </script>

    @endsection
