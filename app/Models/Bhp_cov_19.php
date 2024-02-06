<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bhp_cov_19 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bhp_cov_19';

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
    protected $fillable = ['user_id', 'periode', 'uraian', 'satuan', 'unit_id', 'jumlah', 'harga', 'total', 'keterangan'];

    
}
