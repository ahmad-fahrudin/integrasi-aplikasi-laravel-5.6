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

class Service extends Controller
{
  public function __construct()
  {
      $this->model = new Mase;
  }

  public function permintaanservice(){
    date_default_timezone_set('Asia/Jakarta');
    $da['bm'] = DB::table('tb_services as a')->select("*")->where("a.tanggal_service","=",date('Y-m-d'))->orderBy('id', 'DESC')->get();
    $status = true;
    if(count($da['bm']) > 0){
      foreach ($da['bm'] as $key => $value):
        $split = explode("P",$value->no_service);
        if(count($split) < 3 && $status){
          $var = substr($value->no_service,10,4);
          $number = str_pad($var + 1, 4, '0', STR_PAD_LEFT);
          $status = false;
        }
      endforeach;
    }else{
      $number = "0001";
    }
    $data['kode'] = $number;

    $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();

    
    return view('Service.permintaanservice',$data);
  }
  
  
}
