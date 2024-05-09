<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Response;
use App\Models\TestSession;
use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $counts = DB::table('responses')
        ->select('test_sessions.id as test_session_id', DB::raw('COUNT(*) as total_correct_answers'))
        ->join('tests', 'responses.test_id', '=', 'tests.id')
        ->join('test_sessions', 'tests.test_session_id', '=', 'test_sessions.id')
        ->where('responses.correct', true)
        ->where('test_sessions.user_id', Auth::id())
        ->groupBy('test_sessions.id')
        ->get();

        $count_array = $counts->pluck('total_correct_answers')->toArray();
        $session_array = $counts->pluck('test_session_id')->toArray();
        $count = 0;
        $array = [];
        foreach($session_array as $item)
        {
            $count += 1;
            $array[] = 'Session - '.$count;
        }

        $bar = (new LarapexChart)->barChart()
            ->setTitle('Student test grades per session.')
            ->addData('Average', $count_array)
            ->setXAxis($array);

        return view('user.dashboard', [
            'bar' => $bar
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
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
