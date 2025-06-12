@extends('liveplatform::dashboard.layout.master')
@section('content')
  <div class="indicators">
    <div class="content">


      <div class="fillter">
        <div class="heading">
          <h2 class="text-title">Sessions</h2>
        </div>
        {{-- <div class="select">
          <a href="{{ route('admin.platform.create') }}">
            <i class="fa-solid fa-square-plus"></i></a>
        </div> --}}
      </div>


      <div class="table-responsive">
        {!! $dataTable->table(
            [
                'class' => 'table',
            ],
            true,
        ) !!}
      </div>

    </div>
  </div>
  </div>
@endsection

@section('script')
  {{ $dataTable->scripts() }}
@endsection
