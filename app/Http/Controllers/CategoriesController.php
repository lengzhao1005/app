<?php

namespace App\Http\Controllers;

use App\Models\Topics;
use App\Moldes\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category,Request $request)
    {
        $topics = Topics::where('category_id',$category->id)->withOrder($request->order)->paginate(20);

        return view('topics.index',compact('topics'));
    }
}
