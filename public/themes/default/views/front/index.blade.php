@include('layouts.top')

@include('layouts.nav')

<div class="container jumbotron">
    <div class="row">
        <div class="col-sm-9">
            <h1><?=config('b3_config.header');?></h1>
            <p class="lead"><?=config('b3_config.lead');?></p>
            @foreach (config('b3_config.text') as $text)
                <p class="text"><?=$text;?></p>
            @endforeach

            <!--
            <br />
            <a class="btn btn-primary btn-ghost btn-lg" href="#">Learn more</a>
            -->

            <?=$page->body;?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 index-list">
            <h2>Latest blog posts</h2>
            @foreach ($last_blogposts as $post)
                <a href="{{$post->url}}">{{$post->title}}</a>
                <a href="/blog/{{substr($post->created_at, 0, 4)}}/{{substr($post->created_at, 5, 2)}}/{{substr($post->created_at, 8, 2)}}/{{$post->slug}}">{{$post->post_title}}</a>
            @endforeach
        </div>
        <div class="col-md-5 index-list">
            <h2>Latest projects</h2>
            @foreach ($last_projects as $project)
                <a href="{{$post->url}}">{{$post->title}}</a>
                <a href="/projects/{{$project->slug}}">{{$project->project_title}}</a>
            @endforeach
        </div>
    </div>

</div>

@include('layouts.bottom')
