<!DOCTYPE html>
<html lang="en">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="expires" content="0">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="ProPlus Logics">
        <meta name="_token" content="{{ csrf_token() }}"/>

        <title>{{$PageTitle}} - {{$Company['CompanyName']}}</title>
		<link rel="stylesheet" type="text/css" href="{{url('/assets/css/bootstrap.css')}}">
		<link rel="stylesheet" type="text/css" href="{{url('/assets/css/fontawesome.css')}}">
		<link rel="stylesheet" href="{{url('/assets/pdf/style.css')}}">
		<style>
			html,
			body {
				background-color: transparent !important;
			}
			.header-table td {
				border: 0px;
				padding: 2px;
				font-size: 11px;
			}

			.break-word {
				word-break: break-all;
				overflow-wrap: break-word;
				white-space: normal;
			}

			.quote-table td img {
				width: 40px;
			}
		</style>
	</head>
	<?php
		$isPDF=isset($isPDF)?$isPDF:false;
	?>
	<body class="qt-quote @if($isPDF) pdf-view @endif">
		<div id="divsettings" style="display:none!important">{{json_encode($Settings)}}</div>
		@yield('content')
		<script src="{{url('/assets/js/jquery-3.7.1.min.js')}}"></script>
		<script src="{{url('/assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
        @yield('scripts')
	</body>
</html>
