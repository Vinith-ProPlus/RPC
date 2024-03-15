<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="txtMVehicleType">Vehicle Type <span class="required">*</span></label>
            <input type="text" id="txtMVehicleType"  class="form-control  {{$Theme['input-size']}}" placeholder="Vehicle Type" value="" auto-focus>
            <span class="errors New-VehicleType-err" id="txtMVehicleType-err"></span>
        </div>
    </div>
</div>
<div class="row  mt-30">
    <div class="col-sm-12 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button id="btnCreateVehicleType" type="button" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}} ">Create</button>
    </div>
</div>