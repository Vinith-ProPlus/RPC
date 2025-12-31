
<div class="row mb-30  d-flex justify-content-center">
    <div class="col-sm-6">
        <input type="file" class="Mdropify" id="txtMVCImage" data-allowed-file-extensions="<?php echo implode(" ",$FileTypes['category']['Images']) ?>" >
        <div class="errors new-category" id="txtMVCImage-err"></div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label class="txtMVCName"> Vendor Category Name <span class="required"> * </span></label>
            <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtMVCName" value="">
            <div class="errors new-category" id="txtMVCName-err"></div>
        </div>
    </div>
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label class="lstMActiveStatus"> Active Status</label>
            <select class="form-control  {{$Theme['input-size']}}" id="lstMActiveStatus">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
            <div class="errors new-category" id="lstMActiveStatus-err"></div>
        </div>
    </div>
</div>
<div class="row mt-20">
    <div class="col-sm-12 col-12 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success" id="btnCreateVCategory">Create</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.Mdropify').dropify();
    });
</script>