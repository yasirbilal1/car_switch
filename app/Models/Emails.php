<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\EmailRecipients;
use App\Models\User;

class Emails extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function recipients()
    {
        return $this->hasMany(EmailRecipients::class, 'email_id', 'id');
    }
    public function selected_recipient()
    {
        return $this->hasOne(EmailRecipients::class, 'email_id', 'id')->where('user_email', Auth::user()->email);
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->where('email', Auth::user()->email);
    }
    public function email_sender()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function replies()
    {
        return $this->hasMany(EmailDetails::class, 'email_id', 'id');
    }
    /** business logic */
    /**
     * consider this as the user is replying too all the members of the email without excluding anyone
     */
    public function replyAll($params)
    {
        /** get auth user */
        $auth = Auth::user();

        /** get email data */
        $getEmailById = Emails::where('id', $params['email_id'])->with('selected_recipient')->first();

        /** send the reply by this user */

        $sendReply = EmailDetails::create([
            'email_id'         => $params['email_id'],
            'email_replier_id' => $getEmailById['selected_recipient']['id'],
            'content'          => 'This is a reply from '. $auth->name .' and i have sent this message internally to save some time.',
        ]);

        if($sendReply) {
            return response()->json(
                [
                    'success' => '1',
                    'data'    => true
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => '0',
                    'data'    => false
                ]
            );
        }
    }

}
