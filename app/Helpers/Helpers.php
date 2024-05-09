<?php
use App\Models\Recommend;
use Illuminate\Support\Facades\DB;

function recommend_student()
{
    $count = DB::table('responses')
        ->select('test_sessions.id as test_session_id', DB::raw('COUNT(*) as total_correct_answers'))
        ->join('tests', 'responses.test_id', '=', 'tests.id')
        ->join('test_sessions', 'tests.test_session_id', '=', 'test_sessions.id')
        ->where('responses.correct', true)
        ->where('test_sessions.user_id', Auth::id())
        ->groupBy('test_sessions.id')
        ->orderByDesc('total_correct_answers')
        ->first();

    if(is_null($count))
    {
        return;
    }

    $percentage = (9/$count->total_correct_answers)*100;

    //dd($percentage);

    if($percentage > 89)
    {
        $recommend = Recommend::where('user_id', Auth::id())->first();
        if(is_null($recommend))
        {
            $recommend = new Recommend();
            $recommend->user_id = Auth::id();
            $recommend->approved_by = 100;
            $recommend->save();
        }
    }

    return;
}


function best_score()
{
    $percentage = 0;
    $count = DB::table('responses')
        ->select('test_sessions.id as test_session_id', DB::raw('COUNT(*) as total_correct_answers'))
        ->join('tests', 'responses.test_id', '=', 'tests.id')
        ->join('test_sessions', 'tests.test_session_id', '=', 'test_sessions.id')
        ->where('responses.correct', true)
        ->where('test_sessions.user_id', Auth::id())
        ->groupBy('test_sessions.id')
        ->orderByDesc('total_correct_answers')
        ->first();

    if(!is_null($count))
    {
        $percentage = (9/$count->total_correct_answers)*100;
        return $percentage;
    }

    return $percentage;
}
