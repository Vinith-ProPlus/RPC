<div class="row">
    <div class="col-sm-12 mt-10">
        <div class="form-group">
            <label for="lstMCountry">Country Name <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} mselect2" id="lstMCountry" data-parent="1">
                <option value="">-- Select Country--</option>
                @for($i=0;$i<count($Country);$i++)
                    <option @if($Country[$i]->CountryID==$CountryID) selected @endif value="{{$Country[$i]->CountryID}}">{{$Country[$i]->CountryName}}</option>
                @endfor
            </select>
            <span class="errors New-State-err" id="lstMCountry-err"></span>
        </div>
    </div>
    <div class="col-sm-12  mt-20">
        <div class="form-group">
            <label for="txtMStateName">State Name <span class="required">*</span></label>
            <input type="text" id="txtMStateName"  class="form-control  {{$Theme['input-size']}}" placeholder="State Name"  value="" >
            <span class="errors New-State-err" id="txtMStateName-err"></span>
        </div>
    </div>
    <div class="col-sm-12  mt-20">
        <div class="form-group">
            <label for="txtMStateCode">State Code <span class="required">*</span></label>
            <input type="text" id="txtMStateCode"  class="form-control  {{$Theme['input-size']}}" placeholder="State Code Under GST"  value="">
            <span class="errors New-State-err" id="txtMStateCode-err"></span>
        </div>
    </div>
</div>
<div class="row  mt-30">
    <div class="col-sm-12 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button id="btnCreateState" type="button" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}} ">Create</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.mselect2').select2({
            dropdownParent: $('.dynamicValueModal')
        });
    })
</script>