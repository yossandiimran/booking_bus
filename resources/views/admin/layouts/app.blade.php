<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Booking Bus</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="icon" href="{{ asset('assets/image/logo.png') }}" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="{{ asset('template/assets/js/plugin/webfont/webfont.min.js') }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ["{{ asset('template/assets/css/fonts.min.css') }}"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/assets/css/atlantis.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
	{{-- Tree Js For CSS --}}
	<link rel="stylesheet" href="{{ asset('assets/css/treejs.min.css') }}">

    @yield('css')
</head>
@php $_permission = Auth::user()->group_user; @endphp
<body data-background-color="bg3">
	<div class="wrapper">
        @include('admin.layouts.header')
        @include('admin.layouts.sidebar')
		<div class="main-panel">
			<div class="content">
                @yield('content')
			</div>
			<footer class="footer">
				<div class="container-fluid">
					<div class="copyright ml-auto">
						Copyright &copy; 2024</a>
					</div>				
				</div>
			</footer>
		</div>
	</div>
	<!--   Core JS Files   -->
	<script src="{{ asset('template/assets/js/core/jquery.3.2.1.min.js') }}"></script>
	<script src="{{ asset('template/assets/js/core/popper.min.js') }}"></script>
	<script src="{{ asset('template/assets/js/core/bootstrap.min.js') }}"></script>
	<!-- jQuery UI -->
	<script src="{{ asset('template/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('template/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
	<!-- jQuery Scrollbar -->
	<script src="{{ asset('template/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
	<!-- Datatables -->
	<script src="{{ asset('template/assets/js/plugin/datatables/datatables.min.js') }}"></script>
	<!-- Bootstrap Notify -->
	<script src="{{ asset('template/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
	<!-- Sweet Alert -->
	<script src="{{ asset('template/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
	<!-- Atlantis JS -->
	<script src="{{ asset('template/assets/js/atlantis.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.form.min.js') }}"></script>
	<script src="{{ asset('assets/js/select2.min.js') }}"></script>
	<script src="{{ asset('assets/js/main.js') }}"></script>
	{{-- Tree Js --}}
	<script src="{{ asset('assets/js/tree.min.js') }}"></script>

    @yield('js')
    @error('error')
    <script>
        notif("danger","fas fa-exclamation","Notifikasi Error","{{ $message }}","error");
    </script>
    @enderror
</body>
</html>