<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Auth;

class Quiz extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'description', 'finished_at', 'status', 'slug'];
    protected $dates = ['finished_at']; //CARBONU KULLANABILMEK ICIN
    protected $appends = ['details','my_rank'];

    /*
    public function getFinishedAtAttribute($date)
    {
        return $date ? Carbon::parse($date) : null;
    }
    */

    public function getMyRankAttribute()
    {
        $rank = 0;
        foreach ($this->results()->orderByDesc('point')->get() as $result) {
            $rank += 1;
            if (Auth::user()->id == $result->user_id) {
                return $rank;
            }
        }
    }

    public function getDetailsAttribute()
    {
        if ($this->results()->count() > 0) {
            return [
                'average' => $this->results()->avg('point'),
                'join_count' => $this->results()->count()
            ];
        }

        return null;
    }


    public function topFive()
    {
        return $this->results()->orderByDesc('point')->take(5);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function my_result()
    {
        return $this->hasOne(Result::class)->where('user_id', Auth::user()->id);
    }


    public function sluggable()
    {
        return [
            'slug' => [
                'onUpdate' => true, //güncellemede çalışmıyordu diye ekledim.
                'source' => 'title'
            ]
        ];
    }
}
