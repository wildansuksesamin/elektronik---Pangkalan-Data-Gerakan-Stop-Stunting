@extends('templates/dashboard')

@section('title-tab')
    Lokasi Survey
@endsection

@section('title')
    Lokasi Survey
@endsection

@section('subTitle')
    Master
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
    @if (Auth::user()->role == 'Admin')
        <section>
            <div class="row mb-3">
                <div class="col">
                    @component('components.buttons.add')
                        @slot('href')
                            {{ route('lokasi-survey.create') }}
                        @endslot
                        @slot('onClick')
                        @endslot
                    @endcomponent
                </div>
            </div>
        </section>
    @endif
    <section>
        <div class="row mb-4">
            <div class="col-lg-6 col-md-6">
                {{-- Provinsi --}}
                @component('components.formGroup.select',
                    [
                        'label' => 'Pilih Provinsi',
                        'name' => 'provinsi',
                        'id' => 'provinsi',
                        'class' => 'select2',
                        'class_fg' => 'px-0',
                        'options' => '',
                    ])
                @endcomponent
            </div>
            <div class="col-lg-6 col-md-6">
                {{-- Kabupaten / Kota --}}
                @component('components.formGroup.select',
                    [
                        'label' => 'Pilih Kabupaten / Kota',
                        'name' => 'kabupaten_kota',
                        'id' => 'kabupaten-kota',
                        'class' => 'select2',
                        'class_fg' => 'px-0',
                        'options' => '',
                    ])
                @endcomponent
            </div>
            <div class="col-lg-6 col-md-6">
                {{-- Kecamatan --}}
                @component('components.formGroup.select',
                    [
                        'label' => 'Pilih Kecamatan',
                        'name' => 'kecamatan',
                        'id' => 'kecamatan',
                        'class' => 'select2',
                        'class_fg' => 'px-0',
                        'options' => '',
                    ])
                @endcomponent
            </div>
            <div class="col-lg-6 col-md-6">
                {{-- Desa / Kelurahan --}}
                @component('components.formGroup.select',
                    [
                        'label' => 'Pilih Desa / Kelurahan',
                        'name' => 'desa_kelurahan',
                        'id' => 'desa-kelurahan',
                        'class' => 'select2',
                        'class_fg' => 'px-0',
                        'options' => '',
                    ])
                @endcomponent
            </div>
        </div>
    </section>
    <section>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped yajra-datatable">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Nama Lokasi / Posko</th>
                                <th>Desa/Kelurahan</th>
                                <th>Kecamatan</th>
                                <th>Kabupaten/Kota</th>
                                <th>Provinsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Upload Responden-->
    <div class="modal fade" id="modal-import-responden" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalLongTitle">Upload Responden</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-2">
                    <form method="POST" id="form-import-responden">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-lg col-md">
                                <div class="form-group pt-1">
                                    <label for="exampleFormControlFile1">Upload Responden</label>
                                    <a href="{{ asset('assets/formatImportResponden/Template_Import_Responden.xlsx') }}"
                                        target="_blank" class="badge badge-danger text-right float-right">Format Import</a>
                                    <div class="custom-file">
                                        <input type="file" name="file_import_responden" class="custom-file-input"
                                            id="file-import-responden" autocomplete="off">
                                        <label class="custom-file-label" for="customFile">Pilih file</label>
                                    </div>
                                    <span class="text-muted d-block">File yang di import harus sesuai format yang
                                        ditentukan. </span>
                                    <span class="text-danger error-text  file_import_responden-error"></span>

                                </div>
                                <div class="col-12 justify-content-end text-right">
                                    <button type="submit" class="btn btn-warning" id="btn-submit" value="">
                                        <i class="link-icon icon-cloud-upload"></i>
                                        Import</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="col-lg col-sm-12 mb-1">
                        <button type="button" class="btn btn-md btn-dark w-100" data-dismiss="modal"><i
                                class="fas fa-times"></i>
                            Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@component('components.wilayah.form',
    [
        'is_responden' => 1,
        'provinsi' => $responden->provinsi_id ?? null,
        'kabupaten_kota' => $responden->kabupaten_kota_id ?? null,
        'kecamatan' => $responden->kecamatan_id ?? null,
        'desa_kelurahan' => $responden->desa_kelurahan_id ?? null,
    ])
@endcomponent

@push('script')
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $(document).on('click', '.btn-delete', function() {
            let id = $(this).val();
            var _token = "{{ csrf_token() }}";
            swal({
                title: 'Apakah anda yakin?',
                text: "Data lokasi tugas survey yang dipilih akan dihapus!",
                type: 'warning',
                icon: 'warning',
                buttons: {
                    cancel: {
                        visible: true,
                        className: 'btn btn-danger',
                        text: 'Batal'
                    },
                    confirm: {
                        visible: true,
                        className: 'btn btn-success',
                        text: 'Ya'
                    }
                }
            }).then((result) => {
                if (result) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('lokasi-survey') }}" + '/' + id,
                        data: {
                            _token: _token
                        },
                        success: function(data) {
                            swal({
                                title: 'Berhasil!',
                                text: 'Data lokasi tugas survey berhasil dihapus',
                                type: 'success',
                                icon: 'success',
                                button: false
                            })
                            setTimeout(
                                function() {
                                    location.reload();
                                }, 2000);
                        },
                    })
                } else {
                    swal.close();
                }
            })
        })

        $(function() {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                // responsive: true,
                ajax: {
                    url: "{{ route('lokasi-survey.index') }}",
                    data: function(d) {
                        d.provinsi = $('#provinsi').val();
                        d.kabupaten = $('#kabupaten-kota').val();
                        d.kecamatan = $('#kecamatan').val();
                        d.desa = $('#desa-kelurahan').val();
                        d.search = $('input[type="search"]').val();
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
                        data: 'nama_lokasi_survey',
                        name: 'nama_lokasi_survey'
                    },
                    {
                        data: 'desa_kelurahan',
                        name: 'desa_kelurahan'
                    },
                    {
                        data: 'kecamatan',
                        name: 'kecamatan'
                    },
                    {
                        data: 'kabupaten_kota',
                        name: 'kabupaten_kota'
                    },
                    {
                        data: 'provinsi',
                        name: 'provinsi'
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

            $('#provinsi').change(function() {
                table.draw();
                $('#desa-kelurahan').html('');
                $('#kecamatan').html('');
                $('#kecamatan').attr('disabled', true);
                $('#desa-kelurahan').attr('disabled', true);
            })

            $('#kabupaten-kota').change(function() {
                table.draw();
                $('#desa-kelurahan').html('');
                $('#desa-kelurahan').attr('disabled', true);
            })

            $('#kecamatan').change(function() {
                table.draw();
            })

            $('#desa-kelurahan').change(function() {
                table.draw();
            })


        })
    </script>
@endpush
