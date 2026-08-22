<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'user_id',
        'type',
        'result',
        'notes',
        'contacted_at',
        'next_follow_up_at',
    ];

    protected function casts(): array
    {
        return [
            'contacted_at' => 'datetime',
            'next_follow_up_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Activity Type Constants
    |--------------------------------------------------------------------------
    */

    public const CALL = 'call';
    public const WHATSAPP = 'whatsapp';
    public const SMS = 'sms';
    public const EMAIL = 'email';
    public const MEETING = 'meeting';
    public const OTHER = 'other';

    /*
    |--------------------------------------------------------------------------
    | Activity Result Constants
    |--------------------------------------------------------------------------
    */

    public const CONTACTED = 'contacted';
    public const INTERESTED = 'interested';
    public const FOLLOW_UP = 'follow_up';
    public const NO_ANSWER = 'no_answer';
    public const PHONE_CLOSED = 'phone_closed';
    public const WRONG_NUMBER = 'wrong_number';
    public const NOT_INTERESTED = 'not_interested';
    public const CONVERTED = 'converted';

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * العميل المرتبط بعملية التواصل
     */
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * المستخدم الذي قام بعملية التواصل
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
