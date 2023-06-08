<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Permit;

class ResultReport extends Component
{
    public $remarks;
    public function render()
    {
        $remarks = $this->remarks;
        $query = Permit::whereHas('result', function ($query) use ($remarks) {
            if ($remarks == 1) {
                $query->whereBetween('total_standard_score', [525, 800]);
            } elseif ($remarks == 2) {
                $query->whereBetween('total_standard_score', [375, 524]);
            } else {
                $query->where('total_standard_score', '>=', 375);
            }
        });

        $permits = $query->paginate(100);

        return view('livewire.admin.result-report', [
            'permits' => $permits,
        ]);
    }
}
