<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Moldes\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category,Request $request)
    {
        $topics = Topic::where('category_id',$category->id)->withOrder($request->order)->paginate(20);

        return view('topics.index',compact('topics'));
    }
}
