<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Response;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $request->validate([
                'test_id' => ['required', 'integer']
            ]);

            $count = Response::where('test_id', $request->test_id)->count();
            if($count >= 3)
            {
                $test = Test::find($request->test_id);
                return redirect()->route('test-sessions.show', $test->test_session_id)->with('success', 'Thank you for completing the test');
            }

            $test_id = $request->test_id;
            $question = Question::whereNotIn('id', function ($query) use ($test_id) {
                $query->select('question_id')
                      ->from('responses')
                      ->where('test_id', $test_id);
              })
            ->inRandomOrder()
            ->first();

            $answers = Answer::where('question_id', $question->id)->get();

            return view('user.responses', [
                'question' => $question,
                'answers' => $answers,
                'test_id' => $test_id
            ]);
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        try{
            $request->validate([
                'test_id' => ['required', 'integer'],
                'question_id' => ['required', 'integer'],
                'answer_id' => ['required', 'integer']
            ]);

            $count = Response::where('test_id', $request->test_id)->count();
            if($count < 3)
            {
                $answer = Answer::find($request->answer_id);

                $res = new Response();
                $res->test_id = $request->test_id;
                $res->question_id = $request->question_id;
                $res->answer_id = $request->answer_id;
                $res->correct = $answer->correct;
                $res->save();

                return redirect()->route('responses.index', ['test_id' => $request->test_id])->with('success', 'Answer was saved successfully');
            }else{
                $test = Test::find($request->test_id);
                return redirect()->route('test-sessions.show', $test->test_session_id)->with('error', 'You have answered the maximum number of questions per test.');
            }

        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
