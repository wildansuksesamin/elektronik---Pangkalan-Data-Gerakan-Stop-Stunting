<div class="form-group {{ $class_fg ?? '' }}">
    <label for="">{{ $label }}</label> {!! $button_add ?? '' !!}
    <select name="{{ $name }}" class="form-control {{ $class }}" id="{{ $id }}">
        @if ($class == 'filter')
            <option value="">Semua</option>
        @else
            <option value="" selected hidden>- Pilih Salah Satu -</option>
        @endif
        {{ $options }}
    </select>
    <span class="text-danger error-text {{ $name }}-error"></span>
</div>
