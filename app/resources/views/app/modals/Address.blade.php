<div class="row">
    {{-- <div class="col-sm-12 mt-20">
        <label for="txtADTitle">Address Title <span class="required"> * </span></label>
        <input type="text" class="form-control" name="txtADTitle" id="txtADTitle" value="">
        <span class="errors Address err-sm" id="txtADTitle-err"></span>
    </div> --}}
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label for="txtADAddress">Address <span class="required"> * </span></label>
            <textarea class="form-control" placeholder="Address" id="txtADAddress" name="txtADAddress" rows="2"><?php if(array_key_exists("Address",$data)){ echo $data['Address']; } ?></textarea>
            <span class="errors Address err-sm" id="txtADAddress-err"></span>
        </div>
    </div>
    <div class="col-sm-6 mt-20">
        <div class="form-group">
            <label class="txtADPostalCode">Postal Code <span class="required"> * </span></label>
            <div class="input-group">
                <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtADPostalCode" value="<?php if(array_key_exists("PostalCode",$data)){ echo $data['PostalCode']; } ?>" data-id="<?php if(array_key_exists("PostalCodeID",$data)){ echo $data['PostalCodeID']; } ?>">
                <button class="input-group-text btn btn-sm btn-outline-primary px-4 position-relative" id="btnADPostalCode"><i class="fa fa-search"></i></button>
            </div>
            <div class="errors Address err-sm" id="txtADPostalCode-err"></div>
        </div>
    </div>
    <div class="col-sm-6 mt-20">
        <div class="form-group">
            <label for="lstADCity">City <span class="required"> * </span></label>
            <select class="form-control adselect2" id="lstADCity" data-parent="1" data-country-id="lstADCountry" data-state-id="lstADState" data-district-id="lstADDistrict" data-taluk-id="lstADTaluk" data-postal-id="txtADPostalCode" data-selected="<?php if(array_key_exists("CityID",$data)){ echo $data['CityID']; } ?>">
                <option value="">Select a City</option>
            </select>
            <span class="errors Address err-sm" id="lstADCity-err"></span>
        </div>
    </div>
    <div class="col-sm-6 mt-20">
        <div class="form-group">
            <label for="lstADTaluk">Taluk <span class="required"> * </span></label>
            <select class="form-control  {{$Theme['input-size']}} adselect2" data-parent="1" id="lstADTaluk" data-country-id="lstADCountry" data-state-id="lstADState" data-district-id="lstADDistrict" data-selected="<?php if(array_key_exists("TalukID",$data)){ echo $data['TalukID']; } ?>">
                <option value="">Select a Taluk</option>
            </select>
            <div class="errors Address err-sm" id="lstADTaluk-err"></div>
        </div>
    </div>
    <div class="col-sm-6 mt-20">
        <div class="form-group">
            <label for="lstADDistrict">District <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} adselect2" data-parent="1" id="lstADDistrict" data-country-id="lstADCountry" data-state-id="lstADState" data-selected="<?php if(array_key_exists("DistrictID",$data)){ echo $data['DistrictID']; } ?>">
                <option value="">-- Select a District--</option>
            </select>
            <span class="errors Address err-sm" id="lstADDistrict-err"></span>
        </div>
    </div>
    <div class="col-sm-6 mt-20">
        <div class="form-group">
            <label for="lstADState">State <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} adselect2" data-parent="1" id="lstADState" data-parent="1" data-country-id="lstADCountry" data-selected="<?php if(array_key_exists("StateID",$data)){ echo $data['StateID']; } ?>">
                <option value="">-- Select a State--</option>
            </select>
            <span class="errors Address err-sm" id="lstADState-err"></span>
        </div>
    </div>
    <div class="col-sm-6 mt-20">
        <div class="form-group">
            <label for="lstADCountry">Country <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} adselect2" id="lstADCountry" data-parent="1" data-selected="<?php if(array_key_exists("CountryID",$data)){ echo $data['CountryID']; } ?>">
                <option value="">-- Select a Country--</option>
            </select>
            <span class="errors Address err-sm" id="lstADCountry-err"></span>
        </div>
    </div>
</div>
<div class="row  mt-20">
    <div class="col-sm-12 text-right">
        <button class="btn btn-sm btn-outline-dark m-5 " id="btnMClose">Close</button>
        <button class="btn btn-sm btn-outline-success m-5 " data-edit-id="<?php if(array_key_exists("EditID",$data)){ echo $data['EditID']; } ?>" data-aid="<?php if(array_key_exists("AID",$data)){ echo $data['AID']; } ?>" id="btnSaveAddress">@if(array_key_exists("EditID",$data) && $data['EditID']>0) Update @else Save @endif </button>
    </div>
</div>
<div class="display-none">
    <button id="btnModalInit"></button>
</div>
<script>
$(document).ready(function(){
    $('#btnModalInit').trigger('click');
    
    $(document).on('click','#btnMClose',function(){
        bootbox.hideAll();
    });
});
</script>
