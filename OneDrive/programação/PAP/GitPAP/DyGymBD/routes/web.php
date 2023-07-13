<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => 'cors'], function () use ($router) {
    //All the routes you want to allow CORS for

    $router->options('/{any:.*}', function (Request $req) {
        return;
    });

    // API route group
    $router->group(['prefix' => 'DyGym'], function () use ($router) {
        // Matches "/api/register
        $router->post('register', 'AuthController@register');

        $router->put('objetiv', 'AuthController@objetiv');
        
        $router->get('getObjetiv', 'AuthController@getObjetiv');
        // Matches "/api/update
        $router->post('update', 'AuthController@update');
        // Matches "/api/infos
        $router->put('infos', 'AuthController@infos');
        //Matches "/api/setInfor"
        $router->get('show/{id}', 'UserController@show');

        // Matches "/api/registerPt
        $router->post('registerPt', 'AuthPtController@registerPt');

        // Matches "/api/login
        $router->post('login', 'AuthController@login');

        // Matches "/api/information
        $router->post('sendInfo/{id}', 'UserController@sendInfo');

        // Matches "/api/information
        $router->get('name', 'AuthController@name');

        // Matches "/api/profile
        $router->get('profile', 'UserController@profile');

        // Matches "/api/users/1 
        //get one user by id
        $router->get('users/{id}', 'UserController@singleUser');

        $router->get('GetAuthUser', 'UserController@GetAuthUser');

        // Matches "/api/users
        $router->get('users', 'UserController@allUsers');

        //------------------ADMIN------------//
        $router->post('registerAdmin', 'AdminController@registerAdmin');

        //------------------PT----------------//
        $router->post('loginPt', 'PtController@loginPt');

        // Matches "/api/register
        $router->post('registerPt', 'PtController@registerPt');


        //------------------EXERCISE----------------//
        $router->post('CreateExercise', 'ExerciseController@CreateExercise');

        $router->put('updateExercicio/{id}', 'ExerciseController@updateExercicio');

        //--------------------PLAN---------------------//
        $router->post('CreatePlan', 'planController@CreatePlan');

        $router->get('getExercisesForLoggedInUser', 'planController@getExercisesForLoggedInUser');

        //----------------------Calendar-------------//
        $router->get('getEvents', 'CalendarController@getEvents');

        $router->get('getDescriptions', 'CalendarController@getDescriptions');
        
        //-------------------------Avaliacion------------------//
        $router->get('getAvalicion', 'avaliacionController@getAvalicion');

    });
});