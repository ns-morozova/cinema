<x-layouts.client>
    <section class="ticket">
        <header class="tichet__check">
            <h2 class="ticket__check-title">Электронный билет</h2>
        </header>

        <div class="ticket__info-wrapper">
            <p class="ticket__info">На фильм: <span class="ticket__details ticket__title">{{ $data['movie_title'] }}</span></p>
            <p class="ticket__info">
                Места:
                <span class="ticket__details ticket__chairs">
                    @foreach ($data['seats'] as $seat)
                        {{ $seat['row'] }}-{{ $seat['seat'] }} ({{ $seat['type'] }}): {{ $seat['price'] }} рублей,
                    @endforeach
                </span>
            </p>
            <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">{{ $data['hall_name'] }}</span></p>
            <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start">{{ $data['start_time'] }}</span></p>

            <!-- Отображение QR-кодов -->
            <div class="ticket__qr-codes">
                @foreach ($data['seats'] as $seat)
                    <div class="ticket__qr-code">
                        <p class="ticket__qr-label">Место: {{ $seat['row'] }}-{{ $seat['seat'] }}</p>
                        <img class="ticket__info-qr" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode("Билет на фильм {$data['movie_title']} | Место: {$seat['row']}-{$seat['seat']} | Начало: {$data['start_time']}") }}">
                    </div>
                @endforeach
            </div>

            <p class="ticket__hint">Покажите QR-код нашему контроллеру для подтверждения бронирования.</p>
            <p class="ticket__hint">Приятного просмотра!</p>
        </div>
    </section>
</x-layouts.client>