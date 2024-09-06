@extends('templates/dashboard')

@section('title-tab')
    Survey
@endsection

@section('title')
    Survey
@endsection

@section('subTitle')
    Dashboard
@endsection

@push('style')
    <style>
        .form-group {
            padding-left: 0px;
            padding-right: 0px;
        }

        .form-check-input {
            margin-top: .3rem;
            margin-left: 0rem;
        }

        input.text-jawaban:disabled {
            background-color: white !important;
            opacity: 1 !important;
            border: 0px solid black;
        }
    </style>
@endpush

@section('content')
    {{-- <section>
        <div class="row mb-4">
            <div class="col">
                @component('components.buttons.previous', [
    'class' => 'float-right',
    'href' => url('survey-supervisor/lokasi-survey'),
])
                @endcomponent
            </div>
        </div>
    </section> --}}
    <section>
        <div class="row">
            <div class="col-lg">
                @component('components.formGroup.select',
                    [
                        'label' => 'Pilih Jenis Survey',
                        'name' => 'nama_survey_id',
                        'id' => 'nama_survey_id',
                        'class' => 'select2 filter',
                    ])
                    @slot('options')
                        <option value="semua">Semua</option>
                        @if (count($namaSurvey) > 0)
                            @foreach ($namaSurvey as $row)
                                <option value="{{ $row->id }}">{{ $row->nama }} | {{ $row->tipe }}</option>
                            @endforeach
                        @endif
                    @endslot
                @endcomponent
            </div>
            <div class="col-lg">
                @component('components.formGroup.select',
                    [
                        'label' => 'Pilih Nama Surveyor',
                        'name' => 'nama_surveyor_id',
                        'id' => 'nama_surveyor_id',
                        'class' => 'select2 filter',
                    ])
                    @slot('options')
                        <option value="semua">Semua</option>
                        @foreach ($listAnggotaSupervisor as $anggotaSupervisor)
                            <option value="{{ $anggotaSupervisor->id }}">{{ $anggotaSupervisor->nama_lengkap }}</option>
                        @endforeach
                    @endslot
                @endcomponent
            </div>
        </div>
    </section>

    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered yajra-datatable">
                <thead>
                    <tr class="text-center  ">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('script')
    <script>
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ url('/survey-supervisor/survey' . '/' . $lokasiSurveySupervisor) }}",
                data: function(d) {
                    d.nama_surveyor_id = $('#nama_surveyor_id').val();
                    d.nama_survey_id = $('#nama_survey_id').val();
                    d.status = $('#status').val();
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
                    data: 'tipe',
                    name: 'tipe',
                    className: 'text-center',
                },
                {
                    data: 'status',
                    name: 'status',
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
                }
            ],
        });

        $('.filter').change(function() {
            table.draw();
        })
    </script>
@endpush
