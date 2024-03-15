<div class="row">
<div class="col-sm-12">
    <div class="form-group">
        <label class="txtMGroupName"> Group Name <span class="required"> * </span></label>
        <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtMGroupName">
        <div class="errors new-customer-group" id="txtMGroupName-err"></div>
    </div>
</div>
<div class="col-sm-12 mt-20">
    <div class="form-group">
        <label class="lstMActiveStatus"> Active Status</label>
        <select class="form-control  {{$Theme['input-size']}}" id="lstMActiveStatus">
            <option value="Active"  >Active</option>
            <option value="Inactive" >Inactive</option>
        </select>
        <div class="errors new-customer-group" id="lstMActiveStatus-err"></div>
    </div>
</div>
</div>
<div class="row mt-20">
    <div class="col-sm-12 col-12 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success" id="btnCreateCustomerGroups">Create</button>
    </div>
</div>