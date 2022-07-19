function AddContractor()
{
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

     let form_data = new FormData($('#addContractorForm')[0]);

    $.ajax({
        url: "add_contractor",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        beforeSend: function () {
            $("#btnAddContractorIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddContractor").prop('disabled', 'disabled');
        },
        success: function (JsonObject) {
            if (JsonObject['validation'] == 'hasError') {
                toastr.error('Saving failed!');
                if (JsonObject['error']['contractor_company'] === undefined) {
                    $("#contractorNameId").removeClass('is-invalid');
                    $("#contractorNameId").attr('title', '');
                }
                else {
                    $("#contractorNameId").addClass('is-invalid');
                    $("#contractorNameId").attr('title', JsonObject['error']['contractor_company']);
                }
            }
            else if (JsonObject['result'] == 1) {
                $("#modalAddContractor").modal('hide');
                $("#addContractorForm")[0].reset();
                toastr.success('Contractor added!');
                dataTableContractors.draw();
            }
            else if (JsonObject['result'] == 0) {
                toastr.error('Saving failed!');
            }
            $("#btnAddContractorIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddContractor").removeAttr('disabled');
            $("#btnAddContractorIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnAddContractorIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddContractor").removeAttr('disabled');
            $("#btnAddContractorIcon").addClass('fa fa-check');
        }
    });
}

//============================== EDIT USER ==============================
function EditContractor(){
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

    let form_data = new FormData($('#EditContractor')[0]);

    $.ajax({
        url: "edit_contractor",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        beforeSend: function(){
            $("#iBtnEditContractorIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditContractor").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Updating Contractor Failed!');

                if(response['error']['contractor_name'] === undefined){
                    $("#txtEditCCompany").removeClass('is-invalid');
                    $("#txtEditCCompany").attr('title', '');
                }
                else{
                    $("#txtEditCCompany").addClass('is-invalid');
                    $("#txtEditCCompany").attr('title', response['error']['contractor_name']);
                }
                if(response['error']['edit_esignature'] === undefined){
                    $("#EditESignature").removeClass('is-invalid');
                    $("#EditESignature").attr('title', '');
                }
                else{
                    $("#EditESignature").addClass('is-invalid');
                    $("#EditESignature").attr('title', response['error']['edit_esignature']);
                }

            }else{
                let result = response['result'];
                if(result == 1){
                    $("#modalEditContractor").modal('hide');
                    $("#EditContractor")[0].reset();
                    dataTableContractors.draw();
                    toastr.success('User was succesfully updated!');
                }else{
                    toastr.warning(response['tryCatchError'] + "<br>" +
                    'Try Catch Error');
                }
            }

            $("#iBtnEditContractorIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditContractor").removeAttr('disabled');
            $("#iBtnEditContractorIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnEditContractorIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditContractor").removeAttr('disabled');
            $("#iBtnEditContractorIcon").addClass('fa fa-check');
        }
    });
}


function DeactivateContractor() {
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
        url: "deactivate_contractor",
        method: "post",
        data: $('#deactivateContractor').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#deactivateIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateContractor").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                dataTableContractors.draw();
                $("#modalDeactivateContractor").modal('hide');
                $("#deactivateContractor")[0].reset();
                toastr.success('Contractor successfully deactivated!');
            }
            else {
                toastr.warning('Contractor already deactivated!');
            }

            $("#deactivateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateContractor").removeAttr('disabled');
            $("#deactivateIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#deactivateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateContractor").removeAttr('disabled');
            $("#deactivateIcon").addClass('fa fa-check');
        }
    });
}

function ActivateContractor() {
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
        url: "activate_contractor",
        method: "post",
        data: $('#activateContractor').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#activateIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnActivateContractor").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                $("#modalActivateContractor").modal('hide');
                $("#activateContractor")[0].reset();
                toastr.success('Contractor successfully activated!');
                dataTableContractors.draw();
            }
            else {
                toastr.warning('Contractor already deactivated!');
            }

            $("#activateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnActivateContractor").removeAttr('disabled');
            $("#activateIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#activateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnActivateContractor").removeAttr('disabled');
            $("#activateIcon").addClass('fa fa-check');
        }
    });
}

function GetContractorByIdToEdit(contractorId) {
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
        url: "get_id_edit_contractor",
        method: "get",
        data: {
            contractor_id: contractorId
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            let contractor = response['contractor_name'];
            if (contractor.length > 0) {
                $("#txtEditCCompany").val(contractor[0].company);

            }
            else {
                toastr.warning('No Record Found!');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function GetContractor(cboElement) {
    let result = '<option value="0" selected disabled> -- Select Contractor -- </option>';
    $.ajax({
        url: 'get_contractor',
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

//CONTRACTOR CONTACT MANAGEMENT TAB

function AddContractorContact(){
    // console.log($('#addContractorContactForm').serialize());

    $.ajax({
        url: "add_contractor_contact",
        method: "post",
        data: $('#addContractorContactForm').serialize(),
        dataType: "json",
        beforeSend: function () {

        },
        success: function (JsonObject) {
            if (JsonObject['validation'] == 'hasError') {
                toastr.error('Saving failed!');
                if (JsonObject['error']['contractor_name'] === undefined) {
                    $("#contractor_nameID").removeClass('is-invalid');
                    $("#contractor_nameID").attr('title', '');
                }
                else {
                    $("#contractor_nameID").addClass('is-invalid');
                    $("#contractor_nameID").attr('title', JsonObject['error']['contractor_name']);
                }

                if (JsonObject['error']['contractor'] === undefined) {
                    $("#selContractor").removeClass('is-invalid');
                    $("#selContractor").attr('title', '');
                }
                else {
                    $("#selContractor").addClass('is-invalid');
                    $("#selContractor").attr('title', JsonObject['error']['contractor']);
                }

                if (JsonObject['error']['contractor_email'] === undefined) {
                    $("#contractor_emailID").removeClass('is-invalid');
                    $("#contractor_emailID").attr('title', '');
                }
                else {
                    $("#contractor_emailID").addClass('is-invalid');
                    $("#contractor_emailID").attr('title', JsonObject['error']['contractor_email']);
                }

                if (JsonObject['error']['Classification'] === undefined) {
                    $("#Class").removeClass('is-invalid');
                    $("#Class").attr('title', '');
                }
                else {
                    $("#Class").addClass('is-invalid');
                    $("#Class").attr('title', JsonObject['error']['Classification']);
                }
            }
            else if (JsonObject['result'] == 1) {
                dataTableContractorsContact.draw();
                $("#modalAddContractorContact").modal('hide');
                $("#addContractorContactForm")[0].reset();
                toastr.success('Contractor Contact added!');
            }
            else if (JsonObject['result'] == 0) {
                toastr.error('Saving failed!');
            }
            $("#btnAddContactIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddContact").removeAttr('disabled');
            $("#btnAddContactIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnAddContactIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddContact").removeAttr('disabled');
            $("#btnAddContactIcon").addClass('fa fa-check');
        }
    });
}

//============================== EDIT CONTRACTOR CONTACT ==============================
function DeactivateContractorContact() {
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
        url: "deactivate_contractor_contact",
        method: "post",
        data: $('#deactivateContact').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#deactivateContactIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateContact").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                dataTableContractorsContact.draw();
                $("#modalDeactivateContact").modal('hide');
                $("#deactivateContact")[0].reset();
                toastr.success('Contractor successfully deactivated!');
            }
            else {
                toastr.warning('Contractor already deactivated!');
            }

            $("#deactivateContactIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateContact").removeAttr('disabled');
            $("#deactivateContactIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#deactivateContactIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateContact").removeAttr('disabled');
            $("#deactivateContactIcon").addClass('fa fa-check');
        }
    });
}

function ActivateContractorContact() {
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
        url: "activate_contractor_contact",
        method: "post",
        data: $('#activateContact').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#activateContactIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnActivateContact").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                dataTableContractorsContact.draw();
                $("#modalActivateContact").modal('hide');
                $("#activateContact")[0].reset();
                toastr.success('Contractor successfully activated!');
            }
            else {
                toastr.warning('Contractor already deactivated!');
            }

            $("#activateContactIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnActivateContact").removeAttr('disabled');
            $("#activateContactIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#activateContactIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnActivateContact").removeAttr('disabled');
            $("#activateContactIcon").addClass('fa fa-check');
        }
    });
}

function GetContractorContactIdToEdit(contactId) {
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
        url: "get_id_edit_contractor_contact",
        method: "get",
        data: {
            contact_id: contactId
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            let contractor = response['contractor_contact_name'];
            if (contractor.length > 0) {
                $("#txtEditContractorContact").val(contractor[0].name);
                $("#txtEditContractorEmail").val(contractor[0].email);
                $("#txtEditClassification").val(contractor[0].classification);
            }
            else {
                toastr.warning('No Record Found!');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function EditContractorContact(){
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

    let form_data = new FormData($('#EditContractorContact')[0]);

    $.ajax({
        url: "edit_contractor_contact",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        beforeSend: function(){
            $("#iBtnEditContractorContactIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditContractorContact").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Updating Contractor Failed!');

                if(response['error']['contractor_name'] === undefined){
                    $("#txtEditContractorContact").removeClass('is-invalid');
                    $("#txtEditContractorContact").attr('title', '');
                }
                else{
                    $("#txtEditContractorContact").addClass('is-invalid');
                    $("#txtEditContractorContact").attr('title', response['error']['contractor_contact_name']);
                }

                if(response['error']['contractor_name'] === undefined){
                    $("#txtEditContractorEmail").removeClass('is-invalid');
                    $("#txtEditContractorEmail").attr('title', '');
                }
                else{
                    $("#txtEditContractorEmail").addClass('is-invalid');
                    $("#txtEditContractorEmail").attr('title', response['error']['contractor_contact_email']);
                }

                if(response['error']['contractor_name'] === undefined){
                    $("#txtEditClassification").removeClass('is-invalid');
                    $("#txtEditClassification").attr('title', '');
                }
                else{
                    $("#txtEditClassification").addClass('is-invalid');
                    $("#txtEditClassification").attr('title', response['error']['Contact_Classification']);
                }


            }else{
                let result = response['result'];
                if(result == 1){
                    dataTableContractorsContact.draw();
                    $("#modalEditContractorContact").modal('hide');
                    $("#EditContractorContact")[0].reset();
                    toastr.success('User was succesfully updated!');
                }else{
                    toastr.warning(response['tryCatchError'] + "<br>" +
                    'Try Catch Error');
                }
            }

            $("#iBtnEditContractorContactIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditContractorContact").removeAttr('disabled');
            $("#iBtnEditContractorContactIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnEditContractorContactIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditContractorContact").removeAttr('disabled');
            $("#iBtnEditContractorContactIcon").addClass('fa fa-check');
        }
    });
}






