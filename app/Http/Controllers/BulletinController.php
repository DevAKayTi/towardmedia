<?php

namespace App\Http\Controllers;

use App\Enums\PostType;
use App\Http\Requests\StoreBulletinRequest;
use App\Http\Requests\BulletinUpdateRequest;
use App\Models\Post;
use App\Models\Bulletin;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class BulletinController extends Controller
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
                $data = Bulletin::query()->with('author')
                    ->whereBetween('published_at', array($request->from_date, $request->to_date));
            } else {
                $data = Bulletin::query()->with('author');
            }
            return datatables()->of($data->get())
                ->addIndexColumn()
                ->addColumn('author', function (Bulletin $bulletin) {
                    if (!empty($bulletin->author)) {
                        return $bulletin->author->name;
                    }
                })
                ->addColumn('action', function ($bulletin) use ($request) {
                    $btn = ' <a  href="/admin/bulletins/' . $bulletin->id . '"  name="info" id="' . $bulletin->id . '" class="  info my-1 btn btn-info btn-sm">
                <i class="text-white fa fa-eye "></i></a>';
                    if ($bulletin->author_id === Auth::user()->id || Auth::user()->id == 1) {
                        $btn .= ' <a  href="/admin/bulletins/' . $bulletin->id . '/edit "  name="edit" " class="   my-1 btn btn-warning btn-sm">
                <i class="fas fa-edit text-white"></i></a>';
                        $btn .= ' <a  href="#"  name="delete" data-id="' . $bulletin->id . '" class=" delete-bulletin-btn info my-1 btn btn-danger btn-sm">
                <i class="fa fa-trash"></i></a>';
                    }
                    return $btn;
                })
                ->editColumn('created_at', function ($bulletin) {
                    return $bulletin->created_at !== null ? Carbon::parse($bulletin->created_at)->format('d-M-Y (g:i A)') : '';
                })
                ->editColumn('published_at', function ($bulletin) {
                    return $bulletin->published_at !== null ? Carbon::parse($bulletin->published_at)->format('d-M-Y (g:i A)') : '';
                })
                ->rawColumns(['action', 'published_at', 'created_at'])
                ->make(true);
        }

        return view('bulletins.index')->with(['bulletinsCount' => Bulletin::query()->get()->count(),]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('bulletins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBulletinRequest $request)
    {
        //
        try {
            $bulletin = Bulletin::create([
                'title' => $request->title,
                'author_id' => Auth::user()->id,
                'published' => $request->published,
                'published_at' => $request->published == 1 ? now() : null,
            ]);
            return redirect()->route('bulletins.show', $bulletin->id);
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
        $bulletin = Bulletin::findOrFail($id);
        $articles = $bulletin->articles;
        if (request()->ajax()) {
            return response()->json(['articles' => $articles]);
        }
        return view('bulletins.detail')->with(['bulletin' => $bulletin, 'articles' => $articles]);
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
        $bulletin = Bulletin::findOrFail($id);
        return view('bulletins.edit', ['bulletin' => $bulletin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BulletinUpdateRequest $request, $id)
    {
        //
        $bulletin = Bulletin::findOrFail($id);
        if ($bulletin->author_id !== Auth::user()->id && auth()->user()->role == 1) {
            return back()->with(['error' => "This user don't have permission to update"]);
        }
        $bulletin->update([
            'title' => $request->title,
            'published' => $request->published,
            'published_at' => $request->published == 0 ? null : ($bulletin->published_at == null ? Date::now() : $bulletin->published_at),
        ]);
        return redirect()->route('bulletins.show', $bulletin->id);
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

        $bulletin = Bulletin::findOrFail($id);
        DB::beginTransaction();

        try {
            $bulletin->articles()->delete();
            $bulletin->delete();
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

            if ($bulletin->author_id !== Auth::user()->id &&  Auth::user()->role == 1) {
                return response()->json(['error' => "You don't have permissions to delete."]);
            }
            return response()->json(['success' => true, 'post' => $bulletin]);
        }
    }

    public function articles(Request $request, $id)
    {

        if ($request->ajax()) {
            $data = Post::query()
                ->with('author')
                ->where('type_id', '=', PostType::Article)
                ->where('bulletin_id', $id)
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
                        case PostType::News_Article:
                            # code...
                            return 'News_Article';
                            break;
                        case PostType::Podcast:
                            # code...
                            return 'Podcast';
                            break;
                        case PostType::Newsletter:
                            # code...
                            return 'Newsletter';
                            break;
                        case PostType::Newsbulletin:
                            # code...
                            return 'Newsbulletin';
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

        $a = Bulletin::findOrFail($id);

        return view('bulletins.articles')->with(['articles' => $a->articles, 'bulletin' => $a]);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $posts
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function getJsonResponse(\Illuminate\Database\Eloquent\Builder $bulletins, Request $request): \Illuminate\Http\JsonResponse
    {
        return datatables()->of($bulletins)
            ->addIndexColumn()
            ->addColumn('author', function (Bulletin $bulletin) {
                if (!empty($bulletin->author)) {
                    return $bulletin->author->name;
                }
            })
            ->addColumn('action', function ($bulletin) use ($request) {
                $btn = ' <a  href="/admin/bulletins/' . $bulletin->id . '"  name="info" id="' . $bulletin->id . '" class="  info btn btn-info btn-sm">
                <i class="text-white fa fa-eye "></i></a>';
                if ($bulletin->author_id === Auth::user()->id || Auth::user()->id == 1) {
                    $btn .= ' <a  href="/admin/bulletins/' . $bulletin->id . '/edit "  name="edit" " class="   btn btn-warning btn-sm">
                <i class="fas fa-edit text-white"></i></a>';
                    $btn .= ' <a  href="#"  name="delete" data-id="' . $bulletin->id . '" class=" delete-bulletin-btn info btn btn-danger btn-sm">
                <i class="fa fa-trash"></i></a>';
                }
                return $btn;
            })
            ->editColumn('created_at', function ($bulletin) {
                return $bulletin->created_at !== null ? Carbon::parse($bulletin->created_at)->format('d-M-Y (g:i A)') : '';
            })
            ->editColumn('published_at', function ($bulletin) {
                return $bulletin->published_at !== null ? Carbon::parse($bulletin->published_at)->format('d-M-Y (g:i A)') : '';
            })
            ->rawColumns(['action', 'published_at', 'created_at'])
            ->make(true);
    }
}
