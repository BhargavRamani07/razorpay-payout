@extends('layout.app')

@push('page-stylelink')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Payouts</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        @include('flash-message')

                        {{-- payout form component --}}
                        @livewire('payout-form')
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@push('page-script')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script type="text/javascript">

        // window.livewire.on('initialize-fundSelect2', () => {
        //     $("#fund-account-select").select2({
        //         theme: 'bootstrap4',
        //         placeholder: "Select fund account",
        //         allowClear: true
        //     });
        // });

        // $(document).ready(function() {
        //     $(document).on("change", "#fund-account-select", function(e) {
        //         livewire.emit('showAmountDetails', e.target.value);
        //     });
        // });
    </script>
@endpush
