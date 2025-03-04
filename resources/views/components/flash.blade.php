
<div class="{{$class}} myalert">
    {{$slot}}
</div>


<script>
    const id = setTimeout(() => {
        document.querySelector('.myalert').remove();
    }, 5000)


</script>
