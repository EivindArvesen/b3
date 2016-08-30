@extends(config('bbb_config.theme') . '.layouts.master')

@section('content')
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1>{{$page->page_title}}</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <?=$page->body;?>
        </div>
      </div>
    </div>
@stop
