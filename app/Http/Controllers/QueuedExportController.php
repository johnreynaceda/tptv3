<?php

namespace App\Http\Controllers;

use App\Exports\UsersWithPermitAndSlotQueuedExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class QueuedExportController extends Controller
{
    /**
     * Queue the export of users with permit and slot
     * 
     * @return \Illuminate\Http\Response
     */
    public function exportUsersWithPermitAndSlot()
    {
        $filename = 'users_with_permit_and_slot_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $filePath = 'exports/' . $filename;
        
        // Queue the export
        (new UsersWithPermitAndSlotQueuedExport)
            ->queue($filePath)
            ->chain([
                // You can add notification jobs here if needed
                // new NotifyUserOfCompletedExport(auth()->user()),
            ]);
        
        return back()->with('success', 'Export has been queued. You will be notified when it is ready for download.');
    }
    
    /**
     * List all completed exports
     * 
     * @return \Illuminate\Http\Response
     */
    public function listExports()
    {
        $files = Storage::files('exports');
        $exports = collect($files)->map(function ($file) {
            return [
                'name' => basename($file),
                'size' => Storage::size($file),
                'last_modified' => Storage::lastModified($file),
                'url' => route('export.download', ['filename' => basename($file)]),
            ];
        })->sortByDesc('last_modified');
        
        return view('exports.list', compact('exports'));
    }
    
    /**
     * Download a completed export
     * 
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function downloadExport($filename)
    {
        $path = 'exports/' . $filename;
        
        if (!Storage::exists($path)) {
            return back()->with('error', 'Export file not found.');
        }
        
        return Storage::download($path);
    }
}
