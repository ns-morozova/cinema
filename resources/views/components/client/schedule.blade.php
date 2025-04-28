
<section>
    <div>
        @php
            use Carbon\Carbon;
            $startDate = Carbon::today();
            $dates = [];
            for ($i = 0; $i < 14; $i++) {
                $dates[] = $startDate->copy()->addDays($i);
            }
            $weekdays = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'];
        @endphp
        <ul class="conf-step__selectors-box selector-date-client" id="date-selector-client">
            @foreach ($dates as $index => $date)
                <li class="date-option cursor-pointer {{ $index >= 7 ? 'hidden' : '' }}">
                    <input type="radio" class="conf-step__radio radio-date" name="session-date-client"
                        value="{{ $date->toDateString() }}" id="date-{{ $index }}" {{ $index === 0 ? 'checked' : '' }}>
                    <span class="conf-step__selector leading-7 z-50"
                        style="color: {{ in_array($date->dayOfWeek, [0, 6]) ? '#DE2121' : '#888' }};">
                        {{ $date->format('d.m') }}
                        <br>
                        <small style="font-size: 0.8em; color: {{ in_array($date->dayOfWeek, [0, 6]) ? '#DE2121' : '#888' }};">
                            {{ $weekdays[$date->dayOfWeek] }}
                        </small>
                    </span>
                </li>
            @endforeach
            <li class="button-arrow" id="toggle-dates-client">
                →
            </li>
        </ul>
    </div>

    <div id="movies-container" class="mt-4">
        <!-- Здесь будут динамически отображаться сеансы -->
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateSelector = document.getElementById('date-selector-client');
        const toggleBtnClient = document.getElementById('toggle-dates-client');
        const moviesContainer = document.getElementById('movies-container');

        let showingFirstGroupClient = true;

        // Функция для загрузки фильмов и сеансов через AJAX
        async function loadMoviesAndSessions(date) {
            try {
                const formattedDate = new Date(date).toISOString().split('T')[0];
                const response = await fetch('/client/sessions/by-date', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ date: formattedDate }),
                });

                if (!response.ok) {
                    throw new Error(`Ошибка HTTP: ${response.status}`);
                }

                const data = await response.json();
                renderMoviesAndSessions(data);
            } catch (error) {
                console.error('Ошибка при загрузке данных:', error);
            }
        }

        // Функция для отображения фильмов и сеансов
        function renderMoviesAndSessions(data) {
            moviesContainer.innerHTML = ''; // Очищаем контейнер

            if (!data || data.length === 0) {
                moviesContainer.innerHTML = '<p class="text-white text-2xl">В этот день нет сеансов.</p>';
                return;
            }

            data.forEach(movie => {
                const movieDiv = document.createElement('div');
                movieDiv.classList.add('movie');

                movieDiv.innerHTML = `
            <div class="movie__info">
                <div class="movie__poster">
                    <img class="movie__poster-image" alt="${movie.title} постер" src="${movie.poster}">
                </div>
                <div class="movie__description">
                    <h2 class="movie__title">${movie.title}</h2>
                    <p class="movie__synopsis">${movie.description}</p>
                    <p class="movie__data">
                        <span class="movie__data-duration">${movie.duration}</span>
                        <span class="movie__data-origin">${movie.country}</span>
                    </p>
                </div>
            </div>
            ${Object.entries(movie.seances)
                        .map(([hallName, times]) => `
                    <div class="movie-seances__hall">
                        <h3 class="movie-seances__hall-title">${hallName}</h3>
                        <ul class="movie-seances__list">
                            ${times.map(time => `
                                <li class="movie-seances__time-block">
                                    <a class="movie-seances__time" href="/hall">${time}</a>
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                `)
                        .join('')}
        `;

                moviesContainer.appendChild(movieDiv);
            });
        }

        // Обработчик выбора даты
        dateSelector.addEventListener('change', function (event) {
            const selectedDate = event.target.value;
            if (selectedDate) {
                loadMoviesAndSessions(selectedDate);
            }
        });

        // Переключение между группами дат
        toggleBtnClient.addEventListener('click', function () {
            const dateOptionsClient = document.querySelectorAll('#date-selector-client .date-option input');
            dateOptionsClient.forEach((input, idx) => {
                const parent = input.closest('.date-option');
                if (showingFirstGroupClient) {
                    parent.classList.toggle('hidden', idx < 7);
                } else {
                    parent.classList.toggle('hidden', idx >= 7);
                }
            });
            dateOptionsClient.forEach(input => input.checked = false);

            // Устанавливаем новую выбранную дату
            const newSelectedDate = showingFirstGroupClient ? dateOptionsClient[7].value : dateOptionsClient[0].value;
            if (newSelectedDate) {
                const selectedInput = showingFirstGroupClient ? dateOptionsClient[7] : dateOptionsClient[0];
                selectedInput.checked = true;
                toggleBtnClient.textContent = showingFirstGroupClient ? '←' : '→';

                // Загружаем сеансы для новой выбранной даты
                loadMoviesAndSessions(newSelectedDate);
            }

            showingFirstGroupClient = !showingFirstGroupClient;
        });

        // Инициализация при загрузке страницы
        const initialDate = document.querySelector('.radio-date:checked')?.value;
        if (initialDate) {
            loadMoviesAndSessions(initialDate);
        }
    });
</script>