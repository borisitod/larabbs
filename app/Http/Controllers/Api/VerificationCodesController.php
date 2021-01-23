<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use ClickSendLib\ClickSendClient;
use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Auth\AuthenticationException;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, ClickSendClient $ClickSendClient)
    {
        $captchaData = \Cache::get($request->captcha_key);

        if (!$captchaData) {
            abort(403, 'Captcha is expired');
        }

        if (!hash_equals($captchaData['code'], $request->captcha_code)) {
            // 验证错误就清除缓存
            \Cache::forget($request->captcha_key);
            throw new AuthenticationException('Captcha is invalid');
        }

        $phone = $request->phone;

        if (!app()->environment('production')) {
            $code = '1234';
        } else {
            // 生成4位随机数，左侧补0
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

            try {
                $client = new \ClickSendLib\ClickSendClient(env('SMS_CLICKSEND_USERNAME', ''), env('SMS_CLICKSEND_API_KEY', ''));
                $sms = $client->getSMS();

                // The payload.
                $messages = [
                    [
                        "source" => "php",
                        "from" => config('app.name'),
                        "body" => $code,
                        "to" => $phone,
                    ]
                ];

                // Send SMS.
                $response = $sms->sendSms(['messages' => $messages]);
            } catch (\ClickSendLib\APIException $e) {
                $message = $e->getResponseBody();
                print_r($message);
                abort(500, $message ?: 'The SMS is not sent successfully.');
            }
        }

        $key = 'verificationCode_'.Str::random(15);
        $expiredAt = now()->addMinutes(5);
        // 缓存验证码 5分钟过期。
        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);
        // 清除图片验证码缓存
        \Cache::forget($request->captcha_key);

        return response()->json([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }
}
