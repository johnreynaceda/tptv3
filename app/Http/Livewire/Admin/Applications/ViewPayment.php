<?php

namespace App\Http\Livewire\Admin\Applications;

use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\DB;
use App\Models\{Examination,Application,User,Payment,Proof,Permit};

class ViewPayment extends Component
{

    use Actions;
    public $payment;
    public $user_id;
    public $reject_modal = false;
    public $remarks;
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

    // public function approveConfirm()
    // {
    //     $user = User::where('id', $this->user_id)
    //                     ->with(['application'])
    //                     ->first();
    //     $user->update([
    //         'step' => '5',
    //     ]);
    //     //get last id of permit then add 1
    //     //check if permit is null
    //     $permit = Permit::latest()->first();
    //     if($permit == null)
    //     {
    //         $code_series = "0001";
    //     }else{
    //         $code_series = str_pad($permit->id + 1, 4, '0', STR_PAD_LEFT);
    //     }

    //     $code_series_user = "2" . str_pad($user->id, 4, '0', STR_PAD_LEFT);
    //     Permit::create([
    //         'examinee_number' => $code_series_user,
    //         'examinee_number_updated' => $code_series,
    //         'user_id'=>$user->id,
    //         'examination_id'=>$user->application->examination_id,
    //     ]);
    //     $this->notification([
    //         'title' => 'Success',
    //         'description' => 'Payment has been approved',
    //         'icon' => 'success',
    //     ]);
    //     $this->emit('refresh');
    //     $this->dispatchBrowserEvent('none');
    // }

    public function approveConfirm()
{
    DB::beginTransaction(); 

    try {
        $user = User::where('id', $this->user_id)
                    ->with(['application'])
                    ->first();

        $user->update([
            'step' => '5',
        ]);

        $starting_number = '411111';

        $last_permit = Permit::latest('examinee_number')->first();

        if ($last_permit === null) {
            $new_examinee_number = $starting_number;
        } else {
            $new_examinee_number = str_pad((int)$last_permit->examinee_number + 1, 6, '0', STR_PAD_LEFT);
        }

        Permit::create([
            'examinee_number' => $new_examinee_number,
            'user_id' => $user->id,
            'examination_id' => $user->application->examination_id,
        ]);

        DB::commit(); 

        $this->notification([
            'title' => 'Success',
            'description' => 'Examinee has been approved and assigned a number.',
            'icon' => 'success',
        ]);

        $this->emit('refresh');
        $this->dispatchBrowserEvent('none');
    } catch (\Exception $e) {
        DB::rollBack(); 

        logger()->error($e->getMessage());

        $this->notification([
            'title' => 'Error',
            'description' => 'An error occurred while approving the examinee. Please try again.',
            'icon' => 'error',
        ]);
    }
}

    public function reject()
    {
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => ' Are you sure you want to reject this payment?',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, reject it',
                'method' => 'rejectRemarks',
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);
    }

    public function rejectRemarks()
    {
        $this->reject_modal = true;
    }

    public function rejectConfirm()
    {
        $this->validate([
            'remarks' => 'required',
        ]);
        $user = User::where('id', $this->user_id)->first();
        $user->step = '3';
        $user->is_declined = true;
        $user->remarks = $this->remarks;
        $user->save();
        // $user->update([
        //     'step' => '3',
        //     'is_declined' => true,
        //     'remarks' => $this->remarks,
        // ]);
        $this->notification([
            'title' => 'Success',
            'description' => 'Payment has been rejected',
            'icon' => 'success',
        ]);
        $this->emit('refresh');
        $this->dispatchBrowserEvent('none');
    }
}
