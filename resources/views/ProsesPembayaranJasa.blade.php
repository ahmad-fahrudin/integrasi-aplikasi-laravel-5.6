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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Piutang > Layanan Jasa > <a href="https://stokis.app/?s=proses+bayar+piutang+layanan+jasa" target="_blank">Proses Bayar Piutang</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">No. Kwitansi</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="id" type="hidden" class="form-control">
                                    <input id="no_kwitansi" type="text" class="form-control" placeholder="Pilih No. Kwitansi Jasa">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="caripenjualan()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Tanggal Layanan</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" id="tanggal_proses" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-6"><strong>Member</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Member</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="nama" type="text" readonly class="form-control">
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
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Cabang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="nama_gudang" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <br>
                        <div class="row">
                          <label class="col-lg-6"><strong>Petugas</strong></label>
                        </div>
                        <br>
                        <div hidden class="row">
                          <label class="col-lg-3">Leader</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                    <div class="input-group">
                                      <input id="leader" type="text" class="form-control">
                                      <input id="id_leader" type="hidden" class="form-control">
                                      <div class="input-group-append">
                                          <button class="btn btn-outline-secondary" onclick="carileader()" type="button"><i class="fas fa-folder-open"></i></button>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Manager</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                    <div class="input-group">
                                      <input id="manager" type="text" class="form-control">
                                      <input id="id_manager" type="hidden" class="form-control">
                                      <div class="input-group-append">
                                          <button class="btn btn-outline-secondary" onclick="carimanager()" type="button"><i class="fas fa-folder-open"></i></button>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <label class="col-lg-3">Admin Kasir</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="kasir" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Petugas 1</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="petugas1" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Petugas 2</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <input id="petugas2" type="text" readonly class="form-control">
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Petugas 3</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <input id="petugas3" type="text" readonly class="form-control">
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>

                  <br><br>
									<div class="table-responsive">
                  <table id="cart" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. Jasa</th>
                              <th>Nama Layanan</th>
                              <th>Jumlah Permintaan</th>
                              <th>Jumlah Proses</th>
                              <th>Jumlah Batal</th>
                              <th>Jumlah Selesai</th>
                              <th>Biaya</th>
                              <th>Potongan</th>
                              <th>Jumlah Biaya</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
								</div>
                <br>
                <div id="bayar">
                    
                <div class="row">
                    <div class="col-md-6">
                     <div class="row">
                          <label class="col-lg-3">Status Pembayaran</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" id="status_pembayaran" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div> 
                        <br>
                     <div class="row">
                          <label class="col-lg-3">Tanggal Bayar</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" id="tanggal_bayar" readonly value="{{date('Y-m-d')}}"class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div> 
                      <br>  
                    
                     <div class="row">
                          <label class="col-lg-3">Nama Penyetor</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" id="nama_penyetor" class="form-control" placeholder="Uang diterima dari siapa?">
                                  </div>
                              </div>
                          </div>
                        </div> 
                        
                    </div>
                     <br>
                    <div class="col-md-6">
                      <div class="row">
                          <label class="col-lg-3">Potongan Jasa</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="potongan" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div> 
                        <br>
                      <div class="row">
                          <label class="col-lg-3">Total Piutang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="total_bayar" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div> 
                        <br>
                    <div class="row">
                          <label class="col-lg-3">Nominal Pembayaran</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="pembayaran" class="form-control" data-a-sign="" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div> 
                        <br>
                     <div class="row">
                          <label class="col-lg-3">Sisa Piutang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="piutang" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>   
                        
                    </div>
                </div>    
                    
              </div>
                <br>
                <hr>
                <center> 
                <div class="col-lg-3">
                Metode Pembayaran: 
                    <select class="form-control" id="jenis_pembayaran" onchange="CekBankAktif()">
                            <option>Tunai</option>
                            <option>Transfer</option>
                        </select>
                        <select class="form-control" id="no_rekening_bank" hidden>
                            <option>--Pilih Rekening Bank--</option>
                            <?php foreach($rekening as $val_rek){ ?>
                            <option value="{{$val_rek->id}}">{{$val_rek->nama}} ({{$val_rek->no_rekening}})</option>
                            <?php } ?>
                        </select>
                        </div>
                <br>
                <br>
                  <button class="btn btn-success btn-lg" id="btnbayar" onclick="bayar()">Simpan</button>
                  <button class="btn btn-warning btn-lg" id="cetak" disabled onclick="Cetak()">Cetak Tagihan</button>
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
                          <th>No Kwitansi</th>
                          <th>Nama Konsumen</th>
                          <th>Gudang</th>
                          <th>Tanggal Order</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($transferjasa as $value){
                      if (isset($karyawan[$value->petugas1])) {
                        $petugas1 = $karyawan[$value->petugas1];
                      }else{
                        $petugas1 = "";
                      }
                      if (isset($karyawan[$value->petugas2])) {
                        $petugas2 = $karyawan[$value->petugas2];
                      }else{
                        $petugas2 = "";
                      }
                      if (isset($karyawan[$value->petugas3])) {
                        $petugas3 = $karyawan[$value->petugas3];
                      }else{
                        $petugas3 = "";
                      }
                      ?>
                      <tr onclick="pilihbarangjasa('','{{$value->no_kwitansi}}','{{$value->tanggal_transaksi}}','{{$value->id_konsumen}}','{{$konsumen[$value->id_konsumen]['nama']}}',
                                                '{{$konsumen[$value->id_konsumen]['alamat']}}','{{$konsumen[$value->id_konsumen]['no_hp']}}','{{$gudang[$value->gudang]}}','',
                                                '{{$karyawan[$value->pengembang]}}','{{$karyawan[$value->leader]}}',
                                                '<?php if (isset($karyawan[$value->manager])): ?>{{$karyawan[$value->manager]}}<?php endif; ?>'
                                                ,'{{$karyawan[$value->kasir]}}',
                                                '',
                                                '',
                                                '{{$karyawan[$value->kasir]}}',
                                                '{{$petugas1}}',
                                                '{{$petugas2}}',
                                                '{{$petugas3}}',
                                                '{{$value->manager}}','{{$value->leader}}',0)">
                          <td>{{$value->no_kwitansi}}</td>
                          <td>{{$konsumen[$value->id_konsumen]['nama']}}</td>
                          <td>{{$gudang[$value->gudang]}}</td>
                          <td>{{tanggal($value->tanggal_transaksi)}}</td>
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
                  <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
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

        <div class="modal fade" id="leaders" role="dialog">
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
                          <?php foreach ($leader as $value){ ?>
                            <tr onclick="pilihleader('{{$value->id}}','{{$value->nama}}')">
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

          <div class="modal fade" id="managers" role="dialog">
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
                            <?php foreach ($leader as $value){ ?>
                              <tr onclick="pilihmanager('{{$value->id}}','{{$value->nama}}')">
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
                    <label>Jumlah Proses :</label>
                  </div>
                  <div class="col-md-4">
                    <input type="number" readonly id="proses" class="form-control">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-3">
                    <label>Jumlah Diterima :</label>
                  </div>
                  <div class="col-md-4">
                    <input type="hidden" readonly id="id_detail" class="form-control">
                    <input type="number" id="terkirim" class="form-control">
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
    new AutoNumeric('#pembayaran', "euroPos");
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    var tempid = [];
    var tempid_barang = [];
    var gudang = [];

    function caripenjualan(){
      $('#transfer').modal('show');
    }

    function cariqc(){
      $('#qc').modal('show');
    }

    function pilihqc(id,nama){
      $('#qc').modal('hide');
      document.getElementById("id_qc").value = id;
      document.getElementById("nama_qc").value = nama;
    }

    function carileader(){
      $('#leaders').modal('show');
    }

    function pilihleader(id,nama){
      $('#leaders').modal('hide');
      document.getElementById("id_leader").value = id;
      document.getElementById("leader").value = nama;
    }

    function carimanager(){
      $('#managers').modal('show');
    }

    function pilihmanager(id,nama){
      $('#managers').modal('hide');
      document.getElementById("id_manager").value = id;
      document.getElementById("manager").value = nama;
    }

    function pilihbarangjasa(id,no_kwitansi,tanggal_proses,id_konsumen,nama_pemilik,alamat,no_hp,nama_gudang,sales,
      pengembang,leader,manager,admin_p,kategori,qc,kasir,petugas1,petugas2,petugas3,id_manager,id_leader,ongkos_kirim){
      $('#transfer').modal('hide');
      document.getElementById("id").value = id;
      document.getElementById("no_kwitansi").value = no_kwitansi;
      document.getElementById("tanggal_proses").value = tanggal_proses;
      document.getElementById("nama").value = nama_pemilik;
      document.getElementById("alamat").innerHTML = alamat;
      document.getElementById("nama_gudang").value = nama_gudang;
      document.getElementById("kasir").value = kasir;
      document.getElementById("petugas1").value = petugas1;
      document.getElementById("petugas2").value = petugas2;
      document.getElementById("petugas3").value = petugas3;
      document.getElementById("leader").value = leader;
      document.getElementById("id_leader").value = id_leader;
      document.getElementById("manager").value = manager;
      document.getElementById("id_manager").value = id_manager;
      //document.getElementById("ongkos_kirim").value = numberWithCommas(ongkos_kirim);

      $.ajax({
         url: 'pilihbarangkeluar/'+no_kwitansi,
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
           total_bayar = 0;
           for (var i = 0; i < response['barang'].length; i++) {
             var table = document.getElementById("cart");
             var lastRow = table.rows.length;
             var row = table.insertRow(lastRow);
             row.id = lastRow;

             var cell1 = row.insertCell(0);
             var cell2 = row.insertCell(1);
             var cell3 = row.insertCell(2);
             var cell4 = row.insertCell(3);
             var cell5 = row.insertCell(4);
             var cell6 = row.insertCell(5);
             var cell7 = row.insertCell(6);
             var cell8 = row.insertCell(7);
             var cell9 = row.insertCell(8);

             if (response['barang'][i]['proses'] == null) {
               response['barang'][i]['proses'] = 0;
             }
             if (response['barang'][i]['return'] == null) {
               response['barang'][i]['return'] = 0;
             }
             if (response['barang'][i]['terkirim'] == null) {
               response['barang'][i]['terkirim'] = 0;
             }

             tempid[i] = response['barang'][i]['key'];
             tempid_barang[i] = response['barang'][i]['id_barang'];
             gudang[i] = response['barang'][i]['id_gudang'];

             cell1.innerHTML = response['barang'][i]['id_jasa'];
             cell2.innerHTML = response['barang'][i]['nama_jasa'];
             cell3.innerHTML = response['barang'][i]['jumlah'];
             cell4.innerHTML = "<p id=proses"+response['barang'][i]['key']+">"+response['barang'][i]['jumlah']+"</p>";
             cell5.innerHTML = "<p id=retur"+response['barang'][i]['key']+">"+0+"</p>";
             cell6.innerHTML = "<p id=terkirim"+response['barang'][i]['key']+">"+response['barang'][i]['jumlah']+"</p>";
             cell7.innerHTML = numberWithCommas(response['barang'][i]['biaya']);
             var pot = Number(response['barang'][i]['potongan']/response['barang'].length);
             cell8.innerHTML = 0;
             cell9.innerHTML = numberWithCommas(response['barang'][i]['sub_biaya']-pot);

             document.getElementById("potongan").value = numberWithCommas(response['barang'][i]['potongan']);

             total_bayar +=  Number(response['barang'][i]['sub_biaya']) - pot;
           }
           total_bayar += Number(ongkos_kirim);
           document.getElementById("total_bayar").value=numberWithCommas(total_bayar);
           if (response['bayar'][0]['telah_bayar'] == null) {
             response['bayar'][0]['telah_bayar'] = 0;
             document.getElementById("status_pembayaran").value="Tempo";
           }else{
             document.getElementById("status_pembayaran").value=response['bayar'][0]['status_pembayaran'];
           }

           var piutang = (total_bayar - response['bayar'][0]['telah_bayar']);
           document.getElementById("piutang").value=numberWithCommas(piutang);
           document.getElementById("pembayaran").value=numberWithCommas(piutang);
         }
       });
    }

    function pilihbarang(id,no_kwitansi,tanggal_proses,id_konsumen,nama_pemilik,alamat,no_hp,nama_gudang,sales,
      pengembang,leader,manager,admin_p,kategori,qc,dropper,pengirim,admin_g,admin_v,id_manager,id_leader,ongkos_kirim){
      $('#transfer').modal('hide');
      document.getElementById("id").value = id;
      document.getElementById("no_kwitansi").value = no_kwitansi;
      document.getElementById("tanggal_proses").value = tanggal_proses;
      document.getElementById("nama").value = nama_pemilik;
      document.getElementById("alamat").innerHTML = alamat;
      document.getElementById("nama_gudang").value = nama_gudang;
      document.getElementById("sales").value = sales;
      document.getElementById("admin_p").value = admin_p;
      document.getElementById("dropper").value = dropper;
      document.getElementById("pengirim").value = pengirim;
      document.getElementById("admin_g").value = admin_g;
      document.getElementById("admin_v").value = admin_v;
      document.getElementById("leader").value = leader;
      document.getElementById("id_leader").value = id_leader;
      document.getElementById("manager").value = manager;
      document.getElementById("id_manager").value = id_manager;
      document.getElementById("ongkos_kirim").value = numberWithCommas(ongkos_kirim);

      $.ajax({
         url: 'pilihbarangkeluar/'+no_kwitansi,
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
           total_bayar = 0;
           for (var i = 0; i < response['barang'].length; i++) {
           if (Number(response['barang'][i]['terkirim']) > 0) {
             var table = document.getElementById("cart");
             var lastRow = table.rows.length;
             var row = table.insertRow(lastRow);
             row.id = lastRow;

             var cell1 = row.insertCell(0);
             var cell2 = row.insertCell(1);
             var cell3 = row.insertCell(2);
             var cell4 = row.insertCell(3);
             var cell5 = row.insertCell(4);
             var cell6 = row.insertCell(5);
             var cell7 = row.insertCell(6);
             var cell8 = row.insertCell(7);
             var cell9 = row.insertCell(8);

             if (response['barang'][i]['proses'] == null) {
               response['barang'][i]['proses'] = 0;
             }
             if (response['barang'][i]['return'] == null) {
               response['barang'][i]['return'] = 0;
             }
             if (response['barang'][i]['terkirim'] == null) {
               response['barang'][i]['terkirim'] = 0;
             }

             tempid[i] = response['barang'][i]['key'];
             tempid_barang[i] = response['barang'][i]['id_barang'];
             gudang[i] = response['barang'][i]['id_gudang'];

             cell1.innerHTML = response['barang'][i]['no_sku'];
             cell2.innerHTML = response['barang'][i]['nama_barang'];
             cell3.innerHTML = response['barang'][i]['jumlah'];
             cell4.innerHTML = "<p id=proses"+response['barang'][i]['key']+">"+response['barang'][i]['proses']+"</p>";
             cell5.innerHTML = "<p id=retur"+response['barang'][i]['key']+">"+response['barang'][i]['return']+"</p>";
             cell6.innerHTML = "<p id=terkirim"+response['barang'][i]['key']+">"+response['barang'][i]['terkirim']+"</p>";
             cell7.innerHTML = numberWithCommas(response['barang'][i]['harga_jual']);
             var pot = Number(response['barang'][i]['potongan']) + (Number(response['barang'][i]['sub_potongan']) / Number(response['barang'][i]['terkirim']));
             cell8.innerHTML = numberWithCommas(pot);
             cell9.innerHTML = numberWithCommas(response['barang'][i]['sub_total']);
             total_bayar +=  Number(response['barang'][i]['sub_total']);
           }
           }
           total_bayar += Number(ongkos_kirim);
           document.getElementById("total_bayar").value=numberWithCommas(total_bayar);
           if (response['bayar'][0]['telah_bayar'] == null) {
             response['bayar'][0]['telah_bayar'] = 0;
             document.getElementById("status_pembayaran").value="Tempo";
           }else{
             document.getElementById("status_pembayaran").value=response['bayar'][0]['status_pembayaran'];
           }

           var piutang = (total_bayar - response['bayar'][0]['telah_bayar']);
           document.getElementById("piutang").value=numberWithCommas(piutang);
           document.getElementById("pembayaran").value=numberWithCommas(piutang);
         }
       });
    }

    function editJumlah(key,proses,terkirim){
      document.getElementById("id_detail").value = key;
      document.getElementById("proses").value = proses;
      document.getElementById("terkirim").value = terkirim;
      document.getElementById("terkirim").max = proses;
      $('#edit').modal('show');
    }

    function rubah(){
      var proses = document.getElementById("proses").value;
      var terkirim = document.getElementById("terkirim").value;
      var id_detail = document.getElementById("id_detail").value;
      $.ajax({
         url: 'updateterkirim/'+proses+"/"+terkirim+"/"+id_detail,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           document.getElementById("retur"+response['id']).innerHTML = response['return'];
           document.getElementById("terkirim"+response['id']).innerHTML = response['terkirim'];
           $('#edit').modal('hide');
         }
       });
    }

    function Cetak(){
      var no_kwitansi = document.getElementById("no_kwitansi").value;
      window.open("{{url('/tagihan/')}}"+'/'+no_kwitansi);
    }
    
    function CekBankAktif(){
        var ceks = document.getElementById("jenis_pembayaran").value;
        if(ceks == "Transfer"){
            document.getElementById("no_rekening_bank").hidden = false;
        }else{
            document.getElementById("no_rekening_bank").hidden = true;
        }
    }

    
    function bayar(){
      document.getElementById('btnbayar').disabled = true;
      
      var jenis_pembayaran =document.getElementById("jenis_pembayaran").value;
      var no_rekening_bank =document.getElementById("no_rekening_bank").value;
  
      var pembayarans = document.getElementById("pembayaran").value;
      var nama_penyetors = document.getElementById("nama_penyetor").value;
      var tanggal_bayars = document.getElementById("tanggal_bayar").value;
      var no_kwitansis = document.getElementById("no_kwitansi").value;
      var status_pembayarans = document.getElementById("status_pembayaran").value;
      var tagihans = document.getElementById("piutang").value;
      var id_leader = document.getElementById("id_leader").value;
      var id_manager = document.getElementById("id_manager").value;
      var nama_pembeli = document.getElementById("nama").value;
      
      if (pembayarans != "" && nama_penyetors != "" && tanggal_bayars != "" && no_kwitansis != "" && status_pembayarans != "" && id_leader != "" ) {
        $.post("pembayaran",
          {nama_pembeli:nama_pembeli,no_rekening_bank:no_rekening_bank,jenis_pembayaran:jenis_pembayaran,leader:id_leader, manager:id_manager, no_kwitansi:no_kwitansis, tagihan:tagihans, pembayaran:pembayarans, nama_penyetor:nama_penyetors, tanggal_bayar:tanggal_bayars,status_pembayaran:status_pembayarans, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
              {
                  Swal.fire({
                      title: 'Berhasil',
                      icon: 'success',
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Lanjutkan!'
                    }).then((result) => {
                      document.getElementById('btnbayar').disabled = true;
                      document.getElementById('cetak').disabled = false;
                      var before = document.getElementById("piutang").value;
                      var pembayaran = document.getElementById("pembayaran").value;
                      before = before.split(".").join("");
                      pembayaran = pembayaran.split(".").join("");
                      var after = before - pembayaran;
                      document.getElementById("piutang").value=numberWithCommas(after);
                      if(after <= 0){
                        document.getElementById("status_pembayaran").value="Lunas";
                        location.href="{{url('/prosespembayaranjasa/')}}";
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
