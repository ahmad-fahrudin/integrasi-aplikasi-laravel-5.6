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
		<?php $total=0; $i=1; $no=1; $cek = count($loop); $cek2=1; foreach ($loop as $key => $value): ?>
        <table>
        <tr>
          <td width="65%">
              <img src="<?php echo asset('gambar/'.aplikasi()[0]->icon); ?>" width="250" padding-top="30" alt="homepage" />
                
                			<div class="col-md-9" style="letter-spacing:1px;font-size:16px">
								<?php if(isset($alamat)) {foreach ($alamat as $v):
									$texts=str_ireplace('<p>','',$v->alamat);
									$texts=str_ireplace('</p>','',$texts); ?>
										Alamat: {{$texts}}. {{$v->no_hp}}
								<?php endforeach; } ?>
							</div>
              
          </td>

          <td align="right" style="letter-spacing:1px">
            <h3><b>SURAT JALAN GUDANG</b></h3>
            <h4 style="font-size:30px"><b>{{$trip}}</b></h4>
          </td>
        </tr>
      </table>
      <hr>
		  <table>
        <tr style="border-bottom:1px solid #eee">
          <th style="font-size:28px">No</th>
          <th style="font-size:28px">Nama Barang</th>
          <th style="font-size:28px">Jumlah</th>
        </tr>
        <?php foreach ($value as $k => $val): ?>
          <tr style="border-bottom:1px solid #eee">
            <td style="font-size:30px">{{$no}}</td>
            <td style="font-size:30px">{{$val['nama_barang']}}</td>
            <td style="font-size:30px;text-align:center;font-weight:bold">{{$val['jumlah']}}</td>
          </tr>
        <?php $no++; $total+=$val['jumlah']; endforeach; ?>
        <?php
			if ($cek == $cek2) { ?>
			    <tr>
                    <td style="font-size:30px"></td>
                    <td style="font-size:30px;text-align:center;font-weight:bold">Total</td>
                    <td style="font-size:30px;text-align:center;font-weight:bold">{{$total}}</td>
                  </tr>
		<?php	}
		?>
      </table>

			<?php
			if ($cek == $cek2) {
				$enter = $no % 32;
				for ($i=0; $i < (32 - $enter); $i++) {
					echo "<br style='font-size:28px'>";
				}
			}
			?>

			<div id="footer_wrapper">
			<div class="row">
				<table>
					<tr>
						<td style="letter-spacing:1px;font-size:30px">
							<center><b>Admin Gudang</b></center>
							<br><br>
							<center>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</center>
						</td>
						<td style="letter-spacing:1px;font-size:30px">
							<center><b>QC</b></center>
							<br><br>
							<center>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</center>
						</td>
						<td style="letter-spacing:1px;font-size:30px">
							<center><b>Driver</b></center>
							<br><br>
							<center>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</center>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php $cek2++; endforeach; ?>
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
