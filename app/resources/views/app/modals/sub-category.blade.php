
<div class="row mb-30  d-flex justify-content-center">
    <div class="col-sm-6">
        <input type="file" class="Mdropify" id="txtMSCImage"   data-allowed-file-extensions="<?php echo implode(" ",$FileTypes['category']['Images']) ?>" >
        <div class="errors new-sub-category" id="txtMSCImage-err"></div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label class="txtMSCName"> Sub Category Name <span class="required"> * </span></label>
            <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtMSCName" value="">
            <div class="errors new-sub--category" id="txtMSCName-err"></div>
        </div>
    </div>
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label for="lstMCategory">Category <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} mselect2" id="lstMCategory">
                <option value="">Select s Category</option>
                @for($i=0;$i<count($Category);$i++)
                    <option @if($Category[$i]->CID==$CategoryID) selected @endif value="{{$Category[$i]->CID}}">{{$Category[$i]->CName}}</option>
                @endfor
            </select>
            <span class="errors new-sub-category" id="lstMCategory-err"></span>
        </div>
    </div>
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label class="lstMActiveStatus"> Active Status</label>
            <select class="form-control  {{$Theme['input-size']}}" id="lstMActiveStatus">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
            <div class="errors new-sub--category" id="lstMActiveStatus-err"></div>
        </div>
    </div>
</div>
<div class="row mt-20">
    <div class="col-sm-12 col-12 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success" id="btnCreateSubCategory">Create</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.Mdropify').dropify();
        $('.mselect2').select2({
            dropdownParent: $('.modal-dialog .modal-content')
        });
    });
</script>