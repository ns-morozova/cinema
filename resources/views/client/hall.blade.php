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
                                $isBooked = isset($tickets[$seat->id]);
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
                                                                data-seat-id="{{ $seat->id }}"
                                data-row="{{ $seat->row }}" data-seat="{{ $seat->seat }}"></span>

                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="buying-scheme__legend">
                <div class="col">
                    <p class="buying-scheme__legend-price"><span
                            class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span
                            class="buying-scheme__legend-value">{{$standart_price}}</span>руб)</p>
                    <p class="buying-scheme__legend-price"><span
                            class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span
                            class="buying-scheme__legend-value">{{$vip_price}}</span>руб)</p>
                </div>
                <div class="col">
                    <p class="buying-scheme__legend-price"><span
                            class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
                    <p class="buying-scheme__legend-price"><span
                            class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>
                </div>
            </div>
        </div>

        <button class="acceptin-button">Забронировать</button>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectedSeats = []; // Массив для хранения ID выбранных мест

            // Обработка клика по месту
            document.querySelectorAll('.buying-scheme__chair').forEach(chair => {
                chair.addEventListener('click', () => {
                    if (!chair.classList.contains('buying-scheme__chair_taken') &&
                        !chair.classList.contains('buying-scheme__chair_disabled')) {
                        chair.classList.toggle('buying-scheme__chair_selected');

                        const seatId = parseInt(chair.dataset.seatId); // Получаем ID кресла. Преобразуем в число

                        if (selectedSeats.includes(seatId)) {
                            selectedSeats.splice(selectedSeats.indexOf(seatId), 1); // Удалить, если уже выбрано
                        } else {
                            selectedSeats.push(seatId); // Добавить в массив
                        }
                    }
                });
            });

            // Обработка нажатия на кнопку "Забронировать"
            document.querySelector('.acceptin-button').addEventListener('click', async (e) => {
                e.preventDefault();

                if (selectedSeats.length === 0) {
                    alert('Выберите хотя бы одно место.');
                    return;
                }

                const date = document.querySelector('.buying__info-start').innerText.split(': ')[1];
                const time = document.querySelector('.buying__info-hall').innerText.split(': ')[1];
                const hallId = {{ $hall->id }}; // ID зала из PHP

                try {
                    const response = await fetch('/reserve-tickets', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            date,
                            time,
                            hall_id: hallId,
                            seats: selectedSeats, // Передаем массив ID выбранных мест
                        })
                    });

                    const result = await response.json();
                    if (result.success) {
                        window.location.href = '/payment'; // Перенаправление на страницу оплаты
                    } else {
                        alert(result.message || 'Ошибка при бронировании.');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Произошла ошибка при бронировании.');
                }
            });
        });        
    </script>


</x-layouts.client>