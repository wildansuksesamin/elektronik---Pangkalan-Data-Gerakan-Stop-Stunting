@extends('templates/dashboard')

@section('title-tab')
    Supervisor / DPL
@endsection

@section('title')
    Anggota Supervisor / DPL
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
        <div class="row mb-4">
            <div class="col">
                @if (Auth::user()->role == 'Admin')
                    @component('components.buttons.add',
                        [
                            'id' => 'btn-tambah',
                            'class' => '',
                            'href' => '#',
                        ])
                    @endcomponent
                @endif
                @component('components.buttons.previous',
                    [
                        'class' => 'float-right',
                        'href' => url('lokasi-survey-supervisor-dpl/' . $lokasiSurveySupervisor->profile_id),
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
                                <th>Nama</th>
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
                                'label' => 'Pilih Surveyor / Mahasiswa',
                                'name' => 'profile_surveyor',
                                'id' => 'profile_surveyor',
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
        var idEdit = '';
        var idProfileSurveyor = '';
        var aksiTambah = 'tambah';
        $('#btn-tambah').click(function() {
            aksiTambah = 'tambah';
            idProfileSurveyor = '';
            getLokasiSurvey();
            $('#modal-tambah').modal('show');
            $('#modal-tambah-title').html('Tambah Anggota Supervisor / DPL');
        })

        $(document).on('click', '#btn-edit', function() {
            let id = $(this).val();
            idEdit = id;

            $.ajax({
                url: "{{ url('/anggota-supervisor-dpl' . '/' . $lokasiSurveySupervisor->id) }}" + '/' + id +
                    '/edit',
                type: "GET",
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    aksiTambah = 'ubah';
                    $('#modal-tambah').modal('show');
                    $('#modal-tambah-title').html('Ubah Anggota Supervisor / DPL');
                    idProfileSurveyor = response.profile_surveyor;
                    getLokasiSurvey();
                    setTimeout(
                        function() {
                            $('#profile_surveyor').val(response.profile_surveyor).trigger('change');
                        }, 500
                    );
                },
            })
        })

        $('#form-tambah').submit(function(e) {
            e.preventDefault();
            resetError();
            let formData = new FormData(this);
            if (aksiTambah == 'tambah') {
                $.ajax({
                    url: "{{ url('/anggota-supervisor-dpl' . '/' . $lokasiSurveySupervisor->id) }}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#modal-tambah').modal('hide');
                            table.draw();
                            swal("Berhasil", "Data Berhasil Tersimpan", {
                                icon: "success",
                                buttons: false,
                                timer: 1000,
                            });

                        } else {
                            printErrorMsg(response.error);
                        }
                    },
                    error: function(response) {
                        swal("Gagal", "Data Gagal Ditambahkan", {
                            icon: "error",
                            buttons: false,
                            timer: 1000,
                        });
                    }
                })
            } else {
                formData.append('_method', 'PUT');
                $.ajax({
                    url: "{{ url('/anggota-supervisor-dpl' . '/' . $lokasiSurveySupervisor->id) }}" + '/' +
                        idEdit,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 'success') {
                            $('#modal-tambah').modal('hide');
                            table.draw();
                            swal("Berhasil", "Data Berhasil Diubah", {
                                icon: "success",
                                buttons: false,
                                timer: 1000,
                            });

                        } else {
                            printErrorMsg(response.error);
                        }
                    },
                    error: function(response) {
                        swal("Gagal", "Data Gagal Diubah", {
                            icon: "error",
                            buttons: false,
                            timer: 1000,
                        });
                    }
                })
            }
        })

        $(document).on('click', '#btn-delete', function() {
            let id = $(this).val();
            swal({
                title: 'Apakah Anda Yakin ?',
                icon: 'error',
                text: "Data yang sudah dihapus tidak dapat dikembalikan lagi !",
                type: 'warning',
                buttons: {
                    confirm: {
                        text: 'Hapus',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        visible: true,
                        text: 'Batal',
                        className: 'btn btn-danger'
                    }
                }
            }).then((Delete) => {
                if (Delete) {
                    $.ajax({
                        url: "{{ url('/anggota-supervisor-dpl' . '/' . $lokasiSurveySupervisor->id) }}" +
                            '/' + id,
                        type: 'DELETE',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                swal("Berhasil", "Data Berhasil Dihapus", {
                                    icon: "success",
                                    buttons: false,
                                    timer: 1000,
                                }).then(function() {
                                    table.draw();
                                })
                            } else {
                                swal("Gagal", "Data Gagal Dihapus", {
                                    icon: "error",
                                    buttons: false,
                                    timer: 1000,
                                });
                            }
                        }
                    })
                }
            });
        })

        function getLokasiSurvey() {
            $('#profile_surveyor').html('');
            if (aksiTambah == "tambah") {
                $.ajax({
                    url: "{{ url('list/surveyor') }}",
                    type: 'GET',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        idSupervisor: "{{ $lokasiSurveySupervisor->profile_id }}"
                    },
                    success: function(response) {
                        if (response.length > 0) {
                            $('#profile_surveyor').append("<option></option>");
                            for (var i = 0; i < response.length; i++) {
                                $('#profile_surveyor').append('<option value="' + response[i].id + '">' +
                                    response[
                                        i]
                                    .nama_lengkap + " (" + response[i].user.username + ")" +
                                    '</option>');
                            }
                        }
                    }
                })
            } else {
                $('#profile_surveyor').find("option:not(:first-child)").html('');
                $.ajax({
                    url: "{{ url('list/surveyor') }}",
                    type: 'GET',
                    data: {
                        idSupervisor: "{{ $lokasiSurveySupervisor->profile_id }}",
                        idProfileSurveyor: idProfileSurveyor
                    },
                    success: function(response) {
                        if (response.length > 0) {
                            $('#profile_surveyor').append("<option></option>");
                            for (var i = 0; i < response.length; i++) {
                                $('#profile_surveyor').append('<option value="' + response[i].id + '">' +
                                    response[
                                        i]
                                    .nama_lengkap + " (" + response[i].user.username + ")" +
                                    '</option>');
                            }
                        }
                    }
                })
            }
        }
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searching: false,
            ajax: {
                url: "{{ url('/anggota-supervisor-dpl' . '/' . $lokasiSurveySupervisor->id) }}",
                // data: function(d) {
                //     d.search = $('input[type="search"]').val();
                // }
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
                    data: 'action',
                    name: 'action',
                    className: 'text-center',
                    orderable: true,
                    searchable: true
                },
            ],
        });

        function resetError() {
            $('.nama-error').text('');
        }

        function resetForm() {
            $('#form-tambah')[0].reset();
        }

        function printErrorMsg(msg) {
            $.each(msg, function(key, value) {
                $('.' + key + '-error').text(value);
            });
        }
    </script>
@endpush
