<div class="row">
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label class="txtMTaxName">Tax Name <span class="required"> * </span></label>
            <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtMTaxName">
            <div class="errors new-tax" id="txtMTaxName-err"></div>
        </div>
    </div>
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label class="txtMPercentage">Percentage <span class="required"> * </span></label>
            <input type="number" step="0.01" class="form-control  {{$Theme['input-size']}}" id="txtMPercentage">
            <div class="errors new-tax" id="txtMPercentage-err"></div>
        </div>
    </div>
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label class="lstMActiveStatus">Active Status</label>
            <select class="form-control  {{$Theme['input-size']}}" id="lstMActiveStatus">
                <option value="Active" >Active</option>
                <option value="Inactive" >Inactive</option>
            </select>
            <div class="errors new-tax" id="lstMActiveStatus-err"></div>
        </div>
    </div>
</div>
<div class="row mt-20">
    <div class="col-sm-12 col-12 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success" id="btnCreateTax">Create</button>
    </div>
</div>