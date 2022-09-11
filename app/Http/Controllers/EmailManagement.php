<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Emails;
use App\Models\EmailDetails;
use Illuminate\Http\Request;
use App\Models\EmailRecipients;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EmailRequest;

class EmailManagement extends Controller
{
    protected $emailClass;

    public function __construct(
        Emails $emailClass
    )
    {
        $this->emailClass = $emailClass;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $getInbox = $this->getInbox();
        return view('email.create')->with('inbox', $getInbox);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmailRequest $request)
    {
        try {
            $request  = $request->all();
            $emailTo  = explode(',', $request['email_to']);
            $emailCc  = explode(',', $request['email_cc']);
            
            if(!empty($emailTo)) {
                /** set data to emails table */
                $setEmail = Emails::create([
                    'user_id' => Auth::id(),
                    'subject' => $request['email_subject'],
                    'content' => $request['email_content'],
                ]);
                /** set email to user emails, handles multiple recipients */
                foreach ($emailTo as $key => $emailToValue) {
                    /** add the original email sender */
                    if(Auth::id()) {
                        EmailRecipients::create([
                            'email_id'    => $setEmail->id,
                            'user_email'  => Auth::user()->email,
                            'type_id'     => '0',
                            'is_owner'    => 1
                        ]);     
                    }
                    /** add the recipients, handles multiple recipients */
                    EmailRecipients::create([
                        'email_id'    => $setEmail->id,
                        'user_email'  => $emailToValue,
                        'type_id'     => '1',
                        'is_owner'    => 0
                    ]); 
                }
                /** set email to cc emails, handles multiple recipients cc */
                if(!empty($request['email_cc'])) {
                    foreach ($emailCc as $key => $emailCcValue) {
                        EmailRecipients::create([
                            'email_id'    => $setEmail->id,
                            'user_email'  => $emailCcValue,
                            'type_id'     => '2',
                            'is_owner'    => 0
    
                        ]); 
                    }
                }
                return redirect()->route('email.create');
            }
        } catch (\Throwable $th) {
            return back()->with('message', 'We are unable to process this request temporairly!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getInbox()
    {
        return EmailRecipients::where('user_email', Auth::user()->email)
                                ->with(['user', 'email_details', 'email_content'])
                                ->get();

        // return EmailRecipients::where('user_email', Auth::user()->email)->with('email_details')->get();

    }
    public function getEmailById(EmailRequest $request)
    {
        $request = $request->all();
        $getResponse = Emails::where('id', $request['email_id'])->with('email_sender', 'replies.recipient')->first();
        return response()->json(
            [
                'success' => '1',
                'data'    => $getResponse,
                'session' => Auth::user()
            ]
        );
    }
    public function replyAll(Request $request)
    {
        return $this->emailClass->replyAll($request->all());
    }
}
