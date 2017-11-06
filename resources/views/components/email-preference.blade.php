<div class="email-preference">
    <input name="schedule"
           type="radio"
           id="schedule--{{ $value }}"
           value="{{ $value }}"
           @if ($value === $selected)checked="checked"@endif
    />

    <label for="schedule--{{ $value }}">
        <strong>{{ $title }}</strong><br />
        {{ $description }}
    </label>
</div>
