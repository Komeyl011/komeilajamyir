<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Bot\PersonalManagerController;
use App\Mail\RequestSubmitted;
use App\Models\ContactForm;
use App\Models\User;
use App\Notifications\ContactRequestSubmitted;
use App\Notifications\NewContactRequestNotification;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ContactMeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required',
            '_locale' => 'required|string',
        ]);

        ContactForm::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        try {
            $pmb = new PersonalManagerController();
            $pmb->send_new_contact_request([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
            ]);
        } catch (ConnectionException $e) {
            Log::error($e);
        }

        $owner = User::query()->role('admin')->first();
        $owner->notify(new NewContactRequestNotification(data: ['owner' => $owner->name, 'by' => $validated['name']]));

        Mail::to($validated['email'])->send(new RequestSubmitted(name: $validated['name']));

        return redirect(app()->isLocal() ? config('app.url') . ':8000#contact' : config('app.url') . '#contact')->with('success', __('mainsections.contact-form-success'));
    }
}
