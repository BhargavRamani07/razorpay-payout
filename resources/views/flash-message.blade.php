@if (Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ Session::get('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ Session::get('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif

@if (Session::has('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ Session::get('warning') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif

@if (Session::has('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    {{ Session::get('info') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <ul class="m-0">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif