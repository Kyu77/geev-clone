
@if ($type === "textarea")
<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <textarea class="input input-bordered w-full  @error($name) is-invalid @enderror" name="{{$name}}">{{$slot}}</textarea>
</div>
@else
<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <input class="input input-bordered w-full  @error($name) is-invalid @enderror" name="{{$name}}"" value="{{$value}}" type="{{$type}}">
</div>
@endif

@error($name)
<div class="alert alert-info">
    {{$message}}
</div>
@enderror
