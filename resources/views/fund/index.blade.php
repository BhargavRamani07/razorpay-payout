@extends('layout.app')

@push('page-stylelink')
<link rel="stylesheet" href="{{ asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
<link rel="stylesheet" href="{{ asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
<link rel="stylesheet" href="{{ asset("plugins/datatables-buttons/css/buttons.bootstrap4.min.css") }}">
@endpush
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Funds</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <a href="{{ route('fund.create') }}" class="btn btn-primary float-right">Add Fund Account</a>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    @include('flash-message')
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="fundaccount-report">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>CONTACT_ID</th>
                                            <th>FUND_ID</th>
                                            <th>Account Type</th>
                                            <th>Ifsc</th>
                                            <th>Bank Name</th>
                                            <th>Beneficiary Name</th>
                                            <th>Account No</th>
                                            <th>UPI Username</th>
                                            <th>UPI Handle</th>
                                            <th>UPI Address</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
@push('page-script')
<script src="{{ asset("plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}"></script>

    <script>
        $(document).ready(function () {
            var table = $('#fundaccount-report').DataTable({
                pagingType: 'full_numbers',
                processing: true,
                serverSide: true,
                ajax: "{{ url('admin/funds') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'contact_id', name: 'contact_id'},
                    {data: 'razorpay_acc_id', name: 'razorpay_acc_id'},
                    {data: 'account_type', name: 'account_type'},
                    {data: 'ifsc', name: 'account_type'},
                    {data: 'bank_name', name: 'bank_name'},
                    {data: 'beneficiary_name', name: 'beneficiary_name'},
                    {data: 'account_number', name: 'account_number'},
                    {data: 'upi_username', name: 'upi_username'},
                    {data: 'upi_handle', name: 'upi_handle'},
                    {data: 'upi_address', name: 'upi_address'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endpush