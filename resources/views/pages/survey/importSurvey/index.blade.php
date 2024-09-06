@extends('templates/dashboard')

@section('title-tab')
    Import Survey
@endsection

@section('title')
    Import Survey
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
                        <form action="{{ url('importSurvey/store') }} " method="post" id="import-survey">
                            @csrf
                            <h5 class="text-danger">Fitur Import Survey ini hanya menjadi alternatif apabila fitur
                                sinkronisasi data di Aplikasi Android tidak berjalan dengan baik atau terjadi masalah.
                                Disarankan tetap melakukan
                                sinkronisasi data
                                di Aplikasi Android.</h5>
                            <div class="row">
                                <div class="col-lg col-md">
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Upload Survey</label>
                                        <div class="custom-file">
                                            <input type="file" name="file_survey" class="custom-file-input"
                                                id="customFile">
                                            <label class="custom-file-label" for="customFile">Pilih file</label>
                                        </div>
                                        <span class="text-muted d-block">File yang di import harus yang bernama
                                            "survey.xlsx"</span>
                                        <span class="text-danger error-text file_survey-error"></span>
                                    </div>
                                </div>
                                <div class="col-lg col-md">
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Upload Jawaban Survey</label>
                                        <div class="custom-file">
                                            <input type="file" name="file_jawaban_survey" class="custom-file-input"
                                                id="customFile">
                                            <label class="custom-file-label" for="customFile">Pilih file</label>
                                        </div>
                                        <span class="text-muted d-block">File yang di import harus yang bernama
                                            "jawaban_survey.xlsx"</span>
                                        <span class="text-danger error-text  file_jawaban_survey-error"></span>

                                    </div>
                                </div>
                                <div class="col-lg col-md">
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Upload Responden</label>
                                        <div class="custom-file">
                                            <input type="file" name="file_responden" class="custom-file-input"
                                                id="customFile">
                                            <label class="custom-file-label" for="customFile">Pilih file</label>
                                        </div>
                                        <span class="text-muted d-block">File yang di import harus yang bernama
                                            "responden.xlsx"</span>
                                        <span class="text-danger error-text file_responden-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mt-2">
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
                url: "{{ url('importSurvey/store') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(data);
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
                                window.location.href = "{{ url('importSurvey') }}";
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
