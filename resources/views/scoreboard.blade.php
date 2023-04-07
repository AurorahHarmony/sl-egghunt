<x-layout>
    <x-slot:title>
        All Scores
    </x-slot>

    <div class="container py-2">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="bg-white p-4 rounded-5 shadow mb-3">
                    <a href="/" class="btn btn-sm btn-outline-primary rounded-pill mb-3">&lt; Home</a>
                    <h2>High Scores</h2>

                    @foreach ($all_scores as $score)
                    {{-- <a href="/user/{{$score->user_uuid}}" class="text-decoration-none text-dark"> --}}
                        <div class="row align-items-center">
                            {{-- <div class="col-auto">
                                <img src="https://my-secondlife-agni.akamaized.net/users/aurorahHarmony resident/sl_image.png" class="rounded" height="40" width="40">
                            </div> --}}
                            <div class="col fw-bold" style="line-height: 1.25;">{{$score->username}}<br><span class="fw-light text-muted">{{$score->legacy_username}}</span></div>
                            <div class="col text-end">{{$score->total_score}}</div>
                        </div>
                        <hr class="my-2">
                    {{-- </a> --}}
                    @endforeach
                </div>
            </div>
</x-layout>
