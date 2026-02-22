<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Mode - Result Lookup</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-xl font-bold mb-1">Developer Mode</h1>
        <p class="text-gray-500 text-sm mb-6">Enter examinee number to download result PDF</p>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('developer-mode.search') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="examinee_number" class="block text-sm font-medium text-gray-700 mb-1">Examinee Number</label>
                <input type="text"
                       name="examinee_number"
                       id="examinee_number"
                       placeholder="e.g. 509127"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-lg"
                       value="{{ old('examinee_number') }}">
            </div>
            <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">
                Download PDF
            </button>
        </form>
    </div>
</body>
</html>
