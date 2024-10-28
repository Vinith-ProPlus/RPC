@extends('layouts.chat')
@section('content')
<link rel="stylesheet" href="{{url('/assets/css/chat.css')}}">
<div class="container-fluid pt-10">
	<div class="row d-none d-md-flex">
		<div class="col call-chat-sidebar col-sm-12">
			<div class="card">
				<div class="card-body chat-body">
					<div class="chat-box">
						<!-- Chat left side Start-->
						<div class="chat-left-aside">
							<div>
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
		<div class="col call-chat-body" >
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
										<div class="col-6">
											<div class="name"> <span class="name-info">Anandhan AS</span> <span class="last-seen">last seen <span>today at 02:50 PM</span></span></div>
											<div class="member">Members since : <span class="member-since">11 months</span></div>
											<div class="location">Coimbatore, Tamil Nadu, India</div>
										</div>
										<div class="col-6">
											<div class="mobile-number"> <span>7708679203</span> <a href="tel:7708679203" class="btn btn-sm btn-dark ml-30">Call now</a></div>
											<div class="email">anand@propluslogics.com</div>
										</div>
									</div>
								</div>
								<!-- chat-header end-->
								<div class="chat-history chat-msg-box custom-scrollbar">
									<div class="load-chat-more"></div>
									<ul>
										<li class="sender">
											<div class="message my-message">
												<div><div>hi Welcome sdkgjzskdbj asdfjgasjdfb ausyasdghf awusydfasudfy awsdfahsdfas dasudfyaush</div> </div>
												<span class="time">10:20 am</span>
											</div>
										</li>
										<li class="clearfix reply">
											<div class="message other-message pull-right">
												<div><div>hi Welcome sdkgjzskdbj asdfjgasjdfb ausyasdghf awusydfasudfy awsdfahsdfas dasudfyaush</div> </div>
												<span class="time">10:20 am</span>
											</div>
										</li>
									</ul>
								</div>
								<!-- end chat-history-->
								<div class="chat-message clearfix shadow">
									<div class="row">
										<div class="col-12 d-flex">
											<div class="input-group ">
												<div class="input-group-text"><div class="chat-opt btnSendQuote" id="btnSendQuote" data-bs-toggle="modal" data-bs-target="#quoteModal"><div class="chat-opt-icon" ><img src="data:image/png;base64,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" alt=""></div><div class="chat-opt-name">Quotation</div></div></div>
												<div class="input-group-text"><div class="chat-opt btnSendProduct" id="btnSendProduct"><div class="chat-opt-icon" ><img src='data:image/png;base64,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'/></div><div class="chat-opt-name">Products</div></div></div>
												<div class="input-group-text"><div class="chat-opt btnSendAttachment" id="btnSendAttachment"><div class="chat-opt-icon" ><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB8AAAAbCAYAAACEP1QvAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAKbSURBVHgBxZfNchJBEMe7Z0MlpWAwJ2+ueNDoJXkDuHnkQ6u8BZ7A8gkgT6BvQHI2hH0DeAROVi6B9eYtq5AqlDBj9+4OrCtbC2HBfxXF9MzO/Jju2e4B4Z56aL47Eig/Iarez/7lx+BY2izmEY06IByRmaWPTZ/uRE5Px7Zl6+cQ7iEXLGTHXxiknB7f2laP249y5boCbERMdUBCbWi3LDYErKgwmGSnvJ3FgcGdI6DJa6wMXwQmVxYc23IWgC0aezbst1BJLAAoW/8ADhc3lnZ7FJhj+A9Ywflw0KoG52fNojkVxkDbE6XMpXaeMSvFKHAmV2nGgVkOHzQFXW2nlDyOhWeeV04oOO0oMNnVMJhPe8YsFuPWFrFgBWeBrlgwz0FhdEAY7XSu3NDD7HYKcl7bktYSSYODcxDwqQZPhegE1+JXE9cFU7xPR/2LRtScPWp4YDT1AL8FvJbYNhhQ1XSWw22Dh9eXs2fxf4Fn8HAC2AaY5cY8fBKDmWtTYHcoY5arILAZBpM3suSNm02BvZ0jngQA5/ok3oFbi/01oJc0mLXjF3wPLu+s+QD0prqfnqHYtwlcTArM4pjrnA36QsDiMhksBKREwRruaIPjHBw01LREu7aCfUq516FFYIfr9rJgD07x1MZEiGpwkHc/um6V3MuAVDX+Hg1aC8FSisLIvujCCkKuPFQA6r5tG3Qfc10eoXmR+Bt8a3/pwYoSO1J+hrnrOdk0w+7fBJhljJ2rcerx61+U6t74fS8Vive7B4c/UvsvYOJcfd8j6IODVx8kijMCP0kCzJrl9nTuLblf1ZectzaYZejG75uv3d39w2/ee4/ZqAmccKQSpXXB7lrhDjeuIPKKMh/O/nEom7JfDyXdWPwLfxL6A2iVQ8AcyGlDAAAAAElFTkSuQmCC'/></div></div></div>
												<input type="text" placeholder="Type your message" id="txtMessage" class="form-control">
												<div class="input-group-text">
													<a class="btnSendMessage" id="btnSendMessage" style="display:none"><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAATCAYAAACdkl3yAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAADlSURBVHgBpZOBEYIwEAQvYgGUkA60BKhASqAVO9AKsASpgJEGtAPsQBrQeCFBBEcC4WZ+COR/uTwPVIGUIbFU6oKKoVSJbAlwhRdyQ0TKu8oXuGKce088gRp0Y9Q/OzOBoqkpUbAwcmSe8MRexLjjjyMwIYdLDofGUYGQSVcuJaZq4FD0XqqBwNaG5O6GodehEwiHLDyh42wkrRaDAtm4CehEr5V1NgLgHB55PbQ9krqRmK4OEJvRWduNxBfQyoAC7HgML0ArYT/9wxfw7ShaAuhA/WPNBnQg8495Az5ijxI7Q4v0BlVBdW4a0d5nAAAAAElFTkSuQmCC'/></a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- end chat-message-->
								<!-- chat end-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="quoteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="quoteModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg modal-fullscreen-lg-down">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-14" id="staticBackdropLabel">Quotation</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Understood</button>
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
		const init=async()=>{
			pusherInit();
			getChatList();
			chatListPositionChange();
			detectChatTimeChange();
		}
		const pusherInit=async()=>{
			Pusher.logToConsole = false;

			var pusher = new Pusher("a7ff093c69a29c4158b8", {
				cluster: "ap2",
			});
			var channel = pusher.subscribe("rpc-chat-202");
				channel.bind('Admin', async function(message) {
			})
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
							if(parseInt(data.isRead)==0){
								content+='<div class="icon"><i class="fa fa-envelope"></i></div>';
							}else{
								content+='<div class="icon"><i class="fa fa-envelope-open"></i></div>';
							}
							content+='<div class="name">'+data.sendFromName+' <span class="mobile-number">- '+data.MobileNumber+'</span></div>';
							content+='<div class="full-right">';
								content+='<div class="options dropdown" >';
									content+='<span data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></span>';
									content+='<ul class="dropdown-menu">';
										content+='<li><a class="dropdown-item" href="#" data-id="'+data.ChatID+'"> <i class="fa fa-trash"></i> Delete</a></li>';
										content+='<li><a class="dropdown-item" href="#" data-id="'+data.ChatID+'"> <i class="fa fa-ban"></i> Block</a></li>';
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
						$('#people-list > ul').append('<li data-send-from="'+data.sendFromID+'" data-send-to="'+data.sendTo+'" data-chat-name="'+data.sendFromName +' - '+data.MobileNumber+'" class="clearfix" data-id="'+data.ChatID+'" data-time="'+data.LastMessageOn+'">'+htmlContent+'</li>');
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
						$('.chat-right-aside .name span.last-seen > span').html(response.AdminLastSeenOnHuman);
						$('.chat-right-aside .member span.member-since').html(response.RegisteredOnHuman);
						$('.chat-right-aside .location').html(Address);

						$('.chat-right-aside .mobile-number span').html(response.MobileNumber);
						$('.chat-right-aside .mobile-number a').attr('href','tel:'+response.MobileNumber);
						$('.chat-right-aside .email').html(response.email);
					}

				}
			});
		}
		const chatScrollDown=async()=>{
			// Scroll to the bottom smoothly
			const el = document.querySelector('.chat-history.chat-msg-box');
			el.scrollTo({
				top: el.scrollHeight,
				behavior: 'smooth'
			});
		}
		const getChatHistory=async(MessageID="")=>{
			$.ajax({
				type:"post",
				url:"{{route('admin.chat.get.chat-history','_chatID_')}}".replace('_chatID_',activeChatID),
				headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:{MessageID},
				dataType:"json",
				async:true,
				success:function(response){
					for(let data of response){
						addChatMessages(data);
					}
					chatScrollDown();
					setInterval(updateTimeElements, 60000);
				}
			});
		}
		const addChatMessages=async(data)=>{
			let html = `<li data-id="${data.SLNO}" class="clearfix ${data.MType === "sender" ? "sender" : "reply"}"><div class="message ${data.MType === "sender" ? "my-message" : "other-message pull-right"}"><p>${data.Message}</p><span class="time" data-time="${data.CreatedOn}">${data.CreatedOnHuman}</span></div></li>`;
			$('.chat-history.chat-msg-box ul').append(html);
		}
		const sendMessage=async()=>{
			let message=$('#txtMessage').val();
			if(message!=""){
				let type="Text";
				$.ajax({
					type:"post",
					url:"{{route('admin.chat.send.message','_chatID_')}}".replace('_chatID_',activeChatID),
					headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
					data:{message,type,messageTo,messageFrom},

					async:true,
					success:function(response){
						$('#txtMessage').val('');
						if(response.status && response.SLNO!=""){
							getChatHistory(response.SLNO)
							chatScrollDown();
							if(response.LastMessage!=""){
								$('.people-list ul.list > li[data-id="'+activeChatID+'"] .last-msg').html(response.LastMessage)
							}

							$('.people-list ul.list > li[data-id="'+activeChatID+'"] .timestamp').html(response.LastMessageOnHuman)
							$('.people-list ul.list > li[data-id="'+activeChatID+'"]').attr('data-time',response.LastMessageOn);
						}
					}
				});
			}
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
		init();
		$(document).on('click','#btnSearch',searchChatList);
		$(document).on('click','#people-list > ul > li',function(){
			$('.chat-history.chat-msg-box ul li').remove();
			activeChatID=$(this).attr('data-id');

			messageTo=$(this).attr('data-send-from')
			messageFrom=$(this).attr('data-send-to')
			$('#people-list > ul > li').removeClass('active');
			$('#people-list > ul > li[data-id="'+activeChatID+'"]').addClass('active')
			getChatAccountDetails();
			getChatHistory();
			$('.call-chat-body .card').removeClass('show').addClass('show')
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
				sendMessage();
			}
		})
		$(document).on('click','#btnSendMessage',sendMessage);
	});
</script>
@endsection
