@extends('template/nav')
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb ">
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Stok Gudang Barang > <a href="https://stokis.app/?s=data+stok+gudang+dan+aset+stok" target="_blank">Data Stok Barang</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Berdasarkan</strong></p>
                      <div class="form-group">
                        <form action="{{url('stokgudang')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                         <div class="row">
                             <label class="col-lg-1">Cabang</label>
                             <div class="col-lg-2">
                                 <div class="row">
                                   <div class="col-md-12">
                                     <select onchange="change()" name="id_gudang" id="gudang" required class="form-control">
                                       <option <?php
                                       if(isset($select)){
                                         if ($select == "all"){ echo "selected"; }
                                       }
                                       ?>
                                       value="all">Semua</option>
                                       <?php foreach ($gudang as $value) { ?>
                                       <option
                                       <?php
                                       if(isset($select)){
                                         if ($select == $value->id){ echo "selected"; }
                                       }else{
                                         if(Auth::user()->gudang == $value->id){
                                             echo "selected";
                                         }
                                       } ?>
                                       value="{{$value->id}}">{{$value->nama_gudang}}</option>
                                       <?php } ?>
                                     </select>
                                   </div>
                                 </div>
                             </div>
                             <br>
                             <br>
                             <label class="col-lg-2">Jumlah Stok Dibawah</label>
                             <div class="col-lg-2">
                                 <div class="row">
                                     <div class="col-md-14">
                                         <input onchange="change()" name="jumlah" id="jumlah" <?php if (isset($s)) { echo "value=".$s; } ?> type="text" class="form-control" placeholder="100">
                                     </div>
                                 </div>
                             </div>
                            

                         </div>
                         <br>
                         <div class="row">
                           <label class="col-lg-1">Tampilkan</label>
                           <div class="col-lg-2">
                               <div class="row">
                                   <div class="col-md-12">
                                       <select onchange="change()" name="stok" id="stok" required class="form-control">
                                         <option value="all"
                                         <?php if (isset($st) && $st == "all"): ?>
                                           selected
                                         <?php endif; ?>
                                         >Semua</option>
                                         <option value="stok"
                                         <?php if (isset($st) && $st == "stok"): ?>
                                           selected
                                         <?php endif; ?>
                                         >Ready Stok</option>
                                       </select>
                                   </div>
                               </div>
                           </div>
                           <br><br>
                           <?php if (Auth::user()->level == "1" || Auth::user()->level == "4" || (Auth::user()->level == "3" && Auth::user()->gudang == "1")): ?>
                           <label class="col-lg-2">Lokasi Kulakan</label>
                           <div class="col-lg-2">
                               <div class="row">
                                   <div class="col-md-14">
                                       <input onchange="change()" name="lokasi" maxlength="20" id="lokasi" <?php if (isset($x)) { echo "value=".$x; } ?> type="text" class="form-control" placeholder="Ketik nama kota/kab...">
                                   </div>
                               </div>
                           </div>
                           <?php endif; ?>
                           <br><br>
                           <label class="col-lg-0.5">&emsp;</label>
                           <label class="col-lg-1.5">Daftar Kulakan</label>
                           <div class="col-lg-1">
                               <div class="row">
                                   <div class="col-md-12">
                                     <input type="checkbox" onchange="change()" <?php if (isset($kulak)) { echo "checked"; } ?> name="kulak" value="1">
                                   </div>
                               </div>
                           </div>

                         </div>
                      </div>

                      <div class="form-group">
                         <div class="col-lg-9">
                             <center><button disabled id="filter" class="btn btn-success btn-lg">Filter Data</button></center>
                         </div>
                      </div>
                    </form>
                    </div>
                    <hr><br>
									<div class="table-responsive">
                  <table id="kulakan2" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>Item No.</th>
                              <th>Group</th>
                              <th>Jumlah Stok</th>
                              <th>Order Masuk</th>
                              <th>Kulakan</th>
                              <?php if (Auth::user()->level == "1" || Auth::user()->level == "4" || (Auth::user()->level == "3" && Auth::user()->gudang == "1")): ?>
                              <th>Lokasi Kulakan</th>
                              <?php endif; ?>
                              <th>Keterangan</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php if (isset($kulak)){ ?>

                          <?php foreach ($kulakan as $value) {
                            if($value['orderan'] - $value['stok'] > 0){
                                $kulakin = 0;
                            ?>
                            <tr>
                                <td>{{$value['no_sku']}}</td>
                                <td>{{$value['nama_barang']}}</td>
                                <td>{{$value['part_number']}}</td>
                                <td>{{$value['kategori']}}</td>
                                <td align="left">
                                    {{ribuan($value['stok'])}} {{$value['satuan_pcs']}} 
                                    
                                    <?php if ($value['pcs_koli'] == 1){
                                     echo "";
                                     
                                    }else{
                                     echo "( ";
                                     echo ribuan(($value['stok']) % ($value['pcs_koli'])). " " .$value['satuan_pcs']. ",  " .floor(($value['stok']) / ($value['pcs_koli'])). " " .$value['satuan_koli']."";
                                     echo " )";
                                     
                                    } ?> 
                                    
                                    </td>
                                
                                <td align="center">{{ribuan($value['orderan'])}} {{$value['satuan_pcs']}}</td>
                                <td align="left">
                                  <?php if ($value['orderan'] - $value['stok'] > 0){
                                    echo ribuan($value['orderan'] - $value['stok']);
                                    $kulakin +=($value['orderan'] - $value['stok']);
                                    echo $value['satuan_pcs'];
                                  }else{
                                    echo "0" . " " .$value['satuan_pcs']. "";
                                  } ?>
                                  
                                  <?php if ($value['pcs_koli'] == 1){
                                     echo "";
                                     
                                    }else{
                                     echo "( ";
                                     echo ribuan(($kulakin) % ($value['pcs_koli'])). " " .$value['satuan_pcs']. ",  " .floor(($kulakin) / ($value['pcs_koli'])). " " .$value['satuan_koli']."";
                                     echo " )";
                                     
                                    } ?> 
                                </td>
                                <?php if (Auth::user()->level == "1" || Auth::user()->level == "4" || (Auth::user()->level == "3" && Auth::user()->gudang == "1")): ?>
                                <td>{{$value['lokasi']}}</td>
                                <?php endif; ?>

                                <td><?php if ($value['pcs_koli'] > 0){
                                    echo "1 " .$value['satuan_koli']. " @ " .$value['pcs_koli']. " " .$value['satuan_pcs'].",";
                                  }else{
                                    echo "-";
                                  } ?> 
                                  
                                  <?php if ($value['keterangan'] != "NULL"){
                                    echo "{$value['keterangan']}";
                                  }else{
                                    echo "-";
                                  } ?>
                                  </td>
                                <td>
                                  <?php if ($value['id_barcode'] == "" || $value['id_barcode'] == null){ ?>
                                    <button class="btn btn-default" onclick="printing('{{$value['no_sku']}}')"><i class="icon-printer"></i></button>
                                    <a href="<?php echo 'aset/barcode.php'; ?>?text={{$value['no_sku']}}&codetype=code128&print=true" download="{{$value['no_sku']}}|{{removedot($value['nama_barang'])}}"><i class="icon-arrow-down-circle"></i></a>
                                  <?php }else{ ?>
                                    <button class="btn btn-default" onclick="printing('{{$value['id_barcode']}}')"><i class="icon-printer"></i></button>
                                    <a href="<?php echo 'aset/barcode.php'; ?>?text={{$value['id_barcode']}}&codetype=code128&print=true" download="{{$value['id_barcode']}}|{{removedot($value['nama_barang'])}}"><i class="icon-arrow-down-circle"></i></a>
                                  <?php } ?>
                                </td>
                            </tr>
                          <?php } } ?>

                        <?php }else{ ?>

                          <?php foreach ($kulakan as $value) {
                              $kulakin = 0;
                            ?>
                            <tr>
                                <td>{{$value['no_sku']}}</td>
                                <td>{{$value['nama_barang']}}</td>
                                <td>{{$value['part_number']}}</td>
                                <td>{{$value['kategori']}}</td>
                                <td align="left">
                                    {{ribuan($value['stok'])}} {{$value['satuan_pcs']}} 
                                    
                                    <?php if ($value['pcs_koli'] == 1){
                                     echo "";
                                     
                                    }else{
                                     echo "( ";
                                     echo ribuan(($value['stok']) % ($value['pcs_koli'])). " " .$value['satuan_pcs']. ",  " .floor(($value['stok']) / ($value['pcs_koli'])). " " .$value['satuan_koli']."";
                                     echo " )";
                                     
                                    } ?> 
                                    
                                    </td>
                                
                                <td align="left">{{ribuan($value['orderan'])}} {{$value['satuan_pcs']}}</td>
                                <td align="left">
                                  <?php if ($value['orderan'] - $value['stok'] > 0){
                                    echo ribuan($value['orderan'] - $value['stok']);
                                    $kulakin +=($value['orderan'] - $value['stok']);
                                    echo $value['satuan_pcs'];
                                  }else{
                                    echo "0" . " " .$value['satuan_pcs']. "";
                                  } ?>
                                  
                                  <?php if ($value['pcs_koli'] == 1 || $value['pcs_koli'] < $kulakin || $kulakin == 0 ){
                                     echo "";
                                     
                                    }else{
                                     echo "( ";
                                     echo ribuan(($kulakin) % ($value['pcs_koli'])). " " .$value['satuan_pcs']. ",  " .floor(($kulakin) / ($value['pcs_koli'])). " " .$value['satuan_koli']."";
                                     echo " )";
                                     
                                    } ?> 
                                </td>
                                <?php if (Auth::user()->level == "1" || Auth::user()->level == "4" || (Auth::user()->level == "3" && Auth::user()->gudang == "1")): ?>
                                <td>{{$value['lokasi']}}</td>
                                <?php endif; ?>

                                <td><?php if ($value['pcs_koli'] != 1){
                                    echo "1 " .$value['satuan_koli']. " @ " .$value['pcs_koli']. " " .$value['satuan_pcs'].",";
                                  }else{
                                    echo "-";
                                  } ?> 
                                  
                                  <?php if ($value['keterangan'] != "NULL"){
                                    echo "{$value['keterangan']}";
                                  }else{
                                    echo "-";
                                  } ?>
                                  </td>
                                <td>
                                  <?php if ($value['id_barcode'] == "" || $value['id_barcode'] == null){ ?>
                                    <button class="btn btn-default" onclick="printing('{{$value['no_sku']}}')"><i class="icon-printer"></i></button>
                                    <a href="<?php echo 'aset/barcode.php'; ?>?text={{$value['no_sku']}}&codetype=code128&print=true" download="{{$value['no_sku']}}|{{removedot($value['nama_barang'])}}"><i class="icon-arrow-down-circle"></i></a>
                                  <?php }else{ ?>
                                    <button class="btn btn-default" onclick="printing('{{$value['id_barcode']}}')"><i class="icon-printer"></i></button>
                                    <a href="<?php echo 'aset/barcode.php'; ?>?text={{$value['id_barcode']}}&codetype=code128&print=true" download="{{$value['id_barcode']}}|{{removedot($value['nama_barang'])}}"><i class="icon-arrow-down-circle"></i></a>
                                  <?php } ?>
                                </td>
                            </tr>
                           <?php } ?>
                        <?php } ?>
                      </tbody>
                      
                  </table>
								</div>
                <br>
                <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                <div class="row">
                    <label class="col-lg-2">Nilai Aset Stok: </label>
                    <div class="col-lg-2">
                        <div class="row">
                            <div class="col-md-11">
                                <input type="text" class="form-control" disabled value="Rp {{ribuan($asset)}},-">
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
    function ImagetoPrint(source) {
    return "<html><head><script>function step1(){\n" +
            "setTimeout('step2()', 10);}\n" +
            "function step2(){window.print();window.close()}\n" +
            "</scri" + "pt></head><body onload='step1()'>\n" +
            "<img width=150 src='" + source + "' /></body></html>";
    }

    function printing(value){
      window.open(
        "<?php echo 'aset/print.php'; ?>?text="+value+"&codetype=code128&print=true",
        '_blank' // <- This is what makes it open in a new window.
      );
     /*Pagelink = "about:blank";
     var source = "<?php echo 'aset/barcode.php'; ?>?text="+value+"&codetype=code128&print=true&size=55";
     var pwa = window.open(Pagelink, "_new");
     pwa.document.open();
     pwa.document.write(ImagetoPrint(source));
     pwa.document.close();*/
    }
    function change(){
      document.getElementById("filter").disabled = false;
    }
    </script>
@endsection
