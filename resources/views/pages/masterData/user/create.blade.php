@extends('templates/dashboard')

@section('title-tab')
    Tambah Akun
@endsection

@section('title')
    Tambah Akun
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
                            @slot('form_id', 'form_add_user')
                            @slot('action', route('user.store'))
                            @slot('method', 'POST')
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
