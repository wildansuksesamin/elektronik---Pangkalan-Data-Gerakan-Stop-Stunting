@extends('templates/dashboard')

@section('title-tab')
    Supervisor / DPL
@endsection

@section('title')
    Institusi Supervisor / DPL
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
    </section>
    <section>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped yajra-datatable">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Nama Institusi</th>
                                <th>Total Supervisor/DPL</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(function() {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ url('/institusi-supervisor-dpl') }}",
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
                        data: 'total',
                        name: 'total',
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
