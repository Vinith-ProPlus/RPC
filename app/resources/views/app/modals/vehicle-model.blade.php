<div class="row">
    <div class="col-sm-12 mt-10">
        <div class="form-group">
            <label for="lstMVehicleType">Vehicle Type <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} mselect2" id="lstMVehicleType" data-parent="1">
                <option value="">-- Select Vehicle Type--</option>
                @for($i=0;$i<count($VehicleType);$i++)
                    <option @if($VehicleType[$i]->VehicleTypeID==$VehicleTypeID) selected @endif value="{{$VehicleType[$i]->VehicleTypeID}}">{{$VehicleType[$i]->VehicleType}}</option>
                @endfor
            </select>
            <span class="errors New-VehicleBrand-err" id="lstMVehicleType-err"></span>
        </div>
    </div>
    <div class="col-sm-12 mt-10">
        <div class="form-group">
            <label for="lstMVehicleBrand">Vehicle Brand <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} mselect2" id="lstMVehicleBrand" data-vehicle-type-id="lstMVehicleType" data-parent="1">
                <option value="">-- Select Vehicle Brand--</option>
                @for($i=0;$i<count($VehicleBrand);$i++)
                   <option @if($VehicleBrand[$i]->VehicleBrandID==$VehicleBrandID) selected @endif value="{{$VehicleBrand[$i]->VehicleBrandID}}">{{$VehicleBrand[$i]->VehicleBrandName}}</option>
                @endfor
            </select>
            <span class="errors New-VehicleBrand-err" id="lstMVehicleBrand-err"></span>
        </div>
    </div>
    <div class="col-sm-12  mt-20">
        <div class="form-group">
            <label for="txtMVehicleModel">Vehicle Model <span class="required">*</span></label>
            <input type="text" id="txtMVehicleModel"  class="form-control  {{$Theme['input-size']}}" placeholder="Vehicle Model"  value="">
            <span class="errors New-VehicleBrand-err" id="txtMVehicleModel-err"></span>
        </div>
    </div>
</div>
<div class="row  mt-30">
    <div class="col-sm-12 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button id="btnCreateVehicleModel" type="button" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}} ">Create</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.mselect2').select2({
            dropdownParent: $('.dynamicValueModal')
        });
    })
</script>