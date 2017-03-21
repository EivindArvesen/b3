@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-8">
        <h1>{{ucfirst(strtolower($project['project_title']))}}<br /><small>{{$project['category']}}</small></h1>
        <strong>{{$project['list_group']}}</strong>
        <p class="project-date">{{format_time($project['date'])}}</p>
        <p class="lead">{{$project['description']}}</p>

        <h3><small>{{$project['list_title']}}</small></h3>
        <ul class="meta-list">
          @foreach (explode(',', $project['list_content']) as $item)
            <li>{{trim($item)}}</li>
          @endforeach
        </ul>
      </div>
      <div class="col-xs-12 col-sm-4">
        @if (isset($project['feature']) && $project['feature'] !== '' && $project['feature'] !== '0')
          <img class="media-object" src="{{projectHero($project->feature)}}">
        @endif
      </div>
    </div>
    <div class="row project-body">
      <div class="col-sm-12">
        <?=$project['body'];?>
      </div>
    </div>
  </div>
@stop
