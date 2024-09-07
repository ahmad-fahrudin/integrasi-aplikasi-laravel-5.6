<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Cetak Surat Jalan</title>
	<link rel="icon" href="gambar/<?=aplikasi()[0]->favicon?>" sizes="32x32" />
  <link href="<?php echo asset('system/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <style type="text/css" media="print">

		@media screen {
			div#footer_wrapper {
				display: none;
			}
			div.footer {
					display: none;
			}
		}

    @media print and (width: 21.5cm) and (height: 14cm) {
        @page {
           margin: 0cm;
        }

				div#footer_wrapper {
					margin: 0px 2px 0px 70px;
					position: fixed;
					bottom: 0;
				}

    }

    @page {
       size: B5 potrait;
    }
  </style>
   <style>
       .plugin-details {
           display: none;
       }

       .plugin-details-active {
           display: block;
       }
        body {background:#eee;}
        .container {background:#fff;}
        html {zoom: 80%;}
		.modal-backdrop {
		  width: 100% !important;
		  height: 100% !important;
		}
   </style>
</head>
<style>
table#tbl {
    margin: auto;
    width: calc(100% - 40px);
}
table {
    margin: auto;
    width: calc(100% - 40px);
}
div.b {
  white-space: nowrap;
  width: 350px;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
<div class="container" style="background-color:white;">
  <div id='printMe'>
		<?php
		$c = 0;
		$total_keseluruhan = 0;
		for ($v=0; $v < $page; $v++) { ?>
		  <table>
      <tr>
        <td width="58%">
          <img src="<?php echo asset('gambar/'.aplikasi()[0]->icon); ?>" width="250" alt="homepage" />
          <div class="col-md-9" style="letter-spacing:1px;font-size:16px">
						<?php if(isset($alamat)) {foreach ($alamat as $value):
							$texts=str_ireplace('<p>','',$value->alamat);
							$texts=str_ireplace('</p>','',$texts); ?>
								Alamat: {{$texts}}
						<?php
						if(isset($value->kecamatan)){ echo " ".$data_kecamatan[$value->kecamatan].","; }
						if(isset($value->kabupaten)){ echo " ".$data_kabupaten[$value->kabupaten]."."; }
					endforeach; } ?>
					{{$value->no_hp}}
    			</div>
        </td>

        <td align="right">
          <h4><b>SURAT JALAN KEUANGAN</b></h4>
					<h5 style="font-size:28px">{{$surat[0]->no_trip}}</h5>
        </td>
      </tr>
    </table>
<hr>
<table>
  <tr>
    <td width="65%">
			<table style="font-size:28px">
				<tr>
					<td>Tanggal : {{tanggal($surat[0]->tanggal_input)}}</td>
					<td></td>
				</tr>
				<tr>
					<td>Kategori Penjualan : {{$kategori[$surat[0]->kategori]}}</td>
					<td></td>
				</tr>
				<tr>
					<td>Gudang : {{$gudang[$surat[0]->id_gudang]}}</td>
					<td></td>
				</tr>
			</table>
    </td>
    <td>
      <b style="font-size:28px">Petugas:</b>
      <table style="font-size:28px">
				<tr>
          <td>Driver : <?php if(isset($karyawan[$surat[0]->driver])){ ?>{{$karyawan[$surat[0]->driver]}} <?php } ?></td>
          <td></td>
        </tr>
        <tr>
          <td>QC : {{$karyawan[$surat[0]->qc]}}</td>
          <td></td>
        </tr>
				<tr>
          <td>Admin : {{$admin[$surat[0]->admin]}}</td>
          <td></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
  <hr>
  <div class="col-md-12">
    <table id="tbl" style="font-size:28px;">
      <tr style="border-bottom:1px solid #eee">
        <td><b>No Kwitansi</b></td>
        <td align="left"><b>Nama Member</b></td>
        <!--td><b>Alamat</b></td-->
        <td align="right"><b>Penjualan</b></td>
        <td align="right"><b>Ongkir</b></td>
	  </tr>
      <?php $total=0; $y=0; $a = 0; foreach ($surat as $key => $value):
				$a++;
				$cek = (($v + 1) * 28) + 1;
				if ($a < $cek && $a > $c) { $y++;
					$text=str_ireplace('<p>','',$konsumen[$value->id_konsumen]['alamat']);
	        $text=str_ireplace('</p>','',$text);
					$total+=$value->sub_total;
					$total_keseluruhan+=$value->sub_total;
					
					?>
	        <tr style="border-bottom:1px solid #eee">
	          <td align="left">{{$value->no_kwitansi}}</td>
	          <td align="left">{{$konsumen[$value->id_konsumen]['nama']}}</td>
	          <!--td align="left"><?=$text?></td-->
	          <td align="right">{{ribuan($value->sub_total)}}</td>
	          <td align="right"><?php if(isset($ongkir[$value->no_kwitansi])){ $total_keseluruhan+=$ongkir[$value->no_kwitansi]; echo $ongkir[$value->no_kwitansi]; }else{ echo 0;} ?></td>
	        </tr>
				<?php }
       endforeach; ?>
			<tr>
				<td colspan="2" align="right"><b>Jumlah Penjualan&emsp;</b></td>
				<td align="right"><b>{{ribuan($total)}}</b></td>
			</tr>

			<?php if (($page - 1) == $v): ?>
				<tr>
					<td colspan="2" align="right"><b>Total Pembayaran &emsp;</b></td>
					<td align="right"><b>{{ribuan($total_keseluruhan)}}</b></td>
				</tr>
			<?php endif; ?>

    </table>
		<?php for ($i=0; $i < (28 - $y); $i++) {
			echo "<br>";
		} ?>
    <br><br><br>
    <table style="font-size:28px">
			<!--td>Tanggal Kirim: <b>{{tanggal($value->tanggal_input)}}</b><br><br><br><br></td-->
			<td><center><b>Admin Keuangan</b></center>
				<br>
				<center>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</center></td>
			<td><center><b>QC</b></center>
				<br>
				<center>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</center></td>
			<td><center><b>Driver</b></center>
				<br>
				<center>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</center></td>
		</table>
  </div>
<?php $c += 28; } ?>
</div>

<br><br><br>
<center><button class="btn btn-success" onclick="printDiv('printMe')">Cetak</button>
				<button class="btn btn-primary" onclick="BackTo()">Batal</button></center>
<br><br><br>

<script>
		function printDiv(divName){
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
		}
    function BackTo(){
      window.close();
    }
	</script>
</body>
</html>
