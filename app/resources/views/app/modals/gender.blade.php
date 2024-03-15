<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="txtmGender">Gender <span class="required">*</span></label>
            <input type="text" id="txtmGender"  class="form-control  {{$Theme['input-size']}}" placeholder="Gender"  value="" auto-focus>
            <span class="errors New-Gender-err" id="txtmGender-err"></span>
        </div>
    </div>
</div>
<div class="row  mt-30">
    <div class="col-sm-12 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button id="btnCreateGender" type="button" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}} ">Create</button>
    </div>
</div>