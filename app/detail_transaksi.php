<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detail_transaksi extends Model
{
    protected $table="detail_transaksi";
    protected $fillable = ['id_transaksi','id_jenis','subtotal','qty'];
    public $timestamps = false;
}
