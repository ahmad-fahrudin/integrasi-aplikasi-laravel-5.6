<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Models\Mase;
use Auth;
use Hash;
use Crypt;
use Illuminate\Support\Facades\DB;
use Validator,Redirect,Response,File;
use DateTime;

class AkunController extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }
  
  public function pengajuanakun(){
      $data['akun'] = DB::table('members')->where('pengajuan','pending')->get();
      return view('Olshop.PengajuanAkun',$data);
  }
  
  public function approvepengajuan($id,$level){
      $member['level'] = $level;
      $member['pengajuan'] = null;
      $a = DB::table('members')->where('id',$id)->update($member);
      if($a){
          $data = DB::table('members')->where('id',$id)->get();
          $up['jenis_konsumen'] = $data[0]->level;
          DB::table('tb_karyawan')->where('no_hp',$data[0]->no_hp)->update($up);
          DB::table('tb_konsumen')->where('no_hp',$data[0]->no_hp)->update($up);
          return redirect()->back()->with('success','Berhasil');
      }else{
          return redirect()->back();
      }
  }
  
  public function cancelpengajuan($id,$level){
      $member['pengajuan'] = 'cancel';
      $a = DB::table('members')->where('id',$id)->update($member);
      if($a){
          return redirect()->back()->with('success','Berhasil');
      }else{
          return redirect()->back();
      }
  }
  
  public function tomemberonline(){
      $data['akun'] = DB::table('tb_konsumen as a')
                      ->leftJoin('members as b','a.no_hp','b.no_hp')
                      ->where('a.status','aktif')
                      ->whereNull('b.email')
                      ->select('a.*')
                      ->get();
      return view('Olshop.ToMember',$data);
  }
  
  public function tomemberonlinekaryawan(){
      $data['akun'] = DB::table('tb_karyawan as a')
                      ->leftJoin('members as b','a.no_hp','b.no_hp')
                      ->where('a.status','aktif')->whereNull('a.referal_by')
                      ->whereNull('b.email')
                      ->select('a.*')
                      ->get();
      return view('Olshop.ToMemberKaryawan',$data);
  }
  
  public function simpantomember(Request $post){
      $data = $post->except('_token');
      $dfd['nik'] = $data['nik'];
      $konsumen = DB::table('tb_konsumen')->where('id',$data['id'])->get();
      DB::table('tb_konsumen')->where('id',$data['id'])->update($dfd);
      foreach($konsumen as $key => $value){
          
          $kar['nik'] = $data['nik'];
          $kar['nama'] = $value->nama_pemilik;
          $kar['nama_lengkap'] = $value->nama_pemilik;
          $kar['jabatan'] = 10;
          $kar['alamat'] = $value->alamat;
          $kar['no_hp'] = $value->no_hp;
          $kar['mulai_kerja'] = date('Y-m-d');
          $kar['saldo'] = 0;
          $kar['status'] = "aktif";
          $kar['use'] = "no";
          
          $kar['pengembang'] = $value->pengembang;
          $kar['leader'] = $value->leader;
          
          $kar['referal_by'] = $value->referal_by;
          $kar['reseller'] = $value->reseller;
          $kar['agen'] = $value->agen;
          $kar['distributor'] = $value->distributor;
          
          $kar['jenis_konsumen'] = 1;
          $kar['referal'] = $value->referal;
          
          $cekdata = DB::table('tb_karyawan')->where('no_hp',$kar['no_hp'])->get();
          if(count($cekdata) < 1){
              DB::table('tb_karyawan')->insert($kar);
          }
          
          $member['name'] = $value->nama_pemilik;
          $member['email'] = $data['email'];
          $member['no_hp'] = $value->no_hp;
          $member['level'] = $value->jenis_konsumen;
          $member['kode_verifikasi'] = date('Y-m-d');
          $member['kode_referal'] = $value->referal;
          $member['password'] = Hash::make("ad1ch123");
          
          $cekdata2 = DB::table('members')->where('no_hp',$member['no_hp'])->orWhere('email',$member['email'])->get();
          if(count($cekdata2) < 1){
              DB::table('members')->insert($member);
          }
          
          return redirect()->back()->with('success','Berhasil');
          
      }
  }
    
    
  public function cekemailava($email){
      $cek_email = DB::table('members')->select('name')->where('email',$email)->get();
      echo count($cek_email);
  }    

  public function simpantomemberkaryawan(Request $post){
      $data = $post->except('_token');
      
      $cek_email = DB::table('members')->where('email',$data['email'])->get();
      if(count($cek_email) > 0){
          return redirect()->back()->with('error','Email Sudah Terdaftar');
      }
      
      $karyawan = DB::table('tb_karyawan')->where('id',$data['id'])->get();
      foreach($karyawan as $key => $value){
          $d = DB::table('tb_konsumen as a')->select("*")->where("a.tanggal","=",date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();
          if(count($d) > 0){
            $var = substr($d[0]->id_konsumen,9);
            $number= str_pad($var + 1, 3, '0', STR_PAD_LEFT);;
          }else{
            $number = "001";
          }
          $kons['id_konsumen'] = 'PLG'.date('ymd').$number;
          $kons['status'] = 'aktif';
          $kons['referal'] = $value->referal;
          
          if($value->jenis_konsumen < 1){
              $value->jenis_konsumen = 5;
              $upk['jenis_konsumen'] = $value->jenis_konsumen;
          }
          
          $upk['reseller'] = $value->pengembang;
          $upk['agen'] = $value->leader;
          
          if($value->manager > 0){
              $upk['distributor'] = $value->manager;
          }else{
              $upk['distributor'] = $value->leader;
          }
          
          $upk['referal_by'] = $value->pengembang;
          DB::table('tb_karyawan')->where('id',$data['id'])->update($upk);
          
          $kons['jenis_konsumen'] = $value->jenis_konsumen;
          $kons['referal_by'] = $value->pengembang;
          
          $kons['reseller'] = $value->pengembang;
          $kons['agen'] = $value->leader;
          if($value->manager > 0){
              $kons['distributor'] = $value->manager;
          }else{
              $kons['distributor'] = $value->leader;
          }
          
          
          $kons['pengembang'] = $value->pengembang;
          $kons['leader'] = $value->leader;
          $kons['manager'] = $value->manager;
          $kons['from'] = "karyawan";
          $kons['nama_pemilik'] = $value->nama_lengkap;
          $kons['kategori'] = '2';
          $kons['kategori_konsumen'] = 'Non PKP';
          $kons['tempo_piutang'] = '30';
          $kons['limit_piutang'] = '10000000';
          $kons['alamat'] = $value->alamat;
          $kons['no_hp'] = $value->no_hp;
          $kons['nik'] = $value->nik;
          
          $kons['kecamatan'] = $value->kecamatan;
          $kons['kota'] = $value->kota;
          $kons['provinsi'] = $value->provinsi;
          
          $cekdata = DB::table('tb_konsumen')->where('no_hp',$kons['no_hp'])->get();
          if(count($cekdata) < 1){
              DB::table('tb_konsumen')->insert($kons);
          }
          
          $member['name'] = $value->nama_lengkap;
          $member['email'] = $data['email'];
          $member['no_hp'] = $value->no_hp;
          $member['level'] = $value->jenis_konsumen;
          $member['kode_verifikasi'] = date('Y-m-d');
          $member['kode_referal'] = $value->referal;
          $member['password'] = Hash::make("ad1ch123");
          
          $cekdata2 = DB::table('members')->where('no_hp',$member['no_hp'])->orWhere('email',$member['email'])->get();
          if(count($cekdata2) < 1){
              DB::table('members')->insert($member);
          }
          
          return redirect()->back()->with('success','Berhasil');
      }
  }
  
  public function getagenreseller($id){
      $kar = DB::table('tb_karyawan')->where('id',$id)->get();
      $data = array();
      if(count($kar) > 0){
          $fdkar = array();
          $dkar = DB::table('tb_karyawan')->get();
          foreach($dkar as $key => $val){
              $fdkar[$val->id] = $val;
          }
          
          $data['reseller'] = $kar[0]->referal_by;
          if(isset($fdkar[$kar[0]->referal_by])){
              $data['nama_reseller'] = $fdkar[$kar[0]->referal_by]->nama_lengkap;   
          }
          
          $data['agen'] = $kar[0]->reseller;
          if(isset($fdkar[$kar[0]->reseller])){
              $data['nama_agen'] = $fdkar[$kar[0]->reseller]->nama_lengkap;   
          }
          
          $data['distributor'] = $kar[0]->agen;
          if(isset($fdkar[$kar[0]->agen])){
              $data['nama_distributor'] = $fdkar[$kar[0]->agen]->nama_lengkap;
          }
          
          
          echo json_encode($data);
          
      }
  }
  
}