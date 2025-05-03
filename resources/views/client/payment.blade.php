<x-layouts.client>
    <section class="ticket">
        <header class="tichet__check">
            <h2 class="ticket__check-title">Вы выбрали билеты:</h2>
        </header>
        <div class="ticket__info-wrapper">
            <p class="ticket__info">На фильм: <span
                    class="ticket__details ticket__title">{{ $data['movie_title'] }}</span></p>
            <p class="ticket__info">
                Места:
                <span class="ticket__details ticket__chairs">
                    @foreach ($data['seats'] as $seat)
                        {{ $seat['row'] }}-{{ $seat['seat'] }} ({{ $seat['type'] }}): {{ $seat['price'] }} рублей,
                    @endforeach
                </span>
            </p>
            <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">{{ $data['hall_name'] }}</span>
            </p>
            <p class="ticket__info">Начало сеанса: <span
                    class="ticket__details ticket__start">{{ $data['start_time'] }}</span></p>
            <p class="ticket__info">Стоимость: <span
                    class="ticket__details ticket__cost">{{ $data['total_cost'] }}</span> рублей</p>

            <button class="acceptin-button" onclick="location.href='ticket.html'">Получить код бронирования</button>

            <p class="ticket__hint">
                После оплаты билет будет доступен в этом окне, а также придёт вам на почту.
                Покажите QR-код нашему контроллёру у входа в зал.
            </p>
            <p class="ticket__hint">Приятного просмотра!</p>
        </div>
    </section>
</x-layouts.client>