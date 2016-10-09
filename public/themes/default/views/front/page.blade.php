@extends('layouts.master')

@section('content')
    <div class="container light-bg">
      <div class="row">
        <div class="col-sm-12">
          <h1>{{$page->page_title}}</h1>
        </div>
      </div>
      @if (isset($page['feature']) && $page['feature'] !== '' && $page['cover'] !== '0')
        <div class="row">
          <div class="col-sm-12">
            <img src="{{$page['feature']}}">
          </div>
        </div>
      @endif
      <div class="row">
        <div class="col-sm-12">
          <?=$page->body;?>
        </div>
      </div>
    </div>
@stop
