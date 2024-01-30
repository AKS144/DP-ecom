<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Services\ProductService;
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
        $products = $this->productService->allProduct();
        
        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }
  

    public function store(CreateProductRequest $request)
    {
        $productData = $request->validated();
        $products = $this->productService->createProduct($productData);
        
        return response()->json([
            'status' => 201,
            'products' => $products,
            'message'=> 'Created Successfully'
        ]);
    }


    public function produpdate(CreateProductRequest $request, $productId)
    {          
        $productData = $request->validated();
        $products = $this->productService->updateProduct($productId, $productData);

        return response()->json([
            'status' => 200,
            'products' => $products,
            'message'=> 'Updated successfully'
        ]);
    }


    public function destroy($productId)
    {
        $products = $this->productService->deleteProduct($productId);
       
        return response()->json([
            'status' => 200,
            'products' => $products,
            'message'=> 'Deleted Successfully'
        ]);
    }

    public function show($productId)
    {
        $products = $this->productService->getProduct($productId);
       
        return response()->json([
            'status' => 200,
            'products' => $products,
            'message'=> 'Success'
        ]); 
    }


    public function setSharedValue() 
    {
        // $this->sharedVariable = "Some value";
        return "Hello, World!";
    }

    public function useSharedValue() 
    {
        $result = $this->setSharedValue();
        echo $result;
    }



    /*public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'LIKE', "%$query%")
                            ->orWhere('description','LIKE', "%$query%")
                            ->get();

        return response()->json(['products' => $products]);
    }*/


    public function search(Request $request)
    {
        $query = $request->input('query');
        // $searchFields = $request->input('fields', []);

        // $productsQuery = Product::query();

        // foreach ($searchFields as $field) {
        //     $productsQuery->orWhere($field, 'LIKE', "%$query%");
        // }

        // $products = $productsQuery->get();

        $products = Product::whereRaw("MATCH(name, description) AGAINST(? IN BOOLEAN MODE)", [$query])
                            ->get();

        return response()->json(['products' => $products]);
    }


}
