@extends('templates/dashboard')

@section('title-tab')
    Ubah Akun
@endsection

@section('title')
    Ubah Akun
@endsection

@section('subTitle')
    Akun
@endsection

@push('style')
@endpush

@section('content')
    <section>
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @component('components.form.formUser')
                            @slot('user', $user)
                            @slot('form_id', 'form_edit_user')
                            @slot('action', route('user.update', $user->id))
                            @slot('method', 'PUT')
                            @slot('back_url', route('user.index'))
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
