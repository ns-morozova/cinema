<x-layouts.client>
    <section class="buying">
        <div class="buying__info">
            <div class="buying__info-description">
                <h2 class="buying__info-title">Выбранный зал: {{ $hall->name }}</h2>
                <p class="buying__info-start">Дата: {{ $date }}</p>
                <p class="buying__info-hall">Время: {{ $time }}</p>
            </div>
        </div>

        <div class="buying-scheme">
            <div class="buying-scheme__wrapper">
                @foreach ($seats->groupBy('row') as $rowNumber => $rowSeats)
                    <div class="buying-scheme__row">
                        @foreach ($rowSeats as $seat)
                            @php
                                $key = "{$seat->row}-{$seat->seat}";
                                $isBooked = isset($tickets[$key]) && $tickets[$key]->status === 'booked';
                              $type = $seat->type->value;
                            @endphp

                            <span class="buying-scheme__chair
                                @if ($type === 'standart')
                                    buying-scheme__chair_standart
                                @elseif ($type === 'vip')
                                    buying-scheme__chair_vip
                                @else
                                    buying-scheme__chair_disabled
                                @endif
                                @if ($isBooked)
                                    buying-scheme__chair_taken
                                @endif"
                                data-row="{{ $seat->row }}"
                                data-seat="{{ $seat->seat }}"
                            ></span>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <button class="acceptin-button" onclick="location.href='payment.html'">Забронировать</button>
    </section>

    <script>
        document.querySelectorAll('.buying-scheme__chair').forEach(chair => {
            chair.addEventListener('click', () => {
                if (!chair.classList.contains('buying-scheme__chair_taken') &&
                    !chair.classList.contains('buying-scheme__chair_disabled')) {
                    chair.classList.toggle('buying-scheme__chair_selected');
                }
            });
        });        
    </script>


</x-layouts.client>