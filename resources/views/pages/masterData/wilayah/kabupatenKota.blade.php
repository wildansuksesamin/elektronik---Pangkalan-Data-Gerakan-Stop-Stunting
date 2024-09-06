@extends('templates/dashboard')

@section('title-tab')
    Wilayah
@endsection

@section('title')
    Kabupaten/Kota di Provinsi {{ $provinsi->nama }}
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
                @component('components.buttons.add',
                    [
                        'id' => 'btn-tambah',
                        'class' => '',
                        'href' => '#',
                    ])
                @endcomponent
                @component('components.buttons.previous',
                    [
                        'id' => 'btn-tambah',
                        'class' => 'float-right',
                        'href' => url('wilayah-provinsi'),
                    ])
                @endcomponent
            </div>
        </div>
    </section>
    <section>
        <div class="row">
            <div class="col">
                @component('components.dataTables.index',
                    [
                        'id' => 'table-data',
                        'th' => ['No', 'Nama', 'Status (hanya berlaku untuk Responden)', 'Aksi'],
                    ])
                @endcomponent
            </div>
        </div>
    </section>

    @component('components.modals.masterData.wilayah',
        [
            'idModal' => 'modal-tambah',
            'idForm' => 'form-tambah',
            'label' => 'Tambah Kabupaten / Kota',
        ])
    @endcomponent

    @component('components.modals.masterData.wilayah',
        [
            'idModal' => 'modal-edit',
            'idForm' => 'form-edit',
            'label' => 'Ubah Kabupaten / Kota',
        ])
    @endcomponent
@endsection

@push('script')
    <script>
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            ajax: "{{ url('wilayah-kabupaten' . '/' . $provinsi->id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true,
                    class: 'text-center'
                },
            ]
        });

        var idEdit = 0;

        $('#btn-tambah').click(function() {
            resetError();
            $('#modal-tambah').modal('show');
            $('#form-tambah')[0].reset();
        })

        $(document).on('click', '#btn-delete', function() {
            let id = $(this).val();
            swal({
                title: 'Apakah anda yakin?',
                text: "Anda akan menghapus data kabupaten/kota ini ?",
                icon: 'warning',
                buttons: ["Batal", "Ya"],
            }).then((result) => {
                if (result) {
                    $("#overlay").fadeIn(100);
                    $.ajax({
                        url: "{{ url('wilayah-kabupaten' . '/' . $provinsi->id) }}" + '/' +
                            id,
                        type: 'DELETE',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#overlay").fadeOut(100);
                            if (response.status == 'success') {
                                swal(
                                    'Terhapus!',
                                    'Data kabupaten/kota telah dihapus.',
                                    'success'
                                ).then(function() {
                                    table.draw();
                                })
                            } else {
                                swal(
                                    'Gagal!',
                                    'Data kabupaten/kota gagal dihapus.',
                                    'error'
                                )
                            }
                        }
                    })
                }
            })
        })

        $(document).on('click', '#btn-edit', function() {
            let id = $(this).val();
            idEdit = id;
            $.ajax({
                url: "{{ url('wilayah-kabupaten' . '/' . $provinsi->id) }}" + '/' + id + '/edit',
                type: "GET",
                data: {
                    id: id
                },
                success: function(response) {
                    $('#modal-edit').modal('show');
                    $('#modal-edit .nama').val(response.nama);
                },
            })
        })

        $(document).on('click', '#btn-status', function() {
            let id = $(this).val();
            let status = $(this).data('status');
            let nama = $(this).data('nama');
            let changeStatus = status == 1 ? 'nonaktif' : 'aktif';
            swal({
                title: 'Apakah anda yakin ingin mengubah status?',
                text: `Anda akan mengubah status ` + nama +
                    ` beserta kecamatan dan desa/kelurahan yang terdapat di dalamnya menjadi ` +
                    changeStatus + `?`,
                icon: 'warning',
                buttons: ["Batal", "Ya"],
            }).then((result) => {
                if (result) {
                    $("#overlay").fadeIn(100);
                    $.ajax({
                        url: "{{ url('status-kabupaten') }}" + '/' + id,
                        type: 'PUT',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'status': status == 1 ? 0 : 1
                        },
                        success: function(response) {
                            $("#overlay").fadeOut(100);
                            if (response.status == 'success') {
                                swal(
                                    'Berhasil!',
                                    'Status berhasil diubah.',
                                    'success'
                                ).then(function() {
                                    table.draw();
                                })
                            } else {
                                swal(
                                    'Gagal!',
                                    'Status berhasil diubah.',
                                    'error'
                                )
                            }
                        }
                    })
                }
            })

        })

        $('#form-tambah').submit(function(e) {
            e.preventDefault();
            resetError();
            $("#overlay").fadeIn(100);
            let data = $(this).serialize();
            data += '&provinsi=' + '{{ $provinsi->id }}';
            $.ajax({
                url: "{{ url('wilayah-kabupaten' . '/' . $provinsi->id) }}",
                type: 'POST',
                data: data,
                success: function(response) {
                    $("#overlay").fadeOut(100);
                    if (response.status == 'success') {
                        $('#modal-tambah').modal('hide');
                        table.draw();
                        swal({
                            position: 'center',
                            icon: 'success',
                            title: 'Data Berhasil Disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        printErrorMsg(response.error);
                    }
                },
                error: function(response) {
                    swal({
                        position: 'center',
                        icon: 'error',
                        title: 'Data Gagal Disimpan',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        })

        $('#form-edit').submit(function(e) {
            e.preventDefault();
            resetError();
            $("#overlay").fadeIn(100);
            let data = $(this).serialize();
            data += '&provinsi=' + '{{ $provinsi->id }}';
            $.ajax({
                url: "{{ url('wilayah-kabupaten' . '/' . $provinsi->id) }}" + '/' + idEdit,
                type: 'PUT',
                data: data,
                success: function(response) {
                    $("#overlay").fadeOut(100);
                    if (response.status == 'success') {
                        $('#modal-edit').modal('hide');
                        table.draw();
                        swal({
                            position: 'center',
                            icon: 'success',
                            title: 'Data Berhasil Disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        printErrorMsg(response.error);
                    }
                },
                error: function(response) {
                    swal({
                        position: 'center',
                        icon: 'error',
                        title: 'Data Gagal Disimpan',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        })
    </script>

    <script>
        function printErrorMsg(msg) {
            $.each(msg, function(key, value) {
                $('.' + key + '-error').removeClass('d-none');
                $('.' + key + '-error').text(value);
            });
        }

        function resetError() {
            resetErrorElement('nama');
        }

        function resetModal() {
            resetError();
            $('#form-tambah')[0].reset();
            $('#form-edit')[0].reset();
        }

        function resetErrorElement(key) {
            $('.' + key + '-error').addClass('d-none');
        }
    </script>
@endpush
