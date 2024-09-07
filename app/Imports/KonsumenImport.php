<?php

namespace App\Imports;

use App\Eloimport\Import;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;

class KonsumenImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
      $d['bm'] = DB::table('tb_konsumen as a')->select("*")->where("a.status","=","aktif")->where("a.tanggal","=",date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();
      if(count($d['bm']) > 0){
        $var = substr($d['bm'][0]->id_konsumen,9);
        $number = str_pad($var + 1, 4, '0', STR_PAD_LEFT);
      }else{
        $number = "001";
      }
      if (isset($row[1])) {
        $data['nama_pemilik'] = $row[1];
      }else{
        $data['nama_pemilik'] = 'cek';
      }
      if (isset($row[2])) {
        $data['kategori'] = $row[2];
      }else{
        $data['kategori'] = '1';
      }
      if (isset($row[3])) {
        $data['alamat'] = $row[3];
      }else{
        $data['alamat'] = 'cek';
      }
      if (isset($row[4])) {
        $data['kota'] = $row[4];
      }else{
        $data['kota'] = 'cek';
      }
      if (isset($row[5])) {
        $data['no_hp'] = (string)$row[5];
      }else{
        $data['no_hp'] = 'cek';
      }
      if (isset($row[6])) {
        $data['keterangan'] = $row[6];
      }else{
        $data['keterangan'] = null;
      }
      if (isset($row[7])) {
        $data['pengembang'] = $row[7];
      }else{
        $data['pengembang'] = '1';
      }
      $data['id_konsumen'] = 'PLG'.date('ymd').$number;
      $data['status'] = "aktif";

      DB::table('tb_konsumen')->insert($data);

    }
}
