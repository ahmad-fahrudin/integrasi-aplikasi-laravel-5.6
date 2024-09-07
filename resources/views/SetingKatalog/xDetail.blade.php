@extends('template/nav')
@section('content')

<link href="<?php echo asset('system/script/ui.css'); ?>" rel="stylesheet" type="text/css"/>

<div class="page-wrapper">
    <div class="container-fluid">
      <div class="card">
        	<div class="row no-gutters">
        		<aside class="col-md-6">
              <article class="gallery-wrap">
              	<div class="img-big-wrap">
                  <br>
              	   <a><img id="gambar_view" src="../../admin/gambar/product/{{$gambar[0]->nama_file}}"></a>
              	</div>
              	<div class="thumbs-wrap">
                  <?php foreach ($gambar as $key => $value): ?>
                    <a onclick="detailimage('../../admin/gambar/product/{{$value->nama_file}}')" class="item-thumb"> <img src="../../admin/gambar/product/{{$value->nama_file}}"></a>
                  <?php endforeach; ?>
              	</div> <!-- thumbs-wrap.// -->
              </article> <!-- gallery-wrap .end// -->
        		</aside>
        		<main class="col-md-6 border-left">
              <article class="content-body">
              <h2 class="title">{{$detailproduk[0]->nama_barang}}</h2>
              <div class="mb-3">
                <?php if ($detailproduk[0]->jenis == "single"){ ?>
              	   <var class="price h4" id="harga">RP {{ribuan($harga[0]->harga_retail)}},-</var>
                <?php }else{
                  $min = $harga[$detailproduk[0]->barang_multi]['harga_retail'];
                  $max = $harga[$detailproduk[0]->barang_multi]['harga_retail'];
                  foreach ($harga as $key => $value) {
                    if ($value['harga_retail'] <= $min) {
                      $min = $value['harga_retail'];
                    }
                    if ($value['harga_retail'] >= $max) {
                      $max = $value['harga_retail'];
                    }
                  }
                  echo '<var class="price h4" id="harga">'."Rp ".ribuan($min)." - ".ribuan($max).",-".'</var>';
                } ?>
              </div>
              <dl class="row">
                <dt class="col-sm-2">Brand</dt>
                <dd class="col-sm-10"><!--img src="../../admin/gambar/brand/{{$detailproduk[0]->img}}" width="100px"-->{{$detailproduk[0]->nama_brand}}</dd>

                <dt class="col-sm-2">Berat</dt>
                <dd class="col-sm-10">{{$detailproduk[0]->berat}} kg</dd>

                <?php if ($detailproduk[0]->jenis == "single"){ ?>
                  <dt class="col-sm-2">No SKU</dt>
                  <dd class="col-sm-10">{{$barang[$detailproduk[0]->barang]['no_sku']}}</dd>
                  <dt class="col-sm-2">Keterangan</dt>
                  <dd class="col-sm-10">{{$barang[$detailproduk[0]->barang]['keterangan']}}</dd>
                <?php } ?>
              </dl>
              <br>
              <div class="item-option-select">
              	<h6>Pilihan Warna</h6>
              	<div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
                  <?php $pcs = explode(",", $detailproduk[0]->warna);
                  for ($i=0; $i < (count($pcs)-1); $i++) {
                    echo '<label class="btn btn-light">'.$warna[$pcs[$i]].'</label>';
                  }
                  ?>
              	</div>
              </div>

              <?php if ($detailproduk[0]->jenis == "multiple"): ?>
                <br>Pilihan Produk:<br>
                <?php $no=1; foreach ($pilihan as $key => $value): ?>
                  <label for="male">&nbsp;{{$no}}) No SKU : {{$value['no_sku']}}<br>
                                                   &emsp;&nbsp;Nama Produk : {{$value['nama_barang']}}<br>
                                                   &emsp;&nbsp;Keterangan : {{$value['keterangan']}}<br></label><br>
                <?php $no++; endforeach; ?>
              <?php endif; ?>

              <?php if ($detailproduk[0]->jenis == "single"){ ?>
                <br>
                <b class="label-rating text-success"><i class="fa fa-clipboard-check"></i>&nbsp;&nbsp;Stok Tersedia : <span id="jumlah_stok">{{$stok[0]->jumlah}}</span></b>
              <?php }else{
                $total = 0;
                foreach ($stok as $key => $value) {
                  $total += $value['stok'];
                } ?>
                <br>
                <b class="label-rating text-success"><i class="fa fa-clipboard-check"></i>&nbsp;&nbsp;Stok Tersedia : <span id="jumlah_stok">{{$total}}</span></b>
              <?php } ?>

              </article>
        		</main>
        	</div>
        </div>
  </div>
</div>
<script>
function detailimage(id){
  document.getElementById("gambar_view").src = id;
}
</script>
@endsection
