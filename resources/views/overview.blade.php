<x-layout>
    <x-slot:title>
        Overview
    </x-slot>

    <div class="container py-2">
        <div class="row">
            <div class="col-lg-6">
                <div class="bg-white p-4 rounded-5 shadow mb-3">
                    <h2>High Scores</h2>

                    @for ($i = 0; $i < 7; $i++)
                    <a href="#" class="text-decoration-none text-dark">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="https://placehold.co/50x50" class="rounded" height="40" width="40">
                            </div>
                            <div class="col fw-bold" style="line-height: 1.25;">A username goes here<br><span class="fw-light text-muted">something resident</span></div>
                            <div class="col text-end">1442</div>
                        </div>
                        <hr class="my-2">
                    </a>
                    @endfor

                    <div class="text-center mt-4">
                        <button class="btn btn-primary rounded-pill">View all</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="bg-white p-4 rounded-5 shadow mb-3">
                    <h2>Recent</h2>

                    @for ($i = 0; $i < 7; $i++)
                    <a href="#" class="text-decoration-none text-dark">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="https://placehold.co/50x50" class="rounded" height="40" width="40">
                            </div>
                            <div class="col-auto" style="line-height: 1.25;"><span class="fw-bold">A username goes here</span> found an egg!<br><span class="fw-light text-muted">something resident</span></div>
                            <div class="col text-end">1442</div>
                        </div>
                        <hr class="my-2">
                    </a>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</x-layout>
