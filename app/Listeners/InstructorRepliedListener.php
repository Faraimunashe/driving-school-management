<?php

namespace App\Listeners;

use App\Events\InstructorReplied;
use App\Models\Student;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Twilio\Rest\Client;

class InstructorRepliedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InstructorReplied $event): void
    {
        $booking = $event->booking;
        $message = "DRIVING LESSON BOOKING ALERT\n";
        $message = $message . "ON: ".$booking->date."\n";
        $message = $message . "FROM: ".$booking->start_time."\n";
        $message = $message . "TO: ".$booking->end_time."\n";
        $message = "STATUS: ".$booking->status;

        $sid = getenv("TWILIO_AUTH_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        //$twilio = new Client($sid, $token);

        $student = Student::find($booking->student_id);
        if (is_null($student)) {
            return;
        }

        $number = $student->phone;
        $internationalNumber = "+263" . substr($number, 1);
        //$internationalNumber = preg_replace('/^0/', '+263', $number);

        $client = new Client($sid, $token);
        $client->messages->create($internationalNumber, [
            'from' => getenv("TWILIO_WHATSAPP_FROM"),
            'body' => $message
        ]);
    }
}
