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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Transfer Stok > <a href="https://stokis.app/?s=mengelola+daftar+order+stok+untuk+persiapan+barang+yang+akan+di+transfer+stok+ke+cabang+lain" target="_blank">Daftar Permintaan Stok Gudang</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Berdasarkan</strong></p>
                    <form name="form1" action="{{url('daftarorderstok')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                    <div class="form-group">
                       <div class="row">
                           <label class="col-lg-2">Tanggal Order</label>
                           <div class="col-lg-3">
                               <div class="row">
                                   <div class="col-md-10">
                                       <input type="date" name="from" id="datefrom"
                                       <?php if (isset($from)): ?>
                                         value="{{$from}}"
                                       <?php endif; ?>
                                       onchange="change()" class="form-control">
                                   </div>
                                   <div class="col-md-2">
                                       s/d
                                   </div>
                               </div>
                           </div>
                           <div class="col-lg-3">
                               <div class="row">
                                   <div class="col-md-10">
                                       <input type="date" name="to" id="dateto"
                                       <?php if (isset($to)): ?>
                                         value="{{$to}}"
                                       <?php endif; ?>
                                       onchange="change()" class="form-control">
                                   </div>
                               </div>
                           </div>
                       </div>
                      </div>
                      <div class="form-group">
                         <div class="row">
                             <label class="col-lg-2">Permintaan Stok ke</label>
                             <div class="col-lg-3">
                                 <div class="row">
                                     <div class="col-md-10">
                                       <select name="dari" id="dari" onchange="change2()" class="form-control">
                                         <?php foreach ($gudang as $value): ?>
                                         <option value="{{$value->id}}"
                                           <?php if (isset($dari)): ?>
                                             <?php if ($value->id == $dari): ?>
                                               selected
                                             <?php endif; ?>
                                           <?php endif; ?>
                                         >{{$value->nama_gudang}}</option>
                                         <?php endforeach; ?>
                                       </select>
                                     </div>
                                 </div>
                             </div>
                             <!--div class="col-lg-3">
                                 <div class="row">
                                     <div class="col-md-10">
                                       <select name="kepada" id="kepada" onchange="change2()" class="form-control">
                                         <?php foreach ($gudang as $value): ?>
                                         <option value="{{$value->id}}"
                                           <?php if (isset($kepada)): ?>
                                             <?php if ($value->id == $kepada): ?>
                                               selected
                                             <?php endif; ?>
                                           <?php endif; ?>
                                          >{{$value->nama_gudang}}</option>
                                         <?php endforeach; ?>
                                       </select>
                                     </div>
                                 </div>
                             </div-->
                         </div>
                        </div>
                        <div class="form-group">
                           <div class="col-lg-12">
                               <center><button disabled id="filter" class="btn btn-success btn-lg">Filter Data</button></center>
                           </div>
                        </div>
                      </form>
                      </div>
                        <hr><br>
									<div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. Transfer</th>
                              <th>Tanggal Order</th>
                              <th>Pengorder</th>
                              <th>Pemroses</th>
                              <th>Status</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($transfer_stok as $value) { ?>
                          <tr>
                              <td>{{$value->no_transfer}}</td>
                              <td>{{tanggal($value->tanggal_order)}}</td>
                              <td>{{$value->dari}}</td>
                              <td>{{$value->kepada}}</td>
                              <td>{{$value->status_transfer}}</td>
                              <td>
                                <?php
                                  if (Auth::user()->level == "1" || Auth::user()->id == $value->admin){
                                    $ck = 1;
                                  }else{
                                    $ck = 0;
                                } ?>
                                <button onclick="Rincian('{{$value->no_transfer}}','{{$ck}}')" class="btn btn-primary">Lihat Rincian</button>
                                <button onclick="PrintDetail('{{$value->no_transfer}}')" class="btn btn-warning">Cetak SO</button>
                                <?php if (Auth::user()->level == "1" || $value->admin == Auth::user()->id): ?>
                                  <button onclick="Cancel('{{$value->no_transfer}}')" class="btn btn-danger">Cancel Order</button>
                                <?php endif; ?>
                              </td>
                          </tr>
                         <?php } ?>
                      </tbody>
                  </table>
                  <br>
                  <button onclick="PrintDetailAll()" class="btn btn-light btn-outline-primary">Cetak Semua SO Gudang</button></td>
                  <hr>
								</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="detail" role="dialog">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
              <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                    <tr>
                        <th>No Transfer</th>
                        <th>No. SKU</th>
                        <th>Nama Barang</th>
                        <th>Item No.</th>
                        <th>Jumlah Order</th>
                        <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
              </table>
            </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    var val_dari = null;
    <?php if (isset($dari)) { ?>
      val_dari = {{$dari}}
    <?php } ?>
    function change(){
      var empt = document.getElementById("datefrom").value;
      var empt2 = document.getElementById("dateto").value;
      if (empt != "" && empt2 != ""){
          val_dari = document.getElementById("dari").value;
          document.getElementById("filter").disabled = false;
        }
    }

    function change2(){
      var empt = document.getElementById("dari").value;
      //var v1 = document.getElementsByTagName("option")[empt].value;
      //var empt2 = document.getElementById("kepada").value;
      //var v2 = document.getElementsByTagName("option")[empt2].value;
      if (empt != "")
        {
          //alert(empt + empt2);
          val_dari = document.getElementById("dari").value;
          document.getElementById("filter").disabled = false;
        }
    }

    function Cancel(value){
      Swal.fire(
        'Delete '+value+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/deleteOrderStok/')}}"+"/"+value;
        }
      });
    }

    function Deleted(nama,id){
      Swal.fire(
        'Delete '+nama+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/deleteitemtransfer/')}}"+"/"+id;
        }
      });
    }

    function PrintDetail(value){
      window.open("{{url('/printdetailbarang/')}}"+'/'+value);
      //location.href ="{{url('/printdetailbarang/')}}"+"/"+value;
    }
    function Rincian(value,cek)
    {
      var myTable = document.getElementById("examples");
      var rowCount = myTable.rows.length;
      for (var x=rowCount-1; x>0; x--) {
       myTable.deleteRow(x);
      }

        $.ajax({
           url: 'detailTransferStok/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             for (var i = 0; i < response.length; i++) {
               var table = document.getElementById("examples");
               var lastRow = table.rows.length;
               var row = table.insertRow(lastRow);
               row.id = lastRow;

               var cell1 = row.insertCell(0);
               var cell2 = row.insertCell(1);
               var cell3 = row.insertCell(2);
               var cell4 = row.insertCell(3);
               var cell5 = row.insertCell(4);
               var cell6 = row.insertCell(5);

               cell1.innerHTML = response[i]['no_transfer'];
               cell2.innerHTML = response[i]['no_sku'];
               cell3.innerHTML = response[i]['nama_barang'];
               cell4.innerHTML = response[i]['part_number'];
               cell5.innerHTML = response[i]['jumlah'];
               var vl = "'"+response[i]['nama_barang']+"',"+response[i]['id_link'];
               if (cek == '1') {
                 cell6.innerHTML = '<button onclick="Deleted('+vl+')" class="btn btn-danger">Hapus</button>';
               }
             }

             $('#detail').modal('show');
           }
         });
    }

    function PrintDetailAll(){
      var from = document.getElementById("datefrom").value;
      var to = document.getElementById("dateto").value;
      var dari = val_dari;
      if (from == "") { from="null" }
      if (to == "") { to="null" }
      if (dari == "") { dari="null" }
      window.open("{{url('/printdetailorderstok/')}}"+'/'+from+'/'+to+'/'+dari);
    }

    </script>

@endsection
