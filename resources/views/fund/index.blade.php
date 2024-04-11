@extends('layout.app')

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
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            {{-- <th>Id</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>CONTACT_ID</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach($customers as $customer)
                                        <tr>
                                            <td>{{ $customer->id }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td><span class="badge badge-pill badge-secondary">{{ $customer->type }}</span></td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>
                                                @if($customer->status == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $customer->razorpay_con_id }}</td>
                                        </tr>
                                        @endforeach --}}
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