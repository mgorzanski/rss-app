<div class="form__form-row">
    <label class="form__label">@lang($label)</label>
    <input type="hidden" name="{{ $name }}" value="off">
    <input class="form__checkbox" name="{{ $name }}" type="checkbox" {{ $value === "on" ? "checked" : "" }}>
    @if (!empty($description))
        <label class="form__label--description">@lang($description)</label>
    @endif
</div>