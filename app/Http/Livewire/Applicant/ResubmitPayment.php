<?php

namespace App\Http\Livewire\Applicant;

use App\Models\Payment;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ResubmitPayment extends Component
{

    public function resubmitPayment()
    {
        $payment = Payment::where('user_id', auth()->user()->id)->first();

        if($payment == null)
        {
            return redirect()->route('applicant.payment');
        }else{
            DB::beginTransaction();
            $payment->proofs()->delete();
            $payment->delete();
            DB::commit();
        }


        return redirect()->route('applicant.payment');
    }
    public function render()
    {
        return view('livewire.applicant.resubmit-payment');
    }
}
