<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'whatsapp',
        'business_type',
        'city',
        'address',
        'lead_source_id',
        'assigned_to',
        'status',
        'notes',
        'last_contact_at',
        'next_follow_up_at',
        'converted_at',
    ];

    protected function casts(): array
    {
        return [
            'last_contact_at' => 'datetime',
            'next_follow_up_at' => 'datetime',
            'converted_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Status Constants
    |--------------------------------------------------------------------------
    */

    public const NEW = 'new';
    public const CONTACTED = 'contacted';
    public const INTERESTED = 'interested';
    public const FOLLOW_UP = 'follow_up';
    public const NO_ANSWER = 'no_answer';
    public const PHONE_CLOSED = 'phone_closed';
    public const WRONG_NUMBER = 'wrong_number';
    public const NOT_INTERESTED = 'not_interested';
    public const CONVERTED = 'converted';
    public const LOST = 'lost';



    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    /**
     * مصدر العميل
     */
    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class);
    }

    /**
     * موظف المبيعات المسؤول
     */
    public function sales()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * الخدمات التي يهتم بها العميل
     */
    public function services()
    {
        return $this->belongsToMany(
            Service::class,
            'lead_services'
        )->withTimestamps();
    }

    /**
     * سجل التواصل مع العميل
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
