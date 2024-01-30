<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhonePecontroller;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PhonepayController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::resource('product', ProductController::class) ;
Route::resource('category', CategoryController::class);


Route::get('prod',[ProductController::class,'index'])->name('product.index');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::get('phonepe',[PhonePecontroller::class,'phonePe']);
// Route::any('phonepe-response',[PhonePecontroller::class,'response'])->name('response');

// Route::get('/phonepe/payment',[PhonePecontroller::class,'makePhonePePayment'])->name('phonepe.payment');
// Route::post('/phonepe/payment/callback',[PhonePecontroller::class,'phonePeCallback'])->name('phonepe.payment.callback');


Route::get('/product', function () {
   // ProductName::doSomething();
});



Route::get('/d', function () {
   $results = DB::select('SELECT * FROM products');
   dd($results);

});


Route::get('/array', function () {
      // Define a multidimensional array
      $contacts = array(
         "peter" => array(
            "name" => "Peter Parker",
            "email" => "peterparker@mail.com",
         ),
         "clark" =>array(
            "name" => "Clark Kent",
            "email" => "clarkkent@mail.com",
         ),
         "harry" => array(
            "name" => "Harry Potter",
            "email" => "harrypotter@mail.com",
         )
      );
      // Access nested value

      print_r($contacts["peter"]["name"]); 
});



Route::get('/query', function () {
   //$results = DB::insert("INSERT INTO employees (first_name, last_name, salary) VALUES ('John', 'Doe', '50000')");
   // $results = DB::select('SELECT DISTINCT name FROM products');
   //$results = DB::select("SELECT * FROM products WHERE name='test'");
   // $results = DB::delete("DELETE FROM products WHERE id='14' AND name='hello test'");   
   //$results = DB::select("SELECT * FROM products LIMIT 4 OFFSET 1");  
   // $results = DB::select("SELECT name FROM products UNION ALL  SELECT name FROM categories");
   // $results = DB::select("SELECT products.name, products.category_id FROM products
   //                      LEFT JOIN categories ON products.category_id = categories.id
   //                      WHERE categories.id='2'
   //                      ORDER BY categories.id");

   // $results = DB::select("SELECT name
   //                         FROM products
   //                         WHERE EXISTS (SELECT name FROM categories WHERE products.category_id = categories.id AND products.name = 2)");                   

   // $results = DB::select("SELECT products.id , MAX(price) AS price
   //                         FROM products
   //                         GROUP BY products.id 
   //                         ORDER BY MAX(price) DESC LIMIT 3 OFFSET 1");

   // $results = DB::select("SELECT * FROM products 
   //                         WHERE PRICE < 400 ORDER BY products.id ASC LIMIT 3 OFFSET 3");

   // $results = DB::select("SELECT products.id, products.name FROM products WHERE category_id = 2");

   $results = DB::select("SELECT SUM(price) FROM products WHERE category_id = 1");

   dd($results);

});


Route::get('/putcache', function () {

   $test_cache = 'hello';
   $cache_get = Cache::put('test_cache',$test_cache);

});


Route::get('/getcache', function () {
   
   //Session::forget();
   Cache::flush();
   $cache_get = Cache::get('test_cache');
   dd($cache_get);

});










// Route::get('/', [PhonepayController::class, 'index']);
// Route::get('pay', [PhonepayController::class, 'payment_init']);
// Route::get('pay-refund-view', [PhonepayController::class, 'refund']);
// Route::get('pay-refund', [PhonepayController::class, 'payment_refund']);
// Route::any('pay-return-url', [PhonepayController::class, 'payment_return'])->name('pay-return-url');
// Route::post('pay-callback-url', [PhonepayController::class, 'payment_callback'])->name('pay-callback-url');
// Route::any('pay-refund-callback', [PhonepayController::class, 'payment_refund_callback'])->name('pay-refund-callback');