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
                        <form action="{{ route("fund.store") }}" method="post" id="createForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Contact">Contact<span class="text-danger">*</span></label>
                                            <select name="contactId" id="contact" class="form-control" required>
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
                                                <option value="back_account" selected>Bank a/c</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="vpa-section" style="display: none;">
                                        <div class="form-group">
                                            <label for="VPA (UPI ID)">VPA (UPI ID) <span class="text-danger">*</span></label>
                                            <input type="text" name="upi_id" class="form-control vpa-common-input" placeholder="upi@server" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="bank-account-section">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Account Type">Account Number <span class="text-danger">*</span></label>
                                            <input type="text" name="account_number" id="account_number" class="form-control bank-common-input" placeholder="Enter account number" required>
                                            <input type="text" name="re_account_number" class="form-control bank-common-input mt-2" placeholder="Re-enter account number" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="IFSC">IFSC <span class="text-danger">*</span></label>
                                            <input type="text" name="ifsc" class="form-control bank-common-input" placeholder="IFSC of the bank account" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Beneficiary Name">Beneficiary Name <span class="text-danger">*</span></label>
                                            <input type="text" name="beneficiary_name" class="form-control bank-common-input" required>
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
            if ($(this).val() == "vpa") {
                $(".vpa-common-input").prop('required',true);
                $(".bank-common-input").val(null).prop('required',false);

                $("#bank-account-section").hide();
                $("#vpa-section").show();
            }else if($(this).val() == "back_account"){
                $(".bank-common-input").prop('required',true);
                $(".vpa-common-input").val(null).prop('required',false);
                
                $("#vpa-section").hide();
                $("#bank-account-section").show();
            }else{
                alert("Please select valid account type");
            }
        });

        $('#createForm').validate({
            rules: {
                contactId: {
                    required: true,
                },
                type: {
                    required: true,
                },
                upi_id: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                account_number: {
                    required: true,  
                },
                re_account_number: {
                    required: true,
                    equalTo: '#account_number'
                },
                ifsc: {
                    required: true,
                    minlength: 11,
                    maxlength: 11
                },
                beneficiary_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 120
                }
            },
            messages: {
                contactId : {
                    required: "Please select contact"
                },
                type : {
                    required: "Please select account type"
                },
                upi_id : {
                    required: "Please enter UPI ID",
                    minlength: "UPI ID at least 3 characters",
                    maxlength: "UPI ID no more than 100 characters",
                },
                account_number : {
                    required: "Please enter account number"
                },
                re_account_number : {
                    required: "Please re-enter account number",
                    equalTo: "Account no. does not match"
                },
                ifsc : {
                    required: "Please enter IFSC code",
                    minlength: "IFSC code must be 11 characters",
                    maxlength: "IFSC code must be 11 characters",
                },
                beneficiary_name : {
                    required: "Please enter beneficiary name",
                    minlength: "Beneficiary name at least 3 characters",
                    maxlength: "Beneficiary name no more than 120 characters",
                }
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