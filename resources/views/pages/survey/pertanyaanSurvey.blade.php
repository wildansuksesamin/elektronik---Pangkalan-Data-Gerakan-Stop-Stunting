@extends('templates/dashboard')

@section('title-tab')
    Pertanyaan
@endsection

@section('title')
    Pertanyaan
@endsection

@section('subTitle')
    Survey
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
        <div class="row mb-3 justify-content-center">
            <div class="col-lg-6">
                <form id="form-tambah" method="POST">
                    {{-- <form id="form-tambah" method="POST"
                        action="{{ url('/survey/cek-jawaban/' . $idSurvey . '/' . $kategori->id) }}"> --}}
                    @csrf
                    <div class="card">
                        <div class="card-header fw-bold">
                            <p class="card-text">Responden : {{ $survey->responden->kartu_keluarga }} <span
                                    class="float-right">
                                    {{ \Carbon\Carbon::parse($survey->created_at)->translatedFormat('d F Y') }}</span></p>
                        </div>
                        <div class="card-header">
                            <span> Nama Survey :
                                {{ $survey->namaSurvey->nama }}
                                {!! $survey->namaSurvey->tipe == 'Pre'
                                    ? ' <span class="badge badge-primary">PRE</span>'
                                    : ' <span class="badge badge-success">POST</span>' !!} </span>
                            <p class="mt-2 mb-0">Kategori Soal : {{ $kategori->nama }}</p>
                        </div>
                        <div class="card-body">
                            <input type="text" value="{{ $kategori->id }}" name="kategori_soal_id" hidden readonly>
                            @php
                                $idSoal = '';
                                $jawabanSurvey = \App\Models\JawabanSurvey::with(['jawabanSoal'])
                                    ->groupBy('soal_id', 'kode_unik_survey', 'kategori_soal_id', 'jawaban_soal_id', 'jawaban_lainnya')
                                    ->having(DB::raw('count(*)'), '>=', '1')
                                    ->where('kode_unik_survey', "$kodeUnik")
                                    ->where('kategori_soal_id', $kategori->id)
                                    ->get();
                                $arraySoalId = $jawabanSurvey->pluck('soal_id')->toArray();
                                $arrayJawabanSoalId = $jawabanSurvey->pluck('jawaban_soal_id')->toArray();

                                // $jawabanSurvey = \App\Models\JawabanSurvey::with(['jawabanSoal'])
                                //     ->where('kode_unik_survey', $kodeUnik)
                                //     ->where('jawaban_soal_id', $jawaban->id)
                                //     ->where('soal_id', $soal->id)
                                //     ->first();

                            @endphp
                            @foreach ($kategori->soal as $soal)
                                @php
                                    $index = $loop->iteration;
                                @endphp
                                <input type="text" value="{{ $soal->id }}" name="id[]" hidden readonly>
                                <input type="text" value="{{ $soal->tipe_jawaban }}" name="tipe_jawaban[]" hidden
                                    readonly>
                                <p class="{{ $loop->first ? '' : 'mt-4' }}">{{ $loop->iteration }} .
                                    {{ $soal->soal }}
                                </p>
                                @if ($soal->tipe_jawaban != 'Jawaban Singkat')
                                    @php
                                        if ($soal->tipe_jawaban == 'Pilihan Ganda') {
                                            $tipe = 'radio';
                                        } else {
                                            $tipe = 'checkbox';
                                        }
                                    @endphp
                                    @foreach ($soal->jawabanSoal as $jawaban)
                                        @if ($jawaban->jawaban != 'Lainnya')
                                            @php
                                                $selected = '';
                                                $cekJawaban = array_search($jawaban->id, $arrayJawabanSoalId);
                                                if (count($arrayJawabanSoalId) > 0) {
                                                    if ($cekJawaban !== false) {
                                                        $selected = 'checked';
                                                    }
                                                }

                                            @endphp
                                            <div class='input-group my-2'>
                                                <div class='input-group-text'><input class='form-check-input mt-0'
                                                        type='{{ $tipe }}' name='jawaban-{{ $index }}[]'
                                                        value='{{ $jawaban->id }}'
                                                        aria-label='Radio button for following text input'
                                                        {{ $selected }} />
                                                </div>
                                                <input type='text' class='form-control text-jawaban'
                                                    aria-label='Text input with radio button'
                                                    placeholder='{{ $jawaban->jawaban }}' disabled />
                                            </div>
                                        @else
                                            @php
                                                $selected = '';
                                                $value = '';
                                                $cekJawaban = array_search($soal->id, $arraySoalId);
                                                if (count($arraySoalId) > 0) {
                                                    if ($cekJawaban !== 'false') {
                                                        $isiJawaban = $jawabanSurvey[$cekJawaban];
                                                        if ($isiJawaban->jawaban_lainnya) {
                                                            $selected = 'checked';
                                                            $value = $isiJawaban->jawaban_lainnya;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <div class='input-group'>
                                                <div class='input-group-text'><input class='form-check-input mt-0'
                                                        type='{{ $tipe }}' name='jawaban-{{ $index }}[]'
                                                        value='Lainnya' aria-label='Radio button for following text input'
                                                        {{ $selected }} />
                                                </div>
                                                <input type='text' class='form-control text-jawaban'
                                                    aria-label='Text input with radio button' placeholder='Lainnya'
                                                    name='jawaban-lainnya-{{ $index }}'
                                                    value="{{ $value }}" />
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    @php
                                        $selected = '';
                                        $value = '';
                                        $cekJawaban = array_search($soal->id, $arraySoalId);
                                        if (count($arraySoalId) > 0) {
                                            if ($cekJawaban !== 'false') {
                                                $selected = 'checked';
                                                $value = $jawabanSurvey[$cekJawaban]->jawaban_lainnya;
                                            }
                                        }
                                    @endphp
                                    <input type='text'
                                        class='form-control text-jawaban text-kotak-centang {{ $soal->is_numerik ? 'numerik' : '' }}'
                                        placeholder='{{ $soal->is_numerik == 1 ? 'Masukkan Jawaban Anda (Angka)' : 'Masukkan Jawaban Anda' }}'
                                        name="jawaban-{{ $index }}" value="{{ $value }}" />
                                @endif
                                <div class="mt-3"><span
                                        class='text-danger error-text jawaban-{{ $index }}-error'></span></div>
                            @endforeach
                            <div class="mt-4">
                                @if ($tombolSebelumnya != '')
                                    <div class="float-left">
                                        @component('components.buttons.previous',
                                            [
                                                'label' => 'Sebelumnya',
                                                'href' => $urlSebelumnya,
                                                'onClick' => '',
                                                'class' => '',
                                            ])
                                        @endcomponent
                                    </div>
                                @endif

                                <div class="float-right">
                                    @component('components.buttons.next',
                                        [
                                            'label' => $tombolSelanjutnya,
                                            'class' => '',
                                        ])
                                    @endcomponent
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#form-tambah').submit(function(e) {
                e.preventDefault();
                resetError();
                swal({
                    title: "Apakah anda yakin?",
                    text: "Jawaban Pertanyaan Akan Disimpan",
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
                            url: "{{ url('/survey/cek-jawaban' . '/' . $kodeUnik) }}",
                            type: "POST",
                            data: $(this).serialize(),
                            success: function(response) {
                                $("#overlay").fadeOut(100);
                                if (response.status == "success") {
                                    swal("Berhasil",
                                        "Jawaban Pertanyaan Berhasil Disimpan", {
                                            button: false,
                                            icon: "success",
                                        });
                                    setTimeout(
                                        function() {
                                            $(location).attr('href',
                                                response.url
                                            );
                                        }, 2000);
                                } else {
                                    printErrorMsg(response.error);
                                    swal("Terjadi Kesalahan",
                                        "Pastikan Seluruh Soal Harus Memiliki Jawaban", {
                                            icon: "warning",
                                            buttons: {
                                                confirm: {
                                                    className: 'btn btn-danger'
                                                }
                                            },
                                        });
                                }
                            },
                            error: function(response) {
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
                    }
                });
            })
        })

        function printErrorMsg(msg) {
            $.each(msg, function(key, value) {
                $('.' + key + '-error').text(value);
            });
        }

        function resetError() {
            $('.error-text').text('');
        }

        $('.numerik').on('input', function(e) {
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
        });
    </script>
@endpush
