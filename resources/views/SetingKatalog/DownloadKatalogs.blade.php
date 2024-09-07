<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title><?=aplikasi()[0]->nama?></title>
	<link rel="icon" href="gambar/<?=aplikasi()[0]->favicon?>" sizes="32x32" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
	<link rel="stylesheet" type="text/css" href="<?php echo asset('system/script/css/jquery.dataTables.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo asset('system/script/css/buttons.dataTables.min.css'); ?>">
  <!--link href="<?php echo asset('aset/vendor/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet"-->
  <!--link href="<?php echo asset('aset/css/simple-sidebar.css');?>" rel="stylesheet"-->
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/jquery.dataTables.min.js'); ?>"></script>
	<script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/dataTables.buttons.min.js'); ?>"></script>
	<script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/buttons.flash.min.js'); ?>"></script>
	<script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/jszip.min.js'); ?>"></script>
	<script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/pdfmake.min.js'); ?>"></script>
	<script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/vfs_fonts.js'); ?>"></script>
	<script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/buttons.html5.min.js'); ?>"></script>
	<script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/buttons.print.min.js'); ?>"></script>
	<script src="<?php echo asset('system/autoNumeric.min.js'); ?>"></script>

  <link href="<?php echo asset('system/src/dist/css/style.css?ver=1.0'); ?>" rel="stylesheet">
  <link href="<?php echo asset('system/src/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css'); ?>" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo asset('system/src/highlights/highlight.min.css'); ?>">
  <style type="text/css" media="print">
	.col-md-3{
		width:23%;
	}
	.space{
		width:8%;
	}

  #divheight {
    height: 650px;
  }

    @media screen {
      div#footer_wrapper {
        display: none;
      }
      div.footer {
          display: none;
      }
    }

    @media print and (width: 21.5cm) and (height: 16.5cm) {
        @page {
					margin-top: 2cm;
					margin-bottom: 2cm;
					margin-left: 4cm;
					margin-right: 2cm;
        }

    }

    @page {
       size: A5 landscape;
    }
    
    #frame-image {
    height: 170px;
    overflow: hidden;
    transform: scale(1.0);
    bottom: 5px;
    position: relative;
    }
    #frame-image img {
    max-height: 160px;
    position: absolute;
    left: 50%;
    top: 50%;
    width: auto;
    height:auto;
    -webkit-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
    }

  </style>

</head>
<body>
<div class="page-wrapper" style="background:#eee">
	<br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<button onclick="printDiv('printMe')" class="btn btn-success">Proses Cetak</button><br><br>
  <div id='printMe'>
    <div class="container-fluid" style="background:#fff;width:970px">
        <?php $no=1; $cek=false; $kiri=-1; $kanan=-1; foreach ($produks as $key => $v):?>
          <?php if (($key+1)%2 == 1){ ?>
            <a href="#" target="_blank">
                <img src="<?php echo asset('gambar/'.aplikasi()[0]->icon); ?>" width="150" height="auto" style="padding-top:5px;margin-left:100px;" alt="homepage" /></a> 
            <div style="padding-top:5px;padding-right:20px;" class="float-right">{{$key+1}}</div>
          <?php }else{ ?>
            <a href="#" target="_blank">
                <img src="<?php echo asset('gambar/'.aplikasi()[0]->icon); ?>" width="150" height="auto" style="padding-top:5px;margin-left:10px;" alt="homepage" /></a> 
            <div style="padding-top:5px;padding-right:90px;" class="float-right">{{$key+1}}</div>
          <?php } ?>
          <div id="divheight">
        <?php if (($key+1)%2 == 1){ ?>
          <div class="row" style="padding-left:40px;width:100%;margin:5px">
        <?php }else{ ?>
          <div class="row" style="padding-right:30px;padding-left:10px;width:100%;margin:5px">
        <?php } ?>
          <?php foreach ($v as $k => $value): ?>

            <?php
              if ($no % 4 == 1) {
                $kiri++;
      				  if ($kiri < 3): ?>
      					     <div class="space"></div>
      				  <?php endif;
                if ($kiri == 5) {
                  $kiri=-1;
                }
              }
            ?>

            <div class="col-md-3 border" width="200" height="160">
    					<div width="100%" height="90%">
    						<div class="row" style="position:absolute;z-index: 10">
    							<div class="col-md-6">
    								<?php if (isset($brand[$value['brand']])): ?>
    										<img src="../../admin/gambar/brand/{{$brand[$value['brand']]}}" width="auto" height="20" style="transform: none">
    								<?php endif; ?>
    							</div>
    							<div class="col-md-6" style="text-align: right;">
    								<?php if (isset($value->label)): ?>
    										<span class="badge badge-pill badge-{{$label[$value['label']]['class']}}" style="font-size:10px; margin-right:30px;">{{strtoupper($label[$value['label']]['nama'])}}</span>
    								<?php endif; ?>
    							</div>
    						</div>
    						<div id="frame-image">
    						<a href="#"> <img src="../../admin/gambar/product/{{$value['nama_file']}}" width="90%" height="auto"></a>
    						</div>
    						<div style="overflow:hidden;height:40px;font-weight:bold;color:#708090">
    						<h5><strong><a>{{$value['nama_barang']}}</a></strong></h5>
    						</div>
    					</div>
    				</div>

            <?php
              if ($no % 4 == 0) {
                $kanan++;
        			  if ($kanan >= 3): ?>
        				    <div class="space"></div>
        			  <?php endif;
        		    if ($kanan == 5) {
                  $kanan=-1;
                }
              }
              $no++;
            ?>

          <?php endforeach; ?>
          </div>
        </div>
        <?php endforeach; ?>
    </div>
  </div>
</div>
</body>
<script src="<?php echo asset('system/src/assets/libs/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo asset('system/src/dist/js/app-style-switcher.js'); ?>"></script>
<script src="<?php echo asset('system/src/dist/js/feather.min.js'); ?>"></script>
<script src="<?php echo asset('system/src/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js'); ?>"></script>
<script src="<?php echo asset('system/src/dist/js/sidebarmenu.js'); ?>"></script>
<script src="<?php echo asset('system/src/dist/js/custom.min.js'); ?>"></script>
<script src="<?php echo asset('system/src/highlights/highlight.min.js'); ?>"></script>
<script src="<?php echo asset('system/src/dist/js/pages/datatable/datatable-basic.init.js'); ?>"></script>
<script>
    hljs.initHighlightingOnLoad();
</script>
<script>
function printDiv(divName){
  var printContents = document.getElementById(divName).innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
}
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function Direct(id,ids){
  $.ajax({
     url: 'setkey/'+ids,
     type: 'get',
     dataType: 'json',
     async: false,
     success: function(response){
       location.href = id;
     }
   });
}
</script>
</body>
</html>
