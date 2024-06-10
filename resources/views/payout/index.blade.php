@extends('layout.app')

{{-- @push('page-stylelink')
<link rel="stylesheet" href="{{ asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
<link rel="stylesheet" href="{{ asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
<link rel="stylesheet" href="{{ asset("plugins/datatables-buttons/css/buttons.bootstrap4.min.css") }}">
@endpush --}}

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Payouts</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <a href="{{ route('payout.create') }}" class="btn btn-primary float-right"><i class="fa fa-plus"></i> Payout</a>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('flash-message')
                    @livewire('payouts-list')
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
{{-- @push('page-script')

<script src="{{ asset("plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            let table = $('#myTable').DataTable({
                pagingType: 'full_numbers'
            });
        });
    </script>
@endpush --}}