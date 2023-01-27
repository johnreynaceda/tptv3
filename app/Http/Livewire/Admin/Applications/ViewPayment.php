<?php

namespace App\Http\Livewire\Admin\Applications;

use Livewire\Component;
use App\Models\{Examination,Application,User,Payment,Proof,Permit};
use WireUi\Traits\Actions;
class ViewPayment extends Component
{

    use Actions;
    public $payment;
    public $user_id;
    protected $listeners = [
       'loadUserPayment',
    ];
    public function render()
    {
        return view('livewire.admin.applications.view-payment');
    }
    public function loadUserPayment($id)
    {
        $this->user_id = $id;
        $this->payment = Payment::query()
                                    ->where('user_id', $id)
                                    ->with(['user'=>[
                                        'personal_information',
                                    ],'proofs'])
                                    ->first();
    }

    public function approve()
    {
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => ' Are you sure you want to approve this payment?',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, Approve',
                'method' => 'approveConfirm',
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);
    }

    public function approveConfirm()
    {
        $user = User::where('id', $this->user_id)
                        ->with(['application'])
                        ->first();
        $user->update([
            'step' => '5',
        ]);
        $code_series = "200000"+$user->id;
        Permit::create([
            'examinee_number' => $code_series,
            'user_id'=>$user->id,
            'examination_id'=>$user->application->examination_id,
        ]);
        $this->notification([
            'title' => 'Success',
            'description' => 'Payment has been approved',
            'icon' => 'success',
        ]);
        $this->emit('refresh');
        $this->dispatchBrowserEvent('none');
    }

    public function reject()
    {
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => ' Are you sure you want to reject this payment?',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, reject it',
                'method' => 'rejectConfirm',
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);
    }

    public function rejectConfirm()
    {
        $user = User::where('id', $this->user_id)->first();
        $user->update([
            'step' => '100',
        ]);
        $this->notification([
            'title' => 'Success',
            'description' => 'Payment has been rejected',
            'icon' => 'success',
        ]);
        $this->emit('refresh');
        $this->dispatchBrowserEvent('none');
    }
}
