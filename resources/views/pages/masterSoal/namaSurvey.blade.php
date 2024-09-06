@extends('templates/dashboard')

@section('title-tab')
    Jenis Survey
@endsection

@section('title')
    Jenis Survey
@endsection

@section('subTitle')
    Master Soal
@endsection

@push('style')
@endpush

@section('content')
    <section>
        <div class="row mb-3">
            <div class="col">
                @component('components.buttons.add',
                    [
                        'href' => 'javascript:void(0);',
                        'onClick' => 'tambah()',
                    ])
                @endcomponent
            </div>
        </div>
    </section>

    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered yajra-datatable">
                <thead>
                    <tr class="text-center  ">
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    {{-- NOTE: Modal Tambah --}}
    <div class="modal" tabindex="-1" role="dialog" id="modal-tambah">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jenis Survey</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-tambah">
                        {{-- Input Jenis Survey --}}
                        @component('components.formGroup.input',
                            [
                                'label' => 'Jenis Survey',
                                'type' => 'text',
                                'class' => '',
                                'id' => 'nama',
                                'name' => 'nama',
                                'placeholder' => 'Masukkan',
                                'value' => '',
                            ])
                        @endcomponent

                        {{-- Input Tipe Survey --}}
                        @component('components.formGroup.select',
                            [
                                'label' => 'Tipe Survey',
                                'name' => 'tipe',
                                'id' => 'tipe',
                                'class' => 'tipe',
                            ])
                            @slot('options')
                                <option value="Pre">Pre</option>
                                <option value="Post">Post</option>
                            @endslot
                        @endcomponent

                        @component('components.formGroup.select',
                            [
                                'label' => 'Status Aktif',
                                'name' => 'status',
                                'id' => 'status',
                                'class' => 'status',
                            ])
                            @slot('options')
                                <option value="0">Tidak Aktif</option>
                                <option value="1">Aktif</option>
                            @endslot
                        @endcomponent
                </div>
                <div class="modal-footer">
                    @component('components.buttons.submit', ['label' => 'Simpan'])
                    @endcomponent
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- NOTE: Modal Edit --}}
    <div class="modal" tabindex="-1" role="dialog" id="modal-edit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jenis Survey</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-edit">
                        @method('PUT')
                        {{-- Input Jenis Survey --}}
                        @component('components.formGroup.input',
                            [
                                'label' => 'Jenis Survey',
                                'type' => 'text',
                                'class' => '',
                                'id' => 'nama_edit',
                                'name' => 'nama',
                                'placeholder' => 'Masukkan',
                                'value' => '',
                            ])
                        @endcomponent

                        {{-- Input Tipe Survey --}}
                        @component('components.formGroup.select',
                            [
                                'label' => 'Tipe Survey',
                                'name' => 'tipe',
                                'id' => 'tipe_edit',
                                'class' => 'tipe',
                            ])
                            @slot('options')
                                <option value="Pre">Pre</option>
                                <option value="Post">Post</option>
                            @endslot
                        @endcomponent
                </div>
                <div class="modal-footer">
                    @component('components.buttons.submit', ['label' => 'Simpan'])
                    @endcomponent
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- NOTE: Modal Duplikat --}}
    <div class="modal" tabindex="-1" role="dialog" id="modal-duplikat">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Duplikat Jenis Survey</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-duplikat">
                        {{-- Input Jenis Survey --}}
                        @component('components.formGroup.input',
                            [
                                'label' => 'Jenis Survey',
                                'type' => 'text',
                                'class' => '',
                                'id' => 'nama',
                                'name' => 'nama',
                                'placeholder' => 'Masukkan',
                                'value' => '',
                            ])
                        @endcomponent

                        {{-- Input Tipe Survey --}}
                        @component('components.formGroup.select',
                            [
                                'label' => 'Tipe Survey',
                                'name' => 'tipe',
                                'id' => 'tipe',
                                'class' => 'tipe',
                            ])
                            @slot('options')
                                <option value="Pre">Pre</option>
                                <option value="Post">Post</option>
                            @endslot
                        @endcomponent
                </div>
                <div class="modal-footer">
                    @component('components.buttons.submit', ['label' => 'Simpan'])
                    @endcomponent
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- NOTE: Modal Status Aktif --}}
    <div class="modal" tabindex="-1" role="dialog" id="modal-status-aktif">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Status Aktif</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-status-aktif">
                        {{-- Input Status Aktif --}}
                        @component('components.formGroup.select',
                            [
                                'label' => 'Status Aktif',
                                'name' => 'status_edit',
                                'id' => 'status_edit',
                                'class' => 'status_edit',
                            ])
                            @slot('options')
                                <option value="0">Tidak Aktif</option>
                                <option value="1">Aktif</option>
                            @endslot
                        @endcomponent
                </div>
                <div class="modal-footer">
                    @component('components.buttons.submit', ['label' => 'Simpan'])
                    @endcomponent
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        var idEdit = 0;
        var idEditStatus = 0;
        var idDuplikat = 0;

        function tambah() {
            resetForm();
            resetError();
            $("#modal-tambah").modal('show');
        }

        $('#form-tambah').submit(function(e) {
            e.preventDefault();
            $("#overlay").fadeIn(100);
            $.ajax({
                url: "{{ route('namaSurvey.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    resetError();
                    $("#overlay").fadeOut(100);
                    if (response.status == "success") {
                        swal("Berhasil",
                            "Jenis survey berhasil ditambahkan", {
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: 'btn btn-success'
                                    }
                                },
                            });
                        $('#modal-tambah').modal('hide');
                        table.draw();
                        resetForm();
                    } else {
                        printErrorMsg(response.error);
                    }
                },
                error: function(response) {
                    swal("Gagal",
                        "Jenis survey gagal ditambahkan", {
                            icon: "error",
                            buttons: {
                                confirm: {
                                    className: 'btn btn-danger'
                                }
                            },
                        });
                }
            });
        })

        $('#form-status-aktif').submit(function(e) {
            e.preventDefault();
            $("#overlay").fadeIn(100);
            $.ajax({
                url: "{{ url('namaSurvey/statusAktif') . '/' }}" + idEditStatus,
                type: "PUT",
                data: $(this).serialize(),
                success: function(response) {
                    $("#overlay").fadeOut(100);
                    if (response.status == "success") {
                        swal("Berhasil",
                            "Status survey berhasil diubah", {
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: 'btn btn-success'
                                    }
                                },
                            });
                        $('#modal-status-aktif').modal('hide');
                        table.draw();
                    } else {
                        printErrorMsg(response.error);
                    }
                },
                error: function(response) {
                    $("#overlay").fadeOut(100);
                    swal("Gagal",
                        "Status survey gagal diubah", {
                            icon: "error",
                            buttons: {
                                confirm: {
                                    className: 'btn btn-danger'
                                }
                            },
                        });
                }
            });
        })

        $('#form-edit').submit(function(e) {
            e.preventDefault();
            $("#overlay").fadeIn(100);
            $.ajax({
                url: "{{ url('namaSurvey') . '/' }}" + idEdit,
                type: "PUT",
                data: $(this).serialize(),
                success: function(response) {
                    resetError();
                    $("#overlay").fadeOut(100);
                    if (response.status == "success") {
                        swal("Berhasil",
                            "Jenis survey berhasil diubah", {
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: 'btn btn-success'
                                    }
                                },
                            });
                        $('#modal-edit').modal('hide');
                        table.draw();
                        resetForm();
                    } else {
                        printErrorMsg(response.error);
                    }
                },
                error: function(response) {
                    $("#overlay").fadeOut(100);
                    swal("Gagal",
                        "Jenis survey gagal diubah", {
                            icon: "error",
                            buttons: {
                                confirm: {
                                    className: 'btn btn-danger'
                                }
                            },
                        });
                }
            });
        })

        $('#form-duplikat').submit(function(e) {
            e.preventDefault();
            $("#overlay").fadeIn(100);
            $.ajax({
                url: "{{ url('namaSurvey') . '/' }}" + idDuplikat + "/duplikat",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    resetError();
                    $("#overlay").fadeOut(100);
                    if (response.status == "success") {
                        swal("Berhasil",
                            "Jenis survey berhasil di duplikat", {
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: 'btn btn-success'
                                    }
                                },
                            });
                        $('#modal-duplikat').modal('hide');
                        table.draw();
                        resetForm();
                    } else {
                        printErrorMsg(response.error);
                    }
                },
                error: function(response) {
                    $("#overlay").fadeOut(100);
                    swal("Gagal",
                        "Jenis survey gagal diduplikat", {
                            icon: "error",
                            buttons: {
                                confirm: {
                                    className: 'btn btn-danger'
                                }
                            },
                        });
                }
            });
        })

        function editStatus(id) {
            idEditStatus = id;
            $("#overlay").fadeIn(100);
            $.ajax({
                url: "{{ url('namaSurvey') . '/' }}" + id + "/edit",
                type: "GET",
                success: function(response) {
                    $("#overlay").fadeOut(100);
                    $('#status_edit').val(response.data.is_aktif).trigger('change');
                    $('#modal-status-aktif').modal('show');
                },
                error: function(response) {
                    $("#overlay").fadeOut(100);
                    swal("Gagal",
                        "Jenis survey gagal diedit", {
                            icon: "error",
                            buttons: {
                                confirm: {
                                    className: 'btn btn-danger'
                                }
                            },
                        });
                }
            });
        }

        function edit(id) {
            $("#overlay").fadeIn(100);
            idEdit = id;
            $.ajax({
                url: "{{ url('namaSurvey') . '/' }}" + id + "/edit",
                type: "GET",
                success: function(response) {
                    $("#overlay").fadeOut(100);
                    $('#nama_edit').val(response.data.nama);
                    $('#tipe_edit').val(response.data.tipe);
                    $('#modal-edit').modal('show');
                },
                error: function(response) {
                    $("#overlay").fadeOut(100);
                    swal("Gagal",
                        "Jenis survey gagal diedit", {
                            icon: "error",
                            buttons: {
                                confirm: {
                                    className: 'btn btn-danger'
                                }
                            },
                        });
                }
            });
        }

        function duplikat(id) {
            resetForm();
            idDuplikat = id;
            $('#modal-duplikat').modal('show');
        }

        function hapus(id) {
            swal({
                title: "Apakah anda yakin?",
                text: "Jenis Survey akan dihapus secara permanen, seluruh data yang berhubungan dengan Jenis survey ini akan ikut terhapus",
                icon: "warning",
                buttons: {
                    confirm: {
                        text: "Ya",
                        className: 'btn btn-success'
                    },
                    cancel: {
                        visible: true,
                        text: "Tidak",
                        className: 'btn btn-danger'
                    }
                },
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $("#overlay").fadeIn(100);
                    $.ajax({
                        url: "{{ url('namaSurvey') . '/' }}" + id,
                        type: "DELETE",
                        success: function(response) {
                            $("#overlay").fadeOut(100);
                            if (response.status == "success") {
                                swal("Berhasil",
                                    "Jenis survey berhasil dihapus", {
                                        icon: "success",
                                        buttons: {
                                            confirm: {
                                                className: 'btn btn-success'
                                            }
                                        },
                                    });
                                table.draw();
                            } else {
                                swal("Gagal",
                                    "Jenis survey gagal dihapus", {
                                        icon: "error",
                                        buttons: {
                                            confirm: {
                                                className: 'btn btn-danger'
                                            }
                                        },
                                    });
                            }
                        },
                        error: function(response) {
                            $("#overlay").fadeOut(100);
                            swal("Gagal",
                                "Jenis survey gagal dihapus", {
                                    icon: "error",
                                    buttons: {
                                        confirm: {
                                            className: 'btn btn-danger'
                                        }
                                    },
                                });
                        }
                    });
                }
            });
        }

        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('namaSurvey.index') }}",
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
                    data: 'aktif',
                    name: 'aktif',
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

        function printErrorMsg(msg) {
            $.each(msg, function(key, value) {
                $('.' + key + '-error').text(value);
            });
        }

        function resetError() {
            $('.nama-error').text('');
            $('.urutan-error').text('');
        }

        function resetForm() {
            $('#form-tambah')[0].reset();
            $('#form-duplikat')[0].reset();
        }
    </script>
@endpush
