@extends('layout')

@section('main')

<div class="box form-box">
  <p class="back-link"><a href="/browse/feeds">&#x25C0; @lang('layout.go-back-link')</a></p>
  <h3 class="box-title">@lang('subscription.add-feed-title')</h3>
  <div class="box-content">
    <form action="/browse/feeds" method="post" class="add-feed">
      <div class="form-row">
        <label>@lang('subscription.form-label-title')</label>
        <input type="text" name="title">
      </div>
      <div class="form-row">
        <label>@lang('subscription.form-label-url')</label>
        <input type="url" name="url">
      </div>
      {{ csrf_field() }}
      <input type="hidden" name="action" value="add">
      <button type="submit">@lang('subscription.form-add-submit-btn')</button>
    </form>
  </div>
</div>

@endsection
