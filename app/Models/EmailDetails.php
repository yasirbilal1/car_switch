<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailDetails extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function recipient()
    {
        return $this->hasOne(EmailRecipients::class, 'id', 'email_replier_id');
    }
}
