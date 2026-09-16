<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send OTP Verification code using SMS.ir Pattern (Fast/Verify) API
     */
    public function sendOtp(string $mobile, string $code): bool
    {
        $apiKey = config('sms.smsir.api_key');
        $templateId = config('sms.smsir.template_id');
        $paramName = config('sms.smsir.code_param', 'Code');

        // Check if API Key & Template ID are set
        if (empty($apiKey) || empty($templateId)) {
            Log::info("SMS.ir credentials not set in .env. OTP Code for [{$mobile}] is: {$code}");
            return true;
        }

        try {
            $response = Http::withHeaders([
                'X-API-KEY' => $apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->timeout(10)->post('https://api.sms.ir/v1/send/verify', [
                'mobile' => $mobile,
                'templateId' => (int) $templateId,
                'parameters' => [
                    [
                        'name' => $paramName,
                        'value' => (string) $code,
                    ],
                ],
            ]);

            if ($response->successful()) {
                $body = $response->json();
                if (isset($body['status']) && ($body['status'] == 1 || $body['status'] == 200)) {
                    return true;
                }
                Log::warning("SMS.ir send OTP returned error: " . json_encode($body));
                return false;
            }

            Log::error("SMS.ir HTTP request failed: " . $response->status() . " - " . $response->body());
            return false;
        } catch (Exception $e) {
            Log::error("SMS.ir Exception while sending OTP to {$mobile}: " . $e->getMessage());
            return false;
        }
    }
}
