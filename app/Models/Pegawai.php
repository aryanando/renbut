<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pegawai';

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
    protected $fillable = ['nama', 'gender', 'unit_id','tmt_kerja','pendidikan', 'cuti', 'atasan', 'remun', 'rekening'];

    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
