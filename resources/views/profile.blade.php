@extends('layout')

@section('main')

<div class="box profile-box">
	<p class="back-link"><a href="/">&#x25C0; @lang('layout.go-back-link')</a></p>
	<h3 class="box-title">@lang('profile.title')</h3>

	<div class="box-content">
        <form class="form" action="/user/profile" method="post">
            @include('forms.textfieldtemplate', ['label' => 'profile.label-name', 'name' => 'name', 'value' => $columns->name])
            @include('forms.emailfieldtemplate', ['label' => 'profile.label-email', 'name' => 'email', 'value' => $columns->email])
            @include('forms.passwordfieldtemplate', ['label' => 'profile.label-password', 'name' => 'password', 'value' => ''])
            @include('forms.passwordfieldtemplate', ['label' => 'profile.label-password-repeat', 'name' => 'password-repeat', 'value' => ''])
            {{ csrf_field() }}
            <div class="form__form-row">
                <input name="_method" type="hidden" value="PUT">
                <button type="submit" class="form__submit">@lang('profile.form-submit-btn')</button>
            </div>
        </form>
	</div>
</div>

@endsection