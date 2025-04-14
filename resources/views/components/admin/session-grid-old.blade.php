<section class="conf-step">
    <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Сетка сеансов</h2>
    </header>
    <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">
            <button class="conf-step__button conf-step__button-accent">Добавить фильм</button>
        </p>

        <div class="conf-step__movies">
            @forelse($movies as $movie)
                <div class="conf-step__movie">
                    <img class="conf-step__movie-poster" alt="poster"
                        src="{{ $movie->poster ? asset($movie->poster) : asset('images/admin/poster.png') }}">
                    <h3 class="conf-step__movie-title">{{ $movie->title }}</h3>
                    <p class="conf-step__movie-duration">{{ $movie->duration }} минут</p>
                </div>
            @empty
                <p>Фильмы пока не добавлены.</p>
            @endforelse
        </div>

        <div class="mt-20">
            @php
                use Carbon\Carbon;

                $startDate = Carbon::create(2025, 4, 14);
                $dates = [];
                for ($i = 0; $i < 14; $i++) {
                    $dates[] = $startDate->copy()->addDays($i);
                }

                $weekdays = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'];
            @endphp

            <ul class="conf-step__selectors-box selector-date" id="date-selector">
                @foreach ($dates as $index => $date)
                    <li class="date-option {{ $index >= 7 ? 'hidden' : '' }}">
                        <input type="radio" class="conf-step__radio radio-date" name="session-date"
                            value="{{ $date->toDateString() }}" id="date-{{ $index }}" {{ $index === 0 ? 'checked' : '' }}>
                        <span class="conf-step__selector leading-7">
                            {{ $date->format('d.m') }}
                            <br>
                            <small style="font-size: 0.8em; color: #888;">
                                {{ $weekdays[$date->dayOfWeek] }}
                            </small>
                        </span>
                    </li>
                @endforeach
                <li class="button-arrow">
                    <button type="button" class="conf-step__button-arrow" id="toggle-dates">→</button>
                </li>
            </ul>
        </div>

        {{-- <div class="conf-step__seances">
            <div class="conf-step__seances-hall">
                <h3 class="conf-step__seances-title">Зал 1</h3>
                <div class="conf-step__seances-timeline">
                    <div class="conf-step__seances-movie"
                        style="width: 60px; background-color: rgb(133, 255, 137); left: 0;">
                        <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                        <p class="conf-step__seances-movie-start">10:00</p>
                    </div>
                    <div class="conf-step__seances-movie"
                        style="width: 60px; background-color: rgb(133, 255, 137); left: 360px;">
                        <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                        <p class="conf-step__seances-movie-start">12:00</p>
                    </div>
                    <div class="conf-step__seances-movie"
                        style="width: 65px; background-color: rgb(202, 255, 133); left: 420px;">
                        <p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных
                            клонов</p>
                        <p class="conf-step__seances-movie-start">14:00</p>
                    </div>
                </div>
            </div>
            <div class="conf-step__seances-hall">
                <h3 class="conf-step__seances-title">Зал 2</h3>
                <div class="conf-step__seances-timeline">
                    <div class="conf-step__seances-movie"
                        style="width: 65px; background-color: rgb(202, 255, 133); left: 595px;">
                        <p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных
                            клонов</p>
                        <p class="conf-step__seances-movie-start">19:50</p>
                    </div>
                    <div class="conf-step__seances-movie"
                        style="width: 60px; background-color: rgb(133, 255, 137); left: 660px;">
                        <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                        <p class="conf-step__seances-movie-start">22:00</p>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="conf-step__seances">
            @foreach ($halls as $hall)
                    <div class="conf-step__seances-hall">
                        <h3 class="conf-step__seances-title">{{ $hall['name'] }}</h3>
                        {{-- <div class="conf-step__seances-timeline">
                            <div class="conf-step__seances-movie"
                                style="width: 60px; background-color: rgb(133, 255, 137); left: 0;">
                                <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                                <p class="conf-step__seances-movie-start">00:00</p>
                            </div>
                            <div class="conf-step__seances-movie"
                                style="width: 60px; background-color: rgb(133, 255, 137); left: 360px;">
                                <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                                <p class="conf-step__seances-movie-start">12:00</p>
                            </div>
                            <div class="conf-step__seances-movie"
                                style="width: 65px; background-color: rgb(202, 255, 133); left: 420px;">
                                <p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных
                                    клонов</p>
                                <p class="conf-step__seances-movie-start">14:00</p>
                            </div>
                        </div> --}}

                        <div class="conf-step__seances-timeline">
                            @foreach ($movieSessions->where('hall_id', $hall['id']) as $session)
                                            @php
                                                $start = \Carbon\Carbon::parse($session->start_time);
                                                $date = $start->toDateString();
                                                $duration = $session->movie->duration ?? 0;
                                                $width = $duration; // 1 мин = 1px
                                                $left = $start->hour * 60 + $start->minute;
                                            @endphp
                                            <div class="conf-step__seances-movie" data-date="{{ $date }}"
                                                style="width: {{ $width }}px; background-color: rgb(133, 255, 137); left: {{ $left }}px;">
                                                <p class="conf-step__seances-movie-title">{{ $session->movie->title }}</p>
                                                <p class="conf-step__seances-movie-start">{{ $start->format('H:i') }}</p>
                                            </div>
                            @endforeach
                        </div>
                    </div>
            @endforeach
        </div>

        <fieldset class="conf-step__buttons text-center">
            <button class="conf-step__button conf-step__button-regular">Отмена</button>
            <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
        </fieldset>
    </div>
</section>

<script>
    // document.addEventListener('DOMContentLoaded', function () {
    //     const toggleBtn = document.getElementById('toggle-dates');
    //     const dateOptions = document.querySelectorAll('#date-selector .date-option input');
    //     let showingFirstGroup = true;

    //     toggleBtn.addEventListener('click', function () {
    //         dateOptions.forEach((input, idx) => {
    //             const parent = input.closest('.date-option');
    //             if (showingFirstGroup) {
    //                 parent.classList.toggle('hidden', idx < 7);
    //             } else {
    //                 parent.classList.toggle('hidden', idx >= 7);
    //             }
    //         });

    //         // Сброс выбранного — и установка нужного по умолчанию
    //         dateOptions.forEach(input => input.checked = false);
    //         if (showingFirstGroup) {
    //             dateOptions[7].checked = true; // 21 апреля
    //             toggleBtn.textContent = '←';
    //         } else {
    //             dateOptions[0].checked = true; // 14 апреля
    //             toggleBtn.textContent = '→';
    //         }

    //         showingFirstGroup = !showingFirstGroup;
    //     });
    // });

    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggle-dates');
        const dateOptions = document.querySelectorAll('#date-selector .date-option input');
        let showingFirstGroup = true;

        function filterSessionsByDate(date) {
            document.querySelectorAll('.conf-step__seances-movie').forEach(el => {
                if (el.dataset.date === date) {
                    el.style.display = '';
                } else {
                    el.style.display = 'none';
                }
            });
        }

        // Фильтрация при выборе даты
        dateOptions.forEach(input => {
            input.addEventListener('change', function () {
                if (this.checked) {
                    filterSessionsByDate(this.value);
                }
            });
        });

        // Инициализация фильтра при загрузке
        const checkedDate = document.querySelector('.radio-date:checked')?.value;
        if (checkedDate) {
            filterSessionsByDate(checkedDate);
        }

        toggleBtn.addEventListener('click', function () {
            dateOptions.forEach((input, idx) => {
                const parent = input.closest('.date-option');
                if (showingFirstGroup) {
                    parent.classList.toggle('hidden', idx < 7);
                } else {
                    parent.classList.toggle('hidden', idx >= 7);
                }
            });

            dateOptions.forEach(input => input.checked = false);
            if (showingFirstGroup) {
                dateOptions[7].checked = true;
                toggleBtn.textContent = '←';
                filterSessionsByDate(dateOptions[7].value);
            } else {
                dateOptions[0].checked = true;
                toggleBtn.textContent = '→';
                filterSessionsByDate(dateOptions[0].value);
            }

            showingFirstGroup = !showingFirstGroup;
        });
    });
</script>