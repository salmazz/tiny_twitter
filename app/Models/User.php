<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Register conversions
     *
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('small')->width(200)->sharpen(10);
        $this->addMediaConversion('medium')->width(600)->sharpen(10);
        $this->addMediaConversion('large')->width(1000)->sharpen(10);
    }

    /**
     * Get rules
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'name' => 'required|min:4|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|min:8|max:191',
            'date_of_birth' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:500',
        ];
    }

    /**
     * The following that belong to the user.
     */
    public function following()
    {
        return $this->belongsToMany('App\Models\User', 'follows', 'follower_id', 'following_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tweets()
    {
        return $this->hasMany('App\Models\Tweet');
    }

}
