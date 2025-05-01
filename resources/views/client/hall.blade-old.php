<x-layouts.client>
    <section class="buying">
        <div class="buying__info">
            <div class="buying__info-description">
                <h2 class="buying__info-title">Выбранный зал: {{ $hall->name }}</h2>
                <p class="buying__info-start">Дата: {{ $date }}</p>
                <p class="buying__info-hall">Время: {{ $time }}</p>
            </div>
            <div class="buying__info-hint">
                <p>Тапните дважды,<br>чтобы увеличить</p>
            </div>
        </div>
        <div class="buying-scheme">
            <div class="buying-scheme__wrapper">
                <div class="buying-scheme__row">
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                </div>
    
                <div class="buying-scheme__row">
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_taken"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                </div>
    
                <div class="buying-scheme__row">
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                </div>
    
                <div class="buying-scheme__row">
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_vip"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_vip"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                </div>
    
                <div class="buying-scheme__row">
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_vip"></span><span
                        class="buying-scheme__chair buying-scheme__chair_vip"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_vip"></span><span
                        class="buying-scheme__chair buying-scheme__chair_vip"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                </div>
    
                <div class="buying-scheme__row">
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_vip"></span><span
                        class="buying-scheme__chair buying-scheme__chair_taken"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_taken"></span><span
                        class="buying-scheme__chair buying-scheme__chair_taken"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                </div>
    
                <div class="buying-scheme__row">
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_vip"></span><span
                        class="buying-scheme__chair buying-scheme__chair_taken"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_taken"></span><span
                        class="buying-scheme__chair buying-scheme__chair_vip"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                </div>
    
                <div class="buying-scheme__row">
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_selected"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_selected"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_disabled"></span><span
                        class="buying-scheme__chair buying-scheme__chair_disabled"></span>
                </div>
    
                <div class="buying-scheme__row">
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_taken"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_taken"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_taken"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                </div>
    
                <div class="buying-scheme__row">
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_taken"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_taken"></span><span
                        class="buying-scheme__chair buying-scheme__chair_taken"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                    <span class="buying-scheme__chair buying-scheme__chair_standart"></span><span
                        class="buying-scheme__chair buying-scheme__chair_standart"></span>
                </div>
            </div>
            <div class="buying-scheme__legend">
                <div class="col">
                    <p class="buying-scheme__legend-price"><span
                            class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span
                            class="buying-scheme__legend-value">250</span>руб)</p>
                    <p class="buying-scheme__legend-price"><span
                            class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span
                            class="buying-scheme__legend-value">350</span>руб)</p>
                </div>
                <div class="col">
                    <p class="buying-scheme__legend-price"><span
                            class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
                    <p class="buying-scheme__legend-price"><span
                            class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>
                </div>
            </div>
        </div>
        <button class="acceptin-button" onclick="location.href='payment.html'">Забронировать</button>
    </section>
</x-layouts.client>