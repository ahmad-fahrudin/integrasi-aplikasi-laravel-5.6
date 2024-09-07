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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Transfer Stok > <a href="https://stokis.app/?s=proses+penerimaan+transfer+stok+setelah+proses+pengiriman+barang+dari+cabang+lain" target="_blank">Penerimaan Stok dari Gudang Lain</a></li>
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
                                    <input id="no_transfer"  type="text" class="form-control" placeholder="Pilih No. Order Stok" readonly style="background:#fff">
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
                          <label class="col-lg-3">Tanggal Proses</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="tanggal_order" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3"><b>Pengorder</b></label>
                          <div class="col-lg-8">
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Gudang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="dari" class="form-control">
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
                                      <p class="form-control1" id="alamat_dari"></p>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3"><b>Pemroses</b></label>
                          <div class="col-lg-8">
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Gudang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="kepada" class="form-control">
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
                                      <p class="form-control1" id="alamat_kepada"></p>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                      </div>

                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">Status Transfer</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                    <select id="status_transfer" class="form-control">
                                      <option value="terkirim">Terkirim</option>
                                      <option value="kirim ulang">Kirim Ulang</option>
                                    </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Tanggal Kirim</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" readonly value="{{date('Y-m-d')}}" id="tanggal_terkirim" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3"><b>Petugas</b></label>
                          <div class="col-lg-8">
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Admin Order</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="adminp" class="form-control">
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
                                      <input type="text" readonly id="driver" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">QC</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="qc" class="form-control">
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
                                      <input type="text" readonly id="adming" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Admin Penerima</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly value="{{Auth::user()->name}}" id="adminv" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
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
                              <th>Jumlah Dikirim</th>
                              <th>Jumlah Batal</th>
                              <th>Jumlah Diterima</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
								</div>
                <br>
                <center>
                  <button class="btn btn-success btn-lg" onclick="Simpan()" id="save" disabled>Simpan</button>
                  <!--button class="btn btn-danger btn-lg">Batal</button-->
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
                      <tr onclick="pilihbarang('{{$value->id}}','{{$value->tanggal_order}}','{{$value->no_transfer}}','{{$value->dari}}','{{$value->alamat_dari}}'
                                                ,'{{$value->kepada}}','{{$value->alamat_kepada}}','{{$value->adminp}}','{{$value->driver}}','{{$value->qc}}'
                                                ,'{{$value->adming}}')">
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
                        <input type="text" readonly id="namabenda" class="form-control">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-2"></div>
                      <div class="col-md-3">
                        <label>Dikirim :</label>
                      </div>
                      <div class="col-md-4">
                        <input type="number" readonly id="dikirim" class="form-control">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-2"></div>
                      <div class="col-md-3">
                        <label>Jumlah Diterima :</label>
                      </div>
                      <div class="col-md-4">
                        <input type="number" min="0" max="0" id="diterima" class="form-control">
                      </div>
                    </div>
                    <br>
                    <center><button onclick="rubah()" class="btn btn-primary">Update</button></center>

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
    var gudang_retur = [];
    var idrubah = null;
    var nama_barangs = [];

    function caritransfer(){
      $('#transfer').modal('show');
    }
    function caridriver(){
      $('#driver').modal('show');
    }
    function cariqc(){
      $('#qc').modal('show');
    }
    function pilihbarang(id,tgl_kirim,no_transfer,dari,alamat_dari,kepada,alamat_kepada,adminp,driver,qc,adming){
      $('#transfer').modal('hide');
      document.getElementById("no_transfer").value = no_transfer;
      document.getElementById("id_transfer").value = id;
      document.getElementById("tanggal_order").value = tgl_kirim;
      document.getElementById("dari").value = dari;
      document.getElementById("alamat_dari").innerHTML = alamat_dari;
      document.getElementById("kepada").value = kepada;
      document.getElementById("alamat_kepada").innerHTML = alamat_kepada;
      document.getElementById("adminp").value = adminp;
      document.getElementById("driver").value = driver;
      document.getElementById("qc").value = qc;
      document.getElementById("adming").value = adming;
      $.ajax({
         url: 'pilihtransfer2/'+no_transfer,
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
           gudang_retur = [];
           nama_barangs = [];
           for (var i = 0; i < response.length; i++) {
             var table = document.getElementById("cart");
             var lastRow = table.rows.length;
             var row = table.insertRow(lastRow);
             row.id = lastRow;

             tempid[i] = response[i]['id'];
             tempid_barang[i] = response[i]['id_barang'];
             gudang[i] = response[i]['dari'];
             gudang_retur[i] = response[i]['kepada'];
             nama_barangs[response[i]['id']] = response[i]['nama_barang'];

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
             cell4.innerHTML = response[i]['jumlah'];
             var kembali = response[i]['retur'];
             if (kembali == null) {
                kembali= "-";
             }
             var acc = response[i]['terkirim'];
             if (acc == null) {
                acc= "-";
             }
             if (Number(response[i]['terkirim']) > 0) {
                cell7.innerHTML = "<p id=acc"+response[i]['id']+">"+acc+"</p>";
             }else{
               cell7.innerHTML = "<p id=acc"+response[i]['id']+">"+response[i]['proses']+"</p>";
               $.ajax({
                  url: 'updatepenerimaan/'+response[i]['proses']+"/"+response[i]['proses']+"/"+response[i]['id'],
                  type: 'get',
                  dataType: 'json',
                  async: false,
                  success: function(response){
                    document.getElementById("save").disabled = false;
                  }
                });
             }
             var nama = response[i]['nama_barang'];
             cell5.innerHTML = response[i]['proses'];
             cell6.innerHTML = "<p id=retur"+response[i]['id']+">"+kembali+"</p>";
             cell8.innerHTML = '<button class="btn btn-default" onclick="editJumlah('+response[i]['id']
                                +','+response[i]['proses']+')"><i class="icon-pencil"></i></button>';
           }
         }
       });

    }

    function editJumlah(id,dikirim,diterima){
        idrubah = id;
        console.log(nama_barangs[id]);
        document.getElementById("namabenda").value = nama_barangs[id];
        document.getElementById("dikirim").value = dikirim;
        document.getElementById("diterima").max = dikirim;
        document.getElementById("diterima").min = 0;
        document.getElementById("diterima").value = 0;
        $('#edit').modal('show');
    }

    function rubah(){
      var value = document.getElementById("dikirim").value;
      var value1 = document.getElementById("diterima").value;
      if (Number(value1) <= Number(value)) {
        $.ajax({
           url: 'updatepenerimaan/'+value+"/"+value1+"/"+idrubah,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("save").disabled = false;
             var valretur = "retur"+idrubah;
             var valacc = "acc"+idrubah;
             var ret = value - value1;
             document.getElementById(valretur).innerHTML = ret;
             document.getElementById(valacc).innerHTML = value1;
             $('#edit').modal('hide');
           }
         });
       }else{
         alert('Melebihi jumlah!');
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

    function Simpan(){
      var no_transfers = document.getElementById("id_transfer").value;
      var statuss = document.getElementById("status_transfer").value;
      if (no_transfer != "") {
          document.getElementById("save").disabled = true;
          var terkirims;
          var returs;
          var barangs;
          var gudangs;
          var gudang_returs;
          for (var x = 0; x < tempid.length; x++) {
            var valacc = "acc"+tempid[x];
            var valretur = "retur"+tempid[x];
            var value = document.getElementById(valacc).innerHTML;
            var value1 = document.getElementById(valretur).innerHTML;
            terkirims += ","+String(value);
            returs += ","+String(value1);
            barangs += ","+String(tempid_barang[x]);
            gudangs += ","+String(gudang[x]);
            gudang_returs += ","+String(gudang_retur[x]);
          }

          $.post("postdetailtransferpenerimaan",
            {no_transfer:no_transfers, status:statuss, barang : barangs , gudang:gudangs, terkirim:terkirims, retur:returs , gudang_retur:gudang_returs, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
                {
                    no_fakturs = data;
                    Swal.fire({
                        title: 'Berhasil',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Lanjutkan!'
                      }).then((result) => {
                        if (result.value) {
                          location.href ="{{url('/datatransferstok/')}}";
                        }else{
                          location.href ="{{url('/datatransferstok/')}}";
                        }
                      });
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
