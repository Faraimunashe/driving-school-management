<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $questions = Question::paginate(10);
        $search = $request->search;
        if(isset($search))
        {
            $questions = Question::where('description', 'LIKE', '%'.$search.'%')
            ->paginate(10);
        }

        return view('admin.questions', [
            'questions' => $questions
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
        try{
            $request->validate([
                'description' => ['required', 'string'],
                'answer_1' => ['required', 'string'],
                'answer_2' => ['required', 'string'],
                'correct_answer' => ['required', 'string'],
            ]);

            $filename = '';
            if(isset($request->picture)){
                $request->validate([
                    'picture' => ['required', 'file', 'mimes:png,jpeg,jpg']
                ]);
                $file = $request->file('picture');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $request->picture->move(public_path('images/answers'), $filename);
            }

            $question = new Question();
            $question->description = $request->description;
            if(isset($request->picture))
            {
                $question->picture = $filename;
            }
            $question->save();

            $ans1 = new Answer();
            $ans1->question_id = $question->id;
            $ans1->description = $request->answer_1;
            $ans1->save();

            $ans2 = new Answer();
            $ans2->question_id = $question->id;
            $ans2->description = $request->answer_2;
            $ans2->save();

            $correct_ans = new Answer();
            $correct_ans->question_id = $question->id;
            $correct_ans->description = $request->correct_answer;
            $correct_ans->correct = true;
            $correct_ans->save();

            return redirect()->back()->with('success', 'Question added successfully');
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
        try{
            $question = Question::find($id);
            $answers = Answer::where('question_id', $question->id)->get();

            return view('admin.show-question', [
                'question' => $question,
                'answers' => $answers
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
