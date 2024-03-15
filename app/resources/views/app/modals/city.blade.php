<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="lstMCountry">Country Name <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} mselect2" id="lstMCountry" data-parent="1">
                <option value="">-- Select Country--</option>
                @for($i=0;$i<count($Country);$i++)
                    <option @if($Country[$i]->CountryID==$CountryID) selected @endif value="{{$Country[$i]->CountryID}}">{{$Country[$i]->CountryName}}</option>
                @endfor
            </select>
            <span class="errors New-City-err" id="lstMCountry-err"></span>
        </div>
    </div>
    <div class="col-sm-12  mt-20">
        <div class="form-group">
            <label for="lstMState">State Name <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} mselect2" id="lstMState" data-parent=1 data-country-id="lstMCountry" data-selected="{{$StateID}}">
                <option value="">-- Select State--</option>
                @for($i=0;$i<count($State);$i++)
                    <option @if($State[$i]->StateID==$StateID) selected @endif value="{{$State[$i]->StateID}}">{{$State[$i]->StateName}}</option>
                @endfor
            </select>
            <span class="errors New-City-err" id="lstMState-err"></span>
        </div>
    </div>
    <div class="col-sm-12  mt-20">
        <div class="form-group">
            <label for="lstMDistrict">District Name <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} mselect2" id="lstMDistrict" data-parent=1 data-country-id="lstMCountry" data-state-id="lstMState" data-selected="{{$DistrictID}}">
                <option value="">-- Select District--</option>
                @for($i=0;$i<count($District);$i++)
                    <option @if($District[$i]->DistrictID==$DistrictID) selected @endif value="{{$District[$i]->DistrictID}}">{{$District[$i]->DistrictName}}</option>
                @endfor
            </select>
            <span class="errors New-City-err" id="lstMDistrict-err"></span>
        </div>
    </div>
    <div class="col-sm-6 mt-20">
        <div class="form-group">
            <label for="lstMTaluk"> Taluk <span class="required"> * </span></label>
            <select class="form-control  {{$Theme['input-size']}} mselect2" id="lstMTaluk" data-parent=1 data-country-id="lstMCountry" data-state-id="lstMState" data-district-id="lstMDistrict" data-selected="{{$TalukID}}">
                <option value="">Select a Taluk</option>
                @for($i=0;$i<count($Taluk);$i++)
                    <option @if($Taluk[$i]->TalukID==$TalukID) selected @endif value="{{$Taluk[$i]->TalukID}}">{{$Taluk[$i]->TalukName}}</option>
                @endfor
            </select>
            <div class="errors" id="lstMTaluk-err"></div>
        </div>
    </div>
    <div class="col-sm-6 mt-20">
        <div class="form-group">
            <label for="lstMPostalCode">Postal Code <span class="required"> * </span></label>
            <select class="form-control mselect2 " id="lstMPostalCode" data-parent=1 data-country-id="lstMCountry" data-state-id="lstMState" data-district-id="lstMDistrict" data-selected="{{$PID}}">
                <option value="">Select a Postal Code</option>
                @for($i=0;$i<count($PostalCode);$i++)
                    <option @if($PostalCode[$i]->PID==$PID) selected @endif value="{{$PostalCode[$i]->PID}}">{{$PostalCode[$i]->PostalCode}}</option>
                @endfor
            </select>
            <span class="errors MAddress" id="lstMPostalCode-err"></span>
        </div>
    </div>
    <div class="col-sm-12  mt-20">
        <div class="form-group">
            <label for="txtMCityName">City Name <span class="required">*</span></label>
            <input type="text" id="txtMCityName"  class="form-control  {{$Theme['input-size']}}" placeholder="Enter City Name"  value="" autofocus>
            <span class="errors New-City-err" id="txtMCityName-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12  mt-30 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button id="btnCreateCity" type="button" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}} ">Create</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.mselect2').select2({
            dropdownParent: $('.dynamicValueModal')
        });
        if($('#lstMCountry').val()!=''){
            $('#lstMCountry').trigger('change');
        }
    })
</script>