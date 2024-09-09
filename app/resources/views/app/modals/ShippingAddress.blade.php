<div class="row" id="shippingModalMapDiv">
    <div class="col-sm-12 mt-20">
        <label for="txtADMap">Select Location <span class="required"> * </span></label>
        <div id="map" class="mb-0" style="height: 350px;"></div>
        <span class="errors Address err-sm" id="txtADMap-err"></span>
    </div>
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label for="txtADAddressType">Address Type<span class="required"> * </span></label>
            <select class="form-control" id="txtADAddressType" name="txtADAddressType">
                <option value="">Select Address Type</option>
                <option value="Home" @if(isset($data['AddressType']) && $data['AddressType'] == 'Home') selected @endif>Home</option>
                <option value="Work" @if(isset($data['AddressType']) && $data['AddressType'] == 'Work') selected @endif>Work</option>
                <option value="Friends and Family" @if(isset($data['AddressType']) && $data['AddressType'] == 'Friends and Family') selected @endif>Friends and Family</option>
                <option value="Others" @if(isset($data['AddressType']) && $data['AddressType'] == 'Others') selected @endif>Others</option>
            </select>
            <span class="errors Address err-sm" id="txtADAddressType-err"></span>
        </div>
    </div>

    <div class="col-sm-12 mt-20" id="otherAddressTypeInput" style="display: none;">
        <div class="form-group">
            <label for="txtOtherADAddressType">Specify Address Type<span class="required"> * </span></label>
            <input class="form-control" placeholder="Specify Address Type" id="txtOtherADAddressType" name="txtOtherADAddressType"
                   value="{{ isset($data['AddressType']) && !in_array($data['AddressType'], ['Home', 'Work', 'Friends and Family']) ? $data['AddressType'] : '' }}">
            <span class="errors Address err-sm" id="txtOtherADAddressType-err"></span>
        </div>
    </div>

    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label for="txtADAddress">Address <span class="required"> * </span></label>
            <textarea class="form-control" placeholder="Address" id="txtADAddress" name="txtADAddress" rows="2"><?php if(array_key_exists("Address",$data)){ echo $data['Address']; } ?></textarea>
            <span class="errors Address err-sm" id="txtADAddress-err"></span>
        </div>
    </div>
    <div class="col-sm-6 mt-20">
        <div class="form-group">
            <label class="txtADPostalCode">Postal Code <span class="required"> * </span></label>
            <div class="input-group">
                <input type="text" class="form-control {{$Theme['input-size']}}" id="txtADPostalCode" value="<?php if(array_key_exists("PostalCode",$data)){ echo $data['PostalCode']; } ?>" data-id="<?php if(array_key_exists("PostalCodeID",$data)){ echo $data['PostalCodeID']; } ?>">
                <button class="input-group-text btn btn-sm btn-outline-primary px-4 position-relative" id="btnADPostalCode"><i class="fa fa-search"></i></button>
            </div>
            <div class="errors Address err-sm" id="txtADPostalCode-err"></div>
        </div>
    </div>
    <div class="col-sm-6 mt-20">
        <div class="form-group">
            <label for="lstADCity">City <span class="required"> * </span></label>
            <select class="form-control adselect2" id="lstADCity" data-parent="1" data-country-id="lstADCountry" data-state-id="lstADState" data-district-id="lstADDistrict" data-taluk-id="lstADTaluk" data-postal-id="txtADPostalCode" data-selected="<?php if(array_key_exists("CityID",$data)){ echo $data['CityID']; } ?>">
                <option value="">Select a City</option>
            </select>
            <span class="errors Address err-sm" id="lstADCity-err"></span>
        </div>
    </div>
    <input type="text" id="txtADLatitude" value="" style="display: none !important;">
    <input type="text" id="txtADLongitude" value="" style="display: none !important;">
    <input type="text" id="MapData" value="" style="display: none !important;">
</div>
<div class="row  mt-20">
    <div class="col-sm-12 text-right">
        <button class="btn btn-sm btn-outline-dark m-5 " id="btnMClose">Close</button>
        <button class="btn btn-sm btn-outline-success m-5 " data-edit-id="<?php if(array_key_exists("EditID",$data)){ echo $data['EditID']; } ?>" data-aid="<?php if(array_key_exists("AID",$data)){ echo $data['AID']; } ?>" id="btnSaveAddress">@if(array_key_exists("EditID",$data) && $data['EditID']>0) Update @else Save @endif </button>
    </div>
</div>
<div class="d-none" style="display: none !important;">
    <a id="btnShippingModalMap" href="#shippingModalMapDiv">.</a>
    <button id="btnModalInit"></button>
</div>
<script>
$(document).ready(function(){
    $('#btnModalInit').trigger('click');
    $('#btnShippingModalMap').click();

    $(document).on('click','#btnMClose',function(){
        $('#otherAddressTypeInput').hide();
        bootbox.hideAll();
    });

    $(document).on('shown.bs.modal', function () {
        $('#otherAddressTypeInput').hide();
        $('#txtADAddressType').val('');
    });

    var selectedType = $('#txtADAddressType').val();
    if (selectedType === 'Others' || !['Home', 'Work', 'Friends and Family'].includes(selectedType)) {
        $('#otherAddressTypeInput').show();
    } else {
        $('#otherAddressTypeInput').hide();
    }

    $('#txtADAddressType').on('change', function() {
        if ($(this).val() === 'Others') {
            $('#otherAddressTypeInput').show();
        } else {
            $('#otherAddressTypeInput').hide();
            $('#txtOtherADAddressType').val('');
        }
    });

});
</script>
<script>
    var map, marker;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 10.490, lng: 79.83},
            zoom: 7
        });

        // Check if geolocation is available
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    marker = new google.maps.Marker({
                        position: pos,
                        map: map,
                        title: 'Your current location'
                    });

                    map.setCenter(pos);

                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({'location': pos}, function(results, status) {
                        if (status === 'OK') {
                            if (results[0]) {
                                var formattedAddress = results[0].formatted_address;
                                var lat = results[0].geometry.location.lat();
                                var lng = results[0].geometry.location.lng();
                                var mapData = results[0].geometry;
                                $('#txtADAddress').val(formattedAddress);
                                $('#txtADLatitude').val(lat);
                                $('#txtADLongitude').val(lng);
                                $('#mapData').val(mapData);
                                var postalCode = extractPostalCodeFromAddressComponents(results[0]);
                                if (!postalCode) {
                                    reverseGeocodeWithPlaceId(results[0].place_id);
                                } else {
                                    $('#txtADPostalCode').val(postalCode);
                                    $('#btnADPostalCode').click();
                                }
                            }
                        }
                    });
                },
                function() {
                    console.log('Geolocation permission denied or error occurred.');
                }
            );
        } else {
            console.log('Geolocation is not supported by this browser.');
        }

        map.addListener('click', function(event) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'location': event.latLng}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        var formattedAddress = results[0].formatted_address;
                        var lat = results[0].geometry.location.lat();
                        var lng = results[0].geometry.location.lng();
                        var mapData = results[0].geometry;
                        $('#txtADAddress').val(formattedAddress);
                        $('#txtADLatitude').val(lat);
                        $('#txtADLongitude').val(lng);
                        $('#mapData').val(mapData);
                        var postalCode = extractPostalCodeFromAddressComponents(results[0]);
                        if (!postalCode) {
                            reverseGeocodeWithPlaceId(results[0].place_id);
                        } else {
                            $('#txtADPostalCode').val(postalCode);
                            $('#btnADPostalCode').click();
                        }
                    }
                }
            });
            if (marker) {
                marker.setMap(null);
            }

            marker = new google.maps.Marker({
                position: event.latLng,
                map: map,
            });

            marker.setMap(map);
        });
    }

    function reverseGeocodeWithPlaceId(placeId) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'placeId': placeId }, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    var postalCode = extractPostalCodeFromAddressComponents(results[0]);
                    if (postalCode) {
                        $('#txtADPostalCode').val(postalCode);
                        $('#btnADPostalCode').click();
                    } else {
                        var lat = results[0].geometry.location.lat();
                        var lng = results[0].geometry.location.lng();
                        $.ajax({
                            url: "http://api.geonames.org/findNearbyPostalCodesJSON?lat="+lat+"&lng="+lng+"&username={{ config('app.geo_names_user_name') }}",
                            method: 'GET',
                            success: function(response) {
                                if (response['postalCodes'] && response['postalCodes'].length > 0) {
                                    var postalCode = response['postalCodes'][0]['postalCode'];
                                    $('#txtADPostalCode').val(postalCode);
                                    $('#btnADPostalCode').click();
                                } else {
                                    console.log('Postal code not found in response data.');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching postal code:', error);
                            }
                        });
                    }
                } else {
                    console.log('No results found for the given place ID.');
                }
            } else {
                console.log('Reverse geocoding with place ID failed due to: ' + status);
            }
        });
    }

    function extractPostalCodeFromAddressComponents(result) {
        for (var i = 0; i < result.address_components.length; i++) {
            var addressComponent = result.address_components[i];
            if (addressComponent.types.includes('postal_code')) {
                return addressComponent.long_name;
            }
        }
        return null;
    }
</script>

<script async src="https://maps.googleapis.com/maps/api/js?key={{ config('app.map_api_key') }}&callback=initMap"></script>
