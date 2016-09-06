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
    --><br />

    @foreach ($results as $element)
      <div class="row">
        <div class="col-xl-12">
          <h1>{{ $element['name'] }}</h1>
        </div>
      </div>

      <div class="row">
        <? $in_row = 0; ?>
        @foreach ($element['projects'] as $project)
          <div class="col-xs-12 col-sm-6 col-md-3">
            <a href="#">
              <img class="media-object" data-src="holder.js/256x256" alt="256x256" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGRlZnMvPjxyZWN0IHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjEzLjkyMTg3NSIgeT0iMzIiIHN0eWxlPSJmaWxsOiNBQUFBQUE7Zm9udC13ZWlnaHQ6Ym9sZDtmb250LWZhbWlseTpBcmlhbCwgSGVsdmV0aWNhLCBPcGVuIFNhbnMsIHNhbnMtc2VyaWYsIG1vbm9zcGFjZTtmb250LXNpemU6MTBwdDtkb21pbmFudC1iYXNlbGluZTpjZW50cmFsIj42NHg2NDwvdGV4dD48L2c+PC9zdmc+" data-holder-rendered="true">
            </a>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-3 project-element"> <!-- .media-body -->
            <h2 class="media-heading"><a href="/projects/{{$project['slug']}}">{{$project['project_title']}}</a></h2>
            <p><small>{{$project['date']}}</small></p>
            <p class="lead">{{$project['description']}}</p>
            <h3><small>{{$project['list_title']}}</small></h3>
            <ul>
              @foreach (explode(',', $project['list_content']) as $item)
                <li>{{trim($item)}}</li>
              @endforeach
            </ul>
          </div>
          <?php $in_row++; ?>
          @if (count($in_row) === 1)
              <div class="clearfix visible-sm-block"></div>
          @elseif (count($in_row) > 1)
            </div>
            <div class="row">
          @endif
        @endforeach
      </div>
      <br/><br />
    @endforeach

    </div>
  </div>
@stop
