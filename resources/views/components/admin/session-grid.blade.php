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
                $startDate = Carbon::today();
                $dates = [];
                for ($i = 0; $i < 14; $i++) {
                    $dates[] = $startDate->copy()->addDays($i);
                }
                $weekdays = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'];
            @endphp
            <ul class="conf-step__selectors-box selector-date" id="date-selector">
                @foreach ($dates as $index => $date)
                    <li class="date-option {{ $index >= 7 ? 'hidden' : '' }}">
                        <input 
                            type="radio"
                            class="conf-step__radio radio-date"
                            name="session-date"
                            value="{{ $date->toDateString() }}"
                            id="date-{{ $index }}"
                            {{ $index === 0 ? 'checked' : '' }}
                        >
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
        <div class="conf-step__seances" id="seances-container">
            @foreach ($halls as $hall)
                <div class="conf-step__seances-hall" data-hall-id="{{ $hall['id'] }}">
                    <h3 class="conf-step__seances-title">{{ $hall['name'] }}</h3>
                    <div class="conf-step__seances-timeline"></div>
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
document.addEventListener('DOMContentLoaded', function () {
    const dateSelector = document.getElementById('date-selector');
    const toggleBtn = document.getElementById('toggle-dates');
    const seancesContainer = document.getElementById('seances-container');
    let showingFirstGroup = true;

    // Функция для загрузки сеансов через AJAX
    async function loadSessions(date) {
    try {
        const formattedDate = new Date(date).toISOString().split('T')[0]; // Форматируем дату

        const response = await fetch('/admin/sessions/by-date', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}', // CSRF-токен для Laravel
            },
            body: JSON.stringify({ date: formattedDate }), // Передаем дату в теле запроса
        });

        if (!response.ok) {
            throw new Error(`Ошибка HTTP: ${response.status}`);
        }

        const data = await response.json();
        renderSessions(data.sessions);

    } catch (error) {
        console.error('Ошибка при загрузке сеансов:', error);
    }
}

    // Функция для отображения сеансов
    function renderSessions(sessions) {
        // Очищаем контейнер сеансов
        seancesContainer.innerHTML = '';
        let hallId = 0;
        let hallSessions = [];
        let hallDiv = undefined;
        let hallTitle = undefined;
        let timelineDiv = undefined;
        let sessionDiv = undefined;
        let movieTitle = undefined;
        let startTime = undefined;

        // Отображаем сеансы для каждого зала
        @foreach ($halls as $hall)
            hallId = {{ $hall['id'] }};
            hallSessions = sessions[hallId] || [];

            hallDiv = document.createElement('div');
            hallDiv.classList.add('conf-step__seances-hall');
            hallDiv.setAttribute('data-hall-id', hallId);

            hallTitle = document.createElement('h3');
            hallTitle.classList.add('conf-step__seances-title');
            hallTitle.textContent = '{{ $hall['name'] }}';

            timelineDiv = document.createElement('div');
            timelineDiv.classList.add('conf-step__seances-timeline');

            hallSessions.forEach(session => {
                sessionDiv = document.createElement('div');
                sessionDiv.classList.add('conf-step__seances-movie');

                movieTitle = document.createElement('p');
                movieTitle.classList.add('conf-step__seances-movie-title');
                movieTitle.textContent = session.movie.title;

                startTime = document.createElement('p');
                startTime.classList.add('conf-step__seances-movie-start');
                startTime.textContent = new Date(session.start_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                sessionDiv.appendChild(movieTitle);
                sessionDiv.appendChild(startTime);
                timelineDiv.appendChild(sessionDiv);
            });

            hallDiv.appendChild(hallTitle);
            hallDiv.appendChild(timelineDiv);
            seancesContainer.appendChild(hallDiv);
        @endforeach
    }

    // Обработчик выбора даты
    dateSelector.addEventListener('change', function (event) {
        const selectedDate = event.target.value;
        if (selectedDate) {
            loadSessions(selectedDate);
        }
    });

    // Инициализация фильтра при загрузке
    const checkedDate = document.querySelector('.radio-date:checked')?.value;
    if (checkedDate) {
        loadSessions(checkedDate);
    }

    // Переключение между группами дат
    toggleBtn.addEventListener('click', function () {
        const dateOptions = document.querySelectorAll('#date-selector .date-option input');
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
            loadSessions(dateOptions[7].value);
        } else {
            dateOptions[0].checked = true;
            toggleBtn.textContent = '→';
            loadSessions(dateOptions[0].value);
        }
        showingFirstGroup = !showingFirstGroup;
    });
});
</script>