@extends('liveplatform::dashboard.layout.master')
@section('content')
  <div class="add-projects">
    <div class="content">
      <div class="head">
        <h4>{{ $title }}</h4>
        @include('liveplatform::dashboard.live_account.__form')
      </div>
    </div>
  </div>
@endsection
