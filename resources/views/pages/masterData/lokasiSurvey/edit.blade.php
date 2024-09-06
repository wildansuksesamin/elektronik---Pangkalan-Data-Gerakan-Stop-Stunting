@extends('templates/dashboard')

@section('title-tab')
    Ubah Responden
@endsection

@section('title')
    Ubah Responden
@endsection

@section('subTitle')
    Responden
@endsection

@push('style')
@endpush

@section('content')
    <section>
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @component('components.form.formLokasiSurvey')
                            @slot('lokasi_survey', $lokasiSurvey)
                            @slot('form_id', 'form_edit_responden')
                            @slot('action', route('lokasi-survey.update', $lokasiSurvey->id))'))
                            @slot('method', 'PUT')
                            @slot('back_url', route('lokasi-survey.index'))
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script></script>
@endpush
