@extends('layout')

@section('main')

<div class="box settings-box">
	<p class="back-link"><a href="/">&#x25C0; @lang('layout.go-back-link')</a></p>
	<h3 class="box-title">@lang('settings.title')</h3>

	<div class="box-content">
		<form class="form" action="/settings" method="post">
            <div class="form__form-row">
                <label class="form__label">@lang('settings.label-select-lang')</label>
                <select class="form__select" name="lang">
                    @if ($lang === 'en')
                    <option value="en" selected>english</option>
                    @else
                    <option value="en">english</option>
                    @endif
                    @if ($lang === 'pl')
                    <option value="pl" selected>polski</option>
                    @else
                    <option value="pl">polski</option>
                    @endif
                </select>
            </div>

            @foreach ($settings as $setting)
                    @include($setting->view, $setting->data)
            @endforeach

            {{ csrf_field() }}
            <div class="form__form-row">
                <button type="submit" class="form__submit">@lang('settings.form-submit-btn')</button>
            </div>
        </form>
	</div>
</div>

@endsection