<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Browsershot\Browsershot;

class GeneratePdf extends Component
{
    public $pdfUrl; // Stores the URL of the generated PDF

    public function generatePdf()
    {
        dd('Generate PDF');
        return;
        // Define the path to save the PDF
        $pdfPath = storage_path('app/public/document.pdf');

        // Generate the PDF using Browsershot
        Browsershot::url(route('pdf.test')) // Use the route for the test layout
            ->setOption('args', ['--no-sandbox']) // Required for some server environments
            ->save($pdfPath);

        // Store the URL for the PDF so it can be used in the Blade view
        $this->pdfUrl = asset('storage/document.pdf');
    }

    public function render()
    {
        return view('livewire.generate-pdf');
    }
}
