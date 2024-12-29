<?php

namespace App\Http\Livewire\Admin\Applications;

use App\Http\Controllers\EmailController;
use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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


//     public function approveConfirm()
// {
//     DB::beginTransaction(); // Start the transaction
    
//     try {
//         $user = User::where('id', $this->user_id)
//                     ->with('application') // Load the application relationship
//                     ->first();
        
//         if (!$user || !$user->application) {
//             DB::rollBack(); // Rollback the transaction on error
//             $this->notification([
//                 'title' => 'Error',
//                 'description' => 'User or application not found.',
//                 'icon' => 'error',
//             ]);
//             return;
//         }
    
//         // Update user step
//         $user->update([
//             'step' => '5',
//         ]);
    
//         // Determine the permit examinee number
//         $permit = Permit::latest()->first(); // Get the last created permit
//         $code_series = $permit ? str_pad($permit->id + 1, 6, '0', STR_PAD_LEFT) : "411111";
    
//         // Generate examinee number for the user
//         $code_series_user = "4" . str_pad($user->id, 6, '0', STR_PAD_LEFT);
    
//         // Create new permit
//         Permit::create([
//             'examinee_number' => $code_series_user,
//             'examinee_number_updated' => $code_series_user,
//             'user_id' => $user->id,
//             'examination_id' => $user->application->examination_id,
//         ]);
    
//         // Commit the transaction
//         DB::commit();

//         // Notify and refresh
//         $this->notification([
//             'title' => 'Success',
//             'description' => 'Payment has been approved.',
//             'icon' => 'success',
//         ]);
    
//         $this->emit('refresh');
//         $this->dispatchBrowserEvent('none');
//     } catch (\Exception $e) {
//         DB::rollBack(); // Rollback the transaction on exception
        
//         // Log the error for debugging
//         Log::error('Error approving confirmation: ' . $e->getMessage());

//         $this->notification([
//             'title' => 'Error',
//             'description' => 'An error occurred while processing the request.',
//             'icon' => 'error',
//         ]);
//     }
// }


// version 3
    

// public function approveConfirm()
// {
//     DB::beginTransaction(); // Start the transaction

//     try {
//         $user = User::where('id', $this->user_id)
//                     ->with('application') // Load the application relationship
//                     ->first();

//         if (!$user || !$user->application) {
//             DB::rollBack(); // Rollback the transaction on error
//             $this->notification([
//                 'title' => 'Error',
//                 'description' => 'User or application not found.',
//                 'icon' => 'error',
//             ]);
//             return;
//         }

//         // Update user step
//         $user->update([
//             'step' => '5',
//         ]);

//         // Get the last examinee number
//         $lastPermit = Permit::orderBy('examinee_number', 'desc')->first();

//         // Start from 411111 if no permits exist, otherwise increment
//         $nextExamineeNumber = $lastPermit 
//             ? max(intval($lastPermit->examinee_number) + 1, 411111) // Start at 411111 if no valid number exists
//             : 411111;

//         $nextExamineeNumberFormatted = str_pad($nextExamineeNumber, 6, '0', STR_PAD_LEFT); // Pad to 6 digits

//         // Create new permit
//        $permit = Permit::create([
//             'examinee_number' => $nextExamineeNumberFormatted, // Store the correctly formatted number
//             'examinee_number_updated' => $nextExamineeNumberFormatted,
//             'user_id' => $user->id,
//             'examination_id' => $user->application->examination_id,
//         ]);

//         // Commit the transaction
//         DB::commit();

//         // Notify and refresh
//         $this->notification([
//             'title' => 'Success',
//             'description' => 'Payment has been approved.',
//             'icon' => 'success',
//         ]);
//         EmailController::sendPaymentApplicationApprovalEmail($permit);

//         $this->emit('refresh');
//         $this->dispatchBrowserEvent('none');
//     } catch (\Exception $e) {
//         DB::rollBack(); // Rollback the transaction on exception

//         // Log the error for debugging
//         Log::error('Error approving confirmation: ' . $e->getMessage());

//         $this->notification([
//             'title' => 'Error',
//             'description' => 'An error occurred while processing the request.',
//             'icon' => 'error',
//         ]);
//     }
// }


   

public function approveConfirm()
{
    DB::beginTransaction(); 

    try {
        $user = User::where('id', $this->user_id)
                    ->with('application') 
                    ->first();

        if (!$user || !$user->application) {
            DB::rollBack(); 
            $this->notification([
                'title' => 'Error',
                'description' => 'User or application not found.',
                'icon' => 'error',
            ]);
            return;
        }


        if (Permit::where('user_id', $user->id)->exists()) {
            DB::rollBack(); 
            $this->notification([
                'title' => 'Error',
                'description' => 'This user already has a permit. Duplicate permits are not allowed.',
                'icon' => 'error',
            ]);
            return;
        }


        $user->update([
            'step' => '5',
        ]);

       
        $lastPermit = Permit::orderBy('examinee_number', 'desc')->first();

   
        $nextExamineeNumber = $lastPermit 
            ? max(intval($lastPermit->examinee_number) + 1, 411111) 
            : 411111;

        $nextExamineeNumberFormatted = str_pad($nextExamineeNumber, 6, '0', STR_PAD_LEFT);

     
        $permit = Permit::create([
            'examinee_number' => $nextExamineeNumberFormatted,
            'examinee_number_updated' => $nextExamineeNumberFormatted,
            'user_id' => $user->id,
            'examination_id' => $user->application->examination_id,
        ]);

       
        DB::commit();

     
        $this->notification([
            'title' => 'Success',
            'description' => 'Payment has been approved.',
            'icon' => 'success',
        ]);

     
        EmailController::sendPaymentApplicationApprovalEmail($permit);

        // $this->emit('refresh');
        $this->emit('refreshTable');
        $this->dispatchBrowserEvent('none');
    } catch (\Exception $e) {
        DB::rollBack(); 

      
        Log::error('Error approving confirmation: ' . $e->getMessage());

        $this->notification([
            'title' => 'Error',
            'description' => 'An error occurred while processing the request.',
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
        EmailController::sendPaymentApplicationRejectionEmail($user->application, $this->remarks);
        // $this->emit('refresh');
        $this->emit('refreshTable');
                $this->dispatchBrowserEvent('none');
    }
}
