<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

function aplikasi()
{
    $data = DB::table('aplikasi as a')->select("*")->get();
    return $data;
}

function getroutename()
{
    return Route::currentRouteName();
}


function persenfee()
{
    $fee = DB::table('persenfee as a')->select("*")->get();
    return $fee;
}

function perseninvestor()
{
    $invest = DB::table('perseninvestor as a')->select("*")->get();
    return $invest;
}

function ribuan($number)
{
    $hasil = number_format($number, 0, ',', '.');
    return $hasil;
}

function rupiah($angka)
{
    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}
function tanggal($angka)
{
    if ($angka != "" && $angka != null) {
        $hasil = date("d-m-Y", strtotime($angka));
        return $hasil;
    } else {
        return "";
    }
}

function geticon()
{
    $data = DB::table('aplikasi as a')->select("*")->orderBy("id", 'DESC')->limit(1)->get();
    return $data;
}

function getKodeReferal()
{
    $data = DB::table('tb_karyawan as a')->select("kode_referal")->where("nik", Auth::user()->nik)->get();
    return $data[0]->kode_referal;
}

function status_konsumen($i)
{
    $data = array("None", "Retail", "Reseller", "Agen", "Distributor", "Pengembang");
    return $data[$i];
}

function status_konsumen_all()
{
    $data = array("Retail", "Reseller", "Agen", "Distributor", "Pengembang");
    return $data;
}

function kategoritrip($idx)
{
    $trip[1] = "Non Insentif";
    $trip[2] = "Sales Marketing";
    $trip[3] = "Membership";
    return $trip[$idx];
}

function getnamegudang($idx)
{
    $data = DB::table('tb_gudang as a')->select("*")->get();
    $gdg = array();
    foreach ($data as $v) {
        $gdg[$v->id] = $v->nama_gudang;
    }
    return $gdg[$idx];
}

function removedot($string)
{
    $string = str_replace('.', ',', $string);
    return $string;
}

function role()
{
    $data = DB::table('tb_level as a')->select("*")->where("a.id", Auth::user()->level)->get();
    $url = Route::currentRouteName();

    $akses = explode(",", $data[0]->akses);
    //dd($url);
    if (in_array($url, $akses)) {
        $hasil = true;
    } else {
        $hasil = false;
    }
    //dd($hasil);
    return $hasil;
}
function previllage($key)
{
    $previllage = DB::table('tb_previllage as a')->select("a.*")->where('a.id_gudang', $key)->get();
    if (count($previllage) > 0) {
        $hasil = true;
    } else {
        $hasil = false;
    }
    return $hasil;
}

function allprevillage()
{
    $previllage = DB::table('tb_previllage as a')->select("a.*")->get();
    $hasil = "";
    foreach ($previllage as $key => $value) {
        $hasil .= $value->id_gudang . ",";
    }
    return $hasil;
}

function saldo()
{
    $data = DB::table('tb_investor as a')->select("saldo")->where("nik", Auth::user()->nik)->get();
    if (count($data) > 0) {
        return $data['0']->saldo;
    } else {
        return false;
    }
}

function saldokaryawan()
{
    //$data = DB::table('tb_karyawan as a')->select("saldo")->where("nik",Auth::user()->nik)->get();
    $p = DB::table('tb_karyawan as a')->select("*")->where("a.nik", Auth::user()->nik)->get();
    $insentif = DB::table('tb_insentif as a')
        ->select("*")
        ->where("a.id_karyawan", $p[0]->id)
        ->where("a.status", "aktif")
        ->where("a.id_karyawan", '<>', '22')
        ->get();
    $insentif2 = DB::table('tb_pengembangan as a')
        ->select("*")
        ->where("a.id_karyawan", $p[0]->id)
        ->where("a.status", "aktif")
        ->get();
    $saldo = 0;
    foreach ($insentif as $key => $value) {
        if ($value->jenis == "Trip" || $value->jenis == "Revisi Penambahan Insentif" || $value->jenis == "Bagi Hasil HPP" || $value->jenis == "Fee Transfer Insentif" || $value->jenis == "Bagi Hasil Stokis") {
            $saldo += $value->jumlah;
        }
        if ($value->jenis == "Potongan Insentif" || $value->jenis == "Pengambilan Insentif" || $value->jenis == "Potongan Administrasi" || $value->jenis == "Revisi Pengurangan Insentif") {
            $saldo -= $value->jumlah;
        }
    }
    foreach ($insentif2 as $key => $value) {
        if ($value->jenis == "Trip" || $value->jenis == "Revisi Penambahan Insentif" || $value->jenis == "Bagi Hasil HPP" || $value->jenis == "Fee Transfer Insentif") {
            $saldo += $value->jumlah;
        }
        if ($value->jenis == "Potongan Insentif" || $value->jenis == "Pengambilan Insentif" || $value->jenis == "Potongan Administrasi" || $value->jenis == "Revisi Pengurangan Insentif") {
            $saldo -= $value->jumlah;
        }
    }
    $data['saldo'] = $saldo;
    DB::table('tb_karyawan as a')->where("nik", Auth::user()->nik)->update($data);
    return $saldo;
}

function saldomas()
{
    //$data = DB::table('tb_karyawan as a')->select("saldo")->where("nik",Auth::user()->nik)->get();
    $p = DB::table('tb_karyawan as a')->select("*")->where("a.nik", Auth::user()->nik)->get();
    $insentif = DB::table('tb_pengembangan as a')
        ->select("*")
        ->where("a.id_karyawan", '1')
        ->where("a.status", "aktif")
        ->orWhere("a.nama_karyawan", "Pengembangan Sistem")
        ->where("a.status", "aktif")
        ->get();
    $saldo = 0;
    foreach ($insentif as $key => $value) {
        if ($value->jenis == "Trip" || $value->jenis == "Revisi Penambahan Insentif" || $value->jenis == "Bagi Hasil HPP" || $value->jenis == "Fee Transfer Insentif") {
            $saldo += $value->jumlah;
        }
        if ($value->jenis == "Potongan Insentif" || $value->jenis == "Pengambilan Insentif" || $value->jenis == "Potongan Administrasi" || $value->jenis == "Revisi Pengurangan Insentif") {
            $saldo -= $value->jumlah;
        }
    }
    $data['saldo'] = $saldo;
    $x = DB::table('tb_karyawan as a')->where("nik", Auth::user()->nik)->update($data);
    //if ($x) {
    return $saldo;
    //}else{
    //  return 0;
    //}
}

function cek_penukaranhadiah()
{
    $data = DB::table('tb_hadiah_konsumen')->where('status', 'pending')->get();
    return count($data);
}

function cekmyid_investor()
{
    $data = DB::table('tb_investor as a')->select("id")->where("nik", Auth::user()->nik)->get();
    if (count($data) > 0) {
        return $data['0']->id;
    } else {
        return 0;
    }
}

function cekretail($no_hp)
{
    $data = DB::table('members as a')->select("id")->where("no_hp", $no_hp)->get();
    if (count($data) > 0) {
        return true;
    } else {
        return false;
    }
}

function cekmyid_karyawan()
{
    $data = DB::table('tb_karyawan as a')->select("id")->where("nik", Auth::user()->nik)->get();
    return $data['0']->id;
}

function cekmyname_karyawan()
{
    $data = DB::table('tb_karyawan as a')->select("nama")->where("nik", Auth::user()->nik)->get();
    return $data['0']->nama;
}
function cek_notif($key)
{
    $data = DB::table('tb_transaksi as a')->select("*")->where("status", 'pending')->where("jenis", $key)->get();
    return count($data);
}
function cek_insentif($key)
{
    $data = DB::table('tb_insentif as a')->select("*")->where("status", 'pending')->where("jenis", $key)->get();
    return count($data);
}
function cek_insentifmas($key)
{
    $data = DB::table('tb_pengembangan as a')->select("*")->where("status", 'pending')->where("jenis", $key)->get();
    return count($data);
}
function cek_investasi_lokal_pending()
{
    $data = DB::table('tb_pengadaan_investasi as a')->select("*")->whereNull("status")->whereNotNull("id_pengambil")->get();
    return count($data);
}
function cek_investasi_lokal_selesai()
{
    $data = DB::table('tb_pengadaan_investasi as a')->select("*")->where("status", "proses")->get();
    $jm = 0;
    foreach ($data as $key => $value) {
        $OldDate = new DateTime($value->tanggal_proses);
        $now = new DateTime(Date('Y-m-d'));
        $ava = $OldDate->diff($now);
        if (($value->estimasi_waktu - $ava->days) < 1) {
            $jm += 1;
        }
    }
    return $jm;
}
function cek_investasi_prv_pending()
{
    $data = DB::table('tb_pengadaan_investasi_jkt as a')->select("*")->whereNull("status")->whereNotNull("id_pengambil")->get();
    return count($data);
}
function cek_investasi_prv_selesai()
{
    $data = DB::table('tb_pengadaan_investasi_jkt as a')->select("*")->where("status", "proses")->get();
    $jm = 0;
    foreach ($data as $key => $value) {
        $OldDate = new DateTime($value->tanggal_proses);
        $now = new DateTime(Date('Y-m-d'));
        $ava = $OldDate->diff($now);
        if (($value->estimasi_waktu - $ava->days) < 1) {
            $jm += 1;
        }
    }
    return $jm;
}

function cek_bagi_lock()
{
    date_default_timezone_set('Asia/Jakarta');
    $data = DB::table('tb_lock_investasi')->select("*")
        ->whereDate("next_bagi", "<=", date('Y-m-d'))
        ->where("status", "lock")->get();
    return count($data);
}

function cek_lock($id)
{
    $data = DB::table('tb_lock_investasi')->select(DB::raw('SUM(jumlah_lock) as jumlah_lock'))
        ->where("id_investor", $id)
        ->where("status", "lock")->get();
    if ($data[0]->jumlah_lock > 0) {
        return $data[0]->jumlah_lock;
    } else {
        return 0;
    }
}

function cek_lock2($id)
{
    $data = DB::table('tb_lock_investasi_2')->select(DB::raw('SUM(jumlah_lock) as jumlah_lock'))
        ->where("id_investor", $id)
        ->where("status", "lock")->get();
    return $data[0]->jumlah_lock;
}

function cek_semualock($id)
{
    if (Auth::user()->level == "4") {
        $a = DB::table('tb_lock_investasi')->select(DB::raw('SUM(jumlah_lock) as jumlah_lock'))
            ->where("status", "lock")->get();
    } else {
        $a = DB::table('tb_lock_investasi')->select(DB::raw('SUM(jumlah_lock) as jumlah_lock'))
            ->where("id_investor", $id)->where("status", "lock")->get();
    }
    return $a[0]->jumlah_lock;
}

function cekpengembanginvestor()
{
    $data = DB::table('tb_karyawan')->select("*")
        ->where("nik", Auth::user()->nik)->where("status", "aktif")->get();
    return count($data);
}

function cek_investor_punya_pengembang()
{
    $data = DB::table('tb_investor')->select("*")->where("nik", Auth::user()->nik)->whereNotNull("pengembang")->get();
    return count($data);
}

function format_link($string)
{
    $hasil = str_replace(' ', '-', $string);
    $hasil = str_replace('/', '', $hasil);
    $hasil = str_replace('(', '', $hasil);
    $hasil = str_replace(')', '', $hasil);
    $hasil = str_replace('.', '', $hasil);
    $hasil = str_replace(',', '', $hasil);
    return strtolower($hasil);
}

function un_format_link($string)
{
    $hasil = str_replace('-', ' ', $string);
    return $hasil;
}

function kategori_hits()
{
    $data = DB::table('kt_kategori as a')->select("*")->where("status", "aktif")->orderBy("a.clicked", "DESC")->limit(10)->get();
    return $data;
}

function kategori()
{
    $data = DB::table('kt_kategori as a')->select("*")->where("status", "aktif")->get();
    return $data;
}

function kategorijasa()
{
    $data = DB::table('kb_kategori_jasa as a')->select("*")->where("status", "aktif")->get();
    return $data;
}

function pencarian_terfavorit()
{
    $data = DB::table('kt_pencarian')->orderBy("clicked", "DESC")->limit(5)->get();
    return $data;
}

function cekambilinsentif($id)
{
    $data = DB::table('tb_insentif as a')->select("*")->where("jenis", "Pengambilan Insentif")->where("status", "pending")->where("id_karyawan", $id)->get();
    return $data;
}

function cekambilinsentifmas($id)
{
    $data = DB::table('tb_pengembangan as a')->select("*")->where("jenis", "Pengambilan Insentif")->where("status", "pending")->where("id_karyawan", $id)->get();
    return $data;
}

function cektarik($id)
{
    $data = DB::table('tb_transaksi as a')->select("*")->where("jenis", "out")->whereNull("tgl_verifikasi")->where("id_investor", $id)->get();
    if (count($data) > 0) {
        return true;
    } else {
        return false;
    }
}

function toRight()
{
    $c = "&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;";
    return $c;
}


function reloadpromo()
{
    $data['status'] = "selesai";
    $promo = DB::table('tb_promo')
        ->whereDate('end', '<', date('Y-m-d'))
        ->whereNull('status')
        ->update($data);
    $promo2 = DB::table('tb_voucher')
        ->whereDate('end', '<', date('Y-m-d'))
        ->whereNull('status')
        ->update($data);
    return $promo;
}


function cekrijectstok($id_barang)
{
    $data = DB::table('tb_ as a')
        ->join('tb_reject as b', 'b.no_reject', '=', 'a.no_reject')
        ->select("*")
        ->where("b.status", "pending")
        ->where("b.id_barang", $id_barang)
        ->get();
}

function cek_kas_ditangan()
{
    $data = DB::table('tb_kas_ditangan')->select("*")->where("status", "aktif")->get();
    $hasil = 0;
    foreach ($data as $key => $value) {
        if ($value->jenis == "in" && $value->exception != "on") {
            $hasil += $value->jumlah;
        } else if ($value->jenis == "out" && $value->exception != "on") {
            $hasil -= $value->jumlah;
        }
    }
    if ($hasil < 1) {
        $hasil = 0;
    }
    return $hasil;
}

function cek_kas_dibank()
{
    $data = DB::table('tb_kas_dibank')->select("*")->where("status", "aktif")->get();
    $hasil = 0;
    foreach ($data as $key => $value) {
        if ($value->jenis == "in") {
            $hasil += $value->jumlah;
        } else if ($value->jenis == "out") {
            $hasil -= $value->jumlah;
        }
    }
    if ($hasil < 1) {
        $hasil = 0;
    }
    return $hasil;
}

function saldo_pengadaan()
{
    $data = DB::table('tb_lock_investasi_2 as a')->select("jumlah_lock")->where("id_investor", cekmyid_investor())->where("status", 'lock')->get();
    if (count($data) > 0) {
        $jml_lock = 0;
        foreach ($data as $cv) {
            $jml_lock += $cv->jumlah_lock;
        }
        return $jml_lock;
    } else {
        return false;
    }
}

function pengadaan_berjalan()
{
    $data = DB::table('tb_pengadaan_barang as a')
        ->select("jumlah_investasi")
        ->where("id_pengambil", Auth::user()->id)
        ->where("status", 'proses')
        ->get();
    if (count($data) > 0) {
        $jml_lock = 0;
        foreach ($data as $cv) {
            $jml_lock += $cv->jumlah_investasi;
        }
        return $jml_lock;
    } else {
        return false;
    }
}

function jumlahorderanonlineshop()
{
    $order_ol = DB::table('tb_barang_keluar as a')
        ->where("a.status", "=", "aktif")
        ->where("a.status_barang", "=", "pending")
        ->where("a.id_gudang", "=", '1')
        ->where("a.step", ">", '1')
        ->orderBy("a.tanggal_order", "ASC")
        ->get();
    return count($order_ol);
}

function jumlahmanualpayment()
{
    $order_ol = DB::table('kt_rekap_pembayaran as a')
        ->whereNotNull("bukti")
        ->where("a.cluster", "=", "manual")
        ->where('a.transaction_status', "pending")
        ->get();
    return count($order_ol);
}

function jumlahinputresi()
{
    $order_ol = DB::table('tb_barang_keluar as a')
        ->where("a.status", "=", "aktif")
        ->where("a.status_barang", "=", "proses")
        ->whereNull("a.no_resi")
        ->where("a.id_gudang", "=", '1')
        ->where("a.step", ">", '1')
        ->orderBy("a.tanggal_order", "ASC")
        ->get();
    return count($order_ol);
}

function variableupah()
{
    $data = DB::table('pay_upah_kategori_kerja')->get();
    $a = array();
    foreach ($data as $key => $value) {
        $a[$value->status_pekerja]['Shift 1'] = $value->shift1;
        $a[$value->status_pekerja]['Shift 2'] = $value->shift2;
        $a[$value->status_pekerja]['lembur'] = $value->lembur;
    }
    return $a;
}

function variableupahborongan()
{
    $data = DB::table('pay_upah_satuan_barang')->get();
    $a = array();
    foreach ($data as $key => $value) {
        $a[strtolower($value->status_pekerja)][$value->no_id_pekerjaan] = $value->harga_satuan;
    }
    return $a;
}

function harian($params)
{
    $array = array("", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu");
    return $array[$params];
}


function persentase_pengadaan()
{
    $data = DB::table('tb_lock_investasi_2 as a')->select("durasi")->where("id_investor", cekmyid_investor())->where("status", 'lock')->get();
    if (count($data) > 0) {
        if ($data['0']->durasi == 12) {
            return 1;
        } else if ($data['0']->durasi == 6) {
            return 0.85;
        } else if ($data['0']->durasi == 3) {
            return 0.7;
        }
    } else {
        return 0;
    }
}

function prosespengadaaninvestasi()
{
    $pengadaan_proses = DB::table('tb_pengadaan_barang as a')
        ->select("*")
        ->whereNotNull('a.tgl_ambil')
        ->whereNotNull('a.id_pengambil')
        ->whereNull('a.active')
        ->where('a.status', 'proses')
        ->get();
    foreach ($pengadaan_proses as $key => $value) {
        $date = new DateTime($value->tgl_ambil);
        $date->modify("+" . $value->estimasi_waktu . " day");
        $temp = $date->format("Y-m-d");
        $OldDate = new DateTime($value->tgl_ambil);
        $now = new DateTime(Date('Y-m-d'));
        $ava = $OldDate->diff($now);

        if (($value->estimasi_waktu - $ava->days < 1)) {

            $data['status'] = "selesai";
            $query = DB::table('tb_pengadaan_barang')->where('id', $value->id)->update($data);

            if ($query) {
                $d = DB::table('tb_pengadaan_barang as a')
                    ->join('users as b', 'b.id', '=', 'a.id_pengambil')
                    ->join('tb_investor as c', 'c.nik', '=', 'b.nik')
                    ->select("a.*", "c.id as id_inves", "c.saldo as saldo_inves", "c.nik", "c.nama_investor", "c.pengembang", "c.leader")->where('a.id', '=', $value->id)->get();

                if ($d[0]->pengembang != "") {
                    $estimasi_pendapatan = perseninvestor()[0]->pengadaanLS12 / 100 * $d['0']->estimasi_pendapatan;
                } else {
                    $estimasi_pendapatan = $d['0']->estimasi_pendapatan;
                }


                //$x['saldo'] = $d['0']->saldo_inves + $estimasi_pendapatan + $d['0']->jumlah_investasi;
                $x['saldo'] = $d['0']->saldo_inves + $estimasi_pendapatan;
                DB::table('tb_investor')->where('nik', '=', $d['0']->nik)->update($x);

                $y['id_investor'] = $d['0']->id_inves;
                $y['jumlah'] = $d['0']->jumlah_investasi;
                $y['saldo_temp'] = $d['0']->saldo_inves + $d['0']->jumlah_investasi;
                $y['jenis'] = "selesai";
                $y['id_pengadaan'] = $d['0']->id;
                $y['id_barang'] = $d['0']->id_barang;
                $y['jumlah_barang'] = $d['0']->jumlah_kulakan;
                $y['admin'] = $d['0']->admin_proses;
                DB::table('tb_transaksi')->insert($y);

                $c['id_investor'] = $d['0']->id_inves;
                $c['jumlah'] = $estimasi_pendapatan;
                $c['saldo_temp'] = $x['saldo'];
                $c['jenis'] = "bagi";
                $c['id_pengadaan'] = $d['0']->id;
                $c['id_barang'] = $d['0']->id_barang;
                $c['jumlah_barang'] = $d['0']->jumlah_kulakan;
                $c['admin'] = $d['0']->admin_proses;
                DB::table('tb_transaksi')->insert($c);

                $barang = DB::table('tb_barang')->select("*")->where('id', $d['0']->id_barang)->get();

                $dlr = DB::table('tb_labarugi')->select("*")->where('status', 'aktif')->orderBy("id", "DESC")->limit(1)->get();
                $lr['jumlah'] = $estimasi_pendapatan;
                if (count($dlr) > 0) {
                    $lr['saldo_temp'] = $dlr['0']->saldo_temp + $estimasi_pendapatan;
                } else {
                    $lr['saldo_temp'] = $estimasi_pendapatan;
                }
                $lr['jenis'] = "out";
                $lr['nama_jenis'] = "Bagi Hasil Pengadaan - (" . $y['jumlah_barang'] . ") " . $barang[0]->nama_barang;
                $lr['admin'] = Auth::user()->id;
                $lr['keterangan'] = "- " . $d['0']->nama_investor;
                DB::table('tb_labarugi')->insert($lr);


                if ($d[0]->pengembang != "") {
                    $d_pengembang_investor = DB::table('tb_investor')->select("*")->where("id", $d[0]->pengembang)->get();
                    $bagi_pengembang_investor = perseninvestor()[0]->pengadaan_P / 100 * $d['0']->estimasi_pendapatan;
                    DB::table('tb_investor')->where('id', $d[0]->pengembang)->increment('saldo', $bagi_pengembang_investor);

                    $pengembang_investor['id_investor'] = $d[0]->pengembang;
                    $pengembang_investor['jumlah'] = $bagi_pengembang_investor;
                    $pengembang_investor['saldo_temp'] = $d_pengembang_investor[0]->saldo + $bagi_pengembang_investor;
                    $pengembang_investor['jenis'] = "bagipengembang";
                    $pengembang_investor['id_pengadaan'] = $d['0']->id;
                    $pengembang_investor['id_barang'] = $d['0']->id_barang;
                    $pengembang_investor['jumlah_barang'] = $d['0']->jumlah_kulakan;
                    $pengembang_investor['admin'] = $d['0']->admin_proses;
                    $pengembang_investor['keterangan'] = $d['0']->nama_investor;
                    DB::table('tb_transaksi')->insert($pengembang_investor);

                    $dlr_pengembang = DB::table('tb_labarugi')->select("*")->where('status', 'aktif')->orderBy("id", "DESC")->limit(1)->get();
                    $lr_pengembang['jumlah'] = $bagi_pengembang_investor;
                    $lr_pengembang['saldo_temp'] = $dlr_pengembang['0']->saldo_temp + $bagi_pengembang_investor;
                    $lr_pengembang['jenis'] = "out";
                    $lr_pengembang['nama_jenis'] = "Bagi Hasil Pengadaan Pengembang";
                    $lr_pengembang['admin'] = Auth::user()->id;
                    $lr_pengembang['keterangan'] = "(" . $d['0']->nama_investor . ") - " . $d_pengembang_investor['0']->nama_investor;
                    DB::table('tb_labarugi')->insert($lr_pengembang);
                }

                if ($d[0]->leader != "") {
                    $d_leader_investor = DB::table('tb_investor')->select("*")->where("id", $d[0]->leader)->get();

                    $bagi_leader_investor = perseninvestor()[0]->pengadaan_L / 100 * $d['0']->estimasi_pendapatan;
                    DB::table('tb_investor')->where('id', $d[0]->leader)->increment('saldo', $bagi_leader_investor);

                    $leader_investor['id_investor'] = $d[0]->leader;
                    $leader_investor['jumlah'] = $bagi_leader_investor;
                    $leader_investor['saldo_temp'] = $d_leader_investor[0]->saldo + $bagi_leader_investor;
                    $leader_investor['jenis'] = "bagileader";
                    $leader_investor['id_pengadaan'] = $d['0']->id;
                    $leader_investor['id_barang'] = $d['0']->id_barang;
                    $leader_investor['jumlah_barang'] = $d['0']->jumlah_kulakan;
                    $leader_investor['admin'] = $d['0']->admin_proses;
                    $leader_investor['keterangan'] = $d['0']->nama_investor;
                    DB::table('tb_transaksi')->insert($leader_investor);

                    $dlr_leader = DB::table('tb_labarugi')->select("*")->where('status', 'aktif')->orderBy("id", "DESC")->limit(1)->get();
                    $lr_leader['jumlah'] = $bagi_leader_investor;
                    $lr_leader['saldo_temp'] = $dlr_leader['0']->saldo_temp + $bagi_leader_investor;
                    $lr_leader['jenis'] = "out";
                    $lr_leader['nama_jenis'] = "Bagi Hasil Pengadaan Leader";
                    $lr_leader['admin'] = Auth::user()->id;
                    $lr_leader['keterangan'] = "(" . $d['0']->nama_investor . ") - " . $d_leader_investor['0']->nama_investor;
                    DB::table('tb_labarugi')->insert($lr_leader);
                }
            }
        }
    }
}
