<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{

    public function allProduct()
    {
        $products = Product::all();
        //dd($products);

        return $products;
    }

    public function getProduct($productId)
    {
        $product =  Product::findOrFail($productId);
         return $product;
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct($productId, array $data)
    {
        $products = $this->getProduct($productId);
        $products->update($data);

        return $products;
    }

    public function deleteProduct($productId)
    {
        $products = $this->getProduct($productId);
        $products->delete();

        return $products;
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%$query%")
                            ->orWhere('description','LIKE', "%$query%")
                            ->get();

        return $products;
    }    

    public function doSomething()
    {
        return 'hello';
    }
}   