{{-- @extends('layouts.app')

@section('content')

@endsection --}}


<!DOCTYPE html>
<html>
<head>
    <title>XSS Test</title>
</head>
<body>
    <h1>XSS Output Test</h1>

    <h2>Escaped Output (Safe):</h2>
    <p>{{ $student->religion }}</p>

    <h2>Unescaped Output (Vulnerable):</h2>
    <p>{!! $student->religion !!}</p>
</body>
</html>
