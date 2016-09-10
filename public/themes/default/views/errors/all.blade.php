@extends('layouts.master')

@section('content')
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1>{{$page_title}}</h1>
          <p class="lead">{{$notice}}</p>
        </div>
      </div>
    </div>
@stop
