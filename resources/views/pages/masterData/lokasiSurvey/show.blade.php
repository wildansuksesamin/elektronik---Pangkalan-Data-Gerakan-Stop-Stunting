
@extends('templates/dashboard')

@section('title-tab')Lihat Responden
@endsection

@section('title')
Lihat Responden
@endsection

@section('subTitle')
Responden
@endsection

@push('style')

@endpush

@section('content')
<section>
    <div class="row mb-3 justify-content-center">
        <div class="col-lg-6 col-md-6 text-center">
            <div class="card card-pricing">
                <div class="card-header">
                    <h4 class="card-title">{{$responden->kartu_keluarga}}</h4>
                </div>
                <div class="card-body">
                    <ul class="specification-list">
                        <li>
                            <span class="name-specification">Alamat</span>
                            <span class="status-specification">{{$responden->alamat}}</span>
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
                            <span class="status-specification">{{$responden->nomor_hp}}</span>
                        </li>
                        
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{route('responden.edit', $responden->id)}}" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 w-100"><i class="fas fa-edit"></i> Ubah Data</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@component('components.wilayah.show', [
    'provinsi' => $responden->provinsi_id, 
    'kabupaten_kota' => $responden->kabupaten_kota_id, 
    'kecamatan' => $responden->kecamatan_id, 
    'desa_kelurahan' => $responden->desa_kelurahan_id])
@endcomponent

@push('script')

@endpush
