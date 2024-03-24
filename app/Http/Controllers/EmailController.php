<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Subscriber;
use Carbon\Carbon;
use Exception;


class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $emails = Subscriber::query()
                    ->whereBetween('published_at', array($request->from_date, $request->to_date))->get();
            } else {
                $emails = Subscriber::query()->get();
            }
            return datatables()->of($emails)
                ->addIndexColumn()
                ->editColumn('is_activated', function ($email) {
                    switch ($email->is_activated) {
                        case 0:
                            # code...
                            return 'False';
                            break;
                        case 1:
                            # code...
                            return 'True';
                            break;
                    }
                })
                ->editColumn('created_at', function ($email) {
                    return $email->created_at !== null ? Carbon::parse($email->created_at)->format('d-M-Y (g:i A)') : '';
                })
                ->addColumn('action', function ($email) use ($request) {
                //     $btn = ' <a  href="/admin/emails/' . $email->email . '"  name="info" id="' . $email->email . '" class="  info my-1 btn btn-info btn-sm">
                // <i class="text-white fa fa-eye "></i></a>';
                    $btn = ' <a  href="#"  name="edit" data-id="' . $email->id . '" " class=" edit-email-btn my-1 btn btn-warning btn-sm">
                <i class="fas fa-edit text-white"></i></a>';
                        $btn .= ' <a  href="#"  name="delete" data-id="' . $email->id . '" class=" delete-email-btn info my-1 btn btn-danger btn-sm">
                <i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','created_at'])
                ->make(true);
        }

        return view('emails.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $email = Subscriber::findOrFail($id);
        if($email->is_activated){
            $status = 0;
        }else{
            $status = 1;
        }
        DB::beginTransaction();

        try {
            $email->update([
                'is_activated' => $status,
            ]);
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
            return response()->json(['success' => true, 'post' => $email]);
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

        $email = Subscriber::findOrFail($id);
        DB::beginTransaction();

        try {
            $email->delete();
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
            return response()->json(['success' => true, 'post' => $email]);
        }
        
    }
}
