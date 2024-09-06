@extends('templates/dashboard')

@section('title-tab')
    Soal
@endsection

@section('title')
    Soal
@endsection

@section('subTitle')
    Master Soal
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


    <section>
        <div class="row mb-3">
            @if (!$jawabanSurvey)
                <div class="col">
                    @component('components.buttons.add')
                        @slot('href')
                            {{ url('/soal' . '/' . $kategoriSoal . '/create') }}
                        @endslot
                        @slot('onClick')
                        @endslot
                    @endcomponent
                </div>
            @endif
            <div class="col d-flex justify-content-end">
                <a href="{{ url('/kategoriSoal' . '/' . $idNamaSurvey) }}" class="btn btn-primary"><i
                        class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </section>



    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered yajra-datatable">
                <thead>
                    <tr class="text-center">
                        <th>Urutan</th>
                        <th>Soal</th>
                        <th>Tipe Jawaban</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal-preview">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="preview-body">

                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function preview(id) {
            $("#overlay").fadeIn(100);
            $.ajax({
                url: "{{ url('/soal') . '/' . $kategoriSoal . '/' }}" + id,
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    $("#overlay").fadeOut(100);
                    $('#preview-body').html(response.html);
                    $('#modal-preview').modal('show');
                },
                error: function(response) {
                    $("#overlay").fadeOut(100);
                    alert('Error get data from ajax');
                }
            });
        }

        function hapus(id) {
            swal({
                title: "Apakah anda yakin?",
                text: "Soal ini akan dihapus secara permanen",
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
                        url: "{{ url('soal') . '/' . $kategoriSoal . '/' }}" + id,
                        type: "DELETE",
                        success: function(response) {
                            $("#overlay").fadeOut(100);
                            if (response.status == "success") {
                                swal("Berhasil",
                                    "Soal berhasil dihapus", {
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
                                    "Soal gagal dihapus", {
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
                                "Soal gagal dihapus", {
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

        $(document).ready(function() {
            $("#modal-preview").on("input", ".numerik", function() {
                this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
            });
        })


        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ url('/soal/' . $kategoriSoal) }}",
            },
            columns: [{
                    data: 'urutan',
                    name: 'urutan',
                    className: 'text-center'
                },
                {
                    data: 'soal',
                    name: 'soal'
                },
                {
                    data: 'tipe_jawaban',
                    name: 'tipe_jawaban',
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
    </script>
@endpush
