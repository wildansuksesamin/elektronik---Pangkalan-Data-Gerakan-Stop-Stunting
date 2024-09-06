@extends('templates/dashboard')

@section('title-tab')
    Tambah Lokasi Surver / Posko
@endsection

@section('title')
    Tambah Lokasi Surver / Posko
@endsection

@section('subTitle')
    Lokasi Survey
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
                            @slot('form_id', 'form_add_lokasi_survey')
                            @slot('action', route('lokasi-survey.store'))
                            @slot('method', 'POST')
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
