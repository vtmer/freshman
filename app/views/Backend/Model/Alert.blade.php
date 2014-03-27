@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>{{{Session::get('success')}}}</strong>
</div>
@elseif($errors->any())
 {{-- */ $errors = $errors->all() /*--}}
<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>{{{ $errors[0] }}}</strong>
</div>
@elseif(Session::has('error'))
<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>{{{Session::get('error')}}}</strong>
</div>
@endif
