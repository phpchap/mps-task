@if (session('status') !== null)
<div class="col-lg-12">
    <div role="alert" class="alert alert-success alert-dismissible">
        <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
        {{ session('status') }}
    </div>
</div>
@endif

@if (session('error') !== null)
<div class="col-lg-12">
    <div role="alert" class="alert alert-danger alert-dismissible">
        <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
        {{ session('error') }}
    </div>
</div>
@endif

@if (count($errors) > 0)
<div class="col-lg-12">
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif