@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i
                                    class="f-16 fa fa-home"></i></a></li>
                        <li class="breadcrumb-item">Settings</li>
                        <li class="breadcrumb-item"><a href="{{url('/')}}/admin/settings/chat-suggestions/"
                                                       data-original-title="" title="">{{$PageTitle}}</a></li>
                        <li class="breadcrumb-item">{{ $isEdit ? 'Update' : 'Create' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-sm-12 col-lg-6">
                <div class="card">
                    <div class="card-header text-center"><h5 class="mt-10">{{ $PageTitle }}</h5></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 mt-20">
                                <div class="form-group">
                                    <label class="txtQuestion">Question<span class="required"> * </span></label>
                                    <input type="text" class="form-control  {{ $Theme['input-size'] }}" id="txtQuestion"
                                           value="{{ old('txtQuestion', $isEdit ? $EditData[0]->Question ?? '' : '')  }}">
                                    <div class="errors" id="txtQuestion-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-20">
                                <div class="form-group">
                                    <label class="txtAnswer">Answer<span class="required"> * </span></label>
                                    <div id="editor">{!! $isEdit ? ($EditData[0]->Answer ?? '') : '' !!}</div>
                                    <div class="errors" id="txtAnswer-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-20">
                                <div class="form-group">
                                    <label class="lstActiveStatus">Active Status</label>
                                    <select class="form-control {{ $Theme['input-size'] }}" id="lstActiveStatus">
                                        <option value="Active"
                                                @if($isEdit) @if($EditData[0]->ActiveStatus==="Active") selected @endif @endif >
                                            Active
                                        </option>
                                        <option value="Inactive"
                                                @if($isEdit) @if($EditData[0]->ActiveStatus==="Inactive") selected @endif @endif>
                                            Inactive
                                        </option>
                                    </select>
                                    <div class="errors" id="lstActiveStatus-err"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-20">
                            <div class="col-sm-12 text-right">
                                @if($crud['view'])
                                    <a href="{{url('/')}}/admin/settings/chat-suggestions"
                                       class="btn {{ $Theme['button-size'] }} btn-outline-dark mr-10"
                                       id="btnCancel">Back</a>
                                @endif
                                @if((($crud['add']) && (!$isEdit)) || (($crud['edit']) && ($isEdit)))
                                    <button class="btn {{ $Theme['button-size'] }} btn-outline-success"
                                            id="btnSave">@if($isEdit)
                                            Update
                                        @else
                                            Save
                                        @endif</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            initCKEditor();
            const formValidation = () => {
                $('.errors').html('');
                let status = true;
                let Question = $('#txtQuestion').val();
                let Answer = CKEDITOR.instances.editor.getData();
                if (Question === "") {
                    $('#txtQuestion-err').html('Question is required.');
                    status = false;
                } else if (Question.length < 3) {
                    $('#txtQuestion-err').html('Question must be greater than 3 characters');
                    status = false;
                } else if (Question.length > 100) {
                    $('#txtQuestion-err').html('Question may not be greater than 100 characters');
                    status = false;
                }
                if (Answer === "") {
                    $('#txtAnswer-err').html('Answer is required.');
                    status = false;
                } else if (Answer.length < 3) {
                    $('#txtAnswer-err').html('Answer must be greater than 3 characters');
                    status = false;
                }
                if (status === false) {
                    $("html, body").animate({scrollTop: 0}, "slow");
                }
                return status;
            }

            $('#btnSave').click(function () {
                let status = formValidation();
                if (status) {
                    swal({
                        title: "Are you sure?",
                        text: "You want @if($isEdit)Update @else Save @endif this Question!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-outline-success",
                        confirmButtonText: "Yes, @if($isEdit)Update @else Save @endif it!",
                        closeOnConfirm: false
                    }, function () {
                        swal.close();
                        btnLoading($('#btnSave'));
                        let postUrl = @if($isEdit) "{{ url('/') }}/admin/settings/chat-suggestions/edit/{{ $EditData[0]->CSID }}";
                        @else "{{url('/')}}/admin/settings/chat-suggestions/create"; @endif
                        let formData = new FormData();
                        formData.append('Question', $('#txtQuestion').val());
                        formData.append('Answer', CKEDITOR.instances.editor.getData());
                        formData.append('ActiveStatus', $('#lstActiveStatus').val());
                        $.ajax({
                            type: "post",
                            url: postUrl,
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
                                    }
                                }, false);
                                return xhr;
                            },
                            beforeSend: function () {
                                ajaxIndicatorStart("Please wait Upload Process on going.");
                                var percentVal = '0%';
                                setTimeout(() => {
                                    $('#divProcessText').html(percentVal + ' Completed.<br> Please wait for until upload process complete.');
                                }, 100);
                            },
                            error: function (e, x, settings, exception) {
                                ajaxErrors(e, x, settings, exception);
                            },
                            complete: function (e, x, settings, exception) {
                                btnReset($('#btnSave'));
                                ajaxIndicatorStop();
                                $("html, body").animate({scrollTop: 0}, "slow");
                            },
                            success: function (response) {
                                document.documentElement.scrollTop = 0;
                                if (response.status === true) {
                                    swal({
                                        title: "SUCCESS",
                                        text: response.message,
                                        type: "success",
                                        showCancelButton: false,
                                        confirmButtonClass: "btn-outline-success",
                                        confirmButtonText: "Okay",
                                        closeOnConfirm: false
                                    }, function () {
                                        @if($isEdit)
                                        window.location.replace("{{url('/')}}/admin/settings/chat-suggestions");
                                        @else
                                        window.location.reload();
                                        @endif

                                    });
                                } else {
                                    toastr.error(response.message, "Failed", {
                                        positionClass: "toast-top-right",
                                        containerId: "toast-top-right",
                                        showMethod: "slideDown",
                                        hideMethod: "slideUp",
                                        progressBar: !0
                                    })
                                    if (response['errors'] !== undefined) {
                                        $('.errors').html('');
                                        $.each(response['errors'], function (KeyName, KeyValue) {
                                            if (KeyName === "Question") {
                                                $('#txtQuestion-err').html(KeyValue);
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    });
                }
            });
        });
    </script>
@endsection
