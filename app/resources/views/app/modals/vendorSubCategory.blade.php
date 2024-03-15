
<div class="row mb-30  d-flex justify-content-center">
    <div class="col-sm-6">
        <input type="file" class="Mdropify" id="txtMVSCImage" data-allowed-file-extensions="<?php echo implode(" ",$FileTypes['category']['Images']) ?>" >
        <div class="errors new-category" id="txtMVSCImage-err"></div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label class="txtMVSCName"> Vendor Sub Category Name <span class="required"> * </span></label>
            <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtMVSCName" value="">
            <div class="errors new-category" id="txtMVSCName-err"></div>
        </div>
    </div>
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label class="lstMVCategory"> Vendor Category Name <span class="required"> * </span></label>
            <select class="form-control  {{$Theme['input-size']}} select2" id="lstMVCategory">
                <option value="">-- Select Vendor Category--</option>
                @foreach($VCategory as $row)
                <option @if($row->VCID == $VCID) selected @endif value="{{$row->VCID}}">{{$row->VCName}}</option>
                @endforeach
            </select>
            <div class="errors new-category" id="lstMVCategory-err"></div>
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
        <button class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success" id="btnCreateVSubCategory">Create</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.Mdropify').dropify();
        $('#lstMVCategory').select2({
            dropdownParent: $('.bootbox-body')
        });
    });
</script>