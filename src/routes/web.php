<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

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
Route::get('/test', function (Request $request) {
//    $temp= $request->session()->get('products');
//    array_push($product,$temp);
//    if (!($request->session()->has('products'))){
//        $_SESSION["products"]=array();
//    }
//    $request->session()->put('products',$product);
    $sess = $request->session()->get('products');
    return view('test',[
        'sss'=>$sess
    ]);
});

Route::get('/', function () {
    return view('home');
});
Route::get('/contacts', function (Request $request) {
    $sess=$request->session()->get('products');

    return view('contacts',[
        'sess'=>$sess,
    ]);
});
Route::get('/shop', function (Request $request) {
    $sess=$request->session()->get('products');
    $products = DB::table('products')->where('visible','=',1)->get();
    return view('shop',[
        'products'=>$products,
        'sess'=>$sess,
    ]);
});
Route::get('/cart', function (Request $request) {
    $sess=$request->session()->get('products');

    return view('cart',[

        'sess'=>$sess,
    ]);
});

Route::post('/cart/add/{id}',function (Request $request,$id){
    $temp= $request->session()->get('products');
    $temp[]=[
        'id'=>$id,
        'name'=>$request->name,
        'price'=>$request->price,
        'color'=>$request->color,
        'size'=>$request->size,
        'quantity'=>$request->count,
        'image'=>$request->image,
    ];
    $request->session()->put('products',$temp);
    return back();
});
Route::post('/cart/remove/{id}',function (Request $request,$id){
    $temp= $request->session()->get('products');
    unset($temp[$id]);
    $request->session()->put('products',$temp);
    return back();
});

Route::get('/checkout', function (Request $request) {
    $sess=$request->session()->get('products');

    return view('checkout',[
        'sess'=>$sess,
    ]);
});


Route::post('/checkout',function (Request $request){
    $products= $request->session()->get('products');
    $user_data =[
            "email"=>$request->email,
            "name"=>$request->name,
            "surname"=>$request->surname,
            "phone"=>$request->phone_number,
            "adress"=>$request->adress,
            "home_adress"=>$request->home_adress,
    ];

    DB::table('orders')->insert([
        "products"=>json_encode($products),
        "user_data"=>json_encode($user_data),
        "created_at"=>new \DateTime(),
    ]);
    $request->session()->forget('products');

    // Work on it later
//    if($request->create_acc){
//        DB::table('users')->insert([
//            "email"=>$request->email,
//            "username"=>$request->name,
//            "password"=>"123",// WORK ON HASH8 and email verification
//            "created_at"=>new \DateTime(),
//            "name"=>$request->name,
//            "surname"=>$request->surname,
//            "phone"=>$request->phone_number,
//            "role"=>"user",
//            "adress"=>$request->adress,
//            "home_adress"=>$request->home_adress,
//        ]);
//
//    }
    return redirect('/shop');
});

Route::get('/news', function (Request $request) {
    $sess=$request->session()->get('products');

    return view('news',[
        'sess'=>$sess,
    ]);
});
Route::get('/news/{id}', function ($id) {

    return view('newsView',[
        'id'=>$id
    ]);
});

// admin
Route::get('/admin', function () {
    $news=[];
    return view('admin.main',[
        "news"=>$news,
    ]);
});

// news admin

Route::get('/admin/news',function(){
    $news = DB::table('news')->latest('id')->get();
    return view('admin/news',[
        'news' =>$news
    ]);
})->middleware('auth');

Route::delete('/admin/news',function(Request $request){
    $id = array_search('delete',$request->all());
    $image = DB::table('news')->where('id','=',$id)->get('image');
    if ($image != NULL){
        Storage::disk('public_uploads')->delete($image[0]->image);
    }
    DB::table('news')->where('id','=',$id)->delete();
    return redirect('admin/news');
})->middleware('auth');

Route::get('/admin/news/create',function(){
    return view('admin.news.createNews');
})->middleware('auth');

Route::post("/admin/news/create",function(Request $request){
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $path = $request->image->store('/newsImg', ['disk' => 'public_uploads']);
    }else{
        $path = NULL;
    }
    DB::table('news')->insert([
        "title"=>$request->title,
        "body"=>$request->body,
        "shortcut"=>$request->shortcut,
        "image"=>$path,
        "visible"=>$request->visible,
        "created_at"=> new \DateTime()
    ]);

    return redirect('/admin/news');
})->middleware('auth');


Route::get('/admin/news/view/{id}',function($id){
    $news = DB::table('news')->where('id','=',$id)->get();
    return view('admin.news.viewNews',[
        "news"=>$news
    ]);
})->middleware('auth');

Route::get('/admin/news/edit/{id}',function($id){
    $news = DB::table('news')->where('id','=',$id)->get();
    return view('admin.news.editNews',[
        "news"=>$news
    ]);
})->middleware('auth');

Route::post('/admin/news/edit/{id}',function(Request $request, $id){
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $image_path = DB::table('news')->where('id', '=', $id)->get('image');

        Storage::disk('public_uploads')->delete($image_path[0]->image);
        $path = $request->image->store('/newsImg', ['disk' => 'public_uploads']);
        DB::table('news')->where('id', '=', $id)->update([
            'title' => $request->title,
            'visible'=> $request->visible,
            'body' => $request->body,
            'image' => $path,
            'shortcut'=> $request->shortcut,
        ]);
    }else{
        DB::table('news')->where('id', '=', $id)->update([
            'title' => $request->title,
            'visible'=> $request->visible,
            'shortcut'=> $request->shortcut,
            'body' => $request->body,
        ]);}
    return redirect('/admin/news/view/'.$id);
})->middleware('auth');

// Products admin
Route::get('/admin/products',function(){
    $products= DB::table('products')->get();
    return view('admin.products.productsMain',[
        "pages"=>$products,
    ]);
})->middleware('auth');

Route::get('/admin/products/create',function (){
    $categories = DB::table('category')->get();
    return view('admin.products.createProduct',[
        'categories' => $categories
    ]);
})->middleware('auth');
Route::post('/admin/products/create',function (Request $request){
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $name = $request->name;
        $category = $request->category;
        $subcategory = $request->subcategory;
        $price = $request->price; // FURTHER CHECK THAT HAVE ALL INTEGERS
        $description = $request->description;
        $path = $request->image->store('/productImg', ['disk' => 'public_uploads']);

        // $file = request()->file('uploadFile');
        // $file->store('toPath', ['disk' => 'my_files']);

        // !Storage::disk('public_uploads')->put($path, $file_content

        DB::table('products')->insert(
            [
                'name'=>$name,
                'category'=>$category,
                'subcategory'=>$subcategory,
                'price'=>$price,
                'description'=>$description,
                'main_image'=>$path,
                'visible'=>$request->visible,
            ]
        );
    }
    return redirect('/admin/products');
})->middleware('auth');


Route::get('/admin/products/edit/{id}',function($id){
    $products = DB::table('products')->where('id','=',$id)->get();
    return view('admin.products.editProduct',[
        "product"=>$products
    ]);
})->middleware('auth');

Route::post('/admin/products/edit/{id}',function(Request $request, $id){
    $name = $request->name;
    $category = $request->category;
    $subcategory = $request->subcategory;
    $price = $request->price; // FURTHER CHECK THAT HAVE ALL INTEGERS
    $description = $request->description;
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $image_path = DB::table('products')->where('id', '=', $id)->get('main_image');

        Storage::disk('public_uploads')->delete($image_path[0]->main_image);
        $path = $request->image->store('/newsImg', ['disk' => 'public_uploads']);
        DB::table('products')->where('id', '=', $id)->update([
            'name'=>$name,
            'category'=>$category,
            'subcategory'=>$subcategory,
            'price'=>$price,
            'description'=>$description,
            'image'=>$path,
            'visible'=>$request->visible,
        ]);
    }else{
        DB::table('products')->where('id', '=', $id)->update([
            'name'=>$name,
            'category'=>$category,
            'subcategory'=>$subcategory,
            'price'=>$price,
            'description'=>$description,
            'visible'=>$request->visible,
        ]);}
    return redirect('/admin/products/view/'.$id);
})->middleware('auth');

Route::post('/admin/products/edit/{$id}', function (Request $request,$id){
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $name = $request->name;
        $category = $request->category;
        $subcategory = $request->subcategory;
        $price = $request->price; // FURTHER CHECK THAT HAVE ALL INTEGERS
        $description = $request->description;
        $path = $request->image->store('/productImg', ['disk' => 'public_uploads']);

        // $file = request()->file('uploadFile');
        // $file->store('toPath', ['disk' => 'my_files']);

        // !Storage::disk('public_uploads')->put($path, $file_content

        DB::table('products')->insert(
            [
                'name'=>$name,
                'category'=>$category,
                'subcategory'=>$subcategory,
                'price'=>$price,
                'description'=>$description,
                'image'=>$path,
                'visible'=>$request->visible,
            ]
        );
    }
    return redirect('/admin');
})->middleware('auth');

Route::get('/admin/products/view/{id}',function($id){
    $product = DB::table('products')->where('id','=',$id)->get();
    return view('admin.products.viewProduct',[
        "product"=>$product
    ]);
})->middleware('auth');
Route::DELETE('/admin/products',function (Request $request){
    $id = array_search('delete',$request->all());
    DB::table('products')->where('id','=',$id)->delete();
    return redirect('/admin');
})->middleware('auth');
// change dropzone
Route::post('/admin/product/dropzone/{productId}',function(Request $request,$productId){
    $image = $request->file('file');
    $main = DB::table('products')->where('id','=',$productId)->get('image');
    if($main[0]->image == NULL){
        $path = $image->store('/productImg', ['disk' => 'public_uploads']);
        DB::table('products')->where('id','=',$productId)->update([
            'image'=>$path
        ]);
    }
    else{

        $avatarName = $image->store('/dropzone/product'.$productId, ['disk' => 'public_uploads']);
        $images = DB::table('products')->where('id','=',$productId)->get('otherImage');
        if ($images[0]->otherImage!=NULL){$img_arr = json_decode($images[0]->otherImage,TRUE);}
        $img_arr[] = $avatarName;

        // echo '<pre>';print_r($images);echo'</pre>';
        //  exit();
        DB::table('products')->where('id','=',$productId)->update([
            'otherImage'=>json_encode($img_arr)
        ]);
    }
    return response()->json(['success'=>$avatarName]);
});
//end product details

// Admin order
Route::get('/admin/orders',function (){
    $order = DB::table('orders')->orderBy('id', 'desc')->get();
    return view('admin.orders.ordersMain',[
        "orders"=>$order,
    ]);
})->middleware('auth');

Route::post('/admin/order/complete/{id}',function ($id){
    DB::table('orders')->where('id','=',$id)->update([
        "complete"=>TRUE,
    ]);
    return redirect('admin/orders/');
})->middleware('auth');


Auth::routes();
//
//Route::resource('editor','ckeditor');
//Route::post('/ckeditor/image_upload',"ckeditor@upload")->name('upload');
