@extends('templates/dashboard')

@section('title-tab')
    Ubah Profil
@endsection

@section('title')
    Ubah Profil
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
                            @slot('profile', $profile)
                            @slot('institusi', $institusi)
                            @slot('form_id', 'form_edit_profile')
                            @slot('action', route('profile.update', $profile->id))
                            @slot('method', 'PUT')
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
