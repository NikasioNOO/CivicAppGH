@if(isset($message) || Session::get('message') )
<div class="alert alert-{{ isset($message) ? $status : Session::get('status')  }} status-box">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    {!! isset($message) ? $message :  Session::get('message')!!}
</div>
@endif
