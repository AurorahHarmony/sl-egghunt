<x-layout>
    <x-slot:title>
        Overview
    </x-slot>

    <div class="container py-2">
        <div class="row">
            <div class="col-lg-6">
                <div class="bg-white p-4 rounded-5 shadow mb-3">
                    <h2>High Scores</h2>

                    @foreach ($high_scores as $score)
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

                    <div class="text-center mt-4">
                        <a href="/scoreboard" class="btn btn-primary rounded-pill">View all</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="bg-white p-4 rounded-5 shadow mb-3">
                    <h2>Recent</h2>
                    @php
                        $now = \Carbon\Carbon::now();
                    @endphp
                    @foreach ($recent_scores as $score)
                    {{-- <a href="/user/{{$score->user_uuid}}" class="text-decoration-none text-dark"> --}}
                        <div class="row align-items-center">
                            {{-- <div class="col-auto">
                                <img src="https://placehold.co/50x50" class="rounded" height="40" width="40">
                            </div> --}}
                            <div class="col-auto" style="line-height: 1.25;"><span class="fw-bold">{{$score->score->username}}</span> found an egg in <span class="fw-bold">{{trim(strtok($score->region, '('))}}</span>!<br><span class="fw-light text-muted">{{$score->score->legacy_username}} - {{\Carbon\Carbon::createFromTimeString($score->created_at)->diffForHumans($now,true, true, 1)}} ago</span></div>
                            <div class="col text-end">{{$score->score->total_score}}</div>
                        </div>
                        <hr class="my-2">
                    {{-- </a> --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layout>
