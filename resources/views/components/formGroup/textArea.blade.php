<div class="form-group">
    <label for="">{{$label}}</label>
    <textarea name="{{$name}}" id="{{$id}}" class="form-control {{$class}}" rows="3" placeholder="{{$placeholder}} {{$label}}">{{$value}}</textarea>
    <span class="text-danger error-text {{$id}}-error"></span>
</div>