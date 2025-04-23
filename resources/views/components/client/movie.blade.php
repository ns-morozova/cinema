<div class="movie">
    <div class="movie__info">
        <div class="movie__poster">
            <img class="movie__poster-image" alt="{{ $title }} постер" src="{{ asset($poster) }}">
        </div>
        <div class="movie__description">
            <h2 class="movie__title">{{ $title }}</h2>
            <p class="movie__synopsis">{{ $description }}</p>
            <p class="movie__data">
                <span class="movie__data-duration">{{ $duration }}</span>
                <span class="movie__data-origin">{{ $country }}</span>
            </p>
        </div>
    </div>

    @foreach ($seances as $hallName => $times)
        <div class="movie-seances__hall">
            <h3 class="movie-seances__hall-title">{{ $hallName }}</h3>
            <ul class="movie-seances__list">
                @foreach ($times as $time)
                    <li class="movie-seances__time-block">
                        <a class="movie-seances__time" href="/hall">{{ $time }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>