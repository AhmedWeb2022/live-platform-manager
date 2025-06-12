@extends('liveplatform::dashboard.layout.master')
@section('content')
  <div class="indicators">
    <div class="content">


      <div class="fillter">
        <div class="heading">
          <h4 class="text-title">Platforms</h4>
        </div>
        <div class="select">
          <a href="{{ route('admin.platform.create') }}">
            <i class="fa-solid fa-square-plus"></i></a>
        </div>
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
