<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['tweet', 'user_id'];

    /**
     * Get rules
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'tweet' => 'required|string|min:1|max:140',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
