<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmailDetails;
use App\Models\Emails;

class EmailRecipients extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function email_details()
    {
        return $this->hasMany(EmailDetails::class, 'email_id', 'email_id');
    }
    
    public function user()
    {
        return $this->hasOne(User::class, 'email', 'user_email');
    }
    
    public function email_content()
    {
        return $this->hasOne(Emails::class, 'id', 'email_id');
    }
    public function email_replier()
    {
        return $this->hasMany(EmailDetails::class, 'email_replier_id', 'id');
    }
    
    
    

}
