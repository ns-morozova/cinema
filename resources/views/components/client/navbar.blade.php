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
    <ul class="conf-step__selectors-box selector-date-client" id="date-selector-client">
        @foreach ($dates as $index => $date)
            <li class="date-option cursor-pointer {{ $index >= 7 ? 'hidden' : '' }}">
                <input type="radio" class="conf-step__radio radio-date" name="session-date-client"
                    value="{{ $date->toDateString() }}" id="date-{{ $index }}" {{ $index === 0 ? 'checked' : '' }}>
                <span class="conf-step__selector leading-7 z-50"
                    style="color: {{ in_array($date->dayOfWeek, [0, 6]) ? '#DE2121' : '#888' }};">
                    {{ $date->format('d.m') }}
                    <br>
                    <small style="font-size: 0.8em; color: {{ in_array($date->dayOfWeek, [0, 6]) ? '#DE2121' : '#888' }};">
                        {{ $weekdays[$date->dayOfWeek] }}
                    </small>
                </span>
            </li>
        @endforeach
        <li class="button-arrow" id="toggle-dates-client">
            →
        </li>
    </ul>
</div>

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