@extends('layouts.master')

@section('content')
  <div class="container">

    <!--
    <div class="row">
      <div class="col-sm-12">
        <h1>List of Projects</h1>
        <p class="lead">Description...</p>
      </div>
    </div>
    -->

    @foreach ($results as $element)
      <div class="row">
        <div class="col-xl-12">
          <h1>{{ $element['name'] }}</h1>
        </div>
      </div>

      <div class="row project-row">
        <? $in_row = 0; ?>
        @foreach ($element['projects'] as $project)
          <div class="col-xs-12 col-sm-6 col-md-3 project-element"> <!-- .media-body -->
            <h2 class="media-heading"><a href="/projects/{{$project['slug']}}">{{$project['project_title']}}</a></h2>
            <p class="project-date">{{$project['date']}}</p>
            <strong>{{$project['list_group']}}</strong>
            <p class="lead">{{$project['description']}}</p>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-3">
            @if (isset($project['feature']) && $project['feature'] !== '' && $project['feature'] !== '0')
              <img class="media-object" src="{{$project->feature}}">
            @endif
          </div>
          <?php $in_row++; ?>
          @if (count($in_row) === 1)
              <div class="clearfix visible-sm-block"></div>
          @elseif (count($in_row) > 1)
            </div>
            <div class="row project-row">
          @endif
        @endforeach
      </div>
    @endforeach

    </div>
  </div>
@stop
