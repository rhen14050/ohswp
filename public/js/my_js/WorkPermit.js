function GetContractorID(cboElement) {
    let result = '<option value="0" selected disabled> -- Select Contractor -- </option>';
    $.ajax({
        url: 'get_contractorID',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function (response) {
            result = '';
            if (response['contractor'].length > 0) { // true
                result = '<option value="0" selected disabled> Select Contractor </option>';
                for (let index = 0; index < response['contractor'].length; index++) {
                    result += '<option value="' + response['contractor'][index].id + '">' + response['contractor'][index].company + '</option>';
                }
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}

function AddWorkPermit(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    let formData = new FormData($('#addWorkPermitForm')[0]);


    $.ajax({
        url: "add_work_permit",
        method: "post",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function () {
            $("#btnAddWorkPermitIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddWorkPermit").prop('disabled', 'disabled');

        },
        success: function (JsonObject) {


            if (JsonObject['validation'] == 'hasError') {
                toastr.error('Saving failed!');
                if (JsonObject['error']['work_classification'] === undefined) {
                    $("#workClassificationID").removeClass('is-invalid');
                    $("#workClassificationID").attr('title', '');
                }
                else {
                    $("#workClassificationID").addClass('is-invalid');
                    $("#workClassificationID").attr('title', JsonObject['error']['work_classification']);
                }

                if (JsonObject['error']['start_date'] === undefined) {
                    $("#startDateID").removeClass('is-invalid');
                    $("#startDateID").attr('title', '');
                }
                else {
                    $("#startDateID").addClass('is-invalid');
                    $("#startDateID").attr('title', JsonObject['error']['start_date']);
                }

                if (JsonObject['error']['end_date'] === undefined) {
                    $("#endDateID").removeClass('is-invalid');
                    $("#endDateID").attr('title', '');
                }
                else {
                    $("#endDateID").addClass('is-invalid');
                    $("#endDateID").attr('title', JsonObject['error']['end_date']);
                }

                if (JsonObject['error']['work_time'] === undefined) {
                    $("#workTimeID").removeClass('is-invalid');
                    $("#workTimeID").attr('title', '');
                }
                else {
                    $("#workTimeID").addClass('is-invalid');
                    $("#workTimeID").attr('title', JsonObject['error']['work_time']);
                }

                if (JsonObject['error']['txtperson_in_charge'] === undefined) {
                    $("#txtPersonInChargeID").removeClass('is-invalid');
                    $("#txtPersonInChargeID").attr('title', '');
                }
                else {
                    $("#txtPersonInChargeID").addClass('is-invalid');
                    $("#txtPersonInChargeID").attr('title', JsonObject['error']['txtperson_in_charge']);
                }

                if (JsonObject['error']['txtperson_in_charge_department'] === undefined) {
                    $("#txtPersonInChargeDepartmentID").removeClass('is-invalid');
                    $("#txtPersonInChargeDepartmentID").attr('title', '');
                }
                else {
                    $("#txtPersonInChargeDepartmentID").addClass('is-invalid');
                    $("#txtPersonInChargeDepartmentID").attr('title', JsonObject['error']['txtperson_in_charge_department']);
                }

                if (JsonObject['error']['txt_activity'] === undefined) {
                    $("#txtActivityID").removeClass('is-invalid');
                    $("#txtActivityID").attr('title', '');
                }
                else {
                    $("#txtActivityID").addClass('is-invalid');
                    $("#txtActivityID").attr('title', JsonObject['error']['txt_activity']);
                }

                if (JsonObject['error']['txt_description'] === undefined) {
                    $("#txtDescriptionID").removeClass('is-invalid');
                    $("#txtDescriptionID").attr('title', '');
                }
                else {
                    $("#txtDescriptionID").addClass('is-invalid');
                    $("#txtDescriptionID").attr('title', JsonObject['error']['txt_description']);
                }

                if (JsonObject['error']['txt_localnumber'] === undefined) {
                    $("#txtLocalnumberID").removeClass('is-invalid');
                    $("#txtLocalnumberID").attr('title', '');
                }
                else {
                    $("#txtLocalnumberID").addClass('is-invalid');
                    $("#txtLocalnumberID").attr('title', JsonObject['error']['txt_localnumber']);
                }

                if (JsonObject['error']['txt_location'] === undefined) {
                    $("#txtLocationID").removeClass('is-invalid');
                    $("#txtLocationID").attr('title', '');
                }
                else {
                    $("#txtLocationID").addClass('is-invalid');
                    $("#txtLocationID").attr('title', JsonObject['error']['txt_location']);
                }

                if (JsonObject['error']['dd_contractor'] === undefined) {
                    $("#selContractorID").removeClass('is-invalid');
                    $("#selContractorID").attr('title', '');
                }
                else {
                    $("#selContractorID").addClass('is-invalid');
                    $("#selContractorID").attr('title', JsonObject['error']['dd_contractor']);
                }

                if (JsonObject['error']['dd_contractor_person_in_charge'] === undefined) {
                    $("#contractorPersonInChargeID").removeClass('is-invalid');
                    $("#contractorPersonInChargeID").attr('title', '');
                }
                else {
                    $("#contractorPersonInChargeID").addClass('is-invalid');
                    $("#contractorPersonInChargeID").attr('title', JsonObject['error']['dd_contractor_person_in_charge']);
                }

                if (JsonObject['error']['dd_contractor_safety_officer_in_charge'] === undefined) {
                    $("#contractorSafetyOfficerInChargeID").removeClass('is-invalid');
                    $("#contractorSafetyOfficerInChargeID").attr('title', '');
                }
                else {
                    $("#contractorSafetyOfficerInChargeID").addClass('is-invalid');
                    $("#contractorSafetyOfficerInChargeID").attr('title', JsonObject['error']['dd_contractor_safety_officer_in_charge']);
                }


            }
            else if (JsonObject['result'] == 1) {
                dataTableWorkPermit.draw();
                $("#modalAddWorkPermit").modal('hide');
                $("#addWorkPermitForm")[0].reset();
                // $("#counterID")
                toastr.success('Work Permit added!');
            }
            else if (JsonObject['result'] == 0) {
                toastr.error('Saving failed!');
            }
            $("#btnAddWorkPermitIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddWorkPermit").removeAttr('disabled');
            $("#btnAddWorkPermitIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnAddWorkPermitIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddWorkPermit").removeAttr('disabled');
            $("#btnAddWorkPermitIcon").addClass('fa fa-check');
        }
    });
}

function GetWorkPermitIdToEdit(workpermitID) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "get_work_permit_id_to_edit",
        method: "get",
        data: {
            work_permit_id: workpermitID
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            // console.log(response['startDate']);
            // console.log(response['endDate']);



            // console.log(work_permit_id);

            let result = response['permit_number'];
            let permit_number = response['permit_number'];
            let resulta = response['exploded_work_type'];
            let approver_result = response ['approver'];

            let addtnl_worker_arr = result[0].contractor_id;
            let addtnl_tools_arr = result[0].contractor_id;

            $explodedPermit = permit_number[0].work_permit_type.split(", ");

            let moc_status1 = permit_number[0].moc1;
            let moc_status2 = permit_number[0].moc2;
            let moc_status3 = permit_number[0].moc3;

            $("#workPermitId").val(result[0].plc_category);

            // console.log($explodedPermit);
            // console.log(moc_status1);
            // console.log(moc_status2);
            // console.log(moc_status3);

            // console.log(jQuery.inArray('OHS Work Permit Inside PMI Bldg', $explodedPermit));
            $("#editInsidePmiTypeID").prop( "checked", false )
            $("#editOutsidePmiTypeID").prop( "checked", false )
            $("#editHeightsPmiID").prop( "checked", false )
            $("#editHotWorksPmiID").prop( "checked", false )
            $("#editConfineSpacePmiID").prop( "checked", false )


            if(jQuery.inArray('OHS Work Permit Inside PMI Bldg', $explodedPermit) != -1){
                $("#editInsidePmiTypeID").prop( "checked", true )
            }
            if(jQuery.inArray('OHS Work Permit Outside PMI Bldg', $explodedPermit) != -1){
                $("#editOutsidePmiTypeID").prop( "checked", true )
            }
            if(jQuery.inArray('Working at HEIGHTS Permit', $explodedPermit) != -1){
                $("#editHeightsPmiID").prop( "checked", true )
            }
            if(jQuery.inArray('HOT Works Permit', $explodedPermit) != -1){
                $("#editHotWorksPmiID").prop( "checked", true )
            }
            if(jQuery.inArray('Confine Space Works Permit', $explodedPermit) != -1){
                $("#editConfineSpacePmiID").prop( "checked", true )
            }


            if (moc_status1 == 1){
                $("#moc1Id").prop("checked",true);
            }else{
                $("#moc1Id").prop("checked",false);
            }

            if (moc_status2 == 1){
                $("#moc2Id").prop("checked",true);
            }else{
                $("#moc2Id").prop("checked",false);
            }

            if (moc_status3 == 1){
                $("#moc3Id").prop("checked",true);
            }else{
                $("#moc3Id").prop("checked",false);
            }



            if(result[0].classification == 1){
                $("#editWorkClassificationID").prop("checked",true);
                $("#editWorkClassificationIDN").prop("checked",false);

            }else{
                $("#editWorkClassificationID").prop("checked",false);
                $("#editWorkClassificationIDN").prop("checked",true);
            }




            var date_concut = response['startDate'] + '-' + response['endDate'];
            var start_oras = response['start_time'];
            var end_oras = response['end_time']
            var concut_oras = response['start_time'] + '-' + response['end_time'];
            var date = response['startDate'] ;

        //     var today1 = new Date();
        //     console.log(today1);
        //     var texts = "POWP";
            // var aad = response['permit_number'][0].division;
        //     var ax = "001";
        //     var date1 = texts+'-'+aad+'-'+today1.getFullYear().toString().slice(-2)+''+(today1.getMonth()+1)+'-'+ax;

        // console.log(date1);
        // console.log(response['worker'][0].name);
        // console.log(response['resulta']);
        // console.log(response['approver'][0].permit_number);
        // console.log((response['permit_number'][0]));

            // let workpermit = response['permit_number'];
// console.log(permit_number[0].contractor_id.company);
            // if (workpermit.length > 0) {
                // $("#txtpermitNumberID").val(response['permit_number'][0].permit_number);
                // $("#txtClassificatiodID").val(response['permit_number'][0].classification);
                // $("#txtWorkPermitTypeID").val(response['permit_number'][0].work_permit_type);
                $("#editTxtPersonInChargeID").val(response['permit_number'][0].person_in_charge);
                $("#editTxtActivityID").val(response['permit_number'][0].activity);
                $("#editSelContractorID").val(response['permit_number'][0]['contractor_id']['id']).trigger("change");
                // $("#editContractorPersonInChargeID").val(response['permit_number'][0]['id'].trigger("change"));
                // $("#editContractorPersonInChargeID").val(response['permit_number'][0]['contractor_person_in_charge']['name'].trigger("change"));
                // $("#editContractorSafetyOfficerInChargeID").val(response['permit_number'][0]['contractor_safety_officer_in_charge']['name'].trigger("change"));
                $("#editTxtPersonInChargeDepartmentID").val(response['permit_number'][0].department);
                $("#editTxtLocalnumberID").val(response['permit_number'][0].local_number).trigger("change");
                $("#editTxtLocationID").val(response['permit_number'][0].location);
                $("#txtProjectDurationID").val(date_concut);
                $("#editDivisionId").val(response['permit_number'][0].division);
                $("#editTxtWorkScheduleId").val(response['permit_number'][0]['work_schedule']);
                $("#editStartDateID").val(response['permit_number'][0]['start_date']);
                $("#editEndDateID").val(response['permit_number'][0]['end_date']);
                $("#editStartTimeID").val(response['permit_number'][0]['start_time']);
                $("#editEndTimeID").val(response['permit_number'][0]['end_time']);
                $("#editDivision").val(response['permit_number'][0]['division']).trigger('change');
                // $("#editEndTimeID").val(end_oras);
                $("#editTxtContractorName").val(response['worker'][0].name);
                $("#txtWorkerPositionID").val(response['worker'][0].position);
                $("#txtToolNameID").val(response['resulta']);
                $("#txtToolQuantityID").val(response['tools'][0].quantity);
                $("#editTxtTools").val(response['tools'][0].other_requirements);
                $("#txtAffectedSafetyDevicesID").val(response['tools'][0].affected_safety_devices);
                $("#editTxtAddProjectInCharge").val(response['approver'][0].project_in_charge);
                $("#editSelectSafetyofficerInCharge").val(response['approver'][0]['safety_officer_in_charge']['id']).trigger("change");
                $("#editSelectEmsManager").val(response['approver'][0]['ems_manager']['id']).trigger("change");
                $("#editSelectOverAllSafetyOfficer").val(response['approver'][0]['over_all_safety_officer']['id']).trigger("change");
                $("#editSelectHrdManager").val(response['approver'][0]['hrd_manager']['id']).trigger("change");
                $("#ohsRequirementsCounterID").val(response['approver'][0]['counter']);

                var contractorId = $("#editSelContractorID").val();
                var contractor_person_in_charge =  response['permit_number'][0]['contractor_person_in_charge']['id'];
                var contractor_safety_officer_in_charge =  response['permit_number'][0]['contractor_safety_officer_in_charge']['id'];


                getContractorPersonInChargetoEdit(contractorId,contractor_person_in_charge);
                getContractorSafetyOfficerInChargetoEdit(contractorId,contractor_safety_officer_in_charge);



        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function getContractorPersonInChargetoEdit(contractorId,contractor_person_in_charge){
    $.ajax({
        url: 'get_contact_person_in_charge',
        method: 'get',
        dataType: 'json',
        data: {
            contractorId: contractorId,
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


            $('#editContractorPersonInChargeID').val(contractor_person_in_charge).trigger('change');
        }

    });
}

function getContractorSafetyOfficerInChargetoEdit(contractorId,contractor_safety_officer_in_charge){
    $.ajax({
        url: 'get_contact_safety_officer_in_charge',
        method: 'get',
        dataType: 'json',
        data: {
            contractorId: contractorId,
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

            $('#editContractorSafetyOfficerInChargeID').val(contractor_safety_officer_in_charge).trigger('change');

        }
    });
}


function GetWorkPermitIdToView(workpermitID) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "get_work_permit_id_to_view",
        method: "get",
        data: {
            work_permit_id: workpermitID
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            // console.log(response['startDate']);
            // console.log(response['endDate']);

            let result = response['permit_number'];
            let ohs_result = response['ohs_req'];

            let addtnl_worker_arr = result[0].contractor_id;
            let addtnl_tools_arr = result[0].contractor_id;


            // console.log (addtnl_items_arr.length);

            if(response['permit_number'][0].classification == 0){
                $("#txtClassificatiodID").val("Normal");

            } else if (response['permit_number'][0].classification == 1) {
                $("#txtClassificatiodID").val("Urgent");

            }

            var date_concut = response['startDate'] + '-' + response['endDate'];
            var start_oras = response['start_time'];
            var end_oras = response['end_time']
            var concut_oras = response['start_time'] + '-' + response['end_time'];
            var date = response['startDate'] ;

        //     var today1 = new Date();
        //     console.log(today1);
        //     var texts = "POWP";
        //     var aad = response['permit_number'][0].division;
        //     var ax = "001";
        //     var date1 = texts+'-'+aad+'-'+today1.getFullYear().toString().slice(-2)+''+(today1.getMonth()+1)+'-'+ax;

        // console.log(date1);
        // console.log(response['worker'][0].name);
        // console.log(response['resulta']);
        // console.log(response['approver'][0].permit_number);
        // console.log((response['tools'][0].quantity));

            // let workpermit = response['permit_number'];

            // if (workpermit.length > 0) {
                $("#txtpermitNumberID").val(response['permit_number'][0].permit_number);
                // $("#txtClassificatiodID").val(response['permit_number'][0].classification);
                $("#txtWorkPermitTypeID").val(response['permit_number'][0].work_permit_type);
                $("#txtPersonInCharge").val(response['permit_number'][0].person_in_charge);
                $("#txtActivityNameID").val(response['permit_number'][0].activity);
                $("#txtDescription").val(response['permit_number'][0].description);
                $("#txtContractorsCompanyNameID").val(response['permit_number'][0]['contractor_id']['company']);
                $("#txtContractorsPersonInChargeID").val(response['permit_number'][0]['contractor_person_in_charge']['name']);
                $("#txtContractorsSafetyInChargeID").val(response['permit_number'][0]['contractor_safety_officer_in_charge']['name']);
                $("#txtPmiInChargeDeparmentID").val(response['permit_number'][0].department);
                $("#txtPmiInChargeLocalnoID").val(response['permit_number'][0].local_number);
                $("#txtPmiInChargeLocationID").val(response['permit_number'][0].location);
                $("#txtProjectDurationID").val(date_concut);
                $("#txtWorkScheduleID").val(response['permit_number'][0]['work_schedule']);
                $("#txtWorkDateID").val(date);
                $("#txtStartWorkingTimeID").val(start_oras);
                $("#txtEndWorkingTimeID").val(end_oras);
                $("#txtWorkerNameID").val(response['worker'][0].name);
                $("#txtWorkerPositionID").val(response['worker'][0].position);
                $("#txtToolNameID").val(response['resulta']);
                $("#txtToolQuantityID").val(response['tools'][0].quantity);
                $("#txtOtherRequirementsID").val(response['tools'][0].other_requirements);
                $("#txtAffectedSafetyDevicesID").val(response['tools'][0].affected_safety_devices);
                $("#txtProjectInCharge").val(response['approver'][0].project_in_charge);
                $("#txtEmsManager").val(response['approver'][0]['ems_manager']['name']);
                $("#txtSafetyOfficerInCharge").val(response['approver'][0]['safety_officer_in_charge']['name']);
                $("#txtOverAllSafetyOfficer").val(response['approver'][0]['over_all_safety_officer']['name']);
                $("#txtHrdManager").val(response['approver'][0]['hrd_manager']['name']);
                // $("#ohsRequirementsCounterID").val(response['approver'][0]['counter']);

                // console.log(ohs_result[0].ohs_requirement2);

                if(ohs_result[0].ohs_requirement1 == 1){
                    $("#discussPmiEhsID").prop("checked",true);
                    // console.log('hoy lumabas ka!');
                }

                if (ohs_result[0].ohs_requirement2 == 1){
                    $("#discussApprovedOhsID").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement3 == 1){
                    $("#bringAndWearId").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement4 == 1){
                    $("#certifiedSkilledWorkersId").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement5 == 1){
                    $("#fullBodyHarnessId").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement6 == 1){
                    $("#scaffoldStrenghtId").prop("checked",true);
                }

                if(ohs_result[0].ohs_requirement7 == 1){
                    $("#scaffoldStabilityId").prop("checked",true);
                    // console.log('hoy lumabas ka!');
                }

                if (ohs_result[0].ohs_requirement8 == 1){
                    $("#strictlyNoPassageId").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement9 == 1){
                    $("#provideAppropriateBarricade").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement10 == 1){
                    $("#provideAppropriateSafetyNet").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement11 == 1){
                    $("#insulatedPpeId").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement12 == 1){
                    $("#noLiftingActivity").prop("checked",true);
                }

                if(ohs_result[0].ohs_requirement13 == 1){
                    $("#strictlyToolsId").prop("checked",true);
                    // console.log('hoy lumabas ka!');
                }

                if (ohs_result[0].ohs_requirement14 == 1){
                    $("#fireExtinguisherId").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement15 == 1){
                    $("#strictlyNoFlammableId").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement16 == 1){
                    $("#fireBlanketId").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement17 == 1){
                    $("#gasCylinderId").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement18 == 1){
                    $("#strictlyObservedBuddyId").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement19 == 1){
                    $("#conductDailyId").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement20 == 1){
                    $("#practiceSafetyFirstId").prop("checked",true);
                }

                if (ohs_result[0].ohs_requirement21 == 1){
                    $("#othersParticipateId").prop("checked",true);
                }

        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function GetSafetyOfficerInChargeApprover(cboElement){
    let result = '<option value="0" selected disabled> -- Section Safety Officer In-Charge -- </option>';
    $.ajax({
        url: 'get_safety_officer_in_charge',
        method: 'get',
        dataType: 'json',
        beforeSend: function(){
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['user_approvers'].length > 0){
                result = '<option value="0" selected disabled> -- Safety Officer In-Charge -- </option>';
                for(let index = 0; index < response['user_approvers'].length; index++){
                    result += '<option value="' + response['user_approvers'][index].rapidx_id + '">' + response['user_approvers'][index].rapidx_user_details.name + '</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);

        }
    });
}

function GetOverAllSafetyOfficer(cboElement){
    let result = '<option value="0" selected disabled> -- Section Over-all Safety In-charge -- </option>';
    $.ajax({
        url: 'get_overall_safety_officer',
        method: 'get',
        dataType: 'json',
        beforeSend: function(){
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['user_approvers'].length > 0){
                result = '<option value="0" selected disabled> -- Over-all Safety In-charge -- </option>';
                for(let index = 0; index < response['user_approvers'].length; index++){
                    result += '<option value="' + response['user_approvers'][index].rapidx_id + '">' + response['user_approvers'][index].rapidx_user_details.name + '</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}

function GetHrdManager(cboElement){
    let result = '<option value="0" selected disabled> -- Section HRD Manager -- </option>';
    $.ajax({
        url: 'get_hrd_manager',
        method: 'get',
        dataType: 'json',
        beforeSend: function(){
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['user_approvers'].length > 0){
                result = '<option value="0" selected disabled> -- HRD Manager -- </option>';
                for(let index = 0; index < response['user_approvers'].length; index++){
                    result += '<option value="' + response['user_approvers'][index].rapidx_id + '">' + response['user_approvers'][index].rapidx_user_details.name + '</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}

function GetEmsManager(cboElement){
    let result = '<option value="0" selected disabled> -- Section EMS Manager -- </option>';
    $.ajax({
        url: 'get_ems_manager',
        method: 'get',
        dataType: 'json',
        beforeSend: function(){
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['user_approvers'].length > 0){
                result = '<option value="0" selected disabled> -- EMS Manager -- </option>';
                for(let index = 0; index < response['user_approvers'].length; index++){
                    result += '<option value="' + response['user_approvers'][index].rapidx_id + '">' + response['user_approvers'][index].rapidx_user_details.name + '</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}

function GetLocalNo(cboElement)
{
    let result = '<option value="">N/A</option>';

    $.ajax({

    url: "get_local_no",
    method: "get",
    dataType: "json",

    beforeSend: function(){
        result = '<option value="0" selected disabled> -- Loading -- </option>';
        cboElement.html(result);
    },
    success: function(response){
        result = '';

        if(response['phone_dir'].length > 0){
            result = '<option value="0" selected disabled> -- Local No. -- </option>';
            for(let index = 0; index < response['phone_dir'].length; index++){
                result += '<option value="' + response['phone_dir'][index].phone_number +' - '+ response['phone_dir'][index].location + '">' + response['phone_dir'][index].assigned_user + ', '+response['phone_dir'][index].location +' (#'+response['phone_dir'][index].phone_number +') </option>';
            }
            // console.log('qweqwe');
        }
        else{
            result = '<option value="0" selected disabled> No record found </option>';
        }
        cboElement.html(result);
    // console.log(response);
    }

    });
}

function ApprovedWorkPermit(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "approved_work_permit",
        method: "post",
        data: $('#formApproveWorkPermit').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnApproveIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnApprove").prop('disabled', 'disabled');
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('Cannot Approve!');
            }else{
                if(response['result'] == 1){
                    toastr.success('Already Approved');
                }

                $("#modalApproveWorkPermit").modal('hide');
                $("#formApproveWorkPermit")[0].reset();
                dataTableWorkPermit.draw();
            }

            $("#iBtnApproveIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnApprove").removeAttr('disabled');
            $("#iBtnApproveIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnApproveIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnApprove").removeAttr('disabled');
            $("#iBtnApproveIcon").addClass('fa fa-check');
        }
    });
}

//============================== DISAPPROVE BUTTON ==============================
function DisapproveWorkPermit(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "not_clear_work_permit",
        method: "post",
        data: $('#formDisapprovedWorkPermit').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnDisapproveRemarkIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnDisapproveRemark").prop('disabled', 'disabled');
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                if(response['error']['disapprove_remarks'] === undefined){
                    $("#txtDisapproveRemarks").removeClass('is-invalid');
                    $("#txtDisapproveRemarks").attr('title', '');
                }
                else{
                    $("#txtDisapproveRemarks").addClass('is-invalid');
                    $("#txtDisapproveRemarks").attr('title', response['error']['disapprove_remarks']);
                }

                toastr.error('Cannot Approve!');
            }else{
                if(response['result'] == 1){
                    toastr.success('Disapproved');
                }

                $("#modalDisapprovedWorkPermit").modal('hide');
                $("#formDisapprovedWorkPermit")[0].reset();
                dataTableWorkPermit.draw();
            }

            $("#iBtnDisapproveRemarkIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDisapproveRemark").removeAttr('disabled');
            $("#iBtnDisapproveRemarkIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnDisapproveRemarkIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDisapproveRemark").removeAttr('disabled');
            $("#iBtnDisapproveRemarkIcon").addClass('fa fa-check');
        }
    });

}

function AddOhsRequirements(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "add_ohs_requirements",
        method: "post",
        data: $('#formViewWPRequest').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnSubmitContractorNeedIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSubmitContractorNeed").prop('disabled', 'disabled');

        },
        success: function (JsonObject) {


            if (JsonObject['validation'] == 'hasError') {
                toastr.error('Saving failed!');
                // if (JsonObject['error']['work_classification'] === undefined) {
                //     $("#workClassificationID").removeClass('is-invalid');
                //     $("#workClassificationID").attr('title', '');
                // }
                // else {
                //     $("#workClassificationID").addClass('is-invalid');
                //     $("#workClassificationID").attr('title', JsonObject['error']['work_classification']);
                // }

                // if (JsonObject['error']['start_date'] === undefined) {
                //     $("#startDateID").removeClass('is-invalid');
                //     $("#startDateID").attr('title', '');
                // }
                // else {
                //     $("#startDateID").addClass('is-invalid');
                //     $("#startDateID").attr('title', JsonObject['error']['start_date']);
                // }

                // if (JsonObject['error']['end_date'] === undefined) {
                //     $("#endDateID").removeClass('is-invalid');
                //     $("#endDateID").attr('title', '');
                // }
                // else {
                //     $("#endDateID").addClass('is-invalid');
                //     $("#endDateID").attr('title', JsonObject['error']['end_date']);
                // }

                // if (JsonObject['error']['work_time'] === undefined) {
                //     $("#workTimeID").removeClass('is-invalid');
                //     $("#workTimeID").attr('title', '');
                // }
                // else {
                //     $("#workTimeID").addClass('is-invalid');
                //     $("#workTimeID").attr('title', JsonObject['error']['work_time']);
                // }

                // if (JsonObject['error']['txtperson_in_charge'] === undefined) {
                //     $("#txtPersonInChargeID").removeClass('is-invalid');
                //     $("#txtPersonInChargeID").attr('title', '');
                // }
                // else {
                //     $("#txtPersonInChargeID").addClass('is-invalid');
                //     $("#txtPersonInChargeID").attr('title', JsonObject['error']['txtperson_in_charge']);
                // }

                // if (JsonObject['error']['txtperson_in_charge_department'] === undefined) {
                //     $("#txtPersonInChargeDepartmentID").removeClass('is-invalid');
                //     $("#txtPersonInChargeDepartmentID").attr('title', '');
                // }
                // else {
                //     $("#txtPersonInChargeDepartmentID").addClass('is-invalid');
                //     $("#txtPersonInChargeDepartmentID").attr('title', JsonObject['error']['txtperson_in_charge_department']);
                // }

                // if (JsonObject['error']['txt_activity'] === undefined) {
                //     $("#txtActivityID").removeClass('is-invalid');
                //     $("#txtActivityID").attr('title', '');
                // }
                // else {
                //     $("#txtActivityID").addClass('is-invalid');
                //     $("#txtActivityID").attr('title', JsonObject['error']['txt_activity']);
                // }

                // if (JsonObject['error']['txt_description'] === undefined) {
                //     $("#txtDescriptionID").removeClass('is-invalid');
                //     $("#txtDescriptionID").attr('title', '');
                // }
                // else {
                //     $("#txtDescriptionID").addClass('is-invalid');
                //     $("#txtDescriptionID").attr('title', JsonObject['error']['txt_description']);
                // }

                // if (JsonObject['error']['txt_localnumber'] === undefined) {
                //     $("#txtLocalnumberID").removeClass('is-invalid');
                //     $("#txtLocalnumberID").attr('title', '');
                // }
                // else {
                //     $("#txtLocalnumberID").addClass('is-invalid');
                //     $("#txtLocalnumberID").attr('title', JsonObject['error']['txt_localnumber']);
                // }

                // if (JsonObject['error']['txt_location'] === undefined) {
                //     $("#txtLocationID").removeClass('is-invalid');
                //     $("#txtLocationID").attr('title', '');
                // }
                // else {
                //     $("#txtLocationID").addClass('is-invalid');
                //     $("#txtLocationID").attr('title', JsonObject['error']['txt_location']);
                // }

                // if (JsonObject['error']['dd_contractor'] === undefined) {
                //     $("#selContractorID").removeClass('is-invalid');
                //     $("#selContractorID").attr('title', '');
                // }
                // else {
                //     $("#selContractorID").addClass('is-invalid');
                //     $("#selContractorID").attr('title', JsonObject['error']['dd_contractor']);
                // }

                // if (JsonObject['error']['dd_contractor_person_in_charge'] === undefined) {
                //     $("#contractorPersonInChargeID").removeClass('is-invalid');
                //     $("#contractorPersonInChargeID").attr('title', '');
                // }
                // else {
                //     $("#contractorPersonInChargeID").addClass('is-invalid');
                //     $("#contractorPersonInChargeID").attr('title', JsonObject['error']['dd_contractor_person_in_charge']);
                // }

                // if (JsonObject['error']['dd_contractor_safety_officer_in_charge'] === undefined) {
                //     $("#contractorSafetyOfficerInChargeID").removeClass('is-invalid');
                //     $("#contractorSafetyOfficerInChargeID").attr('title', '');
                // }
                // else {
                //     $("#contractorSafetyOfficerInChargeID").addClass('is-invalid');
                //     $("#contractorSafetyOfficerInChargeID").attr('title', JsonObject['error']['dd_contractor_safety_officer_in_charge']);
                // }


            }
            else if (JsonObject['result'] == 1) {
                dataTableWorkPermit.draw();
                $("#modalViewRequest").modal('hide');
                $("#formViewWPRequest")[0].reset();
                // $("#counterID")
                toastr.success('OHS Requirements added!');
            }
            else if (JsonObject['result'] == 0) {
                toastr.error('Saving failed!');
            }
            $("#btnSubmitContractorNeedIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitContractorNeed").removeAttr('disabled');
            $("#btnSubmitContractorNeedIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnSubmitContractorNeedIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitContractorNeed").removeAttr('disabled');
            $("#btnSubmitContractorNeedIcon").addClass('fa fa-check');
        }
    });
}


//============================== EDIT WORK PERMIT ==============================
function EditWordPermit(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "edit_ohs_work_permit",
        method: "post",
        data: $('#editWorkPermitForm').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#btnEditWorkPermitIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditWorkPermit").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Updating Approver Failed!');

                // if(response['error']['employee_no'] === undefined){
                //     $("#txtEditUserEmployeeNo").removeClass('is-invalid');
                //     $("#txtEditUserEmployeeNo").attr('title', '');
                // }
                // else{
                //     $("#txtEditUserEmployeeNo").addClass('is-invalid');
                //     $("#txtEditUserEmployeeNo").attr('title', response['error']['employee_no']);
                // }

                // if(response['error']['classification'] === undefined){
                //     $("#selectEditUserClassification").removeClass('is-invalid');
                //     $("#selectEditUserClassification").attr('title', '');
                // }
                // else{
                //     $("#selectEditUserClassification").addClass('is-invalid');
                //     $("#selectEditUserClassification").attr('title', response['error']['classification']);
                // }
            }
            else if(response['result'] == 1){
                $("#modalEditWorkPermit").modal('hide');
                $("#editWorkPermitForm")[0].reset();
                toastr.success('User was succesfully saved!');
                dataTableWorkPermit.draw(); // reload the tables after insertion
            }

            $("#btnEditWorkPermitIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditWorkPermit").removeAttr('disabled');
            $("#btnEditWorkPermitIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnEditWorkPermitIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditWorkPermit").removeAttr('disabled');
            $("#btnEditWorkPermitIcon").addClass('fa fa-check');
        }
    });
}

// ============================== DELETE WORK PERMIT==============================
function DeleteWorkPermit(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "delete_work_permit",
        method: "post",
        data: $('#deleteWorkPermitForm').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#deleteWorkPermitIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnDeleteWorkPermit").prop('disabled', 'disabled');
        },
        success: function(response){
            let result = response['result'];
            if(result == 1){
                $("#modalDeleteWorkPermit").modal('hide');
                $("#deleteWorkPermitForm")[0].reset();
                toastr.success('Work Permit successfully deleted');
                dataTableWorkPermit.draw();
            }
            else{
                toastr.warning('No Work Permit found!');
            }

            $("#deleteWorkPermitIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeleteWorkPermit").removeAttr('disabled');
            $("#deleteWorkPermitIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#deleteWorkPermitIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeleteWorkPermit").removeAttr('disabled');
            $("#deleteWorkPermitIcon").addClass('fa fa-check');
        }
    });
}

function GetWorkPermitIdToExtend(workpermitID) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "get_work_permit_id_to_extend",
        method: "get",
        data: {
            extend_work_permit_id: workpermitID
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {



            let permit_number = response['permit_number'];

                $("#prolongStartDateId").val(response['permit_number'][0]['start_date']);
                $("#prolongEndDateId").val(response['permit_number'][0]['end_date']);
                $("#prolongStartTimeId").val(response['permit_number'][0]['start_time']);
                $("#prolongEndTimeId").val(response['permit_number'][0]['end_time']);

        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

//============================== EXTEND WORK PERMIT ==============================
function ExtendWorkPermit(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "extend_work_permit",
        method: "post",
        data: $('#ExtendWorkPermitForm').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#extendWorkPermitIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnExtendWorkPermitId").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Updating Approver Failed!');

            }
            else if(response['result'] == 1){
                $("#modalExtendWorkPermit").modal('hide');
                $("#ExtendWorkPermitForm")[0].reset();
                toastr.success('Work Permit was succesfully extended!');
                dataTableWorkPermit.draw(); // reload the tables after insertion
            }

            $("#extendWorkPermitIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnExtendWorkPermitId").removeAttr('disabled');
            $("#extendWorkPermitIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#extendWorkPermitIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnExtendWorkPermitId").removeAttr('disabled');
            $("#extendWorkPermitIcon").addClass('fa fa-check');
        }
    });
}
