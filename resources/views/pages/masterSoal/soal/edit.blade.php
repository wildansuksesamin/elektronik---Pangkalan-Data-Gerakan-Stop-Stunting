@extends('templates/dashboard')

@section('title-tab')
Edit Soal
@endsection

@section('title')
Edit Soal
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
<form id="form-edit" method="POST">
    @csrf
    @method('PUT')
    <div class="row input-soal">
        <div class="col-lg-12">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control col-lg-1 urutan" aria-label="Text input with dropdown button"
                        placeholder="Urutan" name="urutan" value="{{ $isiSoal->urutan }}">
                    <input type="text" class="form-control" aria-label="Text input with dropdown button"
                        placeholder="Masukkan Soal" name="soal_ubah" value="{{ $isiSoal->soal }}">
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
            @if ($isiSoal->tipe_jawaban == 'Pilihan Ganda')
            @foreach ($isiSoal->jawabanSoal as $jawaban)
            @if ($jawaban->jawaban != 'Lainnya')
            <div class='group-pilihan-ganda' id='index-pilihan-{{ $loop->iteration }}'>
                <div class='input-group mt-2 pilihan-ganda'>
                    <input type="text" value="{{ $jawaban->id }}" name="id_jawaban_ubah[]" hidden>
                    <div class='input-group-text'>
                        <input class='form-check-input mt-0' type='radio'
                            aria-label='Radio button for following text input' onclick='return false' />
                    </div>
                    <input name='jawaban_ubah[]' type='text'
                        class='form-control text-jawaban-ubah text-pilihan-ganda-{{ $loop->iteration }}'
                        aria-label='Text input with radio button' placeholder='Isi Opsi'
                        value="{{ $jawaban->jawaban }}" />
                    @if (!$loop->first)
                    <button type="button" class='btn btn-danger'
                        onclick='hapusJawabanPilihanGandaUbah({{ $loop->iteration }},{{ $jawaban->id }})'>
                        <i class='fas fa-times'></i>
                    </button>
                    @endif
                </div>
                <span class='text-danger error-text jawaban-ubah-error'></span>
            </div>
            @else
            <div class='input-group mt-2' id='tambahkan-lainnya-pilihan-ganda-ubah'>
                <div class='input-group-text'>
                    <input type="text" value="{{ $jawaban->id }}" id="id-lainnya" name="id_jawaban_ubah[]" hidden>
                    <input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input'
                        onclick='return false' />
                </div><input name='jawaban_ubah[]' value='Lainnya' type='text' class='form-control'
                    aria-label='Text input with radio button' placeholder='Lainnya...' readonly /><button type="button"
                    class='btn btn-danger' onclick='hapusLainnyaPilihanGandaUbah({{ $jawaban->id }})'><i
                        class='fas fa-times'></i></button>
            </div>
            @endif
            @endforeach
            @if ($jawaban->jawaban == 'Lainnya')
            <div class='input-group mt-2' id='tambahkan-opsi-pilihan-ganda-ubah'>
                <div class='input-group-text'><input class='form-check-input mt-0' type='radio'
                        aria-label='Radio button for following text input' onclick='return false' /></div><input
                    type='text' class='form-control' aria-label='Text input with radio button'
                    placeholder='Tambahkan Opsi' onclick='tambahJawabanPilihanGanda()' />
            </div>
            @else
            <div class='input-group mt-2' id='pilihan-tambahkan-lainnya-pilihan-ganda'>
                <div class='input-group-text'><input class='form-check-input mt-0' type='radio'
                        aria-label='Radio button for following text input' onclick='return false' /></div><input
                    type='text' class='form-control' aria-label='Text input with radio button'
                    placeholder='Tambahkan Opsi' onclick='tambahJawabanPilihanGanda()' /><button type="button"
                    class='btn btn-primary fw-bold' onclick='tambahPilihanLainnyaPilihanGanda()'><i
                        class='fas fa-plus'></i> Tambahkan 'Lainnya'</button>
            </div>
            @endif
            {{-- Kotak Centang --}}
            @elseif ($isiSoal->tipe_jawaban == 'Kotak Centang')
            @foreach ($isiSoal->jawabanSoal as $jawaban)
            @if ($jawaban->jawaban != 'Lainnya')
            <div class='group-kotak-centang' id='index-pilihan-{{ $loop->iteration }}'>
                <div class='input-group mt-2 kotak-centang'>
                    <input type="text" value="{{ $jawaban->id }}" name="id_jawaban_ubah[]" hidden>
                    <div class='input-group-text'>
                        <input class='form-check-input mt-0' type='radio'
                            aria-label='Radio button for following text input' onclick='return false' />
                    </div>
                    <input name='jawaban_ubah[]' type='text'
                        class='form-control text-jawaban-ubah text-kotak-centang-{{ $loop->iteration }}'
                        aria-label='Text input with radio button' placeholder='Isi Opsi'
                        value="{{ $jawaban->jawaban }}" />
                    @if (!$loop->first)
                    <button type="button" class='btn btn-danger'
                        onclick='hapusJawabanKotakCentangUbah({{ $loop->iteration }},{{ $jawaban->id }})'>
                        <i class='fas fa-times'></i>
                    </button>
                    @endif
                </div>
                <span class='text-danger error-text jawaban-ubah-error'></span>
            </div>
            @else
            <div class='input-group mt-2' id='tambahkan-lainnya-kotak-centang-ubah'>
                <div class='input-group-text'>
                    <input type="text" value="{{ $jawaban->id }}" id="id-lainnya" name="id_jawaban_ubah[]" hidden>
                    <input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input'
                        onclick='return false' />
                </div><input name='jawaban_ubah[]' value='Lainnya' type='text' class='form-control'
                    aria-label='Text input with radio button' placeholder='Lainnya...' readonly /><button type="button"
                    class='btn btn-danger' onclick='hapusLainnyaKotakCentangUbah({{ $jawaban->id }})'><i
                        class='fas fa-times'></i></button>
            </div>
            @endif
            @endforeach
            @if ($jawaban->jawaban == 'Lainnya')
            <div class='input-group mt-2' id='tambahkan-opsi-kotak-centang-ubah'>
                <div class='input-group-text'><input class='form-check-input mt-0' type='radio'
                        aria-label='Radio button for following text input' onclick='return false' /></div><input
                    type='text' class='form-control' aria-label='Text input with radio button'
                    placeholder='Tambahkan Opsi' onclick='tambahJawabanKotakCentang()' />
            </div>
            @else
            <div class='input-group mt-2' id='pilihan-tambahkan-lainnya-kotak-centang'>
                <div class='input-group-text'><input class='form-check-input mt-0' type='radio'
                        aria-label='Radio button for following text input' onclick='return false' /></div><input
                    type='text' class='form-control' aria-label='Text input with radio button'
                    placeholder='Tambahkan Opsi' onclick='tambahJawabanKotakCentang()' /><button type="button"
                    class='btn btn-primary fw-bold' onclick='tambahPilihanLainnyaKotakCentang()'><i
                        class='fas fa-plus'></i> Tambahkan 'Lainnya'</button>
            </div>
            @endif
            @else
            <div class='input-group mt-2 jawaban'><input type='text' class='form-control '
                    aria-label='Text input with radio button' placeholder='Jawaban Singkat' readonly />
                <div class='input-group-text'>
                    <input class='form-check-input mt-0' name='is_numerik' type='checkbox' value='1'
                        aria-label='Radio button for following text input'
                        {{$isiSoal->is_numerik == 1 ? 'checked' : ''}} />
                    <span class='ml-2 mb-1 fw-bold'>
                        Hanya Angka</span></div>
            </div>
            @endif
        </div>
    </div>

    <div>
        <input type="text" id="id-hapus" name="id_hapus" hidden>
        <input type="text" id="id-hapus-lainnya" name="id_hapus_lainnya" hidden>
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
    var tipeJawaban = "{{ $isiSoal->tipe_jawaban }}";
    var indexPilihanGanda = "{{ count($isiSoal->jawabanSoal) }}";
    var indexKotakCentang = "{{ count($isiSoal->jawabanSoal) }}";
    var idHapus = '';
    var idHapusLainnya = '';
    var pilihanJawaban = '';

    $(document).ready(function () {
        $('#tipe-jawaban').val(tipeJawaban);
        $('#tipe-jawaban').prop('disabled', true);
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
            "<div class='group-pilihan-ganda' id='index-pilihan-1'><div class='input-group mt-2 pilihan-ganda'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' name='jawaban[]' class='form-control text-jawaban text-pilihan-ganda-1' aria-label='Text input with radio button' placeholder='Isi Opsi'/></div><span class='text-danger error-text jawaban-error'></span></div><div class='input-group mt-2' id='pilihan-tambahkan-lainnya-pilihan-ganda'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanPilihanGanda()'/><button type='button' class='btn btn-primary fw-bold' onclick='tambahPilihanLainnyaPilihanGanda()'><i class='fas fa-plus'></i> Tambahkan 'Lainnya'</button></div>"
        );
    }

    function tambahJawabanPilihanGanda() {
        indexPilihanGanda++;
        $(".group-pilihan-ganda:last").after(
            "<div class='group-pilihan-ganda' id='index-pilihan-" +
            indexPilihanGanda +
            "'><div class='input-group mt-2 pilihan-ganda'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input name='jawaban[]'type='text' class='form-control text-jawaban text-pilihan-ganda-" +
            indexPilihanGanda +
            "' aria-label='Text input with radio button' placeholder='Isi Opsi'/><button type='button' class='btn btn-danger' onclick='hapusJawabanPilihanGanda(" +
            indexPilihanGanda +
            ")'><i class='fas fa-times'></i></button></div><span class='text-danger error-text jawaban-error'></span></div>"
        );
        $(".text-pilihan-ganda-" + indexPilihanGanda).focus();
    }

    function hapusJawabanPilihanGanda(index) {
        $("#index-pilihan-" + index).remove();
    }

    function hapusJawabanPilihanGandaUbah(index, id) {
        $("#index-pilihan-" + index).remove();
        idHapus = idHapus + id + ',';
        $('#id-hapus').val(idHapus);
    }

    function tambahPilihanLainnyaPilihanGanda() {
        $(".group-pilihan-ganda:last").after(
            "<div class='input-group mt-2' id='tambahkan-lainnya-pilihan-ganda'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input name='lainnya' value='Lainnya' type='text' class='form-control' aria-label='Text input with radio button' placeholder='Lainnya...' readonly/><button type='button' class='btn btn-danger' onclick='hapusLainnyaPilihanGanda()'><i class='fas fa-times'></i></button></div>"
        );
        hapusTambahPilihanLainnyaPilihanGanda();
        $("#tambahkan-lainnya-pilihan-ganda").after(
            "<div class='input-group mt-2' id='tambahkan-opsi-pilihan-ganda'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanPilihanGanda()'/></div>"
        );
    }

    function hapusLainnyaPilihanGanda() {
        $("#tambahkan-lainnya-pilihan-ganda").remove();
        $("#tambahkan-opsi-pilihan-ganda").remove();
        $(".group-pilihan-ganda:last").after(
            "<div class='input-group mt-2' id='pilihan-tambahkan-lainnya-pilihan-ganda'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanPilihanGanda()'/><button type='button' class='btn btn-primary fw-bold' onclick='tambahPilihanLainnyaPilihanGandaUbah()'><i class='fas fa-plus'></i> Tambahkan 'Lainnya'</button></div>"
        );
    }

    function hapusLainnyaPilihanGandaUbah(id) {
        idHapusLainnya = id;
        $("#id-hapus-lainnya").val(id);
        $("#tambahkan-lainnya-pilihan-ganda-ubah").remove();
        $("#tambahkan-opsi-pilihan-ganda-ubah").remove();
        $(".group-pilihan-ganda:last").after(
            "<div class='input-group mt-2' id='pilihan-tambahkan-lainnya-pilihan-ganda-ubah'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanPilihanGanda()'/><button type='button' class='btn btn-primary fw-bold' onclick='tambahPilihanLainnyaPilihanGandaUbah()'><i class='fas fa-plus'></i> Tambahkan 'Lainnya'</button></div>"
        );
    }

    function hapusTambahPilihanLainnyaPilihanGanda() {
        $("#pilihan-tambahkan-lainnya-pilihan-ganda").remove();
    }

    function hapusTambahPilihanLainnyaPilihanGandaUbah() {
        $("#pilihan-tambahkan-lainnya-pilihan-ganda-ubah").remove();
        $("#id-hapus-lainnya").val('');
    }

    function tambahPilihanLainnyaPilihanGandaUbah() {
        $(".group-pilihan-ganda:last").after(
            "<div class='input-group mt-2' id='tambahkan-lainnya-pilihan-ganda-ubah'><div class='input-group-text'><input type='text' value='" +
            idHapusLainnya +
            "' id='id-lainnya' name='id_jawaban_ubah[]' hidden><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input name='jawaban_ubah[]' value='Lainnya' type='text' class='form-control' aria-label='Text input with radio button' placeholder='Lainnya...' readonly/><button type='button' class='btn btn-danger' onclick='hapusLainnyaPilihanGandaUbah(" +
            idHapusLainnya + ")'><i class='fas fa-times'></i></button></div>"
        );
        hapusTambahPilihanLainnyaPilihanGandaUbah();
        $("#tambahkan-lainnya-pilihan-ganda-ubah").after(
            "<div class='input-group mt-2' id='tambahkan-opsi-pilihan-ganda-ubah'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanPilihanGanda()'/></div>"
        );
    }

    // Kotak Centang
    function KotakCentang() {
        $("#jawaban-pertanyaan").append(
            "<div class='group-kotak-centang' id='index-pilihan-1'><div class='input-group mt-2 kotak-centang'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' name='jawaban[]' class='form-control text-jawaban text-kotak-centang-1' aria-label='Text input with radio button' placeholder='Isi Opsi'/></div><span class='text-danger error-text jawaban-error'></span></div><div class='input-group mt-2' id='pilihan-tambahkan-lainnya-kotak-centang'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanKotakCentang()'/><button type='button' class='btn btn-primary fw-bold' onclick='tambahPilihanLainnyaKotakCentang()'><i class='fas fa-plus'></i> Tambahkan 'Lainnya'</button></div>"
        );
    }

    function tambahJawabanKotakCentang() {
        indexKotakCentang++;
        $(".group-kotak-centang:last").after(
            "<div class='group-kotak-centang' id='index-pilihan-" +
            indexKotakCentang +
            "'><div class='input-group mt-2 kotak-centang'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input name='jawaban[]'type='text' class='form-control text-jawaban text-kotak-centang-" +
            indexKotakCentang +
            "' aria-label='Text input with radio button' placeholder='Isi Opsi'/><button type='button' class='btn btn-danger' onclick='hapusJawabanKotakCentang(" +
            indexKotakCentang +
            ")'><i class='fas fa-times'></i></button></div><span class='text-danger error-text jawaban-error'></span></div>"
        );
        $(".text-kotak-centang-" + indexKotakCentang).focus();
    }

    function hapusJawabanKotakCentang(index) {
        $("#index-pilihan-" + index).remove();
    }

    function hapusJawabanKotakCentangUbah(index, id) {
        $("#index-pilihan-" + index).remove();
        idHapus = idHapus + id + ',';
        $('#id-hapus').val(idHapus);
    }

    function tambahPilihanLainnyaKotakCentang() {
        $(".group-kotak-centang:last").after(
            "<div class='input-group mt-2' id='tambahkan-lainnya-kotak-centang'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input name='lainnya' value='Lainnya' type='text' class='form-control' aria-label='Text input with radio button' placeholder='Lainnya...' readonly/><button type='button' class='btn btn-danger' onclick='hapusLainnyaKotakCentang()'><i class='fas fa-times'></i></button></div>"
        );
        hapusTambahPilihanLainnyaKotakCentang();
        $("#tambahkan-lainnya-kotak-centang").after(
            "<div class='input-group mt-2' id='tambahkan-opsi-kotak-centang'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanKotakCentang()'/></div>"
        );
    }

    function hapusLainnyaKotakCentang() {
        $("#tambahkan-lainnya-kotak-centang").remove();
        $("#tambahkan-opsi-kotak-centang").remove();
        $(".group-kotak-centang:last").after(
            "<div class='input-group mt-2' id='pilihan-tambahkan-lainnya-kotak-centang'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanKotakCentang()'/><button type='button' class='btn btn-primary fw-bold' onclick='tambahPilihanLainnyaKotakCentangUbah()'><i class='fas fa-plus'></i> Tambahkan 'Lainnya'</button></div>"
        );
    }

    function hapusLainnyaKotakCentangUbah(id) {
        idHapusLainnya = id;
        $("#id-hapus-lainnya").val(id);
        $("#tambahkan-lainnya-kotak-centang-ubah").remove();
        $("#tambahkan-opsi-kotak-centang-ubah").remove();
        $(".group-kotak-centang:last").after(
            "<div class='input-group mt-2' id='pilihan-tambahkan-lainnya-kotak-centang-ubah'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanKotakCentang()'/><button type='button' class='btn btn-primary fw-bold' onclick='tambahPilihanLainnyaKotakCentangUbah()'><i class='fas fa-plus'></i> Tambahkan 'Lainnya'</button></div>"
        );
    }

    function hapusTambahPilihanLainnyaKotakCentang() {
        $("#pilihan-tambahkan-lainnya-kotak-centang").remove();
    }

    function hapusTambahPilihanLainnyaKotakCentangUbah() {
        $("#pilihan-tambahkan-lainnya-kotak-centang-ubah").remove();
        $("#id-hapus-lainnya").val('');
    }

    function tambahPilihanLainnyaKotakCentangUbah() {
        $(".group-kotak-centang:last").after(
            "<div class='input-group mt-2' id='tambahkan-lainnya-kotak-centang-ubah'><div class='input-group-text'><input type='text' value='" +
            idHapusLainnya +
            "' id='id-lainnya' name='id_jawaban_ubah[]' hidden><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input name='jawaban_ubah[]' value='Lainnya' type='text' class='form-control' aria-label='Text input with radio button' placeholder='Lainnya...' readonly/><button type='button' class='btn btn-danger' onclick='hapusLainnyaKotakCentangUbah(" +
            idHapusLainnya + ")'><i class='fas fa-times'></i></button></div>"
        );
        hapusTambahPilihanLainnyaKotakCentangUbah();
        $("#tambahkan-lainnya-kotak-centang-ubah").after(
            "<div class='input-group mt-2' id='tambahkan-opsi-kotak-centang-ubah'><div class='input-group-text'><input class='form-check-input mt-0' type='radio' aria-label='Radio button for following text input' onclick='return false'/></div><input type='text' class='form-control' aria-label='Text input with radio button' placeholder='Tambahkan Opsi' onclick='tambahJawabanKotakCentang()'/></div>"
        );
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
        $('#form-edit').submit(function (e) {
            e.preventDefault();
            $("#overlay").fadeIn(100);
            resetError();
            $.ajax({
                url: "{{ url('/soal/' . $kategoriSoal . '/' . $idSoal) }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    $("#overlay").fadeOut(100);
                    resetError();
                    if (response.status == "success") {
                        swal("Berhasil",
                            "Soal berhasil diubah", {
                                button: false,
                                icon: "success",
                            });
                        setTimeout(
                            function () {
                                $(location).attr('href',
                                    "{{ url('/soal') . '/' . $kategoriSoal }}");
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

        $('.jawaban-ubah-error').each(function (i, o) {
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

            if (key.split(".")[0] == "jawaban_ubah") {
                $('.text-jawaban-ubah').each(function (i, o) {
                    if ($(o).val() == '') {
                        $('.jawaban-ubah-error').eq(i).text(value);
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
        $('#form-edit')[0].reset();
    }

</script>
@endpush
