<?php

namespace App\Domain\Post\Model;

use App\Domain\Department\Model\Department;
use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'visibility'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            if(empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            'department_posts',
            'post_id',
            'department_id',
            'id',
            'id'
        )->withTimestamps();
    }
}
