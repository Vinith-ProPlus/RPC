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
            <span class="errors New-PostalCode-err" id="lstMCountry-err"></span>
        </div>
    </div>
    <div class="col-sm-12  mt-20">
        <div class="form-group">
            <label for="lstMState">State Name <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} mselect2" id="lstMState" data-parent=1 data-country-id="lstMCountry" data-selected="{{$StateID}}">
                <option value="">-- Select State--</option>
                @for($i=0;$i<count($State);$i++)
                    <option @if($State[$i]->StateID==$StateID) selected @endif value="{{$State[$i]->StateID}}">{{$State[$i]->StateName}}</option>
                @endfor
            </select>
            <span class="errors New-PostalCode-err" id="lstMState-err"></span>
        </div>
    </div>
    <div class="col-sm-12  mt-20">
        <div class="form-group">
            <label for="lstMDistrict">District Name <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} mselect2" id="lstMDistrict" data-parent=1 data-country-id="lstMCountry" data-state-id="lstMState" data-selected="{{$DistrictID}}">
                <option value="">-- Select District--</option>
                @for($i=0;$i<count($District);$i++)
                    <option @if($District[$i]->DistrictID==$DistrictID) selected @endif value="{{$District[$i]->DistrictID}}">{{$District[$i]->DistrictName}}</option>
                @endfor
            </select>
            <span class="errors New-PostalCode-err" id="lstMDistrict-err"></span>
        </div>
    </div>
    <div class="col-sm-12  mt-20">
        <div class="form-group">
            <label for="txtMPostalCode">Postal Code <span class="required">*</span></label>
            <input type="number" id="txtMPostalCode"  class="form-control  {{$Theme['input-size']}}" placeholder="Enter Postal Code"  value="" autofocus>
            <span class="errors New-PostalCode-err" id="txtMPostalCode-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12  mt-30 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button id="btnCreatePostalCode" type="button" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}} ">Create</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.mselect2').select2({
            dropdownParent: $('.dynamicValueModal')
        });
    })
</script>