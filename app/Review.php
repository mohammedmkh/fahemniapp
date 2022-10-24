<?php

namespace App;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    public $table = 'reviews';
    protected $appends = ['type_name'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'reviewer_id',
        'reviewed_id',
        'type',
        'review',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getTypeNameAttribute()
    {

        if($this->type == 1){
            return ' تقييم مدرس' ;
        }


        return ' تقييم طالب' ;
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewed()
    {
        return $this->belongsTo(User::class, 'reviewed_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
