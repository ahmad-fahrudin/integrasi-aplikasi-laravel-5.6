
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Cetak Nota SPB</title>
	<link rel="icon" href="gambar/<?=aplikasi()[0]->favicon?>" sizes="32x32" />
  <link href="http://localhost/gudang.mase.id/system/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <style type="text/css" media="print">

		@media  screen {
			div#footer_wrapper {
				display: none;
			}
			div.footer {
					display: none;
			}
		}

    @media  print and (width: 21.5cm) and (height: 14cm) {
        @page  {
           margin: 0cm;
        }

				div#footer_wrapper {
					margin: 0px 2px 0px 70px;
					position: fixed;
					bottom: 0;
				}

    }

    @page  {
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
    <?php $a=0; foreach ($surat as $key => $value):
    $text=str_ireplace('<p>','',$konsumen[$value->id_konsumen]['alamat']);
    $text=str_ireplace('</p>','',$text);?>
		  <table>
      <tr>
        <td width="60%">
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
          <h4><b>SURAT PENYERAHAN BARANG</b></h4>
          <h5><b>{{$value->no_kwitansi}}</b></h5>
        </td>
      </tr>
    </table>

  <div class="row">

  </div>
<hr>
  <div class="row">
    <table>
      <tr>
        <td width="80%">
          <b style="letter-spacing:1px;font-size:18px">&emsp;Kepada Yth:</b>
          <table>
            <tr>
              <td></td>
              <td>&emsp;<b style="letter-spacing:1px;font-size:18px">{{$konsumen[$value->id_konsumen]['nama']}}</b></td>
              </tr>
            <tr>
              <td></td>
              <td style="letter-spacing:1px;font-size:18px">&emsp;{{$text}}&nbsp;({{$konsumen[$value->id_konsumen]['no_hp']}})</td>
            </tr>
          </table>
        </td>
        <td>
          <b style="letter-spacing:1px;font-size:18px">Petugas:</b>
          <table>
            <tr>
              <td style="font-family: 'MS sans serif', Times, sans serif;font-size:18px">CS : {{$karyawan[$value->qc]}}</td>
              <td></td>
            </tr>
            <tr>
              <td style="font-family: 'MS sans serif', Times, sans serif;font-size:18px">DR : {{$karyawan[$value->driver]}}</td>
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
        <td align="right" style="letter-spacing:1px"><b>Harga Satuan</b></td>
        <td align="right" style="letter-spacing:1px"><b>Potongan</b></td>
        <td align="right" style="letter-spacing:1px"><b>Jumlah Harga</b></td>
      </thead>
      <?php $no=1; $jumlah = 0; $sum = 0;foreach ($detail[$a] as $key => $val): $sum +=$val['jumlah']; $jumlah += $val['jumlah']*($val['harga_satuan'] - $val['potongan']); ?>
        <tr>
          <td><center>{{$no}}</center></td>
          <td><div class="b" style="letter-spacing:1px">{{$barang[$val['id_barang']]}}</div></td>
          <td align="center" style="letter-spacing:1px">{{$val['jumlah']}}</td>
          <td align="right" style="letter-spacing:1px">{{ribuan($val['harga_satuan'])}}</td>
          <td align="right" style="letter-spacing:1px">{{ribuan($val['potongan'])}}</td>
          <td align="right" style="letter-spacing:1px">{{ribuan($val['jumlah']*($val['harga_satuan'] - $val['potongan']))}}</td>
        </tr>
      <?php $no++; endforeach; ?>
        <tr>
        <td colspan="2"><center><h5>TOTAL</h5></center></td>
        <td align="center" style="letter-spacing:1px"><h5>{{$sum}}</h5></td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right" style="letter-spacing:2px"><h4>Rp {{ribuan($jumlah)}},-</h4></td>
      </tr>
    </table>
		<br><br><br><br><br><br><br><br><br>

		<div id="footer_wrapper">
    <div class="row">
      <table>
        <tr>
          <td>
            <p style="letter-spacing:1px">Tanggal Kirim : <b>{{tanggal($value->tanggal_input)}}</b></p>
            <br><br><br>
          </td>
          <td style="letter-spacing:1px">
            <b><center><h5>Petugas</h5></center></b>
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
  <?php $a++; endforeach; ?>
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
