<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Transaksi Belanja</title>
	<link rel="shortcut icon" type="image/png" href="/media/images/favicon.png">
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
       size: B5 landscape;
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
table {
    margin: 0;
		padding: 0;
    width: calc(100% - 10px);
}
hr {
  height:0;
  margin:0;
  background:transparent;
  border-bottom:1px solid #000000;
}
div.b {
  white-space: nowrap;
  width: 350px;
  overflow: hidden;
  text-overflow: ellipsis;
}
b {
  font-family: "MS Sans Serif", Times, sans-serif;
}
p {
  font-family: "MS Sans Serif", Times, sans-serif;
}
</style>

<div class="container" onload="printDiv('printMe')">
  <div id='printMe'>
		<?php $n=1; $a=1; foreach ($detail as $key => $values): ?>
    <table>
      <tr>
        <td width="60%">
          <img src="<?php echo asset('gambar/'.aplikasi()[0]->icon); ?>" width="250" alt="homepage" />
          <div class="col-md-9" style="letter-spacing:1px;font-size:16px">
						<?php if(isset($alamat)) {foreach ($alamat as $value):
							$texts=str_ireplace('<p>','',$value->alamat);
							$texts=str_ireplace('</p>','',$texts); ?>
								Alamat: {{$texts}}
						<?php
						if(isset($value->kecamatan)){ echo " ".$data_kecamatan[$value->kecamatan].", "; }
						if(isset($value->kabupaten)){ echo " ".$data_kabupaten[$value->kabupaten]."."; }
					endforeach; } ?>
					{{$value->no_hp}}
    			</div>
        </td>

        <td align="right">
          <h3><b>KWITANSI TAGIHAN</b></h3>
          <h4><b>{{$transfer[0]->no_kwitansi}}</b></h4>
        </td>
      </tr>
    </table>

<hr>
  <div class="row">
    <table>
      <tr>
        <td width="80%">
          <b style="font-size:18px">&emsp;Kepada Yth:</b>
          <table>
           <tr>
              <td></td>
              <td>&emsp;<b style="letter-spacing:1px;font-size:18px">{{$transfer[0]->nama_pemilik}}</b></td>
              </tr>
            <tr>
              <td></td>
              <td style="letter-spacing:1px;font-size:18px">&emsp;<?php
							$text=str_ireplace('<p>','',$transfer[0]->alamat);
							$text=str_ireplace('</p>','',$text);
							echo $text.",";

							if (is_numeric($transfer[0]->kecamatan)) {
									if(isset($data_kecamatan[$transfer[0]->kecamatan])){ echo " ".$data_kecamatan[$transfer[0]->kecamatan].", "; }
							}else{
									if(isset($transfer[0]->kecamatan)){ echo " ".$transfer[0]->kecamatan.", "; }
							}

							if (is_numeric($transfer[0]->kota)) {
									if(isset($data_kabupaten[$transfer[0]->kota])){ echo $data_kabupaten[$transfer[0]->kota].", "; }
							}else{
									if(isset($transfer[0]->kota)){ echo $transfer[0]->kota.". "; }
							}

							?> &nbsp;(<?php echo $transfer[0]->no_hp; ?>)</td>
            </tr>
          </table>
        </td>
        <td>
          <b style="font-size:18px">Petugas:</b>
          <table>
            <tr>
              <td style="font-family: 'MS Sans Serif', Times, sans-serif;font-size:18px">CS : {{$transfer[0]->sales}}</td>
              <td></td>
            </tr>
            <tr>
              <td style="font-family: 'MS Sans Serif', Times, sans-serif;font-size:18px">Pengirim : {{$transfer[0]->pengirim}}</td>
              <td></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>
  <hr>
  <div class="col-md-12">
    <table id="content" style="font-size:18px">
      <thead>
        <td><center><b>No</b></center></td>
        <td align="left"><b>Nama Barang</b></td>
        <td><center><b>Jumlah</b></center></td>
        <td align="right"><b>Harga Satuan</b></td>
        <td align="right"><b>Potongan</b></td>
        <td align="right"><b>Jumlah Harga</b></td>
      </thead>
      <?php
      $no=1;
      $jumlah=0;
      $total=0;
      foreach ($values as $value):
				if ($no < 11) {
				 ?>
        <tr>
          <td><center>{{$no}}</center></td>
          <td><div class="b" style="font-family: 'MS Sans Serif', Times, sans-serif;">{{$value['nama_barang']}}</div></td>
          <td align="center" style="font-family: 'MS Sans Serif', Times, sans-serif;">{{ribuan($value['proses'])}}
          <?php if ($value['return'] > 0): ?>
            (-{{ribuan($value['return'])}})
          <?php endif; ?> 
          </td>
          <td align="right" style="font-family: 'MS Sans Serif', Times, sans-serif;">{{ribuan($value['harga_jual'])}}</td>
          <td align="right" style="font-family: 'MS Sans Serif', Times, sans-serif;">{{ribuan($value['potongan'])}}</td>
          <td align="right" style="font-family: 'MS Sans Serif', Times, sans-serif;">{{ribuan($value['sub_total'])}}</td>
        </tr>
      <?php $no++; $n++; $jumlah += $value['proses']; $total+= $value['sub_total']; } endforeach; ?>
			<tr>
        <td colspan="2">Ongkos Kirim</td>
        <td align="center"></td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right"><b>{{rupiah($transfer[0]->ongkos_kirim)}},-</b></td>
      </tr>
      <tr>
        <td colspan="2"><center><b>TOTAL</b></center></td>
        <td align="center"><b>{{ribuan($jumlah)}}</b></td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right"><b>{{rupiah($total+$transfer[0]->ongkos_kirim)}},-</b></td>
      </tr>
    </table>
		<?php if ($no < 11){
			for($x=0; $x < (11-$no) ; $x++){
				echo "<br>";
			}
		} ?>
    <hr>
    <?php if (count($detail) == $a): ?>
		<table>
			<td align="right" style="font-size:18px; font-family: 'MS Sans Serif', Times, sans-serif;">Total Yang Sudah Dibayar : Rp {{rupiah($pembayaran[0]->total_bayar)}},-</td>
			<td align="right" style="font-size:18px; font-family: 'MS Sans Serif', Times, sans-serif;">Piutang : Rp {{rupiah($tagihan[0]->tagihan - $pembayaran[0]->total_bayar + $transfer[0]->ongkos_kirim)}},-</td>
		</table>
    <?php endif; ?>
    <hr>
		<div id="footer_wrapper">
    <div class="row">
      <table>
        <tr>
          <td>
            <p style="font-size:18px">Tanggal Kirim : {{tanggal($transfer[0]->tanggal_terkirim)}}</p>
            <p style="font-size:14px;"><b>Catatan :</b><br>
            - Harap melakukan pembayaran tepat waktu sesuai tempo yang telah disepakati</p>
          </td>
          <td>
            <b><center><h5>Petugas</h5></center></b>
            <br>
            <center>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</center>
          </td>
          <td>
            <b><center><h5>Penerima</h5></center></b>
            <br>
            <center>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</center>
          </td>
        </tr>
      </table>
    </div>
	</div>
	</div>
			<?php $a++; endforeach; ?>
  </div>
  <br><br><br>
  <center><button class="btn btn-success btn-lg" onclick="printDiv('printMe')">Cetak</button></center>
  <br><br><br>
</div>

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
