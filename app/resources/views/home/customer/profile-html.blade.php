<style>
    .select2-container--default .select2-selection--multiple
    {
        border: solid black 1px !important;
        outline: 0;
        background-color: white !important;
        border: 1px solid #dfdfdf !important;
        border-radius: 0px !important;
        cursor: text;
    }
    .select2-search__field {
        min-height: 35px !important; /* Adjust the font size as needed */
        padding: .375rem .75rem !important;
        padding-left: 0.75rem !important;
        padding-left: 0.75rem !important;
        font-size: 1.2rem !important;
        font-weight: 400 !important;
    }
</style>
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header text-center profilePageTitle"><h4 class="m-0">@if($isEdit) Profile @else Registration Form @endif</h4></div>
                <div class="card-body " >
                    <div class="row customerRegister">
                        <div class="col-sm-12">
                            <div class="row mb-3 d-flex justify-content-center">
                                {{-- <div class="col-sm-4">
                                    <input type="file" class="dropify imageScrop" data-aspect-ratio="1" data-remove="0" data-is-cover-image="1" id="txtCustomerImage" data-default-file="@if($UserData->ProfileImage){{$UserData->ProfileImage}}@endif">
                                    <div class="errors" id="txtCustomerImage-err"></div>
                                </div> --}}
                                <div class="col-sm-4 d-flex justify-content-center">
                                    <div style="position: relative; display: inline-block;">
                                        <img src="@if($isEdit){{$EditData->CustomerImage}} @elseif($UserData->ProfileImage){{$UserData->ProfileImage}}@endif" alt="" class="rounded-circle border border-secondary" height="200px" width="200px">
                                        <input type="file" class="imageScrop d-none" data-aspect-ratio="1" data-remove="0" data-is-cover-image="1" id="txtCustomerImage">
                                        <button id="btnEditImage" class="btn btn-sm btn-warning rounded-circle">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txtCustomerName">Customer Name <span class="required">*</span></label>
                                        <input type="text" id="txtCustomerName" class="form-control " placeholder="Customer Name" value="@if($isEdit){{$EditData->CustomerName}} @elseif($UserData->Name){{$UserData->Name}}@endif">
                                        <span class="errors Customer err-sm" id="txtCustomerName-err"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txtEmail">Email <span class="required">*</span></label>
                                        <input type="text" disabled id="txtEmail" class="form-control " placeholder="Email"  value="@if($isEdit){{$EditData->Email}} @elseif($UserData->EMail){{$UserData->EMail}}@endif">
                                        <span class="errors Customer err-sm" id="txtEmail-err"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="txtMobileNo1">Mobile Number <span class="required">*</span></label>
                                        <input type="text" id="txtMobileNo1" class="form-control " placeholder="Mobile Number"  value="@if($isEdit){{$EditData->MobileNo1}}@endif">
                                        <span class="errors Customer err-sm" id="txtMobileNo1-err"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="txtMobileNo2">Alternate Mobile Number </label>
                                        <input type="text" id="txtMobileNo2" class="form-control " placeholder="Alternate Mobile Number"  value="@if($isEdit){{$EditData->MobileNo2}}@endif">
                                        <span class="errors Customer err-sm" id="txtMobileNo2-err"></span>
                                    </div>
                                </div>
                                 <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstGender">Gender <span class="required">*</span></label>
                                        <select class="form-control" id="lstGender" data-selected="{{ $isEdit ? $EditData->GenderID : '' }}">
                                            <option value="">Select Gender</option>
                                        </select>
                                        <span class="errors Customer err-sm" id="lstGender-err"></span>
                                    </div>
                                </div>
                                 <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="txtDOB">DOB <span class="required">*</span></label>
                                        <input type="date" id="txtDOB" class="form-control " placeholder="Select DOB" value="{{ $isEdit ? ($EditData->DOB ?? '') : '' }}">
                                        <span class="errors Customer err-sm" id="txtDOB-err"></span>
                                    </div>
                                </div>
                                 <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstCusType">Customer Type <span class="required">*</span></label>
                                        <select class="form-control" id="lstCusType" data-selected="{{ $isEdit ? ($EditData->CusTypeID ?? '') : '' }}">
                                            <option value="">Select a Customer Type</option>
                                        </select>
                                        <span class="errors Customer err-sm" id="lstCusType-err"></span>
                                    </div>
                                </div>
                                 <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstConTypeIDs">Construction Type <span class="required">*</span></label>
                                        <select class="form-control" id="lstConTypeIDs" data-selected="{{ $isEdit ? ($EditData->ConTypeIDs ?? '') : '' }}">
                                            <option value="">Select a Construction Type</option>
                                        </select>
                                        <span class="errors Customer err-sm" id="lstConTypeIDs-err"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-20">
                                    <label for="txtAddress">Billing Address <span class="required">*</span></label>
                                    <textarea  id="txtAddress" class="form-control">@if($isEdit){{$EditData->Address}}@endif</textarea>
                                    <span class="errors BA err-sm" id="txtAddress-err"></span>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="txtPostalCode">Postal Code <span class="required">*</span></label>
                                        <div class="input-group">
                                            <input type="text" id="txtPostalCode" class="form-control" placeholder="Postal Code" value="@if($isEdit){{$EditData->PostalCode}}@endif">
                                            <button type="button" class="btn btn-sm btn-outline-dark" id="btnGSearchPostalCode">Search <i class="fa fa-search"></i></button>
                                        </div>
                                        <div class="errors BA err-sm" id="txtPostalCode-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstCity">City <span class="required">*</span></label>
                                        <select class="form-control" id="lstCity" data-selected="@if($isEdit){{$EditData->CityID}}@endif">
                                            <option value="">Select a City</option>
                                        </select>
                                        <div class="errors BA err-sm" id="lstCity-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstTaluk">Taluk <span class="required">*</span></label>
                                        <select class="form-control" id="lstTaluk" data-selected="@if($isEdit){{$EditData->TalukID}}@endif">
                                            <option value="">Select a Taluk</option>
                                        </select>
                                        <div class="errors BA err-sm" id="lstTaluk-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstDistrict">District <span class="required">*</span></label>
                                        <select class="form-control" id="lstDistricts" data-selected="@if($isEdit){{$EditData->DistrictID}}@endif">
                                            <option value="">Select a District</option>
                                        </select>
                                        <div class="errors BA err-sm" id="lstDistricts-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstState">State <span class="required">*</span></label>
                                        <select class="form-control" id="lstState"  data-selected="@if($isEdit){{$EditData->StateID}}@endif">
                                            <option value="">Select a State</option>
                                        </select>
                                        <div class="errors BA err-sm" id="lstState-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstCountry">Country <span class="required">*</span></label>
                                        <select class="form-control" id="lstCountry" data-selected="@if($isEdit){{$EditData->CountryID}}@endif">
                                            <option value="">Select a Country</option>
                                        </select>
                                        <div class="errors BA err-sm" id="lstCountry-err"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-outline-info btnAddAddress" data-title="Shipping Address">Add Shipping Address</button>
                                    <div class="errors err-sm" id="btnAddAddress-err"></div>
                                </div>
                            </div>
                            <div class="row mt-2 justify-content-center">
                                <div class="col-sm-8 d-flex justify-content-center">
                                    <table class="table" id="tblShippingAddress">
                                        <tbody>
                                        @if($isEdit)
                                            @foreach ($EditData->SAddress as $key => $item)
                                                <tr id="{{ $key + 1 }}" data-aid="{{ $item->AID }}">
                                                    <td class="text-right checkbox1 align-middle">
                                                        <div class="radio radio-primary">
                                                            <input id="chkSA{{ $key + 1 }}" data-aid="{{ $item->AID }}" type="radio" name="SAddress" value="{{ $key + 1 }}" {{ $item->isDefault == 1 ? 'checked' : '' }}>
                                                            <label for="chkSA{{ $key + 1 }}"></label>
                                                        </div>
                                                    </td>
                                                    <td class="pointer">
                                                        <b>{{ $item->Address }}</b>,<br>
                                                        {{ $item->CityName }}, {{ $item->TalukName }},<br>
                                                        {{ $item->DistrictName }}, {{ $item->StateName }},<br>
                                                        {{ $item->CountryName }} - {{ $item->PostalCode }}.
                                                    </td>
                                                    <td class="d-flex text-center">
                                                        <button type="button" class="btn btn-sm btn-outline-success m-3 btnEditSAddress"><i class="fas fa-pencil-alt"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger m-3 btnDeleteSAddress"><i class="fas fa-trash-alt"></i></button>
                                                    </td>
                                                    <td class="d-none">{{ json_encode($item) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-8 errors err-sm" id="tblShippingAddress-err"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        <button class="btn btn-success" id="btnSave" type="button" >@if($isEdit) Update @else Register @endif</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="confirm-modal" class="newsletter-popup mfp-hide bg-img p-6 h-auto" style="background: #f1f1f1 no-repeat center/cover">
        <h2>Are you sure you want to @if($isEdit) Update @else Register @endif ?</h2>
        <div class="modal-buttons">
            <button id="btnMConfirm" class="btn btn-primary">@if($isEdit) Update @else Register @endif</button>
            <button id="btnMCancel" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#lstConTypeIDs').select2({
            multiple: true,
            placeholder: 'Select a Construction Type'
        });
        const getCountry=async(data,id)=>{
            $('#'+id+' option').remove();
            $('#'+id).append('<option value="">Select a Country</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/country",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:data,
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for (let Item of response) {
                        let selected = "";
                        if (Item.CountryID === $('#' + id).attr('data-selected')) {
                            selected = "selected";
                        }
                        $('#' + id).append('<option ' + selected + ' value="' + Item.CountryID + '">' + Item.CountryName + ' </option>');
                    }
                    if ($('#' + id).val() != "") {
                        $('#' + id).trigger('change');
                    }
                }
            });
        }

        const getGender=async(data,id)=>{
            $('#'+id+' option').remove();
            $('#'+id).append('<option value="">Select a Gender</option>');
            $.ajax({
                type:"post",
                url:"{{ route('getGender') }}",
                headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' },
                data:data,
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for (let Item of response) {
                        let selected = "";
                        if (Item.GID  === $('#' + id).attr('data-selected')) {
                            selected = "selected";
                        }
                        $('#' + id).append('<option ' + selected + ' value="' + Item.GID + '">' + Item.Gender + ' </option>');
                    }
                    if ($('#' + id).val() != "") {
                        $('#' + id).trigger('change');
                    }
                }
            });
        }

        const getCusType = async (data, id) => {
            $('#' + id + ' option').remove();
            $('#' + id).append('<option value="">Select a Customer Type</option>');
            $.ajax({
                type: "post",
                url: "{{ route('getCustomerType') }}",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                data: data,
                dataType: "json",
                async: true,
                error: function (e, x, settings, exception) {
                    ajaxErrors(e, x, settings, exception);
                },
                complete: function (e, x, settings, exception) {
                },
                success: function (response) {
                    for (let Item of response) {
                        let selected = "";
                        if (Item.CusTypeID === $('#' + id).attr('data-selected')) {
                            selected = "selected";
                        }
                        $('#' + id).append('<option ' + selected + ' value="' + Item.CusTypeID + '">' + Item.CusTypeName + ' </option>');
                    }
                    if ($('#' + id).val() != "") {
                        $('#' + id).trigger('change');
                    }
                }
            });
        }

        const getConType = async (data, id) => {
            $('#'+id).select2('destroy');
            $('#' + id + ' option').remove();
            $.ajax({
                type: "post",
                url: "{{ route('getConstructionType') }}",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                data: data,
                dataType: "json",
                async: true,
                error: function (e, x, settings, exception) {
                    ajaxErrors(e, x, settings, exception);
                },
                complete: function (e, x, settings, exception) {
                },
                success: function (response) {
                    for (let Item of response.data) {
                        var selectedValues = $('#' + id).attr('data-selected');
                        var selectedValuesArray = selectedValues.split(',');
                        if (selectedValuesArray.includes(Item.ConTypeID)) {
                            $('#' + id).append('<option selected value="' + Item.ConTypeID + '">' + Item.ConTypeName + ' </option>');
                        } else {
                            $('#' + id).append('<option value="' + Item.ConTypeID + '">' + Item.ConTypeName + ' </option>');
                        }
                    }
                    if ($('#' + id).val() != "") {
                        $('#' + id).trigger('change');
                    }
                    $('#' + id).select2({
                        multiple: true,
                        placeholder: 'Select a Construction Type'
                    });
                }
            });
        }

        $('#btnGSearchPostalCode').trigger('click');
        getCountry({},'lstCountry');
        getGender({},'lstGender');
        getCusType({},'lstCusType');
        getConType({},'lstConTypeIDs');
    });
</script>
