



@if($errors->has() && count($errors)> 0)
<div class="alert alert-danger fade in" style="margin:0">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif