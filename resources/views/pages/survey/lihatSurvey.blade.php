@extends('templates/dashboard')

@section('title-tab')
    Lihat Survey
@endsection

@section('title')
    Survey
@endsection

@section('subTitle')
    Lihat Survey
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
                <div class="card">
                    <div class="card-header fw-bold">
                        Nama Survey :
                        {{ $survey->namaSurvey->nama }}
                        {!! $survey->namaSurvey->tipe == 'Pre'
                            ? ' <span class="badge badge-primary">PRE</span>'
                            : ' <span
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="badge badge-success">POST</span>' !!}

                    </div>
                    <div class="card-body ">
                        <p class="card-text">Responden : {{ $survey->responden->kartu_keluarga }} <span class="float-right">
                                {{ \Carbon\Carbon::parse($survey->created_at)->translatedFormat('d F Y') }}</span></p>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        @foreach ($daftarKategori as $kategori)
            @php
                $jawabanSurvey = \App\Models\JawabanSurvey::with(['jawabanSoal'])
                    ->groupBy('soal_id', 'kode_unik_survey', 'kategori_soal_id', 'jawaban_soal_id', 'jawaban_lainnya')
                    ->having(DB::raw('count(*)'), '>=', '1')
                    ->where('kode_unik_survey', "$kodeUnik")
                    ->where('kategori_soal_id', $kategori->id)
                    ->get();
                $arraySoalId = $jawabanSurvey->pluck('soal_id')->toArray();
                $arrayJawabanSoalId = $jawabanSurvey->pluck('jawaban_soal_id')->toArray();
            @endphp
            <div class="row mb-3 justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <p class="fw-bold my-2">Kategori Soal : {{ $kategori->nama }}</p>
                        </div>
                        <div class="card-body">
                            @foreach ($kategori->soal as $soal)
                                <p class="{{ $loop->first ? '' : 'mt-4' }}">{{ $loop->iteration }} . {{ $soal->soal }}
                                </p>
                                @if ($soal->tipe_jawaban != 'Jawaban Singkat')
                                    @php
                                        if ($soal->tipe_jawaban == 'Pilihan Ganda') {
                                            $tipe = 'fas fa-check-circle';
                                        } else {
                                            $tipe = 'far fa-check-square';
                                        }
                                    @endphp
                                    @foreach ($soal->jawabanSoal as $jawaban)
                                        @if ($jawaban->jawaban != 'Lainnya')
                                            @php
                                                $selected = '';
                                                $cekJawaban = array_search($jawaban->id, $arrayJawabanSoalId);
                                            @endphp
                                            @if (count($arrayJawabanSoalId) > 0)
                                                @if ($cekJawaban !== false)
                                                    <p><i class="{{ $tipe }}"></i>
                                                        {{ $jawaban->jawaban }}
                                                    </p>
                                                @endif
                                            @endif
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
                                            @if ($value)
                                                <p><i class="{{ $tipe }}"></i> {{ $value }}</p>
                                            @endif
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
                                    <p>{{ $value }}</p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection

@push('script')
    <script></script>
@endpush
