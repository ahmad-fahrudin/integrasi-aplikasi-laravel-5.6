<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Models\Mase;
use Auth;
use Illuminate\Support\Facades\Hash;
use Crypt;
use Illuminate\Support\Facades\DB;
use Validator,Redirect,Response,File;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class TransaksiController extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function inputtransaksi(){
    if (role()) {
      $data['investor'] = DB::table('tb_investor as a')
                              ->select("*")
                              ->where("a.status","aktif")
                              ->get();
      return view('InputInvestasi',$data);
    }else{
      return view('Denied');
    }
  }

  public function inputsaldo(Request $post){
    if (role()) {
      $data = $post->except('_token');
      $data['saldo'] = str_replace(".","",$data['saldo']);
      $data['old_saldo'] = str_replace(".","",$data['old_saldo']);
      $a['id_investor'] = $data['id'];
      $a['jumlah'] = $data['saldo'];
      $a['saldo_temp'] = $data['old_saldo'] + $data['saldo'];
      $a['jenis'] = "in";
      DB::table('tb_transaksi')->insert($a);

      $b['saldo'] = $a['saldo_temp'];
      DB::table('tb_investor')->where('id','=',$a['id_investor'])->update($b);
      return redirect()->back()->with('success','Berhasil');
    }else{
      return view ('Denied');
    }
  }

  public function datatransaksi(){
      $data['karyawan'] = DB::table('tb_investor as a')
                        ->where("a.status","aktif")
                        ->select("*")->get();
      if (Auth::user()->level == "4" || Auth::user()->level == "1") {
        $data['transaksi'] = DB::table('tb_transaksi as a')
                             ->join('tb_investor as b','b.id','=','a.id_investor')
                             ->leftJoin('tb_bukti_transfer as c','c.id_transaksi','=','a.id')
                             ->select("*","a.keterangan as keterangan_transaksi")
                             ->where("a.status","aktif")
                             ->orderBy("a.id","ASC")
                             ->orderBy("a.tgl_verifikasi","ASC")
                             ->get();
      }else{
        $data['transaksi'] = DB::table('tb_transaksi as a')
                             ->join('tb_investor as b','b.id','=','a.id_investor')
                             ->leftJoin('tb_bukti_transfer as c','c.id_transaksi','=','a.id')
                             ->select("*","a.keterangan as keterangan_transaksi")
                             ->where("a.id_investor",cekmyid_investor())
                             ->where("a.status","aktif")
                             ->orderBy("a.id","ASC")
                             ->orderBy("a.tgl_verifikasi","ASC")
                             ->get();
      }
      $text_barang = DB::table('tb_barang as a')->select("a.*")->get();
      $data['barang'] = array();
      foreach ($text_barang as $value) {
        $data['barang'][$value->id] =$value->nama_barang;
      }
      $text_admin = DB::table('users as a')->select("a.*")->get();
      $data['admin'] = array();
      $data['nama_download'] = "Data Transaksi";
      foreach ($text_admin as $value) {
        $data['admin'][$value->id] =$value->name;
      }
      $text_lock = DB::table('tb_lock_investasi as a')->select("a.*")->get();
      $data['lock'] = array();
      foreach ($text_lock as $key => $value) {
        $data['lock'][$value->id] = $value->share;
      }
        $data['rekening'] = DB::table('tb_rekening as a')
            ->select("*")
            ->where("a.status","aktif")
            ->get();
      return view('Transaksi',$data);
  }

  public function tariktransaksi(){
      if (Auth::user()->level == "4" || Auth::user()->level == "1") {
        $data['pending'] = DB::table('tb_transaksi as a')->join('tb_investor as b','b.id','=','a.id_investor')
                          ->where("a.status","pending")->where("a.jenis","out")
                          ->select("*","a.id as id_tr")->get();
      }else{
        $data['pending'] = DB::table('tb_transaksi as a')
                             ->join('tb_investor as b','b.id','=','a.id_investor')
                             ->select("*","a.id as id_tr")
                             ->where("a.id_investor",cekmyid_investor())
                             ->where("a.status","pending")
                             ->where("a.jenis","out")
                             ->get();
      }
      $investor = DB::table('tb_investor as a')->select("*")->get();
      $data['investor'] = array();
      foreach ($investor as $key => $value) {
        //dd($value);
        $data['investor'][$value->id]['nama_bank'] = $value->nama_bank;
        $data['investor'][$value->id]['no_rekening'] = $value->no_rekening;
        $data['investor'][$value->id]['ats_bank'] = $value->ats_bank;
      }
      $data['pending_pati'] = DB::table('tb_pengadaan_investasi as a')
                              ->select(DB::raw('SUM(a.jumlah_investasi) as jumlah_investasi'))
                              ->where('a.id_pengambil',Auth::user()->id)
                              ->whereNull('a.status')
                              ->get();
      $data['pending_jkt'] = DB::table('tb_pengadaan_investasi_jkt as a')
                              ->select(DB::raw('SUM(a.jumlah_investasi) as jumlah_investasi'))
                              ->where('a.id_pengambil',Auth::user()->id)
                              ->whereNull('a.status')
                              ->get();

      $data['rekening'] = DB::table('tb_rekening as a')
                ->select("*")
                ->where("a.status","aktif")
                ->get();

      return view ('Tarik',$data);
  }

  public function penarikansaldo(Request $post){
      $data = $post->except('_token');
      $data['saldo'] = str_replace(".","",$data['saldo']);
      $u['jumlah'] = $data['saldo'];
      $u['id_investor'] = cekmyid_investor();
      $u['jenis'] = "out";
      $u['saldo_temp'] = saldo();
      $u['status'] = "pending";
      DB::table('tb_transaksi')->insert($u);
      return redirect()->back()->with('success','Berhasil');
  }

  public function inputinvestasi(){
      if (Auth::user()->level == "4" || Auth::user()->level == "1") {
        $data['pending'] = DB::table('tb_transaksi as a')
                          ->join('tb_investor as b','b.id','=','a.id_investor')
                          ->leftJoin('tb_bukti_transfer as c','c.id_transaksi','=','a.id')
                          ->where("a.status","pending")
                          ->where("a.jenis","in")
                          ->select("*","a.id as id_tr")->get();
      }else{
        $data['pending'] = DB::table('tb_transaksi as a')
                             ->join('tb_investor as b','b.id','=','a.id_investor')
                             ->leftJoin('tb_bukti_transfer as c','c.id_transaksi','=','a.id')
                             ->select("*","a.id as id_tr")
                             ->where("a.id_investor",cekmyid_investor())
                             ->where("a.jenis","in")
                             ->where("a.status","pending")
                             ->get();
      }
      $data['rekening'] = DB::table('tb_rekening as a')
                        ->where("a.status","aktif")
                        ->select("*")->get();
      $data['rek'] = array();
      foreach ($data['rekening'] as $key => $value) {
        $data['rek'][$value->id]['nama'] = $value->nama;
        $data['rek'][$value->id]['no_rek'] = $value->no_rekening;
        $data['rek'][$value->id]['ats'] = $value->ats;
      }
      //dd($data);
      return view ('InputInvestasiInvestor',$data);
  }

  public function pengisiansaldo(Request $post){
      $data = $post->except('_token');
      $last = DB::table('tb_transaksi as a')
                        ->select("*")->orderBy("a.id","DESC")->limit(1)->get();

      if (count($last) < 1) {
        $u['id'] = '1';
      }else{
        $u['id'] = $last[0]->id + 1;
      }

      $data['saldo'] = str_replace(".","",$data['saldo']);
      $u['jumlah'] = $data['saldo'];
      $u['id_investor'] = cekmyid_investor();
      $u['jenis'] = "in";
      $u['saldo_temp'] = saldo();
      $u['status'] = "pending";

      $validatedData = $post->validate([
          'file' => 'required|max:1000|mimes:jpeg,png',
      ]);
      if ($validatedData) {
        $image = $post->file('file');
        $s['bukti'] = date('Ymdhis').'.'.$image->getClientOriginalExtension();
        $destinationPath = "gambar/bukti/";
        //$destinationPath = public_path('/bukti');
        $image->move($destinationPath, $s['bukti']);
        $s['id_transaksi'] = $u['id'];
        $s['tgl_transfer'] = $data['tgl_transfer'];
        $s['rekening_tujuan'] = $data['tujuan_rekening'];
        $query = DB::table('tb_transaksi')->insert($u);
        if ($query) {
          $querys = DB::table('tb_bukti_transfer')->insert($s);
        }
        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back()->with('error','Gagal');
      }
  }

  public function uploadbuktitransfer(Request $post){
    if (role()) {
      $data = $post->except('_token');
      $validatedData = $post->validate([
          'file' => 'required|max:1000|mimes:jpeg,png',
      ]);
      if ($validatedData) {
        $image = $post->file('file');
        $u['bukti'] = date('Ymdhis').'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/bukti');
        $image->move($destinationPath, $u['bukti']);
        $u['id_transaksi'] = $data['id_transaksi'];
        DB::table('tb_bukti_transfer')->insert($u);
        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back()->with('error','Gagal');
      }
    }else{
      return view ('Denied');
    }
  }

  public function verifikasitransfer($id){
    if (role()) {
      $d = DB::table('tb_transaksi as a')
           ->join('tb_investor as b','b.id','=','a.id_investor')
           ->select("*")->where('a.id',$id)->get();
      $u['saldo_temp'] = $d[0]->saldo + $d[0]->jumlah;
      $u['status'] = "aktif";
      date_default_timezone_set('Asia/Jakarta');
      $u['tgl_verifikasi'] = date('Y-m-d h:i:s');
      $u['admin'] = Auth::user()->id;
      DB::table('tb_transaksi')->where('id',$id)->update($u);
      $x['saldo'] = $u['saldo_temp'];
      DB::table('tb_investor')->where('id',$d[0]->id_investor)->update($x);
      $status = "berhasil";

        $hd = DB::table('tb_bukti_transfer')->where('id_transaksi',$id)->get();
        $kt['jumlah'] = $d[0]->jumlah;
        $kt['saldo_temp'] = 0;
        $kt['jenis'] = 'in';
        $kt['nama_jenis'] = "Pembiayaan";
        $kt['admin'] = Auth::user()->id;
        $kt['keterangan'] = "Pembiayaan ".$d[0]->nama_investor;
        $kt['kode_bank'] = $hd[0]->rekening_tujuan;
        $q = DB::table('tb_kas_dibank')->insert($kt);


      echo json_encode($status);
    }else{
      return view ('Denied');
    }
  }

  public function canceltransfer($id){
      $d = DB::table('tb_transaksi')->where('id',$id)->delete();
      $e = DB::table('tb_bukti_transfer')->where('id_transaksi',$id)->delete();
      if ($d) {
        $status = "berhasil";
        echo json_encode($status);
      }
  }

  public function verifikasitarik(Request $post){
      if (role()) {
        $dt = $post->except('_token');
        $dt['jumlah'] = str_replace(".","",$dt['jumlah']);
        $d = DB::table('tb_transaksi as a')
             ->join('tb_investor as b','b.id','=','a.id_investor')
             ->select("*")->where('a.id',$dt['id'])->get();

        if ($d[0]->saldo - $d[0]->jumlah > 0) {
          $u['saldo_temp'] = $d[0]->saldo - $d[0]->jumlah + $dt['jumlah'];
          $u['status'] = "aktif";
          date_default_timezone_set('Asia/Jakarta');
          $u['tgl_verifikasi'] = date('Y-m-d h:i:s');
          $u['admin'] = Auth::user()->id;
          $u['jumlah'] = $d[0]->jumlah - $dt['jumlah'];
          DB::table('tb_transaksi')->where('id',$dt['id'])->update($u);

          $a['id_investor'] = $d[0]->id_investor;
          $a['jumlah'] = $dt['jumlah'];
          $a['saldo_temp'] = $u['saldo_temp'] - $dt['jumlah'];
          $a['jenis'] = "potongan";
          $a['admin'] = Auth::user()->id;
          DB::table('tb_transaksi')->insert($a);

          $x['saldo'] = $a['saldo_temp'];
          DB::table('tb_investor')->where('id',$d[0]->id_investor)->update($x);


          if($dt['transaksi'] == "tunai"){
                $kt['jumlah'] = $d[0]->jumlah;
                $kt['saldo_temp'] = 0;
                $kt['jenis'] = 'out';
                $kt['nama_jenis'] = "Angsuran dan Penarikan Investasi";
                $kt['admin'] = Auth::user()->id;
                $kt['keterangan'] = "Penarikan Investasi ".$d[0]->nama_investor;
                $q = DB::table('tb_kas_ditangan')->insert($kt);
          }else if($dt['transaksi'] == "transfer"){
                $kt['jumlah'] = $d[0]->jumlah;
                $kt['saldo_temp'] = 0;
                $kt['jenis'] = 'out';
                $kt['nama_jenis'] = "Angsuran / Penarikan Investasi";
                $kt['admin'] = Auth::user()->id;
                $kt['keterangan'] = "Penarikan Investasi ".$d[0]->nama_investor;
                $kt['kode_bank'] = $dt['rekening'];
                $q = DB::table('tb_kas_dibank')->insert($kt);
          }


          return redirect()->back()->with('success','Berhasil');
        }else{
          return redirect()->back()->withErrors(['msg', 'The Message']);
        }

      }else{
        return view ('Denied');
      }
  }

  public function batalkantarik($id){
    DB::table('tb_transaksi')->where('id',$id)->delete();
    $u['status'] = "success";
    echo json_encode($u);
  }

  public function prosesinvestasi(Request $post){
    $data = $post->except('_token');
    $data['jumlah'] = str_replace(".","",$data['jumlah']);
    $data['old_saldo'] = str_replace(".","",$data['old_saldo']);
    $a['id_investor'] = $data['id_karyawan'];
    $a['jumlah'] = $data['jumlah'];
    if ($data['jenis'] == "revisi") {
      $a['saldo_temp'] = $data['old_saldo'] + $data['jumlah'];
    }else{
      $a['saldo_temp'] = $data['old_saldo'] - $data['jumlah'];
    }
    $a['jenis'] = $data['jenis'];
    $a['tgl_transaksi'] = $data['tgl_transaksi'];
    $a['keterangan'] = $data['keterangan'];
    $a['admin'] = Auth::user()->id;
    if ($data['jenis'] == "out"){
        $a['tgl_verifikasi'] = date('Y-m-d h:i:s');
    }
    DB::table('tb_transaksi')->insert($a);
    $b['saldo'] = $a['saldo_temp'];
    DB::table('tb_investor')->where('id','=',$a['id_investor'])->update($b);

    if ($data['jenis'] == "out") {
     $investor = DB::table('tb_investor')->where('id',$a['id_investor'])->get();
     if($data['transaksi'] == "tunai"){
            $kt['jumlah'] = $data['jumlah'];
            $kt['saldo_temp'] = 0;
            $kt['jenis'] = $data['cek'];
            $kt['nama_jenis'] = "Angsuran dan Penarikan Investasi";
            $kt['admin'] = Auth::user()->id;
            $kt['keterangan'] = "Pengambilan Investasi ".$investor[0]->nama_investor;
            $q = DB::table('tb_kas_ditangan')->insert($kt);
      }else if($data['transaksi'] == "transfer"){
            $kt['jumlah'] = $data['jumlah'];
            $kt['saldo_temp'] = 0;
            $kt['jenis'] = $data['cek'];
            $kt['nama_jenis'] = "Angsuran dan Penarikan Investasi";
            $kt['admin'] = Auth::user()->id;
            $kt['keterangan'] = "Pengambilan Investasi ".$investor[0]->nama_investor;
            $kt['kode_bank'] = $data['rekening'];
            $q = DB::table('tb_kas_dibank')->insert($kt);
      }
    }


    return redirect()->back()->with('success','Berhasil');
  }

}
