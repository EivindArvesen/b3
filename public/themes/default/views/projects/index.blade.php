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

    <?php $in_row = 0; ?>
    @foreach ($results as $element)
      <div class="row">
        <div class="col-xl-12">
          <h1>{{ $element['name'] }}</h1>
        </div>
      </div>

      <div class="row project-row">
        @foreach ($element['projects'] as $project)
          <div class="col-xs-12 col-sm-6 col-md-3 project-element"> <!-- .media-body -->
            <h2 class="media-heading"><a href="/projects/{{$project['slug']}}">{{$project['project_title']}}</a></h2>
            <strong>{{$project['list_group']}}</strong>
            <p class="project-date">{{format_time($project['date'])}}</p>
            <p>{{$project['description']}}</p>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-3 project-element">
            @if (isset($project['feature']) && $project['feature'] !== '' && $project['feature'] !== '0')
              <img class="media-object" src="{{$project->feature}}">
            @endif
          </div>
          <?php $in_row++; ?>
          @if ($in_row === 1)
              <div class="clearfix visible-sm-block"></div>
          @elseif ($in_row > 1)
            </div>
            <div class="row project-row">
            <?php $in_row = 0; ?>
          @endif
        @endforeach
      </div>
    @endforeach

    </div>
  </div>
@stop
