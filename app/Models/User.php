<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'username',
        'password',
        'tanggal_lahir',
        'email',
        'phone',
        'full_name',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
        ];
    }

    // public function mentee ()
    // {
    //     return $this->hasOne(MenteeProfile::class);
    // }

    public function company()
    {
        return $this->hasOne(Company::class, 'user_id', 'user_id');
    }

    public function menteeProfile()
    {
    return $this->hasOne(MenteeProfile::class, 'user_id', 'user_id');
    }

    // Relasi Kelas sebagai Mentor (seorang mentor bisa mengelola banyak kelas)
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'mentor_id', 'user_id');
    }

    // Relasi Kelas sebagai Secretary (seorang sekretaris bisa mengelola banyak kelas)
    public function secretaryClasses()
    {
        return $this->hasMany(Kelas::class, 'secretary_id', 'user_id');
    }

    public function mentor()
    {
        return $this->hasOne(Mentor::class, 'mentor_id', 'user_id');
    }
}
