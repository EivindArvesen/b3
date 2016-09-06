@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1>{{ucfirst(strtolower($project['project_title']))}}<br /><small>{{$project['category']}}</small></h1>
        <p><small>{{$project['date']}}</small></p>
        <p class="lead">{{$project['description']}}</p>
        <h3><small>{{$project['list_title']}}</small></h3>
        <ul>
          @foreach (explode(',', $project['list_content']) as $item)
            <li>{{trim($item)}}</li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <?=$project['body'];?>
      </div>
    </div>
  </div>
@stop
