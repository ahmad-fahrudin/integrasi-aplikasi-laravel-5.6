@extends('template/nav')
@section('content')
<link href="<?php echo asset('system/script/ui.css'); ?>" rel="stylesheet" type="text/css"/>
<style>
.persen{text-align:center;font-size:21px;font-weight:bold;width:60px;height:60px;margin:31px 7px 5px 0;color:#ddd;position:absolute}
.pot{margin-left:-22px;position:absolute;padding:5px}
    .diskon{border-radius: 50%;
    border: solid 2px #f5f5f5;
    width: 60px;
    height: 60px;
    float: right;
    position: absolute;
    right: 0;
    z-index:10;
    font-size: 12px;
    padding: 10px;
    margin: 10px;
   }
   #frame-image {
    height: 180px;
    overflow: hidden;
    transform: scale(1.3);
    bottom: 10px;
    position: relative;
    }

    #frame-image img {
    max-height: 220px;
    position: absolute;
    left: 50%;
    top: 50%;
    height: 100%;
    width: auto;
    -webkit-transform: translate(-50%,-50%);
      -ms-transform: translate(-50%,-50%);
          transform: translate(-50%,-50%);
    }
</style>
<div class="page-wrapper">
    <div class="container-fluid">
      <div class="card" style="margin-bottom:10px;padding-top:12px">

      <form action="{{url('katalog')}}" method="get">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-3" style="width:100%;margin-bottom:10px">
            <input type="text" name="nama_barang" class="form-control" maxlength="35" placeholder="Mau cari produk apa?" <?php if (isset($nama_barangs)): ?>
              value="{{$nama_barangs}}"
            <?php endif; ?>>
            </div>

            <div class="col-md-3" style="width:40%;margin-bottom:10px">
            <select name="main_kategori" id="main_kategoris" class="form-control" onchange="ChangeKategori()">
              <option selected>Semua</option>
              <?php foreach ($mainkategori as $key => $value): ?>
                <option value="{{$value->id}}"
                  <?php if (isset($mainkategoris) && $mainkategoris == $value->id): ?>
                    selected
                  <?php endif; ?>
                >{{strtoupper($value->nama_main_kategori)}}</option>
              <?php endforeach; ?>
            </select>
            </div>

            <div class="col-md-3" style="width:40%;margin-bottom:10px">
            <select name="kategori" id="kategoris" class="form-control">
              <option selected>Semua</option>
              <?php foreach ($kategori as $key => $value): ?>
                <option value="{{$value->id}}"
                  <?php if (isset($kategoris) && $kategoris == $value->id): ?>
                    selected
                  <?php endif; ?>
                >{{strtoupper($value->nama_kategori)}}</option>
              <?php endforeach; ?>
            </select>
            </div>

            <div class="col-md-1" style="text-align:left;width:5%;margin-bottom:10px">
              <input type="submit" value="CARI" class="btn btn-success">
            </div>
          </form>

          <div class="d-lg-inline-block col-md-2 text-right" style="text-align:right;width:50%;margin-bottom:3px">
            <a href="{{url('/downloadkatalog')}}" target="_blank" class="btn btn-warning">Download Katalog</a>
          </div>

          </div>
        </div>
        </div>
      <div class="card">
        <div class="card-body" style="margin:20">
      <div class="row">
	  <?php foreach ($produk as $key => $value) {
			if ($value->jenis == "single") {	?>
			<div class="col-md-2">
				<div class="card card-product-grid" style="padding:16px;overflow:hidden">
          <div class="row">
            <div class="col-md-6" style="text-align:left;width:50%;z-index:10">
              <?php if (isset($brand[$value->brand])): ?>
                  <img src="../../admin/gambar/brand/{{$brand[$value->brand]}}" width="100" height="30">
              <?php endif; ?>
            </div>
            <div class="col-md-6" style="text-align:right;width:50%;z-index:10">
              <?php if (isset($value->label) && $value->label !="" && (($value->label == 1 && isset($harga[$value->barang]['cekpromo'])) || $value->label == 2 ) ){ ?>
                <?php if (($value->label == 1 && isset($harga[$value->barang]['cekpromo'])) || $value->label == 2): ?>
                  <span class="badge badge-pill badge-{{$label[$value->label]['class']}}">{{strtoupper($label[$value->label]['nama'])}}</span>
                <?php endif; ?>
              <?php }else if(isset($getallpromo[$value->barang])){ ?>
                  <span class="badge badge-pill badge-success">ADA PROMO</span>
                  <?php $potonganpromo = $getallpromo[$value->barang]['potongan']/$harga[$value->barang]['harga_retail']; ?>
                  <br>
                  <div class="diskon"><center>Disc.<br><b>{{round($potonganpromo*100)}}%</b></center></div>
              <?php } ?>
            </div>
          </div>
                    <div id="frame-image">
					<a href="#" onclick="Direct('produk/{{format_link($value->nama_barang)}}','{{$value->id}}');return false;"> <img src="../../admin/gambar/product/{{$value->nama_file}}" width="90%" height="auto"> </a><br>
					</div>
					<div style="overflow:hidden;height:65px;padding-top:25px">
					<h4><strong><a href="#" onclick="Direct('produk/{{format_link($value->nama_barang)}}','{{$value->id}}');return false;" style="color:#424242">{{$value->nama_barang}}</a></strong></h4>
                    </div>
          <figcaption class="info-wrap">
					<span style="font-size:14px" class="small text-primary">Rp {{ribuan($harga[$value->barang]['harga_retail'])}},-</span>
							<?php
              if($value->label != 2){
              if ($stok[$value->barang]['stok'] > 5){ ?>
								<a style="font-size:16px;float:right" class="small text-success" href="#" onclick="Direct('produk/{{format_link($value->nama_barang)}}','{{$value->id}}');return false;">Stok Tersedia</a>
							<?php }else if($stok[$value->barang]['stok'] == 0){ ?>
								<a style="font-size:16px;float:right" class="small text-danger" href="#" onclick="Direct('produk/{{format_link($value->nama_barang)}}','{{$value->id}}');return false;">Pre Order</a>
							<?php }else{ ?>
								<a style="font-size:16px;float:right" class="small text-warning" href="#" onclick="Direct('produk/{{format_link($value->nama_barang)}}','{{$value->id}}');return false;">Stok Terbatas</a>
							<?php } } ?>
					</figcaption>
				</div>
			</div>
	  <?php }else{ ?>
			<div class="col-md-2">
				<div class="card card-product-grid" style="padding:16px;overflow:hidden">
          <div class="row">
            <div class="col-md-6" style="text-align:left;width:50%;z-index:10">
              <?php if (isset($brand[$value->brand])): ?>
                  <img src="../../admin/gambar/brand/{{$brand[$value->brand]}}" width="100" height="30">
              <?php endif; ?>
            </div>
            <div class="col-md-6" style="text-align:right;width:50%;z-index:10">

              <?php if (isset($value->label) && $value->label !=""){ ?>
                  <span class="badge badge-pill badge-{{$label[$value->label]['class']}}">{{strtoupper($label[$value->label]['nama'])}}</span>
              <?php }else if(isset($getallpromo[$value->barang])){ ?>
                <span class="badge badge-pill badge-success">Ada Promo</span>
              <?php } ?>

            </div>
          </div>
					<div id="frame-image">
					<a href="#" onclick="Direct('produk/{{format_link($value->nama_barang)}}','{{$value->id}}');return false;"> <img src="../../admin/gambar/product/{{$value->nama_file}}" width="100%"> </a>
					</div>
					<div style="overflow:hidden;height:65px;padding-top:25px">
					<h4><strong><a href="#" onclick="Direct('produk/{{format_link($value->nama_barang)}}','{{$value->id}}');return false;" style="color:#424242">{{$value->nama_barang}}</a></strong></h4>
					</div>
					<figcaption class="info-wrap">
					<span style="font-size:14px" class="small text-primary">	mulai Rp {{ribuan($multi[$value->id]['harga_min'])}},-</span>
            <a style="font-size:16px;float:right" class="small text-secondary" href="#" onclick="Direct('produk/{{format_link($value->nama_barang)}}','{{$value->id}}');return false;">Pilih</a><br>
					</figcaption>
				</div>
			</div>
		<?php } }?>

	</div>
    <nav aria-label="Page navigation example" style="position: absolute; left: 50%; transform: translatex(-50%);">
      <ul class="pagination">
        <?php

        $prv1 = $produk->currentPage() - 1;
        $prv2 = $produk->currentPage() - 2;
        $nxt1 = $produk->currentPage() + 1;
        $nxt2 = $produk->currentPage() + 2;?>
        <li class="page-item"><a class="page-link" href="{{url('/katalog')}}/?page={{$produk->currentPage()-1}}<?php if (isset($nama_barangs)){ echo "&nama_barang=".$nama_barangs; } ?><?php if (isset($kategoris)){ echo "&kategori=".$kategoris; } ?>"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a></li>
        <?php if ($prv2 > 0) {?>
          <li class="page-item"><a class="page-link" href="{{url('/katalog')}}/?page={{$prv2}}<?php if (isset($nama_barangs)){ echo "&nama_barang=".$nama_barangs; } ?><?php if (isset($kategoris)){ echo "&kategori=".$kategoris; } ?>">{{$prv2}}</a></li>
        <?php }
        if ($prv1 > 0) { ?>
          <li class="page-item"><a class="page-link" href="{{url('/katalog')}}/?page={{$prv1}}<?php if (isset($nama_barangs)){ echo "&nama_barang=".$nama_barangs; } ?><?php if (isset($kategoris)){ echo "&kategori=".$kategoris; } ?>">{{$prv1}}</a></li>
        <?php } ?>
        <li class="page-item active"><a class="page-link" href="#">{{$produk->currentPage()}}</a></li>
        <?php if ($nxt1 < $produk->lastPage()) { ?>
          <li class="page-item"><a class="page-link" href="{{url('/katalog')}}/?page={{$nxt1}}<?php if (isset($nama_barangs)){ echo "&nama_barang=".$nama_barangs; } ?><?php if (isset($kategoris)){ echo "&kategori=".$kategoris; } ?>">{{$nxt1}}</a></li>
        <?php }
        if ($nxt2 < ($produk->lastPage())) { ?>
          <li class="page-item"><a class="page-link" href="{{url('/katalog')}}/?page={{$nxt1}}<?php if (isset($nama_barangs)){ echo "&nama_barang=".$nama_barangs; } ?><?php if (isset($kategoris)){ echo "&kategori=".$kategoris; } ?>">{{$nxt2}}</a></li>
        <?php }
        if ($nxt2 < ($produk->lastPage()-1)) {
          echo '<li class="page-item"><a class="page-link" href="#">..</a></li>';
        }?>
        <?php if ($produk->currentPage() < $produk->lastPage()): ?>
          <li class="page-item"><a class="page-link" href="{{url('/katalog')}}/?page={{$produk->lastPage()}}<?php if (isset($nama_barangs)){ echo "&nama_barang=".$nama_barangs; } ?><?php if (isset($kategoris)){ echo "&kategori=".$kategoris; } ?>">{{$produk->lastPage()}}</a></li>
        <?php endif; ?>
        <li class="page-item"><a class="page-link"
          <?php if ($produk->currentPage() < $produk->lastPage()): ?>
            href="{{url('/katalog')}}/?page={{$produk->currentPage()+1}}<?php if (isset($nama_barangs)){ echo "&nama_barang=".$nama_barangs; } ?><?php if (isset($kategoris)){ echo "&kategori=".$kategoris; } ?>"
          <?php endif; ?>
        ><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a></li>

      </ul>
    </nav>
  <br><br>
</div></div></div>
</div>


<div id="detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <article class="gallery-wrap">
              <img id="gambar_brand" height="30" width="auto">
              <img id="gambar_view" width="100%">
              <div class="thumbs-wrap" id="pilih_gambar">
              </div>
            </article>
          </div>
          <div class="col-md-6">
            <article class="content-body">
            <div style="display:none" id="label"></div>

            <h2 class="title" id="nama_barang"></h2> 

            <div id="multi_produk">
            </div>
            <hr>
            <h3 class="text-primary" id="harga"></h3>
            <hr>
            <table class="table table-striped">
              <tbody>
                  <strong>Spesifikasi produk:</strong>
                <tr>
                  <td>Brand</td>
                  <td colspan="3" id="brand"></td>
                </tr>
                <tr>
                  <td>Kategori</td>
                  <td id="mainkategori"></td>
                  <td>></td>
                  <td id="kategori"></td>
                </tr>
                <tr>
                  <td>Berat</td>
                  <td colspan="3" id="berat"></td>
                </tr>
                <tr>
                  <td id="dt_sku"></td>
                  <td colspan="3" id="dd_sku"></td>
                </tr>
                
                <tr>
                  <td>Stok</td>
                  <td colspan="3" id="dd_stok"></td>
                </tr>
                <tr hidden>
                  <td id="dt_warna"></td>
                  <td colspan="3" id="warna"></td>
                </tr>
                <tr hidden>
                  <td id="dt_keterangan"></td>
                  <td id="dd_keterangan"></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
            <hr>
            <dd class="col-sm-12" id="deskripsi" style="font-size:17px;"></dd>

            <div class="kolom" id="detail_promo" hidden>
              <p style="margin-bottom:13px;font-size:17px;" id="judul_promo"></p>
              <ul id="isi_promo">
              </ul>
            </div>
            </article>
          </div>
        </div>
      </div>
      <div class="modal-footer">
      <?php if(Auth::user()->level == "1" || (Auth::user()->gudang == "1" && Auth::user()->level == "3")){ ?>
                <button class="btn btn-success" value="" id="editkatalog"><i data-feather="edit" class="feather-icon"></i> Edit</button>
            <?php } ?>
      
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i data-feather="x-square" class="feather-icon"></i> Close</button>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
$( "#editkatalog" ).click(function() {
  var id = $("#editkatalog").val();
  location.href = "{{url('editkatalogproduk')}}/"+id;
});

function Direct(id,ids){
    Swal.fire({
			title: 'Tunggu sebentar... \n ',
			icon: 'info',
		    showCancelButton: false,
		    showConfirmButton: false
		});
   setTimeout(function (){

  $.ajax({
     url: 'getDetailProduk/'+ids,
     type: 'get',
     dataType: 'json',
     async: false,
     success: function(response){
         $('#detail').modal('show');
        <?php if(Auth::user()->level == "1" || (Auth::user()->gudang == "1" && Auth::user()->level == "3")){ ?>
            document.getElementById("editkatalog").value = ids;
        <?php } ?>

        if (response['promosingle'] != undefined) {
          document.getElementById("detail_promo").hidden = false;
          document.getElementById("judul_promo").innerHTML = "Ada Promo 👇";
          document.getElementById("detail_promo").className = "kolom";
          document.getElementById("isi_promo").innerHTML = "<li>Dapatkan potongan harga Rp "+numberWithCommas(response['promosingle'][response['id_barang']]['potongan'])+",- per produk, promo berlaku dari tanggal "+response['promosingle'][response['id_barang']]['start']+" hingga "+response['promosingle'][response['id_barang']]['end']+".</li>";
        }else{


          if(Number(response['detailproduk'][0]['label']) == 1 && (Number(response['harga'][0]['pot1']) > 0)){
            document.getElementById("detail_promo").hidden = false;
            document.getElementById("detail_promo").className = "kolom";
            document.getElementById("judul_promo").innerHTML = response['label'][response['detailproduk'][0]['label']]['nama']+" 👇";
            var isi_tmp = "";
            if(Number(response['harga'][0]['pot1']) > 0){
              isi_tmp += "<li>Ambil "+response['harga'][0]['qty1']+" Pcs dapat potongan harga Rp "+numberWithCommas(response['harga'][0]['pot1'])+",- per produk</li>";
            }
            if(Number(response['harga'][0]['pot2']) > 0){
              isi_tmp += "<li>Ambil "+response['harga'][0]['qty2']+" Pcs dapat potongan harga Rp "+numberWithCommas(response['harga'][0]['pot2'])+",- per produk</li>";
            }
            if(Number(response['harga'][0]['pot3']) > 0){
              isi_tmp += "<li>Ambil "+response['harga'][0]['qty3']+" Pcs dapat potongan harga Rp "+numberWithCommas(response['harga'][0]['pot3'])+",- per produk</li>";
            }
            document.getElementById("isi_promo").innerHTML = isi_tmp;
          }else if(Number(response['detailproduk'][0]['label']) == 2){
            document.getElementById("detail_promo").className = "kolomdanger";
            document.getElementById("detail_promo").hidden = false;
            document.getElementById("judul_promo").innerHTML = "Discontinue";
            document.getElementById("isi_promo").innerHTML = "<li>Maaf, Produk tidak dapat di order kembali...</li>";
          }else{
            document.getElementById("detail_promo").hidden = true;
          }

        }

         document.getElementById("gambar_view").src = "../../admin/gambar/product/"+response['gambar'][0]['nama_file'];
         document.getElementById("gambar_brand").src = "../../admin/gambar/brand/"+response['brand'][response['detailproduk'][0]['brand']];
         var pilihan = "";
         for (var i = 0; i < response['gambar'].length; i++) {
           var tmp = "'../../admin/gambar/product/"+response['gambar'][i]['nama_file']+"'";
           pilihan += '<a class="item-thumb" onclick="detailImage('+tmp+')"><img src="../../admin/gambar/product/'+response['gambar'][i]['nama_file']+'"></a>';
         }
         document.getElementById("pilih_gambar").innerHTML = pilihan;
         document.getElementById("nama_barang").innerHTML = response['detailproduk'][0]['nama_barang'];
         document.getElementById("brand").innerHTML = response['detailproduk'][0]['nama_brand'];
         document.getElementById("kategori").innerHTML = response['kategori'][response['detailproduk'][0]['kategori']];
         document.getElementById("mainkategori").innerHTML = response['subkat'][0]['nama_main_kategori'];

         if (response['detailproduk'][0]['label'] != null && response['detailproduk'][0]['label'] != "") {
           document.getElementById("label").innerHTML = '<span class="badge badge-pill badge-'+response['label'][response['detailproduk'][0]['label']]['class']+'">'+response['label'][response['detailproduk'][0]['label']]['nama']+'</span>';
         }

         var desk = response['detailproduk'][0]['deskripsi'].split("font-size:11").join("font-size:14");
         desk = desk.split("font-size:12").join("font-size:14");
         desk = desk.split("font-size:13").join("font-size:14");
         document.getElementById("deskripsi").innerHTML = desk;

         if (response['detailproduk'][0]['jenis'] == "single") {
             if(Number(response['detailproduk'][0]['label']) == 2){
                 document.getElementById("dd_stok").className = "";
                document.getElementById("dd_stok").classList.add("text-danger");
                document.getElementById("dd_stok").innerHTML = "Discontinue";
            }else{
           if (Number(response['stok'][0]['jumlah']) > 5) {
             document.getElementById("dd_stok").className = "";
             document.getElementById("dd_stok").classList.add("text-success");
             document.getElementById("dd_stok").innerHTML = "Tersedia";
           }else if(Number(response['stok'][0]['jumlah']) < 1){
             document.getElementById("dd_stok").className = "";
             document.getElementById("dd_stok").classList.add("text-danger");
             document.getElementById("dd_stok").innerHTML = "Pre Order";
           }else{
             document.getElementById("dd_stok").className = "";
             document.getElementById("dd_stok").classList.add("text-warning");
             document.getElementById("dd_stok").innerHTML = "Terbatas";
           }
            }
           document.getElementById("multi_produk").innerHTML ="";
           document.getElementById("harga").innerHTML = "Rp "+numberWithCommas(response['harga'][0]['harga_retail'])+",-";
           document.getElementById("berat").innerHTML = response['detailproduk'][0]['berat']+" kg";
           document.getElementById("dt_sku").innerHTML = "Kode";
           document.getElementById("dd_sku").innerHTML = response['barang'][response['detailproduk'][0]['barang']]['no_sku'];
           document.getElementById("dt_keterangan").innerHTML = "Kolian";
           var keterangan = response['barang'][response['detailproduk'][0]['barang']]['keterangan'];
           if (keterangan == null) {
             keterangan = "-";
           }
           document.getElementById("dd_keterangan").innerHTML = keterangan;
         }else{
           var opsi = "";
           for (var i = 0; i < response['detailproduk'].length; i++) {
             opsi += '<option value="'+response['detailproduk'][i]['berat_multiple']+','+
             response['barang'][response['detailproduk'][i]['barang_multi']]['no_sku']+','+
             response['barang'][response['detailproduk'][i]['barang_multi']]['keterangan']+','+
             response['harga'][response['detailproduk'][i]['barang_multi']]['harga']+','+
             response['stok'][response['detailproduk'][i]['barang_multi']]['stok']+
             '">'+response['barang'][response['detailproduk'][i]['barang_multi']]['nama_barang']
             +'</option>';
           }

           document.getElementById("multi_produk").innerHTML = '<br><b>Pilihan Type:</b><select onchange="ChangePilihan()" class="form-control" id="pilihan_produk">'+opsi+'</select><br>';
           document.getElementById("harga").innerHTML = "Rp "+numberWithCommas(response['harga'][response['detailproduk'][0]['barang_multi']]['harga'])+",-";

           if (Number(response['stok'][response['detailproduk'][0]['barang_multi']]['stok']) > 5) {
             document.getElementById("dd_stok").className = "";
             document.getElementById("dd_stok").classList.add("text-success");
             document.getElementById("dd_stok").innerHTML = "Tersedia";
           }else if(Number(response['stok'][response['detailproduk'][0]['barang_multi']]['stok']) < 1){
             document.getElementById("dd_stok").className = "";
             document.getElementById("dd_stok").classList.add("text-danger");
             document.getElementById("dd_stok").innerHTML = "Pre Order";
           }else{
             document.getElementById("dd_stok").className = "";
             document.getElementById("dd_stok").classList.add("text-warning");
             document.getElementById("dd_stok").innerHTML = "Terbatas";
           }

           document.getElementById("berat").innerHTML = response['detailproduk'][0]['berat_multiple']+" kg";
           document.getElementById("dt_sku").innerHTML = "Kode";
           document.getElementById("dd_sku").innerHTML = response['barang'][response['detailproduk'][0]['barang_multi']]['no_sku'];
           document.getElementById("dt_keterangan").innerHTML = "Kolian";
           var keterangan = response['barang'][response['detailproduk'][0]['barang_multi']]['keterangan'];
           if (keterangan == null) {
             keterangan = "-";
           }
           document.getElementById("dd_keterangan").innerHTML = keterangan;
         }

         if (response['detailproduk'][0]['warna'] != null && response['detailproduk'][0]['warna'] != "") {
           document.getElementById("dt_warna").innerHTML = "Pilihan Warna";
           document.getElementById("warna").innerHTML = "";
           var res = response['detailproduk'][0]['warna'].split(",");
           for (var i = 0; i < (res.length - 1); i++) {
             document.getElementById("warna").innerHTML += response['warna'][res[i]]+"<br>";
           }
         }else{
           document.getElementById("dt_warna").innerHTML = "Pilihan Warna";
           document.getElementById("warna").innerHTML="-";
         }
     },
     complete: function() {
		swal.close()
	 }
   });
   }, 100);

}

function ChangePilihan(){
  var val = document.getElementById("pilihan_produk").value;
  var res = val.split(",");
  document.getElementById("harga").innerHTML = "Rp "+numberWithCommas(res[3])+",-";
  document.getElementById("berat").innerHTML = res[0]+" kg";
  document.getElementById("dd_sku").innerHTML = res[1];
  if (res[2] == "null") {
    res[2] = "-";
  }
  document.getElementById("dd_keterangan").innerHTML = res[2];

  if (Number(res[4]) > 5) {
    document.getElementById("dd_stok").className = "";
    document.getElementById("dd_stok").classList.add("text-success");
    document.getElementById("dd_stok").innerHTML = "Tersedia";
  }else if(Number(res[4]) < 1){
    document.getElementById("dd_stok").className = "";
    document.getElementById("dd_stok").classList.add("text-danger");
    document.getElementById("dd_stok").innerHTML = "Pre Order";
  }else{
    document.getElementById("dd_stok").className = "";
    document.getElementById("dd_stok").classList.add("text-warning");
    document.getElementById("dd_stok").innerHTML = "Terbatas";
  }
}

function detailImage(id){
  document.getElementById("gambar_view").src = id;
}

function ChangeKategori(){
  var mainkate = document.getElementById("main_kategoris").value;
  var kate = document.getElementById("kategoris");

  $.ajax({
     url: 'changekategori/'+mainkate,
     type: 'get',
     dataType: 'json',
     async: false,
     success: function(response){
       kate.innerHTML = "";
       var data = "<option selected>Semua</option>";
       for (var i = 0; i < response.length; i++) {
         data += "<option value='"+response[i]['id']+"'>"+response[i]['nama_kategori']+"</option>";
       }
       kate.innerHTML = data;
     }
   });

}
</script>
@endsection
