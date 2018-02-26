<div class="form__form-row">
    <label class="form__label">@lang($label)</label>
    <input class="form__text" name="{{ $name }}" type="text" value="{{ $value }}">
    @if (!empty($description))
        <label class="form__label--description">@lang($description)</label>
    @endif
</div>