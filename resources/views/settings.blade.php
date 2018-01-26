@extends('layout')

@section('main')

<div class="box settings-box">
	<p class="back-link"><a href="/">&#x25C0; @lang('layout.go-back-link')</a></p>
	<h3 class="box-title">@lang('settings.title')</h3>

	<div class="box-content">
		<form class="settings" action="" method="post">
            <div class="settings__form-row">
                <label class="settings__label">@lang('settings.label-select-lang')</label>
                <select class="settings__select" name="languages">
                    <option>english</option>
                    <option>polski</option>
                </select>
            </div>

            <div class="settings__form-row">
                <label class="settings__label">@lang('settings.label-always-open-source-of-article')</label>
                <label class="settings__label--description">@lang('settings.label-always-open-source-of-article-description')</label>
                <input class="settings__checkbox" name="always_open_source_of_article" type="checkbox">
            </div>
            {{ csrf_field() }}
            <button type="submit" class="settings__submit">@lang('settings.form-submit-btn')</button>
        </form>
	</div>
</div>

@endsection