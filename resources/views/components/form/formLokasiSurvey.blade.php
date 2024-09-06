<form id="{{ $form_id }}" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf
    @if (isset($method) && $method == 'PUT')
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-lg-12">
            {{-- Nama Lokasi --}}
            @component('components.formGroup.input',
                [
                    'label' => 'Nama Lokasi Survey / Posko',
                    'type' => 'text',
                    'class' => '',
                    'id' => 'nama_lokasi_survey',
                    'name' => 'nama_lokasi_survey',
                    'placeholder' => 'Masukkan',
                    'value' => $lokasi_survey->nama_lokasi_survey ?? null,
                ])
            @endcomponent
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6">
            {{-- Provinsi --}}
            @component('components.formGroup.select',
                [
                    'label' => 'Provinsi',
                    'name' => 'provinsi',
                    'id' => 'provinsi',
                    'class' => 'select2',
                    'options' => '',
                ])
            @endcomponent
        </div>
        <div class="col-lg-6 col-md-6">
            {{-- Kabupaten / Kota --}}
            @component('components.formGroup.select',
                [
                    'label' => 'Kabupaten / Kota',
                    'name' => 'kabupaten_kota',
                    'id' => 'kabupaten-kota',
                    'class' => 'select2',
                    'options' => '',
                ])
            @endcomponent
        </div>
        <div class="col-lg-6 col-md-6">
            {{-- Kecamatan --}}
            @component('components.formGroup.select',
                [
                    'label' => 'Kecamatan',
                    'name' => 'kecamatan',
                    'id' => 'kecamatan',
                    'class' => 'select2',
                    'options' => '',
                ])
            @endcomponent
        </div>
        <div class="col-lg-6 col-md-6">
            {{-- Desa / Kelurahan --}}
            @component('components.formGroup.select',
                [
                    'label' => 'Desa / Kelurahan',
                    'name' => 'desa_kelurahan',
                    'id' => 'desa-kelurahan',
                    'class' => 'select2',
                    'options' => '',
                ])
            @endcomponent
        </div>
    </div>

    {{-- Submit --}}
    <div class="form-row mt-2">
        <div class="form-group ml-auto">
            @component('components.buttons.submit', ['label' => 'Simpan'])
            @endcomponent
        </div>
    </div>
</form>

@component('components.wilayah.form',
    [
        'is_responden' => 1,
        'provinsi' => $lokasi_survey->desa_kelurahan->kecamatan->kabupatenKota->provinsi_id ?? null,
        'kabupaten_kota' => $lokasi_survey->desa_kelurahan->kecamatan->kabupaten_kota_id ?? null,
        'kecamatan' => $lokasi_survey->desa_kelurahan->kecamatan_id ?? null,
        'desa_kelurahan' => $lokasi_survey->desa_kelurahan_id ?? null,
    ])
@endcomponent


@push('script')
    <script>
        $(function() {
            $('#{{ $form_id }}').submit(function(e) {
                $("#overlay").fadeIn(100);
                e.preventDefault();
                $('.error-text').text('');
                var formData = new FormData(this)
                $.ajax({
                    type: "POST",
                    url: "{{ $action }}",
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
                            if ('{{ $method }}' == 'PUT') {
                                swal({
                                    title: "Berhasil!",
                                    text: "Perubahan berhasil disimpan!",
                                    icon: "success",
                                    button: false
                                })
                            } else {
                                swal({
                                    title: "Berhasil!",
                                    text: "Data berhasil disimpan!",
                                    icon: "success",
                                    button: false
                                })
                            }
                            setTimeout(
                                function() {
                                    window.location.href = "{{ $back_url }}";
                                }, 2000);
                        } else {
                            swal({
                                title: "Terjadi Kesalahan!",
                                text: "Data gagal disimpan, silahkan cek kembali inputan anda.",
                                icon: "error",
                            });
                            printErrorMsg(data.error);
                            if ('{{ $method }}' == 'PUT') {
                                $('#user-id').attr('disabled', true);
                            }
                        }
                    },
                })

            })

            const printErrorMsg = (msg) => {
                $.each(msg, function(key, value) {
                    $('.' + key + '-error').text(value);
                });
            }
        });
    </script>
@endpush
