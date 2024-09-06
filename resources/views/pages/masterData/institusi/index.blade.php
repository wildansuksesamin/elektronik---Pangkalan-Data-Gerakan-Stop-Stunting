@extends('templates/dashboard')

@section('title-tab')
    Institusi
@endsection

@section('title')
    Institusi
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
                    @component('components.buttons.add',
                        [
                            'href' => 'javascript:void(0);',
                            'onClick' => 'tambah()',
                        ])
                    @endcomponent
                </div>
            </div>
        </section>
    @endif
    <section>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped yajra-datatable">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Nama Institusi</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

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
                    <form id="form-tambah"autocomplete="off">
                        {{-- Input Jenis Survey --}}
                        @component('components.formGroup.input',
                            [
                                'label' => 'Nama Institusi',
                                'type' => 'text',
                                'class' => '',
                                'id' => 'nama',
                                'name' => 'nama',
                                'placeholder' => 'Masukkan',
                                'value' => '',
                            ])
                        @endcomponent

                        @component('components.formGroup.textArea',
                            [
                                'label' => 'Alamat',
                                'class' => '',
                                'id' => 'alamat',
                                'name' => 'alamat',
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
        $type = null;
        $url = null;
        $title = null;

        function tambah() {
            // alert('tambah')
            resetForm();
            resetError();
            $("#modal-tambah").modal('show');
            type = 'POST';
            url = "{{ route('institusi.store') }}"
            title = 'ditambahkan';
        }

        $(function() {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('institusi.index') }}",
                    data: function(d) {
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
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
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
        });

        function edit(id) {
            type = 'PUT';
            url = "{{ url('institusi') . '/' }}" + id
            title = 'diubah';

            resetError();
            $("#overlay").fadeIn(100);
            idEdit = id;
            $.ajax({
                url: "{{ url('institusi') . '/' }}" + id + "/edit",
                type: "GET",
                success: function(response) {
                    $("#overlay").fadeOut(100);
                    $('#nama').val(response.nama);
                    $('#alamat').val(response.alamat);
                    $('#modal-tambah').modal('show');
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

        $('#form-tambah').submit(function(e) {
            e.preventDefault();
            $("#overlay").fadeIn(100);
            $.ajax({
                url: url,
                type: type,
                data: $(this).serialize(),
                success: function(response) {
                    resetError();
                    $("#overlay").fadeOut(100);
                    if (response.status == "success") {
                        swal("Berhasil",
                            "Institusi berhasil " + title, {
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
                        "Institusi gagal " + title, {
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

        function hapus(id) {
            var _token = "{{ csrf_token() }}";
            swal({
                title: 'Apakah anda yakin?',
                text: "Data Institusi yang dipilih akan dihapus!",
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
                        url: "{{ url('institusi') }}" + '/' + id,
                        data: {
                            _token: _token
                        },
                        success: function(data) {
                            swal({
                                title: 'Berhasil!',
                                text: 'Data institusi berhasil dihapus',
                                type: 'success',
                                icon: 'success',
                                button: false
                            })
                            setTimeout(
                                function() {
                                    location.reload();
                                }, 1000);
                        },
                    })
                } else {
                    swal.close();
                }
            })
        }

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
