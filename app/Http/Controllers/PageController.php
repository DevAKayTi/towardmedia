<?php

namespace App\Http\Controllers;

use App\Enums\PostType;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Models\Volume;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Str;

class PageController extends Controller
{
    //
    public function getActivities()
    {
        return Auth::user()->actions()->where('log_name', 'post')->first()->subject;
    }


    public function storeTagWithAjax(Request $request)
    {
        if ($request->ajax()) {
            if ($request->tag) {
                try {
                    $tag = Tag::create([
                        'name' => $request->tag,
                        'slug' => Str::slug($request->tag),
                    ]);
                    return response()->json(['success' => true, 'id' => $tag->id]);
                } catch (\Throwable $th) {
                    return response()->json(['error' => $th]);
                }
            }
        }
    }

    public function createDynamicVolumeWithAjax(Request $request)
    {
        if ($request->ajax()) {
            if ($request->volume) {
                try {
                    $volume = Volume::create([
                        'title' => $request->volume,
                        'author_id' => Auth::user()->id,
                        'created_at' => Date::now(),
                        'published_at' => Date::now(),
                    ]);
                    return response()->json(['success' => true, 'id' => $volume->id]);
                } catch (Exception $e) {
                    return response()->json(['error' => $e->getMessage()]);
                }
            }
        }
    }

    public function passwordChange(PasswordChangeRequest $request)
    {
        $user = User::where('email', '=', $request->email)->get()->first();
        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            return back()->with(['success' => 'Password Upated Successfully']);
        }
    }

    public function profile()
    {
        return view('profile');
    }

    public function updateProfile(ProfileUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $user = User::query()->where('id', $id)->firstOrFail();
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        return redirect()->route('profile')->with(['success' => 'Successfully updated']);
    }

    public function posts(Request $request, $id)
    {
        try {
            if (request()->ajax()) {
                $posts = Post::query()->with('author')->where('author_id', $id)->get();
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
                        $btn = ' <a  href="/admin/blogs/' . $post->id . '"  name="info" id="' . $post->id . '" class=" my-1 info btn btn-info btn-sm">
                        <i class="text-white fa fa-eye "></i></a>';
                        if ($request->user()->can('update', $post)) {
                            $btn .= ' <a  href="/admin/blogs/' . $post->id . '/edit "  name="edit" " class=" my-1 btn btn-warning btn-sm">
                                <i class="fas fa-edit text-white"></i></a>';
                            $btn .= ' <a  href="#"  name="delete" data-id="' . $post->id . '" class=" my-1 delete-post-btn info btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i></a>';
                        }
                        return $btn;
                    })

                    ->editColumn('published_at', function ($post) {
                        return $post->published_at !== null ? Carbon::parse($post->published_at)->format('Y-m-d ') : '';
                    })
                    ->rawColumns(['action', 'published_at', 'title'])
                    ->make(true);
            }
            return view('posts');
        } catch (Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
