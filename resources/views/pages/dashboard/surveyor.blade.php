
@extends('templates/dashboard')

@section('title-tab')Dashboard
@endsection

@section('title')
Dashboard
@endsection

@section('subTitle')
Dashboard
@endsection

@push('style')
    
@endpush

@section('content')
<section>
    <div class="row">
        <div class="col-lg col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-4">
                            <div class="icon-big text-center">
                                <i class="fas fa-users text-danger"></i>
                            </div>
                        </div>
                        <div class="col-8 col-stats">
                            <div class="numbers">
                                <p class="card-category">Total Responden Anda</p>
                                <h4 class="card-title">{{$totalRespondenAnda}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-4">
                            <div class="icon-big text-center">
                                <i class="fas fa-users text-warning"></i>
                            </div>
                        </div>
                        <div class="col-8 col-stats">
                            <div class="numbers">
                                <p class="card-category">Responden Survey Pre</p>
                                <h4 class="card-title">{{$totalRespondenPre}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-4">
                            <div class="icon-big text-center">
                                <i class="fas fa-users text-success"></i>
                            </div>
                        </div>
                        <div class="col-8 col-stats">
                            <div class="numbers">
                                <p class="card-category">Responden Survey Post</p>
                                <h4 class="card-title">{{$totalRespondenPost}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="card">
        <div class="card-header">
            <div class="card-head-row">
                <div class="card-title w-100">
                    Daftar Survey Yang Belum Selesai
                </div>
            </div>
        </div>
        <div class="card-body px-4">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable w-100">
                        <thead>
                            <tr class="text-center  ">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('surveyBelumSelesai') }}",
        },
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'text-center',
                orderable: false,
                searchable: false
            },
            {
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'tipe',
                name: 'tipe',
                className: 'text-center',
            },
            {
                data: 'tanggal',
                name: 'tanggal',
                className: 'text-center',
            },
            {
                data: 'action',
                name: 'action',
                className: 'text-center',
                orderable: true,
                searchable: true
            },
        ],
    });

</script>
@endpush
