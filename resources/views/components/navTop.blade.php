<div class="nav-top">
    <div class="container d-flex flex-row" style="max-width: 1700px !important">
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <!-- Logo Header -->
        <a href="{{ url('/') }}" class="logo d-flex align-self-center d-inline float-left">
            <img src="{{ asset('assets/landingPage') }}/img/logo-header.png" alt="navbar brand" class="navbar-brand"
                width="230px">
        </a>

        <!-- End Logo Header -->

        <!-- Navbar Header -->
        <nav class="navbar navbar-header navbar-expand-lg p-0">

            <div class="container p-0 mr-0">
                <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                    <li class="nav-item dropdown hidden-caret">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                            <div class="avatar-sm">
                                <img src="{{ asset('assets/dashboard') }}/img/user.png" alt="..."
                                    class="avatar-img rounded-circle">
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-user animated fadeIn">
                            <div class="dropdown-user-scroll scrollbar-outer">
                                <li>
                                    <div class="user-box d-flex align-items-center">
                                        <div class="avatar-lg"><img
                                                src="{{ asset('assets/dashboard') }}/img/user.png" alt="image profile"
                                                class="avatar-img rounded"></div>
                                        <div class="u-text">
                                            <h4 class="text-truncate" style="width: 150px">
                                                {{ Auth::user()->profile->nama_lengkap ?? Auth::user()->username }}
                                            </h4>
                                            <p class="text-muted">{{ Auth::user()->role }}</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ url('/edit-profile-account') }}">Ubah Profil /
                                        Akun</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ url('/logout') }}">Keluar</a>
                                </li>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End Navbar -->
    </div>
</div>
