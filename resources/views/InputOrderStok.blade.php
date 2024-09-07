@extends('template/nav')
@section('content')
    <script src="{{asset('system/assets/ckeditor/ckeditor.js')}}"></script>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb ">
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Transfer Stok > <a href="https://stokis.app/?s=input+order+stok+pada+proses+transfer+stok+dari+kepada+gudang+cabang" target="_blank">Input Permintaan Stok ke Gudang lain</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">No. Transfer</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <?php date_default_timezone_set('Asia/Jakarta'); ?>
                                      <input type="text" id="no_transfer" value="{{'TRF'.date('ymd').$number}}" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Tanggal Order</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" id="tgl_order" readonly value="{{date('Y-m-d')}}" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">Status Transfer</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly value="order" id="status_transfer" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Admin</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" id="admin" readonly value="{{Auth::user()->name}}" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <br>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-6"><strong>Dari (Pengorder)</strong></label>
                        </div>
                        <br>
                        <?php if (Auth::user()->level == '1'){ ?>
                          <div class="row">
                            <label class="col-lg-3">Nama Cabang</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-11">
                                      <div class="input-group">
                                        <input id="id_gedungmaster"  type="text" class="form-control" placeholder="Pilih Gudang / Cabang" readonly style="background:#fff">
                                        <input id="dari" type="hidden" class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" onclick="carigedungall()" type="button"><i class="fas fa-folder-open"></i></button>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <label class="col-lg-3">Alamat</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-11">
                                        <p class="form-control1" id="alamatmaster">
                                    </div>
                                </div>
                            </div>
                          </div>
                        <?php }else{ ?>
                        <?php foreach ($gudang as $value): ?>
                        <div class="row">
                          <label class="col-lg-3">Nama Cabang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input readonly type="text" value="{{$value->nama_gudang}}" class="form-control">
                                      <input readonly id="dari" type="hidden" value="{{$value->id}}" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Alamat</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <span class="form-control1"><?php echo $value->alamat; ?></span>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <?php endforeach; ?>
                        <?php } ?>
                        <br>
                        <div class="row">
                          <label class="col-lg-6"><strong>Kepada (Pemroses)</strong></label>
                        </div>
                        <br>
                        <?php if (Auth::user()->level == '1'){ ?>
                          <div class="row">
                            <label class="col-lg-3">Nama Cabang</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-11">
                                      <div class="input-group">
                                        <input id="id_gedung"  type="text" class="form-control" placeholder="Pilih Gudang / Cabang" readonly style="background:#fff">
                                        <input id="valgedung" type="hidden" class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" onclick="carigedungall2()" type="button"><i class="fas fa-folder-open"></i></button>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <label class="col-lg-3">Alamat</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-11">
                                        <p class="form-control1" id="alamat">
                                    </div>
                                </div>
                            </div>
                          </div>
                        <?php } else { ?>
                        <div class="row">
                          <label class="col-lg-3">Nama Cabang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                    <div class="input-group">
                                      <input id="id_gedung"  type="text" class="form-control" placeholder="Pilih Gudang" readonly style="background:#fff">
                                      <input id="valgedung" type="hidden" class="form-control">
                                      <div class="input-group-append">
                                          <button class="btn btn-outline-secondary" onclick="carigedung()" type="button"><i class="fas fa-folder-open"></i></button>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Alamat</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <p class="form-control1" id="alamat">
                                  </div>
                              </div>
                          </div>
                        </div>
                      <?php } ?>
                      </div>

                      <div class="col-md-6">
                          <br><br><br>
                        <div class="row">
                          <label class="col-lg-6"><strong>Data Barang</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">No. SKU</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                    <div class="input-group">
                                      <input id="id_barang"  type="text" class="form-control" placeholder="Pilih Barang" readonly style="background:#fff">
                                      <input id="valbarang" type="hidden" class="form-control">
                                      <div class="input-group-append">
                                          <button class="btn btn-outline-secondary" id="cari_barang" onclick="caribarang()" type="button"><i class="fas fa-folder-open"></i></button>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Barang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="nama_barang" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Jumlah</label>
                          <div class="col-lg-4">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="jumlah" type="number" class="form-control" placeholder="Qty">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <center><button onclick="tambah()" id="tambah" class="btn btn-primary btn-lg"> Tambah </button></center>
                      </div>

                    </div>

                  <br><hr>
				<div class="table-responsive">
                  <table id="cart" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>Jumlah</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
								</div>
                <br>
                <center>
                  <button class="btn btn-success btn-lg" id="save" onclick="Simpan()">Simpan</button>

                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="barang" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
              <table id="exam" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>No SKU</th>
                          <th>Nama Barang</th>
                          <th>Item No.</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($barang as $value){ ?>
                      <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_sku}}','{{$value->nama_barang}}','{{$value->part_number}}')">
                          <td>{{$value->no_sku}}</td>
                          <td>{{$value->nama_barang}}</td>
                          <td>{{$value->part_number}}</td>
                      </tr>
                     <?php } ?>
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

      <div class="modal fade" id="gedung" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                <div class="table-responsive">
                <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($kepada as $value){ ?>
                        <tr onclick="pilihgedung('{{$value->id}}','{{$value->nama_gudang}}','{{$value->alamat}}')">
                            <td>{{$value->nama_gudang}}</td>
                            <td><?php echo $value->alamat; ?></td>
                        </tr>
                       <?php } ?>
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

        <div class="modal fade" id="gedungall" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                  <div class="table-responsive">
                  <table id="examples1" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>Nama</th>
                              <th>Alamat</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($gudang_full as $value){ ?>
                          <tr onclick="pilihgedungall('{{$value->id}}','{{$value->nama_gudang}}','{{$value->alamat}}')">
                              <td>{{$value->nama_gudang}}</td>
                              <td><?php echo $value->alamat; ?></td>
                          </tr>
                         <?php } ?>
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

          <div class="modal fade" id="gedungall2" role="dialog">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">

                    <div class="table-responsive">
                    <table id="examples2" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($gudang_full as $value){ ?>
                            <tr onclick="pilihgedungall2('{{$value->id}}','{{$value->nama_gudang}}','{{$value->alamat}}')">
                                <td>{{$value->nama_gudang}}</td>
                                <td><?php echo $value->alamat; ?></td>
                            </tr>
                           <?php } ?>
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
    var input = document.getElementById("jumlah");
    input.addEventListener("keyup", function(event) {
      if (event.keyCode === 13) {
       event.preventDefault();
       document.getElementById("tambah").click();
      }
    });

    input.addEventListener("keyup", function(event) {
      if (event.keyCode === 16) {
       event.preventDefault();
       document.getElementById("cari_barang").click();
      }
    });

    input.addEventListener("keyup", function(event) {
      if (event.keyCode === 32) {
       event.preventDefault();
       document.getElementById("save").click();
      }
    });

    var cek = true;
    var tempbarang = [];
    var tempjumlah = [];
    function caribarang(){
      var to = document.getElementById("valgedung").value;
      var from = document.getElementById("dari").value;
      if (to == "" || from == "") {
        alert("Input Gudang Terlebih Dahulu!")
      }else{
      var myTable = document.getElementById("exam");
      var rowCount = myTable.rows.length;
      for (var x=rowCount-1; x>0; x--) {
       myTable.deleteRow(x);
      }

      $.ajax({
         url: 'detailBarang/'+to+'/'+from,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           if (cek) {
             $(document).ready(function() {
                      $('#exam').DataTable( {
                        "pagingType": "full_numbers"
                      } );
             });
           }
           cek = false;
           for (var i = 0; i < response.length; i++) {

             var table = document.getElementById("exam").getElementsByTagName('tbody')[0];
             var lastRow = table.rows.length;
             var row = table.insertRow(lastRow);
             row.setAttribute("class","dd")
             row.id = lastRow;

             var cell1 = row.insertCell(0);
             var cell2 = row.insertCell(1);
             var cell3 = row.insertCell(2);

             var id = response[i]['id'];
             var no_sku = response[i]['no_sku'];
             var nama_barang = response[i]['nama_barang'];
             var part_number = response[i]['part_number'];

             cell1.innerHTML = '<p onclick="pilihbarang('+id+','+"'"+no_sku+"'"+','+"'"+nama_barang+"'"+')">'+response[i]['no_sku']+'</p>';
             cell2.innerHTML = '<p onclick="pilihbarang('+id+','+"'"+no_sku+"'"+','+"'"+nama_barang+"'"+')">'+response[i]['nama_barang']+'</p>';
             cell3.innerHTML = '<p onclick="pilihbarang('+id+','+"'"+no_sku+"'"+','+"'"+nama_barang+"'"+')">'+response[i]['part_number']+'</p>';
           }

           $('#barang').modal('show');
         }
       });
     }

    }
    function pilihbarang(barang,id,nama_barang,part_number){
      $('#barang').modal('hide');
      document.getElementById("valbarang").value = barang;
      document.getElementById("id_barang").value = id;
      document.getElementById("nama_barang").value = nama_barang;
      document.getElementById("part_number").value = part_number;
    }

    function Cek(){
      //alert("cek");
      console.log(tempbarang);
      console.log(tempjumlah);
    }

    function carigedung(){
      $('#gedung').modal('show');
    }
    function carigedungall(){
      $('#gedungall').modal('show');
    }
    function carigedungall2(){
      $('#gedungall2').modal('show');
    }
    function pilihgedung(id,nama,alamat){
      $('#gedung').modal('hide');
      document.getElementById("valgedung").value = id;
      document.getElementById("id_gedung").value = nama;
      document.getElementById("alamat").innerHTML = alamat;
      //CKEDITOR.instances['alamat'].setData(alamat);
    }

    function pilihgedungall(id,nama,alamat){
      $('#gedungall').modal('hide');
      document.getElementById("dari").value = id;
      document.getElementById("id_gedungmaster").value = nama;
      document.getElementById("alamatmaster").innerHTML = alamat;
    }

    function pilihgedungall2(id,nama,alamat){
      $('#gedungall2').modal('hide');
      document.getElementById("valgedung").value = id;
      document.getElementById("id_gedung").value = nama;
      document.getElementById("alamat").innerHTML = alamat;
    }

    function deletecart(lastRow){
      Swal.fire(
        'Delete this?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          var row = document.getElementById(lastRow);
          row.parentNode.removeChild(row);
          delete tempbarang[lastRow];
          delete tempjumlah[lastRow];
        }
      });

    }

    function tambah(){
      var a = parseInt(document.getElementById("jumlah").value);
      var id_barang = document.getElementById("id_barang").value;
      var nama_barang = document.getElementById("nama_barang").value;
      var valueid = document.getElementById("valbarang").value;
      if (a > 0 && id_barang != "") {
        var table = document.getElementById("cart");
        var lastRow = table.rows.length;
        var row = table.insertRow(lastRow);
        row.id = lastRow;

        tempbarang[lastRow] = valueid;
        tempjumlah[lastRow] = a;

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        cell1.innerHTML = id_barang;
        cell2.innerHTML = nama_barang;
        cell3.innerHTML = a;
        cell4.innerHTML = '<button class="btn btn-default" onclick="deletecart('+lastRow+')"><i class="icon-trash"></i></button>';
        document.getElementById("id_barang").value = "";
        document.getElementById("nama_barang").value = "";
        document.getElementById("jumlah").value = "";

      }else{
        alert("Isikan Jumlah Terlebih Dahulu!");
      }
    }

    function Simpan(){
      var no_transfers = document.getElementById("no_transfer").value;
      var tanggal_orders = document.getElementById("tgl_order").value;
      var status_transfers = document.getElementById("status_transfer").value;
      var daris = document.getElementById("dari").value;
      var kepadas = document.getElementById("valgedung").value;
      var admins = document.getElementById("admin").value;

      var id_barangs = "";
      var jumlahbarangs = "";
      for (var i = 0; i < tempbarang.length; i++) {
        if (tempbarang[i] != "") {
          id_barangs += tempbarang[i]+",";
          jumlahbarangs += tempjumlah[i]+","
        }
      }

      if (kepadas != "") {
            $.post("posttransferstok",
              {no_transfer:no_transfers, tanggal_order:tanggal_orders, status_transfer:status_transfers, dari:daris, admin:admins, kepada:kepadas, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
                  {
                      var newtransfer = data;
                      //for (var i = 0; i < tempbarang.length; i++) {
                        //if (tempjumlah[i] > 0) {
                        $.post("postdetailtransferstok",
                          {no_transfer:newtransfer, tanggal_order:tanggal_orders, status_transfer:status_transfers, dari:daris, admin:admins, kepada:kepadas, id_barang:id_barangs, jumlah:jumlahbarangs, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
                              {

                                    Swal.fire({
                                        title: 'Berhasil',
                                        icon: 'success',
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Lanjutkan!'
                                      }).then((result) => {
                                        if (result.value) {
                                          document.getElementById("save").disabled = true;
                                          location.href="{{url('/inputorderstok/')}}";
                                        }else{
                                          document.getElementById("save").disabled = true;
                                          location.href="{{url('/inputorderstok/')}}";
                                        }
                                      });

                              }).fail(function(jqXHR, textStatus, errorThrown)
                          {
                              alert(textStatus);
                          });
                        //}
                      //}
                  }).fail(function(jqXHR, textStatus, errorThrown)
              {
                  alert(textStatus);
              });
      }else{
        alert("Isi dahulu semuanya");
      }

    }
    </script>
@endsection
