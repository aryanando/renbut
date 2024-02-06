<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiga60 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tiga60';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['periode', 'user_id', 'user_target_id', 'komponen', 'point', 'nilai'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
