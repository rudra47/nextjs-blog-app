<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    @include('admin.layouts.partials._head')
</head>

<body>

@include('admin.layouts.partials.preloader')

<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        @include('admin.layouts.partials._header')
        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                @include('admin.layouts.partials._sidebar')
                <div class="pcoded-content">
                    <div class="pcoded-inner-content">
                        <div class="main-body">
                            @include('flash::message')
                            @yield('content')
                            {{--                            <div id="styleSelector"></div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="loader text-center">
                    <img src="{{asset('adminity/loader.gif')}}" width="80" alt="">
                </div>
                <div id="formModalBody">

                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.layouts.partials._footer-script')
<script>
    $('.formModalBtn').on('click', function (e) {
        e.preventDefault();
        $(".loader").show();
        let url = $(this).attr('data-action');
        let modalTitle = $(this).attr('modal-title');

        $("#formModalBody").html("");
        $("#formModalLabel").html("");
        $.ajax({
            url: url,
            method: 'get',
            dataType: 'html',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $('#formModalLabel').html(modalTitle);
                $('#formModalBody').html(response);
                $("#formModal").modal('show');
                $(".loader").hide();
            },
            error: function (response) {
            }
        });
    })

    $('.modal').on('mousedown mouseup click', '.multiselect-container', function(e) {
        e.preventDefault();
    });

</script>
</body>
</html>
