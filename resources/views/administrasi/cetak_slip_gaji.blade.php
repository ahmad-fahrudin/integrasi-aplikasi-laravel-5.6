<?php 
//dd($karyawan);
?>
<html dir="ltr" lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Cetak Slip Gaji</title>
    <style>
        body {background:#eee;}
        .container {background:#fff;}
        html {zoom: 80%;}
		.modal-backdrop {
		 width: 100% !important;
		 height: 100% !important;
		}
    </style>
    <link rel="stylesheet" href="<?=asset('sim/css/slim.css')?>">
</head>
<body>
<div class="slim-mainpanel">
<div class="container"  style="max-width:700px">
<table width="100%">
<tr>
<td colspan="2">
<img src="{{url('/img/logovri.webp')}}" width="200px" style="padding:10px"><br>
Alamat: xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
</td>
<td colspan="2" align="right" style="letter-spacing:1px;">
    <h4>SLIP GAJI</h4>
</td>
</tr>
</table>
<hr>
<div class="slim-pageheader">
<table width="100%">
    <tr>
        <td colspan="4"><b>Periode Penggajian</b> {{$slip[0]->mulai}} - {{$slip[0]->sampai}}</td>
    </tr>
    <tr>
        <td colspan="2"><b><br>Karyawan</b></td>
        <td colspan="2"><b>Pendapatan</b></td>
    </tr>
    <tr>
        <td>No. ID Karyawan</td>
        <td>{{$karyawan[0]->id_karyawan}}</td>
        <td>Gaji Pokok</td>
        <td style="text-align: right;">
            <?php if(($slip[0]->gaji_pokok) > 0){ ?>
            {{ribuan($slip[0]->gaji_pokok)}}
            <?}else{?>
            0
            <?php } ?>
            </td>
    </tr>
    <tr>
        <td>Nama Karyawan</td>
        <td>{{$karyawan[0]->nama_karyawan}}</td>
        <td>Upah Kinerja</td>
        <td style="text-align: right;">
            <?php if(($slip[0]->upah_kinerja) > 0){ ?>
            {{ribuan($slip[0]->upah_kinerja)}}
            <?}else{?>
            0
            <?php } ?>
            </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td hidden>Alamat</td>
        <td hidden>{{$karyawan[0]->alamat_karyawan}}</td>
        <td>Bonus Kehadiran</td>
        <td style="text-align: right;">
            <?php if(($slip[0]->bonus_kehadiran) > 0){ ?>
            {{ribuan($slip[0]->bonus_kehadiran)}}
            <?}else{?>
            0
            <?php } ?>
            </td>
    </tr>
    <tr>
        <td><b>Absensi</b></td>
        <td></td>
        <td hidden>No. HP</td>
        <td hidden>{{$karyawan[0]->no_hp}}</td>
        <td>Bonus kinerja</td>
        <td style="text-align: right;">
            <?php if(($slip[0]->bonus_kinerja) > 0){ ?>
            {{ribuan($slip[0]->bonus_kinerja)}}
            <?}else{?>
            0
            <?php } ?>
            </td>
    </tr>
    <tr>
        <td>Masuk</td>
        <td>{{$slip[0]->masuk}}</td>
        <td hidden>No. Rekening</td>
        <td hidden>{{$karyawan[0]->nama_bank}} ({{$karyawan[0]->no_rekening}})</td>
        <td>{{$slip[0]->ketpendapatanlain1}}</td>
        <td style="text-align: right;">{{ribuan($slip[0]->valpendapatanlain1)}}</td>
    </tr>
    <tr>
        <td>Tidak masuk</td>
        <td>{{($slip[0]->sakit)+($slip[0]->izin)+($slip[0]->alfa)}}</td>
        <td hidden>Status Pekerja</td>
        <td hidden>{{$karyawan[0]->status_pekerja}}</td>
        <td>{{$slip[0]->ketpendapatanlain2}}</td>
        <td style="text-align: right;">{{ribuan($slip[0]->valpendapatanlain2)}}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>{{$slip[0]->ketpendapatanlain3}}</td>
        <td style="text-align: right;">{{ribuan($slip[0]->valpendapatanlain3)}}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        
    </tr>
    
    <tr>
        <td>Prosentase Kinerja </td>
        <td>{{round($slip[0]->rata_rata_prosentase)}}%</td>
        <td><b><br>Potongan</b></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>Potongan Gaji Pokok</td>
        <td style="text-align: right;">
            <?php if(($slip[0]->potongan_gaji_pokok) > 0){ ?>
            {{ribuan($slip[0]->potongan_gaji_pokok)}}
            <?}else{?>
            0
            <?php } ?>
            </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td hidden>Izin</td>
        <td hidden>{{$slip[0]->izin}}</td>
        <td>Bpjs Kesehatan</td>
        <td style="text-align: right;">
            <?php if(($slip[0]->bpjs_kesehatan) > 0){ ?>
            {{ribuan($slip[0]->bpjs_kesehatan)}}
            <?}else{?>
            0
            <?php } ?>
            </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td hidden>Alfa</td>
        <td hidden>{{$slip[0]->alfa}}</td>
        <td>Bpjs Ketenagakerjaan</td>
        <td style="text-align: right;">
            <?php if(($slip[0]->bpjs_ketenagakerjaan) > 0){ ?>
            {{ribuan($slip[0]->bpjs_ketenagakerjaan)}}
            <?}else{?>
            0
            <?php } ?>
            </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td hidden>Rolling </td>
        <td hidden>{{$slip[0]->rolling}}</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td hidden>Libur </td>
        <td hidden>{{$slip[0]->libur}}</td>
        <td>{{$slip[0]->ketpotonganlain1}}</td>
        <td style="text-align: right;">{{ribuan($slip[0]->valpotonganlain1)}}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td hidden>Terlambat Masuk </td>
        <td hidden>{{$slip[0]->terlambat}}</td>
        <td>{{$slip[0]->ketpotonganlain2}}</td>
        <td  style="text-align: right;">{{ribuan($slip[0]->valpotonganlain2)}}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td hidden>Pulang Cepat</td>
        <td hidden>{{$slip[0]->pulang_cepat}}</td>
        <td>{{$slip[0]->ketpotonganlain3}}</td>
        <td style="text-align: right;">{{ribuan($slip[0]->valpotonganlain3)}}</td>
    </tr>
    <tr>
        <td><br></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <br><br>
    <tr>
        <td></td><td></td>
        <td style="font-weight:bold">Total Penerimaan&emsp;&emsp;</td>
        <td style="text-align: right;font-weight:bold">{{ribuan($slip[0]->total_gaji)}}</td>
    </tr>
    <tr>
        <td colspan="2"><br><center>Admin</center><br><br><br><center>( {{Auth::user()->name}} )</center></td>
        <td colspan="2"><br><center>Penerima</center><br><br><br><center>(_____________)</center></td>
    </tr>
    
    
</table>
</div>
</div>
</div>
<script>
window.print();
window.onafterprint = function() {
    //window.close();
}
</script>
</body>
</html>