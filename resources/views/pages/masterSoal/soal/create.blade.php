@extends('templates/dashboard')

@section('title-tab')
Tambah Soal
@endsection

@section('title')
Tambah Soal
@endsection

@section('subTitle')
Soal
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

    .page-inner {
        overflow: auto;
    }

    .dropdown-jenis-jawaban {
        position: relative;
    }

</style>
@endpush

@section('content')
<form id="form-tambah" type="POST">
    @csrf
    <div class="row input-soal">
        <div class="col-lg-12">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control col-lg-1 urutan" aria-label="Text input with dropdown button"
                        placeholder="Urutan" name="urutan">
                    <input type="text" class="form-control" aria-label="Text input with dropdown button"
                        placeholder="Masukkan Soal" name="soal">
                    <div class="input-group-append">
                        <select class="form-control " id="tipe-jawaban" name="tipe_jawaban">
                            <option value="" selected hidden>Pilih Tipe Jawaban</option>
                            <option value="Pilihan Ganda">Pilihan Ganda</option>
                            <option value="Kotak Centang">Kotak Centang</option>
                            <option value="Jawaban Singkat">Jawaban Singkat</option>
                        </select>
                    </div>
                </div>
            </div>
            <div><span class='text-danger error-text urutan-error'></span></div>
            <div><span class='text-danger error-text soal-error'></span></div>
            <div><span class="text-danger error-text jenis-jawaban-error"></span></div>
        </div>
    </div>
    <hr>
    <div class="row mb-3">
        <div class="col-lg-12" id="jawaban-pertanyaan">
        </div>
    </div>

    <div class="row float-right">
        <div class="col-lg-12">
            @component('components.buttons.submit', [
            'label' => 'Simpan',
            ])
            @endcomponent
        </div>
    </div>
</form>

{{-- Fix Ketika Hapus Jawaban, Pesan Error Tidak Terhapus --}}
@endsection

@push('script')
<script>
    var indexPilihanGanda = 1;
    var indexKotakCentang = 1;
    var pilihanJawaban = '';

    $(document).ready(function () {
        // resetJawabanPertanyaan();
    });

    $("#tipe-jawaban").change(function () {
        resetJawabanPertanyaan();
        $('.jenis-jawaban-error').text("");
        pilihanJawaban = $(this).val();
        if (pilihanJawaban == "Jawaban Singkat") {
            jawabanSingkat();
        } else if (pilihanJawaban == "Pilihan Ganda") {
            pilihanGanda();
        } else if (pilihanJawaban == "Kotak Centang") {
            kotakCentang();
        }
    });



    // Jawaban Singkat
    function jawabanSingkat() {
        $("#jawaban-pertanyaan").append(
            "<div class='input-group mt-2 jawaban'><input type='text' class='form-control 'aria-label='Text input with radio button' placeholder='Jawaban Singkat' readonly/><div class='input-group-text'><input class='form-check-input mt-0' name='is_numerik' type='checkbox' value='1' aria-label='Radio button for following text input' /> <span class='ml-2 mb-1 fw-bold'> Hanya Angka</span></div></div>"
        );
    }

    // Pilihan Ganda
    function pilihanGanda() {
        $("#jawaban-pertanyaan").append(
            "<div class='group-pilihan-ganda' id='index-pilihan-1'><div class='input-group mt-2 pilihan-ganda'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' value='' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' name='jawaban[]' class='form-control text-jawaban text-pilihan-ganda-1' aria-label='Text input with radio button' placeholder='Isi Opsi'/></div><span class='text-danger error-text jawaban-error'></span></div><div class='input-group mt-2' id='pilihan-tambahkan-lainnya-pilihan-ganda'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' value='' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanPilihanGanda()'/><button class='btn btn-primary fw-bold' onclick='tambahPilihanLainnyaPilihanGanda()'><i class='fas fa-plus'></i> Tambahkan 'Lainnya'</button></div>"
        );
    }

    function tambahJawabanPilihanGanda() {
        indexPilihanGanda++;
        $(".group-pilihan-ganda:last").after(
            "<div class='group-pilihan-ganda' id='index-pilihan-" +
            indexPilihanGanda +
            "'><div class='input-group mt-2 pilihan-ganda'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' value='' aria-label='Radio button for following text input' onclick='return false'/></div><input name='jawaban[]'type='text' class='form-control text-jawaban text-pilihan-ganda-" +
            indexPilihanGanda +
            "' aria-label='Text input with radio button' placeholder='Isi Opsi'/><button class='btn btn-danger' onclick='hapusJawabanPilihanGanda(" +
            indexPilihanGanda +
            ")'><i class='fas fa-times'></i></button></div><span class='text-danger error-text jawaban-error'></span></div>"
        );
        $(".text-pilihan-ganda-" + indexPilihanGanda).focus();
    }

    function hapusJawabanPilihanGanda(index) {
        $("#index-pilihan-" + index).remove();
    }

    function tambahPilihanLainnyaPilihanGanda() {
        $(".group-pilihan-ganda:last").after(
            "<div class='input-group mt-2' id='tambahkan-lainnya-pilihan-ganda'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' value='' aria-label='Radio button for following text input' onclick='return false'/></div><input name='lainnya' value='Lainnya' type='text' class='form-control' aria-label='Text input with radio button' placeholder='Lainnya...' readonly/><button class='btn btn-danger' onclick='hapusLainnyaPilihanGanda()'><i class='fas fa-times'></i></button></div>"
        );
        hapusTambahPilihanLainnyaPilihanGanda();
        $("#tambahkan-lainnya-pilihan-ganda").after(
            "<div class='input-group mt-2' id='tambahkan-opsi-pilihan-ganda'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' value='' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanPilihanGanda()'/></div>"
        );
    }

    function hapusLainnyaPilihanGanda() {
        $("#tambahkan-lainnya-pilihan-ganda").remove();
        $("#tambahkan-opsi-pilihan-ganda").remove();
        $(".group-pilihan-ganda:last").after(
            "<div class='input-group mt-2' id='pilihan-tambahkan-lainnya-pilihan-ganda'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' value='' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanPilihanGanda()'/><button class='btn btn-primary fw-bold' onclick='tambahPilihanLainnyaPilihanGanda()'><i class='fas fa-plus'></i> Tambahkan 'Lainnya'</button></div>"
        );
    }

    function hapusTambahPilihanLainnyaPilihanGanda() {
        $("#pilihan-tambahkan-lainnya-pilihan-ganda").remove();
    }

    // Kotak Centang
    function kotakCentang() {
        $("#jawaban-pertanyaan").append(
            "<div class='group-kotak-centang' id='index-pilihan-1'><div class='input-group mt-2 kotak-centang' ><div class='input-group-text'><input class='form-check-input mt-0' type='checkbox' value='' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' name='jawaban[]' class='form-control text-jawaban text-kotak-centang-1' aria-label='Text input with radio button' placeholder='Isi Opsi'/></div><span class='text-danger error-text jawaban-error'></span></div><div class='input-group mt-2' id='pilihan-tambahkan-lainnya-kotak-centang'><div class='input-group-text'><input class='form-check-input mt-0' type='checkbox' value='' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanKotakCentang()'/><button class='btn btn-primary fw-bold' onclick='tambahPilihanLainnyaKotakCentang()'><i class='fas fa-plus'></i> Tambahkan 'Lainnya'</button></div>"
        );
    }

    function tambahJawabanKotakCentang() {
        indexKotakCentang++;
        $(".group-kotak-centang:last").after(
            "<div class='group-kotak-centang' id='index-pilihan-" +
            indexKotakCentang +
            "'><div class='input-group mt-2 kotak-centang' ><div class='input-group-text'><input class='form-check-input mt-0' type='checkbox' value='' aria-label='Radio button for following text input' onclick='return false'/></div><input name='jawaban[]'type='text' class='form-control text-jawaban text-kotak-centang-" +
            indexKotakCentang +
            "' aria-label='Text input with radio button' placeholder='Isi Opsi'/><button class='btn btn-danger' onclick='hapusJawabanKotakCentang(" +
            indexKotakCentang +
            ")'><i class='fas fa-times'></i></button></div><span class='text-danger error-text jawaban-error'></span></div>"
        );
        $(".text-kotak-centang-" + indexKotakCentang).focus();
    }

    function hapusJawabanKotakCentang(index) {
        $("#index-pilihan-" + index).remove();
    }

    function tambahPilihanLainnyaKotakCentang() {
        $(".group-kotak-centang:last").after(
            "<div class='input-group mt-2' id='tambahkan-lainnya-kotak-centang'><div class='input-group-text'><input class='form-check-input mt-0' type='checkbox' value='' aria-label='Radio button for following text input' onclick='return false'/></div><input name='lainnya' value='Lainnya' type='text' class='form-control' aria-label='Text input with radio button' placeholder='Lainnya...' readonly/><button class='btn btn-danger' onclick='hapusLainnyaKotakCentang()'><i class='fas fa-times'></input></button></div>"
        );
        hapusTambahPilihanLainnyaKotakCentang();
        $("#tambahkan-lainnya-kotak-centang").after(
            "<div class='input-group mt-2' id='tambahkan-opsi-kotak-centang'><div class='input-group-text'><input class='form-check-input mt-0' type='checkbox' value='' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanKotakCentang()'/></div>"
        );
    }

    function hapusLainnyaKotakCentang() {
        $("#tambahkan-lainnya-kotak-centang").remove();
        $("#tambahkan-opsi-kotak-centang").remove();
        $(".group-kotak-centang:last").after(
            "<div class='input-group mt-2' id='pilihan-tambahkan-lainnya-kotak-centang'><div class='input-group-text'><input class='form-check-input mt-0' type='checkbox' value='' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanKotakCentang()'/><button class='btn btn-primary fw-bold' onclick='tambahPilihanLainnyaKotakCentang()'><i class='fas fa-plus'></i> Tambahkan 'Lainnya'</button></div>"
        );
    }

    function hapusTambahPilihanLainnyaKotakCentang() {
        $("#pilihan-tambahkan-lainnya-kotak-centang").remove();
    }

    function resetJawabanPertanyaan() {
        $("#jawaban-pertanyaan").html("");
    }

</script>

<script>
    $('.urutan').keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    $(document).ready(function () {
        $('#form-tambah').submit(function (e) {
            e.preventDefault();
            resetError();
            $("#overlay").fadeIn(100);
            if (pilihanJawaban == '') {
                $("#overlay").fadeOut(100);
                $('.jenis-jawaban-error').text("Jenis Jawaban harus dipilih");
            }
            $.ajax({
                url: "{{ url('/soal/' . $kategoriSoal) }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    console.log(response);
                    $("#overlay").fadeOut(100);
                    if (response.status == "success") {
                        swal("Berhasil",
                            "Soal berhasil ditambahkan", {
                                button: false,
                                icon: "success",
                            });
                        setTimeout(
                            function () {
                                $(location).attr('href', response.url);
                            }, 2000);
                    } else {
                        printErrorMsg(response.error);
                    }
                },
                error: function (response) {
                    $("#overlay").fadeOut(100);
                    swal("Gagal",
                        "Soal gagal ditambahkan", {
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
    })


    function printErrorMsg(msg) {
        $('.jawaban-error').each(function (i, o) {
            $(o).text('');
        })
        var i = 0;
        $.each(msg, function (key, value) {
            if (key.split(".")[0] == "jawaban") {
                $('.text-jawaban').each(function (i, o) {
                    if ($(o).val() == '') {
                        $('.jawaban-error').eq(i).text(value);
                    };
                })
            } else {
                $('.' + key + '-error').text(value);
            }
        });
    }

    function resetError() {
        $('.nama-error').text('');
        $('.urutan-error').text('');
        $('.jenis-jawaban-error').text('');
        $('.urutan-error').text('');
        $('.soal-error').text('');
    }

    function resetForm() {
        $('#form-tambah')[0].reset();
    }

</script>
@endpush
