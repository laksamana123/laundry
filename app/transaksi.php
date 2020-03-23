<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $table="transaksi";
    protected $fillable = ['id_pelanggan','id_petugas','tgl_transaksi','tgl_selesai'];
    public $timestamps = false;
}
