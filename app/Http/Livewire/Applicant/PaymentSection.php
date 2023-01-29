<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;
use App\Models\{Payment,Proof};
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class PaymentSection extends Component
{
    use WithFileUploads, Actions;
    public $receipt_number,$proofs=[];
    protected $rules = [
        'receipt_number'=>'required|unique:payments,reference_number',
        'proofs.*'=>'required|mimes:jpeg,png,pdf,jpg',
    ];
    public function render()
    {
        return view('livewire.applicant.payment-section');
    }

    public function submit()
    {
        $this->validate();
        if (count($this->proofs)==0) {
            $this->notification([
                'title'=>'Error',
                'description'=>'Please upload atleast one proof',
                'icon'=>'error',
            ]);
            return;
        }
        $examination = auth()->user()->application->examination_id;
        $payment = Payment::create([
            'user_id'=>auth()->user()->id,
            'examination_id'=>$examination,
            'reference_number'=>$this->receipt_number,
            'paid_at'=>now(),
        ]);

        foreach ($this->proofs as $key => $proof) {
            Proof::create([
                'payment_id'=>$payment->id,
                'path'=>$proof->store('proofs','public'),
            ]);
        }
        auth()->user()->update([
            'step'=>'4',
        ]);
        $this->notification([
            'title'=>'Success',
            'description'=>'Payment has been submitted',
            'icon'=>'success',
        ]);
        return redirect()->route('applicant.home');
    }
}
