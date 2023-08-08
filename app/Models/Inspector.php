<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Inspector extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'status',
        'avatar',
        'password',
        'company',
        'membership',
        'address',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @param string $email
     * @return $this|null
     */
    public function getByEmail(string $email)
    {
        return self::where('email','like', $email)->first();
    }

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function getEmailAttribute($value) {
        return strtolower($value);
    }

    public function getListName()
    {
        $query = DB::table('regions')
            ->select('id', 'name')
            ->pluck('name', 'id')
            ->toArray();

        return $query;
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $url = route('password.form', ['token' => $token, 'email' => $this->email]);
        $this->notify(new ResetPasswordNotification($url, $this->email, $this->first_name));
    }
}
