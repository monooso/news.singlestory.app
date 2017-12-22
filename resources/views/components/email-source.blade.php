<div class="email-source field">
    <div class="control">
        <div class="select is-medium">
            <select name="source">
                @foreach ($sources as $key => $value)
                    <option value="{{ $key }}"
                            @if ($key === $selected)selected="selected"@endif
                    >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
