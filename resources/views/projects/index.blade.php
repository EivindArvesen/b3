@extends('layouts.master')

@section('content')
  <div class="container">
      <h1>List of Projects</h1>
      <p class="lead">Description...</p>
    <div class="row">
      <div class="col-sm-12 media">
        <div class="media-left">
          <a href="#">
            <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGRlZnMvPjxyZWN0IHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjEzLjkyMTg3NSIgeT0iMzIiIHN0eWxlPSJmaWxsOiNBQUFBQUE7Zm9udC13ZWlnaHQ6Ym9sZDtmb250LWZhbWlseTpBcmlhbCwgSGVsdmV0aWNhLCBPcGVuIFNhbnMsIHNhbnMtc2VyaWYsIG1vbm9zcGFjZTtmb250LXNpemU6MTBwdDtkb21pbmFudC1iYXNlbGluZTpjZW50cmFsIj42NHg2NDwvdGV4dD48L2c+PC9zdmc+" data-holder-rendered="true" style="width: 64px; height: 64px;">
          </a>
        </div>
        <div class="media-body">
          <h2 class="media-heading"><a href="<?php echo '/projects/title'; ?>">Heading</a><span class="label label-default">New</span></h2>
          <p>Description of the project goes here.</p>
          <h3><small>Built with</small></h3>
          <ul>
            <li>Technology</li>
          </ul>
        </div>
      </div><!-- /.col -->
    </div>
  </div>
@stop
