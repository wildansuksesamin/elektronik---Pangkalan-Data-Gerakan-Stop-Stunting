@extends('templates/dashboard')

@section('title-tab')
Starter Template
@endsection

@section('title')
Dashboard
@endsection

@section('subTitle')
Dashboard
@endsection


@push('style')

@endpush

@section('content')

@endsection

@push('script')
{{-- CKEditor --}}
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script>
    var options = {
        	            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        	            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        	            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        	            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
        	            height: 1000,
        	        };
</script>
<script>
    CKEDITOR.replace('my-editor', options);
</script>
@endpush
