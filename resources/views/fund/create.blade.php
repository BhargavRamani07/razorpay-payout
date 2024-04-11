@extends('layout.app')

@push('page-stylelink')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endpush
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Fund</h1>
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
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Fund Account</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post" id="createForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Contact">Contact<span class="text-danger">*</span></label>
                                            <select name="contact_id" id="contact" class="form-control">
                                                <option></option>
                                                @foreach ($customerContacts as $customerContact)
                                                    <option value="{{ $customerContact->razorpay_con_id }}">{{ $customerContact->razorpay_con_id . " - " . $customerContact->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Account Type">Account Type <span class="text-danger">*</span></label>
                                            <select name="type" id="account-type" class="form-control" required>
                                                <option value="vpa">UPI ID</option>
                                                <option value="vpa" selected>Bank a/c</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="vpa-section" style="display: none;">
                                        <div class="form-group">
                                            <label for="VPA (UPI ID)">VPA (UPI ID) <span class="text-danger">*</span></label>
                                            <input type="number" name="upi_id" class="form-control" placeholder="upi@server">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="bank-account-section">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Account Type">Account Number <span class="text-danger">*</span></label>
                                            <input type="number" name="account_number" class="form-control" placeholder="Enter account number">
                                            <input type="number" name="account_number" class="form-control mt-2" placeholder="Re-enter account number">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="IFSC">IFSC <span class="text-danger">*</span></label>
                                            <input type="text" name="ifsc" class="form-control" placeholder="IFSC of the bank account">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Beneficiary Name">Beneficiary Name <span class="text-danger">*</span></label>
                                            <input type="text" name="beneficiary_name" class="form-control">
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
@push('page-script')
<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(document).ready(function () {

        $('#contact').select2({
            placeholder : "Select contact",
            allowClear : true
        });

        $(document).on("change" , "#account-type", function () {
            $("#vpa-section").show();
            $("#bank-account-section").hide();
        });

        $('#createForm').validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                },
                type: {
                    required: true,
                },
                status: {
                    required: true,
                }
            },
            messages: {
                name : {
                    required: "Please enter customer name"
                },
                email: {
                    required: "Please enter a email address",
                    email: "Please enter a valid email address"
                },
                phone: {
                    required: "Please enter contact number",
                    digits: "Please enter valid contact number",
                    minlength: "contact number must be 10 digit",
                    maxlength: "contact number must be 10 digit",
                },
                type : {
                    required: "Please select customer type"
                },
                status : {
                    required: "Please select cusotmer status"
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endpush