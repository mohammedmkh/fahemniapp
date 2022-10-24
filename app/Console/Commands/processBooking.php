<?php

namespace App\Console\Commands;

use App\Booking;
use App\Devicetoken;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;
class processBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:processBooking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        DB::table('cronjob')->insert([
            'created_at' => Carbon::now()->toDateTimeString() ,
            'booking_id' => 3 ,
            'type' => 'remind before hour  mm mtest cron job'
        ]);
        $time = Carbon::now()->subMinutes(5)->toTimeString();
        $now_time = Carbon::now()->toTimeString();
        $date = Carbon::now()->toDateString();

        $bookings = Booking::where('date' , $date)->where('remind_notif' , 0)->get();

        foreach ($bookings as $booking){
            $diff=  Carbon::now()->diffInMinutes( $booking->times->time->time ) ;
            if($diff < 120){
                // send FCM  To Student And Tutor
                $user_id = $booking['tutor_id'];
                $tokens = Devicetoken::where('user_id', $user_id)->first();
                $title = ' لديك حجز قريبا ';
                $body = 'هناك حجز لديك مع طالب موعده بعد ساعتين تقريبا';
                $data['action_type'] = 'remind';
                $data['action_id'] = $booking->id;
                $data['user_id'] = $user_id;
                $data['date'] = Carbon::now()->timestamp;
                $data['title'] = $title;
                $data['body'] = $body;
                sendFCM($title, $body, $data, $tokens, 1, 1);

                $user_id = $booking['user_id'];
                $tokens = Devicetoken::where('user_id', $user_id)->first();
                $title = ' لديك حجز قريبا ';
                $body = ' هناك حجز لديك  موعده بعد ساعتين تقريبا ';
                $data['action_type'] = 'remind';
                $data['action_id'] = $booking->id;
                $data['user_id'] = $user_id;
                $data['date'] = Carbon::now()->timestamp;
                $data['title'] = $title;
                $data['body'] = $body;
                sendFCM($title, $body, $data, $tokens, 1, 1);

                $booking ->remind_notif = 1 ;
                $booking->save();


                DB::table('cronjob')->insert([
                    'created_at' => Carbon::now()->toDateTimeString() ,
                    'booking_id' => $booking ->id ,
                    'type' => 'remind before 2 hour'
                ]);

            }
        }



        $bookings = Booking::where('date' , $date)->where('remind_notif' , ١)->get();

        foreach ($bookings as $booking){
            $diff=  Carbon::now()->diffInMinutes( $booking->times->time->time ) ;
            if($diff < 16){
                // send FCM  To Student And Tutor
                $user_id = $booking['tutor_id'];
                $tokens = Devicetoken::where('user_id', $user_id)->first();
                $title = ' لديك حجز قريبا ';
                $body = 'هناك حجز لديك سيبدا بعد قليل';
                $data['action_type'] = 'remind';
                $data['action_id'] = $booking->id;
                $data['user_id'] = $user_id;
                $data['date'] = Carbon::now()->timestamp;
                $data['title'] = $title;
                $data['body'] = $body;
                sendFCM($title, $body, $data, $tokens, 1, 1);

                $user_id = $booking['user_id'];
                $tokens = Devicetoken::where('user_id', $user_id)->first();
                $title = ' لديك حجز قريبا ';
                $body = ' هناك حجز لديك  موعده بعد قليل ';
                $data['action_type'] = 'remind';
                $data['action_id'] = $booking->id;
                $data['user_id'] = $user_id;
                $data['date'] = Carbon::now()->timestamp;
                $data['title'] = $title;
                $data['body'] = $body;

                sendFCM($title, $body, $data, $tokens, 1, 1);

                $booking ->remind_notif = 2 ;
                $booking->save();


                DB::table('cronjob')->insert([
                    'created_at' => Carbon::now()->toDateTimeString() ,
                    'booking_id' => $booking ->id ,
                    'type' => 'remind before 2 hour'
                ]);

            }
        }
    }
}
