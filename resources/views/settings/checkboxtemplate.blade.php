<div class="settings__form-row">
    <label class="settings__label">@lang($label)</label>
    <input class="settings__checkbox" name="{{ $name }}" type="checkbox">
    @if (!empty($description))
        <label class="settings__label--description">@lang($description)</label>
    @endif
</div>