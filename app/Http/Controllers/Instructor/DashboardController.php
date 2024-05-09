<?php

namespace App\Http\Controllers\Instructor;

use App\Events\InstructorReplied;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public $start_time, $end_time;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bookings = Booking::join('students', 'students.id', '=', 'bookings.student_id')
            ->join('instructors', 'instructors.id', '=', 'bookings.instructor_id')
            ->select('bookings.id', 'bookings.date', 'bookings.start_time', 'bookings.end_time', 'bookings.status', 'students.fname as student_fname', 'students.lname as student_lname', 'instructors.fname as instructor_fname', 'instructors.lname as instructor_fname')
            ->get();

        $search = $request->search;
        if(isset($search))
        {
            $bookings = Booking::join('students', 'students.id', '=', 'bookings.student_id')
            ->join('instructors', 'instructors.id', '=', 'bookings.instructor_id')
            ->select('bookings.id', 'bookings.date', 'bookings.start_time', 'bookings.end_time', 'bookings.status', 'students.fname as student_fname', 'students.lname as student_lname', 'instructors.fname as instructor_fname', 'instructors.lname as instructor_fname')
            ->where('students.fname', 'LIKE', '%'.$search.'%')
            ->orWhere('students.lname', 'LIKE', '%'.$search.'%')
            ->get();
        }

        return view('instructor.dashboard', [
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
                'booking_id' => ['required', 'integer'],
                'status' => ['required', 'alpha']
            ]);

            $booking = Booking::find($request->booking_id);
            $this->start_time = $booking->start_time;
            $this->end_time = $booking->end_time;

            $count = Booking::where('date', $booking->date)
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('start_time', '>=', $this->start_time)
                        ->where('start_time', '<', $this->end_time);
                })
                ->orWhere(function ($q) {
                    $q->where('start_time', '<=', $this->start_time)
                        ->where('end_time', '>', $this->start_time);
                });
            })
            ->where('status', 'APPROVED')
            ->count();

            if($count != 0)
            {
                $booking->status = 'REJECTED';
                $booking->save();
                return redirect()->back()->with('error', 'This booking is overlaping into approved booking time slot.');
            }

            $booking->status = $request->status;
            $booking->save();

            event(new InstructorReplied($booking));

            return redirect()->back()->with('success', 'Booking updated successfully');
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
