@extends('layouts.master')

{{-- @section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@stop --}}

@section('content')
   <?php echo $page->body; ?>
@stop
