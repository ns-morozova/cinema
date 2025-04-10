<section class="conf-step">
    <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Управление залами</h2>
    </header>
    <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Доступные залы:</p>
        <ul class="conf-step__list">
            @foreach ($halls as $hall)
                <li>{{$hall['name']}}
                    <button class="conf-step__button conf-step__button-trash"></button>
                </li>
            @endforeach
        </ul>
        <button class="conf-step__button conf-step__button-accent">Создать зал</button>
    </div>
</section>