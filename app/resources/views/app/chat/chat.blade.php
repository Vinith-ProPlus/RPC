@extends('layouts.chat')
@section('content')
<style>
	.select2-container .select2-selection__rendered img {
		display: inline-block;
		vertical-align: middle;
	}
	.chatModal {
		font-family: "Poppins", sans-serif;
		width: 60% !important;
		max-width: 95% !important;
		margin: auto;
		position: fixed;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	.wzdQuote ul.anchor li {
		position: relative;
		display: block;
		margin: 0;
		padding: 10px 0px;
		float: left;
		clear: both;
		width: 100%;
		box-sizing: border-box;
		z-index: 0;
		background-color: #eae7e7;
		transition: background-color 0.3s;
		border: rgb(81, 83, 76)
	}

	.wzdQuote ul.anchor li.active {
		background-color: #0b8abd;
	}

	.wzdQuote ul.anchor li a {
		color: #000000;
	}

	.wzdQuote ul.anchor li.active::after {
		content: '';
		position: absolute;
		right: 0;
		top: 50%;
		transform: translateY(-50%) rotate(225deg);
		width: 10px;
		height: 10px;
		background-color: #eae7e7;
		clip-path: polygon(0 0, 100% 0, 100% 100%);
	}
    .btnCheckboxProduct {
        width: 1.5em;
        height: 1.5em;
        border: 1px solid #000;
        transform: scale(1.2);
		cursor: pointer;
    }

</style>
<link rel="stylesheet" href="{{url('/assets/css/chat.css')}}">
<div class="container-fluid pt-10">
	<div class="row d-none d-md-flex">
		<div class="col call-chat-sidebar col-sm-12">
			<div class="card">
				<div class="card-body chat-body">
					<div class="chat-box">
						<!-- Chat left side Start-->
						<div class="chat-left-aside">
							<div >
								<div class="about">
									<div class="name f-w-600">All Contacts (<span class="spaTotalContacts">0</span>)</div>
								</div>
								<div class="search pt-10">
									<div class="mb-3">
										<div class="input-group">
											<input class="form-control" type="text" placeholder="search" id="txtSearch">
											<button class="btn btn-dark pl-10 pr-10" id="btnSearch"><span class="fa fa-search"></span></button>
										</div>
									</div>
								</div>
							</div>
							<div class="people-list" id="people-list">
								<ul class="list mt-10">
								</ul>
							</div>
						</div>
						<!-- Chat left side Ends-->
					</div>
				</div>
			</div>
		</div>
		<div class="col call-chat-body " >
			<div class="card">
				<div class="card-body p-0" >
					<div class="row chat-box">
						<!-- Chat right side start-->
						<div class="col pe-0 chat-right-aside">
							<!-- chat start-->
							<div class="chat">
								<!-- chat-header start-->
								<div class="chat-header  clearfix">
									<div class="row">
										<div class="col-7">
											<div class="name"> <span class="name-info">Anandhan AS</span> <span class="last-seen">last seen <span>today at 02:50 PM</span></span></div>
											<div class="member">Members since : <span class="member-since">11 months</span></div>
											<div class="location">Coimbatore, Tamil Nadu, India</div>
										</div>
										<div class="col-5">
											<div class="mobile-number"> <span>7708679203</span> <a href="tel:7708679203" class="btn btn-sm btn-dark ml-30">Call now</a></div>
											<div class="email">anand@propluslogics.com</div>
										</div>
									</div>
								</div>
								<!-- chat-header end-->
								<div class="chat-history chat-msg-box custom-scrollbar">
									<div class="load-chat-more show"><a href="#">Load More</a></div>
									<ul></ul>
								</div>
								<!-- end chat-history-->
								<div class="chat-message clearfix shadow">
									<div class="row chat-input">
										<div class="col-12 d-flex">
											<div class="input-group ">
												<div class="input-group-text"><div class="chat-opt btnSendQuote" id="btnSendQuote" data-bs-toggle="modal" data-bs-target="#quoteModal"><div class="chat-opt-icon" ><img src="data:image/png;base64,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" alt=""></div><div class="chat-opt-name">Quotation</div></div></div>
												<div class="input-group-text"><div class="chat-opt btnSendProduct" id="btnSendProduct" data-bs-toggle="modal" data-bs-target="#productModal"><div class="chat-opt-icon" ><img src='data:image/png;base64,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'/></div><div class="chat-opt-name">Products</div></div></div>
												<div class="input-group-text"><div class="chat-opt btnSendAttachment" id="btnSendAttachment"><div class="chat-opt-icon" ><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB8AAAAbCAYAAACEP1QvAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAKbSURBVHgBxZfNchJBEMe7Z0MlpWAwJ2+ueNDoJXkDuHnkQ6u8BZ7A8gkgT6BvQHI2hH0DeAROVi6B9eYtq5AqlDBj9+4OrCtbC2HBfxXF9MzO/Jju2e4B4Z56aL47Eig/Iarez/7lx+BY2izmEY06IByRmaWPTZ/uRE5Px7Zl6+cQ7iEXLGTHXxiknB7f2laP249y5boCbERMdUBCbWi3LDYErKgwmGSnvJ3FgcGdI6DJa6wMXwQmVxYc23IWgC0aezbst1BJLAAoW/8ADhc3lnZ7FJhj+A9Ywflw0KoG52fNojkVxkDbE6XMpXaeMSvFKHAmV2nGgVkOHzQFXW2nlDyOhWeeV04oOO0oMNnVMJhPe8YsFuPWFrFgBWeBrlgwz0FhdEAY7XSu3NDD7HYKcl7bktYSSYODcxDwqQZPhegE1+JXE9cFU7xPR/2LRtScPWp4YDT1AL8FvJbYNhhQ1XSWw22Dh9eXs2fxf4Fn8HAC2AaY5cY8fBKDmWtTYHcoY5arILAZBpM3suSNm02BvZ0jngQA5/ok3oFbi/01oJc0mLXjF3wPLu+s+QD0prqfnqHYtwlcTArM4pjrnA36QsDiMhksBKREwRruaIPjHBw01LREu7aCfUq516FFYIfr9rJgD07x1MZEiGpwkHc/um6V3MuAVDX+Hg1aC8FSisLIvujCCkKuPFQA6r5tG3Qfc10eoXmR+Bt8a3/pwYoSO1J+hrnrOdk0w+7fBJhljJ2rcerx61+U6t74fS8Vive7B4c/UvsvYOJcfd8j6IODVx8kijMCP0kCzJrl9nTuLblf1ZectzaYZejG75uv3d39w2/ee4/ZqAmccKQSpXXB7lrhDjeuIPKKMh/O/nEom7JfDyXdWPwLfxL6A2iVQ8AcyGlDAAAAAElFTkSuQmCC'/></div></div></div>
												<input type="text" placeholder="Type your message" id="txtMessage" class="form-control">
												<div class="input-group-text">
													<a class="btnSendMessage" id="btnSendMessage" style="display:none"><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAATCAYAAACdkl3yAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAADlSURBVHgBpZOBEYIwEAQvYgGUkA60BKhASqAVO9AKsASpgJEGtAPsQBrQeCFBBEcC4WZ+COR/uTwPVIGUIbFU6oKKoVSJbAlwhRdyQ0TKu8oXuGKce088gRp0Y9Q/OzOBoqkpUbAwcmSe8MRexLjjjyMwIYdLDofGUYGQSVcuJaZq4FD0XqqBwNaG5O6GodehEwiHLDyh42wkrRaDAtm4CehEr5V1NgLgHB55PbQ9krqRmK4OEJvRWduNxBfQyoAC7HgML0ArYT/9wxfw7ShaAuhA/WPNBnQg8495Az5ijxI7Q4v0BlVBdW4a0d5nAAAAAElFTkSuQmCC'/></a>
												</div>
												
											</div>
										</div>
										
										<div style="display:none">
											<input type="file" id="txtAttachments" accept=".jpg, .jpeg, .png, .gif, .bmp, .tiff, .tif, .webp, .svg, .heic', .heif, .ico, .jfif, .doc, .docx, .xls, .xlsx, .pdf">
										</div>
									</div>
									<div class="row blocked-content">
										<div class="col-12">Can't send a message to blocked contact</div>
									</div>
								</div>
								<!-- end chat-message-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade chatModal" id="quoteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="quoteModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg modal-fullscreen-lg-down">
		<div class="modal-content">
			<div class="modal-header bg-dark">
				<h1 class="modal-title fs-14" id="staticBackdropLabel">Quotation</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="wizard-4 wzdQuote" id="">
					<ul class="anchor">
					  <li class="btnQuoteStep active"><a href="#step-1" class="py-4 ">1. Select Product</a></li>
					  <li class="btnQuoteStep"><a href="#step-2" class="py-4">2. Terms and Conditions </a></li>
					  <li class="btnQuoteStep"><a href="#step-3" class="py-4">3. Verify Details</a></li>
					  <li class="btnQuoteStep"><a href="#step-4" class="py-4">4. Generate PDF</a></li>
					</ul>
					
					<div class="step-container" style="height: 295px;">
						<div id="step-1" class="content" style="left: 0px;">
							<div class="col-sm-12 ps-0">
								<div class="form-group">
								  <label for="lstQProducts">Products</label>
								  <select  class="form-control select2" id="lstQProducts" data-selected="">
									<option value="">Select a Product</option>
									@foreach ($Products as $item)
										<option value="{{$item->ProductID}}" data-image="{{$item->ProductImage}}">{{$item->ProductName}}</option>										
									@endforeach
								  </select>
									<span class="errors" id="lstQProducts-err"></span>
								</div>
							</div>
						</div>
						<div id="step-2" class="content" style="display: none;">
							<div class="col-sm-12">
								<form class="theme-form my-5">
									<div class="mb-3 row form-group justify-content-center">
									  <label class="col-sm-3 col-form-label" for="txtDiscount">Discount</label>
									  <div class="col-sm-6">
										<input type="number" class="form-control" id="txtDiscount">
									  </div>
									</div>
									<div class="mb-3 row form-group justify-content-center">
										<label class="col-sm-3 col-form-label" for="txtSCharges">Shipping Charges</label>
									  <div class="col-sm-6">
										<input type="number" class="form-control" id="txtSCharges">
									  </div>
									</div>
									<div class="mb-3 row form-group justify-content-center">
										<label class="col-sm-3 col-form-label" for="dtpExpDelivery">Expected Delivery</label>
									  <div class="col-sm-6">
										<input class="form-control" id="dtpExpDelivery" type="number" placeholder="Contact">
									  </div>
									</div>
									<div class="mb-3 row form-group justify-content-center">
										<label class="col-sm-3 col-form-label" for="txtPaymentTerms">Payment terms</label>
									  <div class="col-sm-6">
										<input class="form-control" id="txtPaymentTerms" type="text" placeholder="Company name">
									  </div>
									</div>
									<div class="mb-3 row form-group justify-content-center">
										<label class="col-sm-3 col-form-label" for="txtDescription">Additional Info</label>
									  <div class="col-sm-6">
										<textarea  id="txtDescription" cols="30" rows="3"></textarea>
									  </div>
									</div>
								  </form>
							</div>
						</div>
						<div id="step-3" class="content" style="display: none;">
							<div class="col-sm-12 ps-0">
								Step 3
							</div>
						</div>
						<div id="step-4" class="content" style="display: none;">
							<div class="col-sm-12 ps-0">
								Step 4
							</div>
						</div>
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" id="btnPrevious" class="btn btn-secondary" data-bs-dismiss="modal">Previous</button> 
				<button type="button" id="btnNext" class="btn btn-primary">Next</button>
			</div>			
		</div>
	</div>
</div>
<div class="modal fade chatModal" id="productModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg modal-fullscreen-lg-down">
		<div class="modal-content">
			<div class="modal-header bg-dark">
				<h1 class="modal-title fs-14" id="staticBackdropLabel">Send Product Details</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row justify-content-center">
					<div class="col-sm-11 my-2">
						<div class="row">
							<div class="col-sm-4">
							  <div class="form-group">
								<select  class="form-control" id="lstPCategory">
								  <option value="">Select a Product Category</option>
								  @foreach ($PCategory as $item)
									  <option value="{{$item->PCID}}">{{$item->PCName}}</option>
								  @endforeach
								</select>
								  <span class="errors" id="lstPCategory-err"></span>
							  </div>
							</div>
							<div class="col-sm-4">
							  <div class="form-group">
								<select  class="form-control" id="lstPSCategory">
								  <option value="">Select a Product Sub Category</option>
									@foreach ($PSCategory as $item)
										<option value="{{$item->PSCID}}" data-pcid="{{ $item->PCID }}">{{$item->PSCName}}</option>
									@endforeach
								</select>
								  <span class="errors" id="lstPSCategory-err"></span>
							  </div>
							</div>
							<div class="col-sm-4">
							  <div class="form-group">
								<input type="text" class="form-control" name="" id="txtProducts" placeholder="Search any Product">
								  <span class="errors" id="txtProducts-err"></span>
							  </div>
							</div>
						</div>
					</div>
					<div class="row my-5">
						@foreach ($Products as $item)
							<div class="col-sm-6 divProduct" data-pcid="{{ $item->PCID }}" data-pscid="{{ $item->PSCID }}" data-product="{{ $item->ProductName }}" data-desc="{{ $item->Description }}">
								<div class="card" style="width: 100%;">
									<div class="row align-items-center justify-content-start">
										<div class="col-auto text-start">
											<input type="checkbox" name="selectedProducts[]" value="{{ $item->ProductID }}" class="form-check-input btnCheckboxProduct">
										</div>
										<div class="col-auto">
											@if($item->ProductImage)
												<img src="{{ $item->ProductImage }}" alt="Product Image" class="me-2" style="width: 120px; height: 100px; object-fit: cover;">
											@endif
										</div>
										<div class="col">
											<span>{{ $item->ProductName }}</span>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
				<div id="no-products-message" class="text-center my-3" style="display: none;">
					<p>No products found matching your criteria.</p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" id="btnCancelSendProducts" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="btnSendProducts">Send</button>
			</div>			
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script>
	
</script>
<script>
	$(document).ready(function(){
		var chatList=[];
		var activeChatID="";
		var messageTo="";var messageFrom="";
		var pageLimit=20;
		var pageNo=1;
		var isLoadMore=false;
		const init=async()=>{
			pusherInit();
			getChatList();
			chatListPositionChange();
			detectChatTimeChange();
			//$('#btnSendProduct').click();
			$('#lstPCategory, #lstPSCategory').select2({
				dropdownParent: $('#productModal'),
			});

		}
		const pusherInit=async()=>{
			Pusher.logToConsole = false;
	
			var pusher = new Pusher("{{config('app.PUSHER_APP_KEY')}}", {
				cluster: "ap2",
			});
			var channel = pusher.subscribe("rpc-chat-582");
				channel.bind('Admin', async function(data) {
					try {
						data.message=JSON.parse(data.message);
						if(data.message.type=="load_message" && activeChatID==data.message.ChatID){
							for(let item of data.message.message){
								addChatMessages(item,true);
							}
						}else if(data.message.type=="update_last_seen"  && activeChatID==data.message.ChatID){
							$('.chat-box .chat-right-aside .chat .chat-header .name .last-seen > span').attr('data-time',data.message.message);
							lastSeenFormat();
						}
					} catch (error) {
						console.log(error);
					}
				})
		}
		const lastSeenFormat=async()=>{
			// Get the data-time attribute from the specified element
			let elementTime = $('.chat-box .chat-right-aside .chat .chat-header .name .last-seen > span').attr('data-time');
    
			// Check if elementTime exists and is valid
			if (!elementTime) return "No last seen time available";

			// Convert elementTime to a Date object
			const date = new Date(elementTime);

			// Call the formatDate function for custom formatting
			let  formattedDate = "";
			const now = new Date();
			const diffTime = now - date;
			const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
			const options = { hour: 'numeric', minute: '2-digit', hour12: true };
			const formattedTime = date.toLocaleTimeString('en-US', options).toUpperCase();

			if (diffDays === 0) {
				formattedDate= `Today ${formattedTime}`;
			} else if (diffDays === 1) {
				formattedDate= `Yesterday ${formattedTime}`;
			} else if (diffDays < 7) {
				const weekday = date.toLocaleDateString('en-US', { weekday: 'short' });
				formattedDate =`${weekday} ${formattedTime}`;
			} else {
				const formattedDate = date.toLocaleDateString('en-US', { year: '2-digit', month: '2-digit', day: '2-digit' });
				formattedDate =`${formattedDate} ${formattedTime}`;
			}
			
			// Set or display the formatted last seen time
			$('.chat-box .chat-right-aside .chat .chat-header .name .last-seen > span').html(`${formattedDate}`);
		}
		const getChatList=async()=>{
			
			const getList=async()=>{
				$.ajax({
					type:"post",
					url:"{{route('admin.chat.get.chat-list')}}",
					headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
					dataType:"json",
					async:true,
					success:function(response){
						$('.spaTotalContacts').html(response.length)
						$('#people-list > ul').html('')
						loadChatList(response);
					}
				});
			}
			const loadChatList=async(chatData)=>{
				tmpChatList=[];
				const checkChatList=async(chatID)=>{
					return $('#people-list > ul > li[data-id="'+chatID+'"]').length>0;
				}
				const getHtmlContent=async(data)=>{
					let content='';
						content+='<div class="people-details">';
							content+='<div class="icon" data-read-status="'+data.isRead+'"><span></span></div>';
							content+='<div class="name">'+data.sendFromName+' <span class="mobile-number">- '+data.MobileNumber+'</span></div>';
							content+='<div class="full-right">';
								content+='<div class="options dropdown" >';
									content+='<span data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></span>';
									content+='<ul class="dropdown-menu">';
										content+='<li><a class="dropdown-item btnDeleteChat" href="#" data-id="'+data.ChatID+'"> <i class="fa fa-trash"></i> Delete</a></li>';
										if(data.Status=="Blocked"){
											content+='<li><a class="dropdown-item btnUnblock" href="#" data-id="'+data.ChatID+'"> <i class="fa fa-repeat fa-flip-horizontal"></i> Unblock</a></li>';
										}else{
											content+='<li><a class="dropdown-item btnBlock" href="#" data-id="'+data.ChatID+'"> <i class="fa fa-ban"></i> Block</a></li>';
										}
										
									content+='</ul>';
								content+='</div>';
							content+='</div>';
						content+='</div>';
						content+='<div class="locations">'+data.DistrictName+", "+data.StateName+'</div>';
						content+='<div class="last-msg">'+data.LastMessage+'</div>';
						content+='<div class="timestamp">'+data.LastMessageOnHuman+'</div>';
					return content;
				}
				for(let data of chatData){
					tmpChatList.push(data.ChatID);
					let status=await checkChatList(data.ChatID);
					let htmlContent=await getHtmlContent(data);
					if(status){
						$('#people-list > ul > li[data-id="'+data.ChatID+'"]').html(htmlContent);
					}else{
						$('#people-list > ul').append('<li data-send-from="'+data.sendFromID+'" data-status="'+data.Status+'" data-send-to="'+data.sendTo+'" data-chat-name="'+data.sendFromName +' - '+data.MobileNumber+'" class="clearfix" data-id="'+data.ChatID+'" data-time="'+data.LastMessageOn+'">'+htmlContent+'</li>');
					}
				}
				chatListPositionChange();
				detectChatTimeChange();
			}
			getList();
		}
		const detectChatTimeChange=async()=>{
			const debounce = (func, delay) => {
				let timeout;
				return function(...args) {
					const context = this;
					clearTimeout(timeout);
					timeout = setTimeout(() => func.apply(context, args), delay);
				};
			};

			const handleChange = debounce((mutations) => {
				mutations.forEach(mutation => {
					if (mutation.type === 'attributes' && mutation.attributeName === 'data-time') {
						chatListPositionChange();
					}
				});
			}, 300); // Adjust the delay as needed

			const observer = new MutationObserver(handleChange);

			// Observe each chat message for attribute changes
			const messages = document.querySelectorAll('#people-list > ul > li');
			messages.forEach(message => {
				observer.observe(message, {
					attributes: true // Observe attribute changes
				});
			});
		}
		const chatListPositionChange=async()=>{
			const chatList = document.querySelector('#people-list > ul');
			const messages = Array.from(chatList.children);

			// Sort messages based on data-chat-time
			messages.sort((a, b) => {
				return new Date(b.getAttribute('data-time')) - new Date(a.getAttribute('data-time'));
			});
			// Insert sorted messages back into the list
			messages.forEach((message, index) => {
				chatList.insertBefore(message, chatList.children[index]);
			});
		}
		const searchChatList=async()=>{
			let search=$('#txtSearch').val().toString().toLowerCase();
			if(search==""){
				$('#people-list > ul > li').show(100)
			}else{
				const listItems = document.querySelectorAll('#people-list > ul > li');
				Array.from(listItems).forEach((item) => {
					const chatName = item.getAttribute('data-chat-name').toLowerCase();
					if (chatName.includes(search)) {
						$(item).show(100);
					} else {
						$(item).hide(100);
					}
				});
			}
		}
		const getChatAccountDetails=async()=>{
			$.ajax({
				type:"post",
				url:"{{route('admin.chat.get.account-details','_chatID_')}}".replace('_chatID_',activeChatID),
				headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				dataType:"json",
				async:true,
				success:function(response){
					if(response.length>0){
						response=response[0];
						let Address=response.DistrictName+", "+response.StateName+", "+response.CountryName;
						$('.chat-right-aside .name span.name-info').html(response.sendFromName);
						$('.chat-right-aside .name span.last-seen > span').attr('data-time',response.SenderLastSeenOn);
						$('.chat-right-aside .member span.member-since').html(response.RegisteredOnHuman);
						$('.chat-right-aside .location').html(Address);

						$('.chat-right-aside .mobile-number span').html(response.MobileNumber);
						$('.chat-right-aside .mobile-number a').attr('href','tel:'+response.MobileNumber);
						$('.chat-right-aside .email').html(response.email);
						lastSeenFormat();
					}
					
				}
			});
		}
		const chatScrollDown=async(isSmooth=false)=>{
			// Scroll to the bottom smoothly
			const el = document.querySelector('.chat-history.chat-msg-box');
			let opts={top: el.scrollHeight}
			if(isSmooth){
				opts.behavior= 'smooth';
			}
			el.scrollTo(opts);
		}
		const chatPositionMove=async(MessageID)=>{
			if(MessageID){
				// Find the element you want to scroll to
				const targetElement = $(`.chat-box .chat-right-aside .chat .chat-msg-box > ul > li[data-id="${MessageID}"]`);
				const HeaderElement=$(`.chat-box .chat-right-aside .chat .chat-header`);

				// Calculate the offset position of the target element within its scrollable container
				const offsetTop = targetElement.position().top - (HeaderElement.innerHeight() +50);

				// Scroll the parent container to the target element's position
				$('.chat-box .chat-right-aside .chat .chat-msg-box').scrollTop(offsetTop);
			}
		}
		const getChatHistory=async(MessageID="",isScrollDown=false,scrollTo=null)=>{
			$.ajax({
				type:"post",
				url:"{{route('admin.chat.get.chat-history','_chatID_')}}".replace('_chatID_',activeChatID),
				headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:{MessageID,pageLimit,pageNo},
				dataType:"json",
				async:true,
				beforeSend:async()=>{
					$(".load-chat-more a").html('<i class="fa fa-spinner fa-spin"> </i> Loading')
					$(".load-chat-more").removeClass('show').addClass('show');
				},
				complete:async()=>{$(".load-chat-more a").html('Load More');},
				success:async(response)=>{
					isLoadMore=response.isLoadMore;
					if(response.isLoadMore){
						$(".load-chat-more").removeClass('show').addClass('show');
					}else{
						$(".load-chat-more").removeClass('show');
					}
					for(let data of response.chat){
						await addChatMessages(data);
					}
					if(isScrollDown){
						chatScrollDown();
					}
					pageNo++;
					setInterval(updateTimeElements, 60000);
					if(scrollTo!=null && scrollTo!=""){
						chatPositionMove(scrollTo);
					}
				}
			});
		}
		const addChatMessages=async(data,isAppend=false)=>{ 
			let html='';
			if(data.Type=="Attachment"){
				let attchmentType=await getFileType(data.Attachments);
				let fileName=data.Attachments.split("/").pop();
				if(attchmentType=="PDF"){
					html = `<li data-id="${data.SLNO}" class="clearfix ${data.MType === "sender" ? "sender" : "reply"}" data-time="${data.CreatedOn}"><div class="message ${data.MType === "sender" ? "my-message" : "other-message pull-right"}"><p class="pdf"><a href="${data.Attachments}" target="_blank" download><span class="icon"></span>${fileName}</a></p><span class="time" data-time="${data.CreatedOn}">${data.CreatedOnHuman}</span></div></li>`;
				}else if(attchmentType=="Image"){
					html = `<li data-id="${data.SLNO}" class="clearfix ${data.MType === "sender" ? "sender" : "reply"}" data-time="${data.CreatedOn}"><div class="message ${data.MType === "sender" ? "my-message" : "other-message pull-right"}"><p class="attachment-img"><a href="${data.Attachments}" target="_blank" download><img src="${data.Attachments}" alt="${fileName}"></a></p><span class="time" data-time="${data.CreatedOn}">${data.CreatedOnHuman}</span></div></li>`;
				}else{
					html = `<li data-id="${data.SLNO}" class="clearfix ${data.MType === "sender" ? "sender" : "reply"}" data-time="${data.CreatedOn}"><div class="message ${data.MType === "sender" ? "my-message" : "other-message pull-right"}"><p class="pdf"><a href="${data.Attachments}" target="_blank" download>${fileName}</a></p><span class="time" data-time="${data.CreatedOn}">${data.CreatedOnHuman}</span></div></li>`;
				}
			}else if(data.Type=="Quotation"){
				let attchmentType=await getFileType(data.Attachments);
				let fileName=data.Attachments.split("/").pop();
				html = `<li data-id="${data.SLNO}" class="clearfix ${data.MType === "sender" ? "sender" : "reply"}"><div class="message ${data.MType === "sender" ? "my-message" : "other-message pull-right"}"><p class="pdf"><a href="${data.Attachments}" target="_blank" download><span class="icon"></span>${fileName}</a></p><span class="time" data-time="${data.CreatedOn}">${data.CreatedOnHuman}</span></div></li>`;
			}else if(data.Type=="Products"){
				try {
					data.Attachments=JSON.parse(data.Attachments)
					for(let product of data.Attachments){
						let ProductUrl="{{route('guest.product.view','_productID_')}}".replace("_productID_",product.ProductID);
						html+=`<li data-id="${data.SLNO}" class="clearfix ${data.MType === "sender" ? "sender" : "reply"}">`;
							html+=`<div class="message ${data.MType === "sender" ? "my-message" : "other-message pull-right"}">`;
								html+=`<div>`;
									html+=`<div class="product">`;
										html+=`<div class="product-img"><img src="${product.ProductImage}" alt="${product.ProductName}"></div>`;
										html+=`<div class="product-infos">`;
											html+=`<div class="product-name">${product.ProductName}</div>`;
											html+=`<div class="product-desc">${product.Description}</div>`;
										html+=`</div>`;
										html+=`<div class="product-view"><a href="${ProductUrl}" target="_blank">View Product</a></div>`;
									html+=`</div>`;
								html+=`</div>`;
								html+=`<span class="time" data-time="${data.CreatedOn}">${data.CreatedOnHuman}</span>`;
							html+=`</div>`;
						html+=`</li>`;
					}
				} catch (error) {
					console.log(error)
				}
			}else{
				html = `<li data-id="${data.SLNO}" class="clearfix ${data.MType === "sender" ? "sender" : "reply"}"><div class="message ${data.MType === "sender" ? "my-message" : "other-message pull-right"}"><p>${data.Message}</p><span class="time" data-time="${data.CreatedOn}">${data.CreatedOnHuman}</span></div></li>`;
			}
			if(isAppend){
				$('.chat-history.chat-msg-box ul').append(html);
			}else{
				$('.chat-history.chat-msg-box ul').prepend(html);
			}
			
		}
		const sendMessage=async(type="Text",message="",attachments={})=>{
			$.ajax({
				type:"post",
				url:"{{route('admin.chat.send.message','_chatID_')}}".replace('_chatID_',activeChatID),
				headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:{message,type,messageTo,messageFrom,attachments:JSON.stringify(attachments)},
				async:true,
				success:async(response)=>{
					$('#txtMessage').val('');
					
					if(response.status && response.SLNO!=""){
						//getChatHistory(response.SLNO,true)
							
						if(response.LastMessage!=""){
							$('.people-list ul.list > li[data-id="'+activeChatID+'"] .last-msg').html(response.LastMessage)
						}
							
						$('.people-list ul.list > li[data-id="'+activeChatID+'"] .timestamp').html(response.LastMessageOnHuman)
						$('.people-list ul.list > li[data-id="'+activeChatID+'"]').attr('data-time',response.LastMessageOn);
					}
				}
			});
			return true
		}
		const sendAttachment=async(attachment)=>{
			let formData=new FormData();
			formData.append('message',"");
			formData.append('type',"Attachment");
			formData.append('messageTo',messageTo);
			formData.append('messageFrom',messageFrom);
			formData.append('attachments',attachment);
			$.ajax({
				type:"post",
				url:"{{route('admin.chat.send.attachment','_chatID_')}}".replace('_chatID_',activeChatID),
				headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:formData,
				async:true,
                cache: false,
                processData: false,
                contentType: false,
				success:async(response)=>{
					$('#txtMessage').val('');
					if(response.status && response.SLNO!=""){
						//getChatHistory(response.SLNO,true)
						if(response.LastMessage!=""){
							$('.people-list ul.list > li[data-id="'+activeChatID+'"] .last-msg').html(response.LastMessage)
						}
						$('.people-list ul.list > li[data-id="'+activeChatID+'"] .timestamp').html(response.LastMessageOnHuman)
						$('.people-list ul.list > li[data-id="'+activeChatID+'"]').attr('data-time',response.LastMessageOn);
					}
				}
			});
		}
		const timeAgo=(date)=> {
			const seconds = Math.floor((new Date() - date) / 1000);
			const intervals = [
			{ label: "yr", plural: "yrs", seconds: 31536000 },
			{ label: "mo", plural: "mos", seconds: 2592000 },
			{ label: "d", plural: "d", seconds: 86400 },
			{ label: "hr", plural: "hrs", seconds: 3600 },
			{ label: "min", plural: "mins", seconds: 60 },
			{ label: "sec", plural: "secs", seconds: 1 },
			];

			for (const interval of intervals) {
			const count = Math.floor(seconds / interval.seconds);
			if (count >= 1) {
				return `${count} ${count > 1 ? interval.plural : interval.label} ago`;
			}
			}
			return "just now";
		}
		const updateTimeElements=async()=>{
			document.querySelectorAll('.chat-history.chat-msg-box ul .time').forEach(el => {
				const dataTime = el.getAttribute('data-time');
				const time = new Date(dataTime);
				el.textContent =  timeAgo(time);
			});
		}
		const getFileType=async(url)=> {
			// Get the file extension
			var extension = url.split('.').pop().toLowerCase();

			// Check the file type based on the extension
			if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'tif', 'webp', 'svg', 'heic', 'heif', 'ico', 'jfif'].includes(extension)) {
				return 'Image';
			} else if (['pdf'].includes(extension)) {
				return 'PDF';
			} else if (['doc', 'docx', 'xls', 'xlsx'].includes(extension)) {
				return 'Document';
			} else {
				return 'Other';
			}
		}
		const validateAttachements=async(fileName)=>{
			var fileExtension = fileName.split('.').pop().toLowerCase();

			// List of allowed extensions
			var allowedExtensions = [
				'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'tif', 
				'webp', 'svg', 'heic', 'heif', 'ico', 'jfif', 
				'doc', 'docx', 'xls', 'xlsx', 'pdf'
			];

			// Check if the file extension is in the allowed list
			if ($.inArray(fileExtension, allowedExtensions) === -1) {
				return false;
			}
			return true;
		}

		const formatOption = async(option)=> {
            if (!option.id) {
                return option.text;
            }
			
            const imgUrl = $(option.element).data('image');
			console.log(imgUrl);
			
            const img = `<img src="${imgUrl}" alt="${option.text}" style="width: 100px; height: 100px; margin-right: 10px;">`;
            const text = `<span>${option.text}</span>`;

            return $(`<span>${img} ${text}</span>`);
        }
		const stripHtmlTags=(input)=> {
    		return $('<div>').html(input).text().split("\t").join("").split("\n").join("");
		}

		$('#quoteModal').on('shown.bs.modal', function () {
			$('#lstQProducts').select2({
				dropdownParent: $('#quoteModal'),
				// templateResult: formatOption,
				// templateSelection: formatOption,
				// width: '100%'
			});

			/* const selectedOption = $('#lstQProducts').find(':selected');
			if (selectedOption.length) {
				const formattedSelection = formatOption(selectedOption[0]);
				$('#lstQProducts').next('.select2-container').find('.select2-selection__rendered').html(formattedSelection);
			} */
		});
		$(".btnQuoteStep").click(function (e) {
			e.preventDefault();

			// Find the href of the clicked link to determine the step to show
			let stepId = $(this).find('a').attr("href");
			
			// Hide all steps and show the selected one
			$(".content").hide();
			$(stepId).fadeIn();

			// Remove active class from all and add to the current step
			$(".btnQuoteStep").removeClass("active");
			$(this).addClass("active");
		});

		let currentStep = 1;
		const totalSteps = 4;

		showStep(currentStep);

		$("#btnNext").click(function () {
			if (validateStep(currentStep)) {
				if (currentStep < totalSteps) {
					currentStep++;
					showStep(currentStep);
				} else {
					alert("Form submitted!");
				}
			}
		});

		$("#btnPrevious").click(function () {
			if (currentStep > 1) {
				currentStep--;
				showStep(currentStep);
			}
		});

		function showStep(step) {
			$(".content").hide();
			$("#step-" + step).show();

			if (step === totalSteps) {
				$("#btnNext").text("Send Quote");
			} else {
				$("#btnNext").text("Next");
			}

			if (step === 1) {
				$("#btnPrevious").hide();
			} else {
				$("#btnPrevious").show();
			}
		}

		function validateStep(step) {
			let isValid = true;
			switch (step) {
				case 1:
					if ($("#step-1 input").val() === "") {
						alert("Please complete step 1!");
						isValid = false;
					}
					break;
				case 2:
					if ($("#step-2 input").val() === "") {
						alert("Please complete step 2!");
						isValid = false;
					}
					break;
				case 3:
					if ($("#step-3 input").val() === "") {
						alert("Please complete step 3!");
						isValid = false;
					}
					break;
				default:
					break;
			}
			return isValid;
		}

		function filterProducts() {
			const selectedCategory = $('#lstPCategory').val();
			const selectedSubCategory = $('#lstPSCategory').val();
			const searchQuery = $('#txtProducts').val().toLowerCase();

			let noProductsMatched = true;

			$('.divProduct').each(function() {
				const productCategory = $(this).data('pcid').toString();
				const productSubCategory = $(this).data('pscid').toString();
				const productName = $(this).data('product').toLowerCase();

				// Check if each filter matches (if a filter is not empty)
				const matchesCategory = selectedCategory === "" || productCategory === selectedCategory;
				const matchesSubCategory = selectedSubCategory === "" || productSubCategory === selectedSubCategory;
				const matchesSearch = searchQuery === "" || productName.includes(searchQuery);

				// Show or hide the product based on combined criteria
				if (matchesCategory && matchesSubCategory && matchesSearch) {
					$(this).show();
					noProductsMatched = false;
				} else {
					$(this).hide();
				}
			});

			// Show a message if no products matched the filter
			if (noProductsMatched) {
				$('#no-products-message').show();
			} else {
				$('#no-products-message').hide();
			}
		}
		function resetProductModal() {
			$('.btnCheckboxProduct').prop('checked', false);
			setTimeout(() => {
				$('#lstPCategory').val('').trigger('change');
				$('#lstPSCategory').val('').trigger('change');
	
				$('#txtProducts').val('');
			}, 1000);
		}

		$(document).on('click','#btnCancelSendProducts',resetProductModal);
		$(document).on('change keyup','#lstPSCategory, #txtProducts',filterProducts);

		$(document).on('change','#lstPCategory',function(){
			filterProducts();
			$('#lstPSCategory').val('');
			const selectedPCID = $(this).val();

			const $subCategorySelect = $('#lstPSCategory');
			$subCategorySelect.select2('destroy');

			if (selectedPCID) {
				$subCategorySelect.find('option').prop('disabled', true);
				$subCategorySelect.find('option[data-pcid="' + selectedPCID + '"]').prop('disabled', false);
			} else {
				$subCategorySelect.find('option').prop('disabled',false);
			}

			$subCategorySelect.select2({
				dropdownParent: $('#productModal'),
			}).val('').trigger('change');
		});
		$(document).on('click', '#btnSendProducts',async function() {
			const SelectedProducts = [];

			$('.btnCheckboxProduct:checked').each(function() {
				const productID = $(this).val();
				const productCard = $(this).closest('.divProduct');

				const productName = productCard.data('product');
				const description = stripHtmlTags(productCard.data('desc'));
				const productImage = productCard.find('img').attr('src');

				SelectedProducts.push({
					ProductID: productID,
					ProductName: productName,
					ProductImage: productImage,
					Description: description
				});
			});
			if (SelectedProducts.length > 0) {
				let status = await sendMessage("Products","Sent Product Details",SelectedProducts);
				resetProductModal();
				if(status){
					$('#productModal').modal('hide');
				}
			} else {
				toastr.error("Please select any product", "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0});
			}
		});

		
		init();
		$(document).on('click','#btnSearch',searchChatList);
		$(document).on('click','#people-list > ul > li',function(){
			if(activeChatID!=$(this).attr('data-id')){
				$('.call-chat-body .card').removeClass('show').addClass('show');
				pageNo=1;
				let chatStatus=$(this).attr('data-status')
				$('.chat-history.chat-msg-box ul li').remove();

				activeChatID=$(this).attr('data-id');

				messageTo=$(this).attr('data-send-from')
				messageFrom=$(this).attr('data-send-to')
				$('#people-list > ul > li').removeClass('active');
				$('#people-list > ul > li[data-id="'+activeChatID+'"]').addClass('active')
				$('#people-list > ul > li[data-id="'+activeChatID+'"] .people-details .icon').attr('data-read-status',1);
				getChatAccountDetails();
				getChatHistory("",true);
				if(chatStatus=="Blocked"){
					$('.chat-box .chat-right-aside .chat .chat-message').removeClass('blocked').addClass('blocked');
				}
			}
		});
		$(document).on('keyup','#txtMessage',function(){
			let message=$('#txtMessage').val();
			if(message!=""){
				$('#btnSendMessage').show(100);
			}else{
				$('#btnSendMessage').hide(100);
			}
		});
		$(document).on('keydown','#txtMessage',function(){
			let message=$('#txtMessage').val();
			if (event.key === 'Enter' && message!="") {
				if($('#txtMessage').val()!=""){
					sendMessage("Text",$('#txtMessage').val())
				}
			}
		})
		$(document).on('click','#btnSendMessage',function(){
			if($('#txtMessage').val()!=""){
				sendMessage("Text",$('#txtMessage').val())
			}
			
		});
		$(document).on('click','.btnDeleteChat',function(){
			let ChatID=$(this).attr('data-id');
			
			$.ajax({
				type:"post",
				url:"{{route('admin.chat.delete','_chatID_')}}".replace('_chatID_',ChatID),
				headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				async:true,
				success:function(response){
					$('#people-list > ul > li[data-id="'+ChatID+'"]').remove();
					if(ChatID==activeChatID){
						$('.call-chat-body .card').removeClass('show')
					}
				}
			});
		});
		$(document).on('click','.btnBlock',function(){
			let _this=$(this);
			let ChatID=$(this).attr('data-id');
			$.ajax({
				type:"post",
				url:"{{route('admin.chat.block','_chatID_')}}".replace('_chatID_',ChatID),
				headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				async:true,
				success:function(response){
					_this.attr('data-status','Blocked');
					_this.html('<i class="fa fa-repeat fa-flip-horizontal"></i> Unblock');
					_this.removeClass('btnBlock').addClass('btnUnblock');
					if(ChatID==activeChatID){
						$('.chat-box .chat-right-aside .chat .chat-message').removeClass('blocked').addClass('blocked');
					}
				}
			});
		});
		$(document).on('click','.btnUnblock',function(){
			let _this=$(this);
			let ChatID=$(this).attr('data-id');
			$.ajax({
				type:"post",
				url:"{{route('admin.chat.unblock','_chatID_')}}".replace('_chatID_',ChatID),
				headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				async:true,
				success:function(response){
					_this.attr('data-status','Active');
					_this.html('<i class="fa fa-ban"></i> Block');
					_this.removeClass('btnUnblock').addClass('btnBlock');
					if(ChatID==activeChatID){
						$('.chat-box .chat-right-aside .chat .chat-message').removeClass('blocked');
					}
				}
			});
		});
		$(document).on('click','#btnSendAttachment',function(){
			$('#txtAttachments').trigger('click');
		});
		$(document).on('change','#txtAttachments',async function(){
			if($('#txtAttachments').val()!=""){
				var fileInput = $('#txtAttachments')[0];
				if (fileInput.files.length > 0) {
					let status=await validateAttachements(fileInput.files[0].name);
					if(status){
						sendAttachment(fileInput.files[0])
					}
				}
				
			}
		});
		$(document).on('click',".load-chat-more a",function(e){
			e.preventDefault();
			if(isLoadMore){
				let dataId = null;
				if($('.chat-box .chat-right-aside .chat .chat-msg-box > ul > li').length>0){
					dataId=$('.chat-box .chat-right-aside .chat .chat-msg-box > ul > li').first().data('id');
				}
				
				getChatHistory("",false,dataId);
			}
		});
	});
</script>
@endsection