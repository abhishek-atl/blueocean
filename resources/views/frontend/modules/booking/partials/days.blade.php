<div class="owl-corousel-container-date mt-3">
    <div class="owl-corousel-date owl-carousel owl-theme">
        @foreach ($days as $day)
        <div class="item">
            <div class="calendar_date_day">{{ $day['day'] }}</div>
            <input type="button" @if ($loop->first) id="first_date" @endif
            data-date="{{ $day['full'] }}" class="calendar_date" value="{{ $day['number'] }}">
            @if ($loop->first || $day['number'] == '01')
            <div class="calendar_date_month">{{ $day['month'] }}</div>
            @endif
        </div>
        @endforeach
    </div>
    <div class="owl-theme">
        <div class="owl-controls">
            <div class="custom-nav owl-nav"></div>
        </div>
    </div>
</div>