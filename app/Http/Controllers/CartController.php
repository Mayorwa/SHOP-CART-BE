<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartCollection;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CartController extends Controller
{
    //

    public function addProductToCart(Request $request): JsonResponse
    {
        $user = Auth::user();

        $product = Product::where('id', $request->product_id)->first();
        if (!$product) {
            throw new HttpException(404, "Specified product not found.");
        }

        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
        } else {
            $cartItem = new Cart();
            $cartItem->user_id = $user->id;
            $cartItem->product_id = $product->id;
            $cartItem->quantity = 1;
        }
        $cartItem->save();

        return $this->okResponse('Product added to cart successfully.', []);
    }

    public function getCartProducts(Request $request): JsonResponse
    {
        $user = Auth::user();

        $cartItems = Cart::with('product')->where('user_id', $user->id)->paginate();

        return $this->okResponse('Users Cart Products retrieved successfully.', new CartCollection($cartItems));
    }
}
