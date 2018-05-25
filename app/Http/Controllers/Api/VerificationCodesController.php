<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Overtrue\EasySms\EasySms;

class VerificationCodesController extends Controller
{
    //
    public function send(Request $request ,EasySms $easySms) {
    	    	 // 生成4位随机数，左侧补0
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

        $phone = $request->phone;
        $code = '0000';
    	$sms = app('easysms');
		 // try {
   //          $result = $easySms->send($phone, [
			//     'template' => 'SMS_135895054',
			//     'data' => [
			//         'code' => $code
			//     ],
   //          ]);
   //      } catch (\GuzzleHttp\Exception\ClientException $exception) {
   //          $response = $exception->getResponse();
   //          $result = json_decode($response->getBody()->getContents(), true);
   //          return $this->response->errorInternal($result['msg'] ?? '短信发送异常');
   //      }

        $key = 'verificationCode_'.str_random(15);
        $expiredAt = now()->addMinutes(10);
        // 缓存验证码 10分钟过期。
        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        return response([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }
}
