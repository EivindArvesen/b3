@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1>Debug!</h1>
            <p class="lead">Here's some files of interest.</p>
            <?php
                foreach ($file_list as $file) {
                    echo '<a href="'.$debug_folder.$file.'">'.$file.'</a><br />';
                }
            ?>
          </div>
        </div>
    </div>

@stop
