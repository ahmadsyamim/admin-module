<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::prefix('admin')->group(function() {
//     Route::get('/', 'AdminController@index');
// });

Route::group(['prefix' => \Config::get('admin.route_prefix')], function () {
    if (env('APP_ADMIN', true)) {
        Voyager::routes();
    }
});

if (env('APP_SITE', false) || (Schema::hasTable('settings') && setting('site.enable'))) {
    $accountController = '\App\Http\Controllers\VoyagerFrontend\AccountController';
    $searchController = '\Pvtl\VoyagerFrontend\Http\Controllers\SearchController';
    
    /**
     * Authentication
     */
    Route::group(['middleware' => ['web']], function () use ($accountController) {
        Route::group(['namespace' => 'App\Http\Controllers'], function () {
            Auth::routes();
        });
    
        Route::group(['middleware' => 'auth', 'as' => 'voyager-frontend.account'], function () use ($accountController) {
            Route::get('/account', "$accountController@index");
            Route::post('/account', "$accountController@updateAccount")->name('.update');
    
            /**
             * User impersonation
             */
            Route::get('/admin/users/impersonate/{userId}', "$accountController@impersonateUser")
                ->name('.impersonate.admin')
                ->middleware(['web', 'admin.user']);
    
            Route::post('/admin/users/impersonate/{originalId}', "$accountController@impersonateUser")
                ->name('.impersonate')
                ->middleware(['web']);
        });
    });
    
    Route::group([
        'as' => 'voyager-frontend.pages.',
        'prefix' => 'admin/pages/',
        'middleware' => ['web', 'admin.user'],
        'namespace' => '\Pvtl\VoyagerFrontend\Http\Controllers'
    ], function () {
        Route::post('layout/{id?}', ['uses' => 'PageController@changeLayout', 'as' => 'layout']);
    });
    
    /**
     * Let's get some search going
     */
    Route::get('/search', "$searchController@index")
        ->middleware(['web'])
        ->name('voyager-frontend.search');

} else if (env('APP_ADMIN', true) && (Schema::hasTable('pages'))) {

    // Which Page Controller shall we use to display the page? Page Blocks or standard page?
    $pageController = '\Pvtl\VoyagerPages\Http\Controllers\PageController';

    if (class_exists('\Pvtl\VoyagerFrontend\Http\Controllers\PageController')) {
        $pageController = '\Pvtl\VoyagerFrontend\Http\Controllers\PageController';
    }

    if (class_exists('\Pvtl\VoyagerPageBlocks\Providers\PageBlocksServiceProvider')) {
        $pageController = '\Pvtl\VoyagerPageBlocks\Http\Controllers\PageController';
    }

    // Get all page slugs (note it's cached for 5mins)
    $pages = Cache::remember('page/slugs', 5, function () {
        return Page::all('slug');
    });
    
    $slug = Request::path() === '/' ? 'home' : Request::path();

    // When the current URI is known to be a page slug, let it be a route
    if ($pages->contains('slug', $slug)) {
        Route::get('/{slug?}', function () {
            return redirect('admin');
        })        
            ->middleware('web')
            ->where('slug', '.+');
    }
}


