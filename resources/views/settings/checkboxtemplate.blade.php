<div class="settings__form-row">
    <label class="settings__label">@lang($label)</label>
    <input type="hidden" name="{{ $name }}" value="off">
    <input class="settings__checkbox" name="{{ $name }}" type="checkbox" {{ $value === "on" ? "checked" : "" }}>
    @if (!empty($description))
        <label class="settings__label--description">@lang($description)</label>
    @endif
</div>