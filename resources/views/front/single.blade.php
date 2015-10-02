@extends('layouts.master')

@section('content')
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1>Flat single page: <?php echo $page_title; ?></h1>
          <p class="lead">Description...</p>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <p><?php echo $content; ?></p>
        </div>
      </div>
    </div>
@stop
