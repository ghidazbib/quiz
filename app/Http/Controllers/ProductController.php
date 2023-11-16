<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth:api')->except(['index', 'show']);
//    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::all();
        if($products->count() > 0){
            $data = [
                'status' => 200,
                'products' => $products
            ];
            return response()->json($data,200);
        }
        else{
            $data = [
                'status' => 404,
                'message' => 'No products'
            ];
            return response()->json($data,404);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);
        if($validatedData->fails()){
            $data = [
                'status' => 422,
                'error' => 'Data missing or wrong'
            ];
            return response()->json($data,422);
        }
        else{
            $product = Product::create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ]);
            if($product){
                $data = [
                    'status' => 200,
                    'message' => 'Product added successfully'
                ];
                return response()->json($data,200);
            }
            else{
                $data = [
                    'status' => 500,
                    'message' => 'Error in add product'
                ];
                return response()->json($data,500);
            }

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if($product){
            $data = [
                'status' => 200,
                'product' => $product
            ];
            return response()->json($data,200);
        }
        else{
            $data = [
                'status' => 404,
                'message' => 'No product found'
            ];
            return response()->json($data,404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        if($product){
            $data = [
                'status' => 200,
                'product' => $product
            ];
            return response()->json($data,200);
        }
        else{
            $data = [
                'status' => 404,
                'message' => 'No product found'
            ];
            return response()->json($data,404);
        }
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);
        if($validatedData->fails()){
            $data = [
                'status' => 422,
                'error' => 'Data missing or wrong'
            ];
            return response()->json($data,422);
        }
        else{
            $product = Product::find($id);
            if($product) {
                $product->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                ]);
                $data = [
                    'status' => 200,
                    'message' => 'Product updated successfully'
                ];
                return response()->json($data,200);
            }
            else{
                $data = [
                    'status' => 404,
                    'message' => 'No product found'
                ];
                return response()->json($data,404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if($product){
            $product->delete();
            $data = [
                'status' => 200,
                'message' => 'Product deleted successfully'
            ];
            return response()->json($data,200);
        }
        else{
            $data = [
                'status' => 404,
                'message' => 'No product found'
            ];
            return response()->json($data,404);

        }
    }
}
