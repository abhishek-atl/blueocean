<div class="owl-corousel-container-time mt-3">
    <div class="owl-corousel-time owl-carousel owl-theme">
        @foreach ($timeSlots as $time)
        <input type="button" @if ($loop->first) id="first_time" @endif data-time="{{ $time }}"
        class="calendar_time" value="{{ $time }}">
        @endforeach
    </div>
    <div class="owl-theme">
        <div class="owl-controls">
            <div class="custom-nav owl-nav"></div>
        </div>
    </div>
</div>