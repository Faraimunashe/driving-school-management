<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class TestSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessions = TestSession::where('test_sessions.user_id', Auth::id())->latest()->get();
        return view('user.test-sessions', [
            'sessions' => $sessions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $test_sessions = TestSession::leftJoin('tests', 'test_sessions.id', '=', 'tests.test_session_id')
        ->select('test_sessions.*', DB::raw('count(tests.id) as test_count'))
        ->where('test_sessions.user_id', Auth::id())
        ->groupBy('test_sessions.id')
        //->having('test_count', '<', 3)
        ->get();

        //dd($test_sessions);

        if($test_sessions->isEmpty())
        {
            $test_session = new TestSession();
            $test_session->user_id = Auth::id();
            $test_session->save();

            return redirect()->back()->with('success', 'Test Session created successfully');
        }

        $create = true;
        foreach($test_sessions as $item)
        {
            if($item->test_count < 3)
            {
                $create = false;
            }
        }

        if($create)
        {
            $test_session = new TestSession();
            $test_session->user_id = Auth::id();
            $test_session->save();

            return redirect()->back()->with('success', 'Test Session created successfully');
        }

        return redirect()->back()->with('error', 'There are incomplete test sessions that need to be done first');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $test_session = TestSession::find($id);
            $tests = Test::where('test_session_id', $test_session->id)->get();

            return view('user.tests', [
                'ses' => $test_session,
                'tests' => $tests
            ]);
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
