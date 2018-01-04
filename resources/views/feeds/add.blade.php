@extends('layout')

@section('main')

<div class="box form-box">
  <p class="back-link"><a href="/browse/feeds">&#x25C0; Go back</a></p>
  <h3 class="box-title">Add feed</h3>
  <div class="box-content">
    <form action="/browse/feeds" method="post" class="add-feed">
      <div class="form-row">
        <label>Title:</label>
        <input type="text" name="title">
      </div>
      <div class="form-row">
        <label>Url:</label>
        <input type="url" name="url">
      </div>
      {{ csrf_field() }}
      <input type="hidden" name="action" value="add">
      <button type="submit">Add</button>
    </form>
  </div>
</div>

@endsection
