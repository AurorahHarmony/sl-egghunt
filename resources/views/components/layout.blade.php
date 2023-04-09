<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ? $title . ' - ' : ''}}Poni Egghunt 2023</title>

    <link rel="icon" href="/img/pink-egg.png">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body style="background: linear-gradient(0deg, #0067b1, #3caeff); min-height: 100vh">
    <canvas id="animatedEggsCanvas" style="height: 100vh; width: 100vw; position: fixed; z-index: -1; filter: opacity(0.3);"></canvas>
    <div class="container pt-5 pb-2">
        <div class="text-center mb-3 text-light">
            <h1 class="fw-bold">Poni Egg Hunt</h1>
        </div>

        <div class="d-flex justify-content-center">
            {{-- <div class="bg-dark text-light rounded-pill px-3 py-2 text-center d-inline-block">Time Remaining: 2hrs 45m 07s</div> --}}
        </div>
    </div>
    {{ $slot }}
    <div class="container text-center text-light pb-5">Regions<a href="http://maps.secondlife.com/secondlife/Zephyr%20Heights/19/63/12" class="text-light" target="__blank">Zephyr Heights</a>, <a href="http://maps.secondlife.com/secondlife/Neighberry/135/130/21" class="text-light" target="__blank">Neighberry</a><br><span style="opacity: 0.5;">Hosting provided by: <a href="https://candyhorses.network" class="text-light" target="__blank">CandyHorses</a></span></div>

    <script src="/js/animatedEggs.js"></script>
</body>

</html>
