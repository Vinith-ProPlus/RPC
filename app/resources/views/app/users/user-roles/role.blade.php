@extends('layouts.app')
@section('content')
<style>
	tr[data-level="L001"]{
		font-weight:900;
		font-size:16px;
	}
	tr[data-level="L002"]{
		font-weight:600;
		font-size:15px;
	}
	
	tr[data-level="L002"] td:first-child{
		padding: 0.5rem 2rem 0.5rem  3rem;
	}
	tr[data-level="L003"]{
		font-weight:500;
		font-size:13px;
	}
	tr[data-level="L003"] td:first-child{
		padding: 0.5rem 2rem 0.5rem  4rem;
	}
	tr[data-level="L001"] .checkbox label::before{
		width: 21px;
    	height: 21px;
	}
	tr[data-level="L002"] .checkbox label::before{
		width: 19px;
    	height: 19px;
	}
	tr[data-level="L003"] .checkbox label::before{
		width: 17px;
    	height: 17px;
	}
</style>
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}/"><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Users & Permissions</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/users-and-permissions/user-roles">{{$PageTitle}}</a></li>
					<li class="breadcrumb-item">@if($isEdit) Update @else Create @endif</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card">
				<div class="card-header text-center"><h5>User Roles</h5></div>
				<div class="card-body">
					<div class="row justify-content-center">
						<div class="col-sm-4">
							<div class="form-group">
								<label for="txtRoleName">Role Name <span class="required">*</span></label>
								<input type="text" id="txtRoleName" class="form-control  {{$Theme['input-size']}}" placeholder="Role Name"  value="@if($isEdit==true){{$EditData[0]->RoleName}}@endif">
								<span class="errors" id="txtRoleName-err"></span>
							</div>
						</div>
					</div>
					<div class="row mt-20">
						<div class="col-12 col-sm-12">
							<table class="table  {{$Theme['table-size']}} table-bordered" id="tblUserRights">
								<thead>
									<tr>
										<th class="text-center">Modules</th>
										<th class="text-center">ADD</th>
										<th class="text-center">VIEW</th>
										<th class="text-center">EDIT</th>
										<th class="text-center">DELETE</th>
										<th class="text-center">COPY</th>
										<th class="text-center">EXCEL</th>
										<th class="text-center">CSV</th>
										<th class="text-center">PRINT</th>
										<th class="text-center">PDF</th>
										<th class="text-center">Restore</th>
										<th class="text-center">Show Pwd</th>
									</tr>
									<tr style="display: none;">
										<th class="text-center"></th>
										<th class="text-center"><div class="checkbox checkbox-dark"><input id="chkAddAll" type="checkbox" ><label for="chkAddAll"></label></div></th>
										<th class="text-center"><div class="checkbox checkbox-dark"><input id="chkViewAll" type="checkbox" ><label for="chkViewAll"></label></div></th>
										<th class="text-center"><div class="checkbox checkbox-dark"><input id="chkEditAll" type="checkbox" ><label for="chkEditAll"></label></div></th>
										<th class="text-center"><div class="checkbox checkbox-dark"><input id="chkDeleteAll" type="checkbox" ><label for="chkDeleteAll"></label></div></th>
										<th class="text-center"><div class="checkbox checkbox-dark"><input id="chkCopyAll" type="checkbox" ><label for="chkCopyAll"></label></div></th>
										<th class="text-center"><div class="checkbox checkbox-dark"><input id="chkExcelAll" type="checkbox" ><label for="chkExcelAll"></label></div></th>
										<th class="text-center"><div class="checkbox checkbox-dark"><input id="chkCSVAll" type="checkbox" ><label for="chkCSVAll"></label></div></th>
										<th class="text-center"><div class="checkbox checkbox-dark"><input id="chkPrintAll" type="checkbox" ><label for="chkPrintAll"></label></div></th>
										<th class="text-center"><div class="checkbox checkbox-dark"><input id="chkPDFAll" type="checkbox" ><label for="chkPDFAll"></label></div></th>
										<th class="text-center"><div class="checkbox checkbox-dark"><input id="chkShowPwdAll" type="checkbox" ><label for="chkShowPwdAll"></label></div></th>
									</tr>
								</thead>
								<tbody id="tblroles"></tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-sm-12 text-right">
							@if($crud['view']==1)
								<a id="btnCancel" href="{{ url('/') }}/admin/users-and-permissions/user-roles/" class="btn {{$Theme['button-size']}}  btn-outline-dark mr-10">Cancel</a>
							@endif
							<button id="btnSubmit" type="button" class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success">Save</button>
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
		const levels={
			"L001":{checkBox:"checkbox-primary",textClass:"txt-dark"},
			"L002":{checkBox:"checkbox-success",textClass:"txt-dark"},
			"L003":{checkBox:"checkbox-dark",textClass:"txt-dark"},
		}
		const init=async()=>{
			getMenus();
		}
		const getMenus=async()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/users-and-permissions/user-roles/get/menus-data",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:false,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:async function(response){
                    await loadMenus(response,{MID:""});
					loadCRUDs();
					enableViewOptions();
					@if($isEdit)
						getRoleData();
					@endif
                }
            });
		}
		const loadMenus=async(datas,parent,old={})=>{
			if(parent.MID==undefined){parent.MID="";}
			for(i=0;i<datas.length;i++){
				let data=datas[i];
				const mLevel=data.Level;

				if((data.Slug!="profile")&&(data.Slug!="logout")&&(data.Slug!="password-change")&&(data.Slug!="change-password")){
					let html='<tr data-level="'+mLevel+'" data-id="'+data.MID+'" data-parent-id="'+parent.MID+'" data-has-submenu="'+data.hasSubMenu+'" data-slug="'+data.Slug+'">';
						html+='<td class="'+levels[mLevel].textClass+'"  data-parant="'+parent.MID+'"  data-id="'+data.MID+'" >'+data.MenuName+'</td>';
						html+='<td class="text-center"><div class="checkbox '+levels[mLevel].checkBox+'"><input data-id="'+data.MID+'" data-parent-id="'+parent.MID+'"  data-crud-value="'+data.Crud.add+'" data-crud="add" id="chk_add_'+data.MID+'" type="checkbox" ><label for="chk_add_'+data.MID+'"></label></div></td>';
						html+='<td class="text-center"><div class="checkbox '+levels[mLevel].checkBox+'"><input data-id="'+data.MID+'" data-parent-id="'+parent.MID+'"  data-crud-value="'+data.Crud.view+'" data-crud="view" id="chk_view_'+data.MID+'" type="checkbox" ><label for="chk_view_'+data.MID+'"></label></div></td>';
						html+='<td class="text-center"><div class="checkbox '+levels[mLevel].checkBox+'"><input data-id="'+data.MID+'" data-parent-id="'+parent.MID+'"  data-crud-value="'+data.Crud.edit+'" data-crud="edit" id="chk_edit_'+data.MID+'" type="checkbox" ><label for="chk_edit_'+data.MID+'"></label></div></td>';
						html+='<td class="text-center"><div class="checkbox '+levels[mLevel].checkBox+'"><input data-id="'+data.MID+'" data-parent-id="'+parent.MID+'"  data-crud-value="'+data.Crud.delete+'" data-crud="delete" id="chk_delete_'+data.MID+'" type="checkbox" ><label for="chk_delete_'+data.MID+'"></label></div></td>';
						html+='<td class="text-center"><div class="checkbox '+levels[mLevel].checkBox+'"><input data-id="'+data.MID+'" data-parent-id="'+parent.MID+'"  data-crud-value="'+data.Crud.copy+'" data-crud="copy" id="chk_copy_'+data.MID+'" type="checkbox" ><label for="chk_copy_'+data.MID+'"></label></div></td>';
						html+='<td class="text-center"><div class="checkbox '+levels[mLevel].checkBox+'"><input data-id="'+data.MID+'" data-parent-id="'+parent.MID+'"  data-crud-value="'+data.Crud.excel+'" data-crud="excel" id="chk_excel_'+data.MID+'" type="checkbox" ><label for="chk_excel_'+data.MID+'"></label></div></td>';
						html+='<td class="text-center"><div class="checkbox '+levels[mLevel].checkBox+'"><input data-id="'+data.MID+'" data-parent-id="'+parent.MID+'"  data-crud-value="'+data.Crud.csv+'" data-crud="csv" id="chk_csv_'+data.MID+'" type="checkbox" ><label for="chk_csv_'+data.MID+'"></label></div></td>';
						html+='<td class="text-center"><div class="checkbox '+levels[mLevel].checkBox+'"><input data-id="'+data.MID+'" data-parent-id="'+parent.MID+'"  data-crud-value="'+data.Crud.print+'" data-crud="print" id="chk_print_'+data.MID+'" type="checkbox" ><label for="chk_print_'+data.MID+'"></label></div></td>';
						html+='<td class="text-center"><div class="checkbox '+levels[mLevel].checkBox+'"><input data-id="'+data.MID+'" data-parent-id="'+parent.MID+'"  data-crud-value="'+data.Crud.pdf+'" data-crud="pdf" id="chk_pdf_'+data.MID+'" type="checkbox" ><label for="chk_pdf_'+data.MID+'"></label></div></td>';
						html+='<td class="text-center"><div class="checkbox '+levels[mLevel].checkBox+'"><input data-id="'+data.MID+'" data-parent-id="'+parent.MID+'"  data-crud-value="'+data.Crud.restore+'"  data-crud="restore" id="chk_restore_'+data.MID+'" type="checkbox" ><label for="chk_restore_'+data.MID+'"></label></div></td>';
						html+='<td class="text-center"><div class="checkbox '+levels[mLevel].checkBox+'"><input data-id="'+data.MID+'" data-parent-id="'+parent.MID+'"  data-crud-value="'+data.Crud.showpwd+'" data-crud="showpwd" id="chk_showpwd_'+data.MID+'" type="checkbox" ><label for="chk_showpwd_'+data.MID+'"></label></div></td>';
					html+='</tr>';
					$('#tblroles').append(html);
					if(data.hasSubMenu==1){
						let t=await loadMenus(data.SubMenu,data,{datas,parent,data,i,old});
						old=t.old;
						datas=t.datas;
						data=t.data;
						parent=t.parent;
						i=t.i;
					}
				}
			}
			return old;
		}
		const loadCRUDs=async()=>{
			$('tr[data-has-submenu="0"][data-slug!="dashboard"] td .checkbox input[data-crud-value="0"]').prop('checked',false)
			$('tr[data-slug="dashboard"] td .checkbox input[data-crud="view"]').prop('checked',true)
			$('tr[data-has-submenu="0"] td .checkbox input[data-crud-value="0"]').attr('disabled','disabled')
			$('tr[data-slug="dashboard"] td .checkbox input[data-crud="view"]').attr('disabled','disabled')
		}
		const enableViewOptions=async()=>{
			$('tr td .checkbox input').each(function(){
				let id=$(this).attr('data-id');
				if($('#chk_view_'+id).prop('checked')==false){
					$('#chk_edit_'+id).attr('disabled','disabled');
					$('#chk_delete_'+id).attr('disabled','disabled');
					$('#chk_copy_'+id).attr('disabled','disabled');
					$('#chk_excel_'+id).attr('disabled','disabled');
					$('#chk_csv_'+id).attr('disabled','disabled');
					$('#chk_print_'+id).attr('disabled','disabled');
					$('#chk_pdf_'+id).attr('disabled','disabled');
					$('#chk_restore_'+id).attr('disabled','disabled');
					$('#chk_showpwd_'+id).attr('disabled','disabled');
					

					$('#chk_edit_'+id).prop('checked',false);
					$('#chk_delete_'+id).prop('checked',false);
					$('#chk_copy_'+id).prop('checked',false);
					$('#chk_excel_'+id).prop('checked',false);
					$('#chk_csv_'+id).prop('checked',false);
					$('#chk_print_'+id).prop('checked',false);
					$('#chk_pdf_'+id).prop('checked',false);
					$('#chk_restore_'+id).prop('checked',false);
					$('#chk_showpwd_'+id).prop('checked',false);
				}else{
					$('tr[data-has-submenu="0"] #chk_edit_'+id+'[data-crud-value="1"]').removeAttr('disabled');
					$('tr[data-has-submenu="0"] #chk_delete_'+id+'[data-crud-value="1"]').removeAttr('disabled');
					$('tr[data-has-submenu="0"] #chk_copy_'+id+'[data-crud-value="1"]').removeAttr('disabled');
					$('tr[data-has-submenu="0"] #chk_excel_'+id+'[data-crud-value="1"]').removeAttr('disabled');
					$('tr[data-has-submenu="0"] #chk_csv_'+id+'[data-crud-value="1"]').removeAttr('disabled');
					$('tr[data-has-submenu="0"] #chk_print_'+id+'[data-crud-value="1"]').removeAttr('disabled');
					$('tr[data-has-submenu="0"] #chk_pdf_'+id+'[data-crud-value="1"]').removeAttr('disabled');
					$('tr[data-has-submenu="0"] #chk_restore_'+id+'[data-crud-value="1"]').removeAttr('disabled');
					$('tr[data-has-submenu="0"] #chk_showpwd_'+id+'[data-crud-value="1"]').removeAttr('disabled');
					
					$('tr[data-has-submenu="1"] #chk_edit_'+id).removeAttr('disabled');
					$('tr[data-has-submenu="1"] #chk_delete_'+id).removeAttr('disabled');
					$('tr[data-has-submenu="1"] #chk_copy_'+id).removeAttr('disabled');
					$('tr[data-has-submenu="1"] #chk_excel_'+id).removeAttr('disabled');
					$('tr[data-has-submenu="1"] #chk_csv_'+id).removeAttr('disabled');
					$('tr[data-has-submenu="1"] #chk_print_'+id).removeAttr('disabled');
					$('tr[data-has-submenu="1"] #chk_pdf_'+id).removeAttr('disabled');
					$('tr[data-has-submenu="1"] #chk_restore_'+id).removeAttr('disabled');
					$('tr[data-has-submenu="1"] #chk_showpwd_'+id).removeAttr('disabled');

					
				}
			})
		}
		const updateCheckedStatus=async()=>{
			const updateStatus=(parentID,old={})=>{
				let elems=$('tr[data-parent-id="'+parentID+'"]');
				for(let i=0;i<elems.length;i++){
					let MID=elems[i].getAttribute('data-id');
					
					let t=updateStatus(MID,{MID,old,parentID,elems,i});
						old=t.old;
						parentID=t.parentID;
						elems=t.elems;
						i=t.i;
						MID=t.MID;
						if($('tr[data-parent-id="'+MID+'"]').length>0){

							let Add=($('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="add"]:checked').length==$('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="add"]').length)?true:false;
							let View=($('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="view"]:checked').length==$('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="view"]').length)?true:false;
							let Edit=($('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="edit"]:checked').length==$('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="edit"]').length)?true:false;
							let Delete=($('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="delete"]:checked').length==$('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="delete"]').length)?true:false;
							let Copy=($('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="copy"]:checked').length==$('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="copy"]').length)?true:false;
							let Excel=($('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="excel"]:checked').length==$('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="excel"]').length)?true:false;
							let CSV=($('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="csv"]:checked').length==$('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="csv"]').length)?true:false;
							let Print=($('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="print"]:checked').length==$('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="print"]').length)?true:false;
							let PDF=($('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="pdf"]:checked').length==$('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="pdf"]').length)?true:false;
							let Restore=($('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="restore"]:checked').length==$('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="restore"]').length)?true:false;
							let ShowPwd=($('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="showpwd"]:checked').length==$('tr[data-parent-id="'+MID+'"] td .checkbox input[data-crud-value="1"][data-crud="showpwd"]').length)?true:false;

							$('tr[data-id="'+MID+'"] td .checkbox input:not(:disabled)[data-crud="add"]').prop('checked',Add);
							$('tr[data-id="'+MID+'"] td .checkbox input:not(:disabled)[data-crud="view"]').prop('checked',View);
							$('tr[data-id="'+MID+'"] td .checkbox input:not(:disabled)[data-crud="edit"]').prop('checked',Edit);
							$('tr[data-id="'+MID+'"] td .checkbox input:not(:disabled)[data-crud="delete"]').prop('checked',Delete);
							$('tr[data-id="'+MID+'"] td .checkbox input:not(:disabled)[data-crud="copy"]').prop('checked',Copy);
							$('tr[data-id="'+MID+'"] td .checkbox input:not(:disabled)[data-crud="excel"]').prop('checked',Excel);
							$('tr[data-id="'+MID+'"] td .checkbox input:not(:disabled)[data-crud="csv"]').prop('checked',CSV);
							$('tr[data-id="'+MID+'"] td .checkbox input:not(:disabled)[data-crud="print"]').prop('checked',Print);
							$('tr[data-id="'+MID+'"] td .checkbox input:not(:disabled)[data-crud="pdf"]').prop('checked',PDF);
							$('tr[data-id="'+MID+'"] td .checkbox input:not(:disabled)[data-crud="restore"]').prop('checked',Restore);
							$('tr[data-id="'+MID+'"] td .checkbox input:not(:disabled)[data-crud="showpwd"]').prop('checked',ShowPwd);
						}
				}
				return old
			};
			updateStatus("");
		}
		const loadRoleData=async(data)=>{

            if(data.RoleName!=undefined){
                 $('#txtUserRoleName').val(data.RoleName);
            }
            if(data.CRUD!=undefined){
                var CRUD=data.CRUD;
                $.each(CRUD, function( KeyName, KeyValue ) {
                    $.each(KeyValue, function( SubKeyName, SubKeyValue ) {
						if($('input[data-id="'+KeyName+'"][data-crud="'+SubKeyName+'"]').attr('data-crud-value')=="1"){
							$('input[data-id="'+KeyName+'"][data-crud="'+SubKeyName+'"]').prop('checked',parseInt(SubKeyValue)==1?true:false);
							$('input[data-id="'+KeyName+'"][data-crud="'+SubKeyName+'"]').attr('data-value',SubKeyValue);
						}else{
							$('input[data-id="'+KeyName+'"][data-crud="'+SubKeyName+'"]').prop('checked',false);
							$('input[data-id="'+KeyName+'"][data-crud="'+SubKeyName+'"]').attr('data-value',0);
						}
                    });
                });

            }
			updateCheckedStatus();
			enableViewOptions();
			updateCheckedStatus();
		}
		const getRoleData=async()=>{
			let RoleID="<?php if($isEdit){ echo $EditData[0]->RoleID;} ?>";
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/users-and-permissions/user-roles/json/"+RoleID,
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:false,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:async function(response){
					loadRoleData(response[0]);
                }
            });
		}
		const getData=()=>{
			let UserRightsData={};
			const getUserRights=(parentID,old={})=>{
				let elems=$('tr[data-parent-id="'+parentID+'"]');
				for(let i=0;i<elems.length;i++){
					let MID=elems[i].getAttribute('data-id');
					
					let t=getUserRights(MID,{MID,old,parentID,elems,i});
						old=t.old;
						parentID=t.parentID;
						elems=t.elems;
						i=t.i;
						MID=t.MID;
						let tmp={add:0,view:0,edit:0,delete:0,copy:0,excel:0,csv:0,print:0,pdf:0,restore:0,showpwd:0}

						$('tr[data-id="'+MID+'"] td .checkbox input:not(:disabled)').each(function(){
							let crud=$(this).attr('data-crud');
							tmp[crud]=$('tr[data-id="'+MID+'"] td .checkbox input:not(:disabled)[data-crud="'+crud+'"]').prop('checked')?1:0;
						});
						if(elems[i].getAttribute('data-slug')=="dashboard"){
							tmp.view=1;
						}
					if(elems[i].getAttribute('data-has-submenu')=="0"){
						UserRightsData[MID]=tmp;
					}
					
				}
				return old
			};
			getUserRights(""); 
			let formData={};
			formData['RoleName']= $('#txtRoleName').val();
			formData['CRUD']= JSON.stringify(UserRightsData);
			return formData;
		}
        const FormValidation=async(data)=>{
            var status=true;
            if(data['RoleName']==""){
                $('#txtRoleName-err').html("The User Role  is required");status=false;
            }
			if(status==false){
				document.body.scrollTop = 0; // For Safari
				document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
			}
            return status;
        }
		$(document).on('click','tr td .checkbox input[data-crud="view"]',function(){
			enableViewOptions();
		})
		$(document).on('click','tr[data-has-submenu="0"] td .checkbox input',function(){
			updateCheckedStatus();
		})
		$(document).on('click','tr[data-has-submenu="1"] td .checkbox input',function(){
			let MID=$(this).attr('data-id');
			let crud=$(this).attr('data-crud');
			let checkStatus=$(this).prop('checked');
			const updateStatus=(parentID,crud,status,old={})=>{
				$('tr[data-has-submenu="0"][data-parent-id="'+parentID+'"] td .checkbox input[data-crud-value="1"][data-crud="'+crud+'"]').prop('checked',status);
				$('tr[data-has-submenu="1"][data-parent-id="'+parentID+'"] td .checkbox input[data-crud="'+crud+'"]').prop('checked',status);
				let elems=$('tr[data-parent-id="'+parentID+'"]');
				for(let i=0;i<elems.length;i++){
					let MID=elems[i].getAttribute('data-id');
					let t=updateStatus(MID,crud,status,{parentID,crud,status,MID,elems,i,old});
					parentID=t.parentID;
					crud=t.crud;
					status=t.status;
					MID=t.MID;
					elems=t.elems;
					i=t.i;
					old=t.old;
				}
				return old;

			};
			updateStatus(MID,crud,checkStatus);
			if(crud=="view"){
				enableViewOptions();
			}
		})
		$(document).on('click','#btnSubmit',async function(){
			let formData=getData();
			let Status=await FormValidation(FormData);
			if(Status==true){
				@if($isEdit==true)
					var submiturl="{{ url('/') }}/admin/users-and-permissions/user-roles/edit/{{$EditData[0]->RoleID}}";
				@else
					var submiturl="{{ url('/') }}/admin/users-and-permissions/user-roles/create";
				@endif
				swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this User Role!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },
                function(){
                	swal.close();
					btnLoading($('#btnSubmit'));
					$.ajax({
						type:"post",
						url:submiturl,
						headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
						data:formData,
						error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
						complete: function(e, x, settings, exception){btnReset($('#btnSubmit'));},
						success:function(response){
							if(response.status==true){
								swal({
									title: "Success",
									text: response.message,
									type: "success",
									showCancelButton: false,
									confirmButtonClass: "btn-outline-primary",
									confirmButtonText: "OK",
									closeOnConfirm: false
								},function(){
									@if($isEdit==true)
										window.location.replace("{{ url('/') }}/admin/users-and-permissions/user-roles/");
									@else
										window.location.reload();
									@endif
									
								});
							}else{
								if(response['errors']!=undefined){
									$('.errors').html('');
									$.each( response['errors'], function( KeyName, KeyValue ) {
										var key=KeyName;
										if(key=="RoleName"){$('#txtRoleName-err').html(KeyValue[0]);}
										
									});
									document.body.scrollTop = 0; // For Safari
									document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
	                            }
							}
						}
					});
                });
			
			}
		});
		init();
	});
</script>
@endsection