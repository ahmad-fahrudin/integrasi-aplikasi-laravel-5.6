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

    @media print and (width: 21.5cm) and (height: 28cm) {
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
		<?php foreach ($detail as $vue):?>
    <table>
      <tr>
        <td width="58%">
          <img src="<?php echo asset('gambar/'.aplikasi()[0]->icon); ?>" width="250" alt="homepage" />
          <div class="col-md-9" style="letter-spacing:1px;font-size:16px">
						<?php if(isset($alamat)) {foreach ($alamat as $value):
							$texts=str_ireplace('<p>','',$value->alamat);
							$texts=str_ireplace('</p>','',$texts); ?>
								Alamat: <?=$texts?>
						<?php
						if(isset($value->kecamatan)){ echo " ".$data_kecamatan[$value->kecamatan].","; }
						if(isset($value->kabupaten)){ echo " ".$data_kabupaten[$value->kabupaten]."."; }
					endforeach; } ?>
					<?php if(isset($value->no_hp)) { ?>{{$value->no_hp}}<?php } ?>
    			</div>
        </td>

        <td align="right">
          <h4><b>Surat Perintah Kerja</b></h4>
          <h5><b><?=$transfer[0]->no_service?></b></h5>
        </td>
      </tr>
    </table>
<hr>
<table>
  <tr>
    <td width="80%">
        <b style="font-size:18px">&emsp;Petugas:</b>
      <table>
        <tr>
          <td></td>
          <td><b style="font-size:18px">&emsp;<?=$karyawan[$transfer[0]->petugas]->nama?></b></td>
          </tr>
        <tr>
          <td></td>
          <td style="font-size:18px">&emsp;Gudang Service - <?php
				$text=str_ireplace('<p>','',$gudangs[$transfer[0]->detail_gudang]->alamat);
				$text=str_ireplace('</p>','',$text);
				echo $text; ?>
					</td>
        </tr>
      </table>
    </td>
    <td>
      <b style="font-size:18px">Admin:</b>
      <table>
        <tr>
          <td style="font-size:18px">Input : <?php if (isset($transfer[0]->admin_g)): ?><?=$user[$transfer[0]->admin_g]->name?><?php endif; ?></td>
          <td></td>
        </tr>
        <tr>
          <td style="font-size:18px">Proses : <?php if (isset($transfer[0]->admin_sm)): ?><?=$user[$transfer[0]->admin_sm]->name?><?php endif; ?></td>
          <td></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
  <hr>
  <div class="col-md-12">
    <table id="tbl" border="0" style="font-size:18px">
      <tr>
        <td><center><b>No</b></center></td>
        <td align="left"><b>Nama Barang</b></td>
        <td><center><b>Jumlah</b></center></td>
      </tr>
      <?php $no=1; $jumlah = 0; $hargatot = 0; foreach ($vue as $value): $jumlah += $value['proses'];?>
        <tr>
          <td><center><?=$no?></center></td>
          <td><?=$value['nama_barang']?></td>
          <td align="center"><?=$value['proses']?></td>
        </tr>
      <?php $no++; endforeach; ?>
      <tr>
        <td colspan="2" align="right"><b>TOTAL</b></td>
        <td align="center"><b><?=$jumlah?></b></td>
				<?php if (isset($trf)): ?>
					<td><center>-</center></td>
					<td><center>-</center></td>
					<td><center><?=ribuan($hargatot)?></center></td>
				<?php endif; ?>
      </tr>
    </table>
    <table>
			<td>Tanggal Proses: <b><?=tanggal($transfer[0]->tanggal_proses)?></b><br>
			Dari Gudang:<b>
		<?php if (isset($gudangs[$transfer[0]->detail_gudang]->nama)){ ?>
          {{$gudangs[$transfer[0]->detail_gudang]->nama}}
        <?php }else{ ?>
          {{$gudangs[$transfer[0]->detail_gudang]->nama_gudang}}
        <?php } ?>
			</b><br><br><br><br></td>
			<td><center><b>Admin</b></center>
				<br>
				<center>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</center></td>
			<td><center><b>Petugas</b></center>
				<br>
				<center>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</center></td>
			<td><center><b>Penerima</b></center>
				<br>
				<center>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</center></td>
		</table>

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
