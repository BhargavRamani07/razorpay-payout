@extends('layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Contact Payment Methods</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a href="{{ url('admin/funds') }}" class="btn btn-primary float-right">Back</a>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4 card-deck">
                    @forelse ($accounts as $account)
                        <div class="col-md-4">
                            <!-- card-header -->
                            <div class="card h-100 card-default">
                                <div class="card-header">
                                    <h3 class="card-title text-uppercase">{{ Str::replace('_', ' ', $account->account_type) }}</h3>
                                    @if ($account->status)
                                        <a href="{{ route('fund.account.mark.status', $account->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-default float-right">Mark as inactive</a>
                                    @else
                                        <a href="{{ route('fund.account.mark.status', $account->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-default float-right">Mark as active</a>
                                    @endif
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        @if ($account->account_type == 'bank_account')
                                            <div class="col-md-6">
                                                <label class="text-black-50">Account No</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-dark">{{ $account->account_number }}</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-black-50">Bank</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-dark">{{ $account->bank_name }}</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-black-50">IFSC</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-dark">{{ $account->ifsc }}</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-black-50">Beneficiary</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-dark">{{ $account->beneficiary_name }}</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-black-50">Fund ID</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-dark">{{ $account->razorpay_acc_id }}</label>
                                            </div>
                                        @else
                                            <div class="col-md-6">
                                                <label class="text-black-50">UPI Username</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-dark">{{ $account->upi_username }}</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-black-50">UPI Handle</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-dark">{{ $account->upi_handle }}</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-black-50">UPI Address</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-dark">{{ $account->upi_address }}</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-black-50">Fund ID</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-dark">{{ $account->razorpay_acc_id }}</label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    @empty
                        <h1 class="text-center">No Accounts Found</h1>
                    @endforelse
                </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
