<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Services\ProductService;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateProductRequest;

class ProductsController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = Product::all();
        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }

    public function store(CreateProductRequest $request)
    {

        // $request->validate([
        //     'category_id' => 'required',
        //     'name' => 'required|min:2|max:200',
        //     //'email' => 'required|email',
        //     'stock_count' => 'required|min:1|max:50',
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
        
        
        // main
        $image = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/images', $image);

        $product = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'stock_count' => $request->stock_count,
            //'email' => $request->email,
            'image' => $image
        ];
        Product::create($product);

        $products = $this->productService->createPost($postData);
        
        return response()->json([
            'status' => 201,
            'products' => $products,
            'message'=> 'Created Successfully'
        ]);
    }


    public function update(Request $request, $id)
    {
        $product = Product::find($id); 

    //     $image = '';
    //     if ($request->hasFile('image')) {
    //       $image = time() . '.' . $request->file->extension();
    //       $request->file->storeAs('public/images', $product);
    //       if ($product->image) {
    //         Storage::delete('public/images/' . $product->image);
    //       }
    //     } else {
    //       $image = $product->image;
    //     }

    //     $prod = [
    //         'name' => $request->name,
    //         'category_id' => $request->category_id,
    //         'stock_count' => $request->stock_count,
    //         'email' => $request->email,
    //         'image' => $image
    //     ];
    // //   dd($product);
    //    $product->update($prod);
        

       $product              =   Product::find($id); 
       $product->name        =   $request->name;
       $product->category_id =   $request->category_id;
       $product->stock_count =   $request->stock_count;
       $product->email_id    =   $request->email_id;
       $product->image       =   $request->image;
       $product->save();



    // $product->update($request->all());
    
        return response()->json([
            'status' => 201,
            // 'products' => $products
            'message'=> 'Updated successfully'
        ]);
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json([
            'status' => 200,
            // 'products' => $products
            'message'=> 'Deleted Successfully'
        ]);
    }
}
