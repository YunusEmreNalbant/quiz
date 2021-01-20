<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Quiz extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'description', 'finished_at','status','slug'];
    protected $dates = ['finished_at']; //CARBONU KULLANABILMEK ICIN

    public function getFinishedAtAttribute($date)
    {
        return $date ? Carbon::parse($date) : null;
    }


    public function questions()
    {
        return $this->hasMany(Question::class);
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
