<section class="conf-step">
    <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Открыть продажи</h2>
    </header>
    <div class="conf-step__wrapper text-center">
        {{-- <p class="conf-step__paragraph">Всё готово, теперь можно:</p> --}}

        <div>
            <p class="conf-step__paragraph">Выберите зал для действия:</p>
            <ul class="conf-step__selectors-box mt-10" id="hall-selector-sales">
                @foreach ($halls as $hall)
                    <li>
                        <input type="radio" class="conf-step__radio hall-selector-sales" name="sales-hall" value="{{ $hall['id'] }}"
                            data-id="{{ $hall['id'] }}" data-enabled="{{ $hall['enabled'] }}">
                        <span class="conf-step__selector">{{ $hall['name'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <button id="button-opening" class="conf-step__button conf-step__button-accent">Открыть продажу билетов</button>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Инициализация первого зала
        const hallSelectorSales = document.getElementById('hall-selector-sales');
        const buttonOpening = document.getElementById('button-opening');

        // Функция для обновления текста кнопки
        function updateButtonText(enabled) {
            buttonOpening.textContent = enabled ? 'Приостановить продажу билетов' : 'Открыть продажу билетов';
        }


        // Инициализация первого зала
        const firstHallRadioSales = hallSelectorSales.querySelector('.hall-selector-sales');
        if (firstHallRadioSales) {
            firstHallRadioSales.checked = true;
            const isEnabled = firstHallRadioSales.getAttribute('data-enabled') === '1';
            updateButtonText(isEnabled);
        }

        // Обработчик изменения выбора зала
        hallSelectorSales.addEventListener('change', function (event) {
            const selectedRadio = event.target.closest('.hall-selector-sales');
            if (selectedRadio) {
                const isEnabled = selectedRadio.getAttribute('data-enabled') === '1';
                updateButtonText(isEnabled);
            }
        });

        // Открытие/приостановка продаж через AJAX
        buttonOpening.addEventListener('click', async function () {
            const selectedRadio = hallSelectorSales.querySelector('.hall-selector-sales:checked');
            if (!selectedRadio) {
                alert('Выберите зал для изменения статуса.');
                return;
            }

            const hallId = selectedRadio.getAttribute('data-id');
            const isEnabled = selectedRadio.getAttribute('data-enabled') === '1';
            const newEnabledState = !isEnabled;

            try {
                const response = await fetch(`/admin/halls/${hallId}/toggle-enabled`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ enabled: newEnabledState }),
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                if (result.success) {
                    // Обновляем состояние радиокнопки и текст кнопки
                    selectedRadio.setAttribute('data-enabled', newEnabledState ? '1' : '0');
                    updateButtonText(newEnabledState);
                    alert(result.message || 'Статус зала успешно изменен.');
                } else {
                    alert(result.message || 'Произошла ошибка при изменении статуса зала.');
                }
            } catch (error) {
                console.error('Ошибка при отправке данных:', error);
                alert('Возникла ошибка. Попробуйте снова.');
            }
        });
    });
</script>