<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe;
use Illuminate\Support\Facades\File;
use Exception;

class StripeController extends Controller
{
    public function stripe()
    {
        return view('backend.layout.stripe.index');
    }

    public function stripePost(Request $request)
    {

     $request->validate([
            'stripe_key' => 'required|string',
            'stripe_secret' => 'required|string',
        ]);

         try {
            $envContent = File::get(base_path('.env'));
            $lineBreak = "\n";
            $envContent = preg_replace([
                '/STRIPE_KEY=(.*)\s/',
                '/STRIPE_SECRET=(.*)\s/',
            ], [
                'STRIPE_KEY=' . $request->stripe_key . $lineBreak,
                'STRIPE_SECRET=' . $request->stripe_secret . $lineBreak,
            ], $envContent);

            if ($envContent !== null) {
                File::put(base_path('.env'), $envContent);
            }
            return back()->with('success', 'Updated successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update');
        }

        return redirect()->back();with('success', 'Stripe keys updated successfully.');

     

        // // Update the .env file with the new Stripe keys
        // $this->updateEnv('STRIPE_KEY', $validatedData['stripe_key']);
        // $this->updateEnv('STRIPE_SECRET', $validatedData['stripe_secret']);

        // return redirect()->back()->with('success', 'Stripe keys updated successfully.');
    }
}
