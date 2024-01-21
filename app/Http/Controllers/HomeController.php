<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        $authorCount = User::query()->where('role', '=', 1)->count();
        $mostViewedPost = Post::query()->orderBy('views', 'desc')->get()->first();
        $activities = Activity::query()->orderBy('created_at', 'desc')->with('causer')
            ->whereHas('causer', function ($q) {
                $q->where('role', '!=', 2);
            })
            ->paginate(10);
        $allViewCounts = DB::table('posts')->sum('views');
        return  view('home')
            ->with(
                [
                    'authorCount' => $authorCount,
                    'mostViewedPost' => $mostViewedPost,
                    'activities' => $activities,
                    'allViewCounts' => $allViewCounts,
                ]
            );
    }
}
