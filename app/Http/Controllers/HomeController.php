<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Displays Home page
     *
     * @var return view
     */
    public function index () {

        //$food = Products::all()->groupBy('category_id')->sum();

        $category = Category::all();

        $pageTitle = "EverFresh Creations || Home Of Luxury Food";

        return view('index', compact('pageTitle', 'category'));
    }

    /**
     * Displays about us page
     *
     * @var return view
     */
    public function about () {

        $pageTitle = "About Us || EverFresh Creations";

        return view('about', compact('pageTitle'));
    }

    /**
     * Displays Food Menu page
     *
     * @var return view
     */
    public function food () {

        $product = Products::paginate(12);

        $category = Category::all();

        $pageTitle = "Order A Meal || EverFresh Creations";

        return view('food', compact('pageTitle', 'category'))->with(['product' => $product]);
    }
}
