<?php

namespace App\Http\Controllers;

use App\Enums\PostType;
use App\Helpers\UUIDGenerate;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use App\Models\Type;
use App\Models\User;
use App\Models\Volume;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Faker;
use Faker\Core\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use Spatie\Activitylog\Facades\CauserResolver;
use Yajra\Datatables\Datatables;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {

        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $posts = Post::query()->with('author')
                    ->whereBetween('published_at', array($request->from_date, $request->to_date))->get();
            } else {
                $posts = Post::query()->with('author')->get();
            }
            return datatables()->of($posts)
                ->addIndexColumn()
                ->addColumn('author', function (Post $post) {
                    if (!empty($post->author)) {
                        return $post->author->name;
                    }
                })
                ->editColumn('type_id', function ($post) {
                    switch ($post->type_id) {
                        case PostType::Article:
                            # code...
                            return 'Article';
                            break;
                        case PostType::Podcast:
                            # code...
                            return 'Podcast';
                            break;
                        case PostType::News:
                            # code...
                            return 'News';
                            break;
                        default:
                            # code...
                            return 'not_set';
                            break;
                    }
                })
                ->addColumn('action', function ($post) use ($request) {
                    $btn = ' <a  href="/admin/blogs/' . $post->id . '"  name="info" id="' . $post->id . '" class=" my-1 info btn  btn-dark btn-sm">
                        View</a>';
                    // if ($request->user()->can('update', $post)) {
                    //     $btn .= ' <a  href="/admin/blogs/' . $post->id . '/edit "  name="edit" " class=" my-1 btn btn-warning btn-sm">
                    //         <i class="fas fa-edit text-white"></i></a>';
                    //     $btn .= ' <a  href="#"  name="delete" data-id="' . $post->id . '" class=" my-1 delete-post-btn info btn btn-danger btn-sm">
                    //         <i class="fa fa-trash"></i></a>';
                    // }
                    return $btn;
                })
                ->editColumn('published_at', function ($post) {
                    return $post->published_at !== null ? Carbon::parse($post->published_at)->format('Y-m-d ') : '';
                })
                ->rawColumns(['action', 'published_at', 'title'])
                ->make(true);
        }

        return view('posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $types = Type::query()->get();
        $tags = Tag::query()->get();
        $volumes = Volume::query()->get();
        $categories = Category::all();
        return view('posts.create', ['types' => $types, 'tags' => $tags, 'volumes' => $volumes, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'content' => 'required',
            'title' => 'required',
            'type' => 'required',
            'tags' => 'required',
            'published' => 'required',
            'description' => 'required|min:6|max:200',
            'featuredImage' => 'required|file|max:5120|mimes:jpeg,png,jpg,gif,svg|image',
        ]);
        if (!($request->type == PostType::Podcast)) {
            $request->validate([
                'category' => 'required'
            ], [
                'category.required' => 'Please Choose Category',
            ]);
        }
        if (!$request->hasFile('featuredImage')) {
            return back()->withErrors(['featuredImage' => 'Please Upload featured Image']);
        }
        if ($request->type == 2) {
            //if article type need to have volume
            $request->validate([
                'volume' => 'required'
            ]);
        }
        DB::beginTransaction();
        try {
            $filename = '';
            $slug = Str::slug($request->title);
            if ($request->file('featuredImage')) {
                $file = $request->file('featuredImage');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                // store in public directory
                $file->move(public_path('storage/uploads/featured'), $filename);
            }
            $post = Post::create([
                'author_id' => Auth::user()->id,
                'title' => $request->title,
                'content' => $request->content,
                'type_id' => $request->type,
                'description' => $request->description,
                'slug' => UUIDGenerate::slug($slug),
                'views' => 0,
                'category_id' => $request->category,
                'post_thumbnail' => $filename,
                'published' => $request->published,
                'published_at' => $request->published == 1 ? now() : null,
            ]);
            foreach ($request->tags as $tag) {
                PostTag::create([
                    'post_id' => $post->id,
                    'tag_id' => $tag,
                ]);
            }
            if ($request->type == 2) {
                //if article type need to have volume
                $post->update([
                    'volume_id' => $request->volume,
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
            DB::rollBack();
        }
        return redirect()->route('blogs.show', $post->id)->with(['success' => 'Successfully Added']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.detail', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        $post = Post::findOrFail($id);
        if ($request->user()->cannot('update', $post)) {
            return back()->with(['error' => "You can't update other author post."]);
            abort(403);
        }
        $types = Type::query()->get();
        $tags = Tag::query()->get();
        $volumes = Volume::query()->get();
        $categories = Category::all();
        return view('posts.edit', ['post' => $post, 'types' => $types, 'tags' => $tags, 'volumes' => $volumes, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $post = Post::findOrFail($id);

        $request->validate([
            'content' => 'required',
            'title' => 'required',
            'type' => 'required',
            'tags' => 'required',
            'published' => 'required',
            'description' => 'required|min:6|max:200',
        ]);
        if (!($request->type == PostType::Podcast)) {
            $request->validate([
                'category' => 'required'
            ], [
                'category.required' => 'Please Choose Category'
            ]);
        }
        if ($request->user()->cannot('update', $post)) {
            abort(403);
        }

        if ($request->type == 2) {
            //if article type need to have volume
            $request->validate([
                'volume' => 'required'
            ]);
        }
        DB::beginTransaction();
        try {
            $slug = Str::slug($request->title);
            $filename = $post->post_thumbnail;
            if ($request->hasFile('featuredImage')) {
                // fill လိုက်တယ်ဆိုမှ update ဖြစ်မှာ
                //  မ fill လိုက်ရင် အရင်ဟာပဲပြန်ထည့်မှာ
                try {
                    if ($request->file('featuredImage')) {
                        unlink(public_path('storage/uploads/featured') . '/' . $filename);
                        $file = $request->file('featuredImage');
                        $filename = date('YmdHi') . $file->getClientOriginalName();
                        $file->move(public_path('storage/uploads/featured'), $filename);
                    }
                } catch (Exception $e) {
                    if ($request->ajax()) {
                        return response()->json(['error' => $e->getMessage()]);
                    }
                    return back()->with(['error' => $e->getMessage()]);
                }
            }

            $post->update([
                'title' => $request->title,
                'slug' => UUIDGenerate::slug($slug),
                'content' => $request->content,
                'type_id' => $request->type,
                'description' => $request->description,
                'published' => $request->published,
                'post_thumbnail' => $filename,
                'category_id' => $request->type == PostType::Podcast ? null : $request->category,
                'published_at' => $request->published == 1 ? ($post->published == 1 ? $post->published_at : now()) : null,
            ]);
            if ($request->type == 2) {
                //if article type need to have volume
                $post->update([
                    'volume_id' => $request->volume,
                ]);
            }
            $post->tags()->detach();
            $post->tags()->sync($request->tags);

            CauserResolver::setCauser(Auth::user());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return back()->with(['error' => $e->getMessage()]);
        }
        return redirect()->route('blogs.show', $id)->with(['success' => 'Post Updated Successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //
        $post = Post::findOrFail($id);
        if ($request->user()->cannot('delete', $post)) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Permission Denied']);
            }
            abort(403);
        }
        try {
            unlink(public_path('storage/uploads/featured') . '/' . $post->post_thumbnail);
            $post->delete();
            CauserResolver::setCauser(Auth::user());
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()]);
            } else {
                return back()->with(['error' => $e->getMessage()]);
            }
        }
        if ($request->ajax()) {
            return response()->json(['success' => true, 'post' => $post]);
        }
        return redirect()->route('blogs.index')->with(['posts' => Post::query()->paginate(8), 'success' => "Successfully Deleted"]);
    }

    public function imageUpload(Request $request)
    {
        if ($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;

            //Upload File
            // $request->file('upload')->storeAs('public/uploads', $filenametostore);
            $request->file('upload')->storeAs('public/uploads/thumbnail', $filenametostore);

            $file = $request->file('upload');

            // store in public directory
            $file->move(public_path('storage/uploads/thumbnail/'), $filenametostore);

            echo json_encode([
                'default' => asset('storage/uploads/thumbnail/' . $filenametostore, true),
            ]);
        }
    }

    public function getUnpublishedPosts(Request $request)
    {
        if ($request->ajax()) {
            $posts = Post::with('author')->where('published_at', null);
            return datatables()->of($posts->get())
                ->addIndexColumn()
                ->addColumn('author', function (Post $post) {
                    if (!empty($post->author)) {
                        return $post->author->name;
                    }
                })
                ->addColumn('action', function ($post) use ($request) {
                    $btn = ' <a  href="/admin/blogs/' . $post->id . '"   id="' . $post->id . '" class=" btn-dark  info btn btn-info btn-sm">
                        View</a>';
                    // if ($request->user()->can('update', $post)) {
                    //     $btn .= ' <a  href="/admin/blogs/' . $post->id . '/edit "  name="edit" " class="   btn btn-warning btn-sm">
                    //         <i class="fas fa-edit text-white"></i></a>';
                    //     $btn .= ' <a  href="#"  name="delete" data-id="' . $post->id . '" class=" delete-post-btn info btn btn-danger btn-sm">
                    //         <i class="fa fa-trash"></i></a>';
                    // }
                    return $btn;
                })
                ->editColumn('created_at', function ($post) {
                    return $post->created_at !== null ? Carbon::parse($post->created_at)->format('Y-m-d ') : '';
                })
                ->editColumn('type_id', function ($post) {
                    switch ($post->type_id) {
                        case PostType::Article:
                            # code...
                            return 'Article';
                            break;
                        case PostType::Podcast:
                            # code...
                            return 'Podcast';
                            break;
                        case PostType::News:
                            # code...
                            return 'News';
                            break;
                        default:
                            # code...
                            return 'not_set';
                            break;
                    }
                })
                ->rawColumns(['action', 'published_at'])
                ->make(true);
        }
        return view('posts.unpublished',);
    }

    public function getPublishedPosts(Request $request)
    {
        if ($request->ajax()) {
            $posts = Post::with('author')->where('published_at', '!=', null);
            if (!empty($request->from_date)) {
                $posts = $posts
                    ->whereBetween('published_at', array($request->from_date, $request->to_date));
            }
            return datatables()->of($posts->get())
                ->addIndexColumn()
                ->addColumn('author', function (Post $post) {
                    if (!empty($post->author)) {
                        return $post->author->name;
                    }
                })
                ->addColumn('action', function ($post) use ($request) {
                    $btn = ' <a  href="/admin/blogs/' . $post->id . '"   id="' . $post->id . '" class=" btn-dark info btn btn-info btn-sm">
                    View</a>';
                    // if ($request->user()->can('update', $post)) {
                    //     $btn .= ' <a  href="/admin/blogs/' . $post->id . '/edit "  name="edit" " class="   btn btn-warning btn-sm">
                    //         <i class="fas fa-edit text-white"></i></a>';
                    //     $btn .= ' <a  href="#"  name="delete" data-id="' . $post->id . '" class=" delete-post-btn info btn btn-danger btn-sm">
                    //         <i class="fa fa-trash"></i></a>';
                    // }
                    return $btn;
                })
                ->editColumn('type_id', function ($post) {
                    switch ($post->type_id) {
                        case PostType::Article:
                            # code...
                            return 'Article';
                            break;
                        case PostType::Podcast:
                            # code...
                            return 'Podcast';
                            break;
                        case PostType::News:
                            # code...
                            return 'News';
                            break;
                        default:
                            # code...
                            return 'not_set';
                            break;
                    }
                })
                ->editColumn('published_at', function ($post) {
                    return $post->published_at !== null ? Carbon::parse($post->published_at)->format('Y-m-d ') : '';
                })
                ->rawColumns(['action', 'published_at'])
                ->make(true);
            // return $this->getJsonResponse($posts, $request);
        }

        return view('posts.published',);
    }
}
