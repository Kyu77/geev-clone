<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.23/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>@yield('title')</title>
</head>

<body>
 <div class="container mx-auto">

    @include("shared.navbar")
    @yield('body')
 </div>

 @if (session('ok'))
 <x-flash>{{session('ok')}}</x-flash>

 @endif

 @if (session('ko'))
 <x-flash>{{session('ko')}}</x-flash>

 @endif

 @vite(['resources/js/app.js'])

</body>

</html>
