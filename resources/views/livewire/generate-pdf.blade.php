<div>
    <!-- Button to trigger PDF generation -->
    <button wire:click="generatePdf" class="px-4 py-2 bg-blue-500 text-white rounded">
        Generate PDF
    </button>

    <!-- Display the link to open the PDF if it's generated -->
    @if ($pdfUrl)
        <a href="{{ $pdfUrl }}" target="_blank" class="block mt-4 text-blue-500 underline">
            Open PDF in a new tab
        </a>
    @endif
</div>
