<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use App\Http\Requests\StoreAuthorRequest;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        //
        if ($request->user()->cannot('view', Auth::user())) {
            abort(403);
        }
        if ($request->ajax()) {
            $authors = User::query()->where('role', UserRoleType::Author);
            // $authors = User::query();
            return Datatables::of($authors)
                ->addIndexColumn()
                ->editColumn('role', function ($author) {
                    if ($author->role === UserRoleType::Author) {
                        return 'Author';
                    }
                    if ($author->role === UserRoleType::Admin) {
                        return 'Admin';
                    }
                    return '';
                })
                ->editColumn('status', function ($author) {
                    if ($author->status == UserStatusType::Active) {
                        $status = "<div class='form-check form-switch'>
                        <input class='form-check-input user-status-toggle-button ' type='checkbox' data-id='" . $author->id . "'   checked >
                      </div>";
                    } else {
                        $status = "<div class='form-check form-switch'>
                        <input class='form-check-input user-status-toggle-button ' type='checkbox' data-id='" . $author->id . "'   >
                      </div>";
                    }
                    return $status;
                })
                ->addColumn('action', function ($author) use ($request) {
                    $btn = ' <a  href="/admin/authors/' . $author->id . '"  name="info" id="' . $author->id . '" class="  info btn btn-info btn-sm btn-dark ">
                    View</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('authors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Request $request)
    {
        //
        if ($request->user()->cannot('create', Auth::user())) {
            abort(403);
        }
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(StoreAuthorRequest $request): RedirectResponse
    {
        //
        try {
            $data = $request->validated();
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'password' => Hash::make($data['password']),
                'status' => 1
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
        return redirect()->route('authors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //

        $author = User::findOrFail($id);
        if ($request->user()->cannot('view', $author)) {
            abort(403);
        }
        return view('authors.detail')->with(['author' => $author]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        //
        $author = User::findOrFail($id);

        if ($request->user()->cannot('update', $author)) {
            return abort(403);
        }
        return view('authors.edit')->with(['author' => $author]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $author = User::findOrFail($id);

        if ($request->user()->cannot('update', $author)) {
            return abort(403);
        }
        $request->validate([
            'name' => 'required|min:3|max:20',
            'email' => "email|unique:users,email,$id,id",
            'role' => 'required',
        ], [
            'name.required' => 'Please Fill Name',
            'email.required' => 'Please Fill Email',
            'role.required' => 'Please Select Role',
        ]);
        try {
            DB::beginTransaction();
            $author->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);
            DB::commit();
            return redirect()->route('authors.show', $id);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
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
        if ($request->ajax()) {
            try {
                User::findOrFail($id)->delete();
                return response()->json(['success' => true]);
            } catch (Exception $e) {
                if ($request->ajax()) {
                    return response()->json(['error' => $e->getMessage()]);
                }
                return back()->with(['error' => $e->getMessage()]);
                //throw $th;
            }
        }
    }

    public function showPosts(Request $request, $id)
    {
        if ($request->user()->cannot('update', User::find($id))) {
            abort(403);
        }
        if ($request->ajax()) {
            $posts = Post::with('author')->where('author_id', $id);
            return Datatables::of($posts)
                ->addIndexColumn()
                ->addColumn('author', function (Post $post) {
                    return $post->author->name;
                })
                ->addColumn('action', function ($post) {
                    $btn = ' <a  href="/admin/blogs/' . $post->id . '"  name="info" id="' . $post->id . '" class="  info btn btn-info btn-sm">
                    <i class=" text-white fa  fa-eye "></i></a>';
                    $btn .= ' <a  href="/admin/blogs/' . $post->id . '/edit "  name="edit" " class="   btn btn-warning btn-sm">
                    <i class=" text-white fa  fa-edit"></i></a>';
                    $btn .= ' <a  href="#"  name="delete" data-id="' . $post->id . '" class=" delete-post-btn info btn btn-danger btn-sm">
                    <i class=" text-white fa  fa-trash"></i></a>';
                    return $btn;
                })
                ->editColumn('published_at', function ($post) {
                    return Carbon::parse($post->published_at)->format('d-M-Y (g:i A)') . '   ' . '<span class=" fs-6 text-info">' . Carbon::parse($post->published_at)->diffForHumans() . '</span>';
                })
                ->rawColumns(['action', 'published_at'])
                ->make(true);
        }
        return view('authors.posts')->with(['author' => User::findOrFail($id)]);
    }

    public function showPasswordResetForm($authorId)
    {
        $author = User::find($authorId);

        if (Auth::user()->cannot('update', $author)) {
            abort(403);
        }
        return view('authors.passwordReset')->with(['author' => $author]);
    }

    public function passwordReset($authorId, Request $request)
    {
        $author = User::find($authorId);

        if ($request->user()->cannot('update', $author)) {
            abort(403);
        }
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|max:20|confirmed',
            'password_confirmation' => 'required'
        ]);

        $author->update([
            'password' => Hash::make($request->password),
            'ip' => null,
            'logined_at' => null,
        ]);

        return redirect()->route('authors.show', $authorId);
    }

    public function showActivities($id)
    {
        $author = User::findOrFail($id);
        $actions = $author->actions()->orderBy('updated_at', 'desc')->paginate(10);
        return view('authors.activities', ['author' => $author, 'actions' => $actions]);
    }

    public function changeStatus(Request $request)
    {

        if ($request->ajax()) {
            try {
                $user =  User::where('id', $request->id)->get()->first();
                $user->update([
                    'status' => $user->status == UserStatusType::Active ? UserStatusType::Inactive : UserStatusType::Active,
                ]);
                return response()->json(['success' =>  $request->id]);
            } catch (Exception $e) {
                if ($request->ajax()) {
                    return response()->json(['error' => $e->getMessage()]);
                }
                return back()->with(['error' => $e->getMessage()]);
            }
        }
    }
}
