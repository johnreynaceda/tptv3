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
            $searchTerm = strtolower($this->search);
            $q->where(function($q) use ($searchTerm) {
                $q->whereRaw('LOWER(full_name) LIKE ?', ["%{$searchTerm}%"])
                  ->orWhereRaw('LOWER(examinee_number) LIKE ?', ["%{$searchTerm}%"]);
            });
        })
        ->pluck('total_standard_score')
        ->filter()
        ->map(fn($s) => intval($s));

    $this->stats = [
        'count'            => $scores->count(),
        'min'              => $scores->min(),
        'max'              => $scores->max(),
        'average'          => $scores->avg() ? number_format($scores->avg(), 2) : null,
        'board_passers'    => $scores->filter(fn($s) => $s >= 530)->count(),
        'nonboard_passers' => $scores->filter(fn($s) => $s >= 400 && $s < 530)->count(),
        'failed'           => $scores->filter(fn($s) => $s < 400)->count(),
    ];
}
public function qualifiedType($score)
{
    if ($score >= 530) return 'Board Program & Non-Board Program';
    if ($score >= 400) return 'Non-Board Program';
    return 'Not Qualified';
}

    protected function stanineInterpretation($stanine)
{
    if ($stanine == 9) return 'Outstanding';
    if ($stanine == 8) return 'Above Average';
    if ($stanine == 7) return 'Above Average';
    if ($stanine == 6) return 'High Average';
    if ($stanine == 5) return 'Middle Average';
    if ($stanine == 4) return 'Low Average';
    if ($stanine == 3) return 'Below Average';
    if ($stanine == 2) return 'Below Average';
    if ($stanine == 1) return 'Low';
    return '';
}

    public function render()
    {
        $results = $this->examination->results()
            ->when($this->search, function($q) {
                $searchTerm = strtolower($this->search);
                $q->where(function($q) use ($searchTerm) {
                    $q->whereRaw('LOWER(full_name) LIKE ?', ["%{$searchTerm}%"])
                      ->orWhereRaw('LOWER(examinee_number) LIKE ?', ["%{$searchTerm}%"]);
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
