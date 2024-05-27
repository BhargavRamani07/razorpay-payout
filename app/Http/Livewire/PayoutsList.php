<?php

namespace App\Http\Livewire;

use App\Models\Payout;
use Livewire\Component;
use Livewire\WithPagination;

class PayoutsList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {
        $payouts = Payout::select("contact_id", 'amount', 'utr', 'status', 'created_at')->with(['contact:id,name'])->orderBy("id", "DESC")->paginate(10);
        
        return view('livewire.payouts-list', compact('payouts'));
    }
}
