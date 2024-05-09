<?php

namespace App\Listeners;

use App\Events\StudentBooked;
use App\Models\Instructor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Twilio\Rest\Client;

class StudentBookedListener
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
    public function handle(StudentBooked $event): void
    {
        $booking = $event->booking;
        $message = "DRIVING LESSON BOOKING ALERT\n";
        $message = $message . "ON ".$booking->date."\n";
        $message = $message . "FROM ".$booking->start_time."\n";
        $message = $message . "TO ".$booking->end_time."\n";

        $sid = getenv("TWILIO_AUTH_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        //$twilio = new Client($sid, $token);

        $instructor = Instructor::find($booking->instructor_id);
        if (is_null($instructor)) {
            return;
        }

        $number = $instructor->phone;
        $internationalNumber = "+263" . $number;
        //$internationalNumber = preg_replace('/^0/', '+263', $number);

        $client = new Client($sid, $token);
        $client->messages->create($internationalNumber, [
            'from' => getenv("TWILIO_WHATSAPP_FROM"),
            'body' => $message
        ]);
    }
}
