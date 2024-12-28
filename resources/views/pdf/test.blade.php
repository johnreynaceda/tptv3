<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Layout</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CSS -->
</head>
<body class="bg-gray-100 text-gray-900 p-6">
    <h1 class="text-2xl font-bold">PDF Test Layout</h1>
    <p class="mt-2">This is a simple example layout for generating a PDF with Browsershot.</p>

    <table class="table-auto border-collapse border border-gray-400 mt-6">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">Column 1</th>
                <th class="border border-gray-300 px-4 py-2">Column 2</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border border-gray-300 px-4 py-2">Row 1 Data 1</td>
                <td class="border border-gray-300 px-4 py-2">Row 1 Data 2</td>
            </tr>
            <tr>
                <td class="border border-gray-300 px-4 py-2">Row 2 Data 1</td>
                <td class="border border-gray-300 px-4 py-2">Row 2 Data 2</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
