<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SMSChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $phone = Str::startsWith($notifiable->phone_number, '0')
            ? '88'.$notifiable->phone_number
            : Str::replaceFirst('+', '', $notifiable->phone_number);

//        dd(Http::get('http://sms.bdwebs.com/smsapi?api_key='.config('services.bdwebs.api_key').'&type=text&contacts=8801783110247&senderid='.config('services.bdwebs.senderid').'&msg="Your OTP for BSBazarBD is: 123465."')->body());
//        dd(Http::get('http://sms.bdwebs.com/miscapi/'.config('services.bdwebs.api_key').'/getDLR/getAll')->body());

        // Send notification to the $notifiable instance...
        $data = array_merge([
            'type' => 'text',
            'contacts' => $phone,
            'label' => 'transactional',
            'api_key' => config('services.bdwebs.api_key'),
            'senderid' => config('services.bdwebs.senderid'),
        ], $notification->toArray($notifiable));

	$this->send_sms($data);
  //      Log::info($this->send_sms($data));
    }

    private function send_sms($data)
    {
//        Log::info('sending sms:', $data);
        $url = "http://sms.bdwebs.com/smsapi";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
