<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    //

    public function index()
    {
        $actions = auth()->user()->actions()->orderBy('created_at', 'desc')->paginate(10);
        return view('activities.index')->with(['actions' => $actions]);
    }

    public function show($id, Request $request)
    {
        try {
            $activity = Activity::where('id', '=', $id)->with('subject')->firstOrFail();
            $deleted = null;
            if ($activity->event === 'deleted') {
                $deleted = $activity->properties['old'];
            }

            if ($request->ajax()) {
                return response()->json(['success' => true, 'activity' => $activity, 'deletedItem' => $deleted, 'ip' => Auth::user()->ip]);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
        return view('activities.detail')->with(['activity' => $activity, 'deletedPost' => $deleted, 'ip' => Auth::user()->ip]);
    }
}
