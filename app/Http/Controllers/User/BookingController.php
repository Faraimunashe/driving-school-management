<?php

namespace App\Http\Controllers\User;

use App\Events\StudentBooked;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Student::where('user_id', Auth::id())->first();
        $bookings = Booking::join('instructors', 'instructors.id', '=', 'bookings.instructor_id')
        ->select('bookings.id', 'bookings.date', 'bookings.start_time', 'bookings.end_time', 'bookings.status', 'instructors.fname', 'instructors.lname')
        ->where('bookings.student_id', $student->id)
        ->get();

        return view('user.bookings', [
            'bookings' => $bookings
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
                'instructor_id' => ['required', 'integer'],
                'date' => ['required', 'date', 'after_or_equal:today'],
                'start_time' => ['required', 'date_format:H:i'],
                'end_time' => ['required', 'date_format:H:i', 'after:start_time']
            ]);

            $startTimeObject = Carbon::createFromFormat('H:i', $request->start_time);

            $today = now()->format('Y-m-d');
            if($request->date == $today){
                if (!$startTimeObject->isAfter(now())) {
                    return redirect()->back()->with('error','The specified start time has lapsed.');
                }
            }

            $student = Student::where('user_id', Auth::id())->first();

            $booking = new Booking();
            $booking->student_id = $student->id;
            $booking->instructor_id = $request->instructor_id;
            $booking->date = $request->date;
            $booking->start_time = $request->start_time;
            $booking->end_time = $request->end_time;
            $booking->status = "PENDING";
            $booking->save();

            event(new StudentBooked($booking));

            return redirect()->back()->with('success', 'Booking sent successfully');

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
        try{
            $booking = Booking::find($id);
            $booking->save();

            return redirect()->back()->with('success', 'Booking deleted successfully');

        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
