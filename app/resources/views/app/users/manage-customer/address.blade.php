<div class="row">
    <div class="col-sm-6 mt-20">
        <label for="txtMTitle">Address Title <span class="required"> * </span></label>
        <input type="text" class="form-control" name="txtMTitle" id="txtMTitle" value="<?php if(array_key_exists("Title",$data)){ echo $data['Title']; } ?>">
        <span class="errors MAddress" id="txtMTitle-err"></span>
    </div>
    <div class="col-sm-6 mt-20">
        <label for="txtMAttention">Attention <span class="required"> * </span></label>
        <input type="text" class="form-control" name="txtMAttention" id="txtMAttention" value="<?php if(array_key_exists("Attention",$data)){ echo $data['Attention']; } ?>">
        <span class="errors MAddress" id="txtMAttention-err"></span>
    </div>
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label for="txtMAddress">Address <span class="required"> * </span></label>
            <textarea class="form-control " placeholder="Address" id="txtMAddress" name="txtMAddress" rows="2"><?php if(array_key_exists("Address",$data)){ echo $data['Address']; } ?></textarea>
            <span class="errors MAddress" id="txtMAddress-err"></span>
        </div>
    </div>
    <div class="col-sm-6 mt-20">
        <div class="form-group">
            <label for="lstMCountry">Country <span class="required"> * </span></label>
            <select class="form-control mselect2 " id="lstMCountry" data-selected="<?php if(array_key_exists("CountryID",$data)){ echo $data['CountryID']; } ?>">
                <option value="">Select a Country</option>
            </select>
            <span class="errors MAddress" id="lstMCountry-err"></span>
        </div>
    </div>
    <div class="col-sm-6 mt-20">
        <div class="form-group">
            <label for="lstMState">State <span class="required"> * </span></label>
            <select class="form-control mselect2 " id="lstMState" data-selected="<?php if(array_key_exists("StateID",$data)){ echo $data['StateID']; } ?>">
                <option value="">Select a State</option>
            </select>
            <span class="errors MAddress" id="lstMState-err"></span>
        </div>
    </div>
    <div class="col-sm-6 mt-20">
        <div class="form-group">
            <label for="lstMCity">City <span class="required"> * </span></label>
            <select class="form-control mselect2 " id="lstMCity" data-selected="<?php if(array_key_exists("CityID",$data)){ echo $data['CityID']; } ?>">
                <option value="">Select a City</option>
            </select>
            <span class="errors MAddress" id="lstMCity-err"></span>
        </div>
    </div>
    <div class="col-sm-6 mt-20">
        <div class="form-group">
            <label for="lstMPostalCode">Postal Code <span class="required"> * </span></label>
            <select class="form-control mselect2Tag " id="lstMPostalCode" data-selected="<?php if(array_key_exists("PostalCodeID",$data)){ echo $data['PostalCodeID']; } ?>">
                <option value="">Select a Postal Code or enter</option>
            </select>
            <span class="errors MAddress" id="lstMPostalCode-err"></span>
        </div>
    </div>
</div>
<div class="display-none">
    <button id="btnModelInit"></button>
</div>
<div class="row  mt-20">
    <div class="col-sm-12 text-right">
        <button class="btn btn-sm btn-outline-dark m-5 " id="btnMClose">Close</button>
        <button class="btn btn-sm btn-outline-success m-5 " data-uuid="<?php if(array_key_exists("uuid",$data)){ echo $data['uuid']; } ?>" data-aid="<?php if(array_key_exists("AID",$data)){ echo $data['AID']; } ?>" id="btnMAddAddress">Add</button>
    </div>
</div>
<script>
$(document).ready(function(){ 
    $('#btnModelInit').trigger('click');
});
</script>
