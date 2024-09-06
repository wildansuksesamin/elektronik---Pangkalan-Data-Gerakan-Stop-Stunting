@extends('templates/dashboard')

@section('title-tab')
    Akun
@endsection

@section('title')
    Akun
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
                @component('components.buttons.add')
                    @slot('href')
                        {{ route('user.create') }}
                    @endslot
                    @slot('onClick')
                    @endslot
                @endcomponent
            </div>
        </div>
    </section>
    <section>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col-lg col-md px-1">
                        @component('components.formGroup.select',
                            [
                                'label' => 'Role',
                                'name' => 'role_filter',
                                'id' => 'role-filter',
                                'class' => 'filter',
                            ])
                            @slot('options')
                                @foreach ($role as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            @endslot
                        @endcomponent
                    </div>
                    <div class="col-lg col-md px-1">
                        @component('components.formGroup.select',
                            [
                                'label' => 'Status',
                                'name' => 'status_filter',
                                'id' => 'status-filter',
                                'class' => 'filter',
                            ])
                            @slot('options')
                                @foreach ($status as $item)
                                    <option value="{{ $item }}">{{ $item == 1 ? 'Aktif' : 'Tidak Aktif' }}</option>
                                @endforeach
                            @endslot
                        @endcomponent
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped yajra-datatable">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Nama Profil</th>
                                <th>Nama Pengguna</th>
                                {{-- <th>Password</th> --}}
                                <th>Role</th>
                                <th>Status</th>
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
        function hapus(id) {
            var _token = "{{ csrf_token() }}";
            swal({
                title: 'Apakah anda yakin?',
                text: "Data akun yang dipilih akan dihapus beserta profilnya!",
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
                        url: "{{ url('user') }}" + '/' + id,
                        data: {
                            _token: _token
                        },
                        success: function(data) {
                            swal({
                                title: 'Berhasil!',
                                text: 'Data akun beserta profilnya berhasil dihapus',
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
                    url: "{{ route('user.index') }}",
                    data: function(d) {
                        d.role = $('#role-filter').val();
                        d.status = $('#status-filter').val();
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
                        data: 'nama_profil',
                        name: 'nama_profil',
                        class: 'text-center',
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    // {
                    //     data: 'password_pengguna',
                    //     name: 'password_pengguna',
                    // },
                    {
                        data: 'role',
                        name: 'role',
                        class: 'text-center',
                    },
                    {
                        data: 'status_pengguna',
                        name: 'status_pengguna',
                        class: 'text-center',
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],

            });

            $('#role-filter').change(function() {
                table.draw();
            })

            $('#status-filter').change(function() {
                table.draw();
            })
        })
    </script>
@endpush
