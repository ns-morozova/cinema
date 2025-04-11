<section class="conf-step">
    <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация залов</h2>
    </header>
    <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box" id="hall-selector">
            @foreach ($halls as $hall)
                <li>
                    <input type="radio" class="conf-step__radio" name="chairs-hall" value="{{ $hall['id'] }}" data-id="{{ $hall['id'] }}">
                    <span class="conf-step__selector">{{ $hall['name'] }}</span>
                </li>
            @endforeach
        </ul>
        <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
        <div class="conf-step__legend">
            <label class="conf-step__label">Рядов, шт<input type="text" id="rows" class="conf-step__input" placeholder="10" readonly></label>
            <span class="multiplier">x</span>
            <label class="conf-step__label">Мест, шт<input type="text" id="seats-per-row" class="conf-step__input" placeholder="8" readonly></label>
        </div>
        <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
        <div class="conf-step__legend">
            <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
            <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
            <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
            <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
        </div>
        <!-- Схема зала -->
        <div class="conf-step__hall" id="hall-layout">
            <!-- Здесь будет динамически отображаться план зала -->
        </div>
        <fieldset class="conf-step__buttons text-center">
            <button class="conf-step__button conf-step__button-regular">Отмена</button>
            <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
        </fieldset>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const hallSelector = document.getElementById('hall-selector');
    const rowsInput = document.getElementById('rows');
    const seatsPerRowInput = document.getElementById('seats-per-row');
    const hallLayout = document.getElementById('hall-layout');

    // Функция для обновления данных о зале
    async function updateHallData(hallId) {
        try {
            const response = await fetch(`/admin/get-hall-data`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ hall_id: hallId }),
            });

            const data = await response.json();

            if (data.error) {
                alert(data.error);
                return;
            }

            // Обновляем количество рядов и мест в ряду
            rowsInput.value = data.rows;
            seatsPerRowInput.value = data.seats_per_row;

            // Обновляем план зала
            renderHallLayout(data.layout);
        } catch (error) {
            console.error('Ошибка при получении данных о зале:', error);
        }
    }

    // Функция для отрисовки плана зала
    function renderHallLayout(layout) {
        hallLayout.innerHTML = '';

        layout.forEach(row => {
            const rowDiv = document.createElement('div');
            rowDiv.className = 'conf-step__row';

            row.forEach(seatType => {
                const seatSpan = document.createElement('span');
                seatSpan.className = `conf-step__chair conf-step__chair_${seatType}`;
                rowDiv.appendChild(seatSpan);
            });

            hallLayout.appendChild(rowDiv);
        });
    }

    // Обработчик выбора зала
    hallSelector.addEventListener('change', function (event) {
        const selectedHallId = event.target.value;
        if (selectedHallId) {
            updateHallData(selectedHallId);
        }
    });

    // Инициализация первого зала
    const firstHallRadio = document.querySelector('#hall-selector input[type="radio"]');
    if (firstHallRadio) {
        firstHallRadio.checked = true;
        updateHallData(firstHallRadio.value);
    }
});
</script>