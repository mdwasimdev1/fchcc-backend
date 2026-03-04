<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Mail\NewsletterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Traits\ResponseTrait;

class NewsletterController extends Controller
{
    use ResponseTrait;

    public function subscribe(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);

            $email = strtolower($request->email);
            $subscriberHash = md5($email);

            $response = Http::withBasicAuth('anystring', env('MAILCHIMP_API_KEY'))
                ->put('https://' . env('MAILCHIMP_SERVER')
                    . '.api.mailchimp.com/3.0/lists/'
                    . env('MAILCHIMP_LIST_ID')
                    . '/members/' . $subscriberHash, [
                    'email_address' => $email,
                    'status_if_new' => 'subscribed'
                ]);

            $data = $response->json();

            if (isset($data['status']) && (int)$data['status'] >= 400) {
                return $this->error(
                    null,
                    $data['detail'] ?? 'Something went wrong with Mailchimp',
                    (int) $data['status']
                );
            }

            $simpleData = [
                'id' => $data['id'] ?? $data['unique_email_id'] ?? null,
                'email_address' => $data['email_address'] ?? null,
                'status' => $data['status'] ?? null
            ];

            return $this->success(
                $simpleData,
                'Subscribed successfully',
                200
            );
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return $this->error(
                null,
                $ve->getMessage(),
                422
            );
        } catch (\Throwable $e) {
            return $this->error(
                null,
                $e->getMessage(),
                500
            );
        }
    }




    public function sendNewsletter(Request $request)
    {
        $subscribers = Subscriber::where('is_active', true)->get();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)
                ->queue(new NewsletterMail($request->content));
        }

        return response()->json([
            'message' => 'Newsletter queued successfully'
        ]);
    }

    public function unsubscribe(Request $request)
    {
        Subscriber::where('email', $request->email)
            ->update(['is_active' => false]);

        return response()->json(['message' => 'Unsubscribed successfully']);
    }
}
