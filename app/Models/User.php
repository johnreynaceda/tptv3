<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function is_admin(): bool
    {
        return $this->role_id === 1;
    }

    public function scopeIsNotAdmin($query){
        return $query->where('role_id', '!=', 1);
    }

    public function application()
    {
        return $this->hasOne(Application::class);
    }

    public function personal_information()
    {
        return $this->hasOne(PersonalInformation::class);
    }

    public function school_information()
    {
        return $this->hasOne(SchoolInformation::class);
    }

    public function program_choices()
    {
        return $this->hasMany(ProgramChoice::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function permit()
    {
        return $this->hasOne(Permit::class);
    }

    public function student_slot()
    {
        return $this->hasOne(StudentSlot::class);
    }

    public function survey_result()
    {
        return $this->hasOne(SurveyResult::class);
    }

    public function selected_courses()
    {
        return $this->hasMany(SelectedCourse::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'type_id',
        'step',
        'remarks',
        'role_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
