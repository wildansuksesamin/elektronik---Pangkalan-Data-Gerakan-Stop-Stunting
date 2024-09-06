<label class="form-radio-label">
    <input class="form-radio-input" type="radio" name="{{$name}}" value="{{$value}}" @if ($value == $checked) checked @endif>
    <span class="form-radio-sign">{{$label}}</span>
</label>