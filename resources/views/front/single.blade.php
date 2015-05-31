@extends('layouts.master')

@section('content')
    <div class="container">
        <h1>Flat single page: <?php echo $page_title; ?></h1>
        <p class="lead">Description...</p>
        <p><?php echo $content; ?></p>
    </div>
@stop
