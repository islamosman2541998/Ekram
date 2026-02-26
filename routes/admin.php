<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\Cms\AdsController;
use App\Http\Controllers\Admin\Cms\TagController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\Cms\NewsController;
use App\Http\Controllers\Admin\Cms\MediaController;
use App\Http\Controllers\Admin\Cms\MenueController;
use App\Http\Controllers\Admin\Cms\PagesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Cms\SliderController;
use App\Http\Controllers\Admin\Cms\StatusController;
use App\Http\Controllers\Admin\Cms\ThemesController;
use App\Http\Controllers\Admin\Badal\RitesController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\Badal\OffersController;
use App\Http\Controllers\Admin\Cms\CategoryController;
use App\Http\Controllers\Admin\Cms\ProjectsController;
use App\Http\Controllers\Admin\Cms\ServicesController;
use App\Http\Controllers\Admin\Cms\SettingsController;
use App\Http\Controllers\Admin\OrderDetailsController;
use App\Http\Controllers\Admin\UploadeImageTexteditor;
use App\Http\Controllers\Admin\Charity\OrderController;
use App\Http\Controllers\Admin\Charity\ReferController;
use App\Http\Controllers\Admin\Charity\StoreController;
use App\Http\Controllers\Admin\Cms\ContactUsController;
use App\Http\Controllers\Admin\Cms\PortfolioController;
use App\Http\Controllers\Admin\App\AppArticleController;
use App\Http\Controllers\Admin\App\AppSectionController;
use App\Http\Controllers\Admin\Charity\DonorsController;
use App\Http\Controllers\Admin\Cms\SubscribesController;
use App\Http\Controllers\Admin\Charity\ManagerController;
use App\Http\Controllers\Admin\Gifts\GiftCardsController;
use App\Http\Controllers\Admin\Products\VendorController;
use App\Http\Controllers\Admin\Badal\SubstituteController;
use App\Http\Controllers\Admin\Cms\PortfolioTagController;
use App\Http\Controllers\Admin\Deceases\DeceaseController;
use App\Http\Controllers\Admin\Products\ProductController;
use App\Http\Controllers\Admin\Charity\VoluntreeController;
use App\Http\Controllers\Admin\Cms\PaymentMethodController;
use App\Http\Controllers\Admin\Badal\BadalProjectController;
use App\Http\Controllers\Admin\Charity\CharityTagController;
use App\Http\Controllers\Admin\Gifts\GiftCategoryController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Admin\Cms\HomeSettingPageController;
use App\Http\Controllers\Admin\Cms\ArticlesContoller;
use App\Http\Controllers\Admin\Gifts\GiftOccasionsController;
use App\Http\Controllers\Admin\Products\AttributesController;
use App\Http\Controllers\Admin\Products\TagProductController;
use App\Http\Controllers\Admin\Authorizations\RolesController;
use App\Http\Controllers\Admin\Charity\ClientsCartsController;
use App\Http\Controllers\Admin\Charity\BeneficiariesController;
use App\Http\Controllers\Admin\Charity\DonorsReportsController;
use App\Http\Controllers\Admin\Charity\CharityProjectController;
use App\Http\Controllers\Admin\Charity\CharityReportsController;
use App\Http\Controllers\Admin\Charity\CharitySectionController;
use App\Http\Controllers\Admin\Charity\VolunteerIdeasController;
use App\Http\Controllers\Admin\Charity\VolunteerPagesController;
use App\Http\Controllers\Admin\Products\AttributesSetController;
use Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect;
use App\Http\Controllers\Admin\Charity\CharityCategoryController;
use App\Http\Controllers\Admin\Products\ProductCategoryControler;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use App\Http\Controllers\Admin\Deceases\DeceasedProjectController;
use App\Http\Controllers\Admin\Charity\CharitySingleProjectController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//   prefix Languages
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localeCookieRedirect'], // Route translate middleware
], function () {

    // Route::redirect('admin', '/admin/dashboard');

    Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {

        Route::get('/', function () {
            return redirect()->route('admin.home');
        });
        // AUTH PAGE ---------------------------------------------------------------------
        Route::group(['middleware' => 'RedirectDashboard'], function () {
            Route::controller(AuthController::class)->group(function () {
                Route::get('login', 'showLogin')->name('login');
                Route::POST('login', 'login')->name('login_post');
            });
        });

        // Dashboard Pages ---------------------------------------------------------------
        Route::group(['middleware' => 'CheckAdminAuth'], function () {

            Route::controller(AuthController::class)->group(function () {
                Route::post('logout', 'logout')->name('logout');
            });
            // 'middleware' => 'CheckPermissionRoute'
            Route::group([], function () {

                Route::controller(DashboardController::class)->group(function () {
                    Route::get('dashboard', 'home')->name('home');
                    Route::get('switch-dark-mode', 'switchMode')->name('switch-dark-mode');
                    Route::get('update-color-header', 'updateColorHeader')->name('update-color-header');
                    Route::get('update-color-side', 'updateColorSide')->name('update-color-side');
                });

                // ---------------------- Profile ---------------------------------//
                Route::get('profile', [ProfileController::class, 'index'])->name('profile');
                Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
                // ---------------------- End Profile -----------------------------//

                // ----- Admins ----------------------------------------------------
                Route::resource('users', AdminController::class);
                Route::post('users/actions', [AdminController::class, 'actions'])->name('users.actions');
                Route::get('users/update-status/{id}', [AdminController::class, 'update_status'])->name('users.update-status');

                //--------------- End Admins ------------------------------------//

                // ----- Authorization -----------------------------------------------
                Route::resource('roles', RolesController::class);
                // ----- End Authorization -------------------------------------------

                //--------------- Start Menus -----------------------------------------------------------------------//
                Route::resource('menus', MenueController::class);
                Route::get('show-menu-tree', [MenueController::class, 'show_tree'])->name('menus.show_tree');
                Route::post('menus/actions', [MenueController::class, 'actions'])->name('menus.actions');
                Route::get('menus/update-status/{id}', [MenueController::class, 'update_status'])->name('menus.update-status');
                Route::get('tree/get-urls', [MenueController::class, 'getUrl'])->name('menus.getUrl');
                Route::get('get-menus', [MenueController::class, 'getMenus'])->name('menus.getMenus');
                //--------------- End Menus -----------------------------------------------------------------------//

                // ----- Pages -----------------------------------------------
                Route::resource('pages', PagesController::class);
                Route::get('pages/update-status/{id}', [PagesController::class, 'update_status'])->name('pages.update-status');
                Route::post('pages/actions', [PagesController::class, 'actions'])->name('pages.actions');
                Route::delete('pages/delete-file/{page}/{index}', [PagesController::class, 'deleteFile'])->name('pages.delete-file');

                // ----- End Pages -------------------------------------------

                // ----- news -----------------------------------------------
                Route::resource('news', NewsController::class);
                Route::get('news/update-status/{id}', [NewsController::class, 'update_status'])->name('news.update-status');
                Route::post('news/actions', [NewsController::class, 'actions'])->name('news.actions');
                Route::get('news/update-featured/{id}', [NewsController::class, 'update_featured'])->name('news.update-featured');
                // ----- End news -------------------------------------------

                // ----- About -----------------------------------------------
                Route::get('about', [App\Http\Controllers\Admin\Cms\AboutController::class, 'index'])->name('about.index');
                Route::put('about', [App\Http\Controllers\Admin\Cms\AboutController::class, 'update'])->name('about.update');
                // ----- End About -------------------------------------------

                //----------------Start Sliders----------------------------//
                Route::resource('slider', SliderController::class);
                Route::get('slider/update-status/{id}', [SliderController::class, 'update_status'])->name('slider.update-status');
                Route::post('slider/actions', [SliderController::class, 'actions'])->name('slider.actions');
                //----------------End Sliders----------------------------//

                // ----- ContactUs -----------------------------------------------
                Route::resource('contact-us', ContactUsController::class);
                Route::post('contact-us/read', [ContactUsController::class, 'read'])->name('contact-us.read');
                Route::get('/notifications/markAll', [ContactUsController::class, 'markAll'])->name('notification.read');
                //--------------- End ContactUs ---------------------------------

                // ----- subscribes -----------------------------------------------
                Route::resource('subscribes', SubscribesController::class);
                //--------------- End subscribes ---------------------------------

                //order details---------------
                Route::get('/order-details', [OrderDetailsController::class, 'index'])->name('order_details.index');
                Route::get('order-details/export', [OrderDetailsController::class, 'export'])
                    ->name('order_details.export')
                    ->withoutMiddleware(LocaleCookieRedirect::class)
                    ->withoutMiddleware(LocaleSessionRedirect::class);

                // ----- Categories -----------------------------------------------
                Route::resource('categories', CategoryController::class);
                Route::get('show-categories-tree', [CategoryController::class, 'show_tree'])->name('categories.show_tree');
                Route::get('categories/update-status/{id}', [CategoryController::class, 'update_status'])->name('categories.update-status');
                Route::post('categories/actions', [CategoryController::class, 'actions'])->name('categories.actions');
                Route::get('categories/update-featured/{id}', [CategoryController::class, 'update_featured'])->name('categories.update-featured');
                //--------------- End Categories ---------------------------------

                // ----- articles -----------------------------------------------
                Route::resource('articles', ArticlesContoller::class);
                Route::get('show-articles-tree', [ArticlesContoller::class, 'show_tree'])->name('articles.show_tree');
                Route::get('articles/update-status/{id}', [ArticlesContoller::class, 'update_status'])->name('articles.update-status');
                Route::post('articles/actions', [ArticlesContoller::class, 'actions'])->name('articles.actions');
                Route::get('articles/update-featured/{id}', [ArticlesContoller::class, 'update_featured'])->name('articles.update-featured');
                //--------------- End articles ---------------------------------

                // ----- Blogs -----------------------------------------------
                Route::resource('blogs', BlogController::class);
                Route::get('blogs/update-status/{id}', [BlogController::class, 'update_status'])->name('blogs.update-status');
                Route::post('blogs/actions', [BlogController::class, 'actions'])->name('blogs.actions');
                Route::get('blogs/update-featured/{id}', [BlogController::class, 'update_featured'])->name('blogs.update-featured');
                // ----- End Blogs -------------------------------------------

                // ----------------------  Tags -----------------------------//
                // Route::resource('tag', TagController::class);
                // Route::get('tag/update-status/{id}', [TagController::class, 'update_status'])->name('tag.update-status');
                // Route::post('tag/actions', [TagController::class, 'actions'])->name('tag.actions');
                // Route::get('tag/update-featured/{id}', [TagController::class, 'update_featured'])->name('tag.update-featured');
                // // ----------------------End  Tags -----------------------------//

                // ----- portfolio-tags -----------------------------------------------
                // Route::resource('portfolio-tags', PortfolioTagController::class);
                // Route::get('portfolio-tags/update-status/{id}', [PortfolioTagController::class, 'update_status'])->name('portfolio-tags.update-status');
                // Route::post('portfolio-tags/actions', [PortfolioTagController::class, 'actions'])->name('portfolio-tags.actions');
                // Route::get('portfolio-tags/update-featured/{id}', [PortfolioTagController::class, 'update_featured'])->name('portfolio-tags.update-featured');
                // // ----- End portfolio -------------------------------------------

                // ----- portfolio -----------------------------------------------
                // Route::resource('portfolio', PortfolioController::class);
                // Route::get('portfolio/update-status/{id}', [PortfolioController::class, 'update_status'])->name('portfolio.update-status');
                // Route::post('portfolio/actions', [PortfolioController::class, 'actions'])->name('portfolio.actions');
                // Route::get('portfolio/update-featured/{id}', [PortfolioController::class, 'update_featured'])->name('portfolio.update-featured');
                // ----- End portfolio -------------------------------------------

                // ----- projects -----------------------------------------------
                // Route::resource('projects', ProjectsController::class);
                // Route::get('projects/update-status/{id}', [ProjectsController::class, 'update_status'])->name('projects.update-status');
                // Route::post('projects/actions', [ProjectsController::class, 'actions'])->name('projects.actions');
                // ----- End projects -------------------------------------------


                // ----- Visitors -----------------------------------------------
                Route::get('visitors', [App\Http\Controllers\Admin\VisitorsController::class, 'index'])->name('visitors');
                Route::get('visitors/export', [App\Http\Controllers\Admin\VisitorsController::class, 'export'])
                    ->name('visitors.export')
                    ->withoutMiddleware(LocaleCookieRedirect::class)
                    ->withoutMiddleware(LocaleSessionRedirect::class);
                // ----- End Visitors -------------------------------------------

                // ----- Clients -----------------------------------------------

                Route::get('clients', [App\Http\Controllers\Admin\ClientsController::class, 'index'])->name('clients');
                Route::get('clients/export', [ClientsController::class, 'export'])
                    ->name('clients.export')
                    ->withoutMiddleware(LocaleCookieRedirect::class)
                    ->withoutMiddleware(LocaleSessionRedirect::class);
                // ----- End Clients -------------------------------------------

                // ----- Services -----------------------------------------------
                // Route::resource('services', ServicesController::class);
                // Route::get('services/update-status/{id}', [ServicesController::class, 'update_status'])->name('services.update-status');
                // Route::post('services/actions', [ServicesController::class, 'actions'])->name('services.actions');
                // Route::get('services/update-featured/{id}', [ServicesController::class, 'update_featured'])->name('services.update-featured');
                // ----- End Services -------------------------------------------


                // ---------- settings --------------------------------------------
                Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
                    Route::get('/', [SettingsController::class, 'index'])->name('index');
                    Route::get('/{key}', [SettingsController::class, 'form'])->name('form');
                    Route::post('/{key}/update', [SettingsController::class, 'form_update'])->name('update');
                    Route::delete('/delete-image', [SettingsController::class, 'deleteImage'])->name('delete-image');

                    Route::post('settings-update/{id}', [SettingsController::class, 'form_update'])->name('update');
                    Route::post('settings-update-custom/{slug}', [SettingsController::class, 'form_update_custom'])->name('update-custom');
                    Route::post('settings-volunteer/{slug}', [SettingsController::class, 'volunteerUpdate'])->name('volunteer');
                });

                // ----- End settings -------------------------------------------

                // ----- Themes -----------------------------------------------
                Route::get('themes/dashboard', [ThemesController::class, 'dashboardTheme'])->name('themes.dashboard');
                Route::post('themes/dashboard', [ThemesController::class, 'Themes_update'])->name('themes.update');
                Route::post('themes/reset', [ThemesController::class, 'Themes_reset'])->name('themes.reset');
                Route::get('themes/site', [ThemesController::class, 'siteTheme'])->name('themes.site');
                // ----- End Themes -------------------------------------------

                // ----- SettingHome -----------------------------------------------
                Route::resource('home-settings', HomeSettingPageController::class);
                Route::get('home-settings/update-status/{id}', [HomeSettingPageController::class, 'update_status'])->name('home-settings.update-status');
                //--------------- End Setting Home ---------------------------------

                // ----------------- Start Route Payment Method ------------------------------------//
                Route::resource('payment-method', PaymentMethodController::class);
                Route::get('payment-method/update-status/{id}', [PaymentMethodController::class, 'update_status'])->name('payment.update-status');
                Route::post('payment-method/actions', [PaymentMethodController::class, 'actions'])->name('payment.actions');
                // ----------------- End Route Payment Method ------------------------------------//

                // ----------------------  Charity  ------------------------------------------------------------------------------------------------//
                Route::group(['as' => 'charity.', 'prefix' => 'chairty'], function () {
                    //--------------------------- Start  Chairty sections-----------------------------------------------------------------------------------
                    Route::resource('sections', CharitySectionController::class);
                    //--------------------------- End Tag ------------------------------------------------------------------------------------=
                    //--------------------------- Start  Chairty sections-----------------------------------------------------------------------------------
                    Route::resource('categories', CharityCategoryController::class);
                    //--------------------------- End Tag ------------------------------------------------------------------------------------=
                    // ---------------------- Start Tags --------------------------------------------------------------------------------------//
                    // Route::resource('tag', CharityTagController::class);
                    // Route::get('tag/update-status/{id}', [CharityTagController::class, 'update_status'])->name('tag.update-status');
                    // Route::post('tag/actions', [CharityTagController::class, 'actions'])->name('tag.actions');
                    // Route::get('tag/update-featured/{id}', [CharityTagController::class, 'update_featured'])->name('tag.update-featured');
                    // ----------------------End Tags -----------------------------//
                    //--------------------------- Start  Project--------------------------------------------------------------------------------
                    Route::resource('projects', CharityProjectController::class);
                    Route::get('project/reviews/{id}', [CharityProjectController::class, 'reviews'])->name('project.reviews');
                    Route::post('project/reviews/actions', [CharityProjectController::class, 'actions'])->name('reviews.actions');
                    Route::get('project/reviews/update-status/{id}', [CharityProjectController::class, 'update_status'])->name('reviews.update-status');
                    Route::post('project/reviews/delete', [CharityProjectController::class, 'deleteReview'])->name('reviews.deleteReview');
                    //--------------------------- End  Project -----------------------------------------------------------------------------------
                    //--------------------------- Start Single page Project--------------------------------------------------------------------------------
                    Route::resource('single-projects', CharitySingleProjectController::class);
                    Route::get('single-projects/reviews/{id}', [CharityProjectController::class, 'reviews'])->name('single-projects.reviews');
                    Route::post('single-projects/reviews/actions', [CharityProjectController::class, 'actions'])->name('single-projects.reviews.actions');
                    Route::get('single-projects/reviews/update-status/{id}', [CharityProjectController::class, 'update_status'])->name('single-projects.reviews.update-status');
                    Route::post('single-projects/reviews/delete', [CharityProjectController::class, 'deleteReview'])->name('single-projects.reviews.deleteReview');
                    //--------------------------- End Single page Project -----------------------------------------------------------------------------------

                    //-------------------------------StartManager--------------------------------------------
                    Route::resource('managers', ManagerController::class);
                    Route::get('managers/update-status/{id}', [ManagerController::class, 'update_status'])->name('managers.update-status');
                    Route::post('managers/actions', [ManagerController::class, 'actions'])->name('managers.actions');
                    //-------------------------------EndManager--------------------------------------------

                    //-------------------------------StartManager--------------------------------------------
                    Route::get('refers/orders/{id}', [ReferController::class, 'orders'])->name('refers.orders');
                    Route::get('refers/update-status/{id}', [ReferController::class, 'update_status'])->name('refers.update-status');
                    Route::post('refers/actions', [ReferController::class, 'actions'])->name('refers.actions');
                    Route::get('refers/supervisor', [ReferController::class, 'managers'])->name('refers.supervisor');
                    Route::resource('refers', ReferController::class);

                    //-------------------------------EndManager--------------------------------------------

                });
                // ----------------------  End Charity  ------------------------------------------------------------------------------------------------//

                // ----------------------   deceases  ------------------------------------------------------------------------------------------------//
                Route::group(['as' => 'deceases.', 'prefix' => 'deceases'], function () {
                    Route::resource('request', DeceaseController::class);
                    Route::post('request/actions', [DeceaseController::class, 'actions'])->name('request.actions');
                    Route::get('request/update-status/{id}', [DeceaseController::class, 'update_status'])->name('request.update-status');
                    Route::resource('projects', DeceasedProjectController::class);
                });
                // ----------------------  End Charity  ------------------------------------------------------------------------------------------------//

                // ----------------------   deceases  ------------------------------------------------------------------------------------------------//
                Route::group(['as' => 'gifts.', 'prefix' => 'gifts'], function () {
                    // categories
                    Route::resource('categories', GiftCategoryController::class);
                    Route::post('categories/actions', [GiftCategoryController::class, 'actions'])->name('categories.actions');
                    Route::get('categories/update-status/{id}', [GiftCategoryController::class, 'update_status'])->name('categories.update-status');
                    Route::get('show-menu-tree', [GiftCategoryController::class, 'show_tree'])->name('categories.show_tree');
                    // occasions
                    Route::resource('occasions', GiftOccasionsController::class);
                    Route::post('occasions/actions', [GiftOccasionsController::class, 'actions'])->name('occasions.actions');
                    Route::get('occasions/update-status/{id}', [GiftOccasionsController::class, 'update_status'])->name('occasions.update-status');
                    // cards
                    Route::resource('cards', GiftCardsController::class);
                    Route::post('cards/actions', [GiftCardsController::class, 'actions'])->name('cards.actions');
                    Route::get('cards/update-status/{id}', [GiftCardsController::class, 'update_status'])->name('cards.update-status');
                });
                // ----------------------  End Charity  ------------------------------------------------------------------------------------------------//

                //--------------------------- Start Badal Project--------------------------------------------------------------------------------
                // Route::group(['as' => 'badal.', 'prefix' => 'badal'], function () {
                //     Route::resource('projects', BadalProjectController::class);
                //     Route::get('projects/reviews/{id}', [BadalProjectController::class, 'reviews'])->name('projects.reviews');
                //     Route::post('projects/reviews/actions', [BadalProjectController::class, 'actions'])->name('projects.reviews.actions');
                //     Route::get('projects/reviews/update-status/{id}', [BadalProjectController::class, 'update_status'])->name('projects.reviews.update-status');
                //     Route::post('projects/reviews/delete', [BadalProjectController::class, 'deleteReview'])->name('projects.reviews.deleteReview');

                //     //-------------------------------Start Rites --------------------------------------------
                //     Route::resource('rites', RitesController::class);
                //     Route::get('rites/update-status/{id}', [RitesController::class, 'update_status'])->name('rites.update-status');
                //     Route::post('rites/actions', [RitesController::class, 'actions'])->name('rites.actions');
                //     //-------------------------------End Rites --------------------------------------------

                //     //-------------------------------Start Rites --------------------------------------------
                //     Route::resource('substitutes', SubstituteController::class);
                //     Route::get('substitutes/update-status/{id}', [SubstituteController::class, 'update_status'])->name('substitutes.update-status');
                //     Route::post('substitutes/actions', [SubstituteController::class, 'actions'])->name('substitutes.actions');
                //     //-------------------------------End Rites --------------------------------------------

                //     Route::get('offers', [OffersController::class, 'index'])->name('offers.index');
                //     Route::post('offers/actions', [OffersController::class, 'actions'])->name('suboffersstitutes.actions');
                // });
                //--------------------------- End Badal Project -----------------------------------------------------------------------------------

                //--------------------------- Application Project--------------------------------------------------------------------------------
                // Route::group(['as' => 'app.', 'prefix' => 'app'], function () {
                //     //------------------------------- Start Section --------------------------------------------
                //     Route::resource('sections', AppSectionController::class);
                //     Route::get('sections/update-status/{id}', [AppSectionController::class, 'update_status'])->name('sections.update-status');
                //     Route::post('sections/actions', [AppSectionController::class, 'actions'])->name('sections.actions');
                //     Route::get('sections/update-featured/{id}', [AppSectionController::class, 'update_featured'])->name('sections.update-featured');
                //     //------------------------------- End Section --------------------------------------------

                //     //------------------------------- Start Articles ------------------------------------------
                //     Route::resource('articles', AppArticleController::class);
                //     Route::get('articles/update-status/{id}', [AppArticleController::class, 'update_status'])->name('articles.update-status');
                //     Route::post('articles/actions', [AppArticleController::class, 'actions'])->name('articles.actions');
                //     Route::get('articles/update-featured/{id}', [AppArticleController::class, 'update_featured'])->name('articles.update-featured');
                //     //------------------------------- End Articles --------------------------------------------
                // });
                //--------------------------- Application Project -----------------------------------------------------------------------------------


                // ----- ads ---------------------------------------------------------------------------------------------------------------------------
                Route::post('ads/create', [AdsController::class, 'create'])->name('ads.create');
                Route::post('ads/store', [AdsController::class, 'store'])->name('ads.store');
                Route::get('ads/edit', [AdsController::class, 'edit'])->name('ads.edit');
                Route::get('ads/show', [AdsController::class, 'show'])->name('ads.show');
                Route::POST('ads/update', [AdsController::class, 'update'])->name('ads.update');
                //--------------- End ads ---------------------------------------------------------------------------------------------------------------

                // ----------------------Start Route Tags -------------------------------------------------------------------------------------------//
                Route::resource('status', StatusController::class);
                Route::get('status/update-status/{id}', [StatusController::class, 'update_status'])->name('status.update-status');
                Route::post('status/actions', [StatusController::class, 'actions'])->name('status.actions');
                // ----------------------End Route Tags ---------------------------------------------------------------------------------------------//

                // ----------------------Start beneficiaries -------------------------------------------------------------------------------------------//

                Route::resource('beneficiaries', BeneficiariesController::class);
                Route::get('beneficiaries/update-status/{id}', [BeneficiariesController::class, 'update_status'])->name('beneficiaries.update-status');
                Route::post('beneficiaries/actions', [BeneficiariesController::class, 'actions'])->name('beneficiaries.actions');

                // ----------------------End beneficiaries ---------------------------------------------------------------------------------------------//


                // ----- volunteers -----------------------------------------------
                Route::resource('volunteers', VoluntreeController::class);
                Route::get('volunteers/update-status/{id}', [VoluntreeController::class, 'update_status'])->name('volunteers.update-status');
                Route::post('volunteers/actions', [VoluntreeController::class, 'actions'])->name('volunteers.actions');
                Route::get('volunteers/update-featured/{id}', [VoluntreeController::class, 'update_featured'])->name('volunteers.update-featured');



                Route::resource('volunteers-ideas', VolunteerIdeasController::class);
                Route::get('volunteers-ideas/update-status/{id}', [VolunteerIdeasController::class, 'update_status'])->name('volunteers-ideas.update-status');
                Route::post('volunteers-ideas/actions', [VolunteerIdeasController::class, 'actions'])->name('volunteers-ideas.actions');
                Route::delete('volunteers-ideas/comment-delete/{id}', [VolunteerIdeasController::class, 'deleteComment'])->name('volunteers-ideas-comment.destroy');

                //--------------- End volunteers ---------------------------------

                // ----- volunteerpages -----------------------------------------------
                Route::resource('volunteerpages', VolunteerPagesController::class);
                Route::get('volunteerpages/update-status/{id}', [VolunteerPagesController::class, 'update_status'])->name('volunteerpages.update-status');
                Route::post('volunteerpages/actions', [VolunteerPagesController::class, 'actions'])->name('volunteerpages.actions');
                //--------------- End volunteerpages ---------------------------------

                // -------------------------Doners------------------------------------------
                Route::resource('donors', DonorsController::class);
                Route::post('donors/actions', [DonorsController::class, 'actions'])->name('donors.actions');
                Route::get('donors/update-status/{id}', [DonorsController::class, 'update_status'])->name('donors.update-status');

                // -------------------------clients_carts------------------------------------------
                Route::resource('clients-carts', ClientsCartsController::class);
                Route::post('clients-carts/actions', [ClientsCartsController::class, 'actions'])->name('clients_carts.actions');
                Route::get('clients-carts/update-status/{id}', [ClientsCartsController::class, 'update_status'])->name('clients_carts.update-status');

                // -------------------------Store------------------------------------------
                Route::resource('store', StoreController::class);
                Route::post('store/actions', [StoreController::class, 'actions'])->name('store.actions');
                Route::get('store/update-status/{id}', [StoreController::class, 'update_status'])->name('store.update-status');


                // ----------------------  Eccommerce  ------------------------------------------------------------------------------------------------//
                // Route::group(['as' => 'eccommerce.', 'prefix' => 'eccommerce'], function () {
                //     // --------------------- Start Categories ------------------------------------
                //     Route::resource('/categories', ProductCategoryControler::class);
                //     // ----- --------------- End Categories ---------------------------------------
                //     // ------------------------------------ Start Tags ------------------------------------------------
                //     Route::resource('/tags', TagProductController::class);
                //     Route::get('/tags/update-status/{id}', [TagProductController::class, 'update_status'])->name('tags.update-status');
                //     Route::post('/tags/actions', [TagProductController::class, 'actions'])->name('tags.actions');
                //     Route::get('/tags/update-featured/{id}', [TagProductController::class, 'update_featured'])->name('tags.update-featured');
                //     // ------------------------------------ End Tags ------------------------------------------------
                //     // -------------------------------------Start Products --------------------------------------------------------------------------------
                //     Route::resource('products', ProductController::class);
                //     Route::get('/update-status/{id}', [ProductController::class, 'update_status'])->name('update-status');
                //     Route::post('/actions', [ProductController::class, 'actions'])->name('actions');
                //     Route::get('/update-featured/{id}', [ProductController::class, 'update_featured'])->name('update-featured');
                //     Route::get('/attribuetss/{id}', [ProductController::class, 'getAttribute'])->name('getAttribute');
                //     Route::post('/newvariance', [ProductController::class, 'newvariance'])->name('addNewvariance');
                //     Route::get('/reviews/{id}', [ProductController::class, 'reviews'])->name('reviews');
                //     Route::get('/reviews/update-status/{id}', [ProductController::class, 'update_status'])->name('reviews.update-status');
                //     Route::post('/reviews/actions', [ProductController::class, 'actions'])->name('reviews.actions');
                //     Route::post('/reviews/delete', [ProductController::class, 'deleteReview'])->name('reviews.deleteReview');
                //     // -------------------------------------End Products ------------------------------------------------------------------------------------
                //     // -------------------------Vendor------------------------------------------
                //     Route::resource('vendors', VendorController::class);
                //     Route::post('vendors/actions', [VendorController::class, 'actions'])->name('vendors.actions');
                //     Route::get('vendors/update-status/{id}', [VendorController::class, 'update_status'])->name('vendors.update-status');
                //     Route::get('vendors/update-featured/{id}', [VendorController::class, 'update_featured'])->name('vendors.update-featured');
                //     // ------------------------- End Vendor ------------------------------------------
                //     // ---------------------AttributesSetController ------------------------------------
                //     Route::resource('attributes-set', AttributesSetController::class);
                //     Route::post('attributes-set/actions', [AttributesSetController::class, 'actions'])->name('attributes-set.actions');
                //     Route::get('attributes-set/update-status/{id}', [AttributesSetController::class, 'update_status'])->name('attributes-set.update-status');
                //     Route::get('attributes-se/update-featured/{id}', [AttributesSetController::class, 'update_featured'])->name('attributes-set.update-featured');
                //     // --------------------- End AttributesSetController ------------------------------------
                //     // ---------------------AttributesController ------------------------------------
                //     Route::get('attributes/index/{id}', [AttributesController::class, 'index'])->name('attributes.index');
                //     Route::get('attributes/{id}', [AttributesController::class, 'add'])->name('attributes.add');
                //     Route::post('attributes/store', [AttributesController::class, 'store'])->name('attributes.store');
                //     Route::get('attributes/edit/{id}', [AttributesController::class, 'edit'])->name('attributes.edit');
                //     Route::post('attributes/updated', [AttributesController::class, 'update'])->name('attributes.update');
                //     Route::post('attributes/actions', [AttributesController::class, 'actions'])->name('attributes.actions');
                //     Route::get('attributes/update-status/{id}', [AttributesController::class, 'update_status'])->name('attributes.update-status');
                //     Route::delete('attributes/delete/{id}', [AttributesController::class, 'destroy'])->name('attributes.destroy');
                // });
                // ----------------------  End Eccommerce  ------------------------------------------------------------------------------------------------//

                // ----------------------  Start Orders  ------------------------------------------------------------------------------------------------//
                Route::group(['as' => 'orders.', 'prefix' => 'orders'], function () {
                    Route::get('/', [OrderController::class, 'index'])->name('index');
                    Route::get('/show', [OrderController::class, 'show'])->name('show');
                    Route::get('/invoices/{id}', [OrderController::class, 'invoices'])->name('invoices');
                });
                // ----------------------  End Orders  ------------------------------------------------------------------------------------------------//


                // ----------------------   Reports  ------------------------------------------------------------------------------------------------//
                Route::group(['as' => 'reports.', 'prefix' => 'reports'], function () {
                    Route::get('products', [ReportsController::class, 'orderProducts'])->name('order-products');
                    // -------------------------Doners Reports------------------------------------------
                    Route::get('donors', [DonorsReportsController::class, 'index'])->name('donors.index');
                    // -------------------------charity Reports------------------------------------------
                    Route::resource('charity-repots', CharityReportsController::class);
                });
                // ----------------------  End Reports  ------------------------------------------------------------------------------------------------//

                // ----------------------  End Reports  ------------------------------------------------------------------------------------------------//
                Route::group(['as' => 'reports.', 'prefix' => 'reports'], function () {
                    Route::get('products', [ReportsController::class, 'orderProducts'])->name('order-products');
                });
                // ----------------------  End Reports  ------------------------------------------------------------------------------------------------//



                //---------------------------Upload Image TextEditor ----------------------------------------------
                Route::post('upload', [UploadeImageTexteditor::class, 'upload'])->name('ckeditor.upload');
                //--------------------------- End Upload Image TextEditor ----------------------------------------------
                // ----- Media------------------------------------------------------
                Route::resource('media', MediaController::class);
                //--------------- End Media -----------------------------------------

            });
        });
    });
});

// require __DIR__.'/auth.php';
