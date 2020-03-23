<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jenis_cuci extends Model
{
    protected $table="jenis_cuci";
    protected $fillable = ['nama_jenis','harga_perkilo'];
    public $timestamps = false;
}
