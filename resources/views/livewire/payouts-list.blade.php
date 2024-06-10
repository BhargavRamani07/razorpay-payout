<div>
    <div class="card card-primary">
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead class="text-left">
                        <tr>
                            <th>Created At</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Contact</th>
                            <th>UTR</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-left">
                        @foreach($payouts as $payout)
                            <tr>
                                <td>{{ date("D d M, h:i A", strtotime($payout->created_at)) }}</td>
                                <td><b>₹{{ $payout->amount }}</b></td>
                                <td>{!! $payout->displayStatus() !!}</td>
                                <td>{{ $payout->contact->name }}</td>
                                <td>{{ $payout->utr }}</td>
                                <td>
                                    <a href="" class="btn btn-sm btn-dark">View Payout</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="float-right">
                    {{ $payouts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
