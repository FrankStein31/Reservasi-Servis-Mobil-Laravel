<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- API Base URL -->
    <meta name="api-base-url" content="{{ url('api') }}" />

    <title>@yield('title') </title>

    <!-- Scripts -->


    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
	<script src="{{ asset("assets/js/plugin/webfont/webfont.min.js") }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
    <style>
        .card-gradient {
            background: linear-gradient(135deg, #f7efff 0%, #accbff 100%);
            color: rgb(1, 1, 1);
            border: none;
        }

        .card-gradient .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.2);
        }

        .card-gradient .card-title,
        .card-gradient .card-body {
            color: rgb(1, 1, 1);
        }
    </style>


	<script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Styles -->
    {{-- <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('font/css/open-iconic-bootstrap.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset("assets/css/bootstrap.min.css")}}">
	{{-- <link rel="stylesheet" href="{{ asset("assets/css/atlantis.css")}}"> --}}
    <link rel="stylesheet" href="{{ asset("assets/css/atlantis2.css")}}">

    {{-- <style>
        #main-menu .nav-link.notif {
            position: relative;
        }

        #main-menu .nav-link.notif .badge {
            position: absolute;
            right: 0;
            top: 5px;
            font-size: 10px;
            padding: 1px 2px;
        }

    </style> --}}

    @stack('style')

</head>

<body>

    <div class="wrapper horizontal-layout-2">
        <div class="main-header fixed up" data-background-color="light-blue2">
            @include('includes.backend.navbar')
        </div>
        <div class="main-panel">
            <div class="container" id="app">
                <div class="page-inner">
                    @yield('content')
                </div>
            </div>
        </div>
        @include('includes.backend.footer')
    </div>

    {{-- Script --}}


    <script src="{{ asset("assets/js/core/jquery.3.6.0.min.js")}}"></script>
	<script src="{{ asset("assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js")}}"></script>
	<script src="{{ asset("assets/js/core/popper.min.js")}}"></script>
	<script src="{{ asset("assets/js/core/bootstrap.min.js")}}"></script>
	<script src="{{ asset("assets/js/atlantis2.min.js")}}"></script>


    @stack('script')

    <!--   Core JS Files   -->


	<!-- jQuery UI -->

	<script src="{{ asset("assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js")}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset("assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js")}}"></script>

	<!-- Moment JS -->
	<script src="{{ asset("assets/js/plugin/moment/moment.min.js")}}"></script>
	<!-- Chart JS -->
	<script src="{{ asset("assets/js/plugin/chart.js/chart.min.js")}}"></script>
	<!-- jQuery Sparkline -->
	<script src="{{ asset("assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js")}}"></script>
	<!-- Chart Circle -->
	<script src="{{ asset("assets/js/plugin/chart-circle/circles.min.js")}}"></script>
	<!-- Datatables -->
	<script src="{{ asset("assets/js/plugin/datatables/datatables.min.js")}}"></script>
	<!-- Bootstrap Notify -->
	<script src="{{ asset("assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js")}}"></script>
	<!-- Bootstrap Toggle -->
	<script src="{{ asset("assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js")}}"></script>
	<!-- jQuery Vector Maps -->
	<script src="{{ asset("assets/js/plugin/jqvmap/jquery.vmap.min.js")}}"></script>
	<script src="{{ asset("assets/js/plugin/jqvmap/maps/jquery.vmap.world.js")}}"></script>
	<!-- Google Maps Plugin -->
	<script src="{{ asset("assets/js/plugin/gmaps/gmaps.js")}}"></script>
	<!-- Dropzone -->
	<script src="{{ asset("assets/js/plugin/dropzone/dropzone.min.js")}}"></script>
	<!-- Fullcalendar -->
	<script src="{{ asset("assets/js/plugin/fullcalendar/fullcalendar.min.js")}}"></script>

	<!-- DateTimePicker -->
	<script src="{{ asset("assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js")}}"></script>

	<!-- Bootstrap Tagsinput -->
	<script src="{{ asset("assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js")}}"></script>

	<!-- Bootstrap Wizard -->
	<script src="{{ asset("assets/js/plugin/bootstrap-wizard/bootstrapwizard.js")}}"></script>

	<!-- jQuery Validation -->
	<script src="{{ asset("assets/js/plugin/jquery.validate/jquery.validate.min.js")}}"></script>

	<!-- Summernote -->
	<script src="{{ asset("assets/js/plugin/summernote/summernote-bs4.min.js")}}"></script>

	<!-- Select2 -->
	<script src="{{ asset("assets/js/plugin/select2/select2.full.min.js")}}"></script>

	<!-- Sweet Alert -->
	<script src="{{ asset("assets/js/plugin/sweetalert/sweetalert.min.js")}}"></script>



</body>

</html>
