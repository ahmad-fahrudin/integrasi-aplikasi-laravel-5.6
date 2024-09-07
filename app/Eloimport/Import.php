<?php

namespace App\Eloimport;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $table = "tb_barang";
    protected $fillable = ['no_sku','nama_barang','merk','tipe'];
}
