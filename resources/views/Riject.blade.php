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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Stok Rijek > <a href="https://stokis.app/?s=input+reject+stok+untuk+gudang+induk+dan+gudang+cabang" target="_blank">Input Barang Rijek</a></li>

                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">No. Rijek</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" id="no_reject" value="{{'RJ-'.date('ymd').$number}}" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Tanggal Input</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" id="tanggal_input" value="{{date('Y-m-d')}}" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Alasan Rijek Stok</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" maxlength="50" id="alasan" class="form-control" placeholder="keterangan (opsional)">
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-12"><strong>Petugas</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-2">QC</label>
                          <div class="col-lg-4">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="id_qc"  type="hidden" class="form-control">
                                    <input id="valqc" type="text" class="form-control" placeholder="Pilih QC Gudang" readonly style="background:#fff">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="cariqc()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                          <label class="col-lg-2">Driver</label>
                          <div class="col-lg-4">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="id_driver"  type="hidden" class="form-control">
                                    <input id="valdriver" type="text" class="form-control" placeholder="Pilih Pengirim" readonly style="background:#fff">
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
                          <label class="col-lg-2">Admin(G)</label>
                          <div class="col-lg-4">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" value="{{Auth::user()->name}}" readonly class="form-control">
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
                          <label class="col-lg-6"><strong>Supplier</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">ID Supplier</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="val_suplayer" type="text" class="form-control" placeholder="Pilih Supplier" readonly style="background:#fff">
                                    <input id="id_suplayer" type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="carikonsumen()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>

                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="nama_pemilik" readonly type="text" class="form-control">
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
                                      <p class="form-control1" id="alamat"></p>
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">No. HP</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="no_hp" readonly type="text" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-6"><strong>Cabang</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Cabang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <select id="id_gudang" class="form-control">
                                        <?php foreach ($gudang as $value): ?>
                                            <option value="{{$value->id}}">{{$value->nama_gudang}}</option>
                                        <?php endforeach; ?>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                      </div>

                      <div class="col-md-6">
                          <br>
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
                                    <input id="val_barang"  type="text" class="form-control" placeholder="Pilih Barang" readonly style="background:#fff">
                                    <input id="id_barang" type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="caribarang()" type="button"><i class="fas fa-folder-open"></i></button>
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
                                      <input type="text" readonly id="nama_barang" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Jumlah Rijek</label>
                          <div class="col-lg-4">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="number" id="riject" class="form-control" placeholder="Qty">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <!--label class="col-lg-3">Potongan</label-->
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="hidden" id="potongan" value="0" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br><br>
                        <center><button class="btn btn-primary btn-lg" onclick="Tambah()"> Tambahkan </button></center>
                        <br>
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
                              <th>Jumlah Rijek</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
								</div>
                <br>
                <center>
                  <button class="btn btn-success btn-lg" id="save" disabled onclick="Simpan()">Simpan</button>
                  <button class="btn btn-warning btn-lg" disabled id="cetak" onclick="Cetak()">Cetak Surat Jalan</button>
                  <!--button class="btn btn-danger btn-lg">Batal</button-->
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalsuplayer" role="dialog">
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
                          <th>ID Suplayer</th>
                          <th>Nama</th>
                          <th>No. Telepon</th>
                          <th>Alamat</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($suplayer as $key => $value): ?>
                      <tr onclick="pilih_suplayer('{{$value->id}}','{{$value->id_suplayer}}','{{$value->nama_pemilik}}','<?php echo $value->alamat;?>','{{$value->no_hp}}')">
                        <td>{{$value->id_suplayer}}</td>
                        <td>{{$value->nama_pemilik}}</td>
                        <td>{{$value->no_hp}}</td>
                        <td><?php echo $value->alamat; ?></td>
                      </tr>
                    <?php endforeach; ?>
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

      <div class="modal fade" id="modalqc" role="dialog">
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
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($karyawan as $value){ ?>
                        <tr onclick="pilihqc('{{$value->id}}','{{$value->nama}}')">
                            <td>{{$value->nik}}</td>
                            <td>{{$value->nama}}</td>
                            <td><?php echo $value->alamat; ?></td>
                            <td>{{$value->no_hp}}</td>
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

        <div class="modal fade" id="modaldriver" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                  <div class="table-responsive">
                  <table id="examples3" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>NIK</th>
                              <th>Nama</th>
                              <th>Alamat</th>
                              <th>No. Telepon</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($karyawan as $value){ ?>
                          <tr onclick="pilihdriver('{{$value->id}}','{{$value->nama}}')">
                              <td>{{$value->nik}}</td>
                              <td>{{$value->nama}}</td>
                              <td><?php echo $value->alamat; ?></td>
                              <td>{{$value->no_hp}}</td>
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

          <div class="modal fade" id="modelbarang" role="dialog">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">

                    <div class="table-responsive">
                    <table id="examples5" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No. SKU</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($barang as $value){ ?>
                            <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_sku}}','{{$value->nama_barang}}','{{$value->harga}}')">
                                <td>{{$value->no_sku}}</td>
                                <td>{{$value->nama_barang}}</td>
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

            <div class="modal fade" id="editing" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                      No. SKU :
                      <input type="text" id="edsku" readonly class="form-control">
                      Nama Barang :
                      <input type="text" id="ednamabarang" readonly class="form-control">
                      Jumlah Riject :
                      <input type="number" id="edriject" class="form-control">
                      <input type="hidden" id="edlastrow" class="form-control">
                      <input type="hidden" id="edid" class="form-control">
                      <br>
                      <center><button onclick="save()" class="btn btn-primary btn-lg">Update</button></center>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
var availablestok = 0;
function carikonsumen(){
  $('#modalsuplayer').modal('show');
}
function pilih_suplayer(id,id_suplayer,nama_pemilik,alamat,no_hp){
  $('#modalsuplayer').modal('hide');
  document.getElementById("val_suplayer").value = id_suplayer;
  document.getElementById("id_suplayer").value = id;
  document.getElementById("nama_pemilik").value = nama_pemilik;
  document.getElementById("alamat").innerHTML = alamat;
  document.getElementById("no_hp").value = no_hp;
}
function cariqc(){
  $('#modalqc').modal('show');
}
function caridriver(){
  $('#modaldriver').modal('show');
}
function pilihdriver(id,nama){
  $('#modaldriver').modal('hide');
  document.getElementById("valdriver").value = nama;
  document.getElementById("id_driver").value = id;
}
function pilihqc(id,nama){
  $('#modalqc').modal('hide');
  document.getElementById("valqc").value = nama;
  document.getElementById("id_qc").value = id;
}
function caribarang(){
  $('#modelbarang').modal('show');
}
function pilihbarang(barang,id,nama,harga){
  var gudang = document.getElementById("id_gudang").value;
  $.ajax({
     url: 'cekstok/'+gudang+"/"+barang,
     type: 'get',
     dataType: 'json',
     async: false,
     success: function(response){
       $('#modelbarang').modal('hide');
       document.getElementById("val_barang").value = id;
       document.getElementById("id_barang").value = barang;
       document.getElementById("nama_barang").value = nama;
       availablestok = response[0]['jumlah'];
     }
   });

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
      tempbarang[lastRow] = "";
      tempjumlah[lastRow] = "";

    }
  });
}
var tempbarang = [];
var tempjumlah = [];
function Tambah(){
  var no_sku = document.getElementById("val_barang").value;
  var nama_barang = document.getElementById("nama_barang").value;
  var riject = document.getElementById("riject").value;
  var id_barang = document.getElementById("id_barang").value;
  if (no_sku != "" && riject != "") {
    if (Number(riject) <= Number(availablestok)) {
      var table = document.getElementById("cart");
      var lastRow = table.rows.length;
      var row = table.insertRow(lastRow);
      row.id = lastRow;

      tempbarang[lastRow] = id_barang;
      tempjumlah[lastRow] = riject;

      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      var cell3 = row.insertCell(2);
      var cell4 = row.insertCell(3);

      var a = "'"+lastRow+"',"+"'"+no_sku+"',"+"'"+riject+"',"+"'"+id_barang+"',"+"'"+nama_barang+"'";

      cell1.innerHTML = no_sku;
      cell2.innerHTML = nama_barang;
      cell3.innerHTML = "<p id=riject"+lastRow+">"+riject+"</p>";
      cell4.innerHTML = '<button class="btn btn-default" onclick="deletecart('+lastRow+')"><i class="icon-trash"></i></button>'+
                        '<button class="btn btn-default" onclick="updatecart('+a+')"><i class="icon-pencil"></i></button>';

      document.getElementById("id_barang").value = "";
      document.getElementById("val_barang").value = "";
      document.getElementById("nama_barang").value = "";
      document.getElementById("riject").value = "";

      document.getElementById("save").disabled = false;
    }else{
      Swal.fire(
        'Proses melebihi stok !',
        'Stok yang tersedia di gudang hanya = '+availablestok,
        'question'
      );
    }
  }else{
    alert("Isi Semua Field");
  }
}

function updatecart(lastRow,no_sku,riject,id_barang,nama_barang){
  document.getElementById("edsku").value = no_sku;
  var rj = document.getElementById("riject"+lastRow).innerHTML;
  document.getElementById("edriject").value = rj;
  document.getElementById("edlastrow").value = lastRow;
  document.getElementById("edid").value = id_barang;
  document.getElementById("ednamabarang").value = nama_barang;
  $('#editing').modal('show');
}

function save(){
  var id = document.getElementById("edid").value;
  var nama_barang = document.getElementById("ednamabarang").value;
  var lastrow = document.getElementById("edlastrow").value;
  var riject = document.getElementById("edriject").value;
  var sku = document.getElementById("edsku").value;


  tempjumlah[lastrow] = riject;

  document.getElementById("riject"+lastrow).innerHTML = riject;

  $('#editing').modal('hide');

}

function Cetak(){
  var no_transfer = document.getElementById("no_reject").value;
  window.open("{{url('/surat/')}}"+'/'+no_transfer);
}

function Simpan(){
  //document.getElementById("save").disabled = true;
  var no_rejects = document.getElementById("no_reject").value;
  var tanggal_inputs = document.getElementById("tanggal_input").value;
  var id_suplayers = document.getElementById("id_suplayer").value;
  var id_gudangs = document.getElementById("id_gudang").value;
  var qcs = document.getElementById("id_qc").value;
  var drivers = document.getElementById("id_driver").value;
  var alasan = document.getElementById("alasan").value;

        if (id_suplayers != "" && qcs != "" && drivers != "") {

              $.post("postbarangriject",
                {alasan:alasan, no_reject:no_rejects, tanggal_input:tanggal_inputs, qc:qcs, driver:drivers, id_suplayer:id_suplayers,
                 id_gudang:id_gudangs, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
                    {

                      var newriject = data;
                      var tempid = "";
                      var tempsum = "";
                      for (var i = 0; i < tempbarang.length; i++) {
                        tempid += tempbarang[i]+",";
                        tempsum += tempjumlah[i]+",";
                      }
                      console.log(tempid);
                      console.log(tempsum);
                      $.post("postdetailbarangriject",
                        {no_reject:newriject, id_barang:tempid ,id_gudang:id_gudangs, jumlah:tempsum , _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
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
                                      document.getElementById("cetak").disabled = false;
                                      //location.href="{{url('/inputriject/')}}";
                                    }else{
                                      document.getElementById("save").disabled = true;
                                      document.getElementById("cetak").disabled = false;
                                      //location.href="{{url('/inputriject/')}}";
                                    }
                                  });
                            }).fail(function(jqXHR, textStatus, errorThrown)
                        {
                            alert(textStatus);
                        });

                    }).fail(function(jqXHR, textStatus, errorThrown)
                {
                    alert(textStatus);
                });
        }else{
          alert("isi semua data");
        }
}

</script>
@endsection
