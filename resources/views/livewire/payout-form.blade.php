<div>
    @include('flash-message')
    <div class="card card-primary">
        <form wire:submit.prevent='storePayout'>
            <div class="card-body">          
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Contact" class="form-label">Contact</label>
                            <select wire:model='contactId' wire:change='getFundAccounts' class="form-control">
                                <option value="">Select contact</option>
                                @foreach ($contacts as $contact)
                                    <option value="{{ $contact['id'] }}">{{ $contact['name'] }} - ({{ $contact['phone'] }}) -
                                        ({{ $contact['email'] }})
                                        - ({{ $contact['type'] }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if ($fundAccounts)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fund-account-select" class="form-label">Pay to</label>
                                <select wire:model='fund_account' wire:change='showAmountDetails' id="fund-account-select" class="form-control">
                                    <option value="">Select fund account</option>
                                    @foreach ($fundAccounts as $fundAccount)
                                        <option value="{{ $fundAccount['id'] }}">
                                            @if ($fundAccount['account_type'] == 'vpa')
                                            UPI ({{ $fundAccount['upi_address'] }})
                                            @elseif($fundAccount['account_type'] == 'bank_account')
                                                {{ $fundAccount['bank_name'] }} (Acc No: {{ $fundAccount['account_number'] }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if ($showAmount)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="amount" class="form-label">Total Amount <span class="text-danger">*</span></label>
                                    <input type="number" wire:model.debounce.1000ms="amount" step="2" id="amount" class="form-control" placeholder="Enter Total Amount">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="PayoutPurpose" class="form-label">Payout Purpose <span class="text-danger">*</span></label>
                                    <select wire:model='purpose' id="PayoutPurpose" class="form-control">
                                        <option value="refund">Refund</option>
                                        <option value="cashback">Cashback</option>
                                        <option value="payout">Payout</option>
                                        <option value="salary">Salary</option>
                                        <option value="utility bill">Utility Bill</option>
                                        <option value="vendor bill">Vendor Bill</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Debit From</label>
                                    <h4 class="text-gray">xx0720</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="PaymentMode" class="form-label">Payment Mode <span class="text-danger">*</span></label>
                                    <select wire:model="payment_mode" id="PaymentMode" class="form-control">
                                        <option value="">Select payment mode</option>
                                        @foreach ($paymentModes as $paymentMode)
                                            <option value="{{ $paymentMode }}">{{ $paymentMode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Reference" class="form-label">Reference</label>
                                    <input type="text" wire:model="reference" id="Reference" class="form-control" placeholder="Enter Reference">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Narration" class="form-label">Narration</label>
                                    <input type="text" wire:model="narration" id="Narration" class="form-control" placeholder="Enter Narration">
                                    <span class="font-weight-bold">Narration will passed in your and the payee's bank statement <i class="far fa-question-circle" style="cursor: pointer;" title="Banks may trim your message based on their word limit. Please enter more important information first."></i></span><br>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-outline-dark float-right">Pay {{ $amount != 0 ? '₹' . $amount : '' }}</button>
            </div>
        </form>
    </div>
</div>
