<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * Model's primary key.
     *
     * @var string
     */
    public $primaryKey = 'key';
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value',
    ];

    public static function key($key)
    {
        return Setting::firstOrCreate(['key' => $key])->value;
    }
}
