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
use App\Models\Bulletin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{


    public function welcome()
    {

        $newIssues = PostResource::collection(Post::query()->where('published', '=', 1)->orderBy('id', 'desc')->take(3)->get());
        $mostIssues = PostResource::collection(Post::query()->where('published', '=', 1)->orderBy('views', 'desc')->take(3)->get());

        $podcasts = PostResource::collection(Post::query()->where('published', '=', 1)->orderBy('published_at', 'desc')->where('type_id', '=', PostType::Podcast)->take(6)->get());
        $newsletter= PostResource::collection(Post::query()->where('published', '=', 1)->where('type_id', '=', PostType::Newsletter)->orderBy('id', 'desc')->take(6)->get());
        $newsbulletin= PostResource::collection(Post::query()->where('published', '=', 1)->where('type_id', '=', PostType::Newsbulletin)->orderBy('id', 'desc')->take(6)->get());
        $newArticles= PostResource::collection(Post::query()->where('published', '=', 1)->where('type_id', '=', PostType::News_Article)->orderBy('id', 'desc')->take(6)->get());

        return view('frontend.index')->with(['newIssues' => $newIssues,'mostIssues' => $mostIssues, 'podcasts' => $podcasts, 'newsletters' => $newsletter, 'newsbulletins' => $newsbulletin, 'newArticles' => $newArticles]);
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
        $articles = Post::query()->where('published', 1)->orderBy('published_at', 'desc')->where('type_id', '1')->paginate(9);
        return view('frontend.articles')->with(['articles' => $articles]);
    }

    public function news()
    {
        $volumes = Volume::query()->where('published', 1)->paginate(12);
        return view('frontend.news')->with(['news' => $volumes]);
    }
    public function bulletins()
    {
        $bulletins = Bulletin::query()->where('published', 1)->paginate(12);
        return view('frontend.bulletins')->with(['bulletins' => $bulletins]);
    }
    public function podcasts()
    {
        $podcasts = Post::query()->where('published', 1)->orderBy('published_at', 'desc')->where('type_id', '4')->paginate(9);
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

    public function bulletinDetail(Request $request, $title)
    {
        $articles = Bulletin::findOrFail($request->id)->articles()->whereIn('published', [1])->orderBy('published_at', 'desc')->paginate(6);
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
