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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Transfer Stok > <a href="https://stokis.app/?s=proses+pengiriman+barang+transfer+stok+dan+cetak+surat+jalan" target="_blank">Pengiriman Stok ke Gudang Lain</a></li>
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
                                  <div class="input-group">
                                    <input id="no_transfer" type="text" class="form-control" placeholder="Pilih No. Order Stok" readonly style="background:#fff">
                                    <input id="id_transfer" type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="caritransfer()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
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
                                      <input type="date" id="tgl_order" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">Status Transfer</label>
                          <div class="col-lg-4">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly value="proses" id="status_transfer" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Tanggal Kirim</label>
                          <div class="col-lg-4">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" readonly value="{{date('Y-m-d')}}" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <br><br>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-6"><strong>Pengorder</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Gudang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="nama_dari" type="text" readonly class="form-control">
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
                                      <p class="form-control1" id="alamat_dari">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-6"><strong>Pemroses</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Gudang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="nama_kepada" type="text" readonly class="form-control">
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
                                      <p class="form-control1" id="alamat_kepada">
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>
                      <br>
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-6"><strong>Petugas</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">QC</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="nama_qc"  type="text" class="form-control" placeholder="Pilih QC Gudang" readonly style="background:#fff">
                                    <input id="id_qc" type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="cariqc()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Driver</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="nama_driver"  type="text" class="form-control" placeholder="Pilih Pengirim" readonly style="background:#fff">
                                    <input id="id_driver" type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="caridriver()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Admin Order</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input readonly type="text" id="admin" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Admin Proses</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input readonly type="text" value="{{Auth::user()->name}}" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                      </div>

                    </div>

                  <br><hr>
				<div class="table-responsive">
                  <table id="cart" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>Item No.</th>
                              <th>Jumlah Order</th>
                              <th>Jumlah Stok</th>
                              <th>Jumlah Proses</th>
                              <th>Jumlah Pending</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
								</div>
                <br>
                <center>
                  <button class="btn btn-success btn-lg" id="simpan" onclick="Simpan()">Simpan</button>
                    <button class="btn btn-warning btn-lg" disabled id="cetak" onclick="Cetak()">Cetak Surat Jalan</button>
                  <!--button class="btn btn-danger btn-lg" onclick="Batalkan()">Batal</button-->
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="transfer" role="dialog">
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
                          <th>No Transfer</th>
                          <th>Gudang Pengirim</th>
                          <th>Gudang Pemohon</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($transfer as $value){ ?>
                      <tr onclick="pilihbarang('{{$value->id}}','{{$value->tanggal_order}}','{{$value->no_transfer}}','{{$value->dari}}','{{$value->kepada}}','{{$value->alamat_dari}}','{{$value->alamat_kepada}}','{{$value->adminp}}','{{$value->idp}}')">
                          <td>{{$value->no_transfer}}</td>
                          <td>{{$value->kepada}}</td>
                          <td>{{$value->dari}}</td>
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

      <div class="modal fade" id="driver" role="dialog">
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
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>No HP</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($driver as $value){ ?>
                        <tr onclick="pilihdriver('{{$value->id}}','{{$value->nama}}')">
                            <td>{{$value->nik}}</td>
                            <td>{{$value->nama}}</td>
                            <td>{{$value->no_hp}}</td
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

        <div class="modal fade" id="qc" role="dialog">
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
                              <th>NIK</th>
                              <th>Nama</th>
                              <th>No HP</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($qc as $value){ ?>
                          <tr onclick="pilihqc('{{$value->id}}','{{$value->nama}}')">
                              <td>{{$value->nik}}</td>
                              <td>{{$value->nama}}</td>
                              <td>{{$value->no_hp}}</td
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

          <div class="modal fade" id="edit" role="dialog">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-2"></div>
                      <div class="col-md-3">
                        <label>Nama Barang :</label>
                      </div>
                      <div class="col-md-4">
                        <p id="nama_barang"></p>
                      </div>
                    </div>
                    
                    <div hidden class="row">
                      <div class="col-md-2"></div>
                      <div class="col-md-3">
                        <label>Item No. :</label>
                      </div>
                      <div class="col-md-4">
                        <p id="part_number"></p>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-2"></div>
                      <div class="col-md-3">
                        <label>Jumlah Stok :</label>
                      </div>
                      <div class="col-md-4">
                        <input type="number" readonly id="stok" class="form-control">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-2"></div>
                      <div class="col-md-3">
                        <label>Jumlah Order :</label>
                      </div>
                      <div class="col-md-4">
                        <input type="number" readonly id="order" class="form-control">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-2"></div>
                      <div class="col-md-3">
                        <label>Jumlah Proses :</label>
                      </div>
                      <div class="col-md-4">
                        <input type="number" min="0" max="0" id="proses" class="form-control">
                      </div>
                    </div>
                    <br>
                    <center><button onclick="rubah()" id="update" class="btn btn-primary">Update</button></center>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    var tempid = [];
    var tempid_barang = [];
    var gudang = [];
    var idrubah = null;
    function caritransfer(){
      $('#transfer').modal('show');
    }
    function caridriver(){
      $('#driver').modal('show');
    }
    function cariqc(){
      $('#qc').modal('show');
    }
    function Batalkan(){
      location.reload();
    }
    function pilihbarang(id,tgl_order,no_transfer,dari,kepada,alamat_dari,alamat_kepada,adminp,idp){
      $('#transfer').modal('hide');
      document.getElementById("no_transfer").value = no_transfer;
      document.getElementById("id_transfer").value = id;
      document.getElementById("nama_dari").value = dari;
      document.getElementById("alamat_dari").innerHTML = alamat_dari;
      document.getElementById("nama_kepada").value = kepada;
      document.getElementById("alamat_kepada").innerHTML = alamat_kepada;
      document.getElementById("tgl_order").value = tgl_order;
      document.getElementById("admin").value = adminp;

      $.ajax({
         url: 'pilihtransfer/'+no_transfer,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           var myTable = document.getElementById("cart");
           var rowCount = myTable.rows.length;
           for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
           }
           tempid = [];
           tempid_barang = [];
           gudang = [];
           for (var i = 0; i < response.length; i++) {
             var table = document.getElementById("cart");
             var lastRow = table.rows.length;
             var row = table.insertRow(lastRow);
             //row.id = lastRow;

             tempid[i] = response[i]['id'];
             tempid_barang[i] = response[i]['id_barang'];
             gudang[i] = response[i]['kepada'];

             var cell1 = row.insertCell(0);
             var cell2 = row.insertCell(1);
             var cell3 = row.insertCell(2);
             var cell4 = row.insertCell(3);
             var cell5 = row.insertCell(4);
             var cell6 = row.insertCell(5);
             var cell7 = row.insertCell(6);
             var cell8 = row.insertCell(7);

             cell1.innerHTML = response[i]['no_sku'];
             cell2.innerHTML = response[i]['nama_barang'];
             cell3.innerHTML = response[i]['part_number'];
             cell4.innerHTML = "<p id=jumlah"+response[i]['id']+">"+response[i]['jumlah']+"</p>";
             cell5.innerHTML = response[i]['stok'];
             var proses = response[i]['proses'];
             var pending = response[i]['pending'];
             if (proses == null) {
                proses= "0";
             }
             if (pending == null) {
                pending= "0";
             }
             cell6.innerHTML = "<p id="+response[i]['id']+">"+proses+"</p>";
             cell7.innerHTML = "<p id=pen"+response[i]['id']+">"+pending+"</p>";
             var a = "'"+response[i]['nama_barang']+"'";
             cell8.innerHTML = '<button class="btn btn-default" onclick="editJumlah('+a+','+response[i]['id']+','+response[i]['stok']+','+response[i]['jumlah']+','+proses+')"><i class="icon-pencil"></i></button>';

           }
         }


       });

    }

    function editJumlah(nama,id,stok,order,proses,part_number){
      if(stok < 1){
        alert("Stok Kosong !");
      }else{
        idrubah = id;
        var pros = document.getElementById(id).innerHTML;
        document.getElementById("stok").value = stok;
        document.getElementById("order").value = order;
        document.getElementById("proses").max = stok;
        document.getElementById("proses").value = pros;
        document.getElementById("nama_barang").innerHTML = nama;
        document.getElementById("part_number").innerHTML = part_number;
        $('#edit').modal('show');
      }
    }

    function rubah(){
      var value = document.getElementById("proses").value;
      var value1 = document.getElementById("order").value;
      var stok = document.getElementById("stok").value;
      if (Number(value) <= Number(stok) && Number(value) <= Number(value1)) {
        $.ajax({
           url: 'updateproses/'+value+"/"+idrubah+"/"+value1,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById(idrubah).innerHTML = value;
             var pend = value1 - value;
             document.getElementById("pen"+idrubah).innerHTML = pend;
             $('#edit').modal('hide');
           }
         });
      }else{
        alert('Proses melebihi stok !');
      }
    }

    function pilihdriver(id,nama){
      $('#driver').modal('hide');
      document.getElementById("id_driver").value = id;
      document.getElementById("nama_driver").value = nama;
    }
    function pilihqc(id,nama){
      $('#qc').modal('hide');
      document.getElementById("id_qc").value = id;
      document.getElementById("nama_qc").value = nama;
    }

    function Cetak(){
      var no_transfer = document.getElementById("no_transfer").value;
      window.open("{{url('/surattransfer/')}}"+'/'+no_transfer);
    }

    function Simpan(){
      document.getElementById('simpan').disabled = true;
      var no_transfer = document.getElementById("id_transfer").value;
      var driver = document.getElementById("id_driver").value;
      var qc = document.getElementById("id_qc").value;
      var next = new Boolean("");
      for (i = 0; i < tempid.length; i++) {
        var cek = Number(document.getElementById(tempid[i]).innerHTML);
        if (cek > 0) {
          next = true;
        }
      }

      if (driver != "" && qc != "" && no_transfer != "" && next == true) {
          document.getElementById('simpan').disabled = true;

          var gudangs = "";
          var tempid_barangs = "";
          var value = "";

          for (var i = 0; i < tempid.length; i++) {
              gudangs += gudang[i]+",";
              tempid_barangs += tempid_barang[i]+",";
              value += document.getElementById(tempid[i]).innerHTML+",";
          }

          $.ajax({
             url: 'updatetransferstok/'+no_transfer+'/'+driver+'/'+qc,
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(response){
                 $.ajax({
                    url: 'updatedetailtransferstok/'+tempid_barangs+'/'+gudangs+'/'+value,
                    type: 'get',
                    dataType: 'json',
                    async: false,
                    success: function(response){
                      console.log(response);
                      Swal.fire({
                          title: 'Berhasil',
                          icon: 'success',
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Lanjutkan!'
                        }).then((result) => {
                          document.getElementById('simpan').disabled = true;
                          document.getElementById('update').disabled = true;
                          document.getElementById('cetak').disabled = false;
                        });
                    }
                  });
             }
           });

      }else{
        alert("Isi dahulu semuanya");
      }

    }
    </script>
@endsection
