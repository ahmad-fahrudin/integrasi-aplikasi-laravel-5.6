<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Models\Mase;
use App\Models\m_bahan_baku;
use App\Models\Universe;
use Auth;
use Hash;
use Crypt;
use Illuminate\Support\Facades\DB;
use Validator,Redirect,Response,File;
use DateTime;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;


class GenController extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

    public function input_nama_devisi(){
        return view('administrasi.in_daftar_nama_devisi');
    }
    public function daftar_nama_devisi(){
        $data['divisi'] = DB::table('pay_divisi')->get();
        return view('administrasi.in_daftar_nama_devisi',$data);
    }
    public function cekabsen($tgl,$id){
        $data = DB::table('pay_absensi')
                ->where('tanggal_hadir',$tgl)->where('id_karyawan',$id)
                //->where('tanggal_tidak_hadir',$tgl)->where('id_karyawan',$id)
                ->get();
        echo json_encode($data);
    }
    public function tambah_nama_divisi(Request $post){
        $data = $post->except('_token');
        $q = DB::table('pay_divisi')->insert($data);
        if($q){
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }
    public function simpan_divisi(Request $post){
        $data = $post->except('_token');
        $q = DB::table('pay_divisi')->where('id_divisi',$post->id_divisi)->update($data);
        if($q){
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }
    public function delete_divisi($id){
        $q = DB::table('pay_divisi')->where('id_divisi',$id)->delete();
        if($q){
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }


    public function input_nama_pekerja(){
        $data['divisi'] = DB::table('pay_divisi')->get();
        $d = DB::table('pay_pekerja')->orderBy('dt','DESC')->limit(1)->get();
        if(count($d)>0){
            $number = explode("P",$d[0]->no_id_pekerjaan);
            $data['number'] = str_pad($number[1]+1,3,"0",STR_PAD_LEFT);
        }else{
            $data['number'] = "001";
        }
        return view('administrasi.in_input_nama_pekerja',$data);
    }
    public function tambah_nama_pekerjaan(Request $post){
        $data = $post->except('_token','no_id_pekerjaan');
        $d = DB::table('pay_pekerja')->orderBy('dt','DESC')->limit(1)->get();
        if(count($d)>0){
            $number = explode("P",$d[0]->no_id_pekerjaan);
            $data['no_id_pekerjaan'] = "P".str_pad($number[1]+1,3,"0",STR_PAD_LEFT);
        }else{
            $data['no_id_pekerjaan'] = "P001";
        }
         
        $q = DB::table('pay_pekerja')->insert($data);
        if($q){
           
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }
    public function daftar_nama_pekerja(){
        $data['divisi'] = DB::table('pay_divisi')->get();
        $data['pekerjaan'] = DB::table('pay_pekerja')
                             ->leftJoin('pay_divisi','pay_divisi.id_divisi','pay_pekerja.id_divisi')->get();
        return view('administrasi.in_daftar_nama_pekerja',$data);
    }
    public function simpan_pekerjaan(Request $post){
        $data = $post->except('_token','upah_persatuan','id_upah');
        $q = DB::table('pay_pekerja')->where('no_id_pekerjaan',$post->no_id_pekerjaan)->update($data);
        
        if($q){
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }
    public function delete_pekerjaan($id){
        $status['status'] = 'non aktif';
        $q = DB::table('pay_pekerja')->where('no_id_pekerjaan',$id)->update($status);
        if($q){
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }


    public function input_satuan_barang(){
        $data['level'] = DB::table('tb_level')->get();
        $data['data'] = DB::table('pay_pekerja')
                        ->leftJoin('pay_divisi','pay_divisi.id_divisi','pay_pekerja.id_divisi')
                        ->whereNull("inputed")->get();
        return view('administrasi.in_input_satuan_barang',$data);
    }
    public function tambah_satuan_barang(Request $post){
        $data = $post->except('_token');
        $user['status_pekerja'] = $post->status_pekerja;
        $user['no_id_pekerjaan'] = $post->no_id_pekerjaan;
        $user['harga_satuan'] = $post->harga_satuan;
        $q = DB::table('pay_upah_satuan_barang')->insert($user);
        if($q){
            $upd['inputed'] = "yes";
            DB::table('pay_pekerja')->where('no_id_pekerjaan',$data['no_id_pekerjaan'])->update($upd); 
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }
    public function daftar_satuan_barang(){
        $divisi = DB::table('pay_divisi')->get();
        foreach($divisi as $key => $value){
            $data['divisi'][$value->id_divisi] = $value;
        }
        $data['data'] = DB::table('pay_upah_satuan_barang')->join('pay_pekerja','pay_pekerja.no_id_pekerjaan','pay_upah_satuan_barang.no_id_pekerjaan')->get();
        return view('administrasi.in_daftar_satuan_barang',$data);
    }
    public function simpan_satuan_barang(Request $post){
        $data = $post->except('_token');
        $user['status_pekerja'] = $post->status_pekerja;
        $user['no_id_pekerjaan'] = $post->no_id_pekerjaan;
        $user['harga_satuan'] = $post->harga_satuan;
        $q = DB::table('pay_upah_satuan_barang')->where('id',$post->id)->update($user);
        if($q){
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }
    public function delete_satuan_barang($id){
        $q = DB::table('pay_upah_satuan_barang')->where('id',$id)->delete();
        if($q){
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }



    public function input_per_kategori_kerja(){
        return view('administrasi.in_input_per_kategori_kerja');
    }
    public function tambah_upah_kategori_kerja(Request $post){
        $data = $post->except('_token');
        $q = DB::table('pay_upah_kategori_kerja')->insert($data);
        if($q){
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }
    public function daftar_per_kategori_kerja(){
        $data['data'] = DB::table('pay_upah_kategori_kerja')->get();
        return view('administrasi.in_daftar_per_kategori_kerja',$data);
    }
    public function simpan_upah_kategori_kerja(Request $post){
        $data = $post->except('_token');
        $q = DB::table('pay_upah_kategori_kerja')->where('id',$post->id)->update($data);
        if($q){
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }
    public function delete_upah_kategori_kerja($id){
        $q = DB::table('pay_upah_kategori_kerja')->where('id',$id)->delete();
        if($q){
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }
    public function input_absensi_karyawan(){
        $data['karyawan'] = DB::table('tb_karyawan')->select("*")->where("status","=","aktif")->whereNull("jenis_konsumen")->orWhere("jenis_konsumen",'>',4)->get();
        $data['divisi'] = DB::table('pay_divisi')->get();
        return view('administrasi.in_input_absensi_karyawan',$data);
    }
    public function tambah_absensi(Request $posts){
        $data = $posts->except('_token');
        $post['id_karyawan'] = $data['id'];
        $post['status_kehadiran'] = $data['status_kehadiran'];
        
        if($post['status_kehadiran'] == "hadir"){
            $post['tanggal_hadir'] = $data['tanggal_hadir'];
            $post['jam_masuk'] = $data['jam_masuk'];
            $post['jam_pulang'] = $data['jam_pulang'];
            DB::table('pay_absensi')->where('tanggal_hadir',$data['tanggal_hadir'])->where('id_karyawan',$data['id'])->delete();
            DB::table('pay_absensi')->where('tanggal_tidak_hadir',$data['tanggal_hadir'])->where('id_karyawan',$data['id'])->delete();
            
        }else{
            $post['tanggal_tidak_hadir'] = $data['tanggal_tidak_hadir'];
            $post['keterangan'] = $data['keterangan'];
            DB::table('pay_absensi')->where('tanggal_tidak_hadir',$data['tanggal_tidak_hadir'])->where('id_karyawan',$data['id'])->delete();
            DB::table('pay_absensi')->where('tanggal_hadir',$data['tanggal_tidak_hadir'])->where('id_karyawan',$data['id'])->delete();
            
        }
        
            $q = DB::table('pay_absensi')->insert($post);
            if($q){
                return redirect()->back()->with(['success' => 'Berhasil']);
            }else{
                return redirect()->back()->with(['error' => 'Gagal']);
            }
       
    }
    public function daftar_absensi_karyawan(){
       
        $div = DB::table('pay_divisi')->get();
        $data['divisi'] = array();
        foreach($div as $key => $value){
            $data['divisi'][$value->id_divisi] = $value;
        }
        $data['data'] = DB::table('pay_absensi')->whereMonth('tanggal_hadir',date('m'))->orWhereMonth('tanggal_tidak_hadir',date('m'))->get();
        $kar = DB::table('tb_karyawan')->select("*")->where("status","=","aktif")->whereNull("jenis_konsumen")->orWhere("jenis_konsumen",'>',4)->get();
        $data['karyawan'] = array();
        foreach($kar as $key => $value){
            $data['karyawan'][$value->id] = $value;
        }
        return view('administrasi.in_daftar_absensi_karyawan',$data);
    }
    public function daftar_absensi_karyawans(Request $post){
        $dat = $post->except('_token');
        $data['mulai'] = $dat['mulai'];
        $data['sampai'] = $dat['sampai'];
        $data['data'] = DB::table('pay_absensi')
             ->whereBetween('tanggal_hadir', [$dat['mulai'], $dat['sampai']])
             ->orWhereBetween('tanggal_tidak_hadir', [$dat['mulai'], $dat['sampai']])
             ->get();
        //$data['data'] = array();
        $data['tanggal'] = array();
        $div = DB::table('pay_divisi')->get();
        $data['divisi'] = array();
        foreach($div as $key => $value){
            $data['divisi'][$value->id_divisi] = $value;
        }
        
        
        $kar = DB::table('tb_karyawan')->select("*")->where("status","=","aktif")->whereNull("jenis_konsumen")->orWhere("jenis_konsumen",'>',4)->get();
        $data['karyawan'] = array();
        foreach($kar as $key => $value){
            $data['karyawan'][$value->id] = $value;
        }
        return view('administrasi.in_daftar_absensi_karyawan',$data);
    }
    public function input_ketentuan_absensi(){
        return view('administrasi.in_input_ketentuan_absensi');
    }
    public function tambah_ketentuan_absen(Request $post){
        $data = $post->except('_token');
        $cek = DB::table('pay_ketentuan_absen')->where('shift_kerja',$post->shift_kerja)->get();
        if(count($cek)>0){
            $q = DB::table('pay_ketentuan_absen')->where('shift_kerja',$post->shift_kerja)->update($data);
        }else{
            $q = DB::table('pay_ketentuan_absen')->insert($data);
        }
        if($q){
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }
    public function daftar_ketentuan_absensi(){
        $data['data'] = DB::table('pay_ketentuan_absen')->get();
        return view('administrasi.in_daftar_ketentuan_absensi',$data);
    }
    public function update_ketentuan_absen(Request $post){
        $data = $post->except('_token');
        $cek = DB::table('pay_ketentuan_absen')->where('shift_kerja',$post->shift_kerja)->where('hari',$post->hari)->get();
        if(count($cek)>0){
            $q = DB::table('pay_ketentuan_absen')->where('shift_kerja',$post->shift_kerja)->where('hari',$post->hari)->update($data);
        }else{
            $q = DB::table('pay_ketentuan_absen')->insert($data);
        }
        if($q){
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }


    public function input_kinerja_karyawan(){
        if(Auth::user()->level == 1 || Auth::user()->level == 3){
            $data['divisi'] = DB::table('pay_divisi')->get();
        }else{
            $data['divisi'] = DB::table('pay_divisi')->where('id_divisi',Auth::user()->id_divisi)->get();
        }
        
        $div = DB::table('pay_divisi')->get();
        $data['divisis'] = array();
        foreach($div as $key => $value){
            $data['divisis'][$value->id_divisi] = $value;
        }
        
        $data['karyawan'] = DB::table('tb_karyawan')->select("*")->where("status","=","aktif")->whereNull("jenis_konsumen")->orWhere("jenis_konsumen",'>',4)->get();
        if(Auth::user()->level == 1 || Auth::user()->level == 3){
            $data['pekerjaan'] = DB::table('pay_pekerja')
                                 ->join('pay_divisi','pay_divisi.id_divisi','pay_pekerja.id_divisi')->where('status','aktif')->get();
        }else{
            $data['pekerjaan'] = DB::table('pay_pekerja')
            ->leftJoin('pay_divisi','pay_divisi.id_divisi','pay_pekerja.id_divisi')
            ->where('pay_divisi.id_divisi',Auth::user()->id_divisi)->get();
        }
        
        $data['kategori'] = DB::table('pay_ketentuan_absen')->get();
        
        $last = DB::table('pay_kienerja_karyawan')->orderBy('id_p','DESC')->get();
        $nb = 0;
        foreach($last as $key => $value){
            $ex = explode("/",$value->no_job);
            if($nb <= (int)$ex[0]){
                $nb = (int)$ex[0];
            }
        }
        $nb += 1;
        $data['nmb'] = str_pad($nb,4,"0",STR_PAD_LEFT);
        
        /*if(count($last)>0){
            $ex = explode("/",$last[0]->no_job);
            $data['nmb'] = str_pad($ex[0]+1,4,"0",STR_PAD_LEFT);
        }else{
            $data['nmb'] = "0001";
        }*/
        
        return view('administrasi.in_input_kinerja_karyawan',$data);
    }
    public function postkinerjakaryawan(Request $post){
        $data = $post->except('_token','no_job','divisi','supervisor','nama_pekerjaan','kategori_kerja','jumlah','jam_kerja','menit_kerja');
        
        
        /*$last = DB::table('pay_kienerja_karyawan')->orderBy('id','DESC')->limit(1)->get();
        if(count($last)>0){
            $ex = explode("/",$last[0]->no_job);
            $nmb = str_pad($ex[0]+1,4,"0",STR_PAD_LEFT);
        }else{
            $nmb = "0001";
        }*/
        $last = DB::table('pay_kienerja_karyawan')->orderBy('id_p','DESC')->get();
        $nb = 0;
        foreach($last as $key => $value){
            $ex = explode("/",$value->no_job);
            if($nb <= (int)$ex[0]){
                $nb = (int)$ex[0];
            }
        }
        $nb += 1;
        $nmb = str_pad($nb,4,"0",STR_PAD_LEFT);
        
        
        
        $data['no_job'] = $nmb."/".date('m/y');
        
        $div = DB::table('pay_divisi')->where('id_divisi',$post->divisi)->get();
        $data['divisi'] = $div[0]->id_divisi;
        $data['supervisor'] = Auth::user()->id;
        
        $nama_pekerjaan = explode("|",$post->nama_pekerjaan);
        $kategori_kerja = explode("|",$post->kategori_kerja);
        $jumlah = explode("|",$post->jumlah);
        $jam_kerja = explode("|",$post->jam_kerja);
        $menit_kerja = explode("|",$post->menit_kerja);

        for($i=0; $i < count($nama_pekerjaan); $i++){
            $ddx = explode(" - ",$nama_pekerjaan[$i]);
            $data['nama_pekerjaan'] = $ddx[0];
            $data['kategori_kerja'] = $kategori_kerja[$i];
            $data['jumlah'] = $jumlah[$i];
            if($data['nama_pekerjaan'] !== "" && $data['nama_pekerjaan'] !== null){
                if($menit_kerja[$i] > 0){
                    $menit = $menit_kerja[$i] / 60;
                }else{
                    $menit = 0;
                }
                $data['jam_kerja'] = $jam_kerja[$i] + $menit;
                DB::table('pay_kienerja_karyawan')->insert($data);
            }
        }
        echo json_encode($data);
    }

    public function savekinerjakaryawan(Request $post){
        $data = $post->except('_token','no_job','divisi','supervisor','nama_pekerjaan','kategori_kerja','jumlah','jam_kerja');
        $data['no_job'] = $post->no_job;
        $data['divisi'] = $post->divisi;
        $data['supervisor'] = $post->supervisor;
        
        $nama_pekerjaan = explode("|",$post->nama_pekerjaan);
        $kategori_kerja = explode("|",$post->kategori_kerja);
        $jumlah = explode("|",$post->jumlah);
        $jam_kerja = explode("|",$post->jam_kerja);
               
        $del = DB::table('pay_kienerja_karyawan')->where('no_job',$post->no_job)->delete();
        if($del){
            for($i=0; $i < count($nama_pekerjaan); $i++){
                $ddx = explode(" - ",$nama_pekerjaan[$i]);
                $data['nama_pekerjaan'] = $ddx[0];
                $data['kategori_kerja'] = $kategori_kerja[$i];
                $data['jumlah'] = $jumlah[$i];
                $data['jam_kerja'] = $jam_kerja[$i];
                if($data['nama_pekerjaan'] !== "" && $data['nama_pekerjaan'] !== null){
                    DB::table('pay_kienerja_karyawan')->insert($data);
                }
            }
            echo json_encode($data);
        }
    }

    public function data_penilaian_kinerja(){
        if(Auth::user()->level == 1){
            $data['data'] = DB::table('pay_kienerja_karyawan')->get();
        }else{
            $data['data'] = DB::table('pay_kienerja_karyawan')->where('supervisor',Auth::user()->id)->get();
        }
        
        
        $kar = DB::table('tb_karyawan')->select("*")->where("status","=","aktif")->whereNull("jenis_konsumen")->orWhere("jenis_konsumen",'>',4)->get();
        $data['karyawan'] = array();
        foreach($kar as $key => $value){
            $data['karyawan'][$value->id] = $value;
        }
        $div = DB::table('pay_divisi')->get();
        $data['divisi'] = array();
        foreach($div as $key => $value){
            $data['divisi'][$value->id_divisi] = $value;
        }
        $kerja = DB::table('pay_pekerja')->get();
        $data['pekerja'] = array();
        foreach($kerja as $key => $value){
            $data['pekerja'][$value->no_id_pekerjaan] = $value;
        }
        $sup = DB::table('users')->get();
        $data['supervisor'] = array();
        foreach($sup as $key => $value){
            $data['supervisor'][$value->id] = $value;
        }
        
        return view('administrasi.in_data_penilaian_kinerja',$data);
    }
    
    public function data_penilaian_kinerjas(Request $post){
        $dat = $post->except('_token');
        $key = array();
        
        if(Auth::user()->level == 1){
            if($dat['id_karyawan'] !== null && $dat['id_karyawan'] !== ""){
                $key["pay_kienerja_karyawan.id_p"] = $dat['id_karyawan'];
                $data['nama_karyawan'] = $dat['nama_karyawan'];
                $data['id_karyawan'] = $dat['id_karyawan'];
            }
            if($dat['id_divisi'] !== null && $dat['id_divisi'] !== ""){
                $key["pay_kienerja_karyawan.divisi"] = $dat['id_divisi'];
                $data['nama_divisi'] = $dat['nama_divisi'];
                $data['id_divisi'] = $dat['id_divisi'];
            }
            if($dat['mulai'] !== null && $dat['mulai'] !== "" && $dat['sampai'] !== null && $dat['sampai'] !== ""){
                $data['mulai'] = $dat['mulai'];
                $data['sampai'] = $dat['sampai'];
                $data['data'] = DB::table('pay_kienerja_karyawan')
                    ->select('pay_kienerja_karyawan.*')
                    ->whereBetween('tanggal', [$dat['mulai'], $dat['sampai']])
                    ->where($key)->get();   
            }else{
                $data['data'] = DB::table('pay_kienerja_karyawan')
                    ->select('pay_kienerja_karyawan.*')
                    ->where($key)->get();
            }
        }else{
            if($dat['id_karyawan'] !== null && $dat['id_karyawan'] !== ""){
                $key["pay_kienerja_karyawan.id_p"] = $dat['id_karyawan'];
                $data['nama_karyawan'] = $dat['nama_karyawan'];
                $data['id_karyawan'] = $dat['id_karyawan'];
            }
            if($dat['id_divisi'] !== null && $dat['id_divisi'] !== ""){
                $key["pay_kienerja_karyawan.divisi"] = $dat['id_divisi'];
                $data['nama_divisi'] = $dat['nama_divisi'];
                $data['id_divisi'] = $dat['id_divisi'];
            }
            if($dat['mulai'] !== null && $dat['mulai'] !== "" && $dat['sampai'] !== null && $dat['sampai'] !== ""){
                $data['mulai'] = $dat['mulai'];
                $data['sampai'] = $dat['sampai'];
                $data['data'] = DB::table('pay_kienerja_karyawan')
                    ->select('pay_kienerja_karyawan.*')
                    ->where('supervisor',Auth::user()->id)
                    ->whereBetween('tanggal', [$dat['mulai'], $dat['sampai']])
                    ->where($key)->get();   
            }else{
                $data['data'] = DB::table('pay_kienerja_karyawan')
                    ->select('pay_kienerja_karyawan.*')
                    ->where('supervisor',Auth::user()->id)
                    ->where($key)->get();
            }
        }
        
        
        $kar = DB::table('tb_karyawan')->select("*")->where("status","=","aktif")->whereNull("jenis_konsumen")->orWhere("jenis_konsumen",'>',4)->get();
        $data['karyawan'] = array();
        foreach($kar as $key => $value){
            $data['karyawan'][$value->id] = $value;
        }
        $div = DB::table('pay_divisi')->get();
        $data['divisi'] = array();
        foreach($div as $key => $value){
            $data['divisi'][$value->id_divisi] = $value;
        }
        $kerja = DB::table('pay_pekerja')->get();
        $data['pekerja'] = array();
        foreach($kerja as $key => $value){
            $data['pekerja'][$value->no_id_pekerjaan] = $value;
        }
        $sup = DB::table('users')->get();
        $data['supervisor'] = array();
        foreach($sup as $key => $value){
            $data['supervisor'][$value->id] = $value;
        }
        
        return view('administrasi.in_data_penilaian_kinerja',$data);
    }
    
    public function edit_kinerja_karyawan($no,$bul,$tah){
        $data['data'] = DB::table('pay_kienerja_karyawan')->leftJoin('pay_pekerja','pay_pekerja.no_id_pekerjaan','pay_kienerja_karyawan.nama_pekerjaan')->where('no_job',$no."/".$bul."/".$tah)->select('pay_kienerja_karyawan.*','pay_pekerja.nama_pekerjaan as nm_pk')->get();

        if(count($data['data'])>0){
            $data['divisi'] = DB::table('pay_divisi')->where('id_divisi',$data['data'][0]->divisi)->first();
            $data['supervisor'] = DB::table('users')->where('id',$data['data'][0]->supervisor)->first();
            $data['karyawan'] = DB::table('tb_karyawan')->where('id',$data['data'][0]->id_karyawan)->get();
            if(Auth::user()->level == 1){
                $data['pekerjaan'] = DB::table('pay_pekerja')->get();
            }else{
                $data['pekerjaan'] = DB::table('pay_pekerja')->where('id_divisi',Auth::user()->id_divisi)->get();
            }
            $data['kategori'] = DB::table('pay_ketentuan_absen')->get();
            $last = DB::table('pay_kienerja_karyawan')->orderBy('id','DESC')->limit(1)->get();
            if(count($last)>0){
                $ex = explode("/",$last[0]->no_job);
                $data['nmb'] = str_pad($ex[0]+1,4,"0",STR_PAD_LEFT);
            }else{
                $data['nmb'] = "0001";
            }
            return view('administrasi.in_edit_kinerja_karyawan',$data);
        }else{
            return redirect()->back();
        }
    }
    public function delete_penilaian_kinerja($id){
        $q = DB::table('pay_kienerja_karyawan')->where('id',$id)->delete();
        if($q){
            return redirect()->back()->with(['success' => 'Berhasil']);
        }else{
            return redirect()->back()->with(['error' => 'Gagal']);
        }
    }

    public function input_perhitungan_upah(){
        $data['divisi'] = DB::table('pay_divisi')->where('id_divisi',Auth::user()->id_divisi)->first();
        $data['karyawan'] = DB::table('tb_karyawan')->select("*")->where("status","=","aktif")->whereNull("jenis_konsumen")->orWhere("jenis_konsumen",'>',4)->get();
        if(Auth::user()->level == 1){
            $data['pekerjaan'] = DB::table('pay_pekerja')->get();
        }else{
            $data['pekerjaan'] = DB::table('pay_pekerja')->where('id_divisi',Auth::user()->id_divisi)->get();
        }
        $data['kategori'] = DB::table('pay_ketentuan_absen')->get();
        $last = DB::table('pay_upah')->orderBy('id','DESC')->limit(1)->get();
        if(count($last)>0){
            $ex = explode("/",$last[0]->no_id_upah);
            $ac = explode("-",$ex[0]);
            $data['nmb'] = str_pad($ac[1]+1,4,"0",STR_PAD_LEFT);
        }else{
            $data['nmb'] = "0001";
        }
        return view('administrasi.in_input_perhitungan_upah',$data);   
    }

    public function getkinerja($mulai,$sampai,$id_karyawan){
        $data = DB::table('pay_kienerja_karyawan')
                ->leftJoin('pay_divisi','pay_divisi.id_divisi','pay_kienerja_karyawan.divisi')->where('id_karyawan',$id_karyawan)->whereBetween('tanggal', [$mulai, $sampai])->whereNull('status')
                ->select("pay_kienerja_karyawan.*","pay_divisi.nama_divisi")->get();
        foreach($data as $key => $value){
            $data[$key]->jam_kerja_floor = floor($value->jam_kerja);
            $data[$key]->menit_kerja_floor = round(($value->jam_kerja - floor($value->jam_kerja))*60);
        }
        echo json_encode($data);
    }

    public function postperhitunganupah(Request $post){
        $data = $post->except('_token');
        $last = DB::table('pay_upah')->orderBy('id','DESC')->limit(1)->get();
        if(count($last)>0){
            $ex = explode("/",$last[0]->no_id_upah);
            $ac = explode("-",$ex[0]);
            $nmb = str_pad($ac[1]+1,4,"0",STR_PAD_LEFT);
        }else{
            $nmb = "0001";
        }
        $data['no_id_upah'] = "G-".$nmb."/".date('m/y');

        $id_job = explode("|",$post->id_job);

        for($i=0; $i < count($id_job); $i++){
            $data['id_job'] = $id_job[$i];
            if($data['id_job'] !== "" && $data['id_job'] !== null){
                $q = DB::table('pay_upah')->insert($data);
                if($q){
                    $st['status'] = "use";
                    DB::table('pay_kienerja_karyawan')->where('id',$data['id_job'])->update($st);
                }
            }
        }
        echo json_encode($data);
    }
    public function data_perhitungan_upahs(Request $post){
        $dat = $post->except('_token');
        $key = array();
        if($dat['id_karyawan'] !== null && $dat['id_karyawan'] !== ""){
            $key["a.id_karyawan"] = $dat['id_karyawan'];
            $data['nama_karyawan'] = $dat['nama_karyawan'];
            $data['id_karyawan'] = $dat['id_karyawan'];
        }
        if($dat['id_divisi'] !== null && $dat['id_divisi'] !== ""){
            $key["divisi"] = $dat['id_divisi'];
            $data['nama_divisi'] = $dat['nama_divisi'];
            $data['id_divisi'] = $dat['id_divisi'];
        }
        $key["status_penggajian"] = $dat["status_penggajian"];
        $key["status_pembayaran"] = $dat["status_pembayaran"];
        $data["status_penggajian"] = $dat["status_penggajian"];
        $data["status_pembayaran"] = $dat["status_pembayaran"];
        
        if($dat['mulai'] !== null && $dat['mulai'] !== "" && $dat['sampai'] !== null && $dat['sampai'] !== ""){
            $data['mulai'] = $dat['mulai'];
            $data['sampai'] = $dat['sampai'];
            $data['data'] = DB::table('pay_upah as a')
                ->join('pay_kienerja_karyawan as b','a.id_job','b.id_p')
                ->whereBetween('tanggal', [$dat['mulai'], $dat['sampai']])
                ->where($key)
                ->get();   
        }else{
            $data['data'] = DB::table('pay_upah as a')
                ->join('pay_kienerja_karyawan as b','a.id_job','b.id_p')
                ->where($key)
                ->get();
        }
        
        $kar = DB::table('tb_karyawan')->select("*")->where("status","=","aktif")->whereNull("jenis_konsumen")->orWhere("jenis_konsumen",'>',4)->get();
        $data['karyawan'] = array();
        foreach($kar as $key => $value){
            $data['karyawan'][$value->id] = $value;
        }

        $div = DB::table('pay_divisi')->get();
        $data['divisi'] = array();
        foreach($div as $key => $value){
            $data['divisi'][$value->id_divisi] = $value;
        }
        
        $kerja = DB::table('pay_pekerja')->get();
        $data['pekerja'] = array();
        foreach($kerja as $key => $value){
            $data['pekerja'][$value->no_id_pekerjaan] = $value;
        }

        $sup = DB::table('users')->get();
        $data['supervisor'] = array();
        foreach($sup as $key => $value){
            $data['supervisor'][$value->id] = $value;
        }
        
        return view('administrasi.in_data_perhitungan_upah',$data);
    }
    public function data_perhitungan_upah(){
        $data['data'] = DB::table('pay_upah as a')
                        ->join('pay_kienerja_karyawan as b','a.id_job','b.id_p')
                        ->get();
        $kar = DB::table('tb_karyawan')->get();
        $data['karyawan'] = array();
        foreach($kar as $key => $value){
            $data['karyawan'][$value->id] = $value;
        }

        $div = DB::table('pay_divisi')->get();
        $data['divisi'] = array();
        foreach($div as $key => $value){
            $data['divisi'][$value->id_divisi] = $value;
        }
        
        $kerja = DB::table('pay_pekerja')->get();
        $data['pekerja'] = array();
        foreach($kerja as $key => $value){
            $data['pekerja'][$value->no_id_pekerjaan] = $value;
        }

        $sup = DB::table('users')->get();
        $data['supervisor'] = array();
        foreach($sup as $key => $value){
            $data['supervisor'][$value->id] = $value;
        }
        
        return view('administrasi.in_data_perhitungan_upah',$data);
    }

    public function buat_slip_gaji(){
        $data['karyawan'] = DB::table('tb_karyawan')->select("*")->where("status","=","aktif")->whereNull("jenis_konsumen")->orWhere("jenis_konsumen",'>',4)->get();
        $data['upah'] = DB::table('pay_upah')->where('status_pembayaran','Proses')->groupBy('no_id_upah')->get();
        return view('administrasi.in_buat_slip_gaji',$data);   
    }

    public function cekgaji($urut,$bl,$th){
        $kerja = DB::table('pay_pekerja')->get();
        $pekerja = array();
        foreach($kerja as $key => $value){
            $pekerja[$value->no_id_pekerjaan] = $value;
        }
        
        $data['upah'] = DB::table('pay_upah as a')->where('no_id_upah',$urut."/".$bl."/".$th)->leftJoin('pay_kienerja_karyawan as b','a.id_job','b.id_p')->get();

        $gaji = 0;
        $persentase = 0;
        $jumlahdata = 0;
        $variabel_upah = variableupah(); 
        $variableupahborongan = variableupahborongan();
        
        foreach($data['upah'] as $key => $value){
            if($value->nama_pekerjaan !== null){
            //dd($pekerja[$value->nama_pekerjaan]->target);
            //dd($value->jam_kerja);
            if($pekerja[$value->nama_pekerjaan]->target * $value->jam_kerja > 0){
                $persentase += $value->jumlah/($pekerja[$value->nama_pekerjaan]->target * $value->jam_kerja)*100;
            }
            $jumlahdata += 1;
            
            if($value->status_penggajian == "Borongan"){
                $vup = $variableupahborongan[strtolower($value->status_penggajian)][$value->nama_pekerjaan]; 
            }else{
                $vup = $variabel_upah[strtolower($value->status_penggajian)][$value->kategori_kerja];
            }
            
            if($value->status_penggajian == "Borongan"){
                if($value->kategori_kerja == "Shift 2"){
                    //$gaji += (($value->jumlah * $vup) + 2000);
                    $gaji += (($value->jumlah * $vup));
                }else{
                    $gaji += ($value->jumlah * $vup);
                }
            }else{
                $gaji += ($value->jam_kerja * $vup);
            }
            }
            
            /*if($value->status_penggajian == "Borongan"){
                if($value->kategori_kerja == "Shift 2"){
                    $gaji += (($value->jumlah * $variabel_upah[strtolower($value->status_penggajian)][$value->kategori_kerja]) + ($value->jam_kerja * 2000));
                }else{
                    $gaji += ($value->jumlah * $variabel_upah[strtolower($value->status_penggajian)][$value->kategori_kerja]);
                }
            }else{
                $gaji += ($value->jam_kerja * $variabel_upah[strtolower($value->status_penggajian)][$value->kategori_kerja]);
            } */
        }

        $hasil = round($persentase / $jumlahdata,2);
        if($hasil > 50){
            $realissasi = 150000;
        }else{
            $realissasi = 0;
        }
        $upx['gaji'] = round($gaji);
        $upx['bonus'] = round($realissasi);
        $upx['hasil'] = round($hasil,2);
        echo json_encode($upx);
    }

    public function cekabsensi($id,$mulai,$selesai){
        $data['masuk'] = 0;
        $data['tidak_masuk'] = 0;
        $data['sakit'] = 0;
        $data['izin'] = 0;
        $data['alfa'] = 0;
        $data['cuti'] = 0;
        $data['libur'] = 0;
        $data['terlambat'] = 0;
        $data['pulang_cepat'] = 0;

        $ketentuan_absen = DB::table('pay_ketentuan_absen')->get();
        $shift1 = array();
        $shift2 = array();
        foreach($ketentuan_absen as $key => $value){
            $endTime = strtotime("+15 minutes", strtotime($value->jam_masuk));
            $jam_masuk = date('h:i:s', $endTime);
            if($value->shift_kerja == "Shift 1"){
                $shift1['masuk_flag'] = $jam_masuk;
                $shift1['masuk'] = $value->jam_masuk;
                $shift1['pulang'] = $value->jam_pulang;
            }
            if($value->shift_kerja == "Shift 2"){
                $shift2['masuk_flag'] = $jam_masuk;
                $shift1['masuk'] = $value->jam_masuk;                
                $shift2['pulang'] = $value->jam_pulang;
            }
        }
        $data['uang_kopi'] = 0;
        $datax = DB::table('pay_absensi as a')
        ->whereBetween('tanggal_hadir', [$mulai, $selesai])->where('id_karyawan',$id)
        ->orWhereBetween('tanggal_tidak_hadir', [$mulai, $selesai])->where('id_karyawan',$id)
        ->get();
        foreach($datax as $key => $value){
            if($value->status_kehadiran == "hadir"){
                $data['masuk'] += 1;
            }else{
                $data['tidak_masuk'] += 1;
            }
            if($value->keterangan == "izin"){
                $data['izin'] += 1;
            }
            if($value->keterangan == "sakit"){
                $data['sakit'] += 1;
            }
            if($value->keterangan == "alfa"){
                $data['alfa'] += 1;
            }
            if($value->keterangan == "cuti"){
                $data['cuti'] += 1;
            }
            if($value->keterangan == "libur"){
                $data['libur'] += 1;
            }
            if($value->status_kehadiran == "hadir"){
                $masuk = strtotime($value->jam_masuk);
                $pulang = strtotime($value->jam_pulang);
                if($masuk > strtotime("14:00:00")){
                    //shift 2
                    $data['uang_kopi'] += 0;
                    if($masuk > strtotime($shift2['masuk_flag'])){
                        $data['terlambat'] += 1;
                    }else if($masuk <= strtotime($shift2['masuk_flag'])){
                        $tmp = $pulang - $masuk;
                        $jam_kerja = date("h",$tmp);
                        if($jam_kerja < 8){
                            $data['pulang_cepat'] += 1;
                        }
                    }
                }else{
                    //shift 1
                    if($masuk > strtotime($shift1['masuk_flag'])){
                        $data['terlambat'] += 1;
                    }else if($masuk <= strtotime($shift1['masuk_flag'])){
                        $tmp = $pulang - $masuk;
                        $jam_kerja = date("h",$tmp);
                        if($jam_kerja < 8){
                            $data['pulang_cepat'] += 1;
                        }
                    }
                }
            }
        }
        echo json_encode($data);
    }

    public function postslipgaji(Request $post){
        $data = $post->except('_token');
        $status['status_pembayaran'] = "Pending";
        DB::table('pay_upah')->where('no_id_upah',$data['no_id_upah'])->update($status);
        //if($a){
            $q = DB::table('pay_slip_gaji')->insert($data);
            if($q){
                $dt = DB::table('pay_slip_gaji')->where($data)->get();
                echo $dt[0]->id;
            }
        //}
        
    }

    public function cetakslipgaji($no){
        $data['slip'] = DB::table('pay_slip_gaji')
                        ->where('id',$no)->get();
        if(count($data['slip'])>0){
            $data['karyawan'] = DB::table('tb_karyawan')->where('id',$data['slip'][0]->id)->get();
            return view('administrasi.cetak_slip_gaji',$data);  
        }
        
    }

    public function data_slip_gaji(){
        $data['slip'] = DB::table('pay_slip_gaji')->get();
        
        $kar = DB::table('tb_karyawan')->select("*")->where("status","=","aktif")->whereNull("jenis_konsumen")->orWhere("jenis_konsumen",'>',4)->get();
        $data['karyawan'] = array();
        foreach($kar as $key => $value){
            $data['karyawan'][$value->id] = $value;
        }

        $div = DB::table('pay_divisi')->get();
        $data['divisi'] = array();
        foreach($div as $key => $value){
            $data['divisi'][$value->id_divisi] = $value;
        }
        
        return view('administrasi.in_data_slip_gaji',$data);  
    }
    
    public function data_slip_gajis(Request $post){
        $dat = $post->except('_token');
        $key = array();
        if($dat['id_karyawan'] !== null && $dat['id_karyawan'] !== ""){
            $key["pay_slip_gaji.id_karyawan"] = $dat['id_karyawan'];
            $data['nama_karyawan'] = $dat['nama_karyawan'];
            $data['id_karyawan'] = $dat['id_karyawan'];
        }
        
        if($dat['id_divisi'] !== null && $dat['id_divisi'] !== ""){
            $key["id_divisi"] = $dat['id_divisi'];
            $data['nama_divisi'] = $dat['nama_divisi'];
            $data['id_divisi'] = $dat['id_divisi'];
        }
        
        $key["status_penggajian"] = $dat["status_penggajian"];
        $key["status_pembayaran"] = $dat["status_pembayaran"];
        $data["status_penggajian"] = $dat["status_penggajian"];
        $data["status_pembayaran"] = $dat["status_pembayaran"];
        
        if($dat['mulai'] !== null && $dat['mulai'] !== "" && $dat['sampai'] !== null && $dat['sampai'] !== ""){
            $key["mulai"] = $dat["mulai"];
            $key["sampai"] = $dat["sampai"];
            $data["mulai"] = $dat["mulai"];
            $data["sampai"] = $dat["sampai"];
        }
            if(isset($key["id_divisi"])){
                  $data['slip'] = DB::table('pay_slip_gaji')
                                  ->join("tb_karyawan","tb_karyawan.id","pay_slip_gaji.id_karyawan")
                                  ->where($key)
                                  ->select("pay_slip_gaji.*")
                                  ->get();
            }else{
                  $data['slip'] = DB::table('pay_slip_gaji')->where($key)->get();
            }

        $kar = DB::table('tb_karyawan')->select("*")->where("status","=","aktif")->whereNull("jenis_konsumen")->orWhere("jenis_konsumen",'>',4)->get();
        $data['karyawan'] = array();
        foreach($kar as $key => $value){
            $data['karyawan'][$value->id] = $value;
        }

        $div = DB::table('pay_divisi')->get();
        $data['divisi'] = array();
        foreach($div as $key => $value){
            $data['divisi'][$value->id_divisi] = $value;
        }
        
        return view('administrasi.in_data_slip_gaji',$data);  
    }
    
    public function cekinsentifkinerja($id){
        $data = DB::table('pay_slip_gaji')
                ->leftJoin('tb_karyawan','tb_karyawan.id','pay_slip_gaji.id_karyawan')
                ->where('pay_slip_gaji.id',$id)
                ->get();
        echo json_encode($data);
    }
    
    public function postupdatedata(Request $post){
        $data = $post->except('_token');
        $upd['status_pembayaran'] = "Terbayar";
        $upd['tgl_pembayaran'] = $data['tgl_bayar'];
        $a = DB::table('pay_slip_gaji')->where('no_id_upah',$data['no_id_upah'])->update($upd);
        $b = DB::table('pay_upah')->where('no_id_upah',$data['no_id_upah'])->update($upd);
        if($a || $b){
            echo json_encode($data);
        }
    }
    
    
    public function getupahpekerjaan(Request $request){
        if ($request->ajax()) {
            $data = Pekerjaan::where('status','aktif')->with('divisian:id_divisi,nama_divisi')->with('upahan:no_id_pekerjaan,id,status_pekerja,harga_satuan')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kategori', function($row){
                    if(isset($row['upahan']) && isset($row['upahan']->status_pekerja)){
                        return $row['upahan']->status_pekerja;
                    }else{
                        return "";
                    }
                })
                ->addColumn('harga_satuan', function($row){
                    if(isset($row['upahan']) && isset($row['upahan']->harga_satuan)){
                        return $row['upahan']->harga_satuan;
                    }else{
                        return "";
                    }
                })
                ->addColumn('action', function($row){
                    if(isset($row['upahan'])){
                        $ky_ck = "'".$row->no_id_pekerjaan."','".$row->nama_pekerjaan."','".$row->satuan."','".$row->id_divisi."','".$row->target."','".$row['upahan']->harga_satuan."','".$row['upahan']->id."'";
                        
                    }else{
                        $ky_ck = "'".$row->no_id_pekerjaan."','".$row->nama_pekerjaan."','".$row->satuan."','".$row->id_divisi."','".$row->target."',0,0";
                        
                    }
                    $ky_del = "'".$row->no_id_pekerjaan."','".$row->nama_pekerjaan."'";
                    $actionBtn = '<button class="btn btn-primary btn-sm text-right" onclick="Edit('.$ky_ck.')">Edit</button>';
                    $actionBtn .= '<button class="btn btn-danger btn-sm text-right" onclick="Hapus('.$ky_del.')">Hapus</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action','kategori','harga_satuan'])
                ->make(true);
        }
    }

}   

?>