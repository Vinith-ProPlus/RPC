<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="txtMCountryName">Country Name <span class="required">*</span></label>
            <input type="text" id="txtMCountryName"  class="form-control  {{$Theme['input-size']}}" placeholder="Country Name" value="" auto-focus>
            <span class="errors New-Country-err" id="txtMCountryName-err"></span>
        </div>
    </div>
    <div class="col-sm-12  mt-20">
        <div class="form-group">
            <label for="txtMShortName">Short Name <span class="required">*</span></label>
            <input type="text" id="txtMShortName"  class="form-control  {{$Theme['input-size']}}" placeholder="Short Name"  value="">
            <span class="errors New-Country-err" id="txtMShortName-err"></span>
        </div>
    </div>
    <div class="col-sm-12  mt-20">
        <div class="form-group">
            <label for="txtMCallingCode">Calling Code <span class="required">*</span></label>
            <input type="number" id="txtMCallingCode"  class="form-control  {{$Theme['input-size']}}" placeholder="Calling Code"  value="">
            <span class="errors New-Country-err" id="txtMCallingCode-err"></span>
        </div>
    </div>
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label for="txtMPhoneLength">Mobile Number Length </label>
            <input type="number" id="txtMPhoneLength"  class="form-control  {{$Theme['input-size']}}" placeholder="Mobile Number Length"  value="0">
            <span class="errors New-Country-err" id="txtMPhoneLength-err"></span>
        </div>
    </div>
</div>
<div class="row  mt-30">
    <div class="col-sm-12 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button id="btnCreateCountry" type="button" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}} ">Create</button>
    </div>
</div>