<div class="email-source field">
    <div class="control">
        <div class="select is-large">
            <select name="news_source">
                @foreach ($sources as $key => $value)
                    <option value="{{ $key }}"
                            @if ($key === $selected)selected="selected"@endif
                    >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
