<?php

namespace App\Domain\Department\Model;

use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;


class Department extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    protected $keyType = 'string';
    public $incrementing = false;


    protected static function  boot()
    {
        parent::boot();

        static::creating(function ($model){
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function users():HasMany
    {
        return $this->hasMany(
            User::class,
            'department_id'
        );
    }


}
