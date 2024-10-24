<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Xolo admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
		<meta name="keywords" content="admin template, Xolo admin template, dashboard template, flat admin template, responsive admin template, web app">
		<meta name="author" content="pixelstrap">
		<link rel="icon" href="{{url('/')}}/assets/images/favicon.png" type="image/x-icon">
		<link rel="shortcut icon" href="{{url('/')}}/assets/images/favicon.png" type="image/x-icon">
		<title>Xolo - Premium Admin Template</title>
		<!-- Google font-->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i&amp;display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700&amp;display=swap" rel="stylesheet">
		<!-- Font Awesome-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/fontawesome.css">
		<!-- ico-font-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/icofont.css">
		<!-- Themify icon-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/themify.css">
		<!-- Flag icon-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/flag-icon.css">
		<!-- Feather icon-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/feather-icon.css">
		<!-- Plugins css start-->
		<!-- Plugins css Ends-->
		<!-- Bootstrap css-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/bootstrap.css">
		<!-- App css-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/style.css">
		<link id="color" rel="stylesheet" href="{{url('/')}}/assets/css/color-1.css" media="screen">
		<!-- Responsive css-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/responsive.css">
	</head>
	<body>
		<input type="hidden" style="display:none!important" id="txtRootUrl" value="{{url('/')}}/">
		<!-- Loader starts-->
		<div class="loader-wrapper">
			<div class="theme-loader"></div>
		</div>
		<!-- Loader ends-->
		<!-- page-wrapper Start-->
		<div class="page-wrapper compact-wrapper" id="pageWrapper">
			<!-- Page Header Start-->
			<div class="page-main-header">
				<div class="main-header-right">
					<div class="main-header-left">
						<div class="logo-wrapper">
							<a href="index.html">
								<img loading="lazy" src="{{url('/')}}/assets/images/logo/logo.png" alt="">
							</a>
						</div>
					</div>
					<div class="mobile-sidebar">
						<div class="flex-grow-1 text-end switch-sm">
							<label class="switch">
								<input id="sidebar-toggle" type="checkbox" data-bs-toggle=".container" checked="checked">
								<span class="switch-state"></span>
							</label>
						</div>
					</div>
					<div class="nav-right col pull-right right-menu">
						<ul class="nav-menus">
							<li class="px-0">
								<form class="form-inline search-form">
									<input class="form-control-plaintext" placeholder="Search.....">
									<i class="close-search" data-feather="x"></i>
								</form>
								<span class="mobile-search">
									<i data-feather="search"></i>
								</span>
							</li>
							<li class="onhover-dropdown">
								<i data-feather="bell"></i>
								<ul class="notification-dropdown onhover-show-div">
									<li class="d-block">
										<h6 class="f-w-600">Notifications</h6>
										<span class="f-12">You have 2 unread messages</span>
									</li>
									<li>
										<p class="mb-0">
											<i class="fa fa-circle-o me-3 font-primary"></i>Delivery processing <span class="pull-right">10 min.</span>
										</p>
									</li>
									<li>
										<p class="mb-0">
											<i class="fa fa-circle-o me-3 font-success"></i>Order Complete <span class="pull-right">1 hr</span>
										</p>
									</li>
									<li>
										<p class="mb-0">
											<i class="fa fa-circle-o me-3 font-info"></i>Tickets Generated <span class="pull-right">3 hr</span>
										</p>
									</li>
									<li>
										<p class="mb-0">
											<i class="fa fa-circle-o me-3 font-warning"></i>Delivery Complete <span class="pull-right">6 hr</span>
										</p>
									</li>
									<li class="bg-light txt-dark">
										<a href="#">All </a> notification
									</li>
								</ul>
							</li>
							<li class="onhover-dropdown">
								<i data-feather="message-circle"></i>
								<ul class="chat-dropdown onhover-show-div p-t-20 p-b-20">
									<li>
										<div class="d-flex align-items-start">
											<img loading="lazy" class="img-fluid rounded-circle me-3" src="{{url('/')}}/assets/images/user/2.jpg" alt="">
											<div class="status-circle online"></div>
											<div class="flex-grow-1">
												<span class="f-w-600">Erica Hughes</span>
												<p class="f-12 mb-0 light-font">There are many variations of passages...</p>
												<p class="f-12 mb-0 font-primary">1 hr ago</p>
											</div>
										</div>
									</li>
									<li>
										<div class="d-flex align-items-start">
											<img loading="lazy" class="img-fluid rounded-circle me-3" src="{{url('/')}}/assets/images/user/1.jpg" alt="">
											<div class="status-circle away"></div>
											<div class="flex-grow-1">
												<span class="f-w-600">Kori Thomas</span>
												<p class="f-12 mb-0 light-font">There are many variations of passages...</p>
												<p class="f-12 mb-0 font-primary">58 mins ago</p>
											</div>
										</div>
									</li>
									<li>
										<div class="d-flex align-items-start">
											<img loading="lazy" class="img-fluid rounded-circle me-3" src="{{url('/')}}/assets/images/user/4.jpg" alt="">
											<div class="status-circle offline"></div>
											<div class="flex-grow-1">
												<span class="f-w-600">Ain Chavez</span>
												<p class="f-12 mb-0 light-font">There are many variations of passages...</p>
												<p class="f-12 mb-0 font-primary">32 mins ago</p>
											</div>
										</div>
									</li>
									<li class="light-font text-center">Mark all as read </li>
								</ul>
							</li>
							<li>
								<a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()">
									<i data-feather="maximize"></i>
								</a>
							</li>
							<li class="theme-setting">
								<i data-feather="settings"></i>
							</li>
							<li class="onhover-dropdown px-0">
								<span class="d-flex user-header">
									<img loading="lazy" class="me-2 rounded-circle img-35" src="{{url('/')}}/assets/images/dashboard/user.png" alt="">
									<span class="flex-grow-1">
										<span class="f-12 f-w-600">Elana Saint</span>
										<span class="d-block">Admin</span>
									</span>
								</span>
								<ul class="profile-dropdown onhover-show-div">
									<li>
										<i data-feather="user"></i>Profile
									</li>
									<li class="f-w-600">Home</li>
									<li class="f-12">
										<i data-feather="chevron-right"></i>Inbox
									</li>
									<li class="f-12">
										<i data-feather="chevron-right"></i>Taskboard
									</li>
									<li class="f-12">
										<i data-feather="chevron-right"></i>Settings
									</li>
									<li>
										<i data-feather="log-in"></i>Log in
									</li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="d-lg-none mobile-toggle pull-right">
						<i data-feather="more-horizontal"></i>
					</div>
				</div>
			</div>
			<!-- Page Header Ends                              -->
			<!-- Page Body Start-->
			<div class="page-body-wrapper sidebar-icon">
				<nav-menus></nav-menus>
				<header class="main-nav">
					<nav>
						<div class="main-navbar">
							<div class="left-arrow" id="left-arrow">
								<i data-feather="arrow-left"></i>
							</div>
							<div id="mainnav">
								<ul class="nav-menu custom-scrollbar">
									<li class="back-btn">
										<div class="mobile-back text-end">
											<span>Back</span>
											<i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
										</div>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title" href="#">
											<i data-feather="home"></i>
											<span>Dashboard</span>
										</a>
										<ul class="nav-submenu menu-content">
											<li>
												<a href="index.html">Business</a>
											</li>
											<li>
												<a href="dashboard-02.html">Helpdesk</a>
											</li>
											<li>
												<a href="dashboard-03.html">Social</a>
											</li>
											<li>
												<a href="dashboard-04.html">Enterprise</a>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title" href="#">
											<i data-feather="airplay"></i>
											<span>Widgets</span>
										</a>
										<ul class="nav-submenu menu-content">
											<li>
												<a href="general-widget.html">General</a>
											</li>
											<li>
												<a href="chart-widget.html">Chart</a>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title" href="#">
											<i data-feather="box"></i>
											<span>Ui Kits</span>
										</a>
										<ul class="nav-submenu menu-content">
											<li>
												<a href="typography.html">Typography</a>
											</li>
											<li>
												<a href="avatars.html">Avatars</a>
											</li>
											<li>
												<a href="helper-classes.html">helper classes</a>
											</li>
											<li>
												<a href="grid.html">Grid</a>
											</li>
											<li>
												<a href="tag-pills.html">Tag & pills</a>
											</li>
											<li>
												<a href="progress-bar.html">Progress</a>
											</li>
											<li>
												<a href="modal.html">Modal</a>
											</li>
											<li>
												<a href="alert.html">Alert</a>
											</li>
											<li>
												<a href="popover.html">Popover</a>
											</li>
											<li>
												<a href="tooltip.html">Tooltip</a>
											</li>
											<li>
												<a href="loader.html">Spinners</a>
											</li>
											<li>
												<a href="dropdown.html">Dropdown</a>
											</li>
											<li>
												<a href="according.html">Accordion</a>
											</li>
											<li>
												<a class="submenu-title" href="#">Tabs <span class="sub-arrow">
														<i class="fa fa-chevron-right"></i>
													</span>
												</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="tab-bootstrap.html">Bootstrap Tabs</a>
													</li>
													<li>
														<a href="tab-material.html">Line Tabs</a>
													</li>
												</ul>
											</li>
											<li>
												<a href="navs.html">Navs</a>
											</li>
											<li>
												<a href="box-shadow.html">Shadow</a>
											</li>
											<li>
												<a href="list.html">Lists</a>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title" href="#">
											<i data-feather="folder-plus"></i>
											<span>Bonus Ui</span>
											<span class="badge badge-success">Hot</span>
										</a>
										<ul class="nav-submenu menu-content">
											<li>
												<a href="scrollable.html">Scrollable</a>
											</li>
											<li>
												<a href="tree.html">Tree view</a>
											</li>
											<li>
												<a href="bootstrap-notify.html">Bootstrap Notify</a>
											</li>
											<li>
												<a href="rating.html">Rating</a>
											</li>
											<li>
												<a href="dropzone.html">dropzone</a>
											</li>
											<li>
												<a href="tour.html">Tour</a>
											</li>
											<li>
												<a href="sweet-alert2.html">SweetAlert2</a>
											</li>
											<li>
												<a href="modal-animated.html">Animated Modal</a>
											</li>
											<li>
												<a href="owl-carousel.html">Owl Carousel</a>
											</li>
											<li>
												<a href="ribbons.html">Ribbons</a>
											</li>
											<li>
												<a href="pagination.html">Pagination</a>
											</li>
											<li>
												<a href="steps.html">Steps</a>
											</li>
											<li>
												<a href="breadcrumb.html">Breadcrumb</a>
											</li>
											<li>
												<a href="range-slider.html">Range Slider</a>
											</li>
											<li>
												<a href="image-cropper.html">Image cropper</a>
											</li>
											<li>
												<a href="sticky.html">Sticky</a>
											</li>
											<li>
												<a href="basic-card.html">Basic Card</a>
											</li>
											<li>
												<a href="creative-card.html">Creative Card</a>
											</li>
											<li>
												<a href="tabbed-card.html">Tabbed Card</a>
											</li>
											<li>
												<a href="dragable-card.html">Draggable Card</a>
											</li>
											<li>
												<a class="submenu-title" href="#">Timeline <span class="sub-arrow">
														<i class="fa fa-chevron-right"></i>
													</span>
												</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="timeline-v-1.html">Timeline 1</a>
													</li>
													<li>
														<a href="timeline-v-2.html">Timeline 2</a>
													</li>
													<li>
														<a href="timeline-small.html">Timeline 3</a>
													</li>
												</ul>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title" href="#">
											<i data-feather="layout"></i>
											<span>Page layout</span>
										</a>
										<ul class="nav-submenu menu-content">
											<li>
												<a href="box-layout.html">Boxed</a>
											</li>
											<li>
												<a href="layout-rtl.html">RTL</a>
											</li>
											<li>
												<a href="layout-light.html">Light Layout</a>
											</li>
											<li>
												<a href="layout-dark.html">Dark Layout</a>
											</li>
											<li>
												<a href="hide-on-scroll.html">Hide Nav Scroll</a>
											</li>
											<li>
												<a href="footer-light.html">Footer Light</a>
											</li>
											<li>
												<a href="footer-dark.html">Footer Dark</a>
											</li>
											<li>
												<a href="footer-fixed.html">Footer Fixed</a>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title" href="#">
											<i data-feather="edit-3"></i>
											<span>Builders</span>
										</a>
										<ul class="nav-submenu menu-content">
											<li>
												<a href="form-builder-1.html"> Form Builder 1</a>
											</li>
											<li>
												<a href="form-builder-2.html"> Form Builder 2</a>
											</li>
											<li>
												<a href="pagebuild.html">Page Builder</a>
											</li>
											<li>
												<a href="button-builder.html">Button Builder</a>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title" href="#">
											<i data-feather="cloud-drizzle"></i>
											<span>Animation</span>
										</a>
										<ul class="nav-submenu menu-content">
											<li>
												<a href="animate.html">Animate</a>
											</li>
											<li>
												<a href="scroll-reval.html">Scroll Reveal</a>
											</li>
											<li>
												<a href="AOS.html">AOS animation</a>
											</li>
											<li>
												<a href="tilt.html">Tilt Animation</a>
											</li>
											<li>
												<a href="wow.html">Wow Animation</a>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title" href="#">
											<i data-feather="command"></i>
											<span>Icons</span>
										</a>
										<ul class="nav-submenu menu-content">
											<li>
												<a href="flag-icon.html">Flag icon</a>
											</li>
											<li>
												<a href="font-awesome.html">Fontawesome Icon</a>
											</li>
											<li>
												<a href="ico-icon.html">Ico Icon</a>
											</li>
											<li>
												<a href="themify-icon.html">Thimify Icon</a>
											</li>
											<li>
												<a href="feather-icon.html">Feather icon</a>
											</li>
											<li>
												<a href="whether-icon.html">Whether Icon</a>
											</li>
											<li>
												<a href="simple-line-icon.html">Simple line Icon</a>
											</li>
											<li>
												<a href="material-design-icon.html">Material Design Icon</a>
											</li>
											<li>
												<a href="pe7-icon.html">pe7 icon</a>
											</li>
											<li>
												<a href="typicons-icon.html">Typicons icon</a>
											</li>
											<li>
												<a href="ionic-icon.html">Ionic icon</a>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title" href="#">
											<i data-feather="cloud"></i>
											<span>Buttons</span>
										</a>
										<ul class="nav-submenu menu-content">
											<li>
												<a href="buttons.html">Default Style</a>
											</li>
											<li>
												<a href="buttons-flat.html">Flat Style</a>
											</li>
											<li>
												<a href="buttons-edge.html">Edge Style</a>
											</li>
											<li>
												<a href="raised-button.html">Raised Style</a>
											</li>
											<li>
												<a href="button-group.html">Button Group</a>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title" href="#">
											<i data-feather="file-text"></i>
											<span>Forms</span>
										</a>
										<ul class="nav-submenu menu-content">
											<li>
												<a class="submenu-title" href="#">Form Controls <span class="sub-arrow">
														<i class="fa fa-chevron-right"></i>
													</span>
												</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="form-validation.html">Form Validation</a>
													</li>
													<li>
														<a href="base-input.html">Base Inputs</a>
													</li>
													<li>
														<a href="radio-checkbox-control.html">Checkbox & Radio</a>
													</li>
													<li>
														<a href="input-group.html">Input Groups</a>
													</li>
													<li>
														<a href="megaoptions.html">Mega Options</a>
													</li>
												</ul>
											</li>
											<li>
												<a class="submenu-title" href="#">Form Widgets <span class="sub-arrow">
														<i class="fa fa-chevron-right"></i>
													</span>
												</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="datepicker.html">Datepicker</a>
													</li>
													<li>
														<a href="time-picker.html">Timepicker</a>
													</li>
													<li>
														<a href="datetimepicker.html">Datetimepicker</a>
													</li>
													<li>
														<a href="daterangepicker.html">Daterangepicker</a>
													</li>
													<li>
														<a href="touchspin.html">Touchspin</a>
													</li>
													<li>
														<a href="select2.html">Select2</a>
													</li>
													<li>
														<a href="switch.html">Switch</a>
													</li>
													<li>
														<a href="typeahead.html">Typeahead</a>
													</li>
													<li>
														<a href="clipboard.html">Clipboard</a>
													</li>
												</ul>
											</li>
											<li>
												<a class="submenu-title" href="#">Form layout <span class="sub-arrow">
														<i class="fa fa-chevron-right"></i>
													</span>
												</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="default-form.html">Default Forms</a>
													</li>
													<li>
														<a href="form-wizard.html">Form Wizard 1</a>
													</li>
													<li>
														<a href="form-wizard-two.html">Form Wizard 2</a>
													</li>
													<li>
														<a href="form-wizard-three.html">Form Wizard 3</a>
													</li>
													<li>
														<a href="form-wizard-four.html">Form Wizard 4</a>
													</li>
												</ul>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title" href="#">
											<i data-feather="server"></i>
											<span>Tables</span>
										</a>
										<ul class="nav-submenu menu-content">
											<li>
												<a class="submenu-title" href="#">Bootstrap Tables <span class="sub-arrow">
														<i class="fa fa-chevron-right"></i>
													</span>
												</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="bootstrap-basic-table.html">Basic Tables</a>
													</li>
													<li>
														<a href="bootstrap-sizing-table.html">Sizing Tables</a>
													</li>
													<li>
														<a href="bootstrap-border-table.html">Border Tables</a>
													</li>
													<li>
														<a href="bootstrap-styling-table.html">Styling Tables</a>
													</li>
													<li>
														<a href="table-components.html">Table components</a>
													</li>
												</ul>
											</li>
											<li>
												<a class="submenu-title" href="#">Data Tables <span class="sub-arrow">
														<i class="fa fa-chevron-right"></i>
													</span>
												</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="datatable-basic-init.html">Basic Init</a>
													</li>
													<li>
														<a href="datatable-advance.html">Advance Init</a>
													</li>
													<li>
														<a href="datatable-styling.html">Styling</a>
													</li>
													<li>
														<a href="datatable-AJAX.html">AJAX</a>
													</li>
													<li>
														<a href="datatable-server-side.html">Server Side</a>
													</li>
													<li>
														<a href="datatable-plugin.html">Plug-in</a>
													</li>
													<li>
														<a href="datatable-API.html">API</a>
													</li>
													<li>
														<a href="datatable-data-source.html">Data Sources</a>
													</li>
												</ul>
											</li>
											<li>
												<a class="submenu-title" href="#">Ex. Data Tables <span class="sub-arrow">
														<i class="fa fa-chevron-right"></i>
													</span>
												</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="datatable-ext-autofill.html">Auto Fill</a>
													</li>
													<li>
														<a href="datatable-ext-basic-button.html">Basic Button</a>
													</li>
													<li>
														<a href="datatable-ext-col-reorder.html">Column Reorder</a>
													</li>
													<li>
														<a href="datatable-ext-fixed-header.html">Fixed Header</a>
													</li>
													<li>
														<a href="datatable-ext-html-5-data-export.html">HTML 5 Export</a>
													</li>
													<li>
														<a href="datatable-ext-key-table.html">Key Table</a>
													</li>
													<li>
														<a href="datatable-ext-responsive.html">Responsive</a>
													</li>
													<li>
														<a href="datatable-ext-row-reorder.html">Row Reorder</a>
													</li>
													<li>
														<a href="datatable-ext-scroller.html">Scroller</a>
													</li>
												</ul>
											</li>
											<li>
												<a href="jsgrid-table.html">Js Grid Table</a>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title" href="#">
											<i data-feather="bar-chart"></i>
											<span>Charts</span>
										</a>
										<ul class="nav-submenu menu-content">
											<li>
												<a href="chart-apex.html">Apex Chart</a>
											</li>
											<li>
												<a href="chart-google.html">Google Chart</a>
											</li>
											<li>
												<a href="chart-sparkline.html">Sparkline chart</a>
											</li>
											<li>
												<a href="chart-flot.html">Flot Chart</a>
											</li>
											<li>
												<a href="chart-knob.html">Knob Chart</a>
											</li>
											<li>
												<a href="chart-morris.html">Morris Chart</a>
											</li>
											<li>
												<a href="chartjs.html">Chatjs Chart</a>
											</li>
											<li>
												<a href="chartist.html">Chartist Chart</a>
											</li>
											<li>
												<a href="chart-peity.html">Peity Chart </a>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title" href="#">
											<i data-feather="grid"></i>
											<span>Pages</span>
											<span class="badge badge-danger">New</span>
										</a>
										<ul class="nav-submenu menu-content">
											<li>
												<a href="landing-page.html">Landing page</a>
											</li>
											<li>
												<a href="sample-page.html">Sample page</a>
											</li>
											<li>
												<a href="internationalization.html">Internationalization</a>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title" href="#">
											<i data-feather="users"></i>
											<span>Apps</span>
										</a>
										<ul class="nav-submenu menu-content">
											<li>
												<a href="bookmark.html">Bookmarks</a>
											</li>
											<li>
												<a href="contacts.html">Contacts</a>
											</li>
											<li>
												<a href="task.html">Tasks</a>
											</li>
											<li>
												<a class="submenu-title" href="#">Maps <span class="sub-arrow">
														<i class="fa fa-chevron-right"></i>
													</span>
												</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="map-js.html">Maps JS</a>
													</li>
													<li>
														<a href="vector-map.html">Vector Maps </a>
													</li>
												</ul>
											</li>
											<li>
												<a class="submenu-title" href="#">Email <span class="sub-arrow">
														<i class="fa fa-chevron-right"></i>
													</span>
												</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="email-application.html">Email App</a>
													</li>
													<li>
														<a href="email-compose.html">Email Compose</a>
													</li>
												</ul>
											</li>
											<li>
												<a class="submenu-title" href="#">Ecommerce <span class="sub-arrow">
														<i class="fa fa-chevron-right"></i>
													</span>
												</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="product.html">Product</a>
													</li>
													<li>
														<a href="product-page.html">Product page</a>
													</li>
													<li>
														<a href="list-products.html">Product list</a>
													</li>
													<li>
														<a href="payment-details.html">Payment Details</a>
													</li>
													<li>
														<a href="order-history.html">Order History</a>
													</li>
													<li>
														<a href="invoice-template.html">Invoice</a>
													</li>
													<li>
														<a href="cart.html">Cart</a>
													</li>
													<li>
														<a href="list-wish.html">Wishlist</a>
													</li>
													<li>
														<a href="checkout.html">Checkout</a>
													</li>
													<li>
														<a href="pricing.html">Pricing</a>
													</li>
												</ul>
											</li>
											<li>
												<a class="submenu-title" href="#">Blog</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="blog.html">Blog Details</a>
													</li>
													<li>
														<a href="blog-single.html">Blog Single</a>
													</li>
													<li>
														<a href="add-post.html">Add Post</a>
													</li>
												</ul>
											</li>
											<li>
												<a class="submenu-title" href="#">Job Search</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="job-cards-view.html">Cards view</a>
													</li>
													<li>
														<a href="job-list-view.html">List View</a>
													</li>
													<li>
														<a href="job-details.html">Job Details</a>
													</li>
													<li>
														<a href="job-apply.html">Apply</a>
													</li>
												</ul>
											</li>
											<li>
												<a class="submenu-title" href="#">Learning</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="learning-list-view.html">Learning List</a>
													</li>
													<li>
														<a href="learning-detailed.html">Detailed Course</a>
													</li>
												</ul>
											</li>
											<li>
												<a class="submenu-title" href="#">Gallery</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="gallery.html">Gallery Grid</a>
													</li>
													<li>
														<a href="gallery-with-description.html">Gallery Grid Desc</a>
													</li>
													<li>
														<a href="gallery-masonry.html">Masonry Gallery</a>
													</li>
													<li>
														<a href="masonry-gallery-with-disc.html">Masonry with Desc</a>
													</li>
													<li>
														<a href="gallery-hover.html">Hover Effects</a>
													</li>
												</ul>
											</li>
											<li>
												<a class="submenu-title" href="#">Chat <span class="sub-arrow">
														<i class="fa fa-chevron-right"></i>
													</span>
												</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="chat.html">Chat App</a>
													</li>
													<li>
														<a href="chat-video.html">Video chat</a>
													</li>
												</ul>
											</li>
											<li>
												<a href="calendar-basic.html">Calender</a>
											</li>
											<li>
												<a class="submenu-title" href="#">Users <span class="sub-arrow">
														<i class="fa fa-chevron-right"></i>
													</span>
												</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="user-profile.html">Users Profile</a>
													</li>
													<li>
														<a href="edit-profile.html">Users Edit</a>
													</li>
													<li>
														<a href="user-cards.html">Users Cards</a>
													</li>
												</ul>
											</li>
											<li>
												<a class="submenu-title" href="#">Editors <span class="sub-arrow">
														<i class="fa fa-chevron-right"></i>
													</span>
												</a>
												<ul class="nav-sub-childmenu submenu-content">
													<li>
														<a href="ckeditor.html">CK editor</a>
													</li>
													<li>
														<a href="simple-MDE.html">MDE editor</a>
													</li>
													<li>
														<a href="ace-code-editor.html">ACE code editor</a>
													</li>
												</ul>
											</li>
											<li>
												<a href="social-app.html">Social App</a>
											</li>
											<li>
												<a href="to-do.html">To-Do</a>
											</li>
											<li>
												<a href="faq.html">FAQ</a>
											</li>
											<li>
												<a href="knowledgebase.html">Knowledgebase</a>
											</li>
											<li>
												<a href="support-ticket.html">Support Ticket</a>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a class="nav-link menu-title link-nav" href="https://admin.pixelstrap.com/xolo/starter-kit/index.html" target="_blank">
											<i data-feather="anchor"></i>
											<span>Starter kit</span>
										</a>
									</li>
									<li class="mega-menu">
										<a class="nav-link menu-title" href="#">
											<i data-feather="layers"></i>
											<span>Others</span>
										</a>
										<div class="mega-menu-container menu-content">
											<div class="container">
												<div class="row">
													<div class="col mega-box">
														<div class="link-section">
															<div class="submenu-title">
																<h5>Search Pages</h5>
															</div>
															<ul class="submenu-content opensubmegamenu">
																<li>
																	<a href="search.html">Search Website</a>
																</li>
																<li>
																	<a href="search-images.html">Search Images</a>
																</li>
																<li>
																	<a href="search-video.html">Search Video</a>
																</li>
															</ul>
														</div>
													</div>
													<div class="col mega-box">
														<div class="link-section">
															<div class="submenu-title">
																<h5>Error Page</h5>
															</div>
															<ul class="submenu-content opensubmegamenu">
																<li>
																	<a href="error-400.html">Error 400</a>
																</li>
																<li>
																	<a href="error-401.html">Error 401</a>
																</li>
																<li>
																	<a href="error-403.html">Error 403</a>
																</li>
																<li>
																	<a href="error-404.html">Error 404</a>
																</li>
																<li>
																	<a href="error-500.html">Error 500</a>
																</li>
																<li>
																	<a href="error-503.html">Error 503</a>
																</li>
															</ul>
														</div>
													</div>
													<div class="col mega-box">
														<div class="link-section">
															<div class="submenu-title">
																<h5> Authentication</h5>
															</div>
															<ul class="submenu-content opensubmegamenu">
																<li>
																	<a href="login.html">Login Simple</a>
																</li>
																<li>
																	<a href="login-image.html">Login with Bg Image</a>
																</li>
																<li>
																	<a href="login-video.html">Login with Bg video</a>
																</li>
																<li>
																	<a href="signup.html">Register Simple</a>
																</li>
																<li>
																	<a href="signup-image.html">Register with Bg Image</a>
																</li>
																<li>
																	<a href="signup-video.html">Register with Bg video</a>
																</li>
																<li>
																	<a href="unlock.html">Unlock User</a>
																</li>
																<li>
																	<a href="forget-password.html">Forget Password</a>
																</li>
																<li>
																	<a href="reset-password.html">Reset Password</a>
																</li>
																<li>
																	<a href="maintenance.html">Maintenance</a>
																</li>
															</ul>
														</div>
													</div>
													<div class="col mega-box">
														<div class="link-section">
															<div class="submenu-title">
																<h5>Coming Soon</h5>
															</div>
															<ul class="submenu-content opensubmegamenu">
																<li>
																	<a href="comingsoon.html">Coming Simple</a>
																</li>
																<li>
																	<a href="comingsoon-bg-video.html">Coming with Bg video</a>
																</li>
																<li>
																	<a href="comingsoon-bg-img.html">Coming with Bg Image</a>
																</li>
															</ul>
														</div>
													</div>
													<div class="col mega-box">
														<div class="link-section">
															<div class="submenu-title">
																<h5>Email templates</h5>
															</div>
															<ul class="submenu-content opensubmegamenu">
																<li>
																	<a href="basic-template.html">Basic Email</a>
																</li>
																<li>
																	<a href="email-header.html">Basic With Header</a>
																</li>
																<li>
																	<a href="template-email.html">Ecomerce Template</a>
																</li>
																<li>
																	<a href="template-email-2.html">Email Template 2</a>
																</li>
																<li>
																	<a href="ecommerce-templates.html">Ecommerce Email</a>
																</li>
																<li>
																	<a href="email-order-success.html">Order Success</a>
																</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
							<div class="right-arrow" id="right-arrow">
								<i data-feather="arrow-right"></i>
							</div>
						</div>
					</nav>
				</header>
				<!-- Page Sidebar Ends-->
				<div class="page-body">
					<div class="container-fluid">
						<div class="page-header">
							<div class="row">
								<div class="col-lg-6">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="index.html">
												<i class="f-16 fa fa-home"></i>
											</a>
										</li>
										<li class="breadcrumb-item">Pages Layout </li>
									</ol>
									<h3>Sample Page</h3>
								</div>
								<div class="col-lg-6">
									<!-- Bookmark Start-->
									<div class="bookmark pull-right">
										<ul>
											<li>
												<a href="#" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" title="" data-original-title="Tables">
													<i data-feather="inbox"></i>
												</a>
											</li>
											<li>
												<a href="#" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" title="" data-original-title="Chat">
													<i data-feather="message-square"></i>
												</a>
											</li>
											<li>
												<a href="#" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" title="" data-original-title="Icons">
													<i data-feather="command"></i>
												</a>
											</li>
											<li>
												<a href="#" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" title="" data-original-title="Learning">
													<i data-feather="layers"></i>
												</a>
											</li>
											<li>
												<a href="#">
													<i class="bookmark-search" data-feather="star"></i>
												</a>
												<form class="form-inline search-form">
													<div class="mb-3 form-control-search form-group">
														<input type="text" placeholder="Search..">
													</div>
												</form>
											</li>
										</ul>
									</div>
									<!-- Bookmark Ends-->
								</div>
							</div>
						</div>
					</div>
					<!-- Container-fluid starts-->
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-12">
								<div class="card">
									<div class="card-header">
										<h5>Sample Card</h5>
										<span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
									</div>
									<div class="card-body"></div>
								</div>
							</div>
						</div>
					</div>
					<!-- Container-fluid Ends-->
				</div>
				<!-- footer start-->
				<footer class="footer">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-6 footer-copyright">
								<p class="mb-0">Copyright 2022 © Xolo All rights reserved.</p>
							</div>
							<div class="col-md-6">
								<p class="pull-right mb-0">Hand crafted & made with &nbsp; <i class="fa fa-heart"></i>
								</p>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
		<!-- latest jquery-->
		<script src="{{url('/')}}/assets/js/jquery-3.5.1.min.js"></script>
		<!-- Bootstrap js-->
		<script src="{{url('/')}}/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
		<!-- feather icon js-->
		<script src="{{url('/')}}/assets/js/icons/feather-icon/feather.min.js"></script>
		<script src="{{url('/')}}/assets/js/icons/feather-icon/feather-icon.js"></script>
		<!-- Sidebar jquery-->
		<script src="{{url('/')}}/assets/js/sidebar-menu.js"></script>
		<script src="{{url('/')}}/assets/js/config.js"></script>
		<!-- Plugins JS start-->
		<!-- Plugins JS Ends-->
		<!-- Theme js-->
		<script src="{{url('/')}}/assets/js/script.js"></script>
		<script src="{{url('/')}}/assets/js/theme-customizer/customizer.js"></script>
		<!-- login js-->
		<!-- Plugin used-->
	</body>
</html>
