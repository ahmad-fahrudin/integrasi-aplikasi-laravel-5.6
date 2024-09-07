<?php

namespace App\Imports;

use App\Eloimport\Import;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;

class BarangImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $id = DB::table('tb_barang as a')->select("*")->orderBy('id','DESC')->limit(1)->get();
        if(count($id) > 0){
          $no = substr($id['0']->no_sku,3) + 1;
          $number = str_pad($no + 1, 4, '0', STR_PAD_LEFT);
          $data['no_sku'] = "SKU".$number;
          $data['id'] = $id['0']->id + 1;
        }else{
          $data['no_sku'] = "SKU0001";
          $data['id'] = 1;
        }
        $data['nama_barang'] = $row[1];
        $data['branded'] = $row[2];

        $dt['id_barang'] = $data['id'];
        $dt['harga'] = $row[3];
        $dt['harga_hpp'] = $row[4];
        $dt['tanggal'] = date('Y-m-d');

        DB::table('tb_barang')->insert($data);
        DB::table('tb_harga')->insert($dt);

        $gudang = DB::table('tb_gudang as a')->select("*")->where("a.status","=","aktif")->get();
        for ($i=0; $i < count($gudang); $i++) {
          $x['id_gudang'] = $gudang[$i]->id;
          $x['id_barang'] = $data['id'];
          $x['jumlah'] = "0";
          $x['harga'] = $row[3];
          $x['status'] = "aktif";
          DB::table('tb_gudang_barang')->insert($x);
        }
    }
}
