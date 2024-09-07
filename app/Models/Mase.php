<?php

namespace app\Models;
use DB;

class Mase
{
  public function getJabatan()
  {
    $q = DB::table('tb_jabatan as a')
    ->select("a.*")
    ->where("a.status","aktif")
    ->get();
    return $q;
  }
  
  public function getDivisi()
  {
    $q = DB::table('pay_divisi as a')
    ->select("a.*")
    ->get();
    return $q;
  }

  //Karyawan
  public function insertKaryawan($data)
  {
    $q = DB::table('tb_karyawan')
    ->insert($data);
    return $q;
  }
  public function getKaryawan()
  {
    $q = DB::table('tb_karyawan as a')
    ->join('tb_jabatan as c','c.id','=','a.jabatan')
    ->join('pay_divisi as d','d.id_divisi','=','a.id_divisi')
    ->select("a.*","c.nama_jabatan","d.nama_divisi")
    ->where("a.status","=","aktif")
    ->get();
    return $q;
  }
  public function delKaryawan($id){
    $data['status'] = "non aktif";
    DB::table('tb_karyawan')
        ->where('id','=',$id)
        ->update($data);
  }
  public function getKaryawanby($id)
  {
    $q = DB::table('tb_karyawan as a')
    ->join('tb_jabatan as c','c.id','=','a.jabatan')
    ->join('pay_divisi as d','d.id_divisi','=','a.id_divisi')
    ->select("a.*","c.nama_jabatan","c.id as idoption","d.nama_divisi","d.id_divisi as idoption")
    ->where("a.status","=","aktif")
    ->where("a.id","=",$id)
    ->get();
    return $q;
  }
  public function updateKaryawan($data,$id)
  {
    DB::table('tb_karyawan')
        ->where('id','=',$id)
        ->update($data);
  }


  //Konsumen
  public function insertKonsumen($data){
    $q = DB::table('tb_konsumen')
    ->insert($data);
    return $q;
  }
  public function getKonsumen()
  {
    $q = DB::table('tb_konsumen as a')
    ->join('tb_kategori as b','b.id','=','a.kategori')->join('tb_karyawan as c','c.id','=','a.pengembang')
    ->select("a.*","b.nama_kategori","c.nama as karyawan")
    ->where("a.status","=","aktif")
    ->get();
    return $q;
  }
  public function delKonsumen($id){
    $data['status'] = "non aktif";
    DB::table('tb_konsumen')
        ->where('id','=',$id)
        ->update($data);
  }
  public function getKonsumenby($id)
  {
    $q = DB::table('tb_konsumen as a')
    ->join('tb_kategori as b','b.id','=','a.kategori')
    ->leftJoin('tb_karyawan as c','c.id','=','a.pengembang')
    ->leftJoin('tb_karyawan as d','d.id','=','a.leader')
    ->leftJoin('tb_karyawan as e','e.id','=','a.manager')
    ->select("a.*","b.nama_kategori","c.nama as karyawan","d.nama as nama_leader","e.nama as nama_manager")
    ->where("a.status","=","aktif")
    ->where("a.id","=",$id)
    ->get();
    return $q;
  }
  public function updateKonsumen($data,$id){
    DB::table('tb_konsumen')
        ->where('id','=',$id)
        ->update($data);
  }


  //Suplayer
  public function insertSuplayer($data){
    $q = DB::table('tb_suplayer')
    ->insert($data);
    return $q;
  }
  public function getSuplayer()
  {
    $q = DB::table('tb_suplayer as a')
    ->select("a.*")
    ->where("status","=","aktif")
    ->get();
    return $q;
  }
  public function getSuplayerByKota($key)
  {
    $q = DB::table('tb_suplayer as a')
    ->select("a.*")
    ->where("status","=","aktif")
    ->where("kota","=",$key)
    ->get();
    return $q;
  }
  public function delSuplayer($id){
    $data['status'] = "non aktif";
    DB::table('tb_suplayer')
        ->where('id','=',$id)
        ->update($data);
  }
  public function getSuplayerby($id)
  {
    $q = DB::table('tb_suplayer as a')
    ->select("a.*")
    ->where("status","=","aktif")
    ->where('id','=',$id)
    ->get();
    return $q;
  }
  public function updateSuplayer($data,$id){
    DB::table('tb_suplayer')
        ->where('id','=',$id)
        ->update($data);
  }


  //level
  public function getLevel()
  {
    $q = DB::table('tb_level as a')
    ->select("a.*")
    ->get();
    return $q;
  }


  //user
  public function insertuser($data){
    $q = DB::table('users')
    ->insert($data);
    return $q;
  }
  public function getUser()
  {
    $q = DB::table('users as a')
    ->join('tb_gudang as c','c.id','=','a.gudang')
    ->join('tb_level as d','d.id','=','a.level')
    ->select("*","a.id as iduser")
    ->where("a.status","=","aktif")
    ->get();
    return $q;
  }
  public function delUser($id){
    $data['status'] = "non aktif";
    DB::table('users')
        ->where('id','=',$id)
        ->update($data);
  }
  public function getUserby($id){
    $q = DB::table('users as a')
    ->select("*")
    ->where("status","=","aktif")
    ->where('id','=',$id)
    ->get();
    return $q;
  }
  public function updateUser($data,$id){
    DB::table('users')
        ->where('id','=',$id)
        ->update($data);
  }


  //Gudang
  public function getGudang()
  {
    $q = DB::table('tb_gudang as a')
    ->select("a.*")
    ->where("a.status","=","aktif")
    ->get();
    return $q;
  }
  public function insertgudang($data){
    $q = DB::table('tb_gudang')
    ->insert($data);
    return $q;
  }
  public function delGudang($id){
    $data['status'] = "non aktif";
    DB::table('tb_gudang')
        ->where('id','=',$id)
        ->update($data);
  }
  public function getGudangby($id)
  {
    $q = DB::table('tb_gudang as a')
    ->select("a.*")
    ->where("a.status","=","aktif")
    ->where('id','=',$id)
    ->get();
    return $q;
  }
  public function updateGudang($data,$id){
    DB::table('tb_gudang')
        ->where('id','=',$id)
        ->update($data);
  }


  //Stok gudang
  public function getBarang()
  {
    $q = DB::table('tb_barang as a')
    ->select("a.*")
    ->where("a.status","=","aktif")
    ->orderBy("a.id","DESC")
    ->limit(1)
    ->get();
    return $q;
  }
  public function insertbarang($data,$dt){
    DB::table('tb_barang')->insert($data);
    DB::table('tb_harga')->insert($dt);
  }

  public function insertbarangmasuk($data,$dt){
    DB::table('tb_barang_masuk')->insert($data);
    DB::table('tb_gudang_barang')->insert($dt);
  }

  public function insertupdatebarangmasuk($data,$dt){
    DB::table('tb_barang_masuk')->insert($data);
    DB::table('tb_gudang_barang')
        ->where('id','=',$dt['id'])
        ->update($dt);
  }


  //Barang Masuk
  public function getBarangMasuk()
  {
    $q = DB::table('tb_barang_masuk as a')
    ->join('tb_suplayer as b','b.id','=','a.suplayer')
    ->join('tb_barang as c','c.id','=','a.barang')
    ->join('tb_karyawan as d','d.id','=','a.driver')
    ->join('tb_karyawan as e','e.id','=','a.qc')
    ->join('users as f','f.id','=','a.admin')
    ->join('tb_gudang as g','g.id','=','a.gudang')
    ->select("a.id","g.nama_gudang","a.no_faktur","a.tgl_masuk","a.kategori","b.nama_pemilik","b.alamat","c.no_sku","c.nama_barang","c.part_number","a.jumlah","c.pcs_koli","c.satuan_pcs","c.satuan_koli","d.nama as driver","e.nama as qc","f.name as admin","a.noted")
    ->where("a.status","=","aktif")
    ->orderBy("a.id","DESC")
    ->limit(1000)
    ->get();
    return $q;
  }


  //pricelist
  public function getPrice(){
    $q = DB::table('tb_harga as a')
    ->join('tb_barang as b','b.id','=','a.id_barang')
    ->select("a.id","b.no_sku","b.nama_barang","b.part_number",'a.harga_coret','a.harga','a.harga_hpp','a.harga_hp','a.harga_retail','a.harga_reseller','a.harga_agen','a.label','a.tanggal',"a.qty1","a.qty2","a.qty3","a.pot1","a.pot2","a.pot3",'a.poin','a.fee_item',"a.id_barang")
    ->where("b.status","=","aktif")
    ->get();
    return $q;
  }

  //transfer stok
  public function inserttransferstok($d){
    DB::table('tb_transfer_stok')->insert($d);
  }
  public function insertdetailtransferstok($s){
    DB::table('tb_detail_transfer')->insert($s);
  }
  public function getTransferStok(){
    $q = DB::table('tb_transfer_stok as a')
    ->join('tb_gudang as b','b.id','=','a.dari')
    ->join('tb_gudang as c','c.id','=','a.kepada')
    ->select("a.*","b.nama_gudang as dari","c.nama_gudang as kepada")
    ->get();
    return $q;
  }
  public function detailTransferStokby($id){
    $q = DB::table('tb_transfer_stok as a')
    ->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
    ->join('tb_barang as c','c.id','=','b.id_barang')
    ->join('tb_gudang as d',function($join){
                $join->on("a.dari","=","d.id");
            })
    ->join('tb_gudang as e',function($join){
                $join->on("a.kepada","=","e.id");
            })
    ->join('users as h','h.id','=','a.admin')
    ->select("a.id","a.no_transfer","a.tanggal_order","a.tanggal_kirim","d.nama_gudang as dari","e.nama_gudang as kepada"
              ,"c.no_sku","c.nama_barang","c.part_number","b.jumlah","a.status_transfer","b.proses","b.pending","b.retur","b.terkirim"
              ,"h.name as admin","a.tanggal_terkirim","b.id as id_link")
    ->where("a.no_transfer","=",$id)
    ->get();
    return $q;
  }

  public function detailBarangKeluarby($id){
    $q = DB::table('tb_barang_keluar as a')
    ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
    ->join('tb_barang as c','c.id','=','b.id_barang')
    ->select("a.id","a.no_kwitansi","c.no_sku","c.nama_barang","c.part_number","b.jumlah","b.terkirim","b.sub_total","b.id as id_link","b.warna_pilihan")
    ->where("a.no_kwitansi","=",$id)
    ->get();
    return $q;
  }

  public function getDataTransferStok(){
    $q = DB::table('tb_transfer_stok as a')
    ->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
    ->join('tb_barang as c','c.id','=','b.id_barang')
    ->join('tb_gudang as d',function($join){
                $join->on("a.dari","=","d.id");
            })
    ->join('tb_gudang as e',function($join){
                $join->on("a.kepada","=","e.id");
            })
    ->join('tb_karyawan as f','f.id','=','a.driver')
    ->join('tb_karyawan as g','g.id','=','a.qc')
    ->join('users as h','h.id','=','a.admin')
    ->join('users as i','i.id','=','a.admin_g')
    ->leftJoin('users as j','j.id','=','a.admin_v')
    ->select("a.id","a.no_transfer","a.tanggal_order","a.tanggal_kirim","d.nama_gudang as dari","e.nama_gudang as kepada"
              ,"c.no_sku","c.nama_barang","b.jumlah","a.status_transfer","b.proses","b.pending","b.retur","b.terkirim"
              ,"f.nama as driver","g.nama as qc","h.name as admin","i.name as admin_g","j.name as admin_v","a.tanggal_terkirim")
    ->get();
    return $q;
  }

}

?>
