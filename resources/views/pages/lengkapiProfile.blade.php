<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Lengkapi Profil</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('assets/logo') }}/untad.png" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/dashboard') }}/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands", "simple-line-icons"
                ],
                urls: ['assets/dashboard/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/atlantis.css">
    <style>
        .login {
            background: url('{{ asset('assets/dashboard/img/new1.jpg') }}');
            background-size: cover;
        }
    </style>
</head>

<body class="login">
    {{-- <div class="wrapper wrapper-login shadow-lg"> --}}
    <div class="row my-5 px-3 justify-content-center">
        <div class="col-lg-8 col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title text-center">Lengkapi Profil Anda Terlebih Dahulu</div>
                </div>
                <div class="card-body">
                    @component('components.form.formProfilePersonal')
                        @slot('profile', $profile ?? '')
                        @slot('institusi', $institusi ?? '')
                        @slot('form_id', 'form_edit_profile2')
                        @slot('action', route('updateProfile'))
                        @slot('method', 'POST')
                        @slot('back_url', route('dashboard'))
                    @endcomponent
                </div>
            </div>
        </div>
        {{-- </div> --}}
        <script src="{{ asset('assets/dashboard') }}/js/core/jquery.3.2.1.min.js"></script>
        <script src="{{ asset('assets/dashboard') }}/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
        <script src="{{ asset('assets/dashboard') }}/js/core/popper.min.js"></script>
        <script src="{{ asset('assets/dashboard') }}/js/core/bootstrap.min.js"></script>
        <script src="{{ asset('assets/dashboard') }}/js/atlantis.min.js"></script>
        <script src="{{ asset('assets/dashboard') }}/js/plugin/select2/select2.full.min.js"></script>
        <script src="{{ asset('assets/dashboard') }}/js/plugin/jquery.mask/jquery.mask.min.js"></script>
        <script src="{{ asset('assets/dashboard') }}/js/plugin/sweetalert/sweetalert.min.js"></script>

        <script>
            $('.select2').select2({
                theme: "bootstrap",
                placeholder: "- Pilih Salah Satu -",
            })

            $('.tanggal').mask('00-00-0000');
            $('.rupiah').mask('000.000.000.000.000', {
                reverse: true
            })
            $('.waktu').mask('00:00');
            $('.angka').mask('00000000000000000000');
        </script>

        @stack('script')

</body>

</html>
