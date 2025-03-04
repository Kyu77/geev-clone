
@if ($type === "textarea")
<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <textarea class="input input-bordered w-full  @error($name) border-red-400 @enderror" name="{{$name}}">{{$slot}}</textarea>
</div>
@else
<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <input class="input input-bordered w-full  @error($name) border-red-400  @enderror" name="{{$name}}" value="{{$value}}" type="{{$type}}">
</div>
@endif

@error($name)
<div class="alert alert-error my-2">
    {{$message}}
</div>
@enderror
