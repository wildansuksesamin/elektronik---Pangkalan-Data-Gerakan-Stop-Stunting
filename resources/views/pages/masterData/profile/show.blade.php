@extends('templates/dashboard')

@section('title-tab')
    Lihat Profil
@endsection

@section('title')
    Lihat Profil
@endsection

@section('subTitle')
    Profil
@endsection

@push('style')
@endpush

@section('content')
    <section>
        <div class="row mb-3 justify-content-center">
            <div class="col-lg-6 col-md-6 text-center">
                <div class="card card-pricing">
                    <div class="card-header">
                        <h4 class="card-title">{{ $profile->nama_lengkap }}</h4>
                    </div>
                    <div class="card-body">
                        <ul class="specification-list">
                            <li>
                                <span class="name-specification">Jenis Kelamin</span>
                                <span class="status-specification">{{ $profile->jenis_kelamin }}</span>
                            </li>
                            <li>
                                <span class="name-specification">Tempat Lahir</span>
                                <span class="status-specification">{{ $profile->tempat_lahir }}</span>
                            </li>
                            <li>
                                <span class="name-specification">Tanggal Lahir</span>
                                <span
                                    class="status-specification">{{ date('d-m-Y', strtotime($profile->tanggal_lahir)) }}</span>
                            </li>
                            <li>
                                <span class="name-specification">Alamat</span>
                                <span class="status-specification">{{ $profile->alamat }}</span>
                            </li>
                            <li>
                                <span class="name-specification">Desa / Kelurahan</span>
                                <span class="status-specification" id="desa_kelurahan"></span>
                            </li>
                            <li>
                                <span class="name-specification">Kecamatan</span>
                                <span class="status-specification" id="kecamatan"></span>
                            </li>
                            <li>
                                <span class="name-specification">Kabupaten / Kota</span>
                                <span class="status-specification" id="kabupaten_kota"></span>
                            </li>
                            <li>
                                <span class="name-specification">Provinsi</span>
                                <span class="status-specification" id="provinsi"></span>
                            </li>
                            <li>
                                <span class="name-specification">Nomor HP</span>
                                <span class="status-specification">{{ $profile->nomor_hp }}</span>
                            </li>
                            <li>
                                <span class="name-specification">Email</span>
                                <span class="status-specification">{{ $profile->email }}</span>
                            </li>
                            <li>
                                <span class="name-specification">Nama Institusi</span>
                                <span class="status-specification">{{ $profile->institusi->nama }}</span>
                            </li>
                            <li>
                                <span class="name-specification">Alamat Institusi</span>
                                <span class="status-specification">{{ $profile->institusi->alamat }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('profile.edit', $profile->id) }}" id="btn-edit"
                            class="btn btn-warning btn-sm mr-1 my-1 w-100"><i class="fas fa-edit"></i> Ubah Data</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@component('components.wilayah.show',
    [
        'provinsi' => $profile->provinsi,
        'kabupaten_kota' => $profile->kabupaten_kota,
        'kecamatan' => $profile->kecamatan,
        'desa_kelurahan' => $profile->desa_kelurahan,
    ])
@endcomponent

@push('script')
@endpush
