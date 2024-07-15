<?php

use App\Http\Controllers\Auth\ApiLoginController;
use App\Http\Controllers\CartController;
use App\Http\Livewire\Login;
use App\Http\Livewire\Register;
use App\Http\Livewire\ShowPosts;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => '', 'namespace' => "Livewire"], function () {
    // Route::get('/login', "Login");
    // Route::get('/register', "Register");
});

Route::group(['prefix' => '', 'namespace' => "Livewire"], function () {
    // Route::get('/', "Home");
    Route::get('/contact', "Contact")->name('contact_us');
    // Route::get('/cart', "Cart");
    // Route::get('/checkout', "Checkout");
    // Route::get('/login', "Login")->name('website_login');
    // Route::get('/register', "Register")->name('website_register');

    Route::group(['middleware' => ['frontend_auth_check']], function () {
        Route::get('/profile', "Profile")->name('frontend.profile');
        Route::get('/orders', "Orders")->name('frontend.orders');
        Route::get('/my-reviews', "MyReviews")->name('frontend.reviews');
        Route::get('/address', "Address")->name('frontend.address');
        Route::get('/account-details', "AccountDetails")->name('frontend.account_details');
        Route::get('/reset-password', "ResetPassword")->name('frontend.reset_password');
        Route::get('/invoice/{id}', "Invoice")->name('frontend.invoice');
    });
    Route::get('/order-complete/{id}', "OrderComplete")->name('order_complete');
    // Route::get('/product/{id}/{product_name}', ProductDetails::class)->name('product_details');
    // Route::get('/category/{id}/{category_name}', CategoryProduct::class)->name('category_product');
    // Route::get('/product/search/{search}', SearchProduct::class)->name('search_product');
    Route::any('/search-product/{search}', SearchProduct::class)->name('search_product');
    Route::get('/offer/prodcuts', OfferProduct::class)->name('offer_products');
    // Route::get('/product/quick_view/{id}', OfferProducts::class)->name('quick_view_product');
    // Route::get('/category-product/{id}', CategoryProduct::class)->name('category_product');
    // Route::get('/login', "Login");
    // Route::get('/register', "Register");
    // Route::get('/about-us', "AboutUs")->name('about_us');
    // Route::get('/privacy-policy', "PrivacyPolicy")->name('privacy_policy');
    // Route::get('/terms', "Terms")->name('terms_and_condition');
    // Route::get('/refund-policy', "RefundPolicy")->name('refund_policy');
});

Route::group(['prefix' => '', 'namespace' => "Controllers"], function () {
    Route::get('/', 'WebsiteController@website');
    Route::get('/invoice/{invoice}', 'WebsiteController@invoice_download')->name('invoice');
    Route::get('/tt', function () {
        // $p = \App\Models\Product::class;
        // $cats = DB::table('category_product')->get();
        // foreach ($cats as $cat) {
        //     $check = $p::where('id',$cat->product_id)->first();
        //     if(!$check){
        //         DB::table('category_product')->where('id',$cat->id)->delete();
        //         // dd($cat);
        //     }
        // }
        // $pr = $p::whereJsonContains('selected_categories', 89)->get();
        // dd($pr);
        // phpinfo();

        // $response = Http::withHeaders(
        //     [
        //         "Api-Key" => "at8f3p06nfiqizwdcisimpjjxoncwljo",
        //         "Secret-Key" => "txgfd00ut5pikkbi4lgpnta5",
        //     ]
        // )->post("https://portal.steadfast.com.bd/api/v1/create_order", [
        //     "invoice" => "2063452339",
        //     "recipient_name" => "shefat",
        //     "recipient_phone" => "01646376015",
        //     "recipient_address" => "mirpur dhaka",
        //     "cod_amount" => "0",
        //     "note" => "test",
        // ]);

        // $response = Http::withHeaders(
        //     [
        //         "Api-Key" => "at8f3p06nfiqizwdcisimpjjxoncwljo",
        //         "Secret-Key" => "txgfd00ut5pikkbi4lgpnta5",
        //     ]
        // )->get("https://portal.steadfast.com.bd/api/v1/status_by_cid/57320417");

        // $data = $response->collect();

        // dd($data);
    });
});

Route::prefix('')->namespace('Controllers')->group(function () {
    Route::get('/organic-oil', "WebsiteController@organic_oil")->name('organic_oil');
    Route::get('/funnel/{slug}', "WebsiteController@landingPage")->name('landing_page');
    Route::get('/about-us', "WebsiteController@aboutus")->name('about_us');
    Route::get('/privacy-policy', "WebsiteController@privacy_policy")->name('privacy_policy');
    Route::get('/terms', "WebsiteController@terms")->name('terms_and_condition');
    Route::get('/refund-policy', "WebsiteController@refund_policy")->name('refund_policy');

    Route::get('/product/{id}/{product_name}', 'WebsiteController@product_details')->name('product_details');
    Route::get('/product_quickview/{id}', 'WebsiteController@single_product_details')->name('single_product_view');

    Route::post('add_to_cart', 'WebsiteController@add_to_cart');
    Route::post('remove_cart', 'WebsiteController@remove_cart');
    Route::get('clear_cart', 'WebsiteController@clear_cart');
    Route::get('cart_all', 'WebsiteController@cart_all');

    Route::get('/category/{id}/{category_name}', 'WebsiteController@category_products')->name('category_product');

    Route::get('/get-category-product/{category_id}/{chunk_size}/{chunk_no}/json', 'JsonController@get_category_product')->name('get_category_product_json');
    Route::post('/search-product/json', 'JsonController@search_product')->name('search_product_json');
    Route::post('/update-cart-html', 'JsonController@update_cart_html')->name('update_cart_html');
    Route::post('/apply-coupon', 'JsonController@applyCoupon')->name('apply_coupon');

    Route::get('/cart', 'CartController@cart');

    Route::get('/checkout', 'FrontendController@checkout');
    Route::post('/checkout', 'FrontendController@confirm_order')->name('frontend_checkout');

    Route::post('/review-submit', 'FrontendController@reviewSubmit');
    Route::post('/review-remove', 'FrontendController@reviewremove');

    Route::get('/login', 'FrontendController@login')->name('login');
    Route::post('/login', 'FrontendController@website_login')->name('login');

    Route::get('/register', 'FrontendController@register')->name('register');
    Route::post('/register', 'FrontendController@website_register')->name('website_register');

    Route::post('/logout', 'FrontendController@logout')->name('logout');

    // Auth::routes();
    Route::post('/website_login', 'FrontendController@website_login')->name('website_login_api');
    Route::post('/website_register', 'FrontendController@website_register')->name('website_register_api');

    Route::get('/get-auth-info', function () {
        return Auth::user();
    })->name('route name');

    Route::group([
        'prefix' => 'admin',
        'middleware' => ['auth'],
        'namespace' => 'Admin'
    ], function () {

        Route::get('/', 'AdminController@index')->name('admin_index');
        Route::post('/set-theme', 'AdminController@set_theme')->name('admin_set_theme');
    });


    // user management
    Route::group([
        'prefix' => 'user',
        'middleware' => ['auth', 'check_user_is_active', 'super_admin'],
        'namespace' => 'Admin'
    ], function () {
        Route::get('/index', 'UserController@index')->name('admin_user_index');
        Route::get('/delivery-man', 'UserController@admin_delivery_man_index')->name('admin_delivery_man_index');

        Route::get('/view/{id}', 'UserController@view')->name('admin_user_view');
        Route::get('/create', 'UserController@create')->name('admin_user_create');
        Route::post('/store', 'UserController@store')->name('admin_user_store');
        Route::get('/edit/{id}', 'UserController@edit')->name('admin_user_edit');
        Route::post('/update', 'UserController@update')->name('admin_user_update');
        Route::post('/delete', 'UserController@delete')->name('admin_user_delete');

        // Route::post('/test', 'UserController@test')->name('admin_user_test');
    });

    // user role
    Route::group([
        'prefix' => 'user-role',
        'middleware' => ['auth', 'check_user_is_active', 'super_admin'],
        'namespace' => 'Admin'
    ], function () {

        Route::get('/index', 'UserRoleController@index')->name('admin_user_role_index');
        Route::get('/view/{id}', 'UserRoleController@view')->name('admin_user_role_view');
        Route::get('/create', 'UserRoleController@create')->name('admin_user_role_create');
        Route::post('/store', 'UserRoleController@store')->name('admin_user_role_store');
        Route::get('/edit', 'UserRoleController@edit')->name('admin_user_role_edit');
        Route::post('/update', 'UserRoleController@update')->name('admin_user_role_update');
        Route::post('/delete', 'UserRoleController@delete')->name('admin_user_role_delete');
    });

    Route::group([
        'prefix' => 'file-manager',
        'middleware' => ['auth'],
        'namespace' => 'Admin'
    ], function () {

        Route::post('/store-file', 'FileManagerController@store_file')->name('admin_fm_store_file');
        Route::get('/get-files', 'FileManagerController@get_files')->name('admin_fm_get_files');
        Route::delete('/delete-file/{image}', 'FileManagerController@delete_file')->name('admin_fm_delete_file');
    });

    Route::group([
        'prefix' => 'admin/product',
        'middleware' => ['auth'],
        'namespace' => 'Admin\Product'
    ], function () {

        Route::get('/list', 'ProductController@list')->name('admin_product_list');
        Route::get('/list-campeing', 'ProductController@list_campeing')->name('admin_product_list_campeing');

        Route::get('/list/json', 'ProductController@list_json')->name('admin_product_list_json');
        Route::get('/list-campeing/json', 'ProductController@list_campeing_json')->name('admin_product_list_campeing_json');

        Route::get('/create', 'ProductController@create')->name('admin_product_create');
        Route::get('/create-campeing', 'ProductController@create_campain')->name('admin_product_create_campain');
        Route::get('/edit-campeing/{id}', 'ProductController@edit_campeing')->name('admin_product_edit_campeing');
        Route::get('/edit/{id}', 'ProductController@edit')->name('admin_product_edit');
        Route::get('/get-json/{id}', 'ProductController@get_json')->name('admin_product_get_json');
        Route::get('/get-campeing-json/{id}', 'ProductController@get_campeing_json')->name('admin_product_get_campeing_json');

        Route::post('/store-product', 'ProductController@store_product')->name('admin_product_store_product');
        Route::post('/update-product', 'ProductController@update_product')->name('admin_product_update_product');

        Route::post('/store-campeing', 'ProductController@store_campeing')->name('admin_product_store_campeing');
        Route::post('/update-campeing', 'ProductController@update_campeing')->name('admin_product_update_campeing');
        Route::post('/delete-campeing', 'ProductController@delete_campeing')->name('admin_product_delete_campeing');


        Route::get('/categories', 'ProductController@categories')->name('admin_product_categories');

        Route::get('/categories_tree_json', 'ProductController@categories_tree_json')->name('admin_product_categories_tree_json');
        Route::get('/create-category', 'ProductController@create_category')->name('admin_product_create_category');
        Route::get('/edit-category/{id}/{category_name}', 'ProductController@edit_category')->name('admin_product_edit_category');
        Route::get('/edit-data/{id}', 'ProductController@category_data')->name('admin_product_category_data');
        Route::post('/categorie-url-check', 'ProductController@categorie_url_check')->name('admin_product_categorie_url_check');
        Route::post('/store-category', 'ProductController@store_category')->name('admin_product_store_category');
        Route::post('/store-category-from-product-create', 'ProductController@store_category_from_product_create')->name('admin_product_store_category_from_product_create');
        Route::post('/update-category', 'ProductController@update_category')->name('admin_product_update_category');
        Route::post('/rearenge-category', 'ProductController@rearenge_category')->name('admin_product_rearenge_category');

        Route::get('/option', 'ProductController@option')->name('admin_product_option');
        Route::get('/option_json', 'ProductController@option_json')->name('admin_product_option_json');
        Route::get('/create-option', 'ProductController@create_option')->name('admin_product_create_option');
        Route::get('/edit-option/{id}', 'ProductController@edit_option')->name('admin_product_edit_option');
        Route::get('/get-option/{id}', 'ProductController@get_option')->name('admin_product_get_option');
        Route::post('/store-option', 'ProductController@store_option')->name('admin_product_store_option');
        Route::post('/update-option', 'ProductController@update_option')->name('admin_product_update_option');
        Route::post('/check_option_exists', 'ProductController@check_option_exists')->name('admin_check_option_exists');
        Route::get('/delete_option/{id}', 'ProductController@delete_option')->name('admin_delete_option');

        Route::get('/brands-json', 'ProductController@brands_json')->name('admin_product_brands_json');
        Route::get('/brands', 'ProductController@brands')->name('admin_product_brands');
        Route::get('/create-brands', 'ProductController@create_brands')->name('admin_product_create_brands');
        Route::get('/edit-brands/{id}', 'ProductController@edit_brands')->name('admin_product_edit_brands');
        Route::post('/store-brands', 'ProductController@store_brands')->name('admin_product_store_brands');
        Route::post('/update-brands', 'ProductController@update_brands')->name('admin_product_update_brands');

        Route::get('/search', 'ProductController@search')->name('admin_product_search');
        Route::get('/reviews', 'ProductController@reviews')->name('admin_product_reviews');
    });

    Route::group([
        'prefix' => 'blank',
        'middleware' => ['auth'],
        'namespace' => 'Admin'
    ], function () {

        // basic_page
        Route::get('/index', 'AdminController@blade_index')->name('admin_blade_index');
        Route::get('/create', 'AdminController@blade_create')->name('admin_blade_create');
        Route::get('/view', 'AdminController@blade_view')->name('admin_blade_view');
    });

    Route::get('/testt', function (Request $request) {

        $options = array(
            'type' => array('kg'),
            'purity' => array('red', 'Green', 'Blue', 'purple'),
            'model' => array('Small', 'Medium', 'Large'),
        );

        // Create an array to store the permutations.
        $results = array();
        foreach ($options as $values) {
            // Loop over the available sets of options.
            if (count($results) == 0) {
                // If this is the first set, the values form our initial results.
                $results = $values;
            } else {
                // Otherwise append each of the values onto each of our existing results.
                $new_results = array();
                foreach ($results as $result) {
                    foreach ($values as $value) {
                        $new_results[] = "$result $value";
                    }
                }
                $results = $new_results;
            }
        }

        // Now output the results.
        foreach ($results as $result) {
            echo "$result<br/>";
        }

        dd(request()->all());
    })->name('route name');
});


Route::get('/admin', function () {
    return view('backend.dashboard');
})->name('admin');

Route::get('/cat', function () {
    return response()->json(\App\Models\Category::select(['id', 'name', 'parent_id'])->get());
});

Route::get('/cart-test', function () {
    ddd((new CartController())->get());
});

Route::get('/optimize_app', function () {
    $call = Artisan::call('optimize:clear');
    dd($call);
});
