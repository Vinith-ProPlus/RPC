<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="lstMCountry">Country Name <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} mselect2" id="lstMCountry" data-parent="1">
                <option value="">-- Select Country--</option>
                @for($i=0;$i<count($Country);$i++)
                    <option @if($Country[$i]->CountryID==$CountryID) selected @endif value="{{$Country[$i]->CountryID}}">{{$Country[$i]->CountryName}}</option>
                @endfor
            </select>
            <span class="errors New-District-err" id="lstMCountry-err"></span>
        </div>
    </div>
    <div class="col-sm-12  mt-20">
        <div class="form-group">
            <label for="lstMState">State Name <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} mselect2" id="lstMState" data-parent="1" data-country-id="lstMCountry" data-selected="{{$StateID}}">
                <option value="">-- Select State--</option>
                @for($i=0;$i<count($State);$i++)
                    <option @if($State[$i]->StateID==$StateID) selected @endif value="{{$State[$i]->StateID}}">{{$State[$i]->StateName}}</option>
                @endfor
            </select>
            <span class="errors New-District-err" id="lstMState-err"></span>
        </div>
    </div>
    <div class="col-sm-12  mt-20">
        <div class="form-group">
            <label for="txtMDistrictName">District Name <span class="required">*</span></label>
            <input type="text" id="txtMDistrictName"  class="form-control  {{$Theme['input-size']}}" placeholder="Enter District Name"  value="" autofocus>
            <span class="errors New-District-err" id="txtMDistrictName-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12  mt-30 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button id="btnCreateDistrict" type="button" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}} ">Create</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.mselect2').select2({
            dropdownParent: $('.dynamicValueModal')
        });
        if($('#lstMCountry').val()!=''){
            $('#lstMCountry').trigger('change');
        }
    })
</script>