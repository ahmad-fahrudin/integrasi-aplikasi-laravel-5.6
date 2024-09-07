<?php

namespace App\Http\Controllers;

use Hash;
use Crypt;
use DateTime;
use Carbon\Carbon;
use App\Models\Mase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Validator, Redirect, Response, File;

class BarangController extends Controller
{
    var $model;
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->model = new Mase;
    }
    public function index()
    {
        if (role() && (Auth::user()->gudang == "1")) {
            $data['suplayer'] = DB::table('tb_suplayer as a')->select("*")->where("a.status", "=", "aktif")->get();
            $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->get();
            $data['driver'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->get();
            $data['barangmasuk'] = $this->model->getBarangMasuk();
            $data['nama_download'] = "Data Barang Masuk";
            //dd($data['barangmasuk'][0]);
            return view('DataBarangMasuk', $data);
        } else {
            return view('Denied');
        }
    }

    public function pengiriman_khusus()
    {
        $data['provinsi'] = DB::table('provinces')->get();
        $data['harga'] = DB::table('tb_wilayah_harga_kurir')->get();
        $data['data'] = DB::table('tb_wilayah_kurir_lokal')->leftJoin('regencies', 'regencies.id', 'tb_wilayah_kurir_lokal.dawerah_kabupaten')->select('tb_wilayah_kurir_lokal.*', 'regencies.name', 'regencies.nama_provinsi')->get();
        return view('pengiriman_khusus', $data);
    }

    public function simpankurirlokal(Request $post)
    {
        $data = $post->except('_token');
        $d['dawerah_kabupaten'] = $data['kota'];
        $q = DB::table('tb_wilayah_kurir_lokal')->insert($d);
        return redirect()->back()->with('success', 'Berhasil');
    }

    public function simpanhargakurirlokal(Request $post)
    {
        $data = $post->except('_token');
        $d['harga'] = $data['kilo_pertama'];
        $d['harga2'] = $data['kilo_selanjutnya'];
        $q = DB::table('tb_wilayah_harga_kurir')->where('id', 1)->update($d);
        return redirect()->back()->with('success', 'Berhasil');
    }

    public function deletekabupaten($id)
    {
        DB::table('tb_wilayah_kurir_lokal')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Berhasil');
    }

    public function cekhargabarangmasuk($id)
    {
        $data = DB::table('tb_harga')->where('id_barang', $id)->get();
        echo json_encode($data);
    }
    public function updatehargahpmasuk($id, $harga)
    {
        $data['harga_hp'] = $harga;
        $data['tanggal'] = date('Y-m-d');
        $harga_lama = DB::table('tb_harga')->where('id_barang', $id)->get();

        $jumlah_stok = DB::table('tb_gudang_barang as a')->where("a.id_barang", $id)->select(DB::raw('SUM(a.jumlah) as stok'))->get();
        $nama_barang = DB::table('tb_barang as a')->where("a.id", $id)->select('*')->get();
        $old_lb = DB::table('tb_labarugi as a')->orderBy("a.id", "DESC")->limit(1)->get();

        if (count($jumlah_stok) > 0) {
            $harga_hp_brg = str_replace(".", "", $harga);
            $harga_hp_brg_old = str_replace(".", "", $harga_lama[0]->harga_hp);

            $labarugi['jumlah'] = $jumlah_stok[0]->stok * ($harga_hp_brg - $harga_hp_brg_old);
            if (count($old_lb) > 0) {
                $labarugi['saldo_temp'] = $old_lb[0]->saldo_temp + $labarugi['jumlah'];
            } else {
                $labarugi['saldo_temp'] = $labarugi['jumlah'];
            }
            if ($labarugi['jumlah'] > 0) {
                $labarugi['jenis'] = "in";
            } else {
                $labarugi['jenis'] = "out";
            }

            if ($labarugi['jumlah'] < 0) {
                $labarugi['jumlah'] = $labarugi['jumlah'] * -1;
            }

            $labarugi['nama_jenis'] = "Penyesuaian harga barang " . $nama_barang[0]->nama_barang;
            $labarugi['admin'] = Auth::user()->id;

            if ($labarugi['jumlah'] !== 0) {
                DB::table('tb_labarugi')->insert($labarugi);
            }
        }

        DB::table('tb_harga')->where('id_barang', $id)->update($data);
    }

    /*public function indexs(){
    $data['nama_download'] = "Data Barang Masuk";
    return redirect()->route('barangmasuk.read')->with('success','Berhasil');
  }*/
    public function barangmasuk(Request $post)
    {
        $data = $post->except('_token');
        if ($data['date_from'] != null) {
            $from = $data['date_from'];
        }
        if ($data['date_to'] != null) {
            $to = $data['date_to'];
        }
        if ($data['driver'] != null) {
            $dt['driver'] = $data['driver'];
            $data['id_driver'] = $data['driver'];
        }
        if ($data['suplayer'] != null) {
            $dt['suplayer'] = $data['suplayer'];
            $data['id_suplayer'] = $data['suplayer'];
        }
        if ($data['qc'] != null) {
            $dt['qc'] = $data['qc'];
            $data['id_qc'] = $data['qc'];
        }
        if ($data['nama_barang'] != null) {
            $nm['nama_barang'] = $data['nama_barang'];
            $nama_barang = $data['nama_barang'];
            $data['nama_barang'] = $data['nama_barang'];
        }
        if (isset($from) && isset($to) && isset($dt) && isset($nm)) {
            $data['barangmasuk'] = DB::table('tb_barang_masuk as a')
                ->join('tb_suplayer as b', 'b.id', '=', 'a.suplayer')->join('tb_barang as c', 'c.id', '=', 'a.barang')->join('tb_karyawan as d', 'd.id', '=', 'a.driver')->join('tb_karyawan as e', 'e.id', '=', 'a.qc')->join('users as f', 'f.id', '=', 'a.admin')
                ->join('tb_gudang as g', 'g.id', '=', 'a.gudang')
                ->select("a.id", "a.kategori", "g.nama_gudang", "a.no_faktur", "a.tgl_masuk", "b.alamat", "b.nama_pemilik", "c.no_sku", "c.nama_barang", "c.part_number", "a.jumlah", "c.pcs_koli", "c.satuan_pcs", "c.satuan_koli", "d.nama as driver", "e.nama as qc", "f.name as admin", "a.noted")
                ->where($dt)
                ->where('nama_barang', 'like', "%$nama_barang%")
                ->whereBetween('tgl_masuk', [$from, $to])
                ->where("a.status", "=", "aktif")
                ->get();
        } else if (isset($dt) && isset($nm)) {
            $data['barangmasuk'] = DB::table('tb_barang_masuk as a')
                ->join('tb_suplayer as b', 'b.id', '=', 'a.suplayer')->join('tb_barang as c', 'c.id', '=', 'a.barang')->join('tb_karyawan as d', 'd.id', '=', 'a.driver')->join('tb_karyawan as e', 'e.id', '=', 'a.qc')->join('users as f', 'f.id', '=', 'a.admin')
                ->join('tb_gudang as g', 'g.id', '=', 'a.gudang')
                ->select("a.id", "a.kategori", "g.nama_gudang", "a.no_faktur", "a.tgl_masuk", "b.alamat", "b.nama_pemilik", "c.no_sku", "c.nama_barang", "c.part_number", "a.jumlah", "c.pcs_koli", "c.satuan_pcs", "c.satuan_koli", "d.nama as driver", "e.nama as qc", "f.name as admin", "a.noted")
                ->where($dt)
                ->where('nama_barang', 'like', "%$nama_barang%")
                ->where("a.status", "=", "aktif")
                ->get();
        } else if (isset($from) && isset($to) && isset($nm)) {
            $data['barangmasuk'] = DB::table('tb_barang_masuk as a')
                ->join('tb_suplayer as b', 'b.id', '=', 'a.suplayer')->join('tb_barang as c', 'c.id', '=', 'a.barang')->join('tb_karyawan as d', 'd.id', '=', 'a.driver')->join('tb_karyawan as e', 'e.id', '=', 'a.qc')->join('users as f', 'f.id', '=', 'a.admin')
                ->join('tb_gudang as g', 'g.id', '=', 'a.gudang')
                ->select("a.id", "a.kategori", "g.nama_gudang", "a.no_faktur", "a.tgl_masuk", "b.alamat", "b.nama_pemilik", "c.no_sku", "c.nama_barang", "c.part_number", "a.jumlah", "c.pcs_koli", "c.satuan_pcs", "c.satuan_koli", "d.nama as driver", "e.nama as qc", "f.name as admin", "a.noted")
                ->whereBetween('tgl_masuk', [$from, $to])
                ->where('nama_barang', 'like', "%$nama_barang%")
                ->where("a.status", "=", "aktif")
                ->get();
        } else if (isset($from) && isset($to) && isset($dt)) {
            $data['barangmasuk'] = DB::table('tb_barang_masuk as a')
                ->join('tb_suplayer as b', 'b.id', '=', 'a.suplayer')->join('tb_barang as c', 'c.id', '=', 'a.barang')->join('tb_karyawan as d', 'd.id', '=', 'a.driver')->join('tb_karyawan as e', 'e.id', '=', 'a.qc')->join('users as f', 'f.id', '=', 'a.admin')
                ->join('tb_gudang as g', 'g.id', '=', 'a.gudang')
                ->select("a.id", "a.kategori", "g.nama_gudang", "a.no_faktur", "a.tgl_masuk", "b.alamat", "b.nama_pemilik", "c.no_sku", "c.nama_barang", "c.part_number", "a.jumlah", "c.pcs_koli", "c.satuan_pcs", "c.satuan_koli", "d.nama as driver", "e.nama as qc", "f.name as admin", "a.noted")
                ->whereBetween('tgl_masuk', [$from, $to])
                ->where($dt)
                ->where("a.status", "=", "aktif")
                ->get();
        } else if (isset($nm)) {
            $data['barangmasuk'] = DB::table('tb_barang_masuk as a')
                ->join('tb_suplayer as b', 'b.id', '=', 'a.suplayer')->join('tb_barang as c', 'c.id', '=', 'a.barang')->join('tb_karyawan as d', 'd.id', '=', 'a.driver')->join('tb_karyawan as e', 'e.id', '=', 'a.qc')->join('users as f', 'f.id', '=', 'a.admin')
                ->join('tb_gudang as g', 'g.id', '=', 'a.gudang')
                ->select("a.id", "a.kategori", "g.nama_gudang", "a.no_faktur", "a.tgl_masuk", "b.alamat", "b.nama_pemilik", "c.no_sku", "c.nama_barang", "c.part_number", "a.jumlah", "c.pcs_koli", "c.satuan_pcs", "c.satuan_koli", "d.nama as driver", "e.nama as qc", "f.name as admin", "a.noted")
                ->where('nama_barang', 'like', "%$nama_barang%")
                ->where("a.status", "=", "aktif")
                ->get();
        } else if (isset($dt)) {
            $data['barangmasuk'] = DB::table('tb_barang_masuk as a')
                ->join('tb_suplayer as b', 'b.id', '=', 'a.suplayer')->join('tb_barang as c', 'c.id', '=', 'a.barang')->join('tb_karyawan as d', 'd.id', '=', 'a.driver')->join('tb_karyawan as e', 'e.id', '=', 'a.qc')->join('users as f', 'f.id', '=', 'a.admin')
                ->join('tb_gudang as g', 'g.id', '=', 'a.gudang')
                ->select("a.id", "a.kategori", "g.nama_gudang", "a.no_faktur", "a.tgl_masuk", "b.alamat", "b.nama_pemilik", "c.no_sku", "c.nama_barang", "c.part_number", "a.jumlah", "c.pcs_koli", "c.satuan_pcs", "c.satuan_koli", "d.nama as driver", "e.nama as qc", "f.name as admin", "a.noted")
                ->where($dt)
                ->where("a.status", "=", "aktif")
                ->get();
        } else if (isset($from) && isset($to)) {
            $data['barangmasuk'] = DB::table('tb_barang_masuk as a')
                ->join('tb_suplayer as b', 'b.id', '=', 'a.suplayer')->join('tb_barang as c', 'c.id', '=', 'a.barang')->join('tb_karyawan as d', 'd.id', '=', 'a.driver')->join('tb_karyawan as e', 'e.id', '=', 'a.qc')->join('users as f', 'f.id', '=', 'a.admin')
                ->join('tb_gudang as g', 'g.id', '=', 'a.gudang')
                ->select("a.id", "a.kategori", "g.nama_gudang", "a.no_faktur", "a.tgl_masuk", "b.alamat", "b.nama_pemilik", "c.no_sku", "c.nama_barang", "c.part_number", "a.jumlah", "c.pcs_koli", "c.satuan_pcs", "c.satuan_koli", "d.nama as driver", "e.nama as qc", "f.name as admin", "a.noted")
                ->whereBetween('tgl_masuk', [$from, $to])
                ->where("a.status", "=", "aktif")
                ->get();
        }

        $data['suplayer'] = DB::table('tb_suplayer as a')->select("*")->where("a.status", "=", "aktif")->get();
        $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->get();
        $data['driver'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->get();
        $data['nama_download'] = "Data Barang Masuk";


        foreach ($data['suplayer']  as $value) {
            $data['val_suplayer'][$value->id] = $value->nama_pemilik;
        }
        foreach ($data['qc']  as $value) {
            $data['val_qc'][$value->id] = $value->nama;
        }
        foreach ($data['driver']  as $value) {
            $data['val_driver'][$value->id] = $value->nama;
        }


        //dd($data);
        return view('DataBarangMasuk', $data);
    }

    public function getBarangMasukBarcode($id)
    {
        $data = DB::table('tb_barang as a')->join('tb_harga as b', 'b.id_barang', '=', 'a.id')
            ->select("a.*", "harga_hp")
            ->where("id_barcode", $id)
            ->orWhere("no_sku", $id)->get();
        echo json_encode($data);
    }

    public function caribarangbykodeBarcode($id)
    {
        $kategori = DB::table('tb_barang as a')->join('tb_harga as b', 'b.id_barang', '=', 'a.id')->where('a.nama_barang', "like", "%$id%")->orWhere('a.id_barcode', "like", "%$id%")->orWhere('a.no_sku', "like", "%$id%")->select("*")->get();
        echo json_encode($kategori);
    }

    public function inputbarangmasuk()
    {
        if (role() && (Auth::user()->gudang == "1")) {
            $data['suplayer'] = DB::table('tb_suplayer as a')->select("*")->where("a.status", "=", "aktif")->get();
            $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
            $data['driver'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
            $data['barang'] = DB::table('tb_barang as a')->join('tb_harga as c', 'c.id_barang', '=', 'a.id')->select("a.*", "c.id_barang", "c.harga", "c.tanggal")->where("a.status", "=", "aktif")->get();
            $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.status", "=", "aktif")->get();

            $data['rekening'] = DB::table('tb_rekening as a')->select("*")->get();

            $d['bm'] = DB::table('tb_barang_masuk as a')->select("*")->where("a.status", "=", "aktif")->where("a.tgl_masuk", "=", date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();
            if (count($d['bm']) > 0) {
                $var = substr($d['bm'][0]->no_faktur, 10);
                $data['number'] = str_pad($var + 1, 3, '0', STR_PAD_LEFT);;
            } else {
                $data['number'] = "001";
            }
            return view('InputBarangMasuk', $data);
        } else {
            return view('Denied');
        }
    }
    public function editBarangMasuk($id)
    {
        $data['suplayer'] = DB::table('tb_suplayer as a')->select("*")->where("a.status", "=", "aktif")->get();
        $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->get();
        $data['driver'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->get();
        $data['admin'] = DB::table('users as a')->select("*")->get();

        $data['barang'] = DB::table('tb_barang_masuk as a')
            ->join('tb_suplayer as b', 'b.id', '=', 'a.suplayer')
            ->join('tb_barang as c', 'c.id', '=', 'a.barang')
            ->join('tb_karyawan as d', 'd.id', '=', 'a.driver')
            ->join('tb_karyawan as e', 'e.id', '=', 'a.qc')
            ->join('users as f', 'f.id', '=', 'a.admin')
            ->select(
                "a.id",
                "a.gudang",
                "a.barang",
                "b.nama_pemilik as suplayer",
                "a.jumlah",
                "c.pcs_koli",
                "c.satuan_pcs",
                "c.satuan_koli",
                "d.nama as driver",
                "f.name as admin",
                "e.nama as qc",
                "a.suplayer as id_suplayer",
                "a.driver as id_driver",
                "a.admin as id_admin",
                "a.qc as id_qc"
            )
            ->where("a.status", "=", "aktif")
            ->where("a.id", "=", $id)
            ->get();
        return view('EditBarangMasuk', $data);
    }

    public function detailBarangMasuk($faktur)
    {
        $data = DB::table('tb_barang_masuk')->where('no_faktur', $faktur)->limit(1)->get();
        $pembayaran = DB::table('tb_pembayaran_hutang')->where("no_faktur", "=", $faktur)->get();
        $total = 0;
        foreach ($pembayaran as $v) {
            $total += $v->pembayaran;
        }
        foreach ($data as $k => $val) {
            $data[$k]->total_sudah_bayar = $total;
        }
        echo json_encode($data);
    }

    public function detailBarangMasuk2($faktur)
    {
        $data = DB::table('tb_barang_masuk')
            ->join('tb_barang', 'tb_barang.id', 'tb_barang_masuk.barang')->where('no_faktur', $faktur)->get();
        echo json_encode($data);
    }

    public function updatebarangmasuk(Request $post)
    {
        $data = $post->except('_token');
        $id_gudang = $post->only('gudang')['gudang'];
        $id_barang = $post->only('barang')['barang'];

        $temp = $post->only('tempjumlah')['tempjumlah'];
        $jumlah = $post->only('jumlah')['jumlah'];
        $input = $temp - $jumlah;

        $q = DB::table('tb_gudang_barang')->where('id_barang', '=', $id_barang)->where('id_gudang', '=', $id_gudang)->decrement('jumlah', $input);

        //tracking data
        if ($q) {
            $bm = DB::table('tb_barang_masuk')->where('id', '=', $post->only('id')['id'])->get();
            $tracking['jenis_transaksi'] = "Update Barang Masuk";
            $tracking['nomor'] = $bm[0]->no_faktur;
            $tracking['gudang'] = $id_gudang;
            $tracking['barang'] = $id_barang;
            $tracking['jumlah'] = $input;
            $tracking['stok'] = "out";
            DB::table('tracking')->insert($tracking);
        }

        $dt['suplayer'] = $post->only('suplayer')['suplayer'];
        $dt['barang'] = $post->only('barang')['barang'];
        $dt['jumlah'] = $post->only('jumlah')['jumlah'];
        $dt['driver'] = $post->only('driver')['driver'];
        $dt['admin'] = $post->only('admin')['admin'];
        $dt['qc'] = $post->only('qc')['qc'];
        DB::table('tb_barang_masuk')->where('id', '=', $post->only('id')['id'])->update($dt);

        $bm = DB::table('tb_barang_masuk')->where('id', '=', $post->only('id')['id'])->get();
        $upd = 0;
        foreach ($bm as $key => $value) {
            $harga = DB::table('tb_harga')->where('id_barang', $value->barang)->get();
            $upd += $value->jumlah * $harga[0]->harga_hp;
        }

        if ($bm[0]->kategori_pembelian == "cash") {
            if ($post->jenis_cash == "tunai") {
                $last = DB::table('tb_kas_ditangan')->where('keterangan', 'LIKE', '%' . $bm[0]->no_faktur . '%')->get();
                if (count($last) > 0) {
                    $updtg['jumlah'] = $upd;
                    DB::table('tb_kas_ditangan')->where('id', $last[0]->id)->update($updtg);
                }
            } else {
                $last = DB::table('tb_kas_dibank')->where('keterangan', 'LIKE', '%' . $bm[0]->no_faktur . '%')->get();
                if (count($last) > 0) {
                    $updtg['jumlah'] = $upd;
                    DB::table('tb_kas_dibank')->where('id', $last[0]->id)->update($updtg);
                }
            }
        } else {
            $last = DB::table('tb_kas_ditangan')->where('keterangan', 'LIKE', '%' . $bm[0]->no_faktur . '%')->get();
            if (count($last) > 0) {
                $updtg['jumlah'] = $upd;
                DB::table('tb_kas_ditangan')->where('id', $last[0]->id)->update($updtg);
            }
        }

        return redirect()->route('databarangmasuk')->with('success', 'Berhasil');
    }
    public function deleteBarangMasuk($id)
    {
        $data = DB::table('tb_barang_masuk as a')->select("jumlah", "barang", "gudang", "no_faktur")->where('id', '=', $id)->get();
        $jumlah = $data[0]->jumlah;
        $id_barang = $data[0]->barang;
        $id_gudang = $data[0]->gudang;
        $qu = DB::table('tb_barang_masuk')->where('id', '=', $id)->delete();
        if ($qu) {
            $q = DB::table('tb_gudang_barang')->where('id_barang', '=', $id_barang)->where('id_gudang', '=', $id_gudang)->decrement('jumlah', $jumlah);
            //tracking data
            if ($q) {
                $tracking['jenis_transaksi'] = "Delete Barang Masuk";
                $tracking['nomor'] = $data[0]->no_faktur;
                $tracking['gudang'] = $id_gudang;
                $tracking['barang'] = $id_barang;
                $tracking['jumlah'] = $jumlah;
                $tracking['stok'] = "out";
                DB::table('tracking')->insert($tracking);
            }
        }
        return redirect()->back()->with('success', 'Berhasil');
    }

    //stok gudang
    public function stokgudang()
    {
        if (role()) {
            $data['asset'] = 0;
            $data['gudang'] = DB::table('tb_gudang as a')->where("a.status", "aktif")->get();


            $data['stok'] = DB::table('tb_barang as a')
                ->join('tb_gudang_barang as b', 'b.id_barang', '=', 'a.id')
                ->join('tb_harga as c', 'c.id_barang', '=', 'a.id')

                ->select("a.*", "a.id as id_barang", "c.harga_hp", DB::raw('SUM(b.jumlah) as stok'))
                ->where("b.id_gudang", Auth::user()->gudang)
                ->where("a.status", "aktif")
                ->groupBy("b.id_barang")
                ->get();

            $cek_bk = array();
            $cek_ts = array();

            //barang keluar
            $bk = DB::table('tb_barang_keluar as a')
                ->where("a.status_barang", "order")
                ->where("a.id_gudang", Auth::user()->gudang)
                ->get();
            foreach ($bk as $key => $value) {
                $cek_bk[$value->no_kwitansi] = $value->no_kwitansi;
            }
            $barangkeluar = DB::table('tb_detail_barang_keluar as b')
                ->select("b.*")
                ->whereNull("proses")
                ->get();
            //end barang keluar

            //transfer stok
            $ts = DB::table('tb_transfer_stok as a')
                ->where("a.status_transfer", "order")
                ->where("a.kepada", Auth::user()->gudang)
                ->get();
            foreach ($ts as $key => $value) {
                $cek_ts[$value->no_transfer] = $value->no_transfer;
            }
            $transferstok = DB::table('tb_detail_transfer as b')
                ->select("b.*")
                ->where("proses", 0)
                ->orWhere("pending", 0)
                ->get();
            //end transfer stok

            $data['kulakan'] = array();
            foreach ($data['stok'] as $key => $value) {
                $data['kulakan'][$value->id]['no_sku'] = $value->no_sku;
                $data['kulakan'][$value->id]['lokasi'] = $value->lokasi;
                $data['kulakan'][$value->id]['keterangan'] = $value->keterangan;
                $data['kulakan'][$value->id]['kategori'] = $value->kategori;
                $data['kulakan'][$value->id]['satuan_pcs'] = $value->satuan_pcs;
                $data['kulakan'][$value->id]['satuan_koli'] = $value->satuan_koli;
                $data['kulakan'][$value->id]['pcs_koli'] = $value->pcs_koli;
                $data['kulakan'][$value->id]['part_number'] = $value->part_number;
                $data['kulakan'][$value->id]['nama_barang'] = $value->nama_barang;
                $data['kulakan'][$value->id]['stok'] = $value->stok;
                $data['kulakan'][$value->id]['orderan'] = "0";
                $data['kulakan'][$value->id]['id_barang'] = $value->id_barang;
                $data['kulakan'][$value->id]['id_barcode'] = $value->id_barcode;
                $data['asset'] += $value->harga_hp * $value->stok;
            }

            foreach ($barangkeluar as $key => $value) {
                if (array_key_exists($value->no_kwitansi, $cek_bk)) {
                    $data['kulakan'][$value->id_barang]['orderan'] += $value->jumlah;
                    /*if($value->id_barang == '957'){
              echo $value->no_kwitansi." ".$value->id_barang." ".$value->jumlah."<br>";
          }*/
                    // echo $value->no_kwitansi." ".$value->id_barang." ".$value->jumlah."<br>";
                }
            }

            foreach ($transferstok as $key => $value) {
                if (array_key_exists($value->no_transfer, $cek_ts)) {
                    $data['kulakan'][$value->id_barang]['orderan'] += $value->jumlah;
                    /*if($value->id_barang == '957'){
              echo $value->no_transfer." ".$value->id_barang." ".$value->jumlah."<br>";
          }*/
                }
            }
            //dd($data);
            $data['nama_download'] = "Daftar Kulakan " . date('d-m-Y');

            return view('StokGudang', $data);
        } else {
            return view('Denied');
        }
    }
    public function stokgudangs(Request $post)
    {
        if (role()) {
            $data['asset'] = 0;
            $d = $post->except('_token');

            if (isset($d['id_gudang']) && $d['id_gudang'] != "all") {
                $x['id_gudang'] = $d['id_gudang'];
            }
            if (isset($d['jumlah'])) {
                $s = $d['jumlah'];
                $data['s'] = $d['jumlah'];
            }
            if (isset($d['lokasi'])) {
                $x['lokasi'] = $d['lokasi'];
                $data['x'] = $d['lokasi'];
            }
            if (isset($d['part_number'])) {
                $x['part_number'] = $d['part_number'];
                $data['x'] = $d['part_number'];
            }
            if (isset($d['kategori'])) {
                $x['kategori'] = $d['kategori'];
                $data['x'] = $d['kategori'];
            }
            if (isset($d['pcs_koli'])) {
                $x['pcs_koli'] = $d['pcs_koli'];
                $data['x'] = $d['pcs_koli'];
            }
            if (isset($d['satuan_pcs'])) {
                $x['satuan_pcs'] = $d['satuan_pcs'];
                $data['x'] = $d['satuan_pcs'];
            }
            if (isset($d['satuan_koli'])) {
                $x['satuan_koli'] = $d['satuan_koli'];
                $data['x'] = $d['satuan_koli'];
            }
            if (isset($d['stok'])) {
                if ($d['stok'] == "stok") {
                    $u = "0";
                } else {
                    $u = "-1";
                }
                $data['st'] = $d['stok'];
            }
            if (isset($d['kulak'])) {
                $data['kulak'] = "1";
            }

            $data['gudang'] = $this->model->getGudang();
            $data['select'] = $d['id_gudang'];

            if (isset($x) && isset($s)) {
                $data['stok'] = DB::table('tb_barang as a')
                    ->join('tb_gudang_barang as b', 'b.id_barang', '=', 'a.id')
                    ->join('tb_harga as c', 'c.id_barang', '=', 'a.id')
                    ->select("a.*", "c.harga_hp", DB::raw('SUM(b.jumlah) as stok'))
                    ->where($x)
                    ->where("b.jumlah", "<", $s)
                    ->where("a.status", "aktif")
                    ->groupBy("b.id_barang")
                    ->get();
            } else if (isset($x) && isset($u)) {
                $data['stok'] = DB::table('tb_barang as a')
                    ->join('tb_gudang_barang as b', 'b.id_barang', '=', 'a.id')
                    ->join('tb_harga as c', 'c.id_barang', '=', 'a.id')
                    ->select("a.*", "c.harga_hp", DB::raw('SUM(b.jumlah) as stok'))
                    ->where("a.status", "aktif")
                    ->where($x)
                    ->where("b.jumlah", ">", $u)
                    ->groupBy("b.id_barang")
                    ->get();
            } else if (isset($s)) {
                $data['stok'] = DB::table('tb_barang as a')
                    ->join('tb_gudang_barang as b', 'b.id_barang', '=', 'a.id')
                    ->join('tb_harga as c', 'c.id_barang', '=', 'a.id')
                    ->select("a.*", "c.harga_hp", DB::raw('SUM(b.jumlah) as stok'))
                    ->where("a.status", "aktif")
                    ->where("b.jumlah", "<", $s)
                    ->groupBy("b.id_barang")
                    ->get();
            } else if (isset($u)) {
                $data['stok'] = DB::table('tb_barang as a')
                    ->join('tb_gudang_barang as b', 'b.id_barang', '=', 'a.id')
                    ->join('tb_harga as c', 'c.id_barang', '=', 'a.id')
                    ->select("a.*", "c.harga_hp", DB::raw('SUM(b.jumlah) as stok'))
                    ->where("a.status", "aktif")
                    ->where("b.jumlah", ">", $u)
                    ->groupBy("b.id_barang")
                    ->get();
            } else {
                $data['stok'] = DB::table('tb_barang as a')
                    ->join('tb_gudang_barang as b', 'b.id_barang', '=', 'a.id')
                    ->join('tb_harga as c', 'c.id_barang', '=', 'a.id')
                    ->select("a.*", "c.harga_hp", DB::raw('SUM(b.jumlah) as stok'))
                    ->where("a.status", "aktif")
                    ->groupBy("b.id_barang")
                    ->get();
            }
            if (isset($x["lokasi"])) {
                unset($x["lokasi"]);
            }
            if (isset($x)) {
                $data['barangkeluar'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_detail_barang_keluar as b', 'b.no_kwitansi', '=', 'a.no_kwitansi')
                    ->select("b.id_barang", DB::raw('SUM(b.jumlah) as orderan'))
                    ->where("a.status_barang", "order")
                    ->where($x)
                    ->groupBy("b.id_barang")
                    ->get();
                $z['kepada'] = $x['id_gudang'];
                $data['transferstok'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_detail_transfer as b', 'b.no_transfer', '=', 'a.no_transfer')
                    ->select("b.id_barang", DB::raw('SUM(b.jumlah) as orderan'))
                    ->where("a.status_transfer", "order")
                    ->where($z)
                    ->groupBy("b.id_barang")
                    ->get();
            } else {
                $data['barangkeluar'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_detail_barang_keluar as b', 'b.no_kwitansi', '=', 'a.no_kwitansi')
                    ->select("b.id_barang", DB::raw('SUM(b.jumlah) as orderan'))
                    ->where("a.status_barang", "order")
                    ->groupBy("b.id_barang")
                    ->get();

                $data['transferstok'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_detail_transfer as b', 'b.no_transfer', '=', 'a.no_transfer')
                    ->select("b.id_barang", DB::raw('SUM(b.jumlah) as orderan'))
                    ->where("a.status_transfer", "order")
                    ->groupBy("b.id_barang")
                    ->get();
            }
            $data['kulakan'] = array();
            foreach ($data['stok'] as $key => $value) {
                $data['kulakan'][$value->id]['no_sku'] = $value->no_sku;
                $data['kulakan'][$value->id]['lokasi'] = $value->lokasi;
                $data['kulakan'][$value->id]['kategori'] = $value->kategori;
                $data['kulakan'][$value->id]['satuan_pcs'] = $value->satuan_pcs;
                $data['kulakan'][$value->id]['satuan_koli'] = $value->satuan_koli;
                $data['kulakan'][$value->id]['pcs_koli'] = $value->pcs_koli;
                $data['kulakan'][$value->id]['part_number'] = $value->part_number;
                $data['kulakan'][$value->id]['keterangan'] = $value->keterangan;
                $data['kulakan'][$value->id]['nama_barang'] = $value->nama_barang;
                $data['kulakan'][$value->id]['stok'] = $value->stok;
                $data['kulakan'][$value->id]['orderan'] = "0";
                $data['kulakan'][$value->id]['id_barcode'] = $value->id_barcode;
                $data['asset'] += $value->harga_hp * $value->stok;
            }

            foreach ($data['barangkeluar'] as $key => $value) {
                if (isset($data['kulakan'][$value->id_barang]['orderan'])) {
                    $data['kulakan'][$value->id_barang]['orderan'] += $value->orderan;
                }
            }



            foreach ($data['transferstok'] as $key => $value) {
                if (isset($data['kulakan'][$value->id_barang]['orderan'])) {
                    $data['kulakan'][$value->id_barang]['orderan'] += $value->orderan;
                }
            }
            $data['nama_download'] = "Daftar Kulakan " . date('d-m-Y');
            return view('StokGudang', $data);
        } else {
            return view('Denied');
        }
    }

    public function inputbarangbaru()
    {
        if (role()) {
            $barang = $this->model->getBarang();
            if (count($barang) == 0) {
                $data['no_sku'] = "SKU0001";
            } else {
                $no = substr($barang[0]->no_sku, 3);
                $number = str_pad($no + 1, 4, '0', STR_PAD_LEFT);
                $data['no_sku'] = "SKU" . $number;
            }
            return view('InputBarangBaru', $data);
        } else {
            return view('Denied');
        }
    }
    public function insertbarang(Request $post)
    {
        $data = $post->except('_token');
        $data['status'] = "aktif";
        $id = DB::table('tb_barang as a')->select("id")->orderBy('id', 'DESC')->limit(1)->get();

        if (count($id) > 0) {
            $data['id'] = $id['0']->id + 1;
        } else {
            $data['id'] = 1;
        }

        $number = str_pad($data['id'], 4, '0', STR_PAD_LEFT);
        $data['no_sku'] = "SKU" . $number;

        $dt['id_barang'] = $data['id'];
        $dt['harga'] = "0";
        if ($data['id_barcode'] == null || $data['id_barcode'] == "") {
            $data['id_barcode'] = $data['no_sku'];
        }

        $this->model->insertbarang($data, $dt);

        $gudang = DB::table('tb_gudang as a')->select("*")->where("a.status", "=", "aktif")->get();
        for ($i = 0; $i < count($gudang); $i++) {
            $x['id_gudang'] = $gudang[$i]->id;
            $x['id_barang'] = $data['id'];
            $x['jumlah'] = "0";
            $x['harga'] = "0";
            $x['status'] = "aktif";
            DB::table('tb_gudang_barang')->insert($x);
        }
        return redirect()->back()->with('success', 'Berhasil');
    }

    public function databarang()
    {
        $data['barang'] = DB::table('tb_barang as a')->select("*")->where('a.status', 'aktif')->orderBy('id', 'DESC')->get();
        return view('DataBarangNew', $data);
    }

    public function editBarang($id)
    {
        $data = DB::table('tb_barang as a')->select("*")->where('id', $id)->get();
        echo json_encode($data);
    }

    public function updatebarang(Request $post)
    {
        $data = $post->except('_token');
        DB::table('tb_barang')->where('id', '=', $post->only('id')['id'])->update($data);
        $key['nama_barang'] = $data['nama_barang'];
        DB::table('kt_katalog')->where('barang', '=', $post->only('id')['id'])->update($key);
        return redirect()->back()->with('success', 'Berhasil');
    }

    public function deleteBarang($id)
    {
        $data['status'] = 'non aktif';
        DB::table('tb_barang')->where('id', '=', $id)->update($data);
        DB::table('kt_katalog')->where('barang', '=', $id)->update($data);

        return redirect()->back()->with('success', 'Berhasil');
    }

    public function postbarangmasuk(Request $post)
    {
        $data = $post->except('no_faktur', '_token', 'id_gudang', 'barang', 'jumlah', 'kategori', 'kategori_pembelian', 'jenis_cash', 'jenis_rekening');

        $usesuply = DB::table('tb_suplayer')->where('id', $data['suplayer'])->get();
        if (count($usesuply) > 0) {
            $nama_suplayer_pengirim = $usesuply[0]->nama_pemilik;
        } else {
            $nama_suplayer_pengirim = "";
        }

        $split = explode(",", $post->only('barang')['barang']);
        $split2 = explode(",", $post->only('jumlah')['jumlah']);

        $ava = DB::table('tb_barang_masuk as a')->select("*")->where("a.tgl_masuk", "=", date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();

        if (count($ava) > 0) {
            $var = substr($ava[0]->no_faktur, 10, 3);
            $number = str_pad($var + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $number = "001";
        }
        $digits = 3;
        $rand = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
        $data['no_faktur'] = 'FK-' . date('md') . $rand . $number;

        $total_harga_hp = 0;

        for ($i = 1; $i < count($split); $i++) {
            $data['jumlah'] = $split2[$i];
            $data['barang'] = $split[$i];
            $data['status'] = "aktif";
            $data['kategori'] = $post->kategori;
            $data['kategori_pembelian'] = $post->kategori_pembelian;
            $data['jenis_cash'] = $post->jenis_cash;
            $dt['id_gudang'] = $post->only('id_gudang')['id_gudang'];
            $data['gudang'] = $post->only('id_gudang')['id_gudang'];
            $dt['id_barang'] = $data['barang'];

            $harga = DB::table('tb_harga as a')->select("harga", "harga_hp")->where("a.id_barang", "=", $dt['id_barang'])->get();
            $total_harga_hp += $split2[$i] * $harga[0]->harga_hp;

            $dt['harga'] = $harga['0']->harga;
            $dt['status'] = "aktif";

            $cek = DB::table('tb_gudang_barang as a')->select("*")->where("a.id_gudang", "=", $data['gudang'])->where("a.id_barang", "=", $dt['id_barang'])->get();

            if (count($cek) > 0) {
                $dt['jumlah'] = $data['jumlah'] + $cek['0']->jumlah;
                $dt['id'] =  $cek['0']->id;
                $this->model->insertupdatebarangmasuk($data, $dt);
            } else {
                $dt['jumlah'] = $data['jumlah'];
                $this->model->insertbarangmasuk($data, $dt);
            }



            $nama_barang = DB::table('tb_barang as a')->where("a.id", $data['barang'])->select('*')->get();
            $harga = DB::table('tb_harga as a')->where("a.id", $data['barang'])->select('*')->get();
            $old_lb = DB::table('tb_labarugi as a')->orderBy("a.id", "DESC")->limit(1)->get();
            if ($data['kategori'] == "bonus") {
                $labarugi['jumlah'] = $data['jumlah'] * $harga[0]->harga_hp;
                if (count($old_lb) > 0) {
                    $labarugi['saldo_temp'] = $old_lb[0]->saldo_temp + $labarugi['jumlah'];
                } else {
                    $labarugi['saldo_temp'] = $labarugi['jumlah'];
                }
                $labarugi['jenis'] = "in";
                $labarugi['nama_jenis'] = "Pendapatan dari bonus " . $nama_barang[0]->nama_barang;
                $labarugi['admin'] = Auth::user()->id;

                if ($labarugi['jumlah'] !== 0) {
                    DB::table('tb_labarugi')->insert($labarugi);
                }
            }
        }


        if ($data['kategori'] == "kulakan") {
            if ($post->kategori_pembelian == "cash") {
                if ($post->jenis_cash == "tunai") {
                    $csx['jumlah'] = $total_harga_hp;
                    $csx['saldo_temp'] = $total_harga_hp;
                    $csx['jenis'] = 'out';
                    $csx['nama_jenis'] = "Pengadaan Barang";
                    $csx['tgl_verifikasi'] = date('Y-m-d');
                    $csx['admin'] = Auth::user()->id;
                    $csx['keterangan'] = "Pengadaan Barang " . $nama_suplayer_pengirim . " " . $data['no_faktur'];
                    DB::table('tb_kas_ditangan')->insert($csx);
                } else {
                    $csx['jumlah'] = $total_harga_hp;
                    $csx['saldo_temp'] = $total_harga_hp;
                    $csx['jenis'] = 'out';
                    $csx['nama_jenis'] = "Pengadaan Barang";
                    $csx['tgl_verifikasi'] = date('Y-m-d');
                    $csx['admin'] = Auth::user()->id;
                    $csx['keterangan'] = "Pengadaan Barang " . $nama_suplayer_pengirim . " " . $data['no_faktur'];
                    $csx['kode_bank'] = $post->jenis_rekening;
                    DB::table('tb_kas_dibank')->insert($csx);
                }
            } else {
                $csx['exception'] = 'on';
                $csx['jumlah'] = $total_harga_hp;
                $csx['saldo_temp'] = $total_harga_hp;
                $csx['jenis'] = 'in';
                $csx['nama_jenis'] = "Pembiayaan / Hutang";
                $csx['tgl_verifikasi'] = date('Y-m-d');
                $csx['admin'] = Auth::user()->id;
                $csx['keterangan'] = "Pengadaan Barang " . $nama_suplayer_pengirim . " " . $data['no_faktur'];
                DB::table('tb_kas_ditangan')->insert($csx);
            }
        }
    }

    public function inputorderstok()
    {
        if (role()) {
            $d['bm'] = DB::table('tb_transfer_stok as a')->select("*")->where("a.tanggal_order", "=", date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();

            if (count($d['bm']) > 0) {
                $var = substr($d['bm'][0]->no_transfer, 9, 3);
                $data['number'] = str_pad($var + 1, 3, '0', STR_PAD_LEFT);;
            } else {
                $data['number'] = "001";
            }

            $data['barang'] = DB::table('tb_barang as a')->select("*")->where("a.status", "=", "aktif")->get();
            $id = Auth::user()->gudang;
            $data['gudang'] = $this->model->getGudangby($id);
            $data['kepada'] = DB::table('tb_gudang as a')->select("a.*")->where("a.status", "=", "aktif")->where('id', '!=', $id)->get();
            $data['gudang_full'] = DB::table('tb_gudang as a')->select("a.*")->where("a.status", "=", "aktif")->get();
            return view('InputOrderStok', $data);
        } else {
            return view('Denied');
        }
    }

    public function detailBarang($to, $from)
    {
        if ($from == '1') {
            $data = DB::table('tb_gudang_barang as a')
                ->join('tb_barang as b', 'b.id', '=', 'a.id_barang')
                ->select("b.*", "a.jumlah")
                ->where("b.status", "=", "aktif")
                ->where("a.id_gudang", "=", $to)
                ->where("a.jumlah", ">", "0")
                ->get();
        } else {
            $data = DB::table('tb_gudang_barang as a')
                ->join('tb_barang as b', 'b.id', '=', 'a.id_barang')
                ->select("b.*", "a.jumlah")
                ->where("b.status", "=", "aktif")
                ->where("a.id_gudang", "=", $to)
                ->get();
        }
        echo json_encode($data);
    }

    public function posttransferstok(Request $post)
    {
        $data = $post->except('_token');
        date_default_timezone_set('Asia/Jakarta');
        $d['no_transfer'] = $data['no_transfer'];
        $d['tanggal_order'] = $data['tanggal_order'];
        $d['status_transfer'] = $data['status_transfer'];
        $d['dari'] = $data['dari'];
        $d['kepada'] = $data['kepada'];
        $d['admin'] = Auth::user()->id;

        $cek = DB::table('tb_transfer_stok as a')->select("*")
            ->where("a.tanggal_order", "=", date('Y-m-d'))
            ->where("a.dari", "=", $d['dari'])
            ->where("a.kepada", "=", $d['kepada'])
            ->where("a.admin", "=", $d['admin'])
            ->where("a.status_transfer", "order")
            ->orderBy('id', 'DESC')->limit(1)->get();

        if (count($cek) < 1) {
            $da['bm'] = DB::table('tb_transfer_stok as a')->select("*")->where("a.tanggal_order", "=", date('Y-m-d'))->orderBy('id', 'DESC')->get();
            $status = true;
            if (count($da['bm']) > 0) {
                foreach ($da['bm'] as $key => $value):
                    $split = explode("P", $value->no_transfer);
                    if (count($split) < 2 && $status) {
                        $var = substr($value->no_transfer, 9, 3);
                        $number = str_pad($var + 1, 3, '0', STR_PAD_LEFT);
                        $status = false;
                    }
                endforeach;
            } else {
                $number = "001";
            }
            $d['no_transfer'] = 'TRF' . date('ymd') . $number;
            $this->model->inserttransferstok($d);
            echo $d['no_transfer'];
        } else {
            echo $cek[0]->no_transfer;
        }
    }

    public function postdetailtransferstok(Request $post)
    {
        $data = $post->except('_token', 'id_barang', 'jumlah');
        $d['no_transfer'] = $data['no_transfer'];
        $d['tanggal_order'] = $data['tanggal_order'];
        $d['status_transfer'] = $data['status_transfer'];
        $d['dari'] = $data['dari'];
        $d['kepada'] = $data['kepada'];
        $d['admin'] = Auth::user()->id;
        $s['no_transfer'] = $data['no_transfer'];
        $s['time'] = date("h:i");
        //$s['id_barang'] = $data['id_barang'];
        //$s['jumlah'] = $data['jumlah'];

        $id_barang = explode(',', $post->only('id_barang')['id_barang']);
        $jumlah = explode(',', $post->only('jumlah')['jumlah']);

        for ($i = 0; $i < count($id_barang); $i++) {
            if ($id_barang[$i] > 0) {
                $s['id_barang'] = $id_barang[$i];
                $s['jumlah'] = $jumlah[$i];

                $available = DB::table('tb_detail_transfer as a')->select("*")->where($s)->get();
                if (count($available) < 1) {
                    $cek = DB::table('tb_detail_transfer as a')->select("*")->where('no_transfer', $s['no_transfer'])->where('id_barang', $s['id_barang'])->get();
                    if (count($cek) < 1) {
                        $this->model->insertdetailtransferstok($s);
                    } else {
                        $trc = DB::table('tb_detail_transfer')->where('no_transfer', $s['no_transfer'])->where('id_barang', $s['id_barang'])->increment('jumlah', $jumlah[$i]);
                    }
                }
            }
        }
    }

    public function daftarorderstok()
    {
        if (role()) {

            $del =  date("Y-m-d", strtotime("-2 Months"));

            $cekdel = DB::table('tb_transfer_stok as a')->where('tanggal_order', '<', $del)->where('status_transfer', 'order')->get();
            foreach ($cekdel as $key => $value) {
                DB::table('tb_transfer_stok')->where('no_transfer', $value->no_transfer)->delete();
                DB::table('tb_detail_transfer')->where('no_transfer', $value->no_transfer)->delete();
            }


            $data['gudang'] = $this->model->getGudang();
            if (Auth::user()->level == "1") {
                $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_gudang as b', 'b.id', '=', 'a.dari')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.kepada')
                    ->select("a.*", "a.admin", "b.nama_gudang as dari", "c.nama_gudang as kepada")
                    ->where("a.status_transfer", "order")
                    ->get();
            } elseif (Auth::user()->gudang == "1") {
                $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_gudang as b', 'b.id', '=', 'a.dari')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.kepada')
                    ->select("a.*", "a.admin", "b.nama_gudang as dari", "c.nama_gudang as kepada")
                    ->where("a.status_transfer", "order")
                    ->get();
            } else {
                $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_gudang as b', 'b.id', '=', 'a.dari')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.kepada')
                    ->select("a.*", "a.admin", "b.nama_gudang as dari", "c.nama_gudang as kepada")
                    ->where("a.dari", Auth::user()->gudang)
                    ->where("a.status_transfer", "order")
                    ->orWhere("a.kepada", Auth::user()->gudang)
                    ->where("a.status_transfer", "order")
                    ->get();
            }
            return view('DaftarOrderStok', $data);
        } else {
            return view('Denied');
        }
    }
    public function daftarorderstoks(Request $post)
    {
        if (role()) {
            $data = $post->except('_token');
            $data['gudang'] = $this->model->getGudang();

            if ($data['from'] != null) {
                $from = $data['from'];
            }
            if ($data['to'] != null) {
                $to = $data['to'];
            }
            if ($data['dari'] != null) {
                $x['kepada'] = $data['dari'];
                $dari = $data['dari'];
            }
            if (Auth::user()->gudang == "3" || Auth::user()->gudang == "4" || Auth::user()->level == "5" || Auth::user()->level == "6") {
                $x['dari'] = Auth::user()->gudang;
            }
            //if ($data['kepada'] != null) { $x['kepada'] = $data['kepada']; }

            //dd($x);

            if (isset($from) && isset($x)) {
                $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_gudang as b', 'b.id', '=', 'a.dari')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.kepada')
                    ->select("a.*", "b.nama_gudang as dari", "c.nama_gudang as kepada")
                    //->where("a.dari",Auth::user()->gudang)
                    //->where("a.status_transfer","order")
                    //->orWhere("a.kepada",Auth::user()->gudang)
                    ->where($x)
                    ->whereBetween('tanggal_order', [$from, $to])
                    ->where("a.status_transfer", "order")
                    ->get();
            } else if (isset($from)) {
                $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_gudang as b', 'b.id', '=', 'a.dari')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.kepada')
                    ->select("a.*", "b.nama_gudang as dari", "c.nama_gudang as kepada")
                    //->where("a.dari",Auth::user()->gudang)
                    //->where("a.status_transfer","order")
                    //->orWhere("a.kepada",Auth::user()->gudang)
                    ->whereBetween('tanggal_order', [$from, $to])
                    ->where("a.status_transfer", "order")
                    ->get();
            } else if (isset($x)) {
                $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_gudang as b', 'b.id', '=', 'a.dari')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.kepada')
                    ->select("a.*", "b.nama_gudang as dari", "c.nama_gudang as kepada")
                    //->where("a.dari",Auth::user()->gudang)
                    //->where("a.status_transfer","order")
                    //->orWhere("a.kepada",Auth::user()->gudang)
                    ->where("a.status_transfer", "order")
                    ->where($x)
                    ->get();
            }
            //dd($data);
            return view('DaftarOrderStok', $data);
        } else {
            return view('Denied');
        }
    }
    public function deleteOrderStok($id)
    {
        DB::table('tb_transfer_stok')->where('no_transfer', '=', $id)->delete();
        DB::table('tb_detail_transfer')->where('no_transfer', '=', $id)->delete();
        return redirect()->back()->with('success', 'Berhasil');
    }
    public function detailTransferStok($id)
    {
        $data = $this->model->detailTransferStokby($id);
        echo json_encode($data);
    }
    public function deleteitemtransfer($id)
    {
        DB::table('tb_detail_transfer')->where('id', '=', $id)->delete();
        return redirect()->back()->with('success', 'Berhasil');
    }
    public function pengiriman()
    {
        if (role()) {
            if (Auth::user()->level == "1") {
                $data['transfer'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_gudang as b', 'b.id', '=', 'a.dari')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.kepada')
                    ->join('users as d', 'd.id', '=', 'a.admin')
                    ->select("a.*", "b.nama_gudang as dari", "c.nama_gudang as kepada", "b.alamat as alamat_dari", "c.alamat as alamat_kepada", "d.name as adminp", "d.id as idp")
                    ->where("a.status_transfer", "=", "order")->get();
            } else {
                $data['transfer'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_gudang as b', 'b.id', '=', 'a.dari')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.kepada')
                    ->join('users as d', 'd.id', '=', 'a.admin')
                    ->select("a.*", "b.nama_gudang as dari", "c.nama_gudang as kepada", "b.alamat as alamat_dari", "c.alamat as alamat_kepada", "d.name as adminp", "d.id as idp")
                    ->where("a.kepada", "=", Auth::user()->gudang)->where("a.status_transfer", "=", "order")->get();
            }

            //dd($data);

            $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
            $data['driver'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();

            $id = Auth::user()->gudang;
            $data['gudang'] = $this->model->getGudangby($id);
            $data['kepada'] = DB::table('tb_gudang as a')->select("a.*")->where("a.status", "=", "aktif")->where('id', '!=', $id)->get();
            return view('Pengiriman', $data);
        } else {
            return view('Denied');
        }
    }
    public function pilihtransfer($id)
    {
        $data = DB::table('tb_detail_transfer as a')
            ->join('tb_barang as b', 'b.id', '=', 'a.id_barang')
            ->join('tb_transfer_stok as d', 'd.no_transfer', '=', 'a.no_transfer')
            ->join('tb_gudang_barang as c', function ($join) {
                $join->on("c.id_barang", "=", "b.id")
                    ->on("c.id_gudang", "=", "d.kepada");
            })
            ->select("a.*", "b.nama_barang", "b.no_sku", "b.part_number", "c.jumlah as stok", "d.kepada", "d.dari", "d.tanggal_kirim")
            ->where("a.no_transfer", "=", $id)
            ->get();
        echo json_encode($data);
    }
    public function pilihtransfer2($id)
    {
        $data = DB::table('tb_detail_transfer as a')
            ->join('tb_barang as b', 'b.id', '=', 'a.id_barang')
            ->join('tb_transfer_stok as d', 'd.no_transfer', '=', 'a.no_transfer')
            ->join('tb_gudang_barang as c', function ($join) {
                $join->on("c.id_barang", "=", "b.id")
                    ->on("c.id_gudang", "=", "d.kepada");
            })
            ->select("a.*", "b.nama_barang", "b.no_sku", "b.part_number", "c.jumlah as stok", "d.kepada", "d.dari", "d.tanggal_kirim")
            ->where("a.no_transfer", "=", $id)
            ->where("a.proses", "<>", "0")
            ->get();
        echo json_encode($data);
    }
    public function updateproses($id, $ids, $order)
    {
        $data['proses'] = $id;
        $data['pending'] = $order - $id;
        DB::table('tb_detail_transfer')->where('id', '=', $ids)->update($data);
        echo json_encode($data);
    }
    public function updatetransferstok($no_transfer, $driver, $qc)
    {
        $data['driver'] = $driver;
        $data['qc'] = $qc;
        $data['status_transfer'] = "proses";
        $data['tanggal_kirim'] = date('Y-m-d');
        $data['admin_g'] = Auth::user()->id;
        $upd_data = DB::table('tb_transfer_stok')->where('id', '=', $no_transfer)->update($data);

        $x = DB::table('tb_transfer_stok as a')->join('tb_detail_transfer as b', 'a.no_transfer', '=', 'b.no_transfer')
            ->where('a.id', '=', $no_transfer)->get();

        $kondisi = false;
        $a = array();
        foreach ($x as $value) {
            $pend = $value->jumlah - $value->proses;
            if ($pend > 0) {
                $s['no_transfer'] = $value->no_transfer . "P";
                $s['id_barang'] = $value->id_barang;
                $s['jumlah'] = $pend;
                $kondisi = true;
                $cek_detail_transfer_stok = DB::table('tb_detail_transfer')->where($s)->get();
                if (count($cek_detail_transfer_stok) < 1) {
                    DB::table('tb_detail_transfer')->insert($s);
                }
                $a['no_transfer'] = $value->no_transfer . "P";
                $a['tanggal_order'] = $value->tanggal_order;
                $a['status_transfer'] = "order";
                $a['dari'] = $value->dari;
                $a['kepada'] = $value->kepada;
                $a['admin'] = $value->admin;
            }
        }

        if ($kondisi) {
            $cek_transfer_stok = DB::table('tb_transfer_stok')->where($a)->get();
            if (count($cek_transfer_stok) < 1) {
                DB::table('tb_transfer_stok')->insert($a);
            }
        }

        if ($upd_data) {
            echo json_encode($data);
        }
    }
    public function updatedetailtransferstok($id_barang, $id_gudang, $value)
    {
        $loop_id_barang = explode(",", $id_barang);
        $loop_id_gudang = explode(",", $id_gudang);
        $loop_value = explode(",", $value);

        $loop = count($loop_id_barang) - 1;
        for ($i = 0; $i < $loop; $i++) {
            if ($loop_value[$i] > 0) {
                $data['jumlah'] = $loop_value[$i];
                $q = DB::table('tb_gudang_barang')->where('id_barang', '=', $loop_id_barang[$i])->where('id_gudang', '=', $loop_id_gudang[$i])->decrement('jumlah', $loop_value[$i]);
                //tracking data
                if ($q) {
                    $tracking['jenis_transaksi'] = "Update Transfer Stok";
                    //$tracking['nomor'] = $data[0]->no_faktur;
                    $tracking['gudang'] = $loop_id_gudang[$i];
                    $tracking['barang'] = $loop_id_barang[$i];
                    $tracking['jumlah'] = $loop_value[$i];
                    $tracking['stok'] = "out";
                    DB::table('tracking')->insert($tracking);
                }
            }
        }
        if ($q) {
            echo json_encode($loop_id_gudang);
        }
    }
    public function penerimaan()
    {
        if (role()) {
            //proses update terkirim otomatis
            $del =  date("Y-m-d", strtotime("-7 day"));
            $pending = DB::table('tb_transfer_stok as a')->select("a.*")->where("a.status_transfer", "proses")->where('a.tanggal_kirim', '<', $del)->get();

            foreach ($pending as $key => $value) {
                $a['status_transfer'] = "terkirim";
                date_default_timezone_set('Asia/Jakarta');
                $a['tanggal_terkirim'] = date('Y-m-d');
                $a['admin_v'] = '23';
                $que = DB::table('tb_transfer_stok')->where('no_transfer', '=', $value->no_transfer)->update($a);
                if ($que) {
                    $barang_pending = DB::table('tb_detail_transfer as a')->select("*")->where("a.no_transfer", $value->no_transfer)->where('a.proses', '<>', '0')->get();
                    foreach ($barang_pending as $k => $v) {
                        $b['retur'] = '0';
                        $b['terkirim'] = $v->proses;
                        $que1 = DB::table('tb_detail_transfer')->where('id', '=', $v->id)->update($b);
                        if ($que1) {
                            $trc = DB::table('tb_gudang_barang')->where('id_barang', '=', $v->id_barang)->where('id_gudang', '=', $value->dari)->increment('jumlah', $v->proses);

                            //tracking data
                            if ($trc) {
                                $tracking['jenis_transaksi'] = "penerimaan";
                                $tracking['nomor'] = $value->no_transfer;
                                $tracking['gudang'] = $value->dari;
                                $tracking['barang'] = $v->id_barang;
                                $tracking['jumlah'] = $v->proses;
                                $tracking['stok'] = "in";
                                DB::table('tracking')->insert($tracking);
                            }
                        }
                    }
                }
            }
            //end proses

            if (Auth::user()->level == "1") {
                $data['transfer'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_gudang as b', 'b.id', '=', 'a.dari')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.kepada')
                    ->join('users as d', 'd.id', '=', 'a.admin')
                    ->join('users as e', 'e.id', '=', 'a.admin_g')
                    ->join('tb_karyawan as f', 'f.id', '=', 'a.qc')
                    ->join('tb_karyawan as g', 'g.id', '=', 'a.driver')
                    ->select(
                        "a.*",
                        "b.nama_gudang as dari",
                        "c.nama_gudang as kepada",
                        "b.alamat as alamat_dari",
                        "c.alamat as alamat_kepada",
                        "d.name as adminp",
                        "e.name as adming",
                        "f.nama as qc",
                        "g.nama as driver"
                    )
                    ->where("a.status_transfer", "=", "proses")
                    ->orWhere("a.status_transfer", "=", 'kirim ulang')->get();
            } else {
                $data['transfer'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_gudang as b', 'b.id', '=', 'a.dari')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.kepada')->join('users as d', 'd.id', '=', 'a.admin')
                    ->join('users as e', 'e.id', '=', 'a.admin_g')
                    ->join('tb_karyawan as f', 'f.id', '=', 'a.qc')
                    ->join('tb_karyawan as g', 'g.id', '=', 'a.driver')
                    ->select(
                        "a.*",
                        "b.nama_gudang as dari",
                        "c.nama_gudang as kepada",
                        "b.alamat as alamat_dari",
                        "c.alamat as alamat_kepada",
                        "d.name as adminp",
                        "e.name as adming",
                        "f.nama as qc",
                        "g.nama as driver"
                    )
                    ->where("a.dari", "=", Auth::user()->gudang)
                    ->where("a.status_transfer", "=", "proses")
                    ->orWhere("a.status_transfer", "=", 'kirim ulang')->get();
            }
            $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.jabatan", "=", "2")->where("a.status", "=", "aktif")->get();
            $data['driver'] = DB::table('tb_karyawan as a')->select("*")->where("a.jabatan", "=", "1")->where("a.status", "=", "aktif")->get();

            $id = Auth::user()->gudang;
            $data['gudang'] = $this->model->getGudangby($id);
            $data['kepada'] = DB::table('tb_gudang as a')->select("a.*")->where("a.status", "=", "aktif")->where('id', '!=', $id)->get();
            return view('Penerimaan', $data);
        } else {
            return view('Denied');
        }
    }
    public function updatepenerimaan($proses, $terkirim, $id)
    {
        $data['terkirim'] = $terkirim;
        $data['retur'] = $proses - $terkirim;
        if ($data['retur'] > 0) {
            $data['verifikasi_return'] = "pending";
        }
        DB::table('tb_detail_transfer')->where('id', '=', $id)->update($data);
        echo json_encode($data);
    }

    public function postdetailtransferpenerimaan(Request $post)
    {
        $d = $post->except('_token');
        $barang = explode(",", $post->only('barang')['barang']);
        $pengorder = explode(",", $post->only('gudang')['gudang']);
        $terkirim = explode(",", $post->only('terkirim')['terkirim']);
        $retur = explode(",", $post->only('retur')['retur']);
        $pemroses = explode(",", $post->only('gudang_retur')['gudang_retur']);

        //update transfer
        $data['status_transfer'] = $d['status'];
        $data['admin_v'] = Auth::user()->id;
        date_default_timezone_set('Asia/Jakarta');
        $data['tanggal_terkirim'] = date('Y-m-d');
        DB::table('tb_transfer_stok')->where('id', '=', $d['no_transfer'])->update($data);
        //end update transfer

        for ($i = 1; $i < count($barang); $i++) {
            $at['jumlah'] = $terkirim[$i];
            $at['id_gudang'] = $pengorder[$i];
            $at['id_barang'] = $barang[$i];
            $at['status'] = "aktif";

            $alldata = $terkirim[$i] + $retur[$i];

            $cek = DB::table('tb_gudang_barang as a')->select("*")->where('id_barang', '=', $barang[$i])->where('id_gudang', '=', $pengorder[$i])->get();
            if (count($cek) > 0) {
                //update terkirim
                $trc = DB::table('tb_gudang_barang')->where('id_barang', '=', $barang[$i])->where('id_gudang', '=', $pengorder[$i])->increment('jumlah', $alldata);

                //tracking data
                if ($trc) {
                    $tracking['jenis_transaksi'] = "postdetailtransferpenerimaan";
                    $tracking['nomor'] = "id " . $d['no_transfer'];
                    $tracking['gudang'] = $pengorder[$i];
                    $tracking['barang'] = $barang[$i];
                    $tracking['jumlah'] = $alldata;
                    $tracking['stok'] = "in";
                    DB::table('tracking')->insert($tracking);
                }

                //DB::table('tb_gudang_barang')->where('id_barang','=',$barang[$i])->where('id_gudang','=',$pengorder[$i])->increment('jumlah', $terkirim[$i]);
                //update retur
                //DB::table('tb_gudang_barang')->where('id_barang','=',$barang[$i])->where('id_gudang','=',$pemroses[$i])->increment('jumlah', $retur[$i]);
            } else {
                $harga = DB::table('tb_harga as a')->select("a.harga")->where('id_barang', '=', $barang[$i])->get();
                $at['harga'] = $harga[0]->harga;
                DB::table('tb_gudang_barang')->insert($at);
                $trc = DB::table('tb_gudang_barang')->where('id_barang', '=', $barang[$i])->where('id_gudang', '=', $pemroses[$i])->increment('jumlah', $retur[$i]);

                //tracking data
                if ($trc) {
                    $tracking['jenis_transaksi'] = "postdetailtransferpenerimaan";
                    $tracking['nomor'] = "id " . $d['no_transfer'] . " onelse";
                    $tracking['gudang'] = $pemroses[$i];
                    $tracking['barang'] = $barang[$i];
                    $tracking['jumlah'] = $retur[$i];
                    $tracking['stok'] = "in";
                    DB::table('tracking')->insert($tracking);
                }
            }
        }
        echo json_encode($data);
    }

    public function verifikasipengembalian()
    {
        if (role()) {
            $data['gudang'] = $this->model->getGudang();
            foreach ($data['gudang']  as $key => $value) {
                $data['gdg'][$value->id] = $value->nama_gudang;
            }
            if (Auth::user()->level == "1") {
                $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_gudang as b', 'b.id', '=', 'a.dari')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.kepada')
                    ->join('tb_detail_transfer as d', 'd.no_transfer', '=', 'a.no_transfer')
                    ->select("a.*", "d.*", "a.admin", "b.nama_gudang as dari", "c.nama_gudang as kepada", "d.id as id_retur")
                    ->where("a.status_transfer", "terkirim")
                    ->where("d.verifikasi_return", "pending")
                    ->get();
            } elseif (Auth::user()->gudang == "1") {
                $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_gudang as b', 'b.id', '=', 'a.dari')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.kepada')
                    ->join('tb_detail_transfer as d', 'd.no_transfer', '=', 'a.no_transfer')
                    ->select("a.*", "d.*", "a.admin", "b.nama_gudang as dari", "c.nama_gudang as kepada", "d.id as id_retur")
                    ->where("a.status_transfer", "terkirim")
                    ->where("d.verifikasi_return", "pending")
                    ->get();
            } else {
                $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_gudang as b', 'b.id', '=', 'a.dari')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.kepada')
                    ->join('tb_detail_transfer as d', 'd.no_transfer', '=', 'a.no_transfer')
                    ->select("a.*", "d.*", "a.admin", "b.nama_gudang as dari", "c.nama_gudang as kepada", "d.id as id_retur")
                    ->where("a.kepada", Auth::user()->gudang)
                    ->where("a.status_transfer", "terkirim")
                    ->where("d.verifikasi_return", "pending")
                    ->get();
            }
            $text_barang = DB::table('tb_barang as a')->select("a.*")->get();
            $data['barang'] = array();
            foreach ($text_barang as $value) {
                $data['barang'][$value->id]['no_sku'] = $value->no_sku;
                $data['barang'][$value->id]['nama_barang'] = $value->nama_barang;
                $data['barang'][$value->id]['part_number'] = $value->part_number;
            }
            return view('DaftarPengembalianStok', $data);
        } else {
            return view('Denied');
        }
    }

    public function verifikasipenjualan()
    {
        if (role()) {
            if (Auth::user()->level == "1") {
                $data['verifikasi'] = DB::table('tb_detail_barang_keluar as a')
                    //->join('tb_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                    ->select("*", "a.id as id_retur")
                    ->where("a.verifikasi_return", "=", "pending")->get();
            } else {
                $data['verifikasi'] = DB::table('tb_detail_barang_keluar as a')
                    //->join('tb_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                    ->select("*", "a.id as id_retur")
                    ->where("a.verifikasi_return", "=", "pending")
                    //->where("b.id_gudang","=",Auth::user()->gudang)
                    ->groupBy("a.no_kwitansi")->get();
            }
            $data['bk'] = array();
            if (Auth::user()->level == "1") {
                foreach ($data['verifikasi'] as $key => $value) {
                    $bk = DB::table('tb_barang_keluar as a')->where('a.status_barang', 'terkirim')->where('a.no_kwitansi', $value->no_kwitansi)->get();
                    if (count($bk) > 0) {
                        $data['bk'][$value->no_kwitansi]['tanggal_terkirim'] = $bk[0]->tanggal_terkirim;
                        $data['bk'][$value->no_kwitansi]['id_gudang'] = $bk[0]->id_gudang;
                        $data['bk'][$value->no_kwitansi]['id_konsumen'] = $bk[0]->id_konsumen;
                    }
                }
            } else {
                foreach ($data['verifikasi'] as $key => $value) {
                    $bk = DB::table('tb_barang_keluar as a')->where('a.status_barang', 'terkirim')
                        ->where("a.id_gudang", "=", Auth::user()->gudang)->where('a.no_kwitansi', $value->no_kwitansi)->get();
                    if (count($bk) > 0) {
                        $data['bk'][$value->no_kwitansi]['tanggal_terkirim'] = $bk[0]->tanggal_terkirim;
                        $data['bk'][$value->no_kwitansi]['id_gudang'] = $bk[0]->id_gudang;
                        $data['bk'][$value->no_kwitansi]['id_konsumen'] = $bk[0]->id_konsumen;
                    }
                }
            }
            $gudang = DB::table('tb_gudang as a')->select("a.*")->get();
            foreach ($gudang as $key => $value) {
                $data['gudang'][$value->id] = $value->nama_gudang;
            }
            $text_barang = DB::table('tb_barang as a')->select("a.*")->get();
            $data['barang'] = array();
            foreach ($text_barang as $value) {
                $data['barang'][$value->id]['no_sku'] = $value->no_sku;
                $data['barang'][$value->id]['nama_barang'] = $value->nama_barang;
                $data['barang'][$value->id]['part_number'] = $value->part_number;
            }

            $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
            foreach ($konsumen as $key => $value) {
                $data['konsumen'][$value->id]['id'] = $value->id_konsumen;
                $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
                $data['konsumen'][$value->id]['alamat'] = $value->alamat;
                $data['konsumen'][$value->id]['no_hp'] = $value->no_hp;
            }
            $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
            foreach ($karyawan as $key => $value) {
                $data['karyawan'][$value->id]['id'] = $value->id;
                $data['karyawan'][$value->id]['nama'] = $value->nama;
                $data['karyawan'][$value->id]['alamat'] = $value->alamat;
                $data['karyawan'][$value->id]['no_hp'] = $value->no_hp;
            }
            return view('DaftarPengembalianPenjualan', $data);
        } else {
            return view('Denied');
        }
    }

    public function verifikasireturpenjualan($id)
    {
        $cek = DB::table('tb_detail_barang_keluar as a')
            ->join('tb_barang_keluar as b', 'b.no_kwitansi', '=', 'a.no_kwitansi')
            ->select("*")->where('a.id', $id)->where('a.verifikasi_return', 'pending')->get();
        $sq = DB::table('tb_gudang_barang')->where('id_barang', '=', $cek[0]->id_barang)->where('id_gudang', '=', $cek[0]->id_gudang)->increment('jumlah', $cek[0]->return);

        //tracking data
        if ($sq) {
            $tracking['jenis_transaksi'] = "verifikasireturpenjualan" . $id;
            $tracking['gudang'] = $cek[0]->id_gudang;
            $tracking['barang'] = $cek[0]->id_barang;
            $tracking['jumlah'] = $cek[0]->return;
            $tracking['stok'] = "in";
            DB::table('tracking')->insert($tracking);
        }

        if ($sq) {
            $dt['verifikasi_return'] = "approved";
            DB::table('tb_detail_barang_keluar')->where('id', $id)->update($dt);
            return redirect()->back()->with('success', 'Berhasil');
        } else {
            return redirect()->back()->with('error', 'Berhasil');
        }
    }

    public function verifikasiretur($id)
    {
        $cek = DB::table('tb_detail_transfer as a')
            ->join('tb_transfer_stok as b', 'b.no_transfer', '=', 'a.no_transfer')
            ->select("*")->where('a.id', $id)->where('a.verifikasi_return', 'pending')->get();
        $sq = DB::table('tb_gudang_barang')->where('id_barang', '=', $cek[0]->id_barang)->where('id_gudang', '=', $cek[0]->kepada)->increment('jumlah', $cek[0]->retur);

        //tracking data
        if ($sq) {
            $tracking['jenis_transaksi'] = "verifikasiretur" . $id;
            $tracking['gudang'] = $cek[0]->kepada;
            $tracking['barang'] = $cek[0]->id_barang;
            $tracking['jumlah'] = $cek[0]->retur;
            $tracking['stok'] = "in";
            DB::table('tracking')->insert($tracking);
        }

        if ($sq) {
            $sq2 = DB::table('tb_gudang_barang')->where('id_barang', '=', $cek[0]->id_barang)->where('id_gudang', '=', $cek[0]->dari)->decrement('jumlah', $cek[0]->retur);

            //tracking data
            if ($sq2) {
                $tracking['jenis_transaksi'] = "verifikasiretur " . $id;
                $tracking['gudang'] = $cek[0]->dari;
                $tracking['barang'] = $cek[0]->id_barang;
                $tracking['jumlah'] = $cek[0]->retur;
                $tracking['stok'] = "out";
                DB::table('tracking')->insert($tracking);
            }
        }
        if ($sq2) {
            $dt['verifikasi_return'] = "approved";
            DB::table('tb_detail_transfer')->where('id', $id)->update($dt);
            return redirect()->back()->with('success', 'Berhasil');
        } else {
            return redirect()->back()->with('error', 'Berhasil');
        }
    }

    public function verifikasireturreject($id)
    {
        $cek = DB::table('tb_detail_transfer as a')
            ->join('tb_transfer_stok as b', 'b.no_transfer', '=', 'a.no_transfer')
            ->select("*")->where('a.id', $id)->where('a.verifikasi_return', 'pending')->get();
        //dd($cek);
        $dt['retur'] = 0;
        $dt['terkirim'] = $cek[0]->terkirim + $cek[0]->retur;
        $dt['verifikasi_return'] = "canceled";
        $query = DB::table('tb_detail_transfer')->where('id', $id)->update($dt);
        if ($query) {
            return redirect()->back()->with('success', 'Berhasil');
        } else {
            return redirect()->back()->with('error', 'Berhasil');
        }
    }

    public function cancelreturpenjualan($id)
    {
        $cek = DB::table('tb_detail_barang_keluar as a')
            ->join('tb_barang_keluar as b', 'b.no_kwitansi', '=', 'a.no_kwitansi')
            ->select("*")->where('a.id', $id)->where('a.verifikasi_return', 'pending')->get();
        $dt['verifikasi_return'] = "canceled";
        $dt['return'] = 0;
        $dt['terkirim'] = $cek[0]->terkirim +  $cek[0]->return;

        if ($cek[0]->terkirim == "0") {
            $terkirim = 1;
        } else {
            $terkirim = $cek[0]->terkirim;
        }

        $dt['sub_total'] = ($dt['terkirim'] * ($cek[0]->harga_jual - $cek[0]->potongan - ($cek[0]->sub_potongan / $terkirim)));
        $dt['sub_potongan'] = ($cek[0]->sub_potongan / $terkirim) * $dt['terkirim'];
        $query = DB::table('tb_detail_barang_keluar')->where('id', $id)->update($dt);
        if ($query) {
            $cx['total_bayar'] = $cek[0]->total_bayar - $cek[0]->sub_total + $dt['sub_total'];
            $query = DB::table('tb_barang_keluar')->where('no_kwitansi', $cek[0]->no_kwitansi)->update($cx);
            return redirect()->back()->with('success', 'Berhasil');
        } else {
            return redirect()->back()->with('error', 'Berhasil');
        }
    }

    public function updatetransferstokpenerimaan($no_transfer, $status)
    {
        $data['status_transfer'] = $status;
        $data['admin_v'] = Auth::user()->id;
        $data['tanggal_terkirim'] = date('Y-m-d');
        DB::table('tb_transfer_stok')->where('id', '=', $no_transfer)->update($data);
        echo json_encode($data);
    }
    public function updatedetailtransferstokpenerimaan($id_barang, $id_gudang, $value, $retur, $gudang_retur)
    {
        $data['jumlah'] = $value;
        $data['id_gudang'] = $id_gudang;
        $data['id_barang'] = $id_barang;
        $data['status'] = "aktif";

        $cek = DB::table('tb_gudang_barang as a')->select("*")->where('id_barang', '=', $id_barang)->where('id_gudang', '=', $id_gudang)->get();
        if (count($cek) > 0) {
            //update terkirim
            $trc1 = DB::table('tb_gudang_barang')->where('id_barang', '=', $id_barang)->where('id_gudang', '=', $id_gudang)->increment('jumlah', $value);

            //tracking data
            if ($trc1) {
                $tracking['jenis_transaksi'] = "updatedetailtransferstokpenerimaan";
                $tracking['nomor'] = "//update terkirim";
                $tracking['gudang'] = $id_gudang;
                $tracking['barang'] = $id_barang;
                $tracking['jumlah'] = $value;
                $tracking['stok'] = "in";
                DB::table('tracking')->insert($tracking);
            }

            //update retur
            $trc2 = DB::table('tb_gudang_barang')->where('id_barang', '=', $id_barang)->where('id_gudang', '=', $gudang_retur)->increment('jumlah', $retur);

            //tracking data
            if ($trc2) {
                $tracking['jenis_transaksi'] = "updatedetailtransferstokpenerimaan";
                $tracking['nomor'] = "//update retur";
                $tracking['gudang'] = $gudang_retur;
                $tracking['barang'] = $id_barang;
                $tracking['jumlah'] = $retur;
                $tracking['stok'] = "in";
                DB::table('tracking')->insert($tracking);
            }
        } else {
            $harga = DB::table('tb_harga as a')->select("a.harga")->where('id_barang', '=', $id_barang)->get();
            $data['harga'] = $harga[0]->harga;
            DB::table('tb_gudang_barang')->insert($data);
            $trc3 = DB::table('tb_gudang_barang')->where('id_barang', '=', $id_barang)->where('id_gudang', '=', $gudang_retur)->increment('jumlah', $retur);

            //tracking data
            if ($trc3) {
                $tracking['jenis_transaksi'] = "updatedetailtransferstokpenerimaan";
                $tracking['nomor'] = "trc3";
                $tracking['gudang'] = $gudang_retur;
                $tracking['barang'] = $id_barang;
                $tracking['jumlah'] = $retur;
                $tracking['stok'] = "in";
                DB::table('tracking')->insert($tracking);
            }
        }

        echo json_encode($data);
    }
    public function datatransferstok()
    {
        if (role() || Auth::user()->level == "3") {
            $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.status", "=", "aktif")->get();
            $data['jabatan'] = DB::table('tb_jabatan as a')->select("*")->where("a.status", "=", "aktif")->get();
            $data['data'] = DB::table('tb_transfer_stok as a')
                ->join('tb_detail_transfer as b', 'b.no_transfer', '=', 'a.no_transfer')
                ->join('tb_barang as c', 'c.id', '=', 'b.id_barang')
                ->join('tb_gudang as d', function ($join) {
                    $join->on("a.dari", "=", "d.id");
                })
                ->join('tb_gudang as e', function ($join) {
                    $join->on("a.kepada", "=", "e.id");
                })
                ->join('tb_karyawan as f', 'f.id', '=', 'a.driver')
                ->join('tb_karyawan as g', 'g.id', '=', 'a.qc')
                ->join('users as h', 'h.id', '=', 'a.admin')
                ->join('users as i', 'i.id', '=', 'a.admin_g')
                ->leftJoin('users as j', 'j.id', '=', 'a.admin_v')
                ->select(
                    "a.id",
                    "a.no_transfer",
                    "a.tanggal_order",
                    "a.tanggal_kirim",
                    "d.nama_gudang as dari",
                    "e.nama_gudang as kepada",
                    "c.no_sku",
                    "c.nama_barang",
                    "c.part_number",
                    "b.jumlah",
                    "a.status_transfer",
                    "b.proses",
                    "b.pending",
                    "b.retur",
                    "b.terkirim",
                    "f.nama as driver",
                    "g.nama as qc",
                    "h.name as admin",
                    "i.name as admin_g",
                    "j.name as admin_v",
                    "a.tanggal_terkirim"
                )
                ->where("b.proses", "<>", "0")
                ->orderBy("a.id", "DESC")
                ->limit(1000)
                ->get();
            $data['nama_download'] = "Data Transfer Stok";
            //dd($data);
            return view('DataTransferStok', $data);
        } else {
            return view('Denied');
        }
    }
    public function datatransferstoks(Request $post)
    {
        if (role() || Auth::user()->level == "3") {
            $x = $post->except('_token');
            if ($x['dari'] != null) {
                $k['dari'] = $x['dari'];
                $data['dari'] = $x['dari'];
            }
            if ($x['kepada'] != null) {
                $k['kepada'] = $x['kepada'];
                $data['kepada'] = $x['kepada'];
            }
            if ($x['from'] != null && $x['to'] != null) {
                $from = $x['from'];
                $to = $x['to'];
                $data['from'] = $x['from'];
                $data['to'] = $x['to'];
            }
            if ($x['status_transfer'] != null) {
                $k['status_transfer'] = $x['status_transfer'];
                $data['status_transfer'] = $x['status_transfer'];
            }
            if ($x['nama_barang'] != null) {
                $nm = $x['nama_barang'];
                $data['nama_barang'] = $x['nama_barang'];
            }
            //dd($k);

            if (isset($k) && isset($from) && isset($nm)) {
                $data['data'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_detail_transfer as b', 'b.no_transfer', '=', 'a.no_transfer')
                    ->join('tb_barang as c', 'c.id', '=', 'b.id_barang')
                    ->join('tb_gudang as d', function ($join) {
                        $join->on("a.dari", "=", "d.id");
                    })
                    ->join('tb_gudang as e', function ($join) {
                        $join->on("a.kepada", "=", "e.id");
                    })
                    ->leftJoin('tb_karyawan as f', 'f.id', '=', 'a.driver')
                    ->leftJoin('tb_karyawan as g', 'g.id', '=', 'a.qc')
                    ->leftJoin('users as h', 'h.id', '=', 'a.admin')
                    ->leftJoin('users as i', 'i.id', '=', 'a.admin_g')
                    ->leftJoin('users as j', 'j.id', '=', 'a.admin_v')
                    ->select(
                        "a.id",
                        "a.no_transfer",
                        "a.tanggal_order",
                        "a.tanggal_kirim",
                        "d.nama_gudang as dari",
                        "e.nama_gudang as kepada",
                        "c.no_sku",
                        "c.nama_barang",
                        "c.part_number",
                        "b.jumlah",
                        "a.status_transfer",
                        "b.proses",
                        "b.pending",
                        "b.retur",
                        "b.terkirim",
                        "f.nama as driver",
                        "g.nama as qc",
                        "h.name as admin",
                        "i.name as admin_g",
                        "j.name as admin_v",
                        "a.tanggal_terkirim"
                    )
                    ->where($k)
                    ->where('nama_barang', 'like', "%$nm%")
                    ->whereBetween('tanggal_order', [$from, $to])
                    ->where("b.proses", "<>", "0")
                    ->get();
            } else if (isset($k) && isset($nm)) {
                $data['data'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_detail_transfer as b', 'b.no_transfer', '=', 'a.no_transfer')
                    ->join('tb_barang as c', 'c.id', '=', 'b.id_barang')
                    ->join('tb_gudang as d', function ($join) {
                        $join->on("a.dari", "=", "d.id");
                    })
                    ->join('tb_gudang as e', function ($join) {
                        $join->on("a.kepada", "=", "e.id");
                    })
                    ->leftJoin('tb_karyawan as f', 'f.id', '=', 'a.driver')
                    ->leftJoin('tb_karyawan as g', 'g.id', '=', 'a.qc')
                    ->leftJoin('users as h', 'h.id', '=', 'a.admin')
                    ->leftJoin('users as i', 'i.id', '=', 'a.admin_g')
                    ->leftJoin('users as j', 'j.id', '=', 'a.admin_v')
                    ->select(
                        "a.id",
                        "a.no_transfer",
                        "a.tanggal_order",
                        "a.tanggal_kirim",
                        "d.nama_gudang as dari",
                        "e.nama_gudang as kepada",
                        "c.no_sku",
                        "c.nama_barang",
                        "c.part_number",
                        "b.jumlah",
                        "a.status_transfer",
                        "b.proses",
                        "b.pending",
                        "b.retur",
                        "b.terkirim",
                        "f.nama as driver",
                        "g.nama as qc",
                        "h.name as admin",
                        "i.name as admin_g",
                        "j.name as admin_v",
                        "a.tanggal_terkirim"
                    )
                    ->where($k)
                    ->where('nama_barang', 'like', "%$nm%")
                    ->where("b.proses", "<>", "0")
                    ->get();
            } else if (isset($from) && isset($nm)) {
                $data['data'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_detail_transfer as b', 'b.no_transfer', '=', 'a.no_transfer')
                    ->join('tb_barang as c', 'c.id', '=', 'b.id_barang')
                    ->join('tb_gudang as d', function ($join) {
                        $join->on("a.dari", "=", "d.id");
                    })
                    ->join('tb_gudang as e', function ($join) {
                        $join->on("a.kepada", "=", "e.id");
                    })
                    ->leftJoin('tb_karyawan as f', 'f.id', '=', 'a.driver')
                    ->leftJoin('tb_karyawan as g', 'g.id', '=', 'a.qc')
                    ->leftJoin('users as h', 'h.id', '=', 'a.admin')
                    ->leftJoin('users as i', 'i.id', '=', 'a.admin_g')
                    ->leftJoin('users as j', 'j.id', '=', 'a.admin_v')
                    ->select(
                        "a.id",
                        "a.no_transfer",
                        "a.tanggal_order",
                        "a.tanggal_kirim",
                        "d.nama_gudang as dari",
                        "e.nama_gudang as kepada",
                        "c.no_sku",
                        "c.nama_barang",
                        "c.part_number",
                        "b.jumlah",
                        "a.status_transfer",
                        "b.proses",
                        "b.pending",
                        "b.retur",
                        "b.terkirim",
                        "f.nama as driver",
                        "g.nama as qc",
                        "h.name as admin",
                        "i.name as admin_g",
                        "j.name as admin_v",
                        "a.tanggal_terkirim"
                    )
                    ->whereBetween('tanggal_kirim', [$from, $to])
                    ->where('nama_barang', 'like', "%$nm%")
                    ->where("b.proses", "<>", "0")
                    ->get();
            } else if (isset($from)) {
                $data['data'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_detail_transfer as b', 'b.no_transfer', '=', 'a.no_transfer')
                    ->join('tb_barang as c', 'c.id', '=', 'b.id_barang')
                    ->join('tb_gudang as d', function ($join) {
                        $join->on("a.dari", "=", "d.id");
                    })
                    ->join('tb_gudang as e', function ($join) {
                        $join->on("a.kepada", "=", "e.id");
                    })
                    ->leftJoin('tb_karyawan as f', 'f.id', '=', 'a.driver')
                    ->leftJoin('tb_karyawan as g', 'g.id', '=', 'a.qc')
                    ->leftJoin('users as h', 'h.id', '=', 'a.admin')
                    ->leftJoin('users as i', 'i.id', '=', 'a.admin_g')
                    ->leftJoin('users as j', 'j.id', '=', 'a.admin_v')
                    ->select(
                        "a.id",
                        "a.no_transfer",
                        "a.tanggal_order",
                        "a.tanggal_kirim",
                        "d.nama_gudang as dari",
                        "e.nama_gudang as kepada",
                        "c.no_sku",
                        "c.nama_barang",
                        "c.part_number",
                        "b.jumlah",
                        "a.status_transfer",
                        "b.proses",
                        "b.pending",
                        "b.retur",
                        "b.terkirim",
                        "f.nama as driver",
                        "g.nama as qc",
                        "h.name as admin",
                        "i.name as admin_g",
                        "j.name as admin_v",
                        "a.tanggal_terkirim"
                    )
                    ->whereBetween('tanggal_kirim', [$from, $to])
                    ->where("b.proses", "<>", "0")
                    ->get();
            } else if (isset($k)) {
                $data['data'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_detail_transfer as b', 'b.no_transfer', '=', 'a.no_transfer')
                    ->join('tb_barang as c', 'c.id', '=', 'b.id_barang')
                    ->join('tb_gudang as d', function ($join) {
                        $join->on("a.dari", "=", "d.id");
                    })
                    ->join('tb_gudang as e', function ($join) {
                        $join->on("a.kepada", "=", "e.id");
                    })
                    ->leftJoin('tb_karyawan as f', 'f.id', '=', 'a.driver')
                    ->leftJoin('tb_karyawan as g', 'g.id', '=', 'a.qc')
                    ->leftJoin('users as h', 'h.id', '=', 'a.admin')
                    ->leftJoin('users as i', 'i.id', '=', 'a.admin_g')
                    ->leftJoin('users as j', 'j.id', '=', 'a.admin_v')
                    ->select(
                        "a.id",
                        "a.no_transfer",
                        "a.tanggal_order",
                        "a.tanggal_kirim",
                        "d.nama_gudang as dari",
                        "e.nama_gudang as kepada",
                        "c.no_sku",
                        "c.nama_barang",
                        "c.part_number",
                        "b.jumlah",
                        "a.status_transfer",
                        "b.proses",
                        "b.pending",
                        "b.retur",
                        "b.terkirim",
                        "f.nama as driver",
                        "g.nama as qc",
                        "h.name as admin",
                        "i.name as admin_g",
                        "j.name as admin_v",
                        "a.tanggal_terkirim"
                    )
                    ->where($k)
                    ->where("b.proses", "<>", "0")
                    ->get();
            }

            $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.status", "=", "aktif")->get();
            $data['jabatan'] = DB::table('tb_jabatan as a')->select("*")->where("a.status", "=", "aktif")->get();
            $data['nama_download'] = "Data Transfer Stok";
            //dd($data);
            return view('DataTransferStok', $data);
        } else {
            return view('Denied');
        }
    }


    public function datatransferstokbyname(Request $post)
    {

        if (role() || Auth::user()->level == "3" || Auth::user()->level == "1") {
            $x = $post->except('_token');

            if ($x['nama_barang'] != null || $x['nama_barang'] != "") {
                $nm = $x['nama_barang'];
                $data['nama_barangs'] = $x['nama_barang'];
            }
            //dd($k);

            if (isset($nm)) {
                $data['data'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_detail_transfer as b', 'b.no_transfer', '=', 'a.no_transfer')
                    ->join('tb_barang as c', 'c.id', '=', 'b.id_barang')
                    ->join('tb_gudang as d', function ($join) {
                        $join->on("a.dari", "=", "d.id");
                    })
                    ->join('tb_gudang as e', function ($join) {
                        $join->on("a.kepada", "=", "e.id");
                    })
                    ->leftJoin('tb_karyawan as f', 'f.id', '=', 'a.driver')
                    ->leftJoin('tb_karyawan as g', 'g.id', '=', 'a.qc')
                    ->leftJoin('users as h', 'h.id', '=', 'a.admin')
                    ->leftJoin('users as i', 'i.id', '=', 'a.admin_g')
                    ->leftJoin('users as j', 'j.id', '=', 'a.admin_v')
                    ->select(
                        "a.id",
                        "a.no_transfer",
                        "a.tanggal_order",
                        "a.tanggal_kirim",
                        "d.nama_gudang as dari",
                        "e.nama_gudang as kepada",
                        "c.no_sku",
                        "c.nama_barang",
                        "c.part_number",
                        "b.jumlah",
                        "a.status_transfer",
                        "b.proses",
                        "b.pending",
                        "b.retur",
                        "b.terkirim",
                        "f.nama as driver",
                        "g.nama as qc",
                        "h.name as admin",
                        "i.name as admin_g",
                        "j.name as admin_v",
                        "a.tanggal_terkirim"
                    )
                    ->where('nama_barang', 'like', "%$nm%")
                    ->where("b.proses", "<>", "0")
                    ->get();
            }
            $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.status", "=", "aktif")->get();
            $data['jabatan'] = DB::table('tb_jabatan as a')->select("*")->where("a.status", "=", "aktif")->get();
            $data['nama_download'] = "Data Transfer Stok";
            //dd($data);
            return view('DataTransferStok', $data);
        } else {
            return view('Denied');
        }
    }


    public function inputorderbaru()
    {
        if (role()) {
            $d['bm'] = DB::table('tb_barang_keluar as a')->select("*")->where("a.status", "=", "aktif")->where("a.tanggal_order", "=", date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();
            if (count($d['bm']) > 0) {
                $var = substr($d['bm'][0]->no_kwitansi, 9, 3);
                $data['number'] = str_pad($var + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $data['number'] = "001";
            }
            $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik", "=", Auth::user()->nik)->get();
            if (Auth::user()->level == "1") {
                $data['gudang'] = $this->model->getGudang();
                $data['konsumen'] = DB::table('tb_konsumen as a')->join('tb_karyawan as b', 'b.id', '=', 'a.pengembang')->select("a.*", "b.nama")
                    ->where("a.status", "=", "aktif")->get();
                $data['kategori'] = DB::table('tb_kategori as a')->select("a.*")->where("a.status", "=", "aktif")->get();
            } else {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.status", "=", "aktif")->where("a.id", "=", Auth::user()->gudang)->get();
                if (Auth::user()->gudang == "1") {
                    $data['kategori'] = DB::table('tb_kategori as a')->select("a.*")->where("a.status", "=", "aktif")
                        //->where("a.id","=","1")
                        ->get();
                } else {
                    $data['kategori'] = DB::table('tb_kategori as a')->select("a.*")->where("a.status", "=", "aktif")
                        //->where("a.id","=","2")->orWhere("a.id","=","3")
                        ->get();
                }
                $data['konsumen'] = DB::table('tb_konsumen as a')->join('tb_karyawan as b', 'b.id', '=', 'a.pengembang')->select("a.*", "b.nama")
                    ->where("a.status", "=", "aktif")->where("a.kategori", Auth::user()->gudang)->get();
            }

            $data['status_order'] = DB::table('tb_status_order as a')->select("a.*")->where("a.status", "=", "aktif")->get();
            $data['sales'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
            $data['leader'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
            $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
            $data['manager'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->get();
            $data['barang'] = DB::table('tb_barang as a')->join('tb_harga as b', 'b.id_barang', '=', 'a.id')
                ->select("a.*", "harga", "harga_hp", "harga_hpp", "harga_retail", "harga_reseller", "harga_agen", "qty1", "pot1", "qty2", "pot2", "qty3", "pot3", "label")->where("a.status", "=", "aktif")->get();


            if (Auth::user()->level == "1") {
                $data['pelanggan'] = DB::table('tb_konsumen as a')
                    ->join('tb_karyawan as b', 'b.id', '=', 'a.pengembang')
                    ->leftJoin('tb_karyawan as c', 'c.id', '=', 'a.leader')
                    ->select("a.*", "b.nama", "c.nama as nama_leader")->where("a.status", "=", "aktif")
                    ->get();
            } else if (Auth::user()->level == "5") {
                $data['pelanggan'] = DB::table('tb_konsumen as a')
                    ->join('tb_karyawan as b', 'b.id', '=', 'a.pengembang')
                    ->leftJoin('tb_karyawan as c', 'c.id', '=', 'a.leader')
                    ->select("a.*", "b.nama", "c.nama as nama_leader")->where("a.status", "=", "aktif")
                    ->where("a.kategori", "=", Auth::user()->gudang)
                    ->where("a.pengembang", "=", $p[0]->id)->get();
            } else {
                $data['pelanggan'] = DB::table('tb_konsumen as a')
                    ->join('tb_karyawan as b', 'b.id', '=', 'a.pengembang')
                    ->leftJoin('tb_karyawan as c', 'c.id', '=', 'a.leader')
                    ->select("a.*", "b.nama", "c.nama as nama_leader")->where("a.status", "=", "aktif")
                    ->where("a.kategori", "=", Auth::user()->gudang)
                    ->get();
            }

            $data['staff'] = DB::table('tb_karyawan as a')
                ->select("a.*")->where("a.status", "=", "aktif")
                ->get();

            return view('InputOrderBaru', $data);
        } else {
            return view('Denied');
        }
    }

    public function cariKaryawan($id, $status)
    {
        $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik", "=", Auth::user()->nik)->get();
        if (Auth::user()->gudang == "1") {
            if ($status == "2" || $status == "3") {
                $data = DB::table('tb_karyawan as a')
                    ->select("a.*")->where("a.status", "=", "aktif")
                    ->get();
            } else {
                if (Auth::user()->level == "1") {
                    $data = DB::table('tb_konsumen as a')->join('tb_karyawan as b', 'b.id', '=', 'a.pengembang')
                        ->select("a.*", "b.nama")->where("a.status", "=", "aktif")
                        ->get();
                } else if (Auth::user()->level == "5") {
                    $data = DB::table('tb_konsumen as a')->join('tb_karyawan as b', 'b.id', '=', 'a.pengembang')
                        ->select("a.*", "b.nama")->where("a.status", "=", "aktif")
                        ->where("a.kategori", "=", Auth::user()->gudang)
                        ->where("a.pengembang", "=", $p[0]->id)->get();
                } else if (Auth::user()->gudang == "2") {
                    $data = DB::table('tb_konsumen as a')->join('tb_karyawan as b', 'b.id', '=', 'a.pengembang')
                        ->select("a.*", "b.nama")->where("a.status", "=", "aktif")
                        ->where("a.kategori", "<>", "1")
                        //->where("a.pengembang","=",$p[0]->id)
                        ->get();
                } else {
                    $data = DB::table('tb_konsumen as a')->join('tb_karyawan as b', 'b.id', '=', 'a.pengembang')
                        ->select("a.*", "b.nama")->where("a.status", "=", "aktif")
                        ->where("a.kategori", "=", Auth::user()->gudang)
                        ->get();
                }
            }
        } else {
            if ($status == "2" || $status == "3") {
                $data = DB::table('tb_karyawan as a')
                    ->select("a.*")->where("a.status", "=", "aktif")
                    ->get();
            } else {
                if (Auth::user()->level == "5") {
                    $data = DB::table('tb_konsumen as a')->join('tb_karyawan as b', 'b.id', '=', 'a.pengembang')
                        ->select("a.*", "b.nama")->where("a.status", "=", "aktif")
                        ->where("a.kategori", "=", Auth::user()->gudang)
                        ->where("a.pengembang", "=", $p[0]->id)->get();
                } else {
                    $data = DB::table('tb_konsumen as a')->join('tb_karyawan as b', 'b.id', '=', 'a.pengembang')
                        ->select("a.*", "b.nama")->where("a.status", "=", "aktif")
                        ->where("a.kategori", "=", Auth::user()->gudang)
                        ->get();
                }
            }
        }
        echo json_encode($data);
    }

    public function postbarangkeluar(Request $post)
    {
        $data = $post->except('_token');
        date_default_timezone_set('Asia/Jakarta');
        $da['bm'] = DB::table('tb_barang_keluar as a')->select("*")->where("a.tanggal_order", "=", date('Y-m-d'))->orderBy('id', 'DESC')->get();
        $status = true;
        if (count($da['bm']) > 0) {
            foreach ($da['bm'] as $key => $value):
                $split = explode("P", $value->no_kwitansi);
                if (count($split) < 2 && $status) {
                    $var = substr($value->no_kwitansi, 9, 3);
                    $number = str_pad($var + 1, 3, '0', STR_PAD_LEFT);
                    $status = false;
                }
            endforeach;
        } else {
            $number = "001";
        }

        $d['no_kwitansi'] = 'GR-' . date('ymd') . $number;
        $d['tanggal_order'] = $data['tanggal_order'];
        $d['status_barang'] = $data['status_barang'];
        $d['ket_tmbhn'] = $data['ket_tmbhn'];
        $d['id_konsumen'] = $data['id_konsumen'];
        $d['id_gudang'] = $data['id_gudang'];
        $d['status_order'] = $data['status_order'];
        $d['pengembang'] = $data['pengembang'];
        $d['sales'] = $data['sales'];
        $d['leader'] = $data['leader'];
        $d['manager'] = $data['manager'];
        $d['kategori'] = $data['kategori'];
        $d['admin_p'] = Auth::user()->id;
        $d['total_bayar'] = $data['total_bayar'];

        $kondisi = DB::table('tb_barang_keluar as a')->select("*")
            ->where("a.status", "=", "aktif")
            ->where("a.id_konsumen", "=", $data['id_konsumen'])
            ->where("a.id_gudang", $data['id_gudang'])
            ->where("a.sales", $data['sales'])
            ->where("a.status_barang", "order")
            ->where("a.tanggal_order", $data['tanggal_order'])
            ->where("a.admin_p", Auth::user()->id)
            ->where("a.status_order", $data['status_order'])
            ->limit(1)
            ->get();

        if (count($kondisi) < 1) {
            $avai = DB::table('tb_barang_keluar as a')->select("*")
                ->where("a.no_kwitansi", "=", $d['no_kwitansi'])
                ->get();
            if (count($avai) < 1) {
                echo "success," . $d['no_kwitansi'];
                DB::table('tb_barang_keluar')->insert($d);
            } else {
                $number += 1;
                $d['no_kwitansi'] = 'GR-' . date('ymd') . $number;
                echo "success," . $d['no_kwitansi'];
                DB::table('tb_barang_keluar')->insert($d);
            }
        } else {
            //$x['status_barang'] = "order";
            //DB::table('tb_barang_keluar')->where('no_kwitansi','=',$kondisi[0]->no_kwitansi)->update($x);
            echo "exist," . $kondisi[0]->no_kwitansi;
        }
    }

    public function detailKwitansi($id)
    {
        $cek = DB::table('tb_barang_keluar as a')->select("*")->where("a.no_kwitansi", $id)->get();
        if ($cek[0]->status_order == "2" || $cek[0]->status_order == "3") {
            $da = DB::table('tb_barang_keluar as a')
                ->join('tb_karyawan as b', 'b.id', '=', 'a.id_konsumen')
                ->join('tb_gudang as e', 'e.id', '=', 'a.id_gudang')
                ->select("*", "b.nama as nama_pemilik")->where("a.no_kwitansi", $id)->get();
        } else {
            $da = DB::table('tb_barang_keluar as a')
                ->join('tb_konsumen as b', 'b.id', '=', 'a.id_konsumen')
                ->join('tb_gudang as e', 'e.id', '=', 'a.id_gudang')
                ->select("*")->where("a.no_kwitansi", $id)->get();
        }
        echo json_encode($da);
    }

    public function simpantransferstok(Request $post)
    {
        $data = $post->except('_token');
        $data['ket'] = "Transfer";
        $data['tanggal_transfer'] = date('Y-m-d');
        DB::table('tb_barang_keluar')->where('no_kwitansi', '=', $data['no_kwitansi'])->update($data);
        echo json_encode($data);
    }

    public function postdetailbarangkeluar(Request $post)
    {
        $data = $post->except('_token');
        $str = explode(",", $data['no_kwitansi']);
        $s['potongan'] = $data['potongan'];
        $s['no_kwitansi'] = $str[1];
        $s['id_barang'] = $data['id_barang'];
        $s['harga_net'] = $data['harga_net'] - $s['potongan'];
        $s['jumlah'] = $data['jumlah'];
        $s['harga_jual'] = $data['harga_jual'];
        $s['sub_total'] = $data['sub_total'];


        $cek_harga = DB::table('tb_harga as a')->select("*")->where("id_barang", $data['id_barang'])->get();
        $s['harga_hp'] = $cek_harga[0]->harga_hp - $data['potonganpromo'];
        $s['harga_hpp'] = $cek_harga[0]->harga_hpp - $data['potonganpromo'];
        $s['harga_agen'] = $cek_harga[0]->harga_agen;
        $s['harga_reseller'] = $cek_harga[0]->harga_reseller;

        $s['time'] = date("h:i");
        $available = DB::table('tb_detail_barang_keluar as a')->select("*")->where($s)->get();
        if (count($available) < 1) {
            DB::table('tb_detail_barang_keluar')->insert($s);
        }
    }

    public function daftarorderbaru()
    {
        if (role()) {

            $del =  date("Y-m-d", strtotime("-2 Months"));
            $cekdel = DB::table('tb_barang_keluar as a')->where('tanggal_order', '<', $del)->where('status_barang', 'order')->get();
            foreach ($cekdel as $key => $value) {
                DB::table('tb_barang_keluar')->where('no_kwitansi', $value->no_kwitansi)->delete();
                DB::table('tb_detail_barang_keluar')->where('no_kwitansi', $value->no_kwitansi)->delete();
            }

            $data['tf'] = $this->model->getGudang();
            if (Auth::user()->level == "5") {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
                $data['order'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_konsumen as b', 'b.id', '=', 'a.id_konsumen')
                    ->join('tb_karyawan as c', 'c.id', '=', 'a.sales')
                    ->join('users as d', 'd.id', '=', 'a.admin_p')
                    ->join('tb_gudang as e', 'e.id', '=', 'a.id_gudang')
                    ->join('tb_status_order as f', 'f.id', '=', 'a.status_order')
                    ->select(
                        "a.id",
                        "a.id_gudang",
                        "a.no_kwitansi",
                        "a.tanggal_order",
                        "b.nama_pemilik",
                        "b.alamat",
                        "b.kota",
                        "c.nama as sales",
                        "d.username as admin_p",
                        "a.admin_p as id_admin_p",
                        "e.nama_gudang",
                        "f.nama_status",
                        "a.status_barang",
                        "a.ket",
                        "a.keterangan",
                        "a.ket_tmbhn"
                    )
                    ->where("a.status", "=", "aktif")->where("a.status_barang", "=", "order")->where("a.id_gudang", "=", Auth::user()->gudang)->orWhere("a.status_barang", "=", "kirim ulang")->where("a.id_gudang", "=", Auth::user()->gudang)->orderBy("a.tanggal_order", "ASC")->get();
                $data['lain'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_karyawan as b', 'b.id', '=', 'a.id_konsumen')
                    ->join('tb_karyawan as c', 'c.id', '=', 'a.sales')
                    ->join('users as d', 'd.id', '=', 'a.admin_p')
                    ->join('tb_gudang as e', 'e.id', '=', 'a.id_gudang')
                    ->join('tb_status_order as f', 'f.id', '=', 'a.status_order')
                    ->select(
                        "a.id",
                        "a.id_gudang",
                        "a.no_kwitansi",
                        "a.tanggal_order",
                        "b.nama",
                        "b.alamat",
                        "c.nama as sales",
                        "d.username as admin_p",
                        "a.admin_p as id_admin_p",
                        "e.nama_gudang",
                        "f.nama_status",
                        "a.status_barang",
                        "a.ket",
                        "a.keterangan",
                        "a.ket_tmbhn"
                    )
                    ->where("a.status", "=", "aktif")->where("a.status_barang", "=", "order")->where("a.id_gudang", "=", Auth::user()->gudang)->orWhere("a.status_barang", "=", "kirim ulang")->where("a.id_gudang", "=", Auth::user()->gudang)->orderBy("a.tanggal_order", "ASC")->get();
            } else if ((Auth::user()->gudang == "1")) {
                $data['gudang'] = $this->model->getGudang();
                $data['order'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_konsumen as b', 'b.id', '=', 'a.id_konsumen')
                    ->join('tb_karyawan as c', 'c.id', '=', 'a.sales')
                    ->join('users as d', 'd.id', '=', 'a.admin_p')
                    ->join('tb_gudang as e', 'e.id', '=', 'a.id_gudang')
                    ->join('tb_status_order as f', 'f.id', '=', 'a.status_order')
                    ->select(
                        "a.id",
                        "a.id_gudang",
                        "a.no_kwitansi",
                        "a.tanggal_order",
                        "b.nama_pemilik",
                        "b.alamat",
                        "b.kota",
                        "c.nama as sales",
                        "d.username as admin_p",
                        "a.admin_p as id_admin_p",
                        "e.nama_gudang",
                        "f.nama_status",
                        "a.status_barang",
                        "a.ket",
                        "a.keterangan",
                        "a.ket_tmbhn"
                    )
                    ->where("a.status", "=", "aktif")->where("a.status_barang", "=", "order")->orWhere("a.status_barang", "=", "kirim ulang")->orderBy("a.tanggal_order", "ASC")->get();
                $data['lain'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_karyawan as b', 'b.id', '=', 'a.id_konsumen')
                    ->join('tb_karyawan as c', 'c.id', '=', 'a.sales')
                    ->join('users as d', 'd.id', '=', 'a.admin_p')
                    ->join('tb_gudang as e', 'e.id', '=', 'a.id_gudang')
                    ->join('tb_status_order as f', 'f.id', '=', 'a.status_order')
                    ->select(
                        "a.id",
                        "a.id_gudang",
                        "a.no_kwitansi",
                        "a.tanggal_order",
                        "b.nama",
                        "b.alamat",
                        "c.nama as sales",
                        "d.username as admin_p",
                        "a.admin_p as id_admin_p",
                        "e.nama_gudang",
                        "f.nama_status",
                        "a.status_barang",
                        "a.ket",
                        "a.keterangan",
                        "a.ket_tmbhn"
                    )
                    ->where("a.status", "=", "aktif")->where("a.status_barang", "=", "order")->orWhere("a.status_barang", "=", "kirim ulang")->orderBy("a.tanggal_order", "ASC")->get();
            } else {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
                $data['order'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_konsumen as b', 'b.id', '=', 'a.id_konsumen')
                    ->join('tb_karyawan as c', 'c.id', '=', 'a.sales')
                    ->join('users as d', 'd.id', '=', 'a.admin_p')
                    ->join('tb_gudang as e', 'e.id', '=', 'a.id_gudang')
                    ->join('tb_status_order as f', 'f.id', '=', 'a.status_order')
                    ->select(
                        "a.id",
                        "a.id_gudang",
                        "a.no_kwitansi",
                        "a.tanggal_order",
                        "b.nama_pemilik",
                        "b.alamat",
                        "b.kota",
                        "c.nama as sales",
                        "d.username as admin_p",
                        "a.admin_p as id_admin_p",
                        "e.nama_gudang",
                        "f.nama_status",
                        "a.status_barang",
                        "a.ket",
                        "a.keterangan",
                        "a.ket_tmbhn"
                    )
                    ->where("a.status", "=", "aktif")->where("a.status_barang", "=", "order")->where("a.id_gudang", "=", Auth::user()->gudang)->orWhere("a.status_barang", "=", "kirim ulang")->where("a.id_gudang", "=", Auth::user()->gudang)->orderBy("a.tanggal_order", "ASC")->get();
                $data['lain'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_karyawan as b', 'b.id', '=', 'a.id_konsumen')
                    ->join('tb_karyawan as c', 'c.id', '=', 'a.sales')
                    ->join('users as d', 'd.id', '=', 'a.admin_p')
                    ->join('tb_gudang as e', 'e.id', '=', 'a.id_gudang')
                    ->join('tb_status_order as f', 'f.id', '=', 'a.status_order')
                    ->select(
                        "a.id",
                        "a.id_gudang",
                        "a.no_kwitansi",
                        "a.tanggal_order",
                        "b.nama",
                        "b.alamat",
                        "c.nama as sales",
                        "d.username as admin_p",
                        "a.admin_p as id_admin_p",
                        "e.nama_gudang",
                        "f.nama_status",
                        "a.status_barang",
                        "a.ket",
                        "a.keterangan",
                        "a.ket_tmbhn"
                    )
                    ->where("a.status", "=", "aktif")->where("a.status_barang", "=", "order")->where("a.id_gudang", "=", Auth::user()->gudang)->orWhere("a.status_barang", "=", "kirim ulang")->where("a.id_gudang", "=", Auth::user()->gudang)->orderBy("a.tanggal_order", "ASC")->get();
            }

            $data['status_order'] = DB::table('tb_status_order as a')->select("a.*")->where("a.status", "=", "aktif")->get();
            $data['sales'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
            $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();

            $provinsi =  DB::table('provinces')->get();
            $kabupaten =  DB::table('regencies')->get();
            $kecamatan =  DB::table('districts')->get();

            foreach ($provinsi as $key => $value) {
                $data['data_provinsi'][$value->id] = $value->name;
            }
            foreach ($kabupaten as $key => $value) {
                $data['data_kabupaten'][$value->id] = $value->name;
            }
            foreach ($kecamatan as $key => $value) {
                $data['data_kecamatan'][$value->id] = $value->name;
            }

            return view('DaftarOrderBaru', $data);
        } else {
            return view('Denied');
        }
    }
    public function daftarorderbarus(Request $post)
    {
        if (role()) {
            $data['tf'] = $this->model->getGudang();
            $d = $post->except('_token');

            //$data['nmbarang'] = DB::table('tb_barang as a')->select("a.*")->get();

            //if($d['nama_barang']) { $data['nama_barang'] = $d['nama_barang']; }
            //if($d['id_barang'] != ""){ $u['z.id_barang']=$d['id_barang']; $data['id_barang'] = $u['z.id_barang']; }
            if ($d['from'] != null && $d['to'] != null) {
                $from = $d['from'];
                $to = $d['to'];
                $data['from'] = $d['from'];
                $data['to'] = $d['to'];
            }
            if ($d['status_order'] != null) {
                $u['a.status_order'] = $d['status_order'];
                $data['v_status_order'] = $d['status_order'];
            }
            if ($d['sales'] != null) {
                $u['a.sales'] = $d['sales'];
                $data['v_sales'] = $d['sales'];
            }
            if ($d['pengembang'] != null) {
                $u['a.pengembang'] = $d['pengembang'];
                $data['v_pengembang'] = $d['pengembang'];
            }
            if ($d['id_gudang'] != null) {
                $u['a.id_gudang'] = $d['id_gudang'];
                $data['id_gudang'] = $d['id_gudang'];
            }
            if ($d['kota'] != null) {
                $u['b.kota'] = $d['kota'];
                $data['kota'] = $d['kota'];
            }

            //dd($u);
            if (isset($d['status_order']) && ($d['status_order'] == "2" || $d['status_order'] == "3")) {
                $data['lain'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_karyawan as b', 'b.id', '=', 'a.id_konsumen')
                    ->join('tb_karyawan as c', 'c.id', '=', 'a.sales')
                    ->join('users as d', 'd.id', '=', 'a.admin_p')
                    ->join('tb_gudang as e', 'e.id', '=', 'a.id_gudang')
                    ->join('tb_status_order as f', 'f.id', '=', 'a.status_order')
                    ->select(
                        "a.id",
                        "a.id_gudang",
                        "a.no_kwitansi",
                        "a.tanggal_order",
                        "b.nama",
                        "b.alamat",
                        "c.nama as sales",
                        "d.username as admin_p",
                        "a.admin_p as id_admin_p",
                        "e.nama_gudang",
                        "f.nama_status",
                        "a.status_barang",
                        "a.ket",
                        "a.ket_tmbhn"
                    )
                    ->where("a.status", "=", "aktif")->where("a.status_order", $d['status_order'])->where("a.status_barang", "=", "order")
                    ->orWhere("a.status_barang", "=", "kirim ulang")->where("a.status", "=", "aktif")->where("a.status_order", $d['status_order'])
                    ->orderBy("a.tanggal_order", "ASC")->get();
            }
            if (isset($from)) {
                $data['order'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_konsumen as b', 'b.id', '=', 'a.id_konsumen')
                    ->join('tb_karyawan as c', 'c.id', '=', 'a.sales')
                    ->join('users as d', 'd.id', '=', 'a.admin_p')
                    ->join('tb_gudang as e', 'e.id', '=', 'a.id_gudang')
                    ->join('tb_status_order as f', 'f.id', '=', 'a.status_order')
                    ->select(
                        "a.id",
                        "a.id_gudang",
                        "a.no_kwitansi",
                        "a.tanggal_order",
                        "b.nama_pemilik",
                        "b.alamat",
                        "b.kota",
                        "c.nama as sales",
                        "d.username as admin_p",
                        "a.admin_p as id_admin_p",
                        "e.nama_gudang",
                        "f.nama_status",
                        "a.status_barang",
                        "a.ket",
                        "a.ket_tmbhn"
                    )
                    ->where($u)->whereBetween('tanggal_order', [$from, $to])->where("a.status", "=", "aktif")->where("a.status_barang", "=", "order")
                    ->orWhere("a.status_barang", "=", "kirim ulang")->where($u)->whereBetween('tanggal_order', [$from, $to])->where("a.status", "=", "aktif")
                    ->orderBy("a.tanggal_order", "ASC")->get();
            } else {
                $data['order'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_konsumen as b', 'b.id', '=', 'a.id_konsumen')
                    ->join('tb_karyawan as c', 'c.id', '=', 'a.sales')
                    ->join('users as d', 'd.id', '=', 'a.admin_p')
                    ->join('tb_gudang as e', 'e.id', '=', 'a.id_gudang')
                    ->join('tb_status_order as f', 'f.id', '=', 'a.status_order')
                    ->select(
                        "a.id",
                        "a.id_gudang",
                        "a.no_kwitansi",
                        "a.tanggal_order",
                        "b.nama_pemilik",
                        "b.alamat",
                        "b.kota",
                        "c.nama as sales",
                        "d.username as admin_p",
                        "a.admin_p as id_admin_p",
                        "e.nama_gudang",
                        "f.nama_status",
                        "a.status_barang",
                        "a.ket",
                        "a.ket_tmbhn"
                    )
                    ->where($u)->where("a.status", "=", "aktif")->where("a.status_barang", "=", "order")
                    ->orWhere("a.status_barang", "=", "kirim ulang")->where($u)->where("a.status", "=", "aktif")
                    ->orderBy("a.tanggal_order", "ASC")->get();
            }
            if (Auth::user()->level == "5") {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
            } else if (Auth::user()->gudang == "1") {
                $data['gudang'] = $this->model->getGudang();
            } else {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
            }
            $data['status_order'] = DB::table('tb_status_order as a')->select("a.*")->where("a.status", "=", "aktif")->get();
            $data['sales'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->get();
            $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->get();
            foreach ($data['pengembang'] as $value) {
                $data['karyawan'][$value->id] = $value->nama;
            }

            $provinsi =  DB::table('provinces')->get();
            $kabupaten =  DB::table('regencies')->get();
            $kecamatan =  DB::table('districts')->get();

            foreach ($provinsi as $key => $value) {
                $data['data_provinsi'][$value->id] = $value->name;
            }
            foreach ($kabupaten as $key => $value) {
                $data['data_kabupaten'][$value->id] = $value->name;
            }
            foreach ($kecamatan as $key => $value) {
                $data['data_kecamatan'][$value->id] = $value->name;
            }

            //dd($data);
            return view('DaftarOrderBaru', $data);
        } else {
            return view('Denied');
        }
    }

    public function deleteOrderBaru($id)
    {
        DB::table('tb_barang_keluar')->where('no_kwitansi', '=', $id)->delete();
        DB::table('tb_detail_barang_keluar')->where('no_kwitansi', '=', $id)->delete();
        DB::table('kt_rekap_pembayaran')->where('no_kwitansi', '=', $id)->delete();
        DB::table('kt_rekap_os')->where('no_kwitansi', '=', $id)->delete();
        return redirect()->back()->with('success', 'Berhasil');
    }

    public function detailBarangKeluar($id)
    {
        $data = $this->model->detailBarangKeluarby($id);

        $d = array();
        $warna = DB::table('kt_color')->get();
        foreach ($warna as $key => $value) {
            $d[$value->hex] = $value->warna;
        }

        foreach ($data as $key => $value) {
            if ($value->warna_pilihan !== null && $value->warna_pilihan !== "") {
                $data[$key]->warna = $d[$value->warna_pilihan];
            } else {
                $data[$key]->warna = "";
            }
        }
        echo json_encode($data);
    }

    public function detailBK($id)
    {
        $data = DB::table('tb_detail_barang_keluar')->where('id', '=', $id)->get();
        echo json_encode($data);
    }

    public function deleteitempenjualan($id)
    {
        $get = DB::table('tb_detail_barang_keluar')->where('id', '=', $id)->get();
        DB::table('tb_detail_barang_keluar')->where('id', '=', $id)->delete();
        DB::table('kt_rekap_pembayaran')->where('no_kwitansi', '=', $id)->delete();
        DB::table('kt_rekap_os')->where('no_kwitansi', '=', $id)->delete();

        if (count($get) > 0) {
            $cek = DB::table('tb_detail_barang_keluar')->where('no_kwitansi', $get[0]->no_kwitansi)->get();
            if (count($cek) < 1) {
                DB::table('tb_barang_keluar')->where('no_kwitansi', $get[0]->no_kwitansi)->delete();
                DB::table('kt_rekap_pembayaran')->where('no_kwitansi', $get[0]->no_kwitansi)->delete();
                DB::table('kt_rekap_os')->where('no_kwitansi', $get[0]->no_kwitansi)->delete();
            }
        }

        return redirect()->back()->with('success', 'Berhasil');
    }

    public function detailBarangTerkirim($id)
    {
        $data = $this->model->detailBarangKeluarby($id);
        echo json_encode($data);
    }

    public function detailBarangTerkirim2($id)
    {
        $data = DB::table('tb_barang_keluar as a')
            ->join('tb_detail_barang_keluar as b', 'b.no_kwitansi', '=', 'a.no_kwitansi')
            ->join('tb_barang as c', 'c.id', '=', 'b.id_barang')
            ->select("a.id", "a.no_kwitansi", "c.no_sku", "c.nama_barang", "c.part_number", "b.jumlah", "b.terkirim", "b.sub_total", "b.id as id_link")
            ->where("a.no_kwitansi", "=", $id)
            ->get();
        $pembayaran = DB::table('tb_detail_pembayaran')->where("no_kwitansi", "=", $id)->get();
        $total = 0;
        foreach ($pembayaran as $v) {
            $total += $v->pembayaran;
        }
        foreach ($data as $k => $val) {
            $data[$k]->total_sudah_bayar = $total;
        }
        echo json_encode($data);
    }

    public function detailBarangTerkirim3($id)
    {
        $data = DB::table('tb_barang_keluar as a')
            ->join('tb_detail_barang_keluar as b', 'b.no_kwitansi', '=', 'a.no_kwitansi')
            ->join('tb_barang as c', 'c.id', '=', 'b.id_barang')
            ->select("a.id", "a.no_kwitansi", "c.no_sku", "c.nama_barang", "c.part_number", "b.jumlah", "b.terkirim", "b.sub_total", "b.id as id_link")
            ->where("a.no_kwitansi", "=", $id)
            ->get();
        $pembayaran = DB::table('tb_detail_pembayaran')->where("no_kwitansi", "=", $id)->get();
        $total = 0;
        foreach ($pembayaran as $v) {
            $total += $v->pembayaran;
        }
        foreach ($data as $k => $val) {
            $data[$k]->total_sudah_bayar = $total;
        }
        echo json_encode($data);
    }


    public function dataorderpenjualan()
    {
        if (role()) {
            if (Auth::user()->level == "5") {
                $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik", "=", Auth::user()->nik)->get();
                $data['data'] = array();
                /*$data['data'] = DB::table('tb_detail_barang_keluar as z')
                            ->join('tb_barang_keluar as a','a.no_kwitansi','=','z.no_kwitansi')
                            //->join('tb_barang as j','j.id',"=",'z.id_barang')
                            //->join('tb_konsumen as b','b.id','=','a.id_konsumen')
                            ->select("*")
                            ->where("a.status_barang","=","terkirim")->where("a.pengembang",$p[0]->id)
                            ->where("z.proses","<>","0")->whereMonth("a.tanggal_proses",Date('m'))
                            ->orWhere("a.status_barang","=","proses")->where("a.pengembang",$p[0]->id)
                            ->where("z.proses","<>","0")->whereMonth("a.tanggal_proses",Date('m'))
                            ->orWhere("a.status_barang","=","kirim ulang")->where("a.pengembang",$p[0]->id)
                            ->where("z.proses","<>","0")->whereMonth("a.tanggal_proses",Date('m'))
                            ->get();*/
            } else if (Auth::user()->gudang == "1" || Auth::user()->gudang == "2") {
                $data['data'] = array();
                /*$data['data'] = DB::table('tb_detail_barang_keluar as z')
                            ->join('tb_barang_keluar as a','a.no_kwitansi','=','z.no_kwitansi')
                            //->join('tb_barang as j','j.id',"=",'z.id_barang')
                            ->select("*")
                            ->where("a.status_barang","=","terkirim")->where("z.proses","<>","0")->whereMonth("a.tanggal_proses",Date('m'))
                            ->orWhere("a.status_barang","=","proses")->where("z.proses","<>","0")->whereMonth("a.tanggal_proses",Date('m'))
                            ->orWhere("a.status_barang","=","kirim ulang")->where("z.proses","<>","0")->whereMonth("a.tanggal_proses",Date('m'))
                            ->orderBy("a.id","DESC")
                            //->toSql();
                            //->limit(15)
                            ->get();
                            //->paginate(15);
                            //dd($data);*/
            } else {
                $data['data'] = array();
                /*$data['data'] = DB::table('tb_detail_barang_keluar as z')
                            ->join('tb_barang_keluar as a','a.no_kwitansi','=','z.no_kwitansi')
                            //->join('tb_barang as j','j.id',"=",'z.id_barang')
                            //->join('tb_konsumen as b','b.id','=','a.id_konsumen')
                            ->select("*")
                            ->where("a.status_barang","=","terkirim")->where("a.id_gudang",Auth::user()->gudang)->where("z.proses","<>","0")->whereMonth("a.tanggal_proses",Date('m'))
                            ->orWhere("a.status_barang","=","proses")->where("a.id_gudang",Auth::user()->gudang)->where("z.proses","<>","0")->whereMonth("a.tanggal_proses",Date('m'))
                            ->orWhere("a.status_barang","=","kirim ulang")->where("a.id_gudang",Auth::user()->gudang)->where("z.proses","<>","0")->whereMonth("a.tanggal_proses",Date('m'))
                            ->get();*/
            }
            if ((Auth::user()->gudang == "1" || Auth::user()->gudang == "2") && Auth::user()->level != "5") {
                $data['gudang'] = $this->model->getGudang();
            } else {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
            }
            $data['status_order'] = DB::table('tb_status_order as a')->select("a.*")->where("a.status", "=", "aktif")->get();
            $data['sales'] = DB::table('tb_karyawan as a')->select("*")->get();
            $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->get();
            $data['user'] = DB::table('users as a')->select("*")->get();
            if (Auth::user()->level == "5") {
                $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik", "=", Auth::user()->nik)->get();
                $kons = DB::table('tb_konsumen as a')->select("*")->where("a.pengembang", $p[0]->id)->get();
            } else if ((Auth::user()->level == "3" && (Auth::user()->gudang == "1")) || Auth::user()->level == "1" || Auth::user()->level == "4") {
                $kons = DB::table('tb_konsumen as a')->select("*")->get();
            } else {
                $kons = DB::table('tb_konsumen as a')->select("*")->where("a.kategori", Auth::user()->gudang)->get();
            }
            $text_gudang = DB::table('tb_gudang as a')->select("a.*")->get();
            $text_kategori = DB::table('tb_kategori as a')->select("a.*")->get();
            $text_harga = DB::table('tb_harga as a')->select("a.*")->get();
            $text_status_order = DB::table('tb_status_order as a')->select("a.*")->get();

            $text_barang = DB::table('tb_barang as a')->select("a.*")->get();
            $data['barang'] = array();
            foreach ($text_barang as $value) {
                $data['barang'][$value->id]['no_sku'] = $value->no_sku;
                $data['barang'][$value->id]['nama_barang'] = $value->nama_barang;
                $data['barang'][$value->id]['part_number'] = $value->part_number;
            }

            $data['karyawan'] = array();
            $data['admin'] = array();
            $data['konsumen'] = array();

            foreach ($data['sales'] as $value) {
                $data['karyawan'][$value->id]['nama'] = $value->nama;
                $data['karyawan'][$value->id]['alamat'] = $value->alamat;
            }
            foreach ($data['user'] as $value) {
                $data['admin'][$value->id] = $value->name;
            }
            foreach ($kons as $value) {
                $data['konsumen'][$value->id]['id_konsumen'] = $value->id;
                $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
                $data['konsumen'][$value->id]['alamat'] = $value->alamat;
                $data['konsumen'][$value->id]['no_hp'] = $value->no_hp;
            }
            foreach ($text_gudang as $value) {
                $data['text_gudang'][$value->id] = $value->nama_gudang;
            }
            foreach ($text_harga as $value) {
                $data['text_harga'][$value->id_barang]['harga'] = $value->harga;
                $data['text_harga'][$value->id_barang]['harga_hpp'] = $value->harga_hpp;
                $data['text_harga'][$value->id_barang]['harga_hp'] = $value->harga_hp;
            }
            foreach ($text_status_order as $value) {
                $data['text_status_order'][$value->id] = $value->nama_status;
            }
            $data['nama_download'] = "Data Order Penjualan";

            $bulan = array("Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            $data['bulan'] = array();
            for ($i = 5; $i < date('m'); $i++) {
                $data['bulan'][$i] = $bulan[$i];
            }
            $data['tab'] = date('m');
            //dd($data);
            return view('DataOrderPenjualan', $data);
        } else {
            return view('Denied');
        }
    }

    public function caridatapenjualan(Request $post)
    {
        $d = $post->except('_token');
        if (Auth::user()->level == '1' || Auth::user()->level == '4') {
            $data['data'] = DB::table('tb_detail_barang_keluar as z')
                ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                ->select("*")
                ->where('z.no_kwitansi', $d['no_kwitansi'])
                ->where("z.proses", "<>", "0")
                ->get();
        } else {
            $data['data'] = DB::table('tb_detail_barang_keluar as z')
                ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                ->select("*")
                ->where('z.no_kwitansi', $d['no_kwitansi'])
                ->where("z.proses", "<>", "0")
                ->where("a.id_gudang", Auth::user()->gudang)
                ->get();
        }

        if ((Auth::user()->gudang == "1" || Auth::user()->gudang == "2") && Auth::user()->level != "5") {
            $data['gudang'] = $this->model->getGudang();
        } else {
            $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
        }
        $data['status_order'] = DB::table('tb_status_order as a')->select("a.*")->where("a.status", "=", "aktif")->get();
        $data['sales'] = DB::table('tb_karyawan as a')->select("*")->get();
        $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->get();
        $data['user'] = DB::table('users as a')->select("*")->get();
        if (Auth::user()->level == "5") {
            $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik", "=", Auth::user()->nik)->get();
            $kons = DB::table('tb_konsumen as a')->select("*")->where("a.pengembang", $p[0]->id)->get();
        } else {
            $kons = DB::table('tb_konsumen as a')->select("*")->get();
        }
        $text_gudang = DB::table('tb_gudang as a')->select("a.*")->get();
        $text_kategori = DB::table('tb_kategori as a')->select("a.*")->get();
        $text_harga = DB::table('tb_harga as a')->select("a.*")->get();
        $text_status_order = DB::table('tb_status_order as a')->select("a.*")->get();

        $data['karyawan'] = array();
        $data['admin'] = array();
        $data['konsumen'] = array();
        foreach ($data['sales'] as $value) {
            $data['karyawan'][$value->id]['nama'] = $value->nama;
            $data['karyawan'][$value->id]['alamat'] = $value->alamat;
        }
        foreach ($data['user'] as $value) {
            $data['admin'][$value->id] = $value->name;
        }
        foreach ($kons as $value) {
            $data['konsumen'][$value->id]['id_konsumen'] = $value->id;
            $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
            $data['konsumen'][$value->id]['alamat'] = $value->alamat;
            $data['konsumen'][$value->id]['kategori_konsumen'] = $value->kategori_konsumen;
        }
        foreach ($text_gudang as $value) {
            $data['text_gudang'][$value->id] = $value->nama_gudang;
        }
        foreach ($text_harga as $value) {
            $data['text_harga'][$value->id_barang]['harga'] = $value->harga;
            $data['text_harga'][$value->id_barang]['harga_hpp'] = $value->harga_hpp;
            $data['text_harga'][$value->id_barang]['harga_hp'] = $value->harga_hp;
        }
        foreach ($text_status_order as $value) {
            $data['text_status_order'][$value->id] = $value->nama_status;
        }
        $data['nama_download'] = "Data Order Penjualan";

        $text_barang = DB::table('tb_barang as a')->select("a.*")->get();
        $data['barang'] = array();
        foreach ($text_barang as $value) {
            $data['barang'][$value->id]['no_sku'] = $value->no_sku;
            $data['barang'][$value->id]['nama_barang'] = $value->nama_barang;
            $data['barang'][$value->id]['branded'] = $value->branded;
            $data['barang'][$value->id]['part_number'] = $value->part_number;
        }

        $bulan = array("Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $data['bulan'] = array();
        for ($i = 5; $i < date('m'); $i++) {
            $data['bulan'][$i] = $bulan[$i];
        }
        return view('DataOrderPenjualan', $data);
    }

    public function caridatapenjualanbyname(Request $post)
    {
        $d = $post->except('_token');

        $id = array();
        if ($d['nama_barang'] != null || $d['nama_barang'] != "") {
            $nm = $d['nama_barang'];
            $data['nama_barangs'] = $d['nama_barang'];
            $cs = DB::table('tb_barang')->where('nama_barang', 'like', "%$nm%")->get();
            foreach ($cs as $key => $value) {
                array_push($id, $value->id);
            }
        }

        if (isset($nm)) {
            if (Auth::user()->level == '1' || Auth::user()->level == '4') {
                $data['data'] = DB::table('tb_detail_barang_keluar as z')
                    ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                    ->select("*")
                    ->where("z.proses", "<>", "0")
                    ->whereIn('z.id_barang', $id)
                    ->get();
            } else {
                $data['data'] = DB::table('tb_detail_barang_keluar as z')
                    ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                    ->select("*")
                    ->where("z.proses", "<>", "0")
                    ->where("a.id_gudang", Auth::user()->gudang)
                    ->whereIn('z.id_barang', $id)
                    ->get();
            }
        } else {
            return redirect()->back();
        }



        if ((Auth::user()->gudang == "1" || Auth::user()->gudang == "2") && Auth::user()->level != "5") {
            $data['gudang'] = $this->model->getGudang();
        } else {
            $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
        }
        $data['status_order'] = DB::table('tb_status_order as a')->select("a.*")->where("a.status", "=", "aktif")->get();
        $data['sales'] = DB::table('tb_karyawan as a')->select("*")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
        $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
        $data['user'] = DB::table('users as a')->select("*")->get();
        if (Auth::user()->level == "5") {
            $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik", "=", Auth::user()->nik)->get();
            $kons = DB::table('tb_konsumen as a')->select("*")->where("a.pengembang", $p[0]->id)->get();
        } else {
            $kons = DB::table('tb_konsumen as a')->select("*")->get();
        }
        $text_gudang = DB::table('tb_gudang as a')->select("a.*")->get();
        $text_kategori = DB::table('tb_kategori as a')->select("a.*")->get();
        $text_harga = DB::table('tb_harga as a')->select("a.*")->get();
        $text_status_order = DB::table('tb_status_order as a')->select("a.*")->get();

        $data['karyawan'] = array();
        $data['admin'] = array();
        $data['konsumen'] = array();
        foreach ($data['sales'] as $value) {
            $data['karyawan'][$value->id]['nama'] = $value->nama;
            $data['karyawan'][$value->id]['alamat'] = $value->alamat;
        }
        foreach ($data['user'] as $value) {
            $data['admin'][$value->id] = $value->name;
        }
        foreach ($kons as $value) {
            $data['konsumen'][$value->id]['id_konsumen'] = $value->id;
            $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
            $data['konsumen'][$value->id]['alamat'] = $value->alamat;
            $data['konsumen'][$value->id]['kategori_konsumen'] = $value->kategori_konsumen;
        }
        foreach ($text_gudang as $value) {
            $data['text_gudang'][$value->id] = $value->nama_gudang;
        }
        foreach ($text_harga as $value) {
            $data['text_harga'][$value->id_barang]['harga'] = $value->harga;
            $data['text_harga'][$value->id_barang]['harga_hpp'] = $value->harga_hpp;
            $data['text_harga'][$value->id_barang]['harga_hp'] = $value->harga_hp;
        }
        foreach ($text_status_order as $value) {
            $data['text_status_order'][$value->id] = $value->nama_status;
        }
        $data['nama_download'] = "Data Order Penjualan";

        $text_barang = DB::table('tb_barang as a')->select("a.*")->get();
        $data['barang'] = array();
        foreach ($text_barang as $value) {
            $data['barang'][$value->id]['no_sku'] = $value->no_sku;
            $data['barang'][$value->id]['nama_barang'] = $value->nama_barang;
            $data['barang'][$value->id]['branded'] = $value->branded;
            $data['barang'][$value->id]['part_number'] = $value->part_number;
        }

        $bulan = array("Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $data['bulan'] = array();
        for ($i = 5; $i < date('m'); $i++) {
            $data['bulan'][$i] = $bulan[$i];
        }
        return view('DataOrderPenjualan', $data);
    }

    public function dataorderpenjualans(Request $post)
    {
        if (role()) {
            $d = $post->except('_token');

            $id = array();
            if ($d['nama_barang'] != null || $d['nama_barang'] != "") {
                $nm = $d['nama_barang'];
                $data['nama_barang'] = $d['nama_barang'];
                $cs = DB::table('tb_barang')->where('nama_barang', 'like', "%$nm%")->get();
                foreach ($cs as $key => $value) {
                    array_push($id, $value->id);
                }
            }

            if ($d['from'] != null && $d['to'] != null) {
                $from = $d['from'];
                $to = $d['to'];
                $data['from'] = $d['from'];
                $data['to'] = $d['to'];
            }
            if ($d['status_order'] != null) {
                $u['status_order'] = $d['status_order'];
                $data['v_status_order'] = $d['status_order'];
            }
            if ($d['id_gudang'] != null) {
                $u['id_gudang'] = $d['id_gudang'];
                $data['id_gudang'] = $d['id_gudang'];
            }
            if ($d['id_konsumen'] != null) {
                $u['id_konsumen'] = $d['id_konsumen'];
                $data['id_konsumen'] = $d['id_konsumen'];
                $data['name_konsumen'] = $d['name_konsumen'];
            }
            if ($d['status_barang'] != null) {
                $u['status_barang'] = $d['status_barang'];
                $data['status_barang'] = $d['status_barang'];
            }
            if ($d['branded'] != "") { /*$u['branded']=$d['branded'];*/
                $data['branded'] = $d['branded'];
            }
            if ($d['petugas'] != null && $d['id'] != null) {
                $u[$d['petugas']] = $d['id'];
                $data['petugas'] = $d['petugas'];
                $data['id'] = $d['id'];
            }

            if ($d['kategori_konsumen'] != null && $d['kategori_konsumen'] != "Semua") {
                $data['kategori_konsumen'] = $d['kategori_konsumen'];
            }

            if ($d['proses'] != null) {
                $range = date("Y-m-d", strtotime("-" . $d['proses'] . " day"));
                $data['proses'] = $d['proses'];
            }
            if (Auth::user()->level == "5") {
                $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik", "=", Auth::user()->nik)->get();
                $u['a.pengembang'] = $p[0]->id;
            }

            if (isset($nm)) {

                if (isset($from) && isset($u)) {
                    $data['data'] = DB::table('tb_detail_barang_keluar as z')
                        ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                        //->join('tb_barang as j','j.id',"=",'z.id_barang')
                        ->select("*")
                        ->whereBetween('tanggal_proses', [$from, $to])
                        ->where("z.proses", "<>", "0")
                        ->whereIn('z.id_barang', $id)
                        ->where($u)->get();
                } elseif (isset($range) && isset($u)) {
                    $data['data'] = DB::table('tb_detail_barang_keluar as z')
                        ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                        //->join('tb_barang as j','j.id',"=",'z.id_barang')
                        ->select("*")
                        ->where('tanggal_proses', '<', $range)
                        ->where("z.proses", "<>", "0")
                        ->whereIn('z.id_barang', $id)
                        ->where($u)->get();
                } elseif (isset($range)) {
                    $data['data'] = DB::table('tb_detail_barang_keluar as z')
                        ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                        //->join('tb_barang as j','j.id',"=",'z.id_barang')
                        ->select("*")
                        ->where("z.proses", "<>", "0")
                        ->whereIn('z.id_barang', $id)
                        ->where('tanggal_proses', '>', $range)->get();
                } elseif (isset($u)) {
                    $data['data'] = DB::table('tb_detail_barang_keluar as z')
                        ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                        //->join('tb_barang as j','j.id',"=",'z.id_barang')
                        ->select("*")
                        ->where("z.proses", "<>", "0")
                        ->whereIn('z.id_barang', $id)
                        ->where($u)->get();
                } elseif (isset($from)) {
                    $data['data'] = DB::table('tb_detail_barang_keluar as z')
                        ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                        //->join('tb_barang as j','j.id',"=",'z.id_barang')
                        ->select("*")
                        ->where("z.proses", "<>", "0")
                        ->whereIn('z.id_barang', $id)
                        ->whereBetween('tanggal_proses', [$from, $to])->get();
                }
            } else {

                if (isset($from) && isset($u)) {
                    $data['data'] = DB::table('tb_detail_barang_keluar as z')
                        ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                        //->join('tb_barang as j','j.id',"=",'z.id_barang')
                        ->select("*")
                        ->whereBetween('tanggal_proses', [$from, $to])
                        ->where("z.proses", "<>", "0")
                        ->where($u)->get();
                } elseif (isset($range) && isset($u)) {
                    $data['data'] = DB::table('tb_detail_barang_keluar as z')
                        ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                        //->join('tb_barang as j','j.id',"=",'z.id_barang')
                        ->select("*")
                        ->where('tanggal_proses', '<', $range)
                        ->where("z.proses", "<>", "0")
                        ->where($u)->get();
                } elseif (isset($range)) {
                    $data['data'] = DB::table('tb_detail_barang_keluar as z')
                        ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                        //->join('tb_barang as j','j.id',"=",'z.id_barang')
                        ->select("*")
                        ->where("z.proses", "<>", "0")
                        ->where('tanggal_proses', '>', $range)->get();
                } elseif (isset($u)) {
                    $data['data'] = DB::table('tb_detail_barang_keluar as z')
                        ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                        //->join('tb_barang as j','j.id',"=",'z.id_barang')
                        ->select("*")
                        ->where("z.proses", "<>", "0")
                        ->where($u)->get();
                } elseif (isset($from)) {
                    $data['data'] = DB::table('tb_detail_barang_keluar as z')
                        ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                        //->join('tb_barang as j','j.id',"=",'z.id_barang')
                        ->select("*")
                        ->where("z.proses", "<>", "0")
                        ->whereBetween('tanggal_proses', [$from, $to])->get();
                }
            }


            if ((Auth::user()->gudang == "1" || Auth::user()->gudang == "2") && Auth::user()->level != "5") {
                $data['gudang'] = $this->model->getGudang();
            } else {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
            }
            $data['status_order'] = DB::table('tb_status_order as a')->select("a.*")->where("a.status", "=", "aktif")->get();
            $data['sales'] = DB::table('tb_karyawan as a')->select("*")->get();
            $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->get();
            $data['user'] = DB::table('users as a')->select("*")->get();
            if (Auth::user()->level == "5") {
                $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik", "=", Auth::user()->nik)->get();
                $kons = DB::table('tb_konsumen as a')->select("*")->where("a.pengembang", $p[0]->id)->get();
            } else {
                $kons = DB::table('tb_konsumen as a')->select("*")->get();
            }
            $text_gudang = DB::table('tb_gudang as a')->select("a.*")->get();
            $text_kategori = DB::table('tb_kategori as a')->select("a.*")->get();
            $text_harga = DB::table('tb_harga as a')->select("a.*")->get();
            $text_status_order = DB::table('tb_status_order as a')->select("a.*")->get();

            $data['karyawan'] = array();
            $data['admin'] = array();
            $data['konsumen'] = array();
            foreach ($data['sales'] as $value) {
                $data['karyawan'][$value->id]['nama'] = $value->nama;
                $data['karyawan'][$value->id]['alamat'] = $value->alamat;
            }
            foreach ($data['user'] as $value) {
                $data['admin'][$value->id] = $value->username;
            }
            foreach ($kons as $value) {
                $data['konsumen'][$value->id]['id_konsumen'] = $value->id;
                $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
                $data['konsumen'][$value->id]['alamat'] = $value->alamat;
                $data['konsumen'][$value->id]['kategori_konsumen'] = $value->kategori_konsumen;
            }
            foreach ($text_gudang as $value) {
                $data['text_gudang'][$value->id] = $value->nama_gudang;
            }
            foreach ($text_harga as $value) {
                $data['text_harga'][$value->id_barang]['harga'] = $value->harga;
                $data['text_harga'][$value->id_barang]['harga_hpp'] = $value->harga_hpp;
                $data['text_harga'][$value->id_barang]['harga_hp'] = $value->harga_hp;
            }
            foreach ($text_status_order as $value) {
                $data['text_status_order'][$value->id] = $value->nama_status;
            }
            $data['nama_download'] = "Data Order Penjualan";

            $text_barang = DB::table('tb_barang as a')->select("a.*")->get();
            $data['barang'] = array();
            foreach ($text_barang as $value) {
                $data['barang'][$value->id]['no_sku'] = $value->no_sku;
                $data['barang'][$value->id]['nama_barang'] = $value->nama_barang;
                $data['barang'][$value->id]['branded'] = $value->branded;
                $data['barang'][$value->id]['part_number'] = $value->part_number;
            }

            $bulan = array("Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            $data['bulan'] = array();
            for ($i = 5; $i < date('m'); $i++) {
                $data['bulan'][$i] = $bulan[$i];
            }
            return view('DataOrderPenjualan', $data);
        } else {
            return view('Denied');
        }
    }

    public function dataorderpenjualanbulan($bulan)
    {
        $data['tab'] = $bulan;
        if (Auth::user()->level == "5") {
            $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik", "=", Auth::user()->nik)->get();
            $data['data'] = DB::table('tb_detail_barang_keluar as z')
                ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                //->join('tb_barang as j','j.id',"=",'z.id_barang')
                //->join('tb_konsumen as b','b.id','=','a.id_konsumen')
                ->select("*")
                ->where("a.status_barang", "=", "terkirim")->where("a.pengembang", $p[0]->id)
                ->where("z.proses", "<>", "0")->whereMonth("a.tanggal_proses", $bulan)
                ->orWhere("a.status_barang", "=", "proses")->where("a.pengembang", $p[0]->id)
                ->where("z.proses", "<>", "0")->whereMonth("a.tanggal_proses", $bulan)
                ->orWhere("a.status_barang", "=", "kirim ulang")->where("a.pengembang", $p[0]->id)
                ->where("z.proses", "<>", "0")->whereMonth("a.tanggal_proses", $bulan)
                ->get();
        } else if (Auth::user()->gudang == "1" || Auth::user()->gudang == "2") {
            $data['data'] = DB::table('tb_detail_barang_keluar as z')
                ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                //->join('tb_barang as j','j.id',"=",'z.id_barang')
                ->select("*")
                ->where("a.status_barang", "=", "terkirim")->where("z.proses", "<>", "0")->whereMonth("a.tanggal_proses", $bulan)
                ->orWhere("a.status_barang", "=", "proses")->where("z.proses", "<>", "0")->whereMonth("a.tanggal_proses", $bulan)
                ->orWhere("a.status_barang", "=", "kirim ulang")->where("z.proses", "<>", "0")->whereMonth("a.tanggal_proses", $bulan)
                ->orderBy("a.id", "DESC")
                //->limit(10)
                ->get();
        } else {
            $data['data'] = DB::table('tb_detail_barang_keluar as z')
                ->join('tb_barang_keluar as a', 'a.no_kwitansi', '=', 'z.no_kwitansi')
                //->join('tb_barang as j','j.id',"=",'z.id_barang')
                //->join('tb_konsumen as b','b.id','=','a.id_konsumen')
                ->select("*")
                ->where("a.status_barang", "=", "terkirim")->where("a.id_gudang", Auth::user()->gudang)->where("z.proses", "<>", "0")->whereMonth("a.tanggal_proses", $bulan)
                ->orWhere("a.status_barang", "=", "proses")->where("a.id_gudang", Auth::user()->gudang)->where("z.proses", "<>", "0")->whereMonth("a.tanggal_proses", $bulan)
                ->orWhere("a.status_barang", "=", "kirim ulang")->where("a.id_gudang", Auth::user()->gudang)->where("z.proses", "<>", "0")->whereMonth("a.tanggal_proses", $bulan)
                ->get();
        }
        if ((Auth::user()->gudang == "1" || Auth::user()->gudang == "2") && Auth::user()->level != "5") {
            $data['gudang'] = $this->model->getGudang();
        } else {
            $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
        }
        $data['status_order'] = DB::table('tb_status_order as a')->select("a.*")->where("a.status", "=", "aktif")->get();
        $data['sales'] = DB::table('tb_karyawan as a')->select("*")->get();
        $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->get();
        $data['user'] = DB::table('users as a')->select("*")->get();
        $kons = DB::table('tb_konsumen as a')->select("*")->get();
        $text_gudang = DB::table('tb_gudang as a')->select("a.*")->get();
        $text_kategori = DB::table('tb_kategori as a')->select("a.*")->get();
        $text_harga = DB::table('tb_harga as a')->select("a.*")->get();
        $text_status_order = DB::table('tb_status_order as a')->select("a.*")->get();

        $data['karyawan'] = array();
        $data['admin'] = array();
        $data['konsumen'] = array();
        foreach ($data['sales'] as $value) {
            $data['karyawan'][$value->id]['nama'] = $value->nama;
            $data['karyawan'][$value->id]['alamat'] = $value->alamat;
        }
        foreach ($data['user'] as $value) {
            $data['admin'][$value->id] = $value->name;
        }
        foreach ($kons as $value) {
            $data['konsumen'][$value->id]['id_konsumen'] = $value->id;
            $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
            $data['konsumen'][$value->id]['alamat'] = $value->alamat;
        }
        foreach ($text_gudang as $value) {
            $data['text_gudang'][$value->id] = $value->nama_gudang;
        }
        foreach ($text_harga as $value) {
            $data['text_harga'][$value->id_barang]['harga'] = $value->harga;
            $data['text_harga'][$value->id_barang]['harga_hpp'] = $value->harga_hpp;
            $data['text_harga'][$value->id_barang]['harga_hp'] = $value->harga_hp;
        }
        foreach ($text_status_order as $value) {
            $data['text_status_order'][$value->id] = $value->nama_status;
        }
        $data['nama_download'] = "Data Order Penjualan";

        $text_barang = DB::table('tb_barang as a')->select("a.*")->get();
        $data['barang'] = array();
        foreach ($text_barang as $value) {
            $data['barang'][$value->id]['no_sku'] = $value->no_sku;
            $data['barang'][$value->id]['nama_barang'] = $value->nama_barang;
            $data['barang'][$value->id]['part_number'] = $value->part_number;
        }

        $bulan = array("Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $data['bulan'] = array();
        for ($i = 5; $i < date('m'); $i++) {
            $data['bulan'][$i] = $bulan[$i];
        }
        return view('DataOrderPenjualan', $data);
    }

    public function dikirim()
    {
        if (role()) {
            if (Auth::user()->level == "1") {
                /*$data['transfer'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_konsumen as b','b.id','=','a.id_konsumen')
                            ->join('tb_gudang as c','c.id','=','a.id_gudang')
                            ->join('tb_karyawan as d','d.id','=','a.sales')
                            ->join('tb_karyawan as e','e.id','=','a.pengembang')
                            ->join('tb_karyawan as f','f.id','=','a.leader')
                            ->join('tb_karyawan as g','g.id','=','a.manager')
                            ->join('tb_kategori as i','i.id',"=",'b.kategori')
                            ->join('users as h','h.id','=','a.admin_p')
                            ->select("a.id","a.no_kwitansi","a.tanggal_order","b.id_konsumen","b.nama_pemilik","b.alamat","b.no_hp"
                                     ,"c.nama_gudang","d.nama as sales","e.nama as pengembang","f.nama as leader","g.nama as manager","h.name as admin_p","i.nama_kategori as kategori")
                            ->where("a.status_barang","=","order")->get();*/

                $data['transfer3'] = DB::table('tb_barang_keluar as a')
                    ->select("*")
                    ->where("a.status_barang", "=", "order")
                    ->get();

                $data['transfer2'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_karyawan as b', 'b.id', '=', 'a.id_konsumen')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.id_gudang')
                    ->join('tb_karyawan as d', 'd.id', '=', 'a.sales')
                    ->join('tb_karyawan as e', 'e.id', '=', 'a.pengembang')
                    ->join('tb_karyawan as f', 'f.id', '=', 'a.leader')
                    ->join('tb_karyawan as g', 'g.id', '=', 'a.manager')
                    ->join('users as h', 'h.id', '=', 'a.admin_p')
                    ->select(
                        "a.id",
                        "a.no_kwitansi",
                        "b.kategori",
                        "a.tanggal_order",
                        "b.id as id_konsumen",
                        "b.nama as nama_pemilik",
                        "b.alamat",
                        "b.no_hp",
                        "c.nama_gudang",
                        "d.nama as sales",
                        "e.nama as pengembang",
                        "f.nama as leader",
                        "g.nama as manager",
                        "h.username as admin_p",
                        "a.ket_tmbhn"
                    )
                    ->where("a.status_barang", "=", "order")
                    ->get();
            } else {
                /*$data['transfer'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_konsumen as b','b.id','=','a.id_konsumen')
                            ->join('tb_gudang as c','c.id','=','a.id_gudang')
                            ->join('tb_karyawan as d','d.id','=','a.sales')
                            ->join('tb_karyawan as e','e.id','=','a.pengembang')
                            ->join('tb_karyawan as f','f.id','=','a.leader')
                            ->join('tb_karyawan as g','g.id','=','a.manager')
                            ->join('tb_kategori as i','i.id',"=",'b.kategori')
                            ->join('users as h','h.id','=','a.admin_p')
                            ->select("a.id","a.no_kwitansi","a.tanggal_order","a.no_kwitansi","b.id_konsumen","b.nama_pemilik","b.alamat","b.no_hp"
                                     ,"c.nama_gudang","d.nama as sales","e.nama as pengembang","f.nama as leader","g.nama as manager","h.name as admin_p","i.nama_kategori as kategori")
                            ->where("a.status_barang","=","order")->where("a.id_gudang","=",Auth::user()->gudang)->get();*/
                $data['transfer3'] = DB::table('tb_barang_keluar as a')
                    ->select("*")
                    ->where("a.status_barang", "=", "order")
                    ->where("a.id_gudang", "=", Auth::user()->gudang)
                    ->get();
                $data['transfer2'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_karyawan as b', 'b.id', '=', 'a.id_konsumen')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.id_gudang')
                    ->join('tb_karyawan as d', 'd.id', '=', 'a.sales')
                    ->join('tb_karyawan as e', 'e.id', '=', 'a.pengembang')
                    ->join('tb_karyawan as f', 'f.id', '=', 'a.leader')
                    ->join('tb_karyawan as g', 'g.id', '=', 'a.manager')
                    ->join('users as h', 'h.id', '=', 'a.admin_p')
                    ->select(
                        "a.id",
                        "a.no_kwitansi",
                        "b.kategori",
                        "a.tanggal_order",
                        "b.id as id_konsumen",
                        "b.nama as nama_pemilik",
                        "b.alamat",
                        "b.no_hp",
                        "c.nama_gudang",
                        "d.nama as sales",
                        "e.nama as pengembang",
                        "f.nama as leader",
                        "g.nama as manager",
                        "h.username as admin_p",
                        "a.ket_tmbhn"
                    )
                    ->where("a.status_barang", "=", "order")->where("a.id_gudang", "=", Auth::user()->gudang)->get();
            }
            $data['barang'] = DB::table('tb_barang as a')->join('tb_harga as b', 'b.id_barang', '=', 'a.id')->select("a.*", "harga")->where("a.status", "=", "aktif")->get();
            $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
            $data['dropper'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
            $data['pengirim'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();

            $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
            $data['konsumen'] = array();
            foreach ($konsumen as $key => $value) {
                $data['konsumen'][$value->id]['nama_pemilik'] = $value->nama_pemilik;
                $data['konsumen'][$value->id]['nik'] = $value->nik;
                $data['konsumen'][$value->id]['alamat'] = $value->alamat;
                $data['konsumen'][$value->id]['no_hp'] = $value->no_hp;
                $data['konsumen'][$value->id]['id_konsumen'] = $value->id_konsumen;
                $data['konsumen'][$value->id]['kategori'] = $value->kategori;
                $data['konsumen'][$value->id]['kategori_konsumen'] = $value->kategori_konsumen;
                $data['konsumen'][$value->id]['limit_piutang'] = $value->limit_piutang;
            }

            $gudang = DB::table('tb_gudang as a')->select("*")->get();
            $data['gudang'] = array();
            foreach ($gudang as $key => $value) {
                $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
                $data['gudang'][$value->id]['alamat'] = $value->alamat;
            }

            $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
            $data['karyawan'] = array();
            foreach ($karyawan as $key => $value) {
                $data['karyawan'][$value->id]['nama'] = $value->nama;
                $data['karyawan'][$value->id]['nik'] = $value->nik;
                $data['karyawan'][$value->id]['alamat'] = $value->alamat;
                $data['karyawan'][$value->id]['id'] = $value->id;
            }

            $kategori = DB::table('tb_kategori as a')->select("*")->get();
            $data['kategori'] = array();
            foreach ($kategori as $key => $value) {
                $data['kategori'][$value->id]['nama_kategori'] = $value->nama_kategori;
            }

            $users = DB::table('users as a')->select("*")->get();
            $data['users'] = array();
            foreach ($users as $key => $value) {
                $data['users'][$value->id]['name'] = $value->username;
            }

            return view('Dikirim', $data);
        } else {
            return view('Denied');
        }
    }

    public function pilihstokbaru($gudang, $id)
    {
        $data = DB::table('tb_gudang_barang as a')
            ->select("*")
            ->where("a.id_gudang", "=", $gudang)
            ->where("a.id_barang", "=", $id)
            ->get();
        echo json_encode($data);
    }

    public function pilihbarangkeluar($id)
    {
        $cek =  substr($id, 0, 2);
        if ($cek == "GR" || $cek == "OL") {
            $data['barang'] = DB::table('tb_detail_barang_keluar as a')
                ->join('tb_barang as b', 'b.id', '=', 'a.id_barang')
                ->join('tb_barang_keluar as d', 'd.no_kwitansi', '=', 'a.no_kwitansi')
                /*->join('tb_gudang_barang as e',function($join){
                          $join->on("e.id_barang","=","a.id_barang")
                               ->on("e.id_gudang","=","d.id_gudang");
                      })*/
                ->select("b.*", "a.*", "d.*", "a.id as key")
                ->where("a.no_kwitansi", "=", $id)
                ->get();
            $u = 0;
            foreach ($data['barang'] as $v) {
                $x = DB::table('tb_gudang_barang as a')
                    ->select("a.jumlah as stokgudang")
                    ->where("a.id_barang", $v->id_barang)
                    ->where("a.id_gudang", $v->id_gudang)
                    ->get();

                $y = DB::table('tb_reject as a')
                    ->join('tb_detail_reject as b', 'b.no_reject', '=', 'a.no_reject')
                    ->where("b.id_barang", $v->id_barang)
                    ->where("a.id_gudang", $v->id_gudang)
                    ->select('*', DB::raw('SUM(b.jumlah) as jumlahreject'))
                    ->get();
                if (count($y) > 0) {
                    $data['barang'][$u]->stokgudang = $x[0]->stokgudang - $y[0]->jumlahreject;
                } else {
                    $data['barang'][$u]->stokgudang = $x[0]->stokgudang;
                }
                $u++;
            }
            //$sql = str_replace_array('?', $data['barang']->getBindings(), $data['barang']->toSql()); dd($sql);

            $data['bayar'] = DB::table('tb_pembayaran as a')
                ->join('tb_detail_pembayaran as d', 'd.no_kwitansi', '=', 'a.no_kwitansi')
                ->select(DB::raw('SUM(d.pembayaran) as telah_bayar'), "a.status_pembayaran")
                ->where("a.no_kwitansi", "=", $id)
                ->get();
            echo json_encode($data);
        } else {
            $data['barang'] = DB::table('tb_detail_order_jasa as a')
                ->join('tb_jasa as b', 'b.kode', '=', 'a.id_jasa')
                ->join('tb_order_jasa as d', 'd.no_kwitansi', '=', 'a.no_kwitansi')
                ->select("b.*", "a.*", "d.*", "a.id as key")
                ->where("a.no_kwitansi", "=", $id)
                ->get();

            $data['bayar'] = DB::table('tb_pembayaran as a')
                ->join('tb_detail_pembayaran as d', 'd.no_kwitansi', '=', 'a.no_kwitansi')
                ->select(DB::raw('SUM(d.pembayaran) as telah_bayar'), "a.status_pembayaran")
                ->where("a.no_kwitansi", "=", $id)
                ->get();
            echo json_encode($data);
        }
    }

    public function cekhutang($id)
    {
        $bk = DB::table('tb_barang_keluar')
            ->leftJoin('tb_detail_pembayaran', 'tb_detail_pembayaran.no_kwitansi', 'tb_barang_keluar.no_kwitansi')
            ->where('id_konsumen', $id)->where('status_barang', 'terkirim')
            ->select(DB::raw('SUM(tb_detail_pembayaran.pembayaran) as telah_bayar'), "tb_barang_keluar.total_bayar")
            ->groupBy('tb_barang_keluar.no_kwitansi')
            ->get();
        $limit = 0;
        foreach ($bk as $key => $value) {
            $limit += ($value->total_bayar - $value->telah_bayar);
        }
        echo $limit;
    }

    public function pilihbarangkeluarterkirim($id)
    {
        //dd($id);
        $data['barang'] = DB::table('tb_detail_barang_keluar as a')
            ->join('tb_barang as b', 'b.id', '=', 'a.id_barang')
            ->join('tb_barang_keluar as d', 'd.no_kwitansi', '=', 'a.no_kwitansi')
            /*->join('tb_gudang_barang as e',function($join){
                        $join->on("e.id_barang","=","a.id_barang")
                             ->on("e.id_gudang","=","d.id_gudang");
                    })*/
            ->select("b.*", "a.*", "d.*", "a.id as key")
            ->where("a.no_kwitansi", "=", $id)
            ->where("a.proses", "<>", 0)
            ->get();

        $u = 0;
        foreach ($data['barang'] as $v) {
            $x = DB::table('tb_gudang_barang as a')
                ->select("a.jumlah as stokgudang")
                ->where("a.id_barang", $v->id_barang)
                ->where("a.id_gudang", $v->id_gudang)
                ->get();
            $data['barang'][$u]->stokgudang = $x[0]->stokgudang;
            $u++;
        }

        $data['bayar'] = DB::table('tb_pembayaran as a')
            ->join('tb_detail_pembayaran as d', 'd.no_kwitansi', '=', 'a.no_kwitansi')
            ->select(DB::raw('SUM(d.pembayaran) as telah_bayar'), "a.status_pembayaran")
            ->where("a.no_kwitansi", "=", $id)
            ->get();
        echo json_encode($data);
    }

    public function updatebarangkeluar(Request $post)
    {
        $data = $post->except('_token');
        //$d['total_bayar'] = $data['total_bayar'];
        $d['no_kwitansi'] = $data['no_kwitansi'];
        $d['dropper'] = $data['dropper'];
        $d['qc'] = $data['qc'];
        $d['pengirim'] = $data['pengirim'];
        $d['helper'] = $data['helper'];
        $d['tanggal_proses'] = $data['tanggal_proses'];
        $d['admin_g'] = Auth::user()->id;
        $d['status_barang'] = "proses";
        $d['ongkos_kirim'] = $data['ongkos_kirim'];

        $d['total_bayar'] = $data['total_bayar'] + $data['ongkos_kirim'];

        $shan['status_pengiriman'] = "proses";
        DB::table('kt_rekap_pembayaran')->where('no_kwitansi', '=', $data['no_kwitansi'])->update($shan);

        DB::table('tb_barang_keluar')->where('no_kwitansi', '=', $d['no_kwitansi'])->update($d);
        //DB::table('tb_barang_keluar')->where('no_kwitansi','=',$d['no_kwitansi'])->increment('total_bayar',  $d['ongkos_kirim']); //cek ini

        $tempid_data = explode(",", $data['tempid_data']);
        $proses_data = explode(",", $data['proses_data']);
        $pending_data = explode(",", $data['pending_data']);

        for ($i = 0; $i < count($tempid_data) - 1; $i++) {
            $bck['id'] = $tempid_data[$i];
            $bck['proses'] = $proses_data[$i];
            $bck['pending'] = $pending_data[$i];
            $bck['terkirim'] = $proses_data[$i];
            DB::table('tb_detail_barang_keluar')->where('id', '=', $bck['id'])->update($bck);
        }

        $x = DB::table('tb_barang_keluar as a')
            ->join('tb_detail_barang_keluar as b', 'a.no_kwitansi', '=', 'b.no_kwitansi')
            ->select("*", "b.id as key")
            ->where('a.no_kwitansi', '=', $d['no_kwitansi'])->get();

        $kondisi = false;
        $a = array();
        foreach ($x as $value) {
            if ($value->proses != null || $value->proses != 0) {
                $trc = DB::table('tb_gudang_barang')->where('id_barang', '=', $value->id_barang)->where('id_gudang', '=', $value->id_gudang)->decrement('jumlah',  $value->proses); //update stok gudang

                //tracking data
                if ($trc) {
                    $tracking['jenis_transaksi'] = "updatebarangkeluar";
                    $tracking['nomor'] = $d['no_kwitansi'];
                    $tracking['gudang'] = $value->id_gudang;
                    $tracking['barang'] = $value->id_barang;
                    $tracking['jumlah'] = $value->proses;
                    $tracking['stok'] = "out";
                    DB::table('tracking')->insert($tracking);
                }
            }
            $pend = $value->jumlah - $value->proses;
            $u['sub_total'] = $value->proses * ($value->harga_jual - $value->potongan);
            DB::table('tb_detail_barang_keluar')->where('id', '=', $value->key)->update($u);
            if ($pend > 0) {
                $s['no_kwitansi'] = $value->no_kwitansi . "P";
                $s['id_barang'] = $value->id_barang;
                $s['harga_net'] = $value->harga_net;
                $s['jumlah'] = $pend;
                $s['harga_jual'] = $value->harga_jual;
                $s['potongan'] = $value->potongan;
                $s['sub_total'] = $s['jumlah'] * ($s['harga_jual'] - $s['potongan']);

                $kondisi = true;
                DB::table('tb_detail_barang_keluar')->insert($s);
                $a['no_kwitansi'] = $value->no_kwitansi . "P";
                $a['tanggal_order'] = $value->tanggal_order;
                $a['status_barang'] = "order";
                $a['id_konsumen'] = $value->id_konsumen;
                $a['id_gudang'] = $value->id_gudang;
                $a['status_order'] = $value->status_order;
                $a['pengembang'] = $value->pengembang;
                $a['sales'] = $value->sales;
                $a['leader'] = $value->leader;
                $a['manager'] = $value->manager;
                $a['kategori'] = $value->kategori;
                $a['admin_p'] = $value->admin_p;
                $a['total_bayar'] = $value->total_bayar; //cek
            }
        }

        //notifikasi
        $notif_get = DB::table('tb_barang_keluar as a')
            ->join('tb_konsumen as b', 'b.id', '=', 'a.id_konsumen')
            ->join('members as c', 'c.no_hp', '=', 'b.no_hp')
            ->select('c.*')
            ->where('no_kwitansi', '=', $data['no_kwitansi'])->get();
        if (count($notif_get) > 0) {
            $notif['id_member'] = $notif_get[0]->id;
            $notif['dilihat'] = 0;
            $notif['text'] = "Pesanan Anda dengan nomor invoice " . $data['no_kwitansi'] . " dalam proses pengiriman. Silahkan cek di laman <a href='order_proses'>Order Proses</a>";
            DB::table('kt_notifikasi')->insert($notif);
        }
        //endnotifikasi

        if ($kondisi) {
            DB::table('tb_barang_keluar')->insert($a);
        }
        echo json_encode($data);
    }

    public function updatedikirim($proses, $jumlah, $id)
    {
        $data['proses'] = $proses;
        $data['pending'] = $jumlah - $proses;
        if ($data['pending'] < 0) {
            $data['pending'] = 0;
        }
        DB::table('tb_detail_barang_keluar')->where('id', '=', $id)->update($data);
        $data['id'] = $id;
        echo json_encode($data);
    }

    public function updatedikirims($proses, $jumlah, $id, $hargajual, $id_barang)
    {
        $data['proses'] = $proses;
        $data['pending'] = $jumlah - $proses;
        if ($data['pending'] < 0) {
            $data['pending'] = 0;
        }
        $data['id_barang'] = $id_barang;
        $data['harga_jual'] = $hargajual;
        $data['sub_total'] = $hargajual * $proses;

        $change = DB::table('tb_detail_barang_keluar as a')
            ->select("*")
            ->where('a.id', '=', $id)->get();

        if ($change[0]->id_barang != $id_barang) {
            $cek = DB::table('tb_harga as a')
                ->select("*")
                ->where('a.id_barang', '=', $id_barang)->get();
            $data['harga_net'] = $cek[0]->harga;
        }
        DB::table('tb_detail_barang_keluar')->where('id', '=', $id)->update($data);

        $data['id'] = $id;
        $dt = DB::table('tb_detail_barang_keluar as a')
            ->join('tb_barang as b', 'a.id_barang', '=', 'b.id')
            ->select("*")
            ->where('a.id', '=', $id)->get();
        $data['no_sku'] = $dt[0]->no_sku;
        $data['nama_barang'] = $dt[0]->nama_barang;
        $data['part_number'] = $dt[0]->part_number;
        echo json_encode($data);
    }

    public function editbarangkeluardikirim($id, $gudang)
    {
        $data = DB::table('tb_detail_barang_keluar as a')
            ->join('tb_barang as b', 'a.id_barang', '=', 'b.id')
            ->join('tb_gudang_barang as c', 'a.id_barang', '=', 'c.id_barang')
            ->select("a.*", "b.*", "a.id as key", "c.jumlah as stok")
            ->where('a.id', '=', $id)->where('c.id_gudang', '=', $gudang)->get();
        echo json_encode($data);
    }

    public function getrejectdata($id_barang, $gudang)
    {
        $y = DB::table('tb_reject as a')
            ->join('tb_detail_reject as b', 'b.no_reject', '=', 'a.no_reject')
            ->where("b.id_barang", $id_barang)
            ->where("a.id_gudang", $gudang)
            ->select('*', DB::raw('SUM(b.jumlah) as jumlahreject'))
            ->get();
        echo json_encode($y);
    }

    public function terkirim()
    {
        if (role()) {
            if (Auth::user()->level == "1") {
                $data['transfer'] = DB::table('tb_barang_keluar as a')
                    ->select("*")
                    ->where("a.status_barang", "=", "proses")->where("a.id_gudang", Auth::user()->gudang)
                    ->orWhere("a.status_barang", "=", 'kirim ulang')->where("a.id_gudang", Auth::user()->gudang)
                    //->limit(3)
                    ->get();
                //dd($data);
                /*$data['transfer'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_konsumen as b','b.id','=','a.id_konsumen')
                            ->join('tb_gudang as c','c.id','=','a.id_gudang')
                            ->join('tb_karyawan as d','d.id','=','a.sales')
                            ->join('tb_karyawan as e','e.id','=','a.pengembang')
                            ->join('tb_karyawan as f','f.id','=','a.leader')
                            ->join('tb_karyawan as g','g.id','=','a.manager')
                            ->join('tb_kategori as i','i.id',"=",'b.kategori')
                            ->join('tb_karyawan as j','j.id',"=",'a.qc')
                            ->join('tb_karyawan as k','k.id',"=",'a.dropper')
                            ->join('tb_karyawan as l','l.id',"=",'a.pengirim')
                            ->leftJoin('tb_karyawan as s','s.id',"=",'a.helper')
                            ->join('users as h','h.id','=','a.admin_p')
                            ->join('users as m','m.id','=','a.admin_g')
                            ->select("a.id","a.no_kwitansi","a.tanggal_order","b.id_konsumen","b.nama_pemilik","b.alamat","b.no_hp"
                                     ,"c.nama_gudang","d.nama as sales","e.nama as pengembang","f.nama as leader","g.nama as manager"
                                     ,"j.nama as qc","a.dropper as id_dropper","k.nama as dropper","a.pengirim as id_pengirim","a.helper as id_helper","l.nama as pengirim","m.name as admin_g","a.tanggal_proses"
                                     ,"h.name as admin_p","i.nama_kategori as kategori","s.nama as helper","a.ongkos_kirim")
                            ->where("a.status_barang","=","proses")
                            ->orWhere("a.status_barang","=", 'kirim ulang')->get();*/

                $data['transfer2'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_karyawan as b', 'b.id', '=', 'a.id_konsumen')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.id_gudang')
                    ->join('tb_karyawan as d', 'd.id', '=', 'a.sales')
                    ->join('tb_karyawan as e', 'e.id', '=', 'a.pengembang')
                    ->join('tb_karyawan as f', 'f.id', '=', 'a.leader')
                    ->join('tb_karyawan as g', 'g.id', '=', 'a.manager')
                    ->join('tb_karyawan as j', 'j.id', "=", 'a.qc')
                    ->join('tb_karyawan as k', 'k.id', "=", 'a.dropper')
                    ->join('tb_karyawan as l', 'l.id', "=", 'a.pengirim')
                    ->leftJoin('tb_karyawan as s', 's.id', "=", 'a.helper')
                    ->join('users as h', 'h.id', '=', 'a.admin_p')
                    ->join('users as m', 'm.id', '=', 'a.admin_g')
                    ->select(
                        "a.id",
                        "a.no_kwitansi",
                        "a.tanggal_order",
                        "b.id as id_konsumen",
                        "b.nama as nama_pemilik",
                        "b.alamat",
                        "b.no_hp",
                        "c.nama_gudang",
                        "d.nama as sales",
                        "e.nama as pengembang",
                        "f.nama as leader",
                        "g.nama as manager",
                        "a.qc as id_qc",
                        "j.nama as qc",
                        "a.dropper as id_dropper",
                        "k.nama as dropper",
                        "a.pengirim as id_pengirim",
                        "a.helper as id_helper",
                        "l.nama as pengirim",
                        "m.username as admin_g",
                        "a.tanggal_proses",
                        "h.username as admin_p",
                        "b.kategori",
                        "s.nama as helper",
                        "a.ongkos_kirim"
                    )
                    ->where("a.status_barang", "=", "proses")->where("a.id_gudang", Auth::user()->gudang)
                    ->orWhere("a.status_barang", "=", 'kirim ulang')->where("a.id_gudang", Auth::user()->gudang)->get();
            } else {
                $data['transfer'] = DB::table('tb_barang_keluar as a')
                    ->select("*")
                    ->where("a.status_barang", "=", "proses")->where("a.id_gudang", Auth::user()->gudang)
                    ->orWhere("a.status_barang", "=", 'kirim ulang')->where("a.id_gudang", Auth::user()->gudang)->get();
                /*$data['transfer'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_konsumen as b','b.id','=','a.id_konsumen')
                            ->join('tb_gudang as c','c.id','=','a.id_gudang')
                            ->join('tb_karyawan as d','d.id','=','a.sales')
                            ->join('tb_karyawan as e','e.id','=','a.pengembang')
                            ->join('tb_karyawan as f','f.id','=','a.leader')
                            ->join('tb_karyawan as g','g.id','=','a.manager')
                            ->join('tb_kategori as i','i.id',"=",'b.kategori')
                            ->join('tb_karyawan as j','j.id',"=",'a.qc')
                            ->join('tb_karyawan as k','k.id',"=",'a.dropper')
                            ->join('tb_karyawan as l','l.id',"=",'a.pengirim')
                            ->leftJoin('tb_karyawan as s','s.id',"=",'a.helper')
                            ->join('users as h','h.id','=','a.admin_p')
                            ->join('users as m','m.id','=','a.admin_g')
                            ->select("a.id","a.no_kwitansi","a.tanggal_order","b.id_konsumen","b.nama_pemilik","b.alamat","b.no_hp"
                                     ,"c.nama_gudang","d.nama as sales","e.nama as pengembang","f.nama as leader","g.nama as manager"
                                     ,"j.nama as qc","a.dropper as id_dropper","k.nama as dropper","a.pengirim as id_pengirim","a.helper as id_helper","l.nama as pengirim","m.name as admin_g","a.tanggal_proses"
                                     ,"h.name as admin_p","i.nama_kategori as kategori","s.nama as helper","a.ongkos_kirim")
                            ->where("a.status_barang","=","proses")->where("a.id_gudang",Auth::user()->gudang)
                            ->orWhere("a.status_barang","=", 'kirim ulang')->where("a.id_gudang",Auth::user()->gudang)->get();*/
                $data['transfer2'] = DB::table('tb_barang_keluar as a')
                    ->join('tb_karyawan as b', 'b.id', '=', 'a.id_konsumen')
                    ->join('tb_gudang as c', 'c.id', '=', 'a.id_gudang')
                    ->join('tb_karyawan as d', 'd.id', '=', 'a.sales')
                    ->join('tb_karyawan as e', 'e.id', '=', 'a.pengembang')
                    ->join('tb_karyawan as f', 'f.id', '=', 'a.leader')
                    ->join('tb_karyawan as g', 'g.id', '=', 'a.manager')
                    ->join('tb_karyawan as j', 'j.id', "=", 'a.qc')
                    ->join('tb_karyawan as k', 'k.id', "=", 'a.dropper')
                    ->join('tb_karyawan as l', 'l.id', "=", 'a.pengirim')
                    ->leftJoin('tb_karyawan as s', 's.id', "=", 'a.helper')
                    ->join('users as h', 'h.id', '=', 'a.admin_p')
                    ->join('users as m', 'm.id', '=', 'a.admin_g')
                    ->select(
                        "a.id",
                        "a.no_kwitansi",
                        "a.tanggal_order",
                        "b.id as id_konsumen",
                        "b.nama as nama_pemilik",
                        "b.alamat",
                        "b.no_hp",
                        "c.nama_gudang",
                        "d.nama as sales",
                        "e.nama as pengembang",
                        "f.nama as leader",
                        "g.nama as manager",
                        "a.qc as id_qc",
                        "j.nama as qc",
                        "a.dropper as id_dropper",
                        "k.nama as dropper",
                        "a.pengirim as id_pengirim",
                        "a.helper as id_helper",
                        "l.nama as pengirim",
                        "m.username as admin_g",
                        "a.tanggal_proses",
                        "h.username as admin_p",
                        "b.kategori",
                        "s.nama as helper",
                        "a.ongkos_kirim"
                    )
                    ->where("a.status_barang", "=", "proses")->where("a.id_gudang", Auth::user()->gudang)
                    ->orWhere("a.status_barang", "=", 'kirim ulang')->where("a.id_gudang", Auth::user()->gudang)->get();
            }
            $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
            $data['dropper'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
            $data['pengirim'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();

            $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
            $data['konsumen'] = array();
            foreach ($konsumen as $key => $value) {
                $data['konsumen'][$value->id]['nama_pemilik'] = $value->nama_pemilik;
                $data['konsumen'][$value->id]['nik'] = $value->nik;
                $data['konsumen'][$value->id]['alamat'] = $value->alamat;
                $data['konsumen'][$value->id]['no_hp'] = $value->no_hp;
                $data['konsumen'][$value->id]['id_konsumen'] = $value->id_konsumen;
                $data['konsumen'][$value->id]['kategori'] = $value->kategori;
                $data['konsumen'][$value->id]['kategori_konsumen'] = $value->kategori_konsumen;
            }

            $gudang = DB::table('tb_gudang as a')->select("*")->get();
            $data['gudang'] = array();
            foreach ($gudang as $key => $value) {
                $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
                $data['gudang'][$value->id]['alamat'] = $value->alamat;
            }

            $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
            $data['karyawan'] = array();
            foreach ($karyawan as $key => $value) {
                $data['karyawan'][$value->id]['nama'] = $value->nama;
                $data['karyawan'][$value->id]['nik'] = $value->nik;
                $data['karyawan'][$value->id]['alamat'] = $value->alamat;
                $data['karyawan'][$value->id]['no_hp'] = $value->no_hp;
            }

            $kategori = DB::table('tb_kategori as a')->select("*")->get();
            $data['kategori'] = array();
            foreach ($kategori as $key => $value) {
                $data['kategori'][$value->id]['nama_kategori'] = $value->nama_kategori;
            }

            $users = DB::table('users as a')->select("*")->get();
            $data['users'] = array();
            foreach ($users as $key => $value) {
                $data['users'][$value->id]['name'] = $value->username;
            }

            $data['rekening'] = DB::table('tb_rekening as a')->get();

            return view('Terkirim', $data);
        } else {
            return view('Denied');
        }
    }

    public function updateterkirim($proses, $terkirim, $id, $potongan)
    {

        $data['terkirim'] = $terkirim;
        $data['return'] = $proses - $terkirim;
        $data['sub_potongan'] = $potongan;
        if ($data['return'] < 0) {
            $data['return'] = 0;
        }
        $cek = DB::table('tb_detail_barang_keluar as a')->select("*")->where('id', '=', $id)->get();
        $data['sub_total'] = $terkirim * ($cek[0]->harga_jual - $cek[0]->potongan) - ($cek[0]->sub_potongan);

        DB::table('tb_detail_barang_keluar')->where('id', '=', $id)->update($data);
        $data['id'] = $id;
        $data = DB::table('tb_detail_barang_keluar')->select("*")->where('id', '=', $id)->get();
        echo json_encode($data);
    }

    public function penerimaanbarangkeluar(Request $post)
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = $post->except('_token', 'nama_pembeli', 'pembayaran', 'nama_penyetor', 'tanggal_bayar', 'tagihan', 'kat_kon', 'status_pembayaran', 'jumlah_pembayaran', 'jenis_pembayaran', 'no_rekening_bank', 'total_tagihan');

        $data['admin_v'] = Auth::user()->id;
        $get = DB::table('tb_detail_barang_keluar as a')->join('tb_barang_keluar as b', 'b.no_kwitansi', '=', 'a.no_kwitansi')
            ->select("a.*", "b.id_gudang", "b.status_order")->where("a.no_kwitansi", "=", $data['no_kwitansi'])->get();
        $data['total_bayar'] = 0;
        foreach ($get as $value) {
            $s['sub_total'] = $value->terkirim * ($value->harga_jual - $value->potongan) - $value->sub_potongan;
            $s['verifikasi_return'] = "";
            if ($value->return > 0) {
                $s['verifikasi_return'] = "pending";
                DB::table('tb_detail_barang_keluar')->where('id', '=', $value->id)->update($s);
                //DB::table('tb_gudang_barang')->where('id_bprosespembayaranarang','=',$value->id_barang)->where('id_gudang','=',$value->id_gudang)->increment('jumlah', $value->return);
            } else {
                DB::table('tb_detail_barang_keluar')->where('id', '=', $value->id)->update($s);
            }
            $data['total_bayar'] += $s['sub_total'];
        }
        $query = DB::table('tb_barang_keluar')->where('no_kwitansi', '=', $data['no_kwitansi'])->update($data);
        $shan['status_pengiriman'] = "terkirim";
        $shan['tanggal_terkirim'] = date('Y-m-d');
        DB::table('kt_rekap_pembayaran')->where('no_kwitansi', '=', $data['no_kwitansi'])->update($shan);

        $v['sub_total'] = $data['total_bayar'];
        DB::table('tb_detail_trip')->where('no_kwitansi', '=', $data['no_kwitansi'])->update($v);

        $querycek = DB::table('tb_grafik')->where('months', date('F Y'))->get();
        if ($query) {
            if ($get[0]->status_order == "1") {
                if (count($querycek) > 0) {
                    DB::table('tb_grafik')->where('months', date('F Y'))->increment('sums', $data['total_bayar']);
                } else {
                    $y['months'] = date('F Y');
                    $y['sums'] = $data['total_bayar'];
                    DB::table('tb_grafik')->insert($y);
                }
            }

            //notifikasi
            $notif_get = DB::table('tb_barang_keluar as a')
                ->join('tb_konsumen as b', 'b.id', '=', 'a.id_konsumen')
                ->join('members as c', 'c.no_hp', '=', 'b.no_hp')
                ->select('c.*')
                ->where('no_kwitansi', '=', $data['no_kwitansi'])->get();
            if (count($notif_get) > 0) {
                $notif['id_member'] = $notif_get[0]->id;
                $notif['dilihat'] = 0;
                $notif['text'] = "Pesanan Anda dengan nomor invoice " . $data['no_kwitansi'] . " telah terkirim. Silahkan cek di laman <a href='order_terkirim'>Order Terkirim</a>";
                DB::table('kt_notifikasi')->insert($notif);
            }
            //endnotifikasi

        }




        //penyesuain
        $d = array();
        $s = array();
        $dt = array();
        $t = array();
        $v = array();
        $x = array();
        $data = array();

        $d = $post->except('_token', 'tagihan', 'kat_kon', 'jumlah_pembayaran', 'total_tagihan', 'status_barang', 'qc', 'dropper', 'pengirim', 'helper', 'tanggal_terkirim');
        $cek =  substr($d['no_kwitansi'], 0, 2);
        $xf['ppn'] = 0;
        if ($cek == "GR" || $cek == "OL") {

            $tagihan = str_replace(".", "", $post->only('tagihan')['tagihan']);
            $d['pembayaran'] = str_replace(".", "", $post->only('pembayaran')['pembayaran']);

            if ($post->kat_kon == "PKP") {
                $xf['pembayaran'] = round(100 / 111 * $d['pembayaran']);
                $xf['ppn'] = $d['pembayaran'] - $xf['pembayaran'];
            } else {
                $xf['pembayaran'] = $d['pembayaran'];
                $xf['ppn'] = 0;
            }

            if ($d['pembayaran'] >= $tagihan) {
                $data['status_pembayaran'] = "Lunas";
            } else if ($d['pembayaran'] == 0) {
                $data['status_pembayaran'] = "Tempo";
            } else {
                $data['status_pembayaran'] = "Titip";
            }

            $data['no_kwitansi'] = $d['no_kwitansi'];
            if ($d['pembayaran'] > 0) {
                $dt['no_kwitansi'] = $d['no_kwitansi'];
                $dt['tgl_bayar'] = $d['tanggal_bayar'];
                $dt['nama_penyetor'] = $d['nama_penyetor'];
                $dt['pembayaran'] = $xf['pembayaran'];
            }
            if ($xf['ppn'] > 0) {
                $dcvf['no_kwitansi'] = $d['no_kwitansi'];
                $dcvf['tgl_bayar'] = $d['tanggal_bayar'];
                $dcvf['nama_penyetor'] = $d['nama_penyetor'];
                $dcvf['pembayaran'] = $xf['ppn'];
                DB::table('tb_detail_pembayaran')->insert($dcvf);
            }

            $s['admin_k'] = Auth::user()->id;
            DB::table('tb_barang_keluar')->where('no_kwitansi', '=', $d['no_kwitansi'])->update($s);

            $szk['transaction_status'] = "settlement";
            $szk['status'] = "proses";
            DB::table('kt_rekap_pembayaran')->where('no_kwitansi', '=', $d['no_kwitansi'])->update($szk);

            $cek = DB::table('tb_pembayaran as a')->select("*")->where("a.no_kwitansi", "=", $d['no_kwitansi'])->get();
            if (count($cek) < 1) {
                DB::table('tb_pembayaran')->insert($data);
            } else {
                $x['status_pembayaran'] = $data['status_pembayaran'];
                DB::table('tb_pembayaran')->where('no_kwitansi', '=', $d['no_kwitansi'])->update($x);
            }
            DB::table('tb_detail_pembayaran')->insert($dt);
        } else {

            $tagihan = str_replace(".", "", $post->only('tagihan')['tagihan']);
            $d['pembayaran'] = str_replace(".", "", $post->only('pembayaran')['pembayaran']);

            if ($d['pembayaran'] >= $tagihan) {
                $data['status_pembayaran'] = "Lunas";
                $s['payment'] = "paid";
            } else if ($d['pembayaran'] == 0) {
                $data['status_pembayaran'] = "Tempo";
            } else {
                $data['status_pembayaran'] = "Titip";
            }

            if ($d['pembayaran'] > 0) {
                $dt['no_kwitansi'] = $d['no_kwitansi'];
                $dt['tgl_bayar'] = $d['tanggal_bayar'];
                $dt['nama_penyetor'] = $d['nama_penyetor'];
                $dt['pembayaran'] = $d['pembayaran'];
            }

            $s['admin_k'] = Auth::user()->id;
            DB::table('tb_order_jasa')->where('no_kwitansi', '=', $d['no_kwitansi'])->update($s);

            $cek = DB::table('tb_pembayaran as a')->select("*")->where("a.no_kwitansi", "=", $d['no_kwitansi'])->get();
            if (count($cek) < 1) {
                DB::table('tb_pembayaran')->insert($data);
            } else {
                $x['status_pembayaran'] = $data['status_pembayaran'];
                DB::table('tb_pembayaran')->where('no_kwitansi', '=', $d['no_kwitansi'])->update($x);
            }
            DB::table('tb_detail_pembayaran')->insert($dt);
        }
        if ($xf['ppn'] > 0 && $d['pembayaran'] > 0) {
            if (strtoupper($d['jenis_pembayaran']) == "TUNAI") {
                $t['jumlah'] = $xf['pembayaran'];
                $t['saldo_temp'] = 0;
                $t['jenis'] = 'in';
                $t['nama_jenis'] = 'Setoran Penjualan';
                $t['admin'] = Auth::user()->id;
                $t['keterangan'] = 'Penjualan ' . $d['nama_pembeli'] . ' (' . $d['no_kwitansi'] . ') ' . $data['status_pembayaran'];
                DB::table('tb_kas_ditangan')->insert($t);

                $v['jumlah'] = $xf['ppn'];
                $v['saldo_temp'] = 0;
                $v['jenis'] = 'in';
                $v['nama_jenis'] = 'PPN';
                $v['admin'] = Auth::user()->id;
                $v['keterangan'] = 'PPN Penjualan ' . $d['nama_pembeli'] . ' (' . $d['no_kwitansi'] . ') ' . $data['status_pembayaran'];
                DB::table('tb_kas_ditangan')->insert($v);
            } else if (strtoupper($d['jenis_pembayaran']) == "TRANSFER") {
                $t['jumlah'] = $xf['pembayaran'];
                $t['saldo_temp'] = 0;
                $t['jenis'] = 'in';
                $t['nama_jenis'] = 'Setoran Penjualan';
                $t['admin'] = Auth::user()->id;
                $t['keterangan'] = 'Penjualan ' . $d['nama_pembeli'] . ' (' . $d['no_kwitansi'] . ') ' . $data['status_pembayaran'];
                $t['kode_bank'] = $d['no_rekening_bank'];
                DB::table('tb_kas_dibank')->insert($t);

                $v['jumlah'] = $xf['ppn'];
                $v['saldo_temp'] = 0;
                $v['jenis'] = 'in';
                $v['nama_jenis'] = 'PPN';
                $v['admin'] = Auth::user()->id;
                $v['keterangan'] = 'PPN Penjualan ' . $d['nama_pembeli'] . ' (' . $d['no_kwitansi'] . ') ' . $data['status_pembayaran'];
                $v['kode_bank'] = $d['no_rekening_bank'];
                DB::table('tb_kas_dibank')->insert($v);
            }
        } else if ($xf['ppn'] == 0 && $d['pembayaran'] > 0) {
            if (strtoupper($d['jenis_pembayaran']) == "TUNAI") {
                $t['jumlah'] = $d['pembayaran'];
                $t['saldo_temp'] = 0;
                $t['jenis'] = 'in';
                $t['nama_jenis'] = 'Setoran Penjualan';
                $t['admin'] = Auth::user()->id;
                $t['keterangan'] = 'Penjualan ' . $d['nama_pembeli'] . ' (' . $d['no_kwitansi'] . ') ' . $data['status_pembayaran'];
                DB::table('tb_kas_ditangan')->insert($t);
            } else if (strtoupper($d['jenis_pembayaran']) == "TRANSFER") {
                $t['jumlah'] = $d['pembayaran'];
                $t['saldo_temp'] = 0;
                $t['jenis'] = 'in';
                $t['nama_jenis'] = 'Setoran Penjualan';
                $t['admin'] = Auth::user()->id;
                $t['keterangan'] = 'Penjualan ' . $d['nama_pembeli'] . ' (' . $d['no_kwitansi'] . ') ' . $data['status_pembayaran'];
                $t['kode_bank'] = $d['no_rekening_bank'];
                DB::table('tb_kas_dibank')->insert($t);
            }
        }
        //penyesuaian





    }

    public function inputbarangkeluar()
    {
        return view('InputBarangKeluar');
    }
    public function daftarbarangkeluar()
    {
        return view('DaftarBarangKeluar');
    }
    public function databarangkeluar()
    {
        return view('DataBarangKeluar');
    }
    public function daftarpenjualan()
    {
        if (role()) {
            $data['jabatan'] = DB::table('tb_jabatan as a')->select("*")->where("a.status", "=", "aktif")->get();
            if (Auth::user()->level == "5") {
                $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik", "=", Auth::user()->nik)->get();
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
                $data['penjualan'] = DB::table('tb_barang_keluar as a')
                    ->select("a.*")
                    ->where("a.pengembang", "=", $p[0]->id)
                    ->where("a.status_barang", "=", "terkirim")
                    ->where("a.total_bayar", ">", 0)
                    ->orderBy("a.tanggal_proses", "ASC")->get();
            } else if (Auth::user()->gudang == "1") {
                $data['gudang'] = $this->model->getGudang();
                $data['penjualan'] = DB::table('tb_barang_keluar as a')
                    ->select("a.*")
                    ->where("a.status_barang", "=", "terkirim")
                    ->where("a.total_bayar", ">", 0)
                    ->orderBy("a.tanggal_proses", "ASC")->get();
            } else {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
                $data['penjualan'] = DB::table('tb_barang_keluar as a')
                    ->select("a.*")
                    ->where("a.id_gudang", "=", Auth::user()->gudang)
                    ->where("a.status_barang", "=", "terkirim")
                    ->where("a.total_bayar", ">", 0)
                    ->orderBy("a.tanggal_proses", "ASC")->get();
            }
            $data['nama_download'] = "Daftar Barang Terkirim";

            $user = DB::table('users as a')->get();
            foreach ($user as $key => $value) {
                $data['user'][$value->id] = $value->name;
            }

            $karyawan = DB::table('tb_karyawan as a')->get();
            foreach ($karyawan as $key => $value) {
                $data['karyawan'][$value->id]['nama'] = $value->nama;
                $data['karyawan'][$value->id]['alamat'] = $value->alamat;
            }

            $konsumen = DB::table('tb_konsumen as a')->get();
            foreach ($konsumen as $key => $value) {
                $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
                $data['konsumen'][$value->id]['alamat'] = $value->alamat;
                $data['konsumen'][$value->id]['no_hp'] = $value->no_hp;
                $data['konsumen'][$value->id]['kategori_konsumen'] = $value->kategori_konsumen;
                $data['konsumen'][$value->id]['tempo_piutang'] = $value->tempo_piutang;
            }

            $data['pembayaran'] = array();
            $pembayaran = DB::table('tb_pembayaran as a')->where("status_pembayaran", "Lunas")->get();
            foreach ($pembayaran as $key => $value) {
                $data['pembayaran'][$value->no_kwitansi] = $value->status_pembayaran;
            }

            return view('DaftarPenjualan', $data);
        } else {
            return view('Denied');
        }
    }
    public function daftarpenjualans(Request $post)
    {
        if (role()) {
            $d = $post->except('_token');
            $Date = date('Y-m-d');
            if ($d['from'] != null && $d['to'] != null) {
                $from = $d['from'];
                $to = $d['to'];
                $data['from'] = $d['from'];
                $data['to'] = $d['to'];
            }
            if ($d['id_gudang'] != null) {
                $u['id_gudang'] = $d['id_gudang'];
                $a['gudang'] = $d['id_gudang'];
                $data['id_gudang'] = $d['id_gudang'];
            }
            if ($d['tempo'] != null) {
                $tmp = ' - ' . $d['tempo'] . ' days';
                $tempo = date('Y-m-d', strtotime($Date . $tmp));
                $data['tempo'] = $d['tempo'];
            }
            if ($d['petugas'] != null && $d['id'] != null) {
                $u[$d['petugas']] = $d['id'];

                $b['petugas1'] = $d['id'];
                $c['petugas2'] = $d['id'];
                $e['petugas3'] = $d['id'];

                $data['petugas'] = $d['petugas'];
                $data['id'] = $d['id'];
            }

            if (Auth::user()->level == "5") {
                $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik", "=", Auth::user()->nik)->get();
                $u['a.pengembang'] = $p[0]->id;
            }

            if (Auth::user()->level == "1" || Auth::user()->level == "2") {
                $data['gudang'] = $this->model->getGudang();
            } else {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
            }
            $data['jabatan'] = DB::table('tb_jabatan as a')->select("*")->where("a.status", "=", "aktif")->get();

            $x = DB::table('tb_karyawan as a')->select("*")->get();
            $y = DB::table('users as a')->select("*")->get();

            if (isset($from) && isset($u) && isset($tempo)) {

                $data['penjualan'] = DB::table('tb_barang_keluar as a')
                    ->select("a.*")
                    ->whereBetween('a.tanggal_terkirim', [$from, $to])
                    ->where($u)
                    ->whereDate('a.tanggal_terkirim', '<', $tempo)
                    ->where("a.status_barang", "=", "terkirim")
                    ->get();
            } else if (isset($from) && isset($u)) {
                $data['penjualan'] = DB::table('tb_barang_keluar as a')
                    ->select("a.*")
                    ->whereBetween('a.tanggal_terkirim', [$from, $to])
                    ->where("a.status_barang", "=", "terkirim")
                    ->where($u)
                    ->get();
            } else if (isset($from) && isset($tempo)) {
                $data['penjualan'] = DB::table('tb_barang_keluar as a')
                    ->select("a.*")
                    ->whereBetween('a.tanggal_terkirim', [$from, $to])
                    ->whereDate('a.tanggal_terkirim', '<', $tempo)
                    ->where("a.status_barang", "=", "terkirim")
                    ->get();
            } else if (isset($u) && isset($tempo)) {
                $data['penjualan'] = DB::table('tb_barang_keluar as a')
                    ->select("a.*")
                    ->where($u)
                    ->whereDate('a.tanggal_terkirim', '<', $tempo)
                    ->where("a.status_barang", "=", "terkirim")
                    ->get();
            } else if (isset($from)) {
                $data['penjualan'] = DB::table('tb_barang_keluar as a')
                    ->select("a.*")
                    ->whereBetween('a.tanggal_terkirim', [$from, $to])
                    ->where("a.status_barang", "=", "terkirim")
                    ->get();
            } else if (isset($u)) {
                $data['penjualan'] = DB::table('tb_barang_keluar as a')
                    ->select("a.*")
                    //->where("i.status_pembayaran","=",null)
                    ->where($u)
                    ->where("a.status_barang", "=", "terkirim")
                    ->get();
            } else if (isset($tempo)) {
                $data['penjualan'] = DB::table('tb_barang_keluar as a')
                    ->select("a.*")
                    ->whereDate('a.tanggal_terkirim', '<', $tempo)
                    ->where("a.status_barang", "=", "terkirim")
                    ->get();
            }
            $data['nama_download'] = "Daftar Barang Terkirim";

            foreach ($y as $value) {
                $data['admin'][$value->id] = $value->name;
            }

            $data['pembayaran'] = array();
            $pembayaran = DB::table('tb_pembayaran as a')->where("status_pembayaran", "Lunas")->get();
            foreach ($pembayaran as $key => $value) {
                $data['pembayaran'][$value->no_kwitansi] = $value->status_pembayaran;
            }

            $karyawan = DB::table('tb_karyawan as a')->get();
            foreach ($karyawan as $key => $value) {
                $data['karyawan'][$value->id]['nama'] = $value->nama;
                $data['karyawan'][$value->id]['alamat'] = $value->alamat;
            }

            $user = DB::table('users as a')->get();
            foreach ($user as $key => $value) {
                $data['user'][$value->id] = $value->name;
            }

            $konsumen = DB::table('tb_konsumen as a')->get();
            foreach ($konsumen as $key => $value) {
                $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
                $data['konsumen'][$value->id]['alamat'] = $value->alamat;
                $data['konsumen'][$value->id]['no_hp'] = $value->no_hp;
                $data['konsumen'][$value->id]['kategori_konsumen'] = $value->kategori_konsumen;
                $data['konsumen'][$value->id]['tempo_piutang'] = $value->tempo_piutang;
            }
            //dd($data['penjualan']);
            return view('DaftarPenjualan', $data);
        } else {
            return view('Denied');
        }
    }

    public function daftarhutang()
    {
        $data['hutang'] = DB::table('tb_kas_ditangan')
            ->where('nama_jenis', 'Pembiayaan / Hutang')
            ->whereNull('status_pembiayaan')
            ->orWhere('status_pembiayaan', 'Titip')
            ->where('nama_jenis', 'Pembiayaan / Hutang')
            ->get();

        foreach ($data['hutang'] as $key => $value) {
            $fk = explode('FK-', $value->keterangan);
            $datafk = DB::table('tb_barang_masuk')->where('no_faktur', 'FK-' . $fk[1])->get();
            if (count($datafk) > 0) {
                $data['hutang'][$key]->suplayer = $datafk[0]->suplayer;
                $data['hutang'][$key]->no_faktur = 'FK-' . $fk[1];
            }
        }

        $data['suplayer'] = DB::table('tb_suplayer as a')->select("*")->get();
        foreach ($data['suplayer']  as $value) {
            $data['val_suplayer'][$value->id] = $value;
        }

        return view('DaftarHutang', $data);
    }

    public function getHuman($id)
    {
        if ($id == "admin_p" || $id == "admin_g" || $id == "admin_v" || $id == "admin_k") {
            $data = DB::table('users as a')->select("*")->get();
        } else {
            $data = DB::table('tb_karyawan as a')->select("*")->get();
        }
        echo json_encode($data);
    }
    public function prosespembayaran()
    {
        if (role()) {
            if (Auth::user()->level == "1" || Auth::user()->level == "4") {
                $data['transfer'] = DB::table('tb_barang_keluar as a')
                    ->select("*", "a.no_kwitansi as no_kwitansi", "a.id as id")
                    ->where("a.status_barang", "=", "terkirim")
                    ->where("a.status_order", "=", "1")
                    ->where("a.total_bayar", ">", 0)
                    ->get();
            } else {
                $data['transfer'] = DB::table('tb_barang_keluar as a')
                    ->select("*", "a.no_kwitansi as no_kwitansi", "a.id as id")
                    ->where("a.status_barang", "=", "terkirim")
                    ->where("a.id_gudang", Auth::user()->gudang)
                    ->where("a.status_order", "=", "1")
                    ->where("a.total_bayar", ">", 0)
                    ->get();
            }
            $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
            $data['leader'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();

            $user = DB::table('users as a')->select("*")->get();
            $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
            $gudang = DB::table('tb_gudang as a')->select("a.*")->get();
            $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
            $kategori = DB::table('tb_kategori as a')->select("*")->get();

            $pembayaran = DB::table('tb_pembayaran as a')->select("*")->where("a.status_pembayaran", "=", "Lunas")->get();
            $data['pembayaran'] = array();
            foreach ($pembayaran as $key => $value) {
                $data['pembayaran'][$value->no_kwitansi] = "Lunas";
            }

            foreach ($user as $key => $value) {
                $data['user'][$value->id] = $value->name;
            }
            foreach ($konsumen as $key => $value) {
                $data['konsumen'][$value->id]['id'] = $value->id_konsumen;
                $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
                $data['konsumen'][$value->id]['alamat'] = $value->alamat;
                $data['konsumen'][$value->id]['no_hp'] = $value->no_hp;
                $data['konsumen'][$value->id]['kategori_konsumen'] = $value->kategori_konsumen;
            }
            foreach ($gudang as $key => $value) {
                $data['gudang'][$value->id] = $value->nama_gudang;
            }
            foreach ($karyawan as $key => $value) {
                $data['karyawan'][$value->id] = $value->nama;
            }
            foreach ($kategori as $key => $value) {
                $data['kategori'][$value->id] = $value->nama_kategori;
            }
            $data['rekening'] = DB::table('tb_rekening as a')
                ->select("*")
                ->where("a.status", "aktif")
                ->get();
            return view('ProsesPembayaran', $data);
        } else {
            return view('Denied');
        }
    }

    public function prosespembayaranhutang()
    {
        $data['transfer'] = DB::table('tb_kas_ditangan as a')
            ->select("*")
            ->where("a.nama_jenis", "Pembiayaan / Hutang")
            ->where("a.status_pembiayaan", 'Titip')
            ->orWhereNull("a.status_pembiayaan")
            ->where("a.nama_jenis", "Pembiayaan / Hutang")
            ->get();
        foreach ($data['transfer'] as $key => $value) {
            $ds = explode('FK-', $value->keterangan);
            $bm = DB::table('tb_barang_masuk')
                ->leftJoin('tb_suplayer', 'tb_barang_masuk.suplayer', 'tb_suplayer.id')
                ->where('tb_barang_masuk.no_faktur', 'FK-' . $ds[1])
                ->groupBy('no_faktur')
                ->select('*')
                ->get();
            $data['transfer'][$key]->nama_pemilik = $bm[0]->nama_pemilik;
            $data['transfer'][$key]->kota = $bm[0]->kota;
            $data['transfer'][$key]->no_hp = $bm[0]->no_hp;
            $data['transfer'][$key]->tgl_masuk = $bm[0]->tgl_masuk;
            $data['transfer'][$key]->no_faktur = $bm[0]->no_faktur;
        }
        $data['rekening'] = DB::table('tb_rekening as a')
            ->select("*")
            ->where("a.status", "aktif")
            ->get();
        $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
        $data['leader'] = DB::table('tb_karyawan as a')->select("*")->where("a.status", "=", "aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen", '>', 4)->where("a.status", "=", "aktif")->get();
        return view('ProsesPembayaranHutang', $data);
    }

    public function pembayaranhutang(Request $post)
    {
        $data = $post->except('_token');
        $tagihan = str_replace(".", "", $post->only('tagihan')['tagihan']);
        $d['pembayaran'] = str_replace(".", "", $post->only('pembayaran')['pembayaran']);

        if ($d['pembayaran'] >= $tagihan) {
            $dtz['status_pembiayaan'] = "Lunas";
        } else {
            $dtz['status_pembiayaan'] = "Titip";
        }

        $dt['no_faktur'] = $data['no_faktur'];
        $dt['tgl_bayar'] = $data['tanggal_bayar'];
        $dt['penyetor'] = $data['nama_penyetor'];
        $dt['pembayaran'] = $d['pembayaran'];
        $dt['via'] = $data['jenis_pembayaran'];
        $dt['rek'] = $data['no_rekening_bank'];

        $q = DB::table('tb_kas_ditangan')->where('keterangan', 'LIKE', '%' . $dt['no_faktur'] . '%')->update($dtz);
        DB::table('tb_pembayaran_hutang')->insert($dt);


        if (strtoupper($data['jenis_pembayaran']) == "TUNAI") {
            $t['jumlah'] = $d['pembayaran'];
            $t['saldo_temp'] = 0;
            $t['jenis'] = 'out';
            $t['nama_jenis'] = 'Bayar Hutang';
            $t['admin'] = Auth::user()->id;
            $t['keterangan'] = 'Pembayaran Hutang Pengadaan barang ' . $data['namas'] . ' (' . $dt['no_faktur'] . ') ';
            DB::table('tb_kas_ditangan')->insert($t);
        } else if (strtoupper($data['jenis_pembayaran']) == "TRANSFER") {
            $t['jumlah'] = $d['pembayaran'];
            $t['saldo_temp'] = 0;
            $t['jenis'] = 'out';
            $t['nama_jenis'] = 'Bayar Hutang';
            $t['admin'] = Auth::user()->id;
            $t['keterangan'] = 'Pembayaran Hutang Pengadaan barang ' . $data['namas'] . ' (' . $dt['no_faktur'] . ') ';
            $t['kode_bank'] = $data['no_rekening_bank'];
            DB::table('tb_kas_dibank')->insert($t);
        }
    }

    public function pilihbarangmasuk($id)
    {
        $bm['bm'] = DB::table('tb_barang_masuk')
            ->leftJoin('tb_barang', 'tb_barang_masuk.barang', 'tb_barang.id')
            ->leftJoin('tb_harga', 'tb_harga.id_barang', 'tb_barang_masuk.barang')
            ->where('tb_barang_masuk.no_faktur', $id)
            ->select('*')
            ->get();
        $bm['bayar'] = DB::table('tb_pembayaran_hutang')
            ->select("*", DB::raw('SUM(pembayaran) as total_pembayaran'))
            ->where('no_faktur', $id)
            ->groupBy('no_faktur')
            ->get();
        echo json_encode($bm);
    }

    public function pembayaran(Request $post)
    {
        $d = $post->except('_token', 'tagihan', 'kat_kon');
        $cek =  substr($d['no_kwitansi'], 0, 2);
        $xf['ppn'] = 0;
        if ($cek == "GR" || $cek == "OL") {

            $tagihan = str_replace(".", "", $post->only('tagihan')['tagihan']);
            $d['pembayaran'] = str_replace(".", "", $post->only('pembayaran')['pembayaran']);

            if ($post->kat_kon == "PKP") {
                $xf['pembayaran'] = round(100 / 111 * $d['pembayaran']);
                $xf['ppn'] = $d['pembayaran'] - $xf['pembayaran'];
            } else {
                $xf['pembayaran'] = $d['pembayaran'];
                $xf['ppn'] = 0;
            }

            if ($d['pembayaran'] >= $tagihan) {
                $data['status_pembayaran'] = "Lunas";
            } else if ($d['pembayaran'] == 0) {
                $data['status_pembayaran'] = "Tempo";
            } else {
                $data['status_pembayaran'] = "Titip";
            }

            $data['no_kwitansi'] = $d['no_kwitansi'];
            if ($d['pembayaran'] > 0) {
                $dt['no_kwitansi'] = $d['no_kwitansi'];
                $dt['tgl_bayar'] = $d['tanggal_bayar'];
                $dt['nama_penyetor'] = $d['nama_penyetor'];
                $dt['pembayaran'] = $xf['pembayaran'];
            }

            if ($xf['ppn'] > 0) {
                $dcvf['no_kwitansi'] = $d['no_kwitansi'];
                $dcvf['tgl_bayar'] = $d['tanggal_bayar'];
                $dcvf['nama_penyetor'] = $d['nama_penyetor'];
                $dcvf['pembayaran'] = $xf['ppn'];
                DB::table('tb_detail_pembayaran')->insert($dcvf);
            }

            $s['admin_k'] = Auth::user()->id;
            $s['leader'] = $d['leader'];
            $s['manager'] = $d['manager'];
            DB::table('tb_barang_keluar')->where('no_kwitansi', '=', $d['no_kwitansi'])->update($s);

            $szk['transaction_status'] = "settlement";
            $szk['status'] = "proses";
            DB::table('kt_rekap_pembayaran')->where('no_kwitansi', '=', $d['no_kwitansi'])->update($szk);

            $cek = DB::table('tb_pembayaran as a')->select("*")->where("a.no_kwitansi", "=", $d['no_kwitansi'])->get();
            if (count($cek) < 1) {
                DB::table('tb_pembayaran')->insert($data);
            } else {
                $x['status_pembayaran'] = $data['status_pembayaran'];
                DB::table('tb_pembayaran')->where('no_kwitansi', '=', $d['no_kwitansi'])->update($x);
            }
            DB::table('tb_detail_pembayaran')->insert($dt);
        } else {

            $tagihan = str_replace(".", "", $post->only('tagihan')['tagihan']);
            $d['pembayaran'] = str_replace(".", "", $post->only('pembayaran')['pembayaran']);

            if ($d['pembayaran'] >= $tagihan) {
                $data['status_pembayaran'] = "Lunas";
                $s['payment'] = "paid";
            } else if ($d['pembayaran'] == 0) {
                $data['status_pembayaran'] = "Tempo";
            } else {
                $data['status_pembayaran'] = "Titip";
            }

            $data['no_kwitansi'] = $d['no_kwitansi'];

            if ($d['pembayaran'] > 0) {
                $dt['no_kwitansi'] = $d['no_kwitansi'];
                $dt['tgl_bayar'] = $d['tanggal_bayar'];
                $dt['nama_penyetor'] = $d['nama_penyetor'];
                $dt['pembayaran'] = $d['pembayaran'];
            }
            $s['admin_k'] = Auth::user()->id;
            $s['leader'] = $d['leader'];
            $s['manager'] = $d['manager'];
            DB::table('tb_order_jasa')->where('no_kwitansi', '=', $d['no_kwitansi'])->update($s);

            $cek = DB::table('tb_pembayaran as a')->select("*")->where("a.no_kwitansi", "=", $d['no_kwitansi'])->get();
            if (count($cek) < 1) {
                DB::table('tb_pembayaran')->insert($data);
            } else {
                $x['status_pembayaran'] = $data['status_pembayaran'];
                DB::table('tb_pembayaran')->where('no_kwitansi', '=', $d['no_kwitansi'])->update($x);
            }
            DB::table('tb_detail_pembayaran')->insert($dt);
        }
        if ($xf['ppn'] > 0 && $d['pembayaran'] > 0) {
            if (strtoupper($d['jenis_pembayaran']) == "TUNAI") {
                $t['jumlah'] = $xf['pembayaran'];
                $t['saldo_temp'] = 0;
                $t['jenis'] = 'in';
                $t['nama_jenis'] = 'Setoran Penjualan';
                $t['admin'] = Auth::user()->id;
                $t['keterangan'] = 'Penjualan ' . $d['nama_pembeli'] . ' (' . $d['no_kwitansi'] . ') ' . $data['status_pembayaran'];
                DB::table('tb_kas_ditangan')->insert($t);

                $v['jumlah'] = $xf['ppn'];
                $v['saldo_temp'] = 0;
                $v['jenis'] = 'in';
                $v['nama_jenis'] = 'PPN';
                $v['admin'] = Auth::user()->id;
                $v['keterangan'] = 'PPN Penjualan ' . $d['nama_pembeli'] . ' (' . $d['no_kwitansi'] . ') ' . $data['status_pembayaran'];
                DB::table('tb_kas_ditangan')->insert($v);
            } else if (strtoupper($d['jenis_pembayaran']) == "TRANSFER") {
                $t['jumlah'] = $xf['pembayaran'];
                $t['saldo_temp'] = 0;
                $t['jenis'] = 'in';
                $t['nama_jenis'] = 'Setoran Penjualan';
                $t['admin'] = Auth::user()->id;
                $t['keterangan'] = 'Penjualan ' . $d['nama_pembeli'] . ' (' . $d['no_kwitansi'] . ') ' . $data['status_pembayaran'];
                $t['kode_bank'] = $d['no_rekening_bank'];
                DB::table('tb_kas_dibank')->insert($t);

                $v['jumlah'] = $xf['ppn'];
                $v['saldo_temp'] = 0;
                $v['jenis'] = 'in';
                $v['nama_jenis'] = 'PPN';
                $v['admin'] = Auth::user()->id;
                $v['keterangan'] = 'PPN Penjualan ' . $d['nama_pembeli'] . ' (' . $d['no_kwitansi'] . ') ' . $data['status_pembayaran'];
                $v['kode_bank'] = $d['no_rekening_bank'];
                DB::table('tb_kas_dibank')->insert($v);
            }
        } else if ($xf['ppn'] == 0 && $d['pembayaran'] > 0) {
            if (strtoupper($d['jenis_pembayaran']) == "TUNAI") {
                $t['jumlah'] = $d['pembayaran'];
                $t['saldo_temp'] = 0;
                $t['jenis'] = 'in';
                $t['nama_jenis'] = 'Setoran Penjualan';
                $t['admin'] = Auth::user()->id;
                $t['keterangan'] = 'Penjualan ' . $d['nama_pembeli'] . ' (' . $d['no_kwitansi'] . ') ' . $data['status_pembayaran'];
                DB::table('tb_kas_ditangan')->insert($t);
            } else if (strtoupper($d['jenis_pembayaran']) == "TRANSFER") {
                $t['jumlah'] = $d['pembayaran'];
                $t['saldo_temp'] = 0;
                $t['jenis'] = 'in';
                $t['nama_jenis'] = 'Setoran Penjualan';
                $t['admin'] = Auth::user()->id;
                $t['keterangan'] = 'Penjualan ' . $d['nama_pembeli'] . ' (' . $d['no_kwitansi'] . ') ' . $data['status_pembayaran'];
                $t['kode_bank'] = $d['no_rekening_bank'];
                DB::table('tb_kas_dibank')->insert($t);
            }
        }
    }

    public function datapembayaran()
    {
        if (role()) {
            $d = DB::table('tb_karyawan as a')->select("*")->get();
            $da = DB::table('users as a')->select("*")->get();
            if (Auth::user()->level == "5") {
                $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik", "=", Auth::user()->nik)->get();
                $data['pembayaran'] = array();
                /*$data['pembayaran'] = DB::table('tb_barang_keluar as a')
                            ->select("*")
                            ->where("a.status_barang","terkirim")
                            ->where("a.pengembang",$p[0]->id)
                            ->whereMonth("a.tanggal_terkirim",Date('m'))
                            ->groupBy('a.no_kwitansi')
                            ->get();*/
            } else if (Auth::user()->gudang == "1") {
                $data['pembayaran'] = array();
                /*$data['pembayaran'] = DB::table('tb_barang_keluar as a')
                    ->select("*")
                    ->where("a.status_barang","terkirim")
                    ->whereMonth("a.tanggal_terkirim",Date('m'))
                    ->groupBy('a.no_kwitansi')
                    ->get();*/
            } else {
                $data['pembayaran'] = array();
                /*$data['pembayaran'] = DB::table('tb_barang_keluar as a')
                            ->select("*")
                            ->where("a.status_barang","terkirim")
                            ->where("a.id_gudang",Auth::user()->gudang)
                            ->whereMonth("a.tanggal_terkirim",Date('m'))
                            ->groupBy('a.no_kwitansi')
                            ->get();*/
            }


            $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
            foreach ($konsumen as $value) {
                $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
                $data['konsumen'][$value->id]['alamat'] = $value->alamat;
            }
            /*$detail = DB::table('tb_detail_pembayaran as a')
                          ->join('tb_pembayaran as o','o.no_kwitansi','=','a.no_kwitansi')
                          ->select("*",DB::raw('SUM(a.pembayaran) as pembayaran'))
                          ->groupBy('a.no_kwitansi')
                          ->get();
      $data['bayar'] = array();
      foreach ($detail as $value) {
        $data['bayar'][$value->no_kwitansi]['bayar'] =$value->pembayaran;
        $data['bayar'][$value->no_kwitansi]['tanggal_bayar'] =$value->tgl_bayar;
        $data['bayar'][$value->no_kwitansi]['penyetor'] =$value->nama_penyetor;
        $data['bayar'][$value->no_kwitansi]['status_pembayaran'] =$value->status_pembayaran;
      }

      $harga = DB::table('tb_harga as a')->select("*")->get();
      foreach ($harga as $value) {
        $data['harga'][$value->id_barang]=$value->harga_hpp;
        $data['harga'][$value->id_barang]=$value->harga_hp;
      }
      //dd($data['harga']);
      $data['barang'] = array();
      $barang = DB::table('tb_detail_barang_keluar as a')
                ->select("*")
                ->get();
      foreach ($barang as $val) {
        if ($val->terkirim < 1){
            $terkirim = 1;
        }else{
            $terkirim = $val->terkirim;
        }
        if ($val->harga_net > ($val->harga_jual - $val->potongan - ($val->sub_potongan / $terkirim))) {
          if (array_key_exists($val->no_kwitansi, $data['barang'])){
            $data['barang'][$val->no_kwitansi]['selisih'] += 0;
            $data['barang'][$val->no_kwitansi]['omset'] += $val->terkirim * $val->harga_jual;
            $harga_hpp = $data['harga'][$val->id_barang];
            $data['barang'][$val->no_kwitansi]['hpp'] += $val->terkirim * ($val->harga_jual - $harga_hpp);
          }else{
            $data['barang'][$val->no_kwitansi]['selisih'] = 0;
            $data['barang'][$val->no_kwitansi]['omset'] = $val->terkirim * $val->harga_jual;
            $harga_hpp = $data['harga'][$val->id_barang];
            $data['barang'][$val->no_kwitansi]['hpp'] = $val->terkirim * ($val->harga_jual - $harga_hpp);
          }
        }else{
          if (array_key_exists($val->no_kwitansi, $data['barang'])){
            $data['barang'][$val->no_kwitansi]['selisih'] += ($val->terkirim * (($val->harga_jual - $val->potongan)- $val->harga_net )) - $val->sub_potongan;
            $data['barang'][$val->no_kwitansi]['omset'] += $val->terkirim * $val->harga_net;
            $harga_hpp = $data['harga'][$val->id_barang];
            $data['barang'][$val->no_kwitansi]['hpp'] += $val->terkirim * ($val->harga_net - $harga_hpp);
          }else{
            $data['barang'][$val->no_kwitansi]['selisih'] = ($val->terkirim * (($val->harga_jual- $val->potongan) - $val->harga_net )) - $val->sub_potongan;
            $data['barang'][$val->no_kwitansi]['omset'] = $val->terkirim * $val->harga_net;
            $harga_hpp = $data['harga'][$val->id_barang];
            $data['barang'][$val->no_kwitansi]['hpp'] = $val->terkirim * ($val->harga_net - $harga_hpp);
          }
        }
      }*/
            $text_gudang = DB::table('tb_gudang as a')
                ->select("*")
                ->get();
            foreach ($text_gudang as $value) {
                $data['text_gudang'][$value->id] = $value->nama_gudang;
            }
            $text_gudang = DB::table('tb_gudang as a')
                ->select("*")
                ->get();
            foreach ($text_gudang as $value) {
                $data['text_gudang'][$value->id] = $value->nama_gudang;
            }

            $data['karyawan'] = array();
            $data['admin'] = array();
            foreach ($d as $value) {
                $data['karyawan'][$value->id] = $value->nama;
            }
            foreach ($d as $value) {
                $data['karyawan2'][$value->id]['nama'] = $value->nama;
                $data['karyawan2'][$value->id]['alamat'] = $value->alamat;
            }
            foreach ($da as $value) {
                $data['admin'][$value->id] = $value->name;
            }
            $data['nama_download'] = "Data Pembayaran";
            if (Auth::user()->level == "5") {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
            } else if (Auth::user()->gudang == "1") {
                $data['gudang'] = $this->model->getGudang();
            } else {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
            }

            $bulan = array("Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            $data['bulan'] = array();
            for ($i = 5; $i < date('m'); $i++) {
                $data['bulan'][$i] = $bulan[$i];
            }
            $data['tab'] = date('m');

            $data['status_order'] = DB::table('tb_status_order as a')->select("*")->where("a.status", "aktif")->get();
            $data['nama_download'] = "Data Pembayaran";
            return view('DataPembayaran', $data);
        } else {
            return view('Denied');
        }
    }


    public function caridatapembayaran(Request $post)
    {
        $k = $post->except('_token');
        $d = DB::table('tb_karyawan as a')->select("*")->get();
        $da = DB::table('users as a')->select("*")->get();

        $data['pembayaran'] = DB::table('tb_barang_keluar as a')
            ->leftJoin('tb_detail_pembayaran as c', 'c.no_kwitansi', '=', 'a.no_kwitansi')
            ->select("a.*")
            ->where("a.status_barang", "terkirim")
            ->where("a.no_kwitansi", $k['no_kwitansi'])
            ->groupBy('a.no_kwitansi')
            ->get();
        $data['nama_download'] = "Data Pembayaran";
        if (Auth::user()->level == "5") {
            $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
        } else if (Auth::user()->gudang == "1") {
            $data['gudang'] = $this->model->getGudang();
        } else {
            $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
        }
        $data['status_order'] = DB::table('tb_status_order as a')->select("*")->where("a.status", "aktif")->get();
        $bulan = array("Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $data['bulan'] = array();
        for ($i = 5; $i < date('m'); $i++) {
            $data['bulan'][$i] = $bulan[$i];
        }
        $data['tab'] = date('m');


        $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
        foreach ($konsumen as $value) {
            $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
            $data['konsumen'][$value->id]['alamat'] = $value->alamat;
        }
        $detail = DB::table('tb_detail_pembayaran as a')
            ->join('tb_pembayaran as o', 'o.no_kwitansi', '=', 'a.no_kwitansi')
            ->select("*", DB::raw('SUM(a.pembayaran) as pembayaran'))
            ->where("a.no_kwitansi", $k['no_kwitansi'])
            ->groupBy('a.no_kwitansi')
            ->get();
        $data['bayar'] = array();
        foreach ($detail as $value) {
            $data['bayar'][$value->no_kwitansi]['bayar'] = $value->pembayaran;
            $data['bayar'][$value->no_kwitansi]['tanggal_bayar'] = $value->tgl_bayar;
            $data['bayar'][$value->no_kwitansi]['penyetor'] = $value->nama_penyetor;
            $data['bayar'][$value->no_kwitansi]['status_pembayaran'] = $value->status_pembayaran;
            $data['status_pembayaran'] = $value->status_pembayaran;
        }

        $data['barang'] = array();
        $barang = DB::table('tb_detail_barang_keluar as a')
            ->select("*")
            ->get();

        $harga = DB::table('tb_harga as a')->select("*")->get();
        foreach ($harga as $value) {
            $data['harga'][$value->id_barang] = $value->harga_hpp;
        }

        foreach ($barang as $val) {
            if ($val->terkirim < 1) {
                $terkirim = 1;
            } else {
                $terkirim = $val->terkirim;
            }
            if ($val->harga_net > ($val->harga_jual - $val->potongan - ($val->sub_potongan / $terkirim))) {
                if (array_key_exists($val->no_kwitansi, $data['barang'])) {
                    $data['barang'][$val->no_kwitansi]['selisih'] += 0;
                    $data['barang'][$val->no_kwitansi]['omset'] += $val->terkirim * $val->harga_jual;
                    $harga_hpp = $data['harga'][$val->id_barang];
                    $data['barang'][$val->no_kwitansi]['hpp'] += $val->terkirim * ($val->harga_jual - $harga_hpp);
                } else {
                    $data['barang'][$val->no_kwitansi]['selisih'] = 0;
                    $data['barang'][$val->no_kwitansi]['omset'] = $val->terkirim * $val->harga_jual;
                    $harga_hpp = $data['harga'][$val->id_barang];
                    $data['barang'][$val->no_kwitansi]['hpp'] = $val->terkirim * ($val->harga_jual - $harga_hpp);
                }
            } else {
                if (array_key_exists($val->no_kwitansi, $data['barang'])) {
                    $data['barang'][$val->no_kwitansi]['selisih'] += ($val->terkirim * ($val->harga_jual - $val->harga_net - $val->potongan)) - $val->sub_potongan;
                    $data['barang'][$val->no_kwitansi]['omset'] += $val->terkirim * $val->harga_net;
                    $harga_hpp = $data['harga'][$val->id_barang];
                    $data['barang'][$val->no_kwitansi]['hpp'] += $val->terkirim * ($val->harga_net - $harga_hpp);
                } else {
                    $data['barang'][$val->no_kwitansi]['selisih'] = ($val->terkirim * ($val->harga_jual - $val->harga_net - $val->potongan)) - $val->sub_potongan;
                    $data['barang'][$val->no_kwitansi]['omset'] = $val->terkirim * $val->harga_net;
                    $harga_hpp = $data['harga'][$val->id_barang];
                    $data['barang'][$val->no_kwitansi]['hpp'] = $val->terkirim * ($val->harga_net - $harga_hpp);
                }
                //dd($data['barang']);
            }
        }
        $d = DB::table('tb_karyawan as a')->select("*")->get();
        $da = DB::table('users as a')->select("*")->get();
        $data['karyawan'] = array();
        $data['admin'] = array();
        foreach ($d as $value) {
            $data['karyawan'][$value->id] = $value->nama;
        }
        foreach ($d as $value) {
            $data['karyawan2'][$value->id]['nama'] = $value->nama;
            $data['karyawan2'][$value->id]['alamat'] = $value->alamat;
        }
        foreach ($da as $value) {
            $data['admin'][$value->id] = $value->name;
        }
        $text_gudang = DB::table('tb_gudang as a')
            ->select("*")
            ->get();
        foreach ($text_gudang as $value) {
            $data['text_gudang'][$value->id] = $value->nama_gudang;
        }
        //dd($data);
        return view('DataPembayaran', $data);
    }

    public function datapembayarans(Request $post)
    {
        if (role()) {
            $k = $post->except('_token');

            if ($k['from'] != null && $k['to'] != null) {
                $from = $k['from'];
                $to = $k['to'];
                $data['from'] = $k['from'];
                $data['to'] = $k['to'];
            }
            if ($k['id_gudang'] != null) {
                $u['a.id_gudang'] = $k['id_gudang'];
                $data['id_gudang'] = $k['id_gudang'];
            }
            if ($k['status_pembayaran'] != null) {
                //$u['o.status_pembayaran'] = $k['status_pembayaran'];
                $data['status_pembayaran'] = $k['status_pembayaran'];
                //if ($u['o.status_pembayaran'] == "Tempo") {
                //  $u['o.status_pembayaran'] = null;
                //}
            }
            if ($k['status_order'] != null) {
                $u['a.status_order'] = $k['status_order'];
                $data['v_status_order'] = $k['status_order'];
            }
            if ($k['petugas'] != null && $k['id'] != null) {
                $u['a.' . $k['petugas']] = $k['id'];
                $data['petugas'] = $k['petugas'];
                $data['id'] = $k['id'];
            }

            $d = DB::table('tb_karyawan as a')->select("*")->get();
            $da = DB::table('users as a')->select("*")->get();

            if (Auth::user()->level == "5") {
                $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik", "=", Auth::user()->nik)->get();
                $u['a.pengembang'] = $p[0]->id;
            }

            if (isset($from)) {
                $data['pembayaran'] = DB::table('tb_barang_keluar as a')
                    ->leftJoin('tb_detail_pembayaran as c', 'c.no_kwitansi', '=', 'a.no_kwitansi')
                    //->leftJoin('tb_pembayaran as o','o.no_kwitansi','=','a.no_kwitansi')
                    ->select("a.*")
                    ->where("a.status_barang", "terkirim")
                    ->where($u)
                    ->whereBetween('tgl_bayar', [$from, $to])
                    ->groupBy('a.no_kwitansi')
                    ->get();
            } else {
                $data['pembayaran'] = DB::table('tb_barang_keluar as a')
                    ->leftJoin('tb_detail_pembayaran as c', 'c.no_kwitansi', '=', 'a.no_kwitansi')
                    //->leftJoin('tb_pembayaran as o','o.no_kwitansi','=','a.no_kwitansi')
                    ->select("a.*")
                    ->where("a.status_barang", "terkirim")
                    ->where($u)
                    ->groupBy('a.no_kwitansi')
                    ->get();
            }

            /*$pembayaran =  DB::table('tb_pembayaran as a')->select("*")->get();
      $data['cek_bayar'] = array();
      foreach ($detail as $value) {
        $data['bayar'][$value->no_kwitansi]['bayar'] =$value->pembayaran;
        $data['bayar'][$value->no_kwitansi]['tanggal_bayar'] =$value->tgl_bayar;
        $data['bayar'][$value->no_kwitansi]['penyetor'] =$value->nama_penyetor;
        $data['bayar'][$value->no_kwitansi]['status_pembayaran'] =$value->status_pembayaran;
      }*/


            $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
            foreach ($konsumen as $value) {
                $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
                $data['konsumen'][$value->id]['alamat'] = $value->alamat;
            }
            $detail = DB::table('tb_detail_pembayaran as a')
                ->join('tb_pembayaran as o', 'o.no_kwitansi', '=', 'a.no_kwitansi')
                ->select("*", DB::raw('SUM(a.pembayaran) as pembayaran'))
                ->groupBy('a.no_kwitansi')
                ->get();

            $data['bayar'] = array();
            foreach ($detail as $value) {
                $data['bayar'][$value->no_kwitansi]['bayar'] = $value->pembayaran;
                $data['bayar'][$value->no_kwitansi]['tanggal_bayar'] = $value->tgl_bayar;
                $data['bayar'][$value->no_kwitansi]['penyetor'] = $value->nama_penyetor;
                $data['bayar'][$value->no_kwitansi]['status_pembayaran'] = $value->status_pembayaran;
            }

            $harga = DB::table('tb_harga as a')->select("*")->get();
            foreach ($harga as $value) {
                $data['harga'][$value->id_barang] = $value->harga_hpp;
            }

            $data['barang'] = array();
            $barang = DB::table('tb_detail_barang_keluar as a')
                ->select("*")
                ->get();
            foreach ($barang as $val) {
                if ($val->terkirim < 1) {
                    $terkirim = 1;
                } else {
                    $terkirim = $val->terkirim;
                }
                if ($val->harga_net > ($val->harga_jual - $val->potongan - ($val->sub_potongan / $terkirim))) {
                    if (array_key_exists($val->no_kwitansi, $data['barang'])) {
                        $data['barang'][$val->no_kwitansi]['selisih'] += 0;
                        $data['barang'][$val->no_kwitansi]['omset'] += $val->terkirim * $val->harga_jual;
                        $harga_hpp = $data['harga'][$val->id_barang];
                        $data['barang'][$val->no_kwitansi]['hpp'] += $val->terkirim * ($val->harga_jual - $harga_hpp);
                    } else {
                        $data['barang'][$val->no_kwitansi]['selisih'] = 0;
                        $data['barang'][$val->no_kwitansi]['omset'] = $val->terkirim * $val->harga_jual;
                        $harga_hpp = $data['harga'][$val->id_barang];
                        $data['barang'][$val->no_kwitansi]['hpp'] = $val->terkirim * ($val->harga_jual - $harga_hpp);
                    }
                } else {
                    if (array_key_exists($val->no_kwitansi, $data['barang'])) {
                        $data['barang'][$val->no_kwitansi]['selisih'] += ($val->terkirim * ($val->harga_jual - $val->harga_net - $val->potongan)) - $val->sub_potongan;
                        $data['barang'][$val->no_kwitansi]['omset'] += $val->terkirim * $val->harga_net;
                        $harga_hpp = $data['harga'][$val->id_barang];
                        $data['barang'][$val->no_kwitansi]['hpp'] += $val->terkirim * ($val->harga_net - $harga_hpp);
                    } else {
                        $data['barang'][$val->no_kwitansi]['selisih'] = ($val->terkirim * ($val->harga_jual - $val->harga_net - $val->potongan)) - $val->sub_potongan;
                        $data['barang'][$val->no_kwitansi]['omset'] = $val->terkirim * $val->harga_net;
                        $harga_hpp = $data['harga'][$val->id_barang];
                        $data['barang'][$val->no_kwitansi]['hpp'] = $val->terkirim * ($val->harga_net - $harga_hpp);
                    }
                    //dd($data['barang']);
                }
            }

            $text_gudang = DB::table('tb_gudang as a')
                ->select("*")
                ->get();
            foreach ($text_gudang as $value) {
                $data['text_gudang'][$value->id] = $value->nama_gudang;
            }

            $bulan = array("Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            $data['bulan'] = array();
            for ($i = 5; $i < date('m'); $i++) {
                $data['bulan'][$i] = $bulan[$i];
            }
            $data['tab'] = date('m');

            $data['karyawan'] = array();
            $data['admin'] = array();
            foreach ($d as $value) {
                $data['karyawan'][$value->id] = $value->nama;
            }
            foreach ($d as $value) {
                $data['karyawan2'][$value->id]['nama'] = $value->nama;
                $data['karyawan2'][$value->id]['alamat'] = $value->alamat;
            }
            foreach ($da as $value) {
                $data['admin'][$value->id] = $value->username;
            }
            $data['nama_download'] = "Data Pembayaran";
            if (Auth::user()->level == "5") {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
            } else if (Auth::user()->gudang == "1") {
                $data['gudang'] = $this->model->getGudang();
            } else {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
            }
            $data['status_order'] = DB::table('tb_status_order as a')->select("*")->where("a.status", "aktif")->get();
            $data['nama_download'] = "Data Pembayaran";
            //dd($data);
            return view('DataPembayaran', $data);
        } else {
            return view('Denied');
        }
    }

    public function datapembayaranbulan($bul)
    {
        if (role()) {
            $data['tabs'] = $bul;
            $d = DB::table('tb_karyawan as a')->select("*")->get();
            $da = DB::table('users as a')->select("*")->get();
            if (Auth::user()->level == "5") {
                $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik", "=", Auth::user()->nik)->get();
                $data['pembayaran'] = DB::table('tb_barang_keluar as a')
                    ->select("*")
                    ->where("a.status_barang", "terkirim")
                    ->where("a.pengembang", $p[0]->id)
                    ->whereMonth("a.tanggal_terkirim", $bul)
                    ->groupBy('a.no_kwitansi')
                    ->get();
            } else if (Auth::user()->gudang == "1") {
                $data['pembayaran'] = DB::table('tb_barang_keluar as a')
                    ->select("*")
                    ->where("a.status_barang", "terkirim")
                    ->whereMonth("a.tanggal_terkirim", $bul)
                    ->groupBy('a.no_kwitansi')
                    ->get();
            } else {
                $data['pembayaran'] = DB::table('tb_barang_keluar as a')
                    ->select("*")
                    ->where("a.status_barang", "terkirim")
                    ->where("a.id_gudang", Auth::user()->gudang)
                    ->whereMonth("a.tanggal_terkirim", $bul)
                    ->groupBy('a.no_kwitansi')
                    ->get();
            }


            $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
            foreach ($konsumen as $value) {
                $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
                $data['konsumen'][$value->id]['alamat'] = $value->alamat;
            }
            $detail = DB::table('tb_detail_pembayaran as a')
                ->join('tb_pembayaran as o', 'o.no_kwitansi', '=', 'a.no_kwitansi')
                ->select("*", DB::raw('SUM(a.pembayaran) as pembayaran'))
                ->groupBy('a.no_kwitansi')
                ->get();
            $data['bayar'] = array();
            foreach ($detail as $value) {
                $data['bayar'][$value->no_kwitansi]['bayar'] = $value->pembayaran;
                $data['bayar'][$value->no_kwitansi]['tanggal_bayar'] = $value->tgl_bayar;
                $data['bayar'][$value->no_kwitansi]['penyetor'] = $value->nama_penyetor;
                $data['bayar'][$value->no_kwitansi]['status_pembayaran'] = $value->status_pembayaran;
            }

            $harga = DB::table('tb_harga as a')->select("*")->get();
            foreach ($harga as $value) {
                $data['harga'][$value->id_barang] = $value->harga_hpp;
                $data['harga'][$value->id_barang] = $value->harga_hp;
            }
            //dd($data['harga']);
            $data['barang'] = array();
            $barang = DB::table('tb_detail_barang_keluar as a')
                ->select("*")
                ->get();
            foreach ($barang as $val) {
                if ($val->terkirim < 1) {
                    $terkirim = 1;
                } else {
                    $terkirim = $val->terkirim;
                }
                if ($val->harga_net > ($val->harga_jual - $val->potongan - ($val->sub_potongan / $terkirim))) {
                    if (array_key_exists($val->no_kwitansi, $data['barang'])) {
                        $data['barang'][$val->no_kwitansi]['selisih'] += 0;
                        $data['barang'][$val->no_kwitansi]['omset'] += $val->terkirim * $val->harga_jual;
                        $harga_hpp = $data['harga'][$val->id_barang];
                        $data['barang'][$val->no_kwitansi]['hpp'] += $val->terkirim * ($val->harga_jual - $harga_hpp);
                    } else {
                        $data['barang'][$val->no_kwitansi]['selisih'] = 0;
                        $data['barang'][$val->no_kwitansi]['omset'] = $val->terkirim * $val->harga_jual;
                        $harga_hpp = $data['harga'][$val->id_barang];
                        $data['barang'][$val->no_kwitansi]['hpp'] = $val->terkirim * ($val->harga_jual - $harga_hpp);
                    }
                } else {
                    if (array_key_exists($val->no_kwitansi, $data['barang'])) {
                        $data['barang'][$val->no_kwitansi]['selisih'] += ($val->terkirim * ($val->harga_jual - $val->harga_net - $val->potongan)) - $val->sub_potongan;
                        $data['barang'][$val->no_kwitansi]['omset'] += $val->terkirim * $val->harga_net;
                        $harga_hpp = $data['harga'][$val->id_barang];
                        $data['barang'][$val->no_kwitansi]['hpp'] += $val->terkirim * ($val->harga_net - $harga_hpp);
                    } else {
                        $data['barang'][$val->no_kwitansi]['selisih'] = ($val->terkirim * ($val->harga_jual - $val->harga_net - $val->potongan)) - $val->sub_potongan;
                        $data['barang'][$val->no_kwitansi]['omset'] = $val->terkirim * $val->harga_net;
                        $harga_hpp = $data['harga'][$val->id_barang];
                        $data['barang'][$val->no_kwitansi]['hpp'] = $val->terkirim * ($val->harga_net - $harga_hpp);
                    }
                }
            }
            $text_gudang = DB::table('tb_gudang as a')
                ->select("*")
                ->get();
            foreach ($text_gudang as $value) {
                $data['text_gudang'][$value->id] = $value->nama_gudang;
            }
            $text_gudang = DB::table('tb_gudang as a')
                ->select("*")
                ->get();
            foreach ($text_gudang as $value) {
                $data['text_gudang'][$value->id] = $value->nama_gudang;
            }

            $data['karyawan'] = array();
            $data['admin'] = array();
            foreach ($d as $value) {
                $data['karyawan'][$value->id] = $value->nama;
            }
            foreach ($d as $value) {
                $data['karyawan2'][$value->id]['nama'] = $value->nama;
                $data['karyawan2'][$value->id]['alamat'] = $value->alamat;
            }
            foreach ($da as $value) {
                $data['admin'][$value->id] = $value->name;
            }
            $data['nama_download'] = "Data Pembayaran";
            if (Auth::user()->level == "5") {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
            } else if (Auth::user()->gudang == "1") {
                $data['gudang'] = $this->model->getGudang();
            } else {
                $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id", "=", Auth::user()->gudang)->get();
            }

            $bulan = array("Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            $data['bulan'] = array();
            for ($i = 5; $i < date('m'); $i++) {
                $data['bulan'][$i] = $bulan[$i];
            }
            $data['tab'] = date('m');

            $data['status_order'] = DB::table('tb_status_order as a')->select("*")->where("a.status", "aktif")->get();
            $data['nama_download'] = "Data Pembayaran";
            //dd($data);
            return view('DataPembayaran', $data);
        } else {
            return view('Denied');
        }
    }
}
