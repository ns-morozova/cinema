<section class="conf-step">
    <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация цен</h2>
    </header>
    <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box">
            @foreach ($halls as $hall)
                <li>
                    <input type="radio" class="conf-step__radio" name="prices-hall" value="Зал 1">
                    <span class="conf-step__selector">{{$hall['name']}}</span>
                </li>
            @endforeach
        </ul>
        <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
        <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" placeholder="0"></label>
            за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
        </div>
        <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" placeholder="0" value="350"></label>
            за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
        </div>
        <fieldset class="conf-step__buttons text-center">
            <button class="conf-step__button conf-step__button-regular">Отмена</button>
            <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
        </fieldset>
    </div>
</section>