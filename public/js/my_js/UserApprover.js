//============================== ADD USER ==============================
function AddUserApprover(){
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
        url: "add_user_approver",
        method: "post",
        data: $('#formAddUserApprover').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnAddUserApproverIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddUserApprover").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Saving User Failed!');

                if(response['error']['employee_no'] === undefined){
                    $("#txtAddUserEmployeeNo").removeClass('is-invalid');
                    $("#txtAddUserEmployeeNo").attr('title', '');
                }
                else{
                    $("#txtAddUserEmployeeNo").addClass('is-invalid');
                    $("#txtAddUserEmployeeNo").attr('title', response['error']['employee_no']);
                }

                if(response['error']['classification'] === undefined){
                    $("#selectAddUserClassification").removeClass('is-invalid');
                    $("#selectAddUserClassification").attr('title', '');
                }
                else{
                    $("#selectAddUserClassification").addClass('is-invalid');
                    $("#selectAddUserClassification").attr('title', response['error']['classification']);
                }
            }
            else if(response['result'] == 1){
                $("#modalAddUserApprover").modal('hide');
                $("#formAddUserApprover")[0].reset();
                toastr.success('User was succesfully saved!');
                dataTableUserApprover.draw(); // reload the tables after insertion
            }

            $("#iBtnAddUserApproverIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddUserApprover").removeAttr('disabled');
            $("#iBtnAddUserApproverIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnAddUserApproverIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddUserApprover").removeAttr('disabled');
            $("#iBtnAddUserApproverIcon").addClass('fa fa-check');
        }
    });
}


//============================== EDIT USER BY ID TO EDIT ==============================
function GetApproverById(approverID){
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
        url: "get_approver_by_id",
        method: "get",
        data: {
            approver_id: approverID
        },
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            let user = response['user'];
            if(user.length > 0){
                $("#txtEditUserEmployeeNo").val(user[0].employee_no);
                $(".selectUser").val(user[0].rapidx_user_details.id).trigger("change");
                // console.log(user[0].classification);
                $("#selectEditUserClassification").val(user[0].classification).trigger('change');
            }
            else{
                toastr.warning('No User Record Found!');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

//============================== EDIT USER ==============================
function EditApprover(){
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
        url: "edit_approver",
        method: "post",
        data: $('#EditApprover').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnEditApproverIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditApprover").prop('disabled', 'disabled');
        },
        success: function(response){


            if(response['validation'] == 'hasError'){
                toastr.error('Updating Approver Failed!');

                if(response['error']['employee_no'] === undefined){
                    $("#txtEditUserEmployeeNo").removeClass('is-invalid');
                    $("#txtEditUserEmployeeNo").attr('title', '');
                }
                else{
                    $("#txtEditUserEmployeeNo").addClass('is-invalid');
                    $("#txtEditUserEmployeeNo").attr('title', response['error']['employee_no']);
                }

                if(response['error']['classification'] === undefined){
                    $("#selectEditUserClassification").removeClass('is-invalid');
                    $("#selectEditUserClassification").attr('title', '');
                }
                else{
                    $("#selectEditUserClassification").addClass('is-invalid');
                    $("#selectEditUserClassification").attr('title', response['error']['classification']);
                }
            }
            else if(response['result'] == 1){
                $("#modalEditApprover").modal('hide');
                $("#EditApprover")[0].reset();
                toastr.success('User was succesfully saved!');
                dataTableUserApprover.draw(); // reload the tables after insertion
            }

            $("#iBtnEditApproverIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditApprover").removeAttr('disabled');
            $("#iBtnEditApproverIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnEditApproverIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditApprover").removeAttr('disabled');
            $("#iBtnEditApproverIcon").addClass('fa fa-check');
        }
    });
}


//============================== SELECT USER APPROVER ( RAPIDX ) ==============================
function LoadRapidXUserList(cboElement)
{
    let result = '<option value="">N/A</option>';

    $.ajax({

    url: "load_rapidx_user_list",
    method: "get",
    dataType: "json",
    beforeSend: function(){
            result = '<option value=""> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(JsonObject){
            result = '';
            if(JsonObject['users'].length > 0){
                result = '<option selected disabled>-- Select User Approver -- </option>';
                for(let index = 0; index < JsonObject['users'].length; index++){
                    let disabled = '';

                    if(JsonObject['users'][index].status == 2){
                        disabled = 'disabled';
                    }
                    else{
                        disabled = '';
                    }
                    result += '<option data-code="' + JsonObject['users'][index].employee_id + '" value="' + JsonObject['users'][index].id + '" ' + disabled + '>' + JsonObject['users'][index].name + '</option>';
                }
            }
            else{
                result = '<option value=""> -- No record found -- </option>';
            }

            cboElement.html(result);
        },
        error: function(data, xhr, status){
            result = '<option value=""> -- Reload Again -- </option>';
            cboElement.html(result);
            toastr.error('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }

    });
}

function DeactivateApprover() {
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
        url: "deactivate_approver",
        method: "post",
        data: $('#deactivateApprover').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#deactivateApproverIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateApprover").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                dataTableUserApprover.draw();
                $("#modalDeactivateApprover").modal('hide');
                $("#deactivateApprover")[0].reset();
                toastr.success('Approver successfully deactivated!');
            }
            else {
                toastr.warning('Approver already deactivated!');
            }

            $("#deactivateApproverIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateApprover").removeAttr('disabled');
            $("#deactivateApproverIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#deactivateApproverIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateApprover").removeAttr('disabled');
            $("#deactivateApproverIcon").addClass('fa fa-check');
        }
    });
}

function ActivateApprover() {
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
        url: "activate_approver",
        method: "post",
        data: $('#activateApprover').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#activateApproverIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnActivateApprover").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                $("#modalActivateApprover").modal('hide');
                $("#activateApprover")[0].reset();
                toastr.success('Approver successfully activated!');
                dataTableUserApprover.draw();
            }
            else {
                toastr.warning('Approver already deactivated!');
            }

            $("#activateApproverIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnActivateApprover").removeAttr('disabled');
            $("#activateApproverIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#activateApproverIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnActivateApprover").removeAttr('disabled');
            $("#activateApproverIcon").addClass('fa fa-check');
        }
    });
}


