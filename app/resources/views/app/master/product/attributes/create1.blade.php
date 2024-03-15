@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Product Master</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/product-master/attributes/" data-original-title="" title="">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">@if($isEdit==true)Update @else Create @endif</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-5">
			<div class="card">
				<div class="card-header text-center"><h5 class="mt-10">{{$PageTitle}}</h5></div>
				<div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mt-20">
                            <div class="form-group">
                                <label class="txtAttrName">Attribute Name <span class="required"> * </span></label>
                                <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtAttrName" value="<?php if($isEdit==true){ echo $EditData[0]->AttrName;} ?>">
                                <div class="errors" id="txtAttrName-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-20">
                            <div class="form-group">
                                <label class="txtValues">Values <span class="required"> * </span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtValues">
                                    <button class="input-group-text btn-outline-primary px-4 position-relative" id="btnAdd"><i class="fa fa-plus"></i></button>
                                </div>
                                <div class="errors" id="txtValues-err"></div>
                            </div>
                            <div class="py-1">
                                <table class="table" id="tblValues">
                                    <tbody>
                                        @if($isEdit)
                                            @foreach ($EditValues as $row)
                                                <tr>
                                                    <td class="input-group p-0">
                                                        <input class="form-control py-0" data-value-id="{{$row->ValueID}}" value="{{$row->Values}}">
                                                        <button class="input-group-text btn-outline-danger px-4 position-relative btnDelete"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- <div class="col-sm-12 mt-20">
                            <div class="form-group">
                                <label class="lstActiveStatus">Active Status</label>
                                <select class="form-control {{$Theme['input-size']}}" id="lstActiveStatus">
                                    <option value="Active" @if($isEdit==true) @if($EditData[0]->ActiveStatus=="Active") selected @endif @endif >Active</option>
                                    <option value="Inactive" @if($isEdit==true) @if($EditData[0]->ActiveStatus=="Inactive") selected @endif @endif>Inactive</option>
                                </select>
                                <div class="errors" id="lstActiveStatus-err"></div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row mt-20">
                        <div class="col-sm-12 text-right">
                            @if($crud['view']==true)
                            <a href="{{url('/')}}/product-master/attributes" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
                            @endif
                            
                            @if((($crud['add']==true) && ($isEdit==false))||(($crud['edit']==true) && ($isEdit==true)))
                                <button class="btn {{$Theme['button-size']}} btn-outline-success" id="btnSave">@if($isEdit==true) Update @else Save @endif</button>
                            @endif
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){

        const ValuesValidation=async(data)=>{
            $('.errors').html('');
            let status=true;
            let lowerCaseData = data.toLowerCase();
            $('#tblValues tbody tr').each(function(){
                let ExistingValue = $(this).find('td:first input').val().toLowerCase();
                // let ExistingValue = $(this).find('td:first div').html().toLowerCase();
                if(ExistingValue == lowerCaseData){
                    $("#txtValues-err").html('This Value exists');status=false;
                    return false;
                }
            });
            if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
            return status;
        }

        $('#btnAdd').click(async function(){
            $('.errors').html('');
			let Value=$('#txtValues').val();
			let status=true;
            if(Value == ""){
                $("#txtValues-err").html('Enter a Value');status=false;
            }else if (!await ValuesValidation(Value)){
                status = false;
            }
			if(status){
				let html='<tr>';
					html+='<td class="input-group p-0">';
					html+='<input class="form-control py-0" data-value-id="" value="'+Value+'">';
					html+='<button class="input-group-text btn-outline-danger px-4 position-relative btnDelete"><i class="fa fa-trash"></i></button>';
					/* html+='<td>';
                    html+='<div>'+Value+'</div>';
					html+='</td>'; */
					html+='</tr>';
				$('#tblValues tbody').append(html);
                $('#txtValues').val('');
			}
		});

        $(document).on('click','.btnDelete',function(){
            $(this).closest('tr').remove();
        });

        const formValidation=()=>{
            $('.errors').html('');
            let status=true;
            let AttrName=$('#txtAttrName').val();
            let ValuesTable=$('#tblValues tbody tr');
            if(AttrName==""){
                $('#txtAttrName-err').html('Attribute Name is required.');status=false;
            }else if(AttrName.length<3){
                $('#txtAttrName-err').html('Attribute Name must be greater than 2 characters');status=false;
            }else if(AttrName.length>100){
                $('#txtAttrName-err').html('Attribute Name may not be greater than 100 characters');status=false;
            }
            if(ValuesTable.length == 0){
                $("#txtValues-err").html('Add a Value');status=false;
            }
            if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
            return status;
        }
        $("#txtValues").keyup(function (e) { 
            $('.errors').html('');
        });
        $('#btnSave').click(function(){
            let status=formValidation();
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this Attribute!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnSave'));
                    let postUrl=@if($isEdit==true) "{{url('/')}}/product-master/attributes/edit/{{$EditData[0]->AttrID}}"; @else "{{url('/')}}/product-master/attributes/create"; @endif
                    let formData=new FormData();
                    formData.append('AttrName',$('#txtAttrName').val());
                    // formData.append('ActiveStatus','$('#lstActiveStatus').val()');
                    formData.append('ActiveStatus','Active');
                    let Values = [];
                    $('#tblValues tbody tr').each(function(){
                        let EachValue=$(this).find('td:first input').val();
                        @if($isEdit)
                            let ValueID = $(this).find('td:first input').attr('data-value-id');
                            let VData = {
                                ValueID: ValueID,
                                Value: EachValue
                            }
                            Values.push(VData);
                        @else
                            Values.push(EachValue);
                        @endif
                    });
                    formData.append('VData', JSON.stringify(Values));
                    $.ajax({
                        type:"post",
                        url:postUrl,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        data:formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = (evt.loaded / evt.total) * 100;
                                    percentComplete=parseFloat(percentComplete).toFixed(2);
                                    $('#divProcessText').html(percentComplete+'% Completed.<br> Please wait for until upload process complete.');
                                    //Do something with upload progress here
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function() {
                            ajaxIndicatorStart("Please wait Upload Process on going.");

                            var percentVal = '0%';
                            setTimeout(() => {
                            $('#divProcessText').html(percentVal+' Completed.<br> Please wait for until upload process complete.');
                            }, 100);
                        },
                        error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                        complete: function(e, x, settings, exception){btnReset($('#btnSave'));ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},
                        success:function(response){
                            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                            if(response.status==true){
                                swal({
                                    title: "SUCCESS",
                                    text: response.message,
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonClass: "btn-outline-success",
                                    confirmButtonText: "Okay",
                                    closeOnConfirm: false
                                },function(){
                                    @if($isEdit==true)
                                        window.location.replace("{{url('/')}}/product-master/attributes");
                                    @else
                                        window.location.reload();
                                    @endif
                                    
                                });
                                
                            }else{
                                toastr.error(response.message, "Failed", {
                                    positionClass: "toast-top-right",
                                    containerId: "toast-top-right",
                                    showMethod: "slideDown",
                                    hideMethod: "slideUp",
                                    progressBar: !0
                                })
                                if(response['errors']!=undefined){
                                    $('.errors').html('');
                                    $.each( response['errors'], function( KeyName, KeyValue ) {
                                        var key=KeyName;
                                        if(key=="AttrName"){$('#txtAttrName-err').html(KeyValue);}
                                        if(key=="ShortName"){$('#txtShortName-err').html(KeyValue);}
                                        if(key=="PhoneCode"){$('#txtPhoneCode-err').html(KeyValue);}
                                    });
                                }
                            }
                        }
                    });
                });
            }
        });

    });
</script>
@endsection