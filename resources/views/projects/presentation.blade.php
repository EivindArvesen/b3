@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1>Project presentation: <?php echo ucfirst(strtolower($title)); ?></h1>
        <p class="lead">Description...</p>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <p>Content.</p>
      </div>
    </div>
  </div>
@stop
