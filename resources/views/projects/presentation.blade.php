@extends('layouts.master')

@section('content')
    <div class="container">
        <h1>Project presentation: <?php echo ucfirst(strtolower($title)); ?></h1>
        <p class="lead">Description...</p>
        <p>Content.</p>
    </div>
@stop
