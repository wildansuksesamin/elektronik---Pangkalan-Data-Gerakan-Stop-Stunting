@extends('templates/dashboard')

@section('title-tab')
    Tambah Profil
@endsection

@section('title')
    Tambah Profil
@endsection

@section('subTitle')
    Profil
@endsection

@push('style')
@endpush

@section('content')
    <section>
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @component('components.form.formProfile')
                            @slot('users', $users)
                            @slot('institusi', $institusi)
                            {{-- @slot('profile', '') --}}

                            @slot('form_id', 'form_add_profile')
                            @slot('action', route('profile.store'))
                            @slot('method', 'POST')
                            @slot('back_url', route('profile.index'))
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
