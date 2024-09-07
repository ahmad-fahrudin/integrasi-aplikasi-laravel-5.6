<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Cetak Label Pengiriman</title>
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

    @media print and (width: 14.8cm) and (height: 10.5cm) {
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
<div style="width:100%;height:500px;padding:20px;">
      <img src="<?php echo asset('gambar/'.aplikasi()[0]->icon); ?>" width="200" padding-top="25" alt="homepage" /><br><br>
      <div class="col-md-9" style="width:50%;float:left;letter-spacing:1px;font-size:20px">
						<?php if(isset($alamat)) {foreach ($alamat as $value):
							$texts=str_ireplace('<p>','',$value->alamat);
							$texts=str_ireplace('</p>','',$texts); ?>
								
				Pengirim:<br>
				<h4><?=aplikasi()[0]->nama?></h4>
						<b>{{$texts}}<br>
						Kec. <?php
						if(isset($value->kecamatan)){ echo " ".$data_kecamatan[$value->kecamatan].","; }
						if(isset($value->kabupaten)){ echo " ".$data_kabupaten[$value->kabupaten].",<br>"; }
						if(isset($value->provinsi)){ echo " ".$data_provinsi[$value->provinsi]."."; }
					    endforeach; } ?><br>
					        ({{$value->no_hp}})</b><br><br>
    		
    		    <img src="../../admin/gambar/ekspedisi.png" width="400px" alt="tindakan" />
    			</div>
    			

    			
    			
      <div class="col-md-9" style="width:50%;float:right;letter-spacing:1px;font-size:20px">
     Penerima:<br>
      <h4>
           <?php if(isset($drp[0]->atas_nama)) {
              echo $drp[0]->atas_nama;
           }else{ 
              echo $transfer[0]->nama_pemilik;
           } ?>
      </h4>
      <b>
        <?php
        if(isset($drp[0]->atas_nama)) {
			echo $drp[0]->alamat.",<br> Kec. ";
			
			if (is_numeric($drp[0]->kecamatan)) {
        			if(isset($data_kecamatan[$drp[0]->kecamatan])){ echo " ".$data_kecamatan[$drp[0]->kecamatan].", "; }
        	}else{
        			if(isset($drp[0]->kecamatan)){ echo " ".$drp[0]->kecamatan.", "; }
        	}
        	
        	if (is_numeric($drp[0]->kabupaten)) {
			    if(isset($data_kabupaten[$drp[0]->kabupaten])){ echo $data_kabupaten[$drp[0]->kabupaten].", <br>"; }
    		}else{
    			if(isset($drp[0]->kabupaten)){ echo $drp[0]->kabupaten.", <br>"; }
    		}
    		
    		if (is_numeric($drp[0]->provinsi)) {
    				if(isset($data_kabupaten[$drp[0]->provinsi])){ echo $data_provinsi[$drp[0]->provinsi].". "; }
    		}else{
    				if(isset($drp[0]->provinsi)){ echo $drp[0]->provinsi.". "; }
    		} ?>
    		<br>(<?php echo $drp[0]->no_hp; ?>)
        <?php
        }else{
            $text=str_ireplace('<p>','',$transfer[0]->alamat);
			$text=str_ireplace('</p>','',$text);
			echo $text.",<br> Kec. ";
        	if (is_numeric($transfer[0]->kecamatan)) {
        			if(isset($data_kecamatan[$transfer[0]->kecamatan])){ echo " ".$data_kecamatan[$transfer[0]->kecamatan].", "; }
        	}else{
        			if(isset($transfer[0]->kecamatan)){ echo " ".$transfer[0]->kecamatan.", "; }
        	}
        	
    		if (is_numeric($transfer[0]->kota)) {
			    if(isset($data_kabupaten[$transfer[0]->kota])){ echo $data_kabupaten[$transfer[0]->kota].", <br>"; }
    		}else{
    			if(isset($transfer[0]->kota)){ echo $transfer[0]->kota.", <br>"; }
    		}
    		
    		if (is_numeric($transfer[0]->provinsi)) {
    				if(isset($data_kabupaten[$transfer[0]->provinsi])){ echo $data_provinsi[$transfer[0]->provinsi].". "; }
    		}else{
    				if(isset($transfer[0]->provinsi)){ echo $transfer[0]->provinsi.". "; }
    		} ?>
    		<br>(<?php echo $transfer[0]->no_hp; ?>)
        <?php }

		?>
		</b>
		<br><br>
		<div style="width:100%;border:1px solid #fb3200;border-radius:10px;padding:10px">
    			    Maaf, Komplain tanpa disertai bukti video saat proses membuka paket ini dari awal, tidak dapat dilayani !
    			</div>
		</div>
	</div>
  
  </div>
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
