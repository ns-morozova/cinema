<section class="conf-step">
    <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Открыть продажи</h2>
    </header>
    <div class="conf-step__wrapper text-center">
        <p class="conf-step__paragraph">Всё готово, теперь можно:</p>

        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">Выберите зал для открытия продаж:</p>
            <ul class="conf-step__selectors-box" id="hall-selector-sales">
                @foreach ($halls as $hall)
                    <li>
                        <input type="radio" class="conf-step__radio hall-selector-sales" name="sales-hall" value="{{ $hall['id'] }}"
                            data-id="{{ $hall['id'] }}">
                        <span class="conf-step__selector">{{ $hall['name'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <button class="conf-step__button conf-step__button-accent">Открыть продажу билетов</button>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Инициализация первого зала
        const hallSelectorSales = document.getElementById('hall-selector-sales');
        const firstHallRadioSales = hallSelectorSales.querySelector('.hall-selector-sales');
        if (firstHallRadioSales) {
            firstHallRadioSales.checked = true;
        }
    });
</script>