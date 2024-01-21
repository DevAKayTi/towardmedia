<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Carbon\Carbon;

class DateRangeController extends Controller
{
    //
    function index(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $data = Post::query()->with('author')
                    ->whereBetween('created_at', array($request->from_date, $request->to_date))
                    ->get();
            } else {
                $data = Post::query()->with('author')
                    ->get();
            }
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('author', function (Post $post) {
                    return $post->author->name;
                })
                ->editColumn('created_at', function ($post) {
                    return $post->created_at !== null ? Carbon::parse($post->created_at)->format('Y-m-d (g:i A)') : '';
                })
                ->editColumn('published_at', function ($post) {
                    return $post->published_at !== null ? Carbon::parse($post->published_at)->format('Y-m-d (g:i A)') : '';
                })
                ->make(true);
        }
        return view('test');
    }
}
