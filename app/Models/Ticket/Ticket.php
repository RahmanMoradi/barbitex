<?php

namespace App\Models\Ticket;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Morilog\Jalali\Jalalian;

class Ticket extends Model
{
    use HasFactory, TicketEvent;

    protected $guarded = ['id'];
    protected $appends = ['status_fa', 'status_class', 'status_color', 'created_at_fa', 'updated_at_fa'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Ticket::class, 'ticket_id', 'id');
    }

    public function getStatusFaAttribute()
    {
        switch ($this->status) {
            case 'new':
                return Lang::get('new');
            case 'user' :
                return Lang::get('user answer');
            case 'admin':
                return Lang::get('admin answer');
            case 'close':
                return Lang::get('closed');
        }
    }

    public function getStatusClassAttribute()
    {
        switch ($this->status) {
            case 'new':
                return 'primary';
            case 'user' :
                return 'info';
            case 'admin':
                return 'success';
            case 'close':
                return 'danger';
        }
    }

    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'new':
                return 'blue';
            case 'user' :
                return 'yellow';
            case 'admin':
                return 'green';
            case 'close':
                return 'red';
        }
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class);
    }

    public function getCreatedAtFaAttribute()
    {
        return Jalalian::forge($this->attributes['created_at'])->format('Y/m/d H:i:s');
    }

    public function getUpdatedAtFaAttribute()
    {
        return Jalalian::forge($this->attributes['updated_at'])->format('Y/m/d H:i:s');
    }
}
