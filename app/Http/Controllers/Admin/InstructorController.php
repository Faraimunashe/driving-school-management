<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $instructors = Instructor::paginate(10);
        $search = $request->search;
        if(isset($search))
        {
            $instructors = Instructor::where('fname', 'LIKE', '%'.$search.'%')
            ->orWhere('lname', 'LIKE', '%'.$search.'%')
            ->paginate(10);
        }

        return view('admin.instuctors', [
            'instructors' => $instructors
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
                'fname' => ['required', 'alpha'],
                'lname' => ['required', 'alpha'],
                'gender' => ['required', 'string'],
                'class' => ['required', 'integer', 'min:0', 'max:5'],
                'phone' => ['required', 'regex:/^7[1378][0-9]{7}$/'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->lname.$request->fname[0],
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->addRole('instructor');

            $instructor = new Instructor();
            $instructor->user_id = $user->id;
            $instructor->fname = $request->fname;
            $instructor->lname = $request->lname;
            $instructor->class = $request->class;
            $instructor->gender = $request->gender;
            $instructor->phone = $request->phone;
            $instructor->save();

            return redirect()->back()->with('success', 'Instructor added successfully');
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
