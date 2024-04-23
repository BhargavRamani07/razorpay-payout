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
                <h1 class="m-0">Contacts</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <a href="{{ route('contact.create') }}" class="btn btn-primary float-right">Add Contact</a>
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
                                <table class="table table-bordered table-striped" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>CONTACT_ID</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contacts as $contact)
                                        <tr>
                                            <td>{{ $contact->id }}</td>
                                            <td>{{ $contact->name }}</td>
                                            <td><span class="badge badge-pill badge-secondary">{{ $contact->type }}</span></td>
                                            <td>{{ $contact->phone }}</td>
                                            <td>{{ $contact->email }}</td>
                                            <td>
                                                @if($contact->status == 1)
                                                    <span class="badge bg-gradient-success">Active</span>
                                                @else
                                                    <span class="badge bg-gradient-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $contact->razorpay_con_id }}</td>
                                            <td>
                                                @if ($contact->status)
                                                    <a href="{{ route("contact.markStatus", $contact->id) }}" onclick="return confirm('Are you sure?')" class="btn bg-gradient-danger btn-sm"><i class="fas fa-user-slash"></i> Mark as Inactive</a>
                                                @else
                                                    <a href="{{ route("contact.markStatus", $contact->id) }}" onclick="return confirm('Are you sure?')" class="btn bg-gradient-success btn-sm"><i class="fas fa-user-check"></i> Mark as Active</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
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

    <script type="text/javascript">
        $(document).ready(function () {
            let table = $('#myTable').DataTable({
                pagingType: 'full_numbers'
            });
        });
    </script>
@endpush