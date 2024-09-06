
@extends('templates/dashboard')

@section('title-tab')Tambah Responden
@endsection

@section('title')
Tambah Responden
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
                    @component('components.form.formResponden')
                        @slot('form_id', 'form_add_responden')
                        @slot('action', route('responden.store'))
                        @slot('method', 'POST')
                        @slot('back_url', route('responden.index'))      
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('script')
<script>

</script>
@endpush
