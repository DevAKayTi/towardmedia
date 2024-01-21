<?php

namespace App\Http\Controllers;

use App\Enums\PostType;
use App\Http\Requests\StoreVolumeRequest;
use App\Http\Requests\VolumeUpdateRequest;
use App\Models\Post;
use App\Models\Volume;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class VolumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $data = Volume::query()->with('author')
                    ->whereBetween('published_at', array($request->from_date, $request->to_date));
            } else {
                $data = Volume::query()->with('author');
            }
            return datatables()->of($data->get())
                ->addIndexColumn()
                ->addColumn('author', function (Volume $volume) {
                    if (!empty($volume->author)) {
                        return $volume->author->name;
                    }
                })
                ->addColumn('action', function ($volume) use ($request) {
                    $btn = ' <a  href="/admin/volumes/' . $volume->id . '"  name="info" id="' . $volume->id . '" class="  info my-1 btn btn-info btn-sm">
                <i class="text-white fa fa-eye "></i></a>';
                    if ($volume->author_id === Auth::user()->id || Auth::user()->id == 1) {
                        $btn .= ' <a  href="/admin/volumes/' . $volume->id . '/edit "  name="edit" " class="   my-1 btn btn-warning btn-sm">
                <i class="fas fa-edit text-white"></i></a>';
                        $btn .= ' <a  href="#"  name="delete" data-id="' . $volume->id . '" class=" delete-volume-btn info my-1 btn btn-danger btn-sm">
                <i class="fa fa-trash"></i></a>';
                    }
                    return $btn;
                })
                ->editColumn('created_at', function ($volume) {
                    return $volume->created_at !== null ? Carbon::parse($volume->created_at)->format('d-M-Y (g:i A)') : '';
                })
                ->editColumn('published_at', function ($volume) {
                    return $volume->published_at !== null ? Carbon::parse($volume->published_at)->format('d-M-Y (g:i A)') : '';
                })
                ->rawColumns(['action', 'published_at', 'created_at'])
                ->make(true);
        }

        return view('volumes.index')->with(['volumesCount' => Volume::query()->get()->count(),]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('volumes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVolumeRequest $request)
    {
        //
        try {
            $volume = Volume::create([
                'title' => $request->title,
                'author_id' => Auth::user()->id,
                'published' => $request->published,
                'published_at' => $request->published == 1 ? now() : null,
            ]);
            return redirect()->route('volumes.show', $volume->id);
        } catch (Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $volume = Volume::findOrFail($id);
        $articles = $volume->articles;
        if (request()->ajax()) {
            return response()->json(['articles' => $articles]);
        }
        return view('volumes.detail')->with(['volume' => $volume, 'articles' => $articles]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $volume = Volume::findOrFail($id);
        return view('volumes.edit', ['volume' => $volume]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VolumeUpdateRequest $request, $id)
    {
        //
        $volume = Volume::findOrFail($id);
        if ($volume->author_id !== Auth::user()->id && auth()->user()->role == 1) {
            return back()->with(['error' => "This user don't have permission to update"]);
        }
        $volume->update([
            'title' => $request->title,
            'published' => $request->published,
            'published_at' => $request->published == 0 ? null : ($volume->published_at == null ? Date::now() : $volume->published_at),
        ]);

        return redirect()->route('volumes.show', $volume->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //

        $volume = Volume::findOrFail($id);
        DB::beginTransaction();

        try {
            $volume->articles()->delete();
            $volume->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()]);
            } else {
                return back()->with(['error' => $e->getMessage()]);
            }
        }
        if ($request->ajax()) {

            if ($volume->author_id !== Auth::user()->id &&  Auth::user()->role == 1) {
                return response()->json(['error' => "You don't have permissions to delete."]);
            }
            return response()->json(['success' => true, 'post' => $volume]);
        }
    }

    public function articles(Request $request, $id)
    {

        if ($request->ajax()) {
            $data = Post::query()
                ->with('author')
                ->where('type_id', '=', PostType::Article)
                ->where('volume_id', $id)
                ->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('author', function (Post $post) {
                    if (!empty($post->author)) {
                        return $post->author->name;
                    }
                })
                ->addColumn('action', function ($post) use ($request) {
                    $btn = ' <a  href="/admin/blogs/' . $post->id . '"  name="info" id="' . $post->id . '" class=" my-1 info btn btn-info btn-sm">
                        <i class="text-white fa fa-eye "></i></a>';
                    if ($request->user()->can('update', $post)) {
                        $btn .= ' <a  href="/admin/blogs/' . $post->id . '/edit "  name="edit" " class=" my-1  btn btn-warning btn-sm">
                            <i class="fas fa-edit text-white"></i></a>';
                        $btn .= ' <a  href="#"  name="delete" data-id="' . $post->id . '" class=" my-1 delete-post-btn info btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i></a>';
                    }
                    return $btn;
                })
                ->editColumn('published_at', function ($post) {
                    return $post->published_at !== null ? Carbon::parse($post->published_at)->format('d-M-Y (g:i A)') : '';
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

        $a = Volume::findOrFail($id);

        return view('volumes.articles')->with(['articles' => $a->articles, 'volume' => $a]);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $posts
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function getJsonResponse(\Illuminate\Database\Eloquent\Builder $volumes, Request $request): \Illuminate\Http\JsonResponse
    {
        return datatables()->of($volumes)
            ->addIndexColumn()
            ->addColumn('author', function (Volume $volume) {
                if (!empty($volume->author)) {
                    return $volume->author->name;
                }
            })
            ->addColumn('action', function ($volume) use ($request) {
                $btn = ' <a  href="/admin/volumes/' . $volume->id . '"  name="info" id="' . $volume->id . '" class="  info btn btn-info btn-sm">
                <i class="text-white fa fa-eye "></i></a>';
                if ($volume->author_id === Auth::user()->id || Auth::user()->id == 1) {
                    $btn .= ' <a  href="/admin/volumes/' . $volume->id . '/edit "  name="edit" " class="   btn btn-warning btn-sm">
                <i class="fas fa-edit text-white"></i></a>';
                    $btn .= ' <a  href="#"  name="delete" data-id="' . $volume->id . '" class=" delete-volume-btn info btn btn-danger btn-sm">
                <i class="fa fa-trash"></i></a>';
                }
                return $btn;
            })
            ->editColumn('created_at', function ($volume) {
                return $volume->created_at !== null ? Carbon::parse($volume->created_at)->format('d-M-Y (g:i A)') : '';
            })
            ->editColumn('published_at', function ($volume) {
                return $volume->published_at !== null ? Carbon::parse($volume->published_at)->format('d-M-Y (g:i A)') : '';
            })
            ->rawColumns(['action', 'published_at', 'created_at'])
            ->make(true);
    }
}
