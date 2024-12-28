@if(session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif
@if(session()->has('error'))
<div class="alert alert-danger">
    {{ session()->get('error') }}
</div>
@endif
@if($errors->any())
<div class="alert alert-danger">
    {{$errors->first()}}
</div>
@endif
