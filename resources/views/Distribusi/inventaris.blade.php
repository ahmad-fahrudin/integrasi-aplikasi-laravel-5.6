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
                             <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Inventaris > <a href="https://stokis.app/?s=input+inventaris" target="_blank">Input Barang Inventaris</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">No. Inventaris</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <?php date_default_timezone_set('Asia/Jakarta'); ?>
                                      <input type="text" id="no_kwitansi" value="{{'IN-'.date('ymd').$number}}" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Tanggal</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" id="tanggal_order" value="{{date('Y-m-d')}}" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row" hidden>
                          <label class="col-lg-3">Status Produk</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" id="status_barang" value="order" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-12"><strong>Petugas</strong></label>
                        </div>
                        
                        <div class="row" hidden>
                          <label class="col-lg-2">Sales</label>
                          <div class="col-lg-4">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="id_sales"  type="hidden" class="form-control">
                                    <input id="valsales" type="text" class="form-control" placeholder="Pilih Sales">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="carisales()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                         </div>
                        <div class="row">
                          <label class="col-lg-3">Admin</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" value="{{Auth::user()->username}}" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Cabang / Gudang</label>
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
                      </div>
                    </div>

                    <br>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-6"><strong>Penanggung Jawab Inventaris</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">ID Karyawan</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="val_konsumen" type="text" class="form-control" placeholder="Pilih Penerima" readonly style="background-color:#fff">
                                    <input id="id_konsumen" type="hidden" class="form-control">
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
                        <br>
                        <div class="row">
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
                        <div class="row" hidden>
                          <label class="col-lg-3">Status Member</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input readonly type="text" class="form-control1" id="status_member"></p>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                      </div>

                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-6"><strong>Produk Sebagai Inventaris</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">No. SKU</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="val_barang"  type="text" class="form-control" placeholder="Pilih Produk" readonly style="background-color:#fff">
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
                          <label class="col-lg-3">Nama Produk</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="nama_barang" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row" hidden>
                          <label class="col-lg-3">Rekomendasi Harga</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="harga" class="form-control" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="row" hidden>
                          <label class="col-lg-3">Harga Jual</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="harga_jual" class="form-control" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-lg-3">Jumlah</label>
                          <div class="col-lg-3">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="number" id="order" onchange="cekpotongan()" class="form-control" placeholder="Qty">
                                  </div>
                              </div>
                          </div>
                        </div>

                        <div id="divpotonganpromo" class="row" hidden>
                          <label class="col-lg-3">Potongan Promo (Per Pcs)</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" id="potonganpromo" readonly value="0" class="form-control" value="0" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>


                        <br>
                        <div id="divpotongan" class="row" hidden>
                          <label class="col-lg-3">Potongan Promo (Per Pcs)</label>
                          <div class="col-lg-3">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" id="potongan" readonly value="0" class="form-control" value="0">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <center><button class="btn btn-primary btn-lg" onclick="Tambah()"> Tambahkan </button></center>
                        <br>
                        
                      </div>
                    </div>

                  <br>
                  <hr>
				<div class="table-responsive">
                  <table id="cart" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. SKU</th>
                              <th>Nama Produk</th>
                              <th>Jumlah Order</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <tr hidden>
                          <td colspan="5"><center>Total Bayar</center></td>
                          <td colspan="2"><center><p id="total_bayar">0</p></center></td>
                        </tr>
                      </tbody>
                  </table>
								</div>
                <br>
                <center>
                  <button class="btn btn-success btn-lg" id="save" disabled onclick="Simpan()">Simpan</button>
                  <button onclick="Cetak()" id="cetak" disabled class="btn btn-warning btn-lg">Cetak SPB</button>

                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalkonsumen" role="dialog">
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
                          <th>ID Member</th>
                          <th>Nama Pemilik</th>
                          <th>No HP</th>
                          <th>Alamat</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($pelanggan as $key => $value): ?>
                      <tr onclick="pilihkonsumen('{{$value->id}}','{{$value->id_konsumen}}','{{$value->nama_pemilik}}','{{$value->alamat}}','{{$value->no_hp}}','{{$value->nama}}','{{$value->pengembang}}','{{$value->nama_leader}}','{{$value->leader}}','{{$value->kota}}','{{$value->kategori}}','{{$value->jenis_konsumen}}','{{$value->manager}}')">
                        <td>{{$value->id_konsumen}}</td>
                        <td>{{$value->nama_pemilik}}</td>
                        <td>{{$value->no_hp}}</td>
                        <td><?php echo $value->alamat; ?></td>
                        </td>
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

      <div class="modal fade" id="modalstaff" role="dialog">
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
                            <th>ID Member</th>
                            <th>Nama Pemilik</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($staff as $key => $value): ?>
                          <tr onclick="pilihkonsumen('{{$value->id}}','{{$value->nik}}','{{$value->nama}}','{{$value->alamat}}','{{$value->no_hp}}','{{$value->nama}}','{{$value->id}}','{{$value->nama}}','{{$value->id}}','')">
                          <td>{{$value->nik}}</td>
                          <td>{{$value->nama}}</td>
                          <td>{{$value->no_hp}}</td>
                          <td><?php echo $value->alamat; ?></td>
                          </td>
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

      <div class="modal fade" id="modalsales" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                <div class="table-responsive">
                <table id="examples6" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama Petugas</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($sales as $value){ ?>
                        <tr onclick="pilihsales('{{$value->id}}','{{$value->nama}}')">
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

        <div class="modal fade" id="modalpengembang" role="dialog">
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
                              <th>Nama Petugas</th>
                              <th>Alamat</th>
                              <th>No HP</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($pengembang as $value){ ?>
                          <tr onclick="pilihpengembang('{{$value->id}}','{{$value->nama}}')">
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

          <div class="modal fade" id="modalleader" role="dialog">
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
                                <th>Nama Petugas</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($leader as $value){ ?>
                            <tr onclick="pilihleader('{{$value->id}}','{{$value->nama}}')">
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
                                    <th>No SKU</th>
                                    <th>Nama Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($barang as $value){ ?>
                                <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_sku}}','{{$value->nama_barang}}','{{$value->harga}}','{{$value->harga_hp}}'
                                                          ,'{{$value->qty1}}','{{$value->pot1}}','{{$value->qty2}}','{{$value->pot2}}','{{$value->qty3}}','{{$value->pot3}}','{{$value->label}}','{{$value->harga_hpp}}','{{$value->harga_reseller}}','{{$value->harga_agen}}','{{$value->harga_retail}}')">
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
                          Order :
                          <input type="number" id="edorder" class="form-control">
                          Harga Jual :
                          <input type="number" id="edhargajual" class="form-control">
                          <input type="hidden" id="edpotongan" class="form-control">
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
var cek_Status_konsumen = "";
const status_konsumen_member = ["None","Retail","Reseller","Agen","Distributor"];

new AutoNumeric('#harga_jual', "euroPos");
new AutoNumeric('#harga', "euroPos");
new AutoNumeric('#potonganpromo', "euroPos");
//new AutoNumeric('#potongan', "euroPos");
var total_bayar = 0;
var tempbarang = [];
var tempjumlah = [];
var tempharga_jual = [];
var temppotongan = [];
var temppotonganpromo = [];
var tempsub_total = [];
var tempharga_net = [];

var prv = "<?= allprevillage()?>";
var qty1 = 0;
var pot1 = 0;
var qty2 = 0;
var pot2 = 0;
var qty3 = 0;
var pot3 = 0;

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

var stok_barang = 0;

function pilihbarang(barang,id,nama,harga,harga_hp,qty1v,pot1v,qty2v,pot2v,qty3v,pot3v,label,harga_hpp,harga_reseller,harga_agen,harga_retail){
  $('#modelbarang').modal('hide');
  document.getElementById("val_barang").value = id;
  document.getElementById("id_barang").value = barang;
  document.getElementById("nama_barang").value = nama;

  if (cek_Status_konsumen == "Distributor") {
    AutoNumeric.getAutoNumericElement('#harga').set(harga);
  }else if(cek_Status_konsumen == "Agen"){
    AutoNumeric.getAutoNumericElement('#harga').set(harga_agen);
  }else if(cek_Status_konsumen == "Reseller"){
    AutoNumeric.getAutoNumericElement('#harga').set(harga_reseller);
  }else{
    AutoNumeric.getAutoNumericElement('#harga').set(harga_retail);
  }

  if (label == 1 || label == "1") {
    qty1 = qty1v;
    qty2 = qty2v;
    qty3 = qty3v;
    pot1 = pot1v;
    pot2 = pot2v;
    pot3 = pot3v;
  }else{
    qty1 = 0;
    qty2 = 0;
    qty3 = 0;
    pot1 = 0;
    pot2 = 0;
    pot3 = 0;
    document.getElementById("potongan").value = 0;
    document.getElementById("divpotongan").hidden = "true";
  }

  var gd = document.getElementById("id_gudang").value;
  var ck_prv = prv.split(",");
  var cek_previllage = false;
  for (var i = 0; i < ck_prv.length; i++) {
    if (Number(gd) == ck_prv[i]) {
      cek_previllage = true;
    }
  }

  var gds = document.getElementById("id_gudang").value;
  $.ajax({
     url: 'getstokbar/'+barang+"/"+gds,
     type: 'get',
     dataType: 'json',
     async: false,
     success: function(response){
       stok_barang = Number(response);
     }
   });


}

function pilihkonsumen(id,id_konsumen,nama_pemilik,alamat,no_hp,nama,pengembang,nama_leader,leader,kota,kategori,jenis_konsumen,manager){
  $('#modalkonsumen').modal('hide');
  $('#modalstaff').modal('hide');
  document.getElementById("val_konsumen").value = id_konsumen;
  document.getElementById("id_konsumen").value = id;
  document.getElementById("nama_pemilik").value = nama_pemilik;
  document.getElementById("alamat").innerHTML = alamat;
  document.getElementById("no_hp").value = no_hp;

}

function pilihsales(id,nama){
  $('#modalsales').modal('hide');
  document.getElementById("valsales").value = nama;
  document.getElementById("id_sales").value = id;
}

function pilihpengembang(id,nama){
  $('#modalpengembang').modal('hide');
  document.getElementById("valpengembang").value = nama;
  document.getElementById("id_pengembang").value = id;
}

function pilihleader(id,nama){
  $('#modalleader').modal('hide');
  document.getElementById("valleader").value = nama;
  document.getElementById("id_leader").value = id;
}


function cekpotongan(){
  var cek = document.getElementById("order").value;
  var el = document.getElementById("divpotongan");
  var gd = document.getElementById("id_gudang").value;

  var ck_prv = prv.split(",");
  var cek_previllage = false;
  for (var i = 0; i < ck_prv.length; i++) {
    if (Number(gd) == ck_prv[i]) {
      cek_previllage = true;
    }
  }
  if (cek_previllage) {
    el.hidden = true;
  }else{
    if (qty1 != 0 && Number(cek) >= qty1) {
      if (Number(cek) >= Number(qty3)) {
        document.getElementById("potongan").value = numberWithCommas(pot3);
      }else if(Number(cek) >= Number(qty2)){
        document.getElementById("potongan").value = numberWithCommas(pot2);
      }else if (Number(cek) >= Number(qty1)) {
        document.getElementById("potongan").value = numberWithCommas(pot1);
      }else{
        document.getElementById("potongan").value = 0;
      }
      el.hidden = false;
    }else{
      document.getElementById("potongan").value = 0;
      el.hidden = true;
    }
  }
}

function carikonsumen(){
    $('#modalstaff').modal('show');
}
function carisales(){
  $('#modalsales').modal('show');
}
function caripengembang(){
  $('#modalpengembang').modal('show');
}
function carileader(){
  $('#modalleader').modal('show');
}

function caribarang(){
  $('#modelbarang').modal('show');
}
function Tambah(){

  var no_sku = document.getElementById("val_barang").value;
  var nama_barang = document.getElementById("nama_barang").value;
  var order = document.getElementById("order").value;
  var harga_jual = document.getElementById("harga_jual").value;
  harga_jual = harga_jual.split(".").join("");
  var potongan = document.getElementById("potongan").value;
  var id_barang = document.getElementById("id_barang").value;
  var harga_net = document.getElementById("harga").value;
  harga_net = harga_net.split(".").join("");
  potongan = potongan.split(".").join("");

  var potonganpromo = document.getElementById("potonganpromo").value;
  potonganpromo = potonganpromo.split(".").join("");

  var totalpotongan = Number(potonganpromo)+Number(potongan);

  if (Number(stok_barang) >= Number(order)) {
  if (no_sku != "" && order != "" && harga_jual != "" && potongan!= "") {
    var table = document.getElementById("cart");
    var lastRow = table.rows.length - 1;
    var row = table.insertRow(lastRow);
    row.id = lastRow;

    var subtotal = order * ( harga_jual - totalpotongan);
    tempbarang[lastRow] = id_barang;
    tempjumlah[lastRow] = order;
    tempharga_jual[lastRow] = harga_jual;
    temppotongan[lastRow] = totalpotongan;
    temppotonganpromo[lastRow] = potonganpromo;
    tempsub_total[lastRow] = subtotal;
    tempharga_net[lastRow] = harga_net;

    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    cell1.innerHTML = no_sku;
    cell2.innerHTML = nama_barang;
    cell3.innerHTML = "<p id=order"+lastRow+">"+order+"</p>";
    cell4.innerHTML = '<button class="btn btn-default" onclick="deletecart('+lastRow+','+subtotal+')"><i class="icon-trash"></i></button>'+
                      '<button class="btn btn-default" onclick="updatecart('+lastRow+','+subtotal+','+order+','+harga_jual+','+totalpotongan+')"><i class="icon-pencil"></i></button>';
    var sum = tempsub_total.reduce(function(a, b){ return a + b; }, 0);
    document.getElementById("total_bayar").innerHTML = numberWithCommas(sum);

    document.getElementById("id_barang").value = "";
    document.getElementById("val_barang").value = "";
    document.getElementById("nama_barang").value = "";
    document.getElementById("harga").value = "";
    document.getElementById("order").value = "";
    document.getElementById("harga_jual").value = "";
    //document.getElementById("potongan").value = "";
    document.getElementById("divpotongan").hidden = "true";
    document.getElementById("save").disabled = false;

    document.getElementById("divpotonganpromo").hidden = true;
  }else{
    alert("Isi Semua Field");
  }
}else{
  alert("Stok hanya "+stok_barang);
}
}

function updatecart(lastRow,sub,order,harga_jual,potongan){
  document.getElementById("edorder").value = order;
  document.getElementById("edhargajual").value = harga_jual;
  document.getElementById("edpotongan").value = potongan;
  document.getElementById("edid").value = lastRow;
  $('#editing').modal('show');
}

/*$(document).ready(function() {
    var table = $('#examp').DataTable();
    $('#examp tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        //alert( 'You clicked on '+data[0]+'\'s row' );
        pilihkonsumen(data_id[data[0]],data[0],data[1],data[3],data[2],data_nama[data[0]],data_pengembang[data[0]]);
    } );
} );

$(document).ready(function() {
    var table = $('#exampes').DataTable();
    $('#exampes tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        //alert( 'You clicked on '+data[0]+'\'s row' );
        pilihkonsumen(data_id[data[0]],data[0],data[1],data[3],data[2],data_nama[data[0]],data_pengembang[data[0]]);
    } );
} );*/
//window.onload = function(){
  //createkonsumen();
//};

var cek = true;
var data_id = [];
var data_nama = [];
var data_pengembang = [];
function createkonsumen(){
  var kategori = document.getElementById("kategori").value;
  var status = document.getElementById("status_order").value;
  $.ajax({
     url: 'cariKaryawan/'+kategori+"/"+status,
     type: 'get',
     dataType: 'json',
     async: false,
     success: function(response){
       var table = $('#examp').DataTable();
       table.clear().draw();
       data_id = [];
       data_nama = [];
       data_pengembang = [];
       if (status == "2" || status == "3") {
         for (var i = 0; i < response.length; i++) {
           data_id[response[i]['id']] = response[i]['id'];
           data_nama[response[i]['id']] = response[i]['nama'];
           data_pengembang[response[i]['id']] = response[i]['id'];

           table.row.add( [
             response[i]['id'],
             response[i]['nama'],
             response[i]['no_hp'],
             response[i]['alamat']
           ] ).draw( false );
         }
       }else{
         for (var i = 0; i < response.length; i++) {
           data_id[response[i]['id_konsumen']] = response[i]['id'];
           data_nama[response[i]['id_konsumen']] = response[i]['nama'];
           data_pengembang[response[i]['id_konsumen']] = response[i]['pengembang'];

           table.row.add( [
             response[i]['id_konsumen'],
             response[i]['nama_pemilik'],
             response[i]['no_hp'],
             response[i]['alamat']
           ] ).draw( false );
         }
       }

       $('#barang').modal('show');
     }
   });

}

function save(){
  var id = document.getElementById("edid").value;
  var harga_jual = document.getElementById("edhargajual").value;
  var order = document.getElementById("edorder").value;
  var potongan = document.getElementById("edpotongan").value;

  var subtotal = order * ( harga_jual - potongan);
  tempjumlah[id] = order;
  tempharga_jual[id] = harga_jual;
  temppotongan[id] = potongan;
  tempsub_total[id] = subtotal;

  document.getElementById("order"+id).innerHTML = numberWithCommas(order);
  document.getElementById("harga_jual"+id).innerHTML = numberWithCommas(harga_jual);
  //document.getElementById("potongan"+id).innerHTML = potongan;
  document.getElementById("subtotal"+id).innerHTML = numberWithCommas(subtotal);
  var sum = tempsub_total.reduce(function(a, b){ return a + b; }, 0);
  document.getElementById("total_bayar").innerHTML = numberWithCommas(sum);

  $('#editing').modal('hide');

}

function deletecart(lastRow,sub){
  Swal.fire(
    'Delete this?',
    'Apakah Anda Yakin?',
    'question'
  ).then((result) => {
    if (result.value) {
      var old = document.getElementById("total_bayar").innerHTML;
      old = old.split(".").join("");
      total_bayar = Number(old) - Number(sub);
      document.getElementById("total_bayar").innerHTML = numberWithCommas(total_bayar);
      var row = document.getElementById(lastRow);
      row.parentNode.removeChild(row);

      tempbarang[lastRow] = "";
      tempjumlah[lastRow] = "";
      tempharga_jual[lastRow] = "";
      temppotongan[lastRow] = "";
      temppotonganpromo[lastRow] = "";
      tempsub_total[lastRow] = "";
      tempharga_net[lastRow] = "";

    }
  });
}

function StatusOrder(){
  var value = document.getElementById("status_order").value;
  if (value == "2" || value == "3") {
    document.getElementById("kategori").disabled = true;

    var kategori = document.getElementById("kategori").value;
    var status = document.getElementById("status_order").value;
    $.ajax({
       url: 'cariKaryawan/'+kategori+"/"+status,
       type: 'get',
       dataType: 'json',
       async: false,
       success: function(response){
         var table = $('#examp').DataTable();
         table.clear().draw();
         data_id = [];
         data_nama = [];
         data_pengembang = [];
           for (var i = 0; i < response.length; i++) {
             data_id[response[i]['id']] = response[i]['id'];
             data_nama[response[i]['id']] = response[i]['nama'];
             data_pengembang[response[i]['id']] = response[i]['id'];

             table.row.add( [
               response[i]['id'],
               response[i]['nama'],
               response[i]['no_hp'],
               response[i]['alamat']
             ] ).draw( false );
           }

         $('#barang').modal('show');
       }
     });

  }else{
    var kategori = document.getElementById("kategori").value;
    var status = document.getElementById("status_order").value;
    $.ajax({
       url: 'cariKaryawan/'+kategori+"/"+status,
       type: 'get',
       dataType: 'json',
       async: false,
       success: function(response){
         var table = $('#examp').DataTable();
         table.clear().draw();
         data_id = [];
         data_nama = [];
         data_pengembang = [];
           for (var i = 0; i < response.length; i++) {
             data_id[response[i]['id']] = response[i]['id'];
             data_nama[response[i]['id']] = response[i]['nama'];
             data_pengembang[response[i]['id']] = response[i]['id'];
             console.log(response[i]);
             table.row.add( [
               response[i]['id'],
               response[i]['nama_pemilik'],
               response[i]['no_hp'],
               response[i]['alamat']
             ] ).draw( false );
           }

         $('#barang').modal('show');
       }
     });

    document.getElementById("kategori").disabled = false;
  }
}

function Cek(){
  console.log(tempjumlah);
}
var postno_kwitansi = "";
function Simpan(){
  //document.getElementById("save").disabled = true;
  var no_kwitansis = document.getElementById("no_kwitansi").value;
  var tanggal_orders = document.getElementById("tanggal_order").value;
  var id_konsumens = document.getElementById("id_konsumen").value;
  var id_gudangs = document.getElementById("id_gudang").value;

        if (id_konsumens != "") {

              $.post("postinventaris",
                {no_kwitansi:no_kwitansis, tanggal_order:tanggal_orders,
                 id_konsumen:id_konsumens, id_gudang:id_gudangs, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
                    {

                      var newkwitansi = data;
                      postno_kwitansi = newkwitansi;
                      
                      for (var i = 0; i < tempbarang.length; i++) {
                      if (tempjumlah[i] > 0) {
                      $.post("postinventarisdetail",
                        {no_kwitansi:newkwitansi,
                         id_barang:tempbarang[i], harga_net:tempharga_net[i], jumlah:tempjumlah[i] , harga_jual:tempharga_jual[i],
                         potongan:temppotongan[i],potonganpromo:temppotonganpromo[i],sub_total:tempsub_total[i], _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
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
                                      //location.href="{{url('/inputinventaris/')}}";
                                    }else{
                                      document.getElementById("save").disabled = true;
                                      document.getElementById("cetak").disabled = false;
                                      //location.href="{{url('/inputinventaris/')}}";
                                    }
                                  });
                            }).fail(function(jqXHR, textStatus, errorThrown)
                        {
                            alert(textStatus);
                        });
                      }
                    }

                    }).fail(function(jqXHR, textStatus, errorThrown)
                {
                    alert(textStatus);
                });

        }else{
          alert("isi semua data");
        }
}
    function Cetak(){
      var no_kwitansi = document.getElementById("no_kwitansi").value;
      let text = postno_kwitansi;
      const myArray = text.split(",");
      window.open("{{url('/spbinventaris/')}}"+'/'+myArray[1]);
    }

</script>
@endsection
