@extends('templates/dashboard')

@section('title-tab')
    Responden
@endsection

@section('title')
    Responden
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
    <section>
        <div class="row mb-3">
            <div class="col">
                @if (Auth::user()->role == 'Admin')
                    @component('components.buttons.add')
                        @slot('href')
                            {{ route('responden.create') }}
                        @endslot
                        @slot('onClick')
                        @endslot
                    @endcomponent
                @endif
                @if (Auth::user()->role == 'Admin')
                    <button type="button" class="ml-2 btn btn-warning" id="import-responden"><i
                            class="link-icon icon-cloud-upload"></i> Import
                        Responden</button>
                @endif
                <button class="btn btn-primary ml-2" id="btn-export">
                    <i class="fas fa-file-download"></i>
                    Export Responden
                </button>
            </div>
        </div>
    </section>
    <section>
        <form action="{{ url('responden/export') }}" method="POST" id="form-export">
            @csrf
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
                {{-- <div class="col-12">
                    <button class="btn btn-primary d-none" type="submit" id="btn-export-form">Export Responden</button>
                </div> --}}
            </div>
        </form>
    </section>
    <section>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped yajra-datatable">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Nomor KK</th>
                                <th>Nama Kepala Keluarga</th>
                                {{-- <th>Alamat</th> --}}
                                <th>Desa/Kelurahan</th>
                                <th>Kecamatan</th>
                                <th>Kabupaten/Kota</th>
                                <th>Provinsi</th>
                                <th>Nomor HP</th>
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
        $('#btn-export').click(function() {
            $('#form-export').submit();
        });

        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        function hapus(id) {
            var _token = "{{ csrf_token() }}";
            swal({
                title: 'Apakah anda yakin?',
                text: "Data responden yang dipilih akan dihapus!",
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
                        url: "{{ url('responden') }}" + '/' + id,
                        data: {
                            _token: _token
                        },
                        success: function(data) {
                            swal({
                                title: 'Berhasil!',
                                text: 'Data responden berhasil dihapus',
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
        }

        $(function() {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('responden.index') }}",
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
                        data: 'kartu_keluarga',
                        name: 'kartu_keluarga'
                    },
                    {
                        data: 'nama_kepala_keluarga',
                        name: 'nama_kepala_keluarga'
                    },
                    // {
                    //     data: 'alamat',
                    //     name: 'alamat'
                    // },
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
                        data: 'nomor_hp',
                        name: 'nomor_hp'
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

        $(document).on('click', '#import-responden', function() {
            $('#modal-import-responden').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#file-import-responden').val('');
            $('#file-import-responden').attr('autocomplete', 'off');
            $('.custom-file-label').text('Pilih File');
        })

        $('#form-import-responden').on('submit', function(e) {
            $("#overlay").fadeIn(100);
            e.preventDefault();
            $('.error-text').text('');
            var formData = new FormData(this)
            $.ajax({
                type: "POST",
                url: "{{ url('importResponden/store') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    $("#overlay").fadeOut(100);
                    if ($.isEmptyObject(data.error)) {
                        swal({
                            title: "Berhasil!",
                            text: "Data berhasil disimpan!",
                            icon: "success",
                            button: false
                        })
                        setTimeout(
                            function() {
                                window.location.href = "{{ url()->current() }}";
                            }, 2000);

                    } else {
                        swal({
                            title: "Terjadi Kesalahan!",
                            text: "Data gagal disimpan, silahkan cek kembali inputan anda.",
                            icon: "error",
                        });
                        printErrorMsg(data.error);

                    }
                },
            })

            const printErrorMsg = (msg) => {
                $.each(msg, function(key, value) {
                    $('.' + key + '-error').text(value);
                });
            }

        })
    </script>
@endpush
