@extends('templates/dashboard')

@section('title-tab')
    Import Akun
@endsection

@section('title')
    Import Akun
@endsection

@section('subTitle')
    Dashboard
@endsection

@push('style')
@endpush

@section('content')
    <section>
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('importAkun') }} " method="post" id="import-survey">
                            @csrf
                            <div class="row">
                                <div class="col-lg col-md">
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Upload Data Akun</label>
                                        <div class="custom-file">
                                            <input type="file" name="file_akun" class="custom-file-input"
                                                id="customFile">
                                            <label class="custom-file-label" for="customFile">Pilih file</label>
                                        </div>
                                        <span class="text-muted d-block">File yang di import harus yang berekstensi
                                            .xlsx</span>
                                        <span class="text-danger error-text file_akun-error"></span>
                                    </div>
                                </div>
                                <div class="col-lg col-md">
                                    @component('components.formGroup.select',
                                        [
                                            'label' => 'Role',
                                            'name' => 'role',
                                            'id' => 'role',
                                            'class' => 'select2',
                                        ])
                                        @slot('options')
                                            <option value="Admin">Admin</option>
                                            <option value="Sub Admin">Sub Admin</option>
                                            <option value="Institusi">Institusi / Universitas</option>
                                            <option value="Supervisor">Supervisor / DPL</option>
                                            <option value="Surveyor">Surveyor / Mahasiswa</option>
                                        @endslot
                                    @endcomponent
                                </div>
                                <div class="col-lg col-md">
                                    @component('components.formGroup.select',
                                        [
                                            'label' => 'Institusi',
                                            'name' => 'institusi_id',
                                            'id' => 'institusi_id',
                                            'class' => 'select2',
                                        ])
                                        @slot('options')
                                            @foreach ($daftarInstitusi as $institusi)
                                                <option value="{{ $institusi->id }}">{{ $institusi->nama }}</option>
                                            @endforeach
                                        @endslot
                                    @endcomponent
                                </div>
                            </div>
                            <div class="form-row mt-2">
                                <div class="form-group mr-auto">
                                    <a href="{{ asset('assets') }}/formatImport.xlsx" class="btn btn-primary"><i
                                            class="fas fa-file-download"></i>
                                        Format Import</a>
                                </div>
                                <div class="form-group ml-auto">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-cloud-upload-alt"></i>
                                        Import</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $('#import-survey').submit(function(e) {
            $("#overlay").fadeIn(100);
            e.preventDefault();
            $('.error-text').text('');
            var formData = new FormData(this)
            $.ajax({
                type: "POST",
                url: "{{ url('importAkun') }}",
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
                                window.location.href = "{{ url('user') }}";
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
