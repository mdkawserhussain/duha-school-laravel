<?php

namespace App\Http\Controllers;

use App\Services\ContactService;
use App\Http\Requests\SendContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected ContactService $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index()
    {
        return view('pages.contact');
    }

    public function send(SendContactRequest $request)
    {
        $this->contactService->sendContactMessage($request->validated());

        return redirect()->back()->with('success', 'Your message has been sent successfully. We will contact you soon.');
    }
}
