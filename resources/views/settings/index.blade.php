@extends('layouts.admin')
@section('page-title')
    {{ __('Settings') }}
@endsection
@php
    // $logo=asset(Storage::url('uploads/'));
    $logo = \App\Models\Utility::get_file('uploads/logo/');
    
    $lang = \App\Models\Utility::getValByName('default_language');
    
    $file_type = config('files_types');
    $setting = App\Models\Utility::settings();
    
    $local_storage_validation = $setting['local_storage_validation'];
    $local_storage_validations = explode(',', $local_storage_validation);
    
    $s3_storage_validation = $setting['s3_storage_validation'];
    $s3_storage_validations = explode(',', $s3_storage_validation);
    
    $wasabi_storage_validation = $setting['wasabi_storage_validation'];
    $wasabi_storage_validations = explode(',', $wasabi_storage_validation);
    $logo_img = \App\Models\Utility::getValByName('company_logo');
    $logo_light_img = \App\Models\Utility::getValByName('company_logo_light');
    $chatgpt_setting = App\Models\Utility::chatgpt_setting(\Auth::user()->creatorId());
    
@endphp
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Settings') }}</li>
@endsection
@section('title')
    {{ __('Settings') }}
@endsection
@php
    // $color = Cookie::get('color');
    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';
@endphp

@if ($color == 'theme-3')
    <style>
        .btn-check:checked+.btn-outline-success,
        .btn-check:active+.btn-outline-success,
        .btn-outline-success:active,
        .btn-outline-success.active,
        .btn-outline-success.dropdown-toggle.show {
            color: #ffffff;
            background-color: #6fd943 !important;
            border-color: #6fd943 !important;

        }

        .btn-outline-success:hover {
            color: #ffffff;
            background-color: #6fd943 !important;
            border-color: #6fd943 !important;
        }

        .btn.btn-outline-success {
            color: #6fd943;
            border-color: #6fd943 !important;
        }
    </style>
@endif
@if ($color == 'theme-2')
    <style>
        .btn-check:checked+.btn-outline-success,
        .btn-check:active+.btn-outline-success,
        .btn-outline-success:active,
        .btn-outline-success.active,
        .btn-outline-success.dropdown-toggle.show {
            color: #ffffff;
            background: linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #4ebbd3 99.86%)#1f3996 !important;
            border-color: #1F3996 !important;

        }

        .btn-outline-success:hover {
            color: #ffffff;
            background: linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #4ebbd3 99.86%)#1f3996 !important;
            border-color: #1F3996 !important;
        }

        .btn.btn-outline-success {
            color: #1F3996;
            border-color: #1F3996 !important;
        }
    </style>
@endif
@if ($color == 'theme-4')
    <style>
        .btn-check:checked+.btn-outline-success,
        .btn-check:active+.btn-outline-success,
        .btn-outline-success:active,
        .btn-outline-success.active,
        .btn-outline-success.dropdown-toggle.show {
            color: #ffffff;
            background-color: #584ed2 !important;
            border-color: #584ed2 !important;

        }

        .btn-outline-success:hover {
            color: #ffffff;
            background-color: #584ed2 !important;
            border-color: #584ed2 !important;
        }

        .btn.btn-outline-success {
            color: #584ed2;
            border-color: #584ed2 !important;
        }
    </style>
@endif
@if ($color == 'theme-1')
    <style>
        .btn-check:checked+.btn-outline-success,
        .btn-check:active+.btn-outline-success,
        .btn-outline-success:active,
        .btn-outline-success.active,
        .btn-outline-success.dropdown-toggle.show {
            color: #ffffff;
            background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
            border-color: #51459d !important;

        }

        .btn-outline-success:hover {
            color: #ffffff;
            background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
            border-color: #51459d !important;
        }

        .btn.btn-outline-success {
            color: #51459d;
            border-color: #51459d !important;
        }
    </style>
@endif
@push('custom-scripts')
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        });
        var multipleCancelButton = new Choices(
            '#choices-multiple-remove-button', {
                removeItemButton: true,
            }
        );
        var multipleCancelButton = new Choices(
            '#choices-multiple-remove-button1', {
                removeItemButton: true,
            }
        );
        var multipleCancelButton = new Choices(
            '#choices-multiple-remove-button2', {
                removeItemButton: true,
            }
        );
    </script>
    <script>
        $(document).ready(function() {
            if ($('.gdpr_fulltime').is(':checked')) {

                $('.fulltime').show();
            } else {

                $('.fulltime').hide();
            }

            $('#gdpr_cookie').on('change', function() {
                if ($('.gdpr_fulltime').is(':checked')) {

                    $('.fulltime').show();
                } else {

                    $('.fulltime').hide();
                }
            });
        });
    </script>
    <script src="{{ asset('custom/libs/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>
    <script>
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            show_toastr('Success', "{{ __('Link copied') }}", 'success');
        }

        $(document).on('click', 'input[name="theme_color"]', function() {
            var eleParent = $(this).attr('data-theme');
            $('#themefile').val(eleParent);
            var imgpath = $(this).attr('data-imgpath');
            $('.' + eleParent + '_img').attr('src', imgpath);
        });

        $(document).ready(function() {
            setTimeout(function(e) {
                var checked = $("input[type=radio][name='theme_color']:checked");
                $('#themefile').val(checked.attr('data-theme'));
                $('.' + checked.attr('data-theme') + '_img').attr('src', checked.attr('data-imgpath'));
            }, 300);
        });
    </script>
    <script>
        function check_theme(color_val) {

            $('.theme-color').prop('checked', false);
            $('input[value="' + color_val + '"]').prop('checked', true);
        }
    </script>

    <script type="text/javascript">
        $(document).on("click", '.send_email', function(e) {
            e.preventDefault();
            var title = $(this).attr('data-title');
            var size = 'md';
            var url = $(this).attr('data-url');

            if (typeof url != 'undefined') {
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $("#commonModal").modal('show');

                $.post(url, {
                    _token: '{{ csrf_token() }}',
                    mail_driver: $("#mail_driver").val(),
                    mail_host: $("#mail_host").val(),
                    mail_port: $("#mail_port").val(),
                    mail_username: $("#mail_username").val(),
                    mail_password: $("#mail_password").val(),
                    mail_encryption: $("#mail_encryption").val(),
                    mail_from_address: $("#mail_from_address").val(),
                    mail_from_name: $("#mail_from_name").val(),

                }, function(data) {
                    $('#commonModal .modal-body').html(data);
                });
            }
        });
        $(document).on('submit', '#test_email', function(e) {
            e.preventDefault();
            $("#email_sending").show();
            var post = $(this).serialize();
            var url = $(this).attr('action');
            $.ajax({
                type: "post",
                url: url,
                data: post,
                cache: false,
                beforeSend: function() {
                    $('#test_email .btn-create').attr('disabled', 'disabled');
                },
                success: function(data) {

                    if (data.is_success) {
                        toastrs('Success', data.message, 'success');
                    } else {
                        toastrs('Error', data.message, 'error');
                    }
                    $("#email_sending").hide();
                    $('#commonModal').modal('hide');

                },
                complete: function() {
                    $('#test_email .btn-create').removeAttr('disabled');
                },
            });
        });
    </script>

    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {

            target: '#useradd-sidenav',
            offset: 300,
        })
        $(".list-group-item").click(function() {
            $('.list-group-item').filter(function() {
                // alert('fghyht');
                // return this.href == id ;
            }).parent().removeClass('text-primary');
        });

        function check_theme(color_val) {
            $('#theme_color').prop('checked', false);
            $('input[value="' + color_val + '"]').prop('checked', true);
        }

        $(document).on('change', '[name=storage_setting]', function() {
            if ($(this).val() == 's3') {
                $('.s3-setting').removeClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').addClass('d-none');
            } else if ($(this).val() == 'wasabi') {
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').removeClass('d-none');
                $('.local-setting').addClass('d-none');
            } else {
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').removeClass('d-none');
            }
        });
    </script>
    <script>
        var custthemebg = document.querySelector("#cust-theme-bg");
        custthemebg.addEventListener("click", function() {
            if (custthemebg.checked) {
                document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.add("transprent-bg");
            } else {
                document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.remove("transprent-bg");
            }
        });
    </script>
    <script type="text/javascript">
        function enablecookie() {
            const element = $('#enable_cookie').is(':checked');
            $('.cookieDiv').addClass('disabledCookie');
            if (element == true) {
                $('.cookieDiv').removeClass('disabledCookie');
                $("#cookie_logging").attr('checked', true);
            } else {
                $('.cookieDiv').addClass('disabledCookie');
                $("#cookie_logging").attr('checked', false);
            }
        }
    </script>
    <script>
        if ($('#cust-darklayout').length > 0) {
            var custthemedark = document.querySelector("#cust-darklayout");
            custthemedark.addEventListener("click", function() {
                if (custthemedark.checked) {
                    $('#main-style-link').attr('href', '{{ env('APP_URL') }}' +
                        '/public/assets/css/style-dark.css');
                    $('.dash-sidebar .main-logo a img').attr('src', '{{ $logo . $logo_light_img }}');
                } else {
                    $('#main-style-link').attr('href', '{{ env('APP_URL') }}' + '/public/assets/css/style.css');
                    $('.dash-sidebar .main-logo a img').attr('src', '{{ $logo . $logo_img }}');
                }
            });
        }
    </script>
@endpush
@section('content')
    <div class="row mt-3">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#brand-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('Brand Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#email-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('Email Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#recaptcha-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('ReCaptcha Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#storage-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('Storage Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#Google_Setting"
                                class="list-group-item list-group-item-action border-0  ">{{ __('Google Calendar Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#cache-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('Cache Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#Webhook_Setting"
                                class="list-group-item list-group-item-action border-0  ">{{ __('Webhook Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#cookie-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('Cookie Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#chatgpt-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('ChatGPT Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div id="brand-settings" class="">
                        <div class="card">
                            {{ Form::model($settings, ['url' => 'systems', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            <div class="card-header">
                                <h5>{{ __('Brand Settings') }}</h5>
                                <small class="text-muted">{{ __('Edit your brand details') }}</small>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Logo Dark') }}</h5>
                                            </div>
                                            <div class="card-body pt-1 min-250">
                                                <div class=" setting-card">
                                                    <div class="logo-content mt-5">
                                                        <a href="{{ $logo . 'logo-dark.png' }}" target="_blank">
                                                            <img id="dark-logo" alt="your image"
                                                                src="{{ $logo . 'logo-dark.png'.'?'.time() }}" width="150px"
                                                                class="big-logo">
                                                        </a>
                                                    </div>
                                                    <div class="choose-files mt-5">
                                                        <label for="logo">
                                                            <div class="mt-3 bg-primary logo_update"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Select image') }}
                                                            </div>
                                                            <input type="file" class="form-control file" name="logo"
                                                                id="logo" data-filename="editlogo"
                                                                onchange="document.getElementById('dark-logo').src = window.URL.createObjectURL(this.files[0])">
                                                        </label>
                                                    </div>
                                                    <p class="editlogo"></p>
                                                    @error('logo')
                                                        <span class="invalid-logo text-xs text-danger"
                                                            role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Logo Light') }}</h5>
                                            </div>
                                            <div class="card-body pt-1 min-250">
                                                <div class=" setting-card">
                                                    <div class="logo-content mt-5">

                                                        <a href="{{ $logo . 'logo-light.png' }}" target="_blank">
                                                            <img id="light-logo" alt="your image"
                                                                src="{{ $logo . 'logo-light.png'.'?'.time() }}" width="150px"
                                                                class="big-logo img_setting">
                                                        </a>

                                                    </div>
                                                    <div class="choose-files mt-5 ">
                                                        <label for="landing_logo">
                                                            <div class="mt-3 bg-primary company_favicon_update"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Select image') }}
                                                            </div>
                                                            <input type="file" class="form-control file"
                                                                name="landing_logo" id="landing_logo"
                                                                data-filename="landing_logo_update"
                                                                onchange="document.getElementById('light-logo').src = window.URL.createObjectURL(this.files[0])">
                                                        </label>
                                                    </div>
                                                    @error('landing_logo')
                                                        <span class="invalid-company_favicon text-xs text-danger"
                                                            role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Favicon') }}</h5>
                                            </div>
                                            <div class="card-body min-250">
                                                <div class=" setting-card">
                                                    <div class="logo-content mt-4">

                                                        <a href="{{ $logo . (isset($logo) && !empty($logo) ? $logo : 'favicon.png') }}"
                                                            target="_blank">
                                                            <img id="favicon-logo" alt="your image"
                                                                src="{{ $logo . 'favicon.png'.'?'.time() }}" width="50px"
                                                                class="img_setting">
                                                        </a>
                                                    </div>
                                                    <div class="choose-files mt-5 ">
                                                        <label for="favicon">
                                                            <div class="mt-3 bg-primary company_favicon_update"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Select image') }}
                                                            </div>
                                                            <input type="file" class="form-control file"
                                                                name="favicon" id="favicon"
                                                                data-filename="favicon_update"
                                                                onchange="document.getElementById('favicon-logo').src = window.URL.createObjectURL(this.files[0])">
                                                        </label>
                                                    </div>
                                                    @error('favicon')
                                                        <span class="invalid-company_favicon text-xs text-danger"
                                                            role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12 col-md-612">
                                        <div class="row mt-4">
                                            <div class="col-md-6 col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    {{ Form::label('title_text', __('Title Text'), ['class' => 'form-label']) }}
                                                    {{ Form::text('title_text', null, ['class' => 'form-control', 'placeholder' => __('Title Text')]) }}
                                                    @error('title_text')
                                                        <span class="invalid-title_text" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    {{ Form::label('footer_text', __('Footer Text'), ['class' => 'form-label']) }}
                                                    {{ Form::text('footer_text', null, ['class' => 'form-control', 'placeholder' => __('Footer Text')]) }}
                                                    @error('footer_text')
                                                        <span class="invalid-footer_text" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    {{ Form::label('default_language', __('Default Language'), ['class' => 'form-label']) }}
                                                    <div class="changeLanguage">
                                                        <select name="default_language" id="default_language"
                                                            class="form-control select2">
                                                            @foreach (App\Models\Utility::languages() as $code => $language)
                                                                <option @if ($lang == $code) selected @endif
                                                                    value="{{ $code }}">
                                                                    {{ ucFirst($language) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    {{ Form::label('company_email', __('System Email'), ['class' => 'form-label']) }}
                                                    <small>{{ __('(Note:For appointment mail send.)') }}</small>
                                                    {{ Form::text('company_email', null, ['class' => 'form-control', 'placeholder' => __('System Email')]) }}
                                                    @error('company_email')
                                                        <span class="invalid-title_text" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    {{ Form::label('company_email_from_name', __('Email (From Name)'), ['class' => 'form-label']) }}
                                                    <small>{{ __('(Note:For appointment mail send.)') }}</small>
                                                    {{ Form::text('company_email_from_name', null, ['class' => 'form-control', 'placeholder' => __('Email (From Name)')]) }}
                                                    @error('company_email_from_name')
                                                        <span class="invalid-title_text" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    {{ Form::label('timezone', __('Timezone'), ['class' => 'form-label']) }}
                                                    <select type="text" name="timezone" class="form-control"
                                                        id="timezone">
                                                        <option value="">{{ __('Select Timezone') }}</option>

                                                        @foreach ($timezones as $k => $timezone)
                                                            <option value="{{ $k }}"
                                                                {{ env('APP_TIMEZONE') == $k ? 'selected' : '' }}>
                                                                {{ $timezone }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    {{ Form::label('SITE_RTL', __('Enable RTL'), ['class' => 'form-label']) }}

                                                    <div
                                                        class="d-flex align-items-center  justify-content-between border-0  py-2 borderleft">
                                                        <input type="checkbox" data-toggle="switchbutton"
                                                            data-onstyle="primary" name="SITE_RTL" id="SITE_RTL"
                                                            {{ env('SITE_RTL') == 'on' ? 'checked="checked"' : '' }}>

                                                        <label class="form-label" for="SITE_RTL"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    {{ Form::label('Landing Page Display', __('Landing Page Display'), ['class' => 'form-label']) }}
                                                    <div
                                                        class="d-flex align-items-center  justify-content-between border-0  py-2 borderleft">
                                                        <input type="checkbox" data-toggle="switchbutton"
                                                            data-onstyle="primary" name="display_landing_page"
                                                            id="display_landing_page"
                                                            {{ $settings['display_landing_page'] == 'on' ? 'checked="checked"' : '' }}>

                                                        <label class="custom-control-label form-control-label"
                                                            for="display_landing_page"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="setting-card setting-logo-box p-3">
                                            <div class="row">
                                                <h4 class="small-title">{{ __('Theme Customizer') }}</h4>
                                                <div class="col-lg-4 col-xl-4 col-md-4 my-auto">
                                                    <h6 class="mt-2">
                                                        <i data-feather="credit-card"
                                                            class="me-2"></i>{{ __('Primary Color Settings') }}
                                                    </h6>
                                                    <hr class="my-2" />
                                                    <div class="theme-color themes-color">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-1' ? 'active_color' : '' }}"
                                                            data-value="theme-1" onclick="check_theme('theme-1')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-1" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-2' ? 'active_color' : '' }} "
                                                            data-value="theme-2" onclick="check_theme('theme-2')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-2" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-3' ? 'active_color' : '' }}"
                                                            data-value="theme-3" onclick="check_theme('theme-3')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-3" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-4' ? 'active_color' : '' }}"
                                                            data-value="theme-4" onclick="check_theme('theme-4')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-4" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-5' ? 'active_color' : '' }}"
                                                            data-value="theme-5" onclick="check_theme('theme-5')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-5" style="display: none;">
                                                        <br>
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-6' ? 'active_color' : '' }}"
                                                            data-value="theme-6" onclick="check_theme('theme-6')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-6" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-7' ? 'active_color' : '' }}"
                                                            data-value="theme-7" onclick="check_theme('theme-7')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-7" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-8' ? 'active_color' : '' }}"
                                                            data-value="theme-8" onclick="check_theme('theme-8')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-8" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-9' ? 'active_color' : '' }}"
                                                            data-value="theme-9" onclick="check_theme('theme-9')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-9" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-10' ? 'active_color' : '' }}"
                                                            data-value="theme-10" onclick="check_theme('theme-10')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-10" style="display: none;">
                                                    </div>

                                                </div>
                                                <div class="col-lg-4 col-xl-4 col-md-4 my-auto mt-2">
                                                    <h6>
                                                        <i data-feather="layout"
                                                            class="me-2"></i>{{ __('Sidebar Settings') }}
                                                    </h6>
                                                    <hr class="my-2" />
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="cust-theme-bg" name="cust_theme_bg"
                                                            {{ Utility::getValByName('cust_theme_bg') == 'on' ? 'checked' : '' }} />
                                                        <label class="form-check-label f-w-600 pl-1"
                                                            for="cust-theme-bg">{{ __('Transparent layout') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xl-4 col-md-4 my-auto mt-2">
                                                    <h6>
                                                        <i data-feather="sun"
                                                            class="me-2"></i>{{ __('Layout Settings') }}
                                                    </h6>
                                                    <hr class="my-2" />
                                                    <div class="form-check form-switch mt-2">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="cust-darklayout" name="cust_darklayout"
                                                            {{ Utility::getValByName('cust_darklayout') == 'on' ? 'checked' : '' }} />
                                                        <label class="form-check-label f-w-600 pl-1"
                                                            for="cust-darklayout">{{ __('Dark Layout') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>

                            </div>
                            <div class="card-footer text-end">
                                {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-print-invoice  btn-primary']) }}
                            </div>
                            {{ Form::close() }}
                        </div>

                        <div id="email-settings" class="card">
                            <div class="card-header">
                                <h5>{{ __('Email Settings') }}</h5>
                                <small class="text-muted">{{ __('Edit your email details') }}</small>
                            </div>
                            {{ Form::open(['route' => 'email.settings', 'method' => 'post']) }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_driver', __('Mail Driver'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_driver', env('MAIL_DRIVER'), ['class' => 'form-control', 'placeholder' => __('Enter Mail Driver')]) }}
                                            @error('mail_driver')
                                                <span class="invalid-mail_driver" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_host', __('Mail Host'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_host', env('MAIL_HOST'), ['class' => 'form-control ', 'placeholder' => __('Enter Mail Host')]) }}
                                            @error('mail_host')
                                                <span class="invalid-mail_driver" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_port', __('Mail Port'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_port', env('MAIL_PORT'), ['class' => 'form-control', 'placeholder' => __('Enter Mail Port')]) }}
                                            @error('mail_port')
                                                <span class="invalid-mail_port" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_username', __('Mail Username'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_username', env('MAIL_USERNAME'), ['class' => 'form-control', 'placeholder' => __('Enter Mail Username')]) }}
                                            @error('mail_username')
                                                <span class="invalid-mail_username" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_password', __('Mail Password'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_password', env('MAIL_PASSWORD'), ['class' => 'form-control', 'placeholder' => __('Enter Mail Password')]) }}
                                            @error('mail_password')
                                                <span class="invalid-mail_password" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_encryption', __('Mail Encryption'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_encryption', env('MAIL_ENCRYPTION'), ['class' => 'form-control', 'placeholder' => __('Enter Mail Encryption')]) }}
                                            @error('mail_encryption')
                                                <span class="invalid-mail_encryption" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_from_address', __('Mail From Address'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_from_address', env('MAIL_FROM_ADDRESS'), ['class' => 'form-control', 'placeholder' => __('Enter Mail From Address')]) }}
                                            @error('mail_from_address')
                                                <span class="invalid-mail_from_address" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_from_name', __('Mail From Name'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_from_name', env('MAIL_FROM_NAME'), ['class' => 'form-control', 'placeholder' => __('Enter Mail Name')]) }}
                                            @error('mail_from_name')
                                                <span class="invalid-mail_from_name" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-auto form-group">
                                        <a href="#" data-url="{{ route('test.mail') }}" data-ajax-popup="true"
                                            data-title="{{ __('Send Test Mail') }}"
                                            class="send_email btn m-r-10 mt-1 btn-primary">
                                            {{ __('Send Test Mail') }}
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-print-invoice  btn-primary ']) }}
                                    </div>
                                </div>

                            </div>
                            {{ Form::close() }}
                        </div>
                        <div id="recaptcha-settings" class="card">
                            <form method="POST" action="{{ route('recaptcha.settings.store') }}"
                                accept-charset="UTF-8">
                                @csrf
                                <div class="card-header row d-flex justify-content-between">
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <h5>{{ __('ReCaptcha Settings') }}</h5>
                                        <small class="text-muted"><a
                                                href="https://phppot.com/php/how-to-get-google-recaptcha-site-and-secret-key/"
                                                target="_blank" class="text-muted">
                                                ({{ __('How to Get Google reCaptcha Site and Secret key') }})
                                            </a>
                                        </small><br>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 text-end">
                                        <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary"
                                            name="recaptcha_module" id="recaptcha_module" value="yes"
                                            {{ env('RECAPTCHA_MODULE') == 'yes' ? 'checked="checked"' : '' }}>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                                <label for="google_recaptcha_key"
                                                    class="form-label">{{ __('Google Recaptcha Key') }}</label>
                                                <input class="form-control"
                                                    placeholder="{{ __('Enter Google Recaptcha Key') }}"
                                                    name="google_recaptcha_key" type="text"
                                                    value="{{ env('NOCAPTCHA_SITEKEY') }}" id="google_recaptcha_key">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                                <label for="google_recaptcha_secret"
                                                    class="form-label">{{ __('Google Recaptcha Secret') }}</label>
                                                <input class="form-control "
                                                    placeholder="{{ __('Enter Google Recaptcha Secret') }}"
                                                    name="google_recaptcha_secret" type="text"
                                                    value="{{ env('NOCAPTCHA_SECRET') }}" id="google_recaptcha_secret">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <div class="row">
                                        <div class="form-group float-end">
                                            {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-print-invoice  btn-primary']) }}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="storage-settings" class="card mb-3">
                            {{ Form::open(['route' => 'storage.setting.store', 'enctype' => 'multipart/form-data']) }}
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                        <h5 class="">{{ __('Storage Settings') }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="pe-2">
                                        <input type="radio" class="btn-check" name="storage_setting"
                                            id="local-outlined" autocomplete="off"
                                            {{ $setting['storage_setting'] == 'local' ? 'checked' : '' }} value="local"
                                            checked>
                                        <label class="btn btn-outline-primary"
                                            for="local-outlined">{{ __('Local') }}</label>
                                    </div>
                                    <div class="pe-2">
                                        <input type="radio" class="btn-check" name="storage_setting" id="s3-outlined"
                                            autocomplete="off" {{ $setting['storage_setting'] == 's3' ? 'checked' : '' }}
                                            value="s3">
                                        <label class="btn btn-outline-primary" for="s3-outlined">
                                            {{ __('AWS S3') }}</label>
                                    </div>

                                    <div class="pe-2">
                                        <input type="radio" class="btn-check" name="storage_setting"
                                            id="wasabi-outlined" autocomplete="off"
                                            {{ $setting['storage_setting'] == 'wasabi' ? 'checked' : '' }}
                                            value="wasabi">
                                        <label class="btn btn-outline-primary"
                                            for="wasabi-outlined">{{ __('Wasabi') }}</label>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div
                                        class="local-setting row {{ $setting['storage_setting'] == 'local' ? ' ' : 'd-none' }}">
                                        <div class="col-lg-8 col-md-11 col-sm-12">
                                            {{ Form::label('local_storage_validation', __('Only Upload Files'), ['class' => ' form-label']) }}
                                            <select name="local_storage_validation[]" class="form-control"
                                                name="choices-multiple-remove-button" id="choices-multiple-remove-button"
                                                placeholder="This is a placeholder" multiple>
                                                @foreach ($file_type as $f)
                                                    <option @if (in_array($f, $local_storage_validations)) selected @endif>
                                                        {{ $f }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="local_storage_max_upload_size">{{ __('Max upload size ( In KB)') }}</label>
                                                <input type="number" name="local_storage_max_upload_size"
                                                    class="form-control"
                                                    value="{{ !isset($setting['local_storage_max_upload_size']) || is_null($setting['local_storage_max_upload_size']) ? '' : $setting['local_storage_max_upload_size'] }}"
                                                    placeholder="{{ __('Max upload size') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="s3-setting row {{ $setting['storage_setting'] == 's3' ? ' ' : 'd-none' }}">

                                        <div class=" row ">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="s3_key">{{ __('S3 Key') }}</label>
                                                    <input type="text" name="s3_key" class="form-control"
                                                        value="{{ !isset($setting['s3_key']) || is_null($setting['s3_key']) ? '' : $setting['s3_key'] }}"
                                                        placeholder="{{ __('S3 Key') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_secret">{{ __('S3 Secret') }}</label>
                                                    <input type="text" name="s3_secret" class="form-control"
                                                        value="{{ !isset($setting['s3_secret']) || is_null($setting['s3_secret']) ? '' : $setting['s3_secret'] }}"
                                                        placeholder="{{ __('S3 Secret') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_region">{{ __('S3 Region') }}</label>
                                                    <input type="text" name="s3_region" class="form-control"
                                                        value="{{ !isset($setting['s3_region']) || is_null($setting['s3_region']) ? '' : $setting['s3_region'] }}"
                                                        placeholder="{{ __('S3 Region') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_bucket">{{ __('S3 Bucket') }}</label>
                                                    <input type="text" name="s3_bucket" class="form-control"
                                                        value="{{ !isset($setting['s3_bucket']) || is_null($setting['s3_bucket']) ? '' : $setting['s3_bucket'] }}"
                                                        placeholder="{{ __('S3 Bucket') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="s3_url">{{ __('S3 URL') }}</label>
                                                    <input type="text" name="s3_url" class="form-control"
                                                        value="{{ !isset($setting['s3_url']) || is_null($setting['s3_url']) ? '' : $setting['s3_url'] }}"
                                                        placeholder="{{ __('S3 URL') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_endpoint">{{ __('S3 Endpoint') }}</label>
                                                    <input type="text" name="s3_endpoint" class="form-control"
                                                        value="{{ !isset($setting['s3_endpoint']) || is_null($setting['s3_endpoint']) ? '' : $setting['s3_endpoint'] }}"
                                                        placeholder="{{ __('S3 Endpoint') }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-8 switch-width">
                                                {{ Form::label('s3_storage_validation', __('Only Upload Files'), ['class' => ' form-label']) }}
                                                <select name="s3_storage_validation[]" class="form-control"
                                                    name="choices-multiple-remove-button"
                                                    id="choices-multiple-remove-button1"
                                                    placeholder="This is a placeholder" multiple>
                                                    @foreach ($file_type as $f)
                                                        <option @if (in_array($f, $s3_storage_validations)) selected @endif>
                                                            {{ $f }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_max_upload_size">{{ __('Max upload size ( In KB)') }}</label>
                                                    <input type="number" name="s3_max_upload_size" class="form-control"
                                                        value="{{ !isset($setting['s3_max_upload_size']) || is_null($setting['s3_max_upload_size']) ? '' : $setting['s3_max_upload_size'] }}"
                                                        placeholder="{{ __('Max upload size') }}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div
                                        class="wasabi-setting row {{ $setting['storage_setting'] == 'wasabi' ? ' ' : 'd-none' }}">
                                        <div class=" row ">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_key">{{ __('Wasabi Key') }}</label>
                                                    <input type="text" name="wasabi_key" class="form-control"
                                                        value="{{ !isset($setting['wasabi_key']) || is_null($setting['wasabi_key']) ? '' : $setting['wasabi_key'] }}"
                                                        placeholder="{{ __('Wasabi Key') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_secret">{{ __('Wasabi Secret') }}</label>
                                                    <input type="text" name="wasabi_secret" class="form-control"
                                                        value="{{ !isset($setting['wasabi_secret']) || is_null($setting['wasabi_secret']) ? '' : $setting['wasabi_secret'] }}"
                                                        placeholder="{{ __('Wasabi Secret') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_region">{{ __('Wasabi Region') }}</label>
                                                    <input type="text" name="wasabi_region" class="form-control"
                                                        value="{{ !isset($setting['wasabi_region']) || is_null($setting['wasabi_region']) ? '' : $setting['wasabi_region'] }}"
                                                        placeholder="{{ __('Wasabi Region') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="wasabi_bucket">{{ __('Wasabi Bucket') }}</label>
                                                    <input type="text" name="wasabi_bucket" class="form-control"
                                                        value="{{ !isset($setting['wasabi_bucket']) || is_null($setting['wasabi_bucket']) ? '' : $setting['wasabi_bucket'] }}"
                                                        placeholder="{{ __('Wasabi Bucket') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="wasabi_url">{{ __('Wasabi URL') }}</label>
                                                    <input type="text" name="wasabi_url" class="form-control"
                                                        value="{{ !isset($setting['wasabi_url']) || is_null($setting['wasabi_url']) ? '' : $setting['wasabi_url'] }}"
                                                        placeholder="{{ __('Wasabi URL') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="wasabi_root">{{ __('Wasabi Root') }}</label>
                                                    <input type="text" name="wasabi_root" class="form-control"
                                                        value="{{ !isset($setting['wasabi_root']) || is_null($setting['wasabi_root']) ? '' : $setting['wasabi_root'] }}"
                                                        placeholder="{{ __('Wasabi Root') }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-8 switch-width">
                                                {{ Form::label('wasabi_storage_validation', __('Only Upload Files'), ['class' => 'form-label']) }}

                                                <select name="wasabi_storage_validation[]" class="form-control"
                                                    name="choices-multiple-remove-button"
                                                    id="choices-multiple-remove-button2"
                                                    placeholder="This is a placeholder" multiple>
                                                    @foreach ($file_type as $f)
                                                        <option @if (in_array($f, $wasabi_storage_validations)) selected @endif>
                                                            {{ $f }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="wasabi_root">{{ __('Max upload size ( In KB)') }}</label>
                                                    <input type="number" name="wasabi_max_upload_size"
                                                        class="form-control"
                                                        value="{{ !isset($setting['wasabi_max_upload_size']) || is_null($setting['wasabi_max_upload_size']) ? '' : $setting['wasabi_max_upload_size'] }}"
                                                        placeholder="{{ __('Max upload size') }}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div><br>
                            </div>
                            <div class="card-footer text-end">
                                <input class="btn btn-print-invoice  btn-primary " type="submit"
                                    value="{{ __('Save Changes') }}">

                            </div>
                            {{ Form::close() }}
                        </div>
                        <div id="Google_Settings" class="card text-white">
                            {{ Form::open(['url' => route('setting.GoogleCalendaSetting'), 'enctype' => 'multipart/form-data']) }}
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <h5 class="">{{ __('Google Calendar Settings') }}</h5>
                                        <small
                                            class="text-secondary font-weight-bold">{{ __('Edit your Google Calendar') }}</small>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 text-end">

                                        <input type="hidden" name="is_mercado_enabled" value="off">
                                        <input type="checkbox" name="Google_Calendar" id="Google_Calendar"
                                            data-toggle="switchbutton" data-onstyle="primary"
                                            {{ isset($settings['Google_Calendar']) && $settings['Google_Calendar'] == 'on' ? 'checked="checked"' : '' }}>
                                        <label class="custom-label form-label" for="Google_Calendar"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label h6">{{ __('Google calendar id') }}</label>
                                            <input type="text" name="google_calender_id" class="form-control"
                                                placeholder="Enter Google calendar id"
                                                value="{{ !empty($settings['google_calender_id']) ? $settings['google_calender_id'] : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label h6">{{ __('Google calendar json file') }}</label>
                                        <input type="file" name="google_calender_json_file" id="json_file"
                                            class="form-control custom-input-file"
                                            placeholder="Enter Google calendar json file"
                                            value="{{ !empty($settings['google_calender_json_file']) ? $settings['google_calender_json_file'] : '' }}">
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer  text-end">
                                {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-primary']) }}
                            </div>
                            {{ Form::close() }}
                        </div>
                        <div id="cache-settings" class="card">
                            <form method="POST" action="{{ route('cache.settings.clear') }}" accept-charset="UTF-8">
                                @csrf
                                <div class="card-header row d-flex justify-content-between">
                                    <div class="col-auto">
                                        <h5>{{ __('Cache Settings') }}</h5>
                                        <small class="text-muted"><a
                                                href="https://phppot.com/php/how-to-get-google-recaptcha-site-and-secret-key/"
                                                target="_blank" class="text-muted">
                                                {{ __("This is a page meant for more advanced users, simply ignore it if you don't understand what cache is.") }}
                                            </a>
                                        </small><br>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label for="current_cache_size"
                                                    class="form-label">{{ __('Current cache size') }}</label>
                                                <div class="input-group search-form">
                                                    <input type="text" value="{{ $file_size }}"
                                                        class="form-control" disabled>
                                                    <span
                                                        class="input-group-text bg-transparent">{{ __('MB') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <div class="row">
                                        <div class="form-group  float-end">
                                            {{ Form::submit(__('Clear Cache'), ['class' => 'btn btn-print-invoice  btn-primary ']) }}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- Webhook Setting Start --}}
                        <div id="Webhook_Setting" class="card text-white">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <h5 class="">{{ __('Webhook Settings') }}</h5>
                                        <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
                                            data-bs-placement="top">
                                            <a href="#"
                                                class="btn btn-sm btn-primary btn-icon justify-content-center m-1 wid-30 hei-30 lh-1 align-items-center d-flex"
                                                data-bs-target="#exampleModal" data-url="{{ route('webhook.create') }}"
                                                data-bs-whatever="{{ __('Create Webhook') }}" data-bs-toggle="modal">
                                                <span class="text-white">
                                                    <i class="ti ti-plus text-white" data-bs-toggle="tooltip"
                                                        data-bs-original-title="{{ __('Create Webhook') }}"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th> {{ __('Module') }}</th>
                                                <th> {{ __('Method') }}</th>
                                                <th> {{ __('URL') }}</th>
                                                <th class="text-right"> {{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($webhook as $webhook_detail)
                                                <tr>
                                                    <td>{{ $webhook_detail->module }}</td>
                                                    <td>{{ $webhook_detail->method }}</td>
                                                    <td>{{ $webhook_detail->url }}</td>
                                                    <td class="action">
                                                        <div class="action-btn bg-info  ms-2">
                                                            <a href="#"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-toggle="modal" data-target="#commonModal"
                                                                data-ajax-popup="true" data-size="md"
                                                                data-url="{{ route('webhook.edit', $webhook_detail->id) }}"
                                                                data-title="{{ __('Webhook Edit') }}"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-original-title="{{ __('Webhook Edit') }}"> <span
                                                                    class="text-white"><i
                                                                        class="ti ti-edit text-white    "></i></span></a>
                                                        </div>
                                                        <div class="action-btn bg-danger ms-2">
                                                            <a href="#"
                                                                class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="delete-form-{{ $webhook_detail->id }}"
                                                                title="{{ __('Delete') }}" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"><span class="text-white"><i
                                                                        class="ti ti-trash"></i></span></a>
                                                        </div>
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['webhook.destroy', $webhook_detail->id],
                                                            'id' => 'delete-form-' . $webhook_detail->id,
                                                        ]) !!}
                                                        {!! Form::close() !!}

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>


                            </div>

                        </div>
                        {{-- Webhook Setting End --}}
                        {{-- Cookie Code Start --}}
                        <div class="card" id="cookie-settings">
                            {{ Form::model($settings, ['route' => 'cookie.setting', 'method' => 'post']) }}
                            <div
                                class="card-header flex-column flex-lg-row  d-flex align-items-lg-center gap-2 justify-content-between">
                                <h5>{{ __('Cookie Settings') }}</h5>
                                <div class="d-flex align-items-center">
                                    {{ Form::label('enable_cookie', __('Enable cookie'), ['class' => 'col-form-label p-0 fw-bold me-3']) }}
                                    <div class="custom-control custom-switch" onclick="enablecookie()">
                                        <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary"
                                            name="enable_cookie" class="form-check-input input-primary "
                                            id="enable_cookie"
                                            {{ $settings['enable_cookie'] == 'on' ? ' checked ' : '' }}>
                                        <label class="custom-control-label mb-1" for="enable_cookie"></label>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="card-body cookieDiv {{ $settings['enable_cookie'] == 'off' ? 'disabledCookie ' : '' }}">
                                @if ($chatgpt_setting['enable_chatgpt'] == 'on')
                                    <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end {{ $settings['enable_cookie'] == 'off' ? 'disabledCookie ' : '' }}"
                                        data-bs-placement="top">
                                        <a href="#" data-size="lg" class="btn btn-sm btn-primary"
                                            data-ajax-popup-over="true" data-url="{{ route('generate', ['cookie']) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ __('Generate') }}"
                                            data-title="{{ __('Generate content with AI') }}">
                                            <i class="fas fa-robot"></i>&nbsp;{{ __('Generate with AI') }}
                                        </a>
                                    </div>
                                @endif
                                <div class="row ">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch custom-switch-v1" id="cookie_log">
                                            <input type="checkbox" name="cookie_logging"
                                                class="form-check-input input-primary cookie_setting"
                                                id="cookie_logging"{{ $settings['cookie_logging'] == 'on' ? ' checked ' : '' }}>
                                            <label class="form-check-label"
                                                for="cookie_logging">{{ __('Enable logging') }}</label>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('cookie_title', __('Cookie Title'), ['class' => 'col-form-label']) }}
                                            {{ Form::text('cookie_title', null, ['class' => 'form-control cookie_setting']) }}
                                        </div>
                                        <div class="form-group ">
                                            {{ Form::label('cookie_description', __('Cookie Description'), ['class' => ' form-label']) }}
                                            {!! Form::textarea('cookie_description', null, ['class' => 'form-control cookie_setting', 'rows' => '3']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch custom-switch-v1 ">
                                            <input type="checkbox" name="necessary_cookies"
                                                class="form-check-input input-primary" id="necessary_cookies" checked
                                                onclick="return false">
                                            <label class="form-check-label"
                                                for="necessary_cookies">{{ __('Strictly necessary cookies') }}</label>
                                        </div>
                                        <div class="form-group ">
                                            {{ Form::label('strictly_cookie_title', __(' Strictly Cookie Title'), ['class' => 'col-form-label']) }}
                                            {{ Form::text('strictly_cookie_title', null, ['class' => 'form-control cookie_setting']) }}
                                        </div>
                                        <div class="form-group ">
                                            {{ Form::label('strictly_cookie_description', __('Strictly Cookie Description'), ['class' => ' form-label']) }}
                                            {!! Form::textarea('strictly_cookie_description', null, [
                                                'class' => 'form-control cookie_setting ',
                                                'rows' => '3',
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <h5>{{ __('More Information') }}</h5>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            {{ Form::label('more_information_description', __('Contact Us Description'), ['class' => 'col-form-label']) }}
                                            {{ Form::text('more_information_description', null, ['class' => 'form-control cookie_setting']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            {{ Form::label('contactus_url', __('Contact Us URL'), ['class' => 'col-form-label']) }}
                                            {{ Form::text('contactus_url', null, ['class' => 'form-control cookie_setting']) }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div
                                class="card-footer d-flex align-items-center gap-2 flex-sm-column flex-lg-row justify-content-between">
                                <div>
                                    @if (isset($settings['cookie_logging']) && $settings['cookie_logging'] == 'on')
                                        <label for="file"
                                            class="form-label">{{ __('Download cookie accepted data') }}</label>
                                        <a href="{{ asset(Storage::url('uploads/sample')) . '/data.csv' }}"
                                            class="btn btn-primary mr-2 ">
                                            <i class="ti ti-download"></i>
                                        </a>
                                    @endif
                                </div>
                                <input type="submit" value="{{ __('Save Changes') }}" class="btn btn-primary">
                            </div>
                            {{ Form::close() }}
                        </div>
                        {{-- Cookie Code End --}}
                        {{-- Chatgtp --}}
                        <div class="tab-pane " id="chatgpt-settings" role="tabpanel"
                            aria-labelledby="pills-chatgpt-tab">
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card">
                                    {{ Form::model($settings, ['route' => 'settings.chatgptkey', 'method' => 'post']) }}
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8">
                                                <h5>{{ __('Chat GPT Key Settings') }}</h5>
                                                <small>{{ __('Edit your key details') }}</small>
                                            </div>
                                            <div class="col-lg-4 col-md-4 text-end">
                                                <div class="custom-control custom-switch">
                                                    {{-- <input type="hidden" name="enable_chatgpt" value="off"> --}}
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="enable_chatgpt" data-toggle="switchbutton"
                                                        data-onstyle="primary" id="enable_chatgpt"
                                                        {{ isset($setting['enable_chatgpt']) && $setting['enable_chatgpt'] == 'on' ? 'checked' : '' }}>
                                                    <label class="custom-control-label mb-1 "
                                                        for="enable_chatgpt"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group">
                                                {{ Form::text('chatgpt_key', isset($settings['chatgpt_key']) ? $settings['chatgpt_key'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Chatgpt Key Here')]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                        {{-- Chatgtp End --}}
                        <!-- [ sample-page ] end -->
                    </div>
                    <!-- [ Main Content ] end -->
                </div>
            </div>
        </div>
    </div>
@endsection
