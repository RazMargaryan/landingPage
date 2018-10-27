<?php



Route::auth();

Route::middleware(['web'])->group(function () {
    Route::get('/', 'IndexController@index')->name('home');
    Route::post('/', 'IndexController@create')->name('create');
    Route::get("/page/{alias}", "PageController@execute")->name('page');
});

//admin route
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', function () {
        if (view()->exists('admin.index')) {
            $data = ['title' => 'Admin panel'];
            return view('admin.index', $data);
        }
    });
    //admin/page
    Route::prefix('pages')->group(function () {
        Route::get("/", 'pages\AdminPagesController@index')->name('pages');

        //admin/page/add
        Route::get('/add', 'pages\AdminPagesAddController@show')->name('showPages');
        Route::post('/add', 'pages\AdminPagesAddController@store')->name('pagesAdd');
        //admin/page/add

        //admin/page/edit
        Route::get('/edit/{page}', 'pages\AdminPagesEditController@edit')->name('showPageEdit');
        Route::post('/edit/{page}', 'pages\AdminPagesEditController@update')->name('editPage');
        Route::delete('/edit/{page}', 'pages\AdminPagesEditController@destroy')->name('deletePage');
    });
    //admin/page  **** END

    //admin/portfolio
    Route::prefix('portfolio')->group(function () {
        //admin/portfolio
        Route::get('/', 'portfolio\PortfolioController@index')->name('portfolio');

        //admin/portfolio/add
        Route::get('/add', 'portfolio\PortfolioAddController@show')->name('portfolioAdd');
        Route::post('/add', 'portfolio\PortfolioAddController@store')->name('portfolioAdd');
        //admin/portfolio/add

        //admin/portfolio/edit
        Route::get('/edit/{portfolio}', "portfolio\PortfolioEditController@index")->name('portfolioEditShow');
        Route::post('/edit/{portfolio}', "portfolio\PortfolioEditController@update")->name('portfolioEdit');
        Route::delete('/edit/{portfolio}', "portfolio\PortfolioEditController@destroy")->name('portfolioDelete');
    });


    Route::prefix('services')->group(function () {
        //admin/services
        Route::get('/', 'services\ServicesController@index')->name('services');

        //admin/services/add
        Route::get('/add', 'services\ServicesAddController@index')->name('servicesAdd');
        Route::post('/add', 'services\ServicesAddController@create')->name('servicesAdd');
        //admin/services/add

        //admin/services/edit
        Route::get('/edit/{services}', "services\ServicesEditController@edit")->name('servicesEditShow');
        Route::put('/edit/{service}', "services\ServicesEditController@update")->name('servicesEdit');
        Route::delete('/edit/{service}', "services\ServicesEditController@destroy")->name('servicesDelete');
    });
});



