<div class="nav-bottom">
    <div class="container" style="max-width: 1700px !important">
        <h3 class="title-menu d-flex d-lg-none">
            Menu
            <div class="close-menu"> <i class="flaticon-cross"></i></div>
        </h3>
        <ul class="nav page-navigation page-navigation-info bg-white">
            <li class="nav-item menu">
                <a class="nav-link" href="{{ url('/dashboard') }}">
                    <i class="link-icon icon-screen-desktop text-danger"></i>
                    <span class="menu-title">Beranda</span>
                </a>
            </li>
            @if (Auth::user()->role != 'Supervisor')
                <li class="nav-item menu">
                    <a class="nav-link" href="{{ url('/survey/daftar-survey') }}">
                        <i class="link-icon icon-book-open text-danger"></i>
                        <span class="menu-title">Survey</span>
                    </a>
                </li>
            @else
                <li class="nav-item menu">
                    <a class="nav-link" href="{{ url('/survey-supervisor/lokasi-survey') }}">
                        <i class="link-icon icon-book-open text-danger"></i>
                        <span class="menu-title">Survey</span>
                    </a>
                </li>
            @endif

            @if (in_array(Auth::user()->role, ['Admin', 'Sub Admin']))
                @if (Auth::user()->role == 'Admin')
                    <li class="nav-item menu">
                        <a class="nav-link" href="{{ url('/namaSurvey') }}">
                            <i class="link-icon icon-note text-danger"></i>
                            <span class="menu-title">Soal Survey</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item submenu" id="nav-master">
                    <a class="nav-link" href="#">
                        <i class="link-icon icon-grid text-danger"></i>
                        <span class="menu-title">Master</span>
                    </a>
                    <div class="navbar-dropdown animated fadeIn">
                        <ul>
                            <li>
                                <a href="{{ url('responden') }}">Responden</a>
                            </li>
                            <li>
                                <a href="{{ url('institusi') }}">Institusi</a>
                            </li>
                            @if (Auth::user()->role == 'Admin')
                                <li>
                                    <a href="{{ url('profile') }}">Profil</a>
                                </li>
                                <li>
                                    <a href="{{ url('user') }}">Akun</a>
                                </li>
                                <li>
                                    <a href="{{ url('wilayah-provinsi') }}">Wilayah</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ url('lokasi-survey') }}">Lokasi Survey</a>
                            </li>
                            <li>
                                <a href="{{ url('institusi-supervisor-dpl') }}">Supervisor / DPL</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            @if (Auth::user()->role == 'Supervisor')
                <li class="nav-item menu">
                    <a class="nav-link" href="{{ url('/lokasi-survey-supervisor-dpl/' . Auth::user()->profile->id) }}">
                        <i class="icon-people text-danger mr-1"> </i>
                        <span class="menu-title"> Surveyor / Mahasiswa</span>
                    </a>
                </li>
            @endif
            <li class="nav-item menu">
                <a class="nav-link" href="{{ url('/exportSurvey') }}">
                    <i class="link-icon icon-cloud-download text-danger"></i>
                    <span class="menu-title"> Export Survey</span>
                </a>
            </li>

            @if (Auth::user()->role == 'Institusi')
                <li class="nav-item menu">
                    <a class="nav-link" href="{{ url('/supervisor-dpl/' . Auth::user()->profile->institusi_id) }}">
                        <i class="icon-people text-danger"> </i> <span class="menu-title ml-1"> Supervisor/DPL</span>
                    </a>
                </li>
            @endif

            @if (!in_array(Auth::user()->role, ['Institusi', 'Supervisor', 'Sub Admin']))
                <li class="nav-item menu">
                    <a class="nav-link" href="{{ url('/importSurvey') }}">
                        <i class="link-icon icon-cloud-upload text-danger"></i>
                        <span class="menu-title"> Import Survey Android</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->role == 'Admin')
                <li class="nav-item menu">
                    <a class="nav-link" href="{{ url('/importAkun') }}">
                        <i class="link-icon icon-cloud-upload text-danger"></i>
                        <span class="menu-title"> Import Akun</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
