<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sarpras extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sarpras';

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
    protected $fillable = ['user_id', 'periode', 'uraian', 'satuan', 'unit_id', 'jumlah','stok', 'harga', 'total', 'keterangan'];

    
}
