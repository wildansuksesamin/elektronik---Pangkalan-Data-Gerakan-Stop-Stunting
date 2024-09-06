@extends('templates/dashboard')

@section('title-tab')
    Ubah Profil
@endsection

@section('title')
    Ubah Profil / Akun
@endsection

@section('subTitle')
    Profil / Akun
@endsection

@push('style')
@endpush

@section('content')
    <section>
        <div class="row mb-3">
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Profil</div>
                    </div>
                    <div class="card-body">
                        @component('components.form.formProfilePersonal')
                            @slot('profile', $profile ?? '')
                            @slot('institusi', $institusi ?? '')
                            @slot('form_id', 'form_edit_profile2')
                            @slot('action', route('updateProfile'))
                            @slot('method', 'PUT')
                            @slot('back_url', route('editProfileAccount'))
                        @endcomponent
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Akun</div>
                    </div>
                    <div class="card-body">
                        @component('components.form.formUserPersonal')
                            @slot('user', $user)
                            @slot('form_id', 'form_edit_user2')
                            @slot('action', route('updateAccount'))
                            @slot('method', 'PUT')
                            @slot('back_url', route('editProfileAccount'))
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
