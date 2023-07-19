<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display Food Menu page
     *
     * @var Return view
     */
    public function showProducts() {

        if (Auth::check() && Auth::user()->is_admin == 1) {

            $pageTitle = "Food Menu || EverFresh Creations";

            $food = Products::all();

            $data = Category::all();

            return view('admin.foodMenu', compact('pageTitle', 'food', 'data', ));

        } elseif (Auth::check() && Auth::user()->is_admin == 0) {

            return redirect()->route('dashboard');
        }
    }

    /**
     * Handles adding food to database
     *
     * @array Return Response
     */
    public function addProducts(Request $request) {

        if (Auth::check() && Auth::user()->is_admin == 1) {

            $food = new Products;

            $food->title = $request->name;
            $food->description = $request->description;
            $food->price = $request->price;
            $food->discount_price = $request->discount;
            $food->category_id = $request->category;

            // Handle image upload request
            $image = $request->images;
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->images->move('food/', $imagename);
            $food->image = $imagename;
            $food->save();

            /**
         * foreach ($request->file('images') as $imagefile) {
         *     $image = new ProductImage;
         *     $path = $imagefile->store('/images/food/'.$food->title, ['disk' =>   'my_files']);
         *     $image->url = $path;
         *     $image->product_id = $food->id;
         *    $image->save();
         *   }
             */

            return redirect()->route('admin.products')->with('message', 'Meal has been added successfully');
        } elseif (Auth::check() && Auth::user()->is_admin == 0) {

            abort(403);
        }
    }

    public function editProducts (Request $request, $id) {

        if (Auth::check() && Auth::user()->is_admin == 1) {

            $food = Products::findOrFail($id);

            $food->title = $request->name;
            $food->description = $request->description;
            $food->discount_price = $request->discount;
            $food->price = $request->price;
            $food->category_id = $request->category;

            $image = $request->images;

            if($image)
            {
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->images->move('food/', $imagename);
            $food->image = $imagename;
            }

            $food->save();

            return redirect()->route('admin.products')->with('message', 'Meal has been edited successfully');
        } elseif (Auth::check() && Auth::user()->is_admin == 0) {

            abort(403);
        }


    }

    public function deleteProducts($id) {

        if (Auth::check() && Auth::user()->is_admin == 1) {

            $food = Products::findOrFail($id);

            $food->delete();

            return redirect()->route('admin.products')->with('message', 'Meal has been deleted successfully');
        } elseif (Auth::check() && Auth::user()->is_admin == 0) {

            abort(403);
        }

    }

    public function showDetails($id) {

        $food = Products::findOrFail($id);

        $category = Products::where("category_id", "=", $food->category_id)->skip(1)->take(3)->get();

        $pageTitle = $food->title. " || EverFresh Creations";

        return view('foodDetails', compact('pageTitle', 'food', 'category'));
    }

}

