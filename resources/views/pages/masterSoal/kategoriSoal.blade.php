@extends('templates/dashboard')

@section('title-tab')
    Kategori Soal
@endsection

@section('title')
    Kategori Soal
@endsection

@section('subTitle')
    Nama Survey
@endsection

@push('style')
@endpush

@section('content')
    <section>
        <div class="row mb-3">
            @if (!$survey)
                <div class="col">
                    @component('components.buttons.add', [
                        'href' => 'javascript:void(0);',
                        'onClick' => 'tambah()',
                        ])
                    @endcomponent
                </div>
            @endif
            <div class="col d-flex justify-content-end">
                <a href="{{ url('/namaSurvey') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </section>



    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered yajra-datatable">
                <thead>
                    <tr class="text-center  ">
                        <th>Urutan</th>
                        <th>Nama</th>
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
                    <h5 class="modal-title">Tambah Kategori Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-tambah">
                        {{-- Input Urutan --}}
                        @component('components.formGroup.input', [
                            'label' => 'Urutan',
                            'type' => 'text',
                            'class' => 'urutan',
                            'id' => 'urutan',
                            'name' => 'urutan',
                            'placeholder' => 'Masukkan',
                            'value' => '',
                            ])
                        @endcomponent

                        {{-- Input Kategori Soal --}}
                        @component('components.formGroup.input', [
                            'label' => 'Kategori Soal',
                            'type' => 'text',
                            'class' => '',
                            'id' => 'nama',
                            'name' => 'nama',
                            'placeholder' => 'Masukkan',
                            'value' => '',
                            ])
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
                    <h5 class="modal-title">Edit Kategori Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-edit">
                        @method('PUT')
                        {{-- Input Urutan --}}
                        @component('components.formGroup.input', [
                            'label' => 'Urutan',
                            'type' => 'text',
                            'class' => 'urutan',
                            'id' => 'urutan_edit',
                            'name' => 'urutan',
                            'placeholder' => 'Masukkan',
                            'value' => '',
                            ])
                        @endcomponent

                        {{-- Input Kategori Soal --}}
                        @component('components.formGroup.input', [
                            'label' => 'Kategori Soal',
                            'type' => 'text',
                            'class' => '',
                            'id' => 'nama_edit',
                            'name' => 'nama',
                            'placeholder' => 'Masukkan',
                            'value' => '',
                            ])
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

        function tambah() {
            resetForm();
            resetError();
            $("#modal-tambah").modal('show');
        }

        $('.urutan').keypress(function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $('#form-tambah').submit(function(e) {
            $("#overlay").fadeIn(100);
            e.preventDefault();
            $.ajax({
                url: "{{ url('/kategoriSoal/' . $namaSurvey) }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    resetError();
                    $("#overlay").fadeOut(100);
                    if (response.status == "success") {
                        swal("Berhasil",
                            "Kategori Soal berhasil ditambahkan", {
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
                    $("#overlay").fadeOut(100);
                    swal("Gagal",
                        "Kategori Soal gagal ditambahkan", {
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
                url: "{{ url('kategoriSoal/' . $namaSurvey) . '/' }}" + idEdit,
                type: "PUT",
                data: $(this).serialize(),
                success: function(response) {
                    resetError();
                    $("#overlay").fadeOut(100);
                    if (response.status == "success") {
                        swal("Berhasil",
                            "Kategori Soal berhasil diubah", {
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
                        "Kategori Soal gagal diubah", {
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

        function edit(id) {
            $("#overlay").fadeIn(100);
            idEdit = id;
            $.ajax({
                url: "{{ url('kategoriSoal/' . $namaSurvey) . '/' }}" + id + "/edit",
                type: "GET",
                success: function(response) {
                    $("#overlay").fadeOut(100);
                    $('#nama_edit').val(response.data.nama);
                    $('#urutan_edit').val(response.data.urutan);
                    $('#modal-edit').modal('show');
                },
                error: function(response) {
                    $("#overlay").fadeOut(100);
                    swal("Gagal",
                        "Kategori Soal gagal diedit", {
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

        function hapus(id) {
            swal({
                title: "Apakah anda yakin?",
                text: "Kategori soal ini akan dihapus secara permanen, data yang berkaitan dengan kategori soal ini juga akan dihapus",
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
                        url: "{{ url('kategoriSoal/' . $namaSurvey) . '/' }}" + id,
                        type: "DELETE",
                        success: function(response) {
                            $("#overlay").fadeOut(100);
                            if (response.status == "success") {
                                swal("Berhasil",
                                    "Kategori Soal berhasil dihapus", {
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
                                    "Kategori Soal gagal dihapus", {
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
                                "Kategori Soal gagal dihapus", {
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
                url: "{{ url('/kategoriSoal/' . $namaSurvey) }}",
            },
            columns: [{
                    data: 'urutan',
                    name: 'urutan',
                    className: 'text-center'
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
        }
    </script>
@endpush
