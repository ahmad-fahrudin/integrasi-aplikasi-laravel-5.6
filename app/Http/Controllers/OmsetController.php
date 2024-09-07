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

class OmsetController extends Controller
{
  var $model;
  public function __construct()
  {   
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function dataomset(){
    if (role()) {
      $data['omset'] = DB::table('tb_omset as a')
                           ->select("*")
                           ->where("a.status","aktif")
                           ->orderBy("a.id","ASC")
                           ->orderBy("a.tgl_verifikasi","ASC")
                           ->get();
     $text_admin = DB::table('users as a')->select("a.*")->get();
     $data['admin'] = array();
     $data['nama_download'] = "Data Omset";
     foreach ($text_admin as $value) {
       $data['admin'][$value->id] =$value->name;
     }
      return view('Omset',$data);
    }else{
      return view('Denied');
    }
  }

  public function dataomsets(Request $post){
    if (role()) {
      $data = $post->except('_token');
      $data['omset'] = DB::table('tb_omset as a')
                           ->select("*")
                           ->where("a.status","aktif")
                           ->whereBetween('tgl_transaksi',[$data['from'],$data['to']])
                           ->orderBy("a.id","ASC")
                           ->orderBy("a.tgl_verifikasi","ASC")
                           ->get();
     $text_admin = DB::table('users as a')->select("a.*")->get();
     $data['admin'] = array();
     $data['nama_download'] = "Data Omset";
     foreach ($text_admin as $value) {
       $data['admin'][$value->id] =$value->name;
     }
      return view('Omset',$data);
    }else{
      return view('Denied');
    }
  }

}
?>
