@extends('layouts.app')
@section('content')
<link href='//fonts.googleapis.com/css?family=Open+Sans:100,200,300,400,500,600,700|Montserrat:100,200,300,400,500,600,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/support-ticket.css">
		<link rel="stylesheet" href="{{url('/')}}/assets/plugins/fancybox/jquery.fancybox.css" />
		<script src="{{url('/')}}/assets/plugins/fancybox/jquery.fancybox.js"></script>
<style>
    body,.page-body{
        background-color: #F3F3F3 !important;
        background: #F3F3F3 !important;
    }
    .card{
        font-family: "Montserrat",sans-serif !important;
        font-weight: 400 !important;
        line-height: 1.2 !important;
    }
</style>
<div class="container-fluid mt-100 pt-40">
<div class="content-header row">
        <div class="content-header-left col-md-8 col-12 mb-2 ">
            <div><h3 class="content-header-title mb-0 d-inline-block fs-21 fw-700" style="color:#607d8b">Customer Name : <span class="fs-19 fw-600"> {{$TUInfo['Name']}}  <span class="fs-16 fw-500">( {{$TUInfo['MobileNumber']}} )</span>  </span></h3></div>
            <div><h3 class="content-header-title mb-0 d-inline-block fs-21 fw-700 mt-20" style="color:#607d8b">Subject : <span class="fs-19 fw-600">@if(count($Support)>0) {{$Support[0]->Subject}} @endif </span></h3></div>
        </div>
    </div>
    @if(count($Support)>0)
    <div class="row " style="margin-bottom:40px;">
        <div class="col-sm-12 text-center">
            <div class="btn-group" role="group" >
                <!--<button type="button" class="btn btn-outline-secondary"> <i class="fa fa-reply-all" aria-hidden="true"></i> Reply</button>-->
                @if($Support[0]->Status!=0)
                    <button type="button" class="btn btn-outline-dark SupportTicketClose" data-id= "{{$Support[0]->SupportID}}"><i class="fa fa-check-circle" aria-hidden="true"></i> Close</button>
                @endif
                @if(($Support[0]->DFlag==0)&&($crud['add']==1)&&($Support[0]->Status!=0))
                    <!--<button type="button" class="btn btn-outline-dark SupportTicketDelete"> <i class="fa fa-trash" aria-hidden="true"></i> Delete</button>-->
                @endif
                <a type="button" href="{{url('/')}}/admin/support/" class="btn btn-outline-dark"> <i class="fa fa-reply-all" aria-hidden="true"></i> Back</a>
            </div>
        </div>
    </div>
    @endif
    <div class="SupportTicket"  style="margin-bottom:40px;">
            @for($i=0;$i<count($SupportDetails);$i++)
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <div class="1">
                                    <?php
                                        if (!file_exists($SupportDetails[$i]->ProfileImage)) {
                                            $SupportDetails[$i]->ProfileImage="";
                                        }
                                        if(($SupportDetails[$i]->ProfileImage=="")||($SupportDetails[$i]->ProfileImage==null)){
                                            $SupportDetails[$i]->ProfileImage="assets/images/male-icon.png";
                                        }
                                    ?>
                                    <img loading="lazy" src="{{url('/')}}/{{$SupportDetails[$i]->ProfileImage}}">
                                </div>
                                <h4 class="card-title">{{$SupportDetails[$i]->Name}} <br> <span>Posted on : {{date('d/m/Y',strtotime($SupportDetails[$i]->CreatedOn))}} at {{date('h:iA',strtotime($SupportDetails[$i]->CreatedOn))}}</span></h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li></li>
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?php echo $SupportDetails[$i]->Description; ?>
                                            @if(count($SupportDetails[$i]->Attachments)>0)
                                                <div class="row attachments mt-20 ml-10">
                                                    @for($j=0;$j<count($SupportDetails[$i]->Attachments);$j++)
                                                        @if($SupportDetails[$i]->Attachments[$j]->UploadUrl!="")
                                                            <div class="col-sm-2">
                                                                <?php
                                                                    if(file_exists($SupportDetails[$i]->Attachments[$j]->UploadUrl)){
                                                                        $ext = pathinfo($SupportDetails[$i]->Attachments[$j]->UploadUrl, PATHINFO_EXTENSION);
                                                                        $ext=strtolower($ext);
                                                                        if(in_array($ext,array('jpeg','jpg','png','gif','webp','bmp'))){
                                                                            echo '<a target="_blank" href="'.url("/")."/".$SupportDetails[$i]->Attachments[$j]->UploadUrl.'" data-fancybox="Image-1" data-caption="'.$SupportDetails[$i]->Attachments[$j]->UploadFileName.'"><img loading="lazy" class="b-r-5"  src="'.url("/")."/".$SupportDetails[$i]->Attachments[$j]->UploadUrl.'"></a>';
                                                                        }elseif($ext=="mp4"){
                                                                            echo '<a target="_blank" href="'.url("/")."/".$SupportDetails[$i]->Attachments[$j]->UploadUrl.'" data-fancybox="Videos" data-caption="'.$SupportDetails[$i]->Attachments[$j]->UploadFileName.'"><video class="b-r-5"  style="cursor:pointer" width="100%"><source src="'.url("/")."/".$SupportDetails[$i]->Attachments[$j]->UploadUrl.'" ></video></a>';
                                                                        }else{
                                                                            echo '<a target="_blank" data-fancybox data-type="iframe" data-src="'.url("/")."/".$SupportDetails[$i]->Attachments[$j]->UploadUrl.'" href="javascript:;">'.$SupportDetails[$i]->Attachments[$j]->UploadFileName.'</a>';
                                                                        }
                                                                    }
                                                                ?>
                                                            </div>
                                                        @endif
                                                    @endfor
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        @if($crud['edit']==1)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="img1"><img loading="lazy" src="{{url('/')}}/{{$UInfo->ProfileImage}}"></div>
                            <h4 class="card-title">{{$UInfo->Name}}</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">Attachments</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="file" id="imgAttachment1" class="dropify Attachments" data-default-file=""  data-max-file-size="20M"  data-allowed-file-extensions='jpeg jpg png gif webp bmp pdf'  /><span class="errors" id="imgAttachment1-err"></span>
                                            <span class="errors" id="imgAttachment1-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="file" id="imgAttachment2" class="dropify Attachments" data-default-file=""  data-max-file-size="20M"  data-allowed-file-extensions='jpeg jpg png gif webp bmp pdf'  /><span class="errors" id="imgAttachment2-err"></span>
                                            <span class="errors" id="imgAttachment2-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="file" id="imgAttachment3" class="dropify Attachments" data-default-file=""  data-max-file-size="20M"  data-allowed-file-extensions='jpeg jpg png gif webp bmp pdf'  /><span class="errors" id="imgAttachment3-err"></span>
                                            <span class="errors" id="imgAttachment3-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="file" id="imgAttachment4" class="dropify Attachments" data-default-file=""  data-max-file-size="20M"  data-allowed-file-extensions='jpeg jpg png gif webp bmp pdf'  /><span class="errors" id="imgAttachment4-err"></span>
                                            <span class="errors" id="imgAttachment4-err"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="txtDescription">Description <span class="required">*</span></label>
                                            <textarea class="form-control" id="txtDescription" rows=5></textarea>
                                            <span class="errors" id="txtDescription-err"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-20 mb-20">
                                    <div class="col-sm-12 text-right">
                                        <button id="btnSubmitSupport" type="button" class="btn btn-outline-success">Reply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if(count($Support)>0)
    <div class="row " style="margin-bottom:40px;">
        <div class="col-sm-12 text-center">
            <div class="btn-group" role="group" >
                <!--<button type="button" class="btn btn-outline-secondary"> <i class="fa fa-reply-all" aria-hidden="true"></i> Reply</button>-->
                @if($Support[0]->Status!=0)
                    <button type="button" class="btn btn-outline-dark SupportTicketClose" data-id= "{{$Support[0]->SupportID}}"><i class="fa fa-check-circle" aria-hidden="true"></i> Close</button>
                @endif
                @if(($Support[0]->DFlag==0)&&($crud['add']==1)&&($Support[0]->Status!=0))
                    <!--<button type="button" class="btn btn-outline-dark SupportTicketDelete"> <i class="fa fa-trash" aria-hidden="true"></i> Delete</button>-->
                @endif
                <a type="button" href="{{url('/')}}/admin/support/" class="btn btn-outline-dark"> <i class="fa fa-reply-all" aria-hidden="true"></i> Back</a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
@section('scripts')
<script src="{{url('/')}}/assets/js/support-chat.js"></script>
<script>
    $(document).ready(function(){
        const chat=Chat.ChatInstance({basePath:"{{url('/')}}",isAdmin:true,headers:{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }});
        $('#btnSubmitSupport').click(async function(){
            let Description=$('#txtDescription').val().split("'").join("").split('"').join("");
            let status=true;
            if(Description==""){
                $('#txtDescription-err').html('Description is required');status=false;
            }else if(Description.length<3){
                $('#txtDescription-err').html('Description must be at least 3 characters');status=false;
            }
            if(status==true){
                btnLoading($('#btnSubmitSupport'));
                let formData = new FormData();
                formData.append('Description', Description);
                if($('#imgAttachment1').val()!=""){
                    formData.append('Attachment1', $('#imgAttachment1')[0].files[0]);
                }
                if($('#imgAttachment2').val()!=""){
                    formData.append('Attachment2', $('#imgAttachment2')[0].files[0]);
                }
                if($('#imgAttachment3').val()!=""){
                    formData.append('Attachment3', $('#imgAttachment3')[0].files[0]);
                }
                if($('#imgAttachment4').val()!=""){
                    formData.append('Attachment4', $('#imgAttachment4')[0].files[0]);
                }
                formData.append('SID', "{{$SID}}");
                await chat.send_chats(formData);
                window.location.reload();
            }
        });

        $(document).on('click','.SupportTicketClose',function(){
                var CID=$(this).attr('data-id');
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/admin/support/deactivate/{{$SID}}",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success:function(response){
                        window.location.replace("{{url('/')}}/admin/support/");

                    }
                });
            });
            $(document).on('click','.SupportTicketDelete',function(){
                var CID=$(this).attr('data-id');
                swal({
                    title: "Are you sure?",
                    text: "You want Delete this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type:"post",
                        url:"{{url('/')}}/admin/support/delete/{{$SID}}",
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        success:function(response){
                            window.location.reload();
                        }
                    });
                });
            });
    });
</script>
@endsection
