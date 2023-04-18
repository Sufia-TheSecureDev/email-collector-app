<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use App\Models\Email;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;


class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Email::orderBy('updated_at', 'desc');

        // If something has in search box, then process more
        $searched = request()->search;
        if (!empty($searched)) {
            $query->where('email', 'like', '%' . $searched .'%');
        }

        $emails = $query->paginate(10);
        return view('emails.index', compact('emails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmailRequest $request)
    {
        $emails = explode(',', $request->emails);
        $total = 0;

        //naive insertion
        // foreach ($emails as $emailString) {
        //     // Trim the string
        //     $emailString = trim($emailString);

        //     // Check if a valid email.
        //     if (filter_var($emailString, FILTER_VALIDATE_EMAIL) !== false) {
        //         // Check if this email exists in database.
        //         if (!Email::where('email', $emailString)->limit(1)->exists()) {
        //             // Save in DB
        //             $email = new Email();
        //             $email->email = $emailString;
        //             $email->save();
        //             $total++;
        //         }
        //     }
        // }

        //optimize insertion with bulk op
        $validEmails = [];
        foreach ($emails as $emailString) {
            // Trim the string
            $emailString = trim($emailString);

            // Check if a valid email.
            if (filter_var($emailString, FILTER_VALIDATE_EMAIL) !== false) {
                // Check if this email exists in database.
                if (!Email::where('email', $emailString)->limit(1)->exists()) {
                    $validEmails[] = [
                        'email' => $emailString,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                    $total++;
                }
            }
        } 
        if ($total > 0) {
            Email::insert($validEmails);
            session()->flash('success', "Successfully {$total} Emails have been added");
        } else {
            session()->flash('error', "Sorry, No valid emails found.");
        }
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Email $email)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Email $email)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Email $email)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Email $email)
    {
        if ($email) {
            $email->delete();
        } 
        return back();
    }
}
