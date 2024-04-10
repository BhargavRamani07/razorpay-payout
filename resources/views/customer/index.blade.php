@extends('layout.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Customers</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Customer</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('customer.store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Name">Customer name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" placeholder="Enter customer name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Email">Email address <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Phone">Phone no. <span class="text-danger">*</span></label>
                                            <input type="number" name="phone" class="form-control" placeholder="Enter contact number" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Type">Type <span class="text-danger">*</span></label>
                                            <select name="type" class="form-control" required>
                                                <option value="vendor">vendor</option>
                                                <option value="customer">customer</option>
                                                <option value="employee">employee</option>
                                                <option value="self">self</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Status">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control" required>
                                                <option value="active">active</option>
                                                <option value="inactive">inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Note">Note <span class="text-gray">(Optional)</span></label>
                                            <textarea name="notes" class="form-control" cols="30" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection