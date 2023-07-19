<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart (Request $request, $id) {

        if(Auth::id()) {

            $user = Auth::user();

            $food = Products::findOrFail($id);

            $cart = new Cart;

            $cart->name = $user->name;
            $cart->email = $user->email;
            $cart->phone = $user->phone;
            $cart->address = $user->shipping_address;
            $cart->user_id = $user->id;
            $cart->product_title = $food->title;
            $cart->quantity = $request->quantity;

            if ($food->discount_price != null) {

                $cart->price = $food->discount_price * $request->quantity;
            } else {

                $cart->price = $food->price * $request->quantity;
            }

            $cart->image = $food->image;
            $cart->product_id = $food->id;
            $cart->save();

            return redirect()->back();

        } else {

            return redirect()->route('login.show');

        }
    }

    public function showCart () {

        $id = Auth::user()->id;

        $cart = Cart::where('user_id', '=', $id)->get();

        $pageTitle = "Your Cart || EverFresh Creations";

        return view('cart', compact('pageTitle', 'cart'));
    }

    public function removeItem ($id) {

        $cart = Cart::findOrFail($id);

        $cart->delete();

        return redirect()->back();
    }
}
