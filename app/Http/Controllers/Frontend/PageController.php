<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\PostType;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\VolumeResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Tag;
use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{


    public function welcome()
    {

        $newIssues = PostResource::collection(Post::query()->where('published', '=', 1)->orderBy('id', 'desc')->take(3)->get());
        $mostIssues = PostResource::collection(Post::query()->where('published', '=', 1)->orderBy('views', 'desc')->take(3)->get());

        // $news = PostResource::collection(Post::query()->where('published', '=', 1)->orderBy('published_at', 'desc')->where('type_id', '1')->take(8)->get());
        // $articles = PostResource::collection(Post::query()->where('published', '=', 1)->orderBy('published_at', 'desc')->where('type_id', '2')->take(6)->get());


        $podcasts = PostResource::collection(Post::query()->where('published', '=', 1)->orderBy('published_at', 'desc')->where('type_id', '3')->take(6)->get());
        $volumes = VolumeResource::collection(Volume::query()->where('published', '=', 1)->orderBy('published_at', 'desc')->take(4)->get());
        $newsCategory = Category::query()->where('type_id', PostType::News)->get();
        $articlesCategory = Category::query()->where('type_id', PostType::Article)->get();
        return view('frontend.index')->with(['newIssues' => $newIssues,'mostIssues' => $mostIssues, 'podcasts' => $podcasts, 'volumes' => $volumes, 'newsCategory' => $newsCategory, 'articlesCategory' => $articlesCategory]);
    }

    public function index()
    {
        $posts = PostResource::collection(Post::query()->orderBy('updated_at', 'desc')->where('published', 1)->paginate(9));
        return view('frontend.post.index')->with(['posts' => $posts]);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->with('tags')->first();
        if ($post === null) {
            return back();
        }
        $Key = 'blog' . $post->id;
        if (!Session::has($Key)) {
            $post->incrementViewCount();
            Session::put($Key, 1);
        }
        return view('frontend.detail')->with(['post' => $post]);
    }

    public function groupByTag($tag)
    {
        $selectedTag = Tag::where('name', $tag)->first();
        $tags = Tag::query()->where('id', '!=', $selectedTag->id)->get();
        $posts = PostResource::collection($selectedTag->posts()->orderBy('updated_at', 'desc')->where('published', 1)->paginate(12));
        if ($selectedTag === null) {
            return back();
        }
        return view('frontend.postsByTag')->with(['posts' => $posts, 'selectedTag' => $selectedTag, 'tags' => $tags]);
    }

    public function groupByCategory($category)
    {
        $selectedCategory = Category::where('slug', $category)->first();
        $posts = PostResource::collection($selectedCategory->posts()->orderBy('updated_at', 'desc')->where('published', 1)->paginate(12));
        if ($selectedCategory === null) {
            return back();
        }
        return view('frontend.postsByTag')->with(['posts' => $posts, 'selectedTag' => $selectedCategory,]);
    }

    public function increaseViewCount($post_id)
    {
        $post =  Post::findOrFail($post_id);
        $post->disableLogging();
        $post->timestamps = false;
        $post->update([
            'views' => ++$post->views,
        ]);
        $post->timestamps = true;
        return response()->json(['success' => true]);
    }

    public function articles()
    {
        $articles = Post::query()->where('published', 1)->orderBy('published_at', 'desc')->where('type_id', '2')->paginate(6);
        return view('frontend.articles')->with(['articles' => $articles]);
    }

    public function news()
    {
        $news = Post::query()->where('published', 1)->orderBy('published_at', 'desc')->where('type_id', '1')->paginate(6);
        return view('frontend.news')->with(['news' => $news]);
    }
    public function podcasts()
    {
        $podcasts = Post::query()->where('published', 1)->orderBy('published_at', 'desc')->where('type_id', PostType::Podcast)->paginate(6);
        return view('frontend.podcasts')->with(['podcasts' => $podcasts]);
    }

    public function volumes()
    {
        $volumes = Volume::query()->where('published', 1)->paginate(12);
        return view('frontend.volumes')->with(['volumes' => $volumes]);
    }


    public function volumeDetail(Request $request, $title)
    {
        $articles = Volume::findOrFail($request->id)->articles()->whereIn('published', [1])->orderBy('published_at', 'desc')->paginate(6);
        return view('frontend.articles')->with(['articles' => $articles]);
    }

    public function aboutUs()
    {
        return view('frontend.aboutus');
    }

    public function privacyPolicy()
    {
        return view('frontend.privacy');
    }
}
