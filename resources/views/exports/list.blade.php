<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Completed Exports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <div class="mb-4">
                    <a href="{{ route('export.queue_users_with_permit_and_slot') }}" class="btn btn-primary">
                        Queue New Export
                    </a>
                </div>
                
                @if(count($exports) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Filename</th>
                                    <th>Size</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exports as $export)
                                    <tr>
                                        <td>{{ $export['name'] }}</td>
                                        <td>{{ round($export['size'] / 1024, 2) }} KB</td>
                                        <td>{{ date('Y-m-d H:i:s', $export['last_modified']) }}</td>
                                        <td>
                                            <a href="{{ $export['url'] }}" class="btn btn-sm btn-success">
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        No exports available yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
