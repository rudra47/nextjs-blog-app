<!-- Required Jquery -->
<script src="{{ asset('/') }}adminity/files/bower_components/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('/') }}adminity/files/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="{{ asset('/') }}adminity/files/bower_components/popper.js/dist/umd/popper.min.js"></script>
<script src="{{ asset('/') }}adminity/files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script src="{{ asset('/') }}adminity/files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>
<!-- modernizr js -->
<script src="{{ asset('/') }}adminity/files/bower_components/modernizr/modernizr.js"></script>
<script src="{{ asset('/') }}adminity/files/bower_components/modernizr/feature-detects/css-scrollbars.js"></script>
<!-- Chart js -->
<script src="{{ asset('/') }}adminity/files/bower_components/chart.js/dist/Chart.js"></script>
<!-- amchart js -->
<script src="{{ asset('/') }}adminity/files/assets/pages/widget/amchart/amcharts.js"></script>
<script src="{{ asset('/') }}adminity/files/assets/pages/widget/amchart/serial.js"></script>
<script src="{{ asset('/') }}adminity/files/assets/pages/widget/amchart/light.js"></script>
<!-- Custom js -->
<script src="{{ asset('/') }}adminity/files/assets/js/SmoothScroll.js"></script>
<script src="{{ asset('/') }}adminity/files/assets/js/pcoded.min.js"></script>
<script src="{{ asset('/') }}adminity/files/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="{{ asset('/') }}adminity/files/assets/js/vartical-layout.min.js"></script>
<script src="{{ asset('/') }}adminity/files/assets/pages/dashboard/analytic-dashboard.min.js"></script>
<script src="{{ asset('/') }}adminity/files/assets/js/script.js"></script>
<!-- Select 2 js -->
<script src="{{ asset('/') }}adminity/files/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- Multiselect js -->
<script src="{{ asset('/') }}adminity/files/bower_components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
<script src="{{ asset('/') }}adminity/files/bower_components/multiselect/js/jquery.multi-select.js"></script>
<script src="{{ asset('/') }}adminity/files/assets/js/jquery.quicksearch.js"></script>
<script src="{{ asset('/') }}adminity/files/assets/pages/advance-elements/select2-custom.js"></script>
<!-- Sweet-Alert  -->
<script src="{{ URL::asset('adminity/files/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    @if(Session::has('message'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.success("{{ session('message') }}");
    @endif

    @if(Session::has('error'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.warning("{{ session('warning') }}");
    @endif
</script>
<script>
    function makeDeleteRequest(event, id) {
        event.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger mr-2"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons
            .fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            })
            .then(result => {
                console.log(id);
                if (result.value) {
                    let form_id = $("#delete-form-" + id);
                    $(form_id).submit();
                }
            });
    }
</script>

<script>
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
</script>

@stack('script')
