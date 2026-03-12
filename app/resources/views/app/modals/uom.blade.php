
<div class="row">
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label class="txtMUCode">Unit Code<span class="required"> * </span></label>
            <input type="text" class="form-control  {{$Theme['input-size']}}" placeholder="Code" id="txtMUCode" >
            <div class="errors new-uom" id="txtMUCode-err"></div>
        </div>
    </div>
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label class="txtMUName">Unit Name <span class="required"> * </span></label>
            <input type="text" class="form-control  {{$Theme['input-size']}}" placeholder="Name" id="txtMUName">
            <div class="errors new-uom" id="txtMUName-err"></div>
        </div>
    </div>
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label class="lstMActiveStatus"> Active Status</label>
            <select class="form-control  {{$Theme['input-size']}}" id="lstMActiveStatus">
                <option value="1" >Active</option>
                <option value="0" >Inactive</option>
            </select>
            <div class="errors new-uom" id="lstMActiveStatus-err"></div>
        </div>
    </div>
</div>
<div class="row mt-20">
    <div class="col-sm-12 col-12 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success" id="btnCreateUOM">Create</button>
    </div>
</div>