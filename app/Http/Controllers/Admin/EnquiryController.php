<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    public function index(): View
    {
        return view('admin.enquiries.index', [
            'enquiries' => Enquiry::latest()->get(),
        ]);
    }

    public function show(Enquiry $enquiry): View
    {
        return view('admin.enquiries.show', [
            'enquiry' => $enquiry,
        ]);
    }

    public function destroy(Enquiry $enquiry): RedirectResponse
    {
        $enquiry->delete();

        return back()->with('success_message', 'Enquiry deleted!');
    }
}
