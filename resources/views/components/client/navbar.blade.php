<div>
    @php
use Carbon\Carbon;
$startDate = Carbon::today();
$dates = [];
for ($i = 0; $i < 14; $i++) {
    $dates[] = $startDate->copy()->addDays($i);
}
$weekdays = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'];
    @endphp
    <ul class="conf-step__selectors-box selector-date selector-date-client" id="date-selector-client">
        @foreach ($dates as $index => $date)
            <li class="date-option cursor-pointer {{ $index >= 7 ? 'hidden' : '' }}">
                <input type="radio" class="conf-step__radio radio-date" name="session-date-client"
                    value="{{ $date->toDateString() }}" id="date-{{ $index }}" {{ $index === 0 ? 'checked' : '' }}>
                <span class="conf-step__selector leading-7" style="color: {{ in_array($date->dayOfWeek, [0, 6]) ? '#DE2121' : '#888' }};"">
                    {{ $date->format('d.m') }}
                    <br>
                    <small style="font-size: 0.8em; color: {{ in_array($date->dayOfWeek, [0, 6]) ? '#DE2121' : '#888' }};">
                        {{ $weekdays[$date->dayOfWeek] }}
                    </small>
                </span>
            </li>
        @endforeach
        <li class="button-arrow">
            <button type="button" class="conf-step__button-arrow" id="toggle-dates-client">→</button>
        </li>
    </ul>
</div>


{{-- <nav class="page-nav" id="pageNav">
    <a class="page-nav__day page-nav__day_today js-nav-day" href="#">
        <span class="page-nav__day-week">Пн</span>
        <span class="page-nav__day-number">31</span>
    </a>
    <a class="page-nav__day js-nav-day" href="#">
        <span class="page-nav__day-week">Вт</span><span class="page-nav__day-number">1</span>
    </a>
    <a class="page-nav__day page-nav__day_chosen js-nav-day" href="#">
        <span class="page-nav__day-week">Ср</span><span class="page-nav__day-number">2</span>
    </a>
    <a class="page-nav__day js-nav-day" href="#">
        <span class="page-nav__day-week">Чт</span><span class="page-nav__day-number">3</span>
    </a>
    <a class="page-nav__day js-nav-day" href="#">
        <span class="page-nav__day-week">Пт</span><span class="page-nav__day-number">4</span>
    </a>
    <a class="page-nav__day page-nav__day_weekend js-nav-day" href="#">
        <span class="page-nav__day-week">Сб</span><span class="page-nav__day-number">5</span>
    </a>
    <a class="page-nav__day page-nav__day_next" href="#">
    </a>
</nav> --}}


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtnClient = document.getElementById('toggle-dates-client');
        let showingFirstGroupClient = true;

        // Переключение между группами дат
        toggleBtnClient.addEventListener('click', function () {
            const dateOptionsClient = document.querySelectorAll('#date-selector-client .date-option input');
            dateOptionsClient.forEach((input, idx) => {
                const parent = input.closest('.date-option');
                if (showingFirstGroupClient) {
                    parent.classList.toggle('hidden', idx < 7);
                } else {
                    parent.classList.toggle('hidden', idx >= 7);
                }
            });
            dateOptionsClient.forEach(input => input.checked = false);
            if (showingFirstGroupClient) {
                dateOptionsClient[7].checked = true;
                toggleBtnClient.textContent = '←';
            } else {
                dateOptionsClient[0].checked = true;
                toggleBtnClient.textContent = '→';
            }
            showingFirstGroupClient = !showingFirstGroupClient;
        });   
    });
</script>