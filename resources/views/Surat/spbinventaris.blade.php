<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Cetak Nota SPB</title>
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

</style>

<div class="container" onload="printDiv('printMe')">
  <div id='printMe'>
		<?php $n=1; foreach ($detail as $key => $values): ?>
    <table>
      <tr>
        <td width="65%">

            <img src="<?php echo asset('gambar/'.aplikasi()[0]->icon); ?>" width="250" padding-top="30" alt="homepage" />

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

        <td align="right" style="letter-spacing:1px">
          <h4><b>Surat Penyerahan Barang</b></h4>
          <b>{{$transfer[0]->no_kwitansi}}</b>
        </td>
      </tr>
    </table>

  <div class="row">

  </div>
<hr>
  <div class="row">
    <table>
      <tr>
        <td width="75%">
          <b style="letter-spacing:1px;font-size:18px">&emsp;Kepada Yth:</b>
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
							?>&nbsp;(<?php echo $transfer[0]->no_hp; ?>) </td>
            </tr>
          </table>
        </td>
        <td>
          <b style="letter-spacing:1px;font-size:18px">Petugas:</b>
          <table>
            <tr>
              <td style="font-family: 'MS sans serif', Times, sans serif;font-size:18px">Admin : <?php echo $transfer[0]->admin_p; ?></td>
              <td></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>
  <hr><br>
  <div class="col-md-12">
    <table id="content" style="font-size:18px">
      <thead>
        <td><center><b>No.</b></center></td>
        <td align="left" style="letter-spacing:1px"><b>Nama Barang</b></td>
        <td><center><b>Jumlah</b></center></td>
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
          <td><div class="b" style="letter-spacing:1px">{{$value['nama_barang']}}</div></td>
          <td align="center" style="letter-spacing:1px">{{ribuan($value['proses'])}}</td>
        </tr>
      <?php $no++; $n++; $jumlah += $value['proses']; } endforeach; ?>

    </table>
		<?php if ($no < 11){
			for($x=0; $x < (11-$no) ; $x++){
				echo "<br>";
			}
		} ?>


		<div id="footer_wrapper">
    <div class="row">
      <table>
        <tr>
          <td style="letter-spacing:1px">  
            Tanggal : <b>{{tanggal($transfer[0]->tanggal_order)}}</b>
          </div>
          <td style="letter-spacing:1px">
            <b><center><h5>Managemen</h5></center></b>
            <br>
            <center>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</center>
          </td>
          <td style="letter-spacing:1px">
            <b><center><h5>Admin</h5></center></b>
            <br>
            <center>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</center>
          </td>
          <td style="letter-spacing:1px">
            <b><center><h5>Penerima</h5></center></b>
            <br>
            <center>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</center>
          </td>
        </tr>
      </table>
    </div>
	</div>
	</div>
			<?php endforeach; ?>
  </div>
  <br><br><br>
  <center><button class="btn btn-success" onclick="printDiv('printMe')">Cetak</button>
  <button class="btn btn-primary" onclick="BackTo()">Batal</button></center>
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
