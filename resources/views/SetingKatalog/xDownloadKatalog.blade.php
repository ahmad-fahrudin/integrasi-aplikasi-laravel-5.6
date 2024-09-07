<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>MASE.ID</title>
	<link rel="shortcut icon" type="image/png" href="/system/src/assets/images/favicon.png">
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

  </style>

</head>
<body>
<div class="page-wrapper" style="background:#fff">
	<br>&emsp;<button onclick="printDiv('printMe')" class="btn btn-success">Download / Print</button><br><br>
  <div id='printMe'>
    <div class="container-fluid" style="background:#fff">
      <div class="row">
	  	<?php $no=1; $cek=false; $kiri=-1; $kanan=-1; foreach ($produk as $key => $value) {
			if ($no % 4 == 1) { $kiri++; ?>
				<?php if ($kiri < 3): ?>
					<div class="space"></div>
				<?php endif; ?>
			<?php if ($kiri == 5) { $kiri=-1; } }
			if ($value->jenis == "single") {	?>
				<div class="col-md-3 border">
					<div class="card card-product-grid" style="box-shadow:none;">
						<div class="row">
							<div class="col-md-6">
								<?php if (isset($brand[$value->brand])): ?>
										<img src="../../admin/gambar/brand/{{$brand[$value->brand]}}" width="100" height="30">
								<?php endif; ?>
							</div>
							<div class="col-md-6" style="text-align: right;">
								<?php if (isset($value->label)): ?>
										<span class="badge badge-pill badge-{{$label[$value->label]['class']}}" style="font-size:10px; margin-right:30px;">{{strtoupper($label[$value->label]['nama'])}}</span>
								<?php endif; ?>
							</div>
						</div>
						<a href="#" onclick="Direct('produk/{{format_link($value->nama_barang)}}','{{$value->id}}');return false;" class="img-wrap"> <img src="../../admin/gambar/product/{{$value->nama_file}}" width="100%" height="auto"> </a>
						<?php if (strlen($value->nama_barang) < 30): ?>
						<?php endif; ?>
						<h6><strong><a href="#" onclick="Direct('produk/{{format_link($value->nama_barang)}}','{{$value->id}}');return false;" style="color:#424242">{{$value->nama_barang}}</a></strong></h6>
					</div>
				</div>
	  <?php }else{ ?>
			<div class="col-md-3 border">
				<div class="card card-product-grid">
          <div class="row">
            <div class="col-md-6">
              <?php if (isset($brand[$value->brand])): ?>
                  <img src="../../admin/gambar/brand/{{$brand[$value->brand]}}" width="100" height="30">
              <?php endif; ?>
            </div>
            <div class="col-md-6" style="text-align: right;">
              <?php if (isset($value->label)): ?>
                  <span class="badge badge-pill badge-{{$label[$value->label]['class']}}" style="font-size:10px; margin-right:30px;">{{strtoupper($label[$value->label]['nama'])}}</span>
              <?php endif; ?>
            </div>
          </div>
					<a href="#" onclick="Direct('produk/{{format_link($value->nama_barang)}}','{{$value->id}}');return false;" class="img-wrap"> <img src="../../admin/gambar/product/{{$value->nama_file}}" width="100%"> </a>
					<?php if (strlen($value->nama_barang) < 30): ?>
					<?php endif; ?>
					<h6><strong><a href="#" onclick="Direct('produk/{{format_link($value->nama_barang)}}','{{$value->id}}');return false;" style="color:#424242">{{$value->nama_barang}}</a></strong></h6>
				</div>
			</div>
		<?php }

		if ($no % 4 == 0) { $kanan++; ?>
			<?php if ($kanan >= 3): ?>
				<div class="space"></div>
			<?php endif; ?>
		<?php if ($kanan == 5) { $kanan=-1; } }

		$no++; }?>

	</div>
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
