<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="author" content="{{ config('app.name') }}">
		<meta name="_token" content="{{ csrf_token() }}" />
        <!--
		<link rel="apple-touch-icon" sizes="180x180" href="{{url('/')}}/assets/images/favicon/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="{{url('/')}}/assets/images/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="{{url('/')}}/assets/images/favicon/favicon-16x16.png">
		<link rel="manifest" href="{{url('/')}}/assets/images/favicon/manifest.json">
		<link rel="mask-icon" href="{{url('/')}}/assets/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="theme-color" content="#ffffff">-->
		<title>Login | {{ config('app.name') }}</title>
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i&amp;display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700&amp;display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/fontawesome.css">
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/icofont.css">
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/themify.css">
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/flag-icon.css">
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/feather-icon.css">
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/sweetalert2.css">
        <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/select2.css">
        <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/toastr.css">
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/style.css">
		<link id="color" rel="stylesheet" href="{{url('/')}}/assets/css/color-1.css" media="screen">
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/responsive.css">
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/custom.css">
		<style>
			.home-icon{
				position: fixed;
				top: 20px;
				right: 20px;
			}
			.home-icon i{
				font-size:16px;
			}
		</style>
		<script src="{{url('/')}}/assets/js/jquery-3.5.1.min.js"></script>
		<script src="{{url('/')}}/assets/js/bootstrap/popper.min.js"></script>
		<script src="{{url('/')}}/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="{{url('/')}}/assets/js/sweet-alert/sweetalert.min.js"></script>
        <script src="{{url('/')}}/assets/js/toastr.min.js"></script>
        <script src="{{url('/')}}/assets/js/select2/select2.full.min.js"></script>
	</head>
	<body>
		<!-- Loader starts-->
		<div class="loader-wrapper">
			<div class="theme-loader"></div>
		</div>
		<!-- Loader ends-->
		<!-- page-wrapper Start-->
		<div class="page-wrapper">
			<div class="container-fluid p-0">
				<!-- login page with video background start-->
				<div class="auth-bg-video">
					<video id="bgvid" poster="{{url('/')}}/assets/images/other-images/coming-soon-bg.jpg" playsinline="" autoplay="" muted="" loop=""><source src="http://admin.pixelstrap.com/xolo/assets/video/auth-bg.mp4" type="video/mp4"></video>
					<div class="authentication-box">
						<div class="mt-4">
                        <div class="card shadow">
                                <div class="card-header text-center"><h4>LOGIN</h4></div>
                                <div class="card-body  ">
                                    <div class="cont text-left">
                                        <div>
                                            <form class="theme-form" id="frmLogin">
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0">User Name</label>
                                                    <input class="form-control" type="text" required="" id="txtUserName">
                                                    <div class="errors" id="txtUserName-err"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Password</label>
                                                    <div class="input-group">
                                                        <input type="password" id="txtPassword" class="form-control" placeholder="Password">
                                                        <button class="btn btn-outline-light" data-is-show=0 id="btnShowPassword" type="button"><i class="fa fa-eye"></i></button>
                                                    </div>
									                <div class="errors" id="txtPassword-err"></div>
                                                </div>
                                                <div class="checkbox p-0">
                                                    <input id="chkRememberMe" type="checkbox">
                                                    <label for="chkRememberMe">Remember me</label>
                                                </div>
                                                <div class="mb-3 row g-2 mt-3 mb-0">
                                                    <button class="btn btn-primary d-block w-100" id="btnLogin" type="submit">LOGIN</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>
				<!-- login page with video background end-->
			</div>
		</div>
		<!-- latest jquery-->
		<!-- feather icon js-->
		<script src="{{url('/')}}/assets/js/icons/feather-icon/feather.min.js"></script>
		<script src="{{url('/')}}/assets/js/icons/feather-icon/feather-icon.js"></script>
		<!-- Sidebar jquery-->
		<script src="{{url('/')}}/assets/js/sidebar-menu.js"></script>
		<script src="{{url('/')}}/assets/js/config.js"></script>
		<!-- Plugins JS Ends-->
		<!-- Theme js-->
		<script src="{{url('/')}}/assets/js/script.js"></script>
		<!-- login js-->
		<script src="{{url('/')}}/assets/js/custom.js"></script>
		<script src="{{url('/')}}/assets/js/prototypes.js"></script>
		<!-- Plugin used-->
        <script>
            $(document).ready(function(){
				var params = new window.URLSearchParams(window.location.search);
				var redirectUrl=params.get('r');
                
                $(document).on('click','#btnShowPassword',function(){
                    if($(this).attr('data-is-show')=="0"){
                        $(this).attr('data-is-show',1)
                        $(this).html('<i class="fa fa-eye-slash"></i>');
                        $('#txtPassword').attr('type','text');
                    }else{
                        $(this).attr('data-is-show',0)
                        $(this).html('<i class="fa fa-eye"></i>')
                        $('#txtPassword').attr('type','password');
                    }
                });
                
				$('#frmLogin').submit((e) => {
					e.preventDefault();
					btnLoading($('#btnLogin'));
					var RememberMe = $("#chkRememberMe").prop('checked') == true?1:0;
					$('.errors').html('');
					$.ajax({
						type: "post",
						url: "{{url('/')}}/admin/auth/login",
						headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
						data: {
							email: $('#txtUserName').val(),
							password: $('#txtPassword').val(),
							remember: RememberMe,
							_token: $('meta[name=_token]').attr('content')
						},
						error: function(e, x, settings, exception) {btnReset($('#btnLogin'));ajaxErrors(e, x, settings, exception);},
						success: function(response) {
							btnReset($('#btnLogin'));
							if (response.status == true) {
								if((redirectUrl!=null)&&(redirectUrl!=undefined)&&(redirectUrl!="")){
										window.location.replace(redirectUrl);
								}else{
									window.location.replace("{{url('/') }}/admin/dashboard");
								}
							} else {
								toastr.error(response.message, "Failed", {
									positionClass: "toast-top-right",
									containerId: "toast-top-right",
									showMethod: "slideDown",
									hideMethod: "slideUp",
									progressBar: !0
								})
								if (response.email != undefined) {$('#txtUserName-err').html(response.email);}
								if (response.password != undefined) {$('#txtPassword-err').html(response.password);}
							}
						}
					});
				});
            })
        </script>
	</body>
</html>