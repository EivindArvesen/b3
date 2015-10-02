<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// $app->get('/', function() use ($app) {
//     return $app->welcome();
// });


// /* ROUTE */
// $app->get('user/{id}', function($id) {
//     return 'User '. $id;
// });
// $app->get('blog/{date}/{id}', 'App\Http\Controllers\BlogController@showEntry');

$app->group(['namespace' => 'App\Http\Controllers'], function($group){

    $group->get('/', 'FrontController@index');

    $group->get('blog', 'BlogController@showFront');
    $group->get('blog/language/{language}', 'BlogController@listLanguage');
    $group->get('blog/category/{category}', 'BlogController@listCategory');
    $group->get('blog/tag/{tag}', 'BlogController@listTag');
    $group->get('blog/search', 'BlogController@search');
    $group->get('blog/{year}/', 'BlogController@showArchive1');
    $group->get('blog/{year}/{month}', 'BlogController@showArchive2');
    $group->get('blog/{year}/{month}/{day}', 'BlogController@showArchive3');
    $group->get('blog/{year}/{month}/{day}/{title}', 'BlogController@showEntry');

    $group->get('projects', 'ProjectsController@showList');
    $group->get('projects/{title}', 'ProjectsController@description');

    $group->get('contact', 'FrontController@contact');

});

if (config('bbb_config.site_name')==True)
{
    $app->group(['namespace' => 'App\Http\Controllers'], function($group){
        $group->get('debug', 'FrontController@debug');
        $group->get('debug/theme', 'FrontController@debugtheme');
    });
}


// /* NAMED ROUTES */
// // Named routes allow you to conveniently generate URLs or redirects for a specific route. You may specify a name for a route with the as array key:
// $app->get('user/profile', ['as' => 'profile', function() {
//     //
// }]);
// // You may also specify route names for controller actions:
// $app->get('user/profile', [
//     'as' => 'profile', 'uses' => 'UserController@showProfile'
// ]);
// // Now, you may use the route's name when generating URLs or redirects:
// //$url = route('profile');
// //$redirect = redirect()->route('profile');


// /* MOCK ROUTES */
// $app->get('/', function() {
//     return view('front.index', $data);
// });

// $app->get('/blog', function() {
//     return view('blog.index', $data);
// });

// $app->get('/projects', function() {
//     return view('projects.index', $data);
// });
