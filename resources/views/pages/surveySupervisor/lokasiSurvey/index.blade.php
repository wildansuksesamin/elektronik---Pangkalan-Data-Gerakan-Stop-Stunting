@extends('templates/dashboard')

@section('title-tab')
    Survey
@endsection

@section('title')
    Lokasi Survey / Posko
@endsection

@section('subTitle')
    Survey
@endsection

@push('style')
    <style>
        #DataTables_Table_0_wrapper {
            padding: 0 !important
        }

        #DataTables_Table_0 {
            width: 100% !important
        }
    </style>
@endpush

@section('content')
    <section>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped yajra-datatable">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Lokasi Survey / Posko</th>
                                <th>Wilayah</th>
                                <th>Total Surveyor / Mahasiswa</th>
                                <th>Total Data</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal" role="dialog" id="modal-tambah">
        <form method="POST" id="form-tambah">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-tambah-title">Tambah Golongan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @component('components.formGroup.select',
                            [
                                'label' => 'Pilih Lokasi Survey / Posko',
                                'name' => 'lokasi_survey_id',
                                'id' => 'lokasi_survey_id',
                                'class' => 'select2',
                            ])
                            @slot('options')
                            @endslot
                        @endcomponent
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                        @component('components.buttons.submit',
                            [
                                'label' => 'Simpan',
                            ])
                        @endcomponent
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ url('/survey-supervisor/lokasi-survey') }}",
                data: function(d) {
                    // d.search = $('input[type="search"]').val();
                }
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
                    data: 'wilayah',
                    name: 'wilayah'
                },
                {
                    data: 'total',
                    name: 'total',
                    className: 'text-center'
                },
                {
                    data: 'total_data',
                    name: 'total_data',
                    className: 'text-center'
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
