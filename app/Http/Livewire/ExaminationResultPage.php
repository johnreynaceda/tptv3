<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Examination;
use App\Models\Result;

class ExaminationResultPage extends Component
{
    use WithPagination;

    public Examination $examination;
    public $search = '';
    public $stats = [];

    // Bootstrap/Tailwind? Use Tailwind (default in Laravel Breeze/Jetstream)
    protected $paginationTheme = 'tailwind';

    public function mount(Examination $examination)
    {
        $this->examination = $examination;
        $this->calculateStats();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function calculateStats()
    {
        $scores = $this->examination->results()
            ->when($this->search, function($q) {
                $q->where(function($q) {
                    $q->where('full_name', 'like', "%{$this->search}%")
                      ->orWhere('examinee_number', 'like', "%{$this->search}%");
                });
            })
            ->pluck('total_standard_score')
            ->filter()
            ->map(fn($s) => intval($s));
        $this->stats = [
            'count'   => $scores->count(),
            'min'     => $scores->min(),
            'max'     => $scores->max(),
            'average' => $scores->avg() ? number_format($scores->avg(), 2) : null,
            'passers' => $scores->filter(fn($s) => $s >= 400)->count(),
        ];
    }

    public function scoreInterpretation($score)
    {
        $score = intval($score);
        if ($score >= 200 && $score <= 324) return 'Low';
        if ($score >= 325 && $score <= 374) return 'Below Average';
        if ($score >= 375 && $score <= 474) return 'Low Average';
        if ($score >= 475 && $score <= 524) return 'Middle Average';
        if ($score >= 525 && $score <= 579) return 'High Average';
        if ($score >= 580 && $score <= 679) return 'Above Average';
        if ($score >= 680 && $score <= 800) return 'Outstanding';
        return 'Invalid';
    }

    public function render()
    {
        $results = $this->examination->results()
            ->when($this->search, function($q) {
                $q->where(function($q) {
                    $q->where('full_name', 'like', "%{$this->search}%")
                      ->orWhere('examinee_number', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('full_name')
            ->paginate(50); // Set your desired per-page count (e.g., 50)

        // Update stats for current search
        $this->calculateStats();

        return view('livewire.examination-result-page', [
            'results' => $results,
        ]);
    }
}
