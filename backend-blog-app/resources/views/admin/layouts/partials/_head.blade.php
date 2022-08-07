<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ get_page_meta() }} {{ config('app.name') }}</title>
<!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 10]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- Meta -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!-- Favicon icon -->
<link rel="icon" href="{{ asset('/') }}adminity/files/assets/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

<!-- Google font-->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
<!-- Required Framework -->
<link rel="stylesheet" href="{{ asset('/') }}adminity/files/bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- feather Awesome -->
<link rel="stylesheet" href="{{ asset('/') }}adminity/files/assets/icon/feather/css/feather.css">
<!-- Style.css -->
<link rel="stylesheet" href="{{ asset('/') }}adminity/files/assets/css/style.css">
<link rel="stylesheet" href="{{ asset('/') }}adminity/files/assets/css/jquery.mCustomScrollbar.css">
<!-- Sweet Alert -->
<link href="{{ URL::asset('adminity/files/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<!-- Select 2 css -->
<link rel="stylesheet" href="{{ asset('/') }}adminity/files/bower_components/select2/dist/css/select2.min.css" />
<!-- Multi Select css -->
<link rel="stylesheet" href="{{ asset('/') }}adminity/files/bower_components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css" />
<link rel="stylesheet" href="{{ asset('/') }}adminity/files/bower_components/multiselect/css/multi-select.css" />
<!-- Style.css -->
<link rel="stylesheet" href="{{ asset('/') }}adminity/files/assets/css/style.css">
<link rel="stylesheet" href="{{ asset('/') }}adminity/files/assets/css/custom.css">
<link rel="stylesheet" href="{{ asset('/') }}adminity/files/assets/css/jquery.mCustomScrollbar.css">
<link rel="stylesheet" type="text/css"
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<style>
    .dropdown-toggle::after {
        display: none;
    }
</style>
@stack('style')
