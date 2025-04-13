<section class="conf-step">
    <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация цен</h2>
    </header>
    <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        {{-- <ul class="conf-step__selectors-box">
            @foreach ($halls as $hall)
                <li>
                    <input type="radio" class="conf-step__radio" name="prices-hall" value="Зал 1">
                    <span class="conf-step__selector">{{$hall['name']}}</span>
                </li>
            @endforeach
        </ul> --}}

        <ul class="conf-step__selectors-box" id="hall-selector-price">
            @foreach ($halls as $index => $hall)
                <li>
                    <input type="radio" class="conf-step__radio" name="prices-hall" value="{{ $hall['id'] }}"
                        data-id="{{ $hall['id'] }}" {{ $loop->first ? 'checked' : '' }}>
                    <span class="conf-step__selector">{{ $hall['name'] }}</span>
                </li>
            @endforeach
        </ul>

        <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
        <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей<input id="price-standart" type="text" class="conf-step__input"
                    placeholder="0"></label>
            за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
        </div>
        <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей<input id="price-vip" type="text" class="conf-step__input" placeholder="0"></label>
            за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
        </div>
        <fieldset class="conf-step__buttons text-center">
            <button class="conf-step__button conf-step__button-regular">Отмена</button>
            <button id="save-configuration-price" class="conf-step__button conf-step__button-accent">Сохранить</button>
        </fieldset>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hallSelector = document.getElementById('hall-selector-price');
        const priceStandartInput = document.getElementById('price-standart');
        const priceVipInput = document.getElementById('price-vip');

        let originalPrices = {};
        let currentPrices = {};
        let origStandartPrice = 0;
        let origVipPrice = 0;

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

                originalPrices = JSON.parse(JSON.stringify(data.prices)); // глубокая копия
                currentPrices = JSON.parse(JSON.stringify(data.prices));

                origStandartPrice = data.prices.standart;
                origVipPrice = data.prices.vip;

                if (data.error) {
                    alert(data.error);
                    return;
                }

                // // Обновляем цены
                priceStandartInput.value = origStandartPrice;
                priceVipInput.value = origVipPrice;
            } catch (error) {
                console.error('Ошибка при получении данных о зале:', error);
            }
        }

        // Обработчик выбора зала
        hallSelector.addEventListener('change', function (event) {
            const selectedHallId = event.target.value;
            if (selectedHallId) {
                updateHallData(selectedHallId);
            }
        });

        // Инициализация первого зала
        const firstHallRadio = document.querySelector('#hall-selector-price input[type="radio"]');
        if (firstHallRadio) {
            firstHallRadio.checked = true;
            updateHallData(firstHallRadio.value);
        }

        // Слушатель на кнопку Сохранить
        document.getElementById('save-configuration-price').addEventListener('click', async (e) => {
            e.preventDefault();

            const hallId = document.querySelector('#hall-selector-price input[type="radio"]:checked')?.value;
            if (!hallId) return;

            try {
                const response = await fetch('/admin/update-hall-price', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        hall_id: hallId,
                        vip: parseInt(priceVipInput.value),
                        standart: parseInt(priceStandartInput.value),
                    })
                });

                const result = await response.json();
                alert(result.message || 'Изменения сохранены');
            } catch (err) {
                alert('Ошибка при сохранении');
                console.error(err);
            }
        });

    });
</script>