<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductController extends Controller
{
    //
    public function getAllProducts(Request $request): JsonResponse
    {
        $products = Product::paginate(10);
        return $this->okResponse('Products Retrieved Successfully.', new ProductCollection($products));
    }

    public function createAnProduct(Request $request): JsonResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'min:4', 'max:40'],
            'description' => ['required', 'string'],
            'price' => ['required', 'string'],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $body = $request->only(['title', 'description', 'price']);

        if (!$request->file('image')->isValid()) {
            throw new HttpException(400, "Invalid image.");
        }

        $image = $request->file('image');
        $path = $image->store('public/images');

        $body['image'] = $path;

        $productId = Product::create($body)->id;

        $product = Product::where('id', $productId)->first();

        return $this->createdResponse('Product Created Successfully.', new ProductResource($product));
    }

    public function getOneProduct(Request $request): JsonResponse
    {
        $product = Product::where('id', $request->product_id)->first();

        if (!$product) {
            throw new HttpException(404, "Specified product not found.");
        }

        return $this->okResponse('Product Retrieved Successfully.', new ProductResource($product));
    }
}
