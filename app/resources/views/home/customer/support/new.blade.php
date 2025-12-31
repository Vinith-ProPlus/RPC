<div class="row">
    <div class="col-sm-3">
        <div class="form-group d-none">
            <label for="lstTicketFor">Ticket For <span class="required">*</span></label>
            <select class="form-control" id="lstTicketFor">
                {{--                <option value="Vendor">Vendor</option>--}}
                <option value="Customer" selected>Customer</option>
            </select>
            {{--            <span class="errors MTicket err-sm" id="lstTicketFor-err"></span>--}}
        </div>
    </div>
    <div class="col-sm-3 d-none" id="divCustomer">
        <div class="form-group">
            <label for="lstCustomer">Customer <span class="required">*</span></label>
            <select class="form-control mSelect2" id="lstCustomer">
                <option value="">Select a Customer</option>
                @foreach($Customers as $data)
                    <option
                        value="{{$data->UserID}}" {{ ($UInfo->UserID == $data->UserID) ? 'selected' : '' }}>{{$data->Name}}
                        ( {{$data->MobileNumber}} )
                    </option>
                @endforeach
            </select>
            {{--            <span class="errors MTicket err-sm" id="lstCustomer-err"></span>--}}
        </div>
    </div>
    <div class="col-sm-3 d-none" id="divVendor">
        <div class="form-group">
            <label for="lstVendor">Vendor <span class="required">*</span></label>
            <select class="form-control mSelect2" id="lstVendor">
                <option value="">Select a Vendor</option>
                @foreach($Vendors as $data)
                    <option value="{{$data->UserID}}">{{$data->Name}} ( {{$data->MobileNumber}} )</option>
                @endforeach
            </select>
            {{--            <span class="errors MTicket err-sm" id="lstVendor-err"></span>--}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="lstSupportType">Support Type <span class="required">*</span></label>
            <select class="form-control" id="lstSupportType">
                <option value="">Select a Support Type</option>
                @foreach($SupportType as $data)
                    <option value="{{$data->SLNO}}">{{$data->SupportType}}</option>
                @endforeach
            </select>
            <span class="errors MTicket err-sm" id="lstSupportType-err"></span>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="lstPriority">Priority <span class="required">*</span></label>
            <select class="form-control" id="lstPriority">
                <option value="low" selected>Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
            <span class="errors MTicket err-sm" id="lstPriority-err"></span>
        </div>
    </div>
    <div class="col-sm-12 my-2">
        <div class="form-group">
            <label for="txtSubject">Subject <span class="required">*</span></label>
            <input type="text" id="txtSubject" class="form-control" placeholder="Subject  must be 3-100 characters">
            <span class="errors MTicket err-sm" id="txtSubject-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="txtDescription">Description <span class="required">*</span></label>
            <textarea class="form-control" id="txtDescription" rows=5></textarea>
            <span class="errors MTicket err-sm" id="txtDescription-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3 my-2">Attachments</div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <input type="file" id="imgAttachment1" class="dropify Attachments" data-default-file=""
                   data-max-file-size="20M" data-allowed-file-extensions='jpeg jpg png gif webp bmp pdf'/><span
                class="errors" id="imgAttachment1-err"></span>
            <span class="errors" id="imgAttachment1-err"></span>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <input type="file" id="imgAttachment2" class="dropify Attachments" data-default-file=""
                   data-max-file-size="20M" data-allowed-file-extensions='jpeg jpg png gif webp bmp pdf'/><span
                class="errors" id="imgAttachment2-err"></span>
            <span class="errors" id="imgAttachment2-err"></span>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <input type="file" id="imgAttachment3" class="dropify Attachments" data-default-file=""
                   data-max-file-size="20M" data-allowed-file-extensions='jpeg jpg png gif webp bmp pdf'/><span
                class="errors" id="imgAttachment3-err"></span>
            <span class="errors" id="imgAttachment3-err"></span>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <input type="file" id="imgAttachment4" class="dropify Attachments" data-default-file=""
                   data-max-file-size="20M" data-allowed-file-extensions='jpeg jpg png gif webp bmp pdf'/><span
                class="errors" id="imgAttachment4-err"></span>
            <span class="errors" id="imgAttachment4-err"></span>
        </div>
    </div>
</div>

<div class="row mt-20 mb-20">
    <div class="col-sm-12 text-right">
        <button id="btnCloseModal" type="button" class="btn btn-outline-dark btn-sm mr-1">Cancel</button>
        <button id="{{$SaveButtonID}}" type="button" class="btn btn-outline-success btn-sm btn-success-air">Submit
        </button>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.mSelect2').select2({
            dropdownParent: $('.bootbox-body')
        });

        let blnprocess = false;
        $('.Attachments').dropify();
        $(document).on('click', '#btnCloseModal', function () {
            bootbox.hideAll();
        });
        const formValidation = async () => {

            $('.errors.MTicket').html("");
            let status = true;
            let UserID = "";

            UserID = $("#lstCustomer").val();
            if (!UserID) {
                $('#lstCustomer-err').html('Customer Name is required');
                status = false;
            }

            let Subject = $('#txtSubject').val();
            let SupportType = $('#lstSupportType').val();
            let Description = $('#txtDescription').val();
            if (Subject == "") {
                $('#txtSubject-err').html('Subject is required');
                status = false;
            } else if (Subject.length < 3) {
                $('#txtSubject-err').html('Subject must be at least 3 characters');
                status = false;
            } else if (Subject.length > 100) {
                $('#txtSubject-err').html('Subject may not be greater than 100 characters');
                status = false;
            }
            if (SupportType == "") {
                $('#lstSupportType-err').html('Support Type is required');
                status = false;
            }
            if (Description == "") {
                $('#txtDescription-err').html('Description is required');
                status = false;
            } else if (Description.length < 3) {
                $('#txtDescription-err').html('Description must be at least 3 characters');
                status = false;
            }
            return status;
        }
        $(document).on('click', '#{{$SaveButtonID}}', async () => {
            let status = await formValidation();
            let TicketFor = $("#lstTicketFor").val();
            if ((status == true) && (blnprocess == false)) {
                blnprocess = true;
                btnLoading($('#btnSubmitSupport'));
                let formData = new FormData();
                formData.append('UserID', TicketFor == "Vendor" ? $('#lstVendor').val() : $('#lstCustomer').val());
                formData.append('TicketFor', $('#lstTicketFor').val());
                formData.append('Priority', $('#lstPriority').val());
                formData.append('SupportType', $('#lstSupportType').val());
                formData.append('Subject', $('#txtSubject').val().split("'").join("").split('"').join(""));
                formData.append('Description', $('#txtDescription').val().split("'").join("").split('"').join(""));
                if ($('#imgAttachment1').val() != "") {
                    formData.append('Attachment1', $('#imgAttachment1')[0].files[0]);
                }
                if ($('#imgAttachment2').val() != "") {
                    formData.append('Attachment2', $('#imgAttachment2')[0].files[0]);
                }
                if ($('#imgAttachment3').val() != "") {
                    formData.append('Attachment3', $('#imgAttachment3')[0].files[0]);
                }
                if ($('#imgAttachment4').val() != "") {
                    formData.append('Attachment4', $('#imgAttachment4')[0].files[0]);
                }
                $.ajax({
                    type: "post",
                    url: "{{url('/')}}/customer/support/new-ticket/save",
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                percentComplete = parseFloat(percentComplete).toFixed(2);
                                $('#divProcessText').html(percentComplete + '% Completed.<br> Please wait for until upload process complete.');
                                //Do something with upload progress here
                            }
                        }, false);
                        return xhr;
                    },
                    beforeSend: function () {
                        btnLoading($('#btnSubmit'));
                        ajaxIndicatorStart("Please wait Upload Process on going.");

                        var percentVal = '0%';
                        setTimeout(() => {
                            $('#divProcessText').html(percentVal + ' Completed.<br> Please wait for until upload process complete.');
                        }, 100);
                    },
                    error: function (e, x, settings, exception) {
                        blnProcessing = false;
                        ajaxErrors(e, x, settings, exception);
                    },
                    complete: function (e, x, settings, exception) {
                        blnprocess = false;
                        ajaxIndicatorStop();
                        btnReset($('#btnSubmitSupport'));
                    },
                    success: function (response) {
                        if (response.status == true) {
                            $('#support-tab').click();
                            toastr.success(response.message, "Success", {
                                positionClass: "toast-top-right",
                                containerId: "toast-top-right",
                                showMethod: "slideDown",
                                hideMethod: "slideUp",
                                // progressBar: !0
                            })
                            bootbox.hideAll();
                        } else {
                            if (response['errors'] != undefined) {
                                $('.errors').html('');
                                $.each(response['errors'], function (KeyName, KeyValue) {
                                    var key = KeyName;
                                    if (key == "UserID") {
                                        $('#lstCustomer-err').html(KeyValue);
                                    }
                                    if (key == "Subject") {
                                        $('#txtSubject-err').html(KeyValue);
                                    }
                                    if (key == "Priority") {
                                        $('#lstPriority-err').html(KeyValue);
                                    }
                                    if (key == "SupportType") {
                                        $('#lstSupportType-err').html(KeyValue);
                                    }
                                    if (key == "Description") {
                                        $('#txtDescription-err').html(KeyValue);
                                    }
                                    if (key == "Attachment1") {
                                        $('#imgAttachment1-err').html(KeyValue);
                                    }
                                    if (key == "Attachment2") {
                                        $('#imgAttachment2-err').html(KeyValue);
                                    }
                                    if (key == "Attachment3") {
                                        $('#imgAttachment3-err').html(KeyValue);
                                    }
                                    if (key == "Attachment4") {
                                        $('#imgAttachment4-err').html(KeyValue);
                                    }
                                });
                            }
                            toastr.error(response.message, "Failed", {
                                positionClass: "toast-top-right",
                                containerId: "toast-top-right",
                                showMethod: "slideDown",
                                hideMethod: "slideUp",
                                // progressBar: !0
                            })
                        }
                    }
                });
            }
        });
    });
</script>
