<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display Category page
     *
     * @var return view
     */
    public function categoryShow() {

        if (Auth::check() && Auth::user()->is_admin == 1) {

            $data = Category::all();

            $pageTitle = "Food Category || EverFresh Creations";

            return view('admin.category', compact('pageTitle', 'data'));

        } elseif (Auth::check() && Auth::user()->is_admin == 0 ) {

            return redirect()->route('dashboard');
        }
    }

    /**
     * Saves Category to Database
     *
     * @var Request Response
     */
    public function  createCategory(Request $request) {

        $request->validate([
            'name' => 'required|unique:category,name',
            'icon' => 'required|mimes:jpeg,png,jpg,webm,gif'
        ]);

        $category = new Category;

        $category->name = $request->name;

        //Handel image upload request
        $image = $request->icon;
        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $request->icon->move('categoryIcons', $imagename);
        $category->icon = $imagename;

        $category->save();

        return redirect()->route('admin.category')->with('message', 'Category has been added successfully');
    }

    /**
     * Delete Category from database
     */
    public function deleteCategory($id) {

        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->route('admin.category')->with('message', 'Category has been deleted successfully');
    }

    public function editCategory(Request $request, $id) {
        
        $category = Category::find($id);

        $category->name = $request->name;

        //Handel image upload request
        $image = $request->icon;

        if($image)
        {
           $imagename = time() . '.' . $image->getClientOriginalExtension();
           $request->icon->move('categoryIcons', $imagename);
           $category->icon = $imagename;
        }

        $category->save();

        return redirect()->route('admin.category')->with('message', 'Category has been updated successfully');
    }
}
