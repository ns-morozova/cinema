<section class="conf-step">
    <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Сетка сеансов</h2>
    </header>
    <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">
            <button id="create-movie-btn" class="conf-step__button conf-step__button-accent">
                Добавить фильм
            </button>
        </p>
        <div class="conf-step__movies mt-10">
            @forelse($movies as $movie)
                <div class="conf-step__movie relative" style="background-color: {{ $movie->color }}">
                    <img class="conf-step__movie-poster" alt="poster"
                        src="{{ $movie->poster ? asset($movie->poster) : asset('images/admin/poster.png') }}">
                    <h3 class="conf-step__movie-title">{{ $movie->title }}</h3>
                    <p class="conf-step__movie-duration">{{ $movie->duration }} минут</p>
                    <div class="absolute right-2 bottom-2">
                        <button
                            class="conf-step__button conf-step__button-trash delete-movie-btn"
                             data-id="{{ $movie->id }}"
                             data-title="{{ $movie->title }}">
                        </button>
                    </div>
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

        <div>
            <p class="conf-step__paragraph">
                <button id="create-session-btn" class="conf-step__button conf-step__button-accent">
                    Добавить сеанс
                </button>
            </p>
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

<div id="create-movie-modal" class="modal" style="display:none;">
    <div class="modal__overlay"></div>
    <div class="modal__window">
        <h3 class="modal__title">Добавить новый фильм</h3>
        <form id="create-movie-form" action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label class="modal__label">Название фильма:
                <input type="text" name="title" class="modal__input" required>
            </label>
            <label class="modal__label">Описание:
                <input type="text" name="description" class="modal__input" required>
            </label>
            <label class="modal__label">Продолжительность, минут:
                <input type="number" name="duration" class="modal__input" min="1" required>
            </label>
            <label class="modal__label">Страна:
                <input type="text" name="country" class="modal__input" required>
            </label>
            <label class="modal__label modal__label_color">Цвет в таблице сеансов:
                <input type="color" name="color" class="modal__input" id="movie-color" value="#B78EAA" required>
            </label>
            <label class="modal__label">Постер:
                <input type="file" name="poster" class="modal__input" accept="image/*" required>
            </label>

            <div class="modal__actions">
                <button type="button" id="cancel-create-movie"
                    class="conf-step__button conf-step__button-regular">Отмена</button>
                <button type="submit" id="save-create-movie"
                    class="conf-step__button conf-step__button-accent">Сохранить</button>
            </div>
        </form>
    </div>
</div>

<div id="delete-movie-modal" class="modal" style="display: none;">
    <div class="modal__overlay"></div>
    <div class="modal__window">
        <h3 class="modal__title">Удалить фильм</h3>
        <p id="delete-movie-text" class="modal__label">Вы уверены, что хотите удалить фильм?</p>
        <form id="delete-movie-form" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal__actions">
                <button type="button" id="cancel-delete-movie" class="conf-step__button conf-step__button-regular">Отмена</button>
                <button type="submit" class="conf-step__button conf-step__button-accent">Удалить</button>
            </div>
        </form>
    </div>
</div>

<div id="create-session-modal" class="modal" style="display:none;">
    <div class="modal__overlay"></div>
    <div class="modal__window">
        <h3 class="modal__title">Добавить сеанс</h3>
        <form id="create-session-form" action="{{ route('admin.sessions.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <label class="modal__label">Дата:
                <input type="hidden" name="date" id="hidden-date">
                <p id="checked-date" class="text-gray-500 text-md mt-2"></p>
            </label>
            <label class="modal__label">Фильм:
                <select name="movie_id" class="modal__input" required>
                    <option value="">Выберите фильм</option>
                    @foreach ($movies as $movie)
                        <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                    @endforeach
                </select>
            </label>

            <label class="modal__label">Зал:
                <select name="hall_id" class="modal__input" required>
                    <option value="">Выберите зал</option>
                    @foreach ($halls as $hall)
                        <option value="{{ $hall['id'] }}">{{ $hall['name'] }}</option>
                    @endforeach
                </select>
            </label>

            <label class="modal__label">Время сеанса:
                <select name="time" class="modal__input" required>
                    <option value="">Выберите время</option>
                    <option value="09:00">09:00</option>
                    <option value="12:00">12:00</option>
                    <option value="15:00">15:00</option>
                    <option value="18:00">18:00</option>
                    <option value="21:00">21:00</option>
                </select>
            </label>
            @error('time')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <div class="modal__actions">
                <button type="button" id="cancel-create-session"
                    class="conf-step__button conf-step__button-regular">Отмена</button>
                <button type="submit" id="save-create-session"
                    class="conf-step__button conf-step__button-accent">Сохранить</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let selectedDate = undefined;

        const createModalMovie = document.getElementById('create-movie-modal');
        const createBtnMovie = document.getElementById('create-movie-btn');
        const cancelBtnMovie = document.getElementById('cancel-create-movie');

        const dltModalMovie = document.getElementById('delete-movie-modal');
        const dltFormMovie = document.getElementById('delete-movie-form');
        const dltTextMovie = document.getElementById('delete-movie-text');
        const cancelDltBtnMovie = document.getElementById('cancel-delete-movie');

        const createModalSession = document.getElementById('create-session-modal');
        const createBtnSession = document.getElementById('create-session-btn');
        const cancelBtnSession = document.getElementById('cancel-create-session');

        const closeModalMovie = () => createModalMovie.style.display = 'none';
        const openModalMovie = () => createModalMovie.style.display = 'block';

        const closeModalSession = () => createModalSession.style.display = 'none';
        const openModalSession = () => { 
            createModalSession.style.display = 'block';
            const dateParagraph = document.getElementById('checked-date');
            if (dateParagraph) {
                dateParagraph.textContent = selectedDate;
                document.getElementById('hidden-date').value = selectedDate;
            }
        };

        const colorInput = document.getElementById('movie-color');

        colorInput.addEventListener('input', function () {
            this.style.backgroundColor = this.value;
        });

        createBtnMovie.addEventListener('click', openModalMovie);
        cancelBtnMovie.addEventListener('click', closeModalMovie);

        createBtnSession.addEventListener('click', openModalSession);
        cancelBtnSession.addEventListener('click', closeModalSession);

        // Открытие модального окна при клике на кнопку удаления
        document.querySelectorAll('.delete-movie-btn').forEach(button => {
            button.addEventListener('click', () => {
                const movieId = button.getAttribute('data-id');
                const movieTitle = button.getAttribute('data-title');

                dltTextMovie.textContent = `Вы уверены, что хотите удалить фильм «${movieTitle}» из базы?`;
                dltFormMovie.action = `/admin/movies/${movieId}`;

                dltModalMovie.style.display = 'block';
            });
        });

        // Отмена удаления
        cancelDltBtnMovie.addEventListener('click', () => {
            dltModalMovie.style.display = 'none';
        });

        const dateSelector = document.getElementById('date-selector');
        const toggleBtn = document.getElementById('toggle-dates');
        const seancesContainer = document.getElementById('seances-container');
        let showingFirstGroup = true;

        const timelineStart = 9 * 60;   // 9:00 в минутах
        const timelineEnd = 23 * 60;    // 23:00 в минутах
        const timelineDuration = timelineEnd - timelineStart; // всего 840 минут

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
                    const start = new Date(session.start_time);
                    const end = new Date(session.end_time);

                    const startMinutes = start.getHours() * 60 + start.getMinutes();
                    const endMinutes = end.getHours() * 60 + end.getMinutes();
                    const sessionDuration = endMinutes - startMinutes;

                    const leftPercent = ((startMinutes - timelineStart) / timelineDuration) * 100;
                    const widthPercent = (sessionDuration / timelineDuration) * 100;

                    sessionDiv = document.createElement('div');
                    sessionDiv.classList.add('conf-step__seances-movie');
                    sessionDiv.style.backgroundColor = session.movie.color || '#ccc';

                    sessionDiv.style.left = `${leftPercent}%`;
                    sessionDiv.style.width = `${widthPercent}%`;

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
            selectedDate = event.target.value;
            if (selectedDate) {
                loadSessions(selectedDate);
            }
        });

        // Инициализация фильтра при загрузке
        selectedDate = document.querySelector('.radio-date:checked')?.value;
        if (selectedDate) {
            loadSessions(selectedDate);
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