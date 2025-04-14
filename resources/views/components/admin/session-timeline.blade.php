    <div class="conf-step__seances-hall">
        <h3 class="conf-step__seances-title">{{ $hall->name }}</h3>

        <div class="conf-step__seances-timeline">
            @php
                $sessionsByDate = $movieSessions[$hall->id] ?? collect();
                $earliest = $sessionsByDate->min(function ($s) {
                    $time = \Carbon\Carbon::parse($s->start_time);
                    return $time->hour * 60 + $time->minute;
                });
            @endphp

            @foreach ($sessionsByDate as $session)
                @php
                    $start = \Carbon\Carbon::parse($session->start_time);
                    $left = ($start->hour * 60 + $start->minute) - $earliest;
                    $duration = $session->movie->duration ?? 0;
                @endphp
                <div class="conf-step__seances-movie" data-date="{{ $date }}"
                    style="width: {{ $duration }}px; background-color: rgb(133, 255, 137); left: {{ $left }}px;">
                    <p class="conf-step__seances-movie-title">{{ $session->movie->title }}</p>
                    <p class="conf-step__seances-movie-start">{{ $start->format('H:i') }}</p>
                </div>
            @endforeach
        </div>
    </div>
