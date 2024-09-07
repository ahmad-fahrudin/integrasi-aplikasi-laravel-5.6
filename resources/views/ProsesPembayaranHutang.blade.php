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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Hutang > <a href="https://stokis.app/?s=proses+bayar+pembelian" target="_blank">Proses Bayar Hutang</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">No. Faktur</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="id" type="hidden" class="form-control">
                                    <input id="no_kwitansi" type="text" class="form-control" placeholder="Pilih No. Kwitansi Pembelian">
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
                          <label class="col-lg-3">Tanggal Masuk</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" id="tanggal_masuk" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-6"><strong>Supplier</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Supplier</label>
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
                        <div hidden class="row">
                          <label class="col-lg-3">No HP</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                    <p class="form-control1" id="no_hp"></p>

                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">

                        <div hidden class="row">
                          <label class="col-lg-3">Admin(K)</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="tanggal_terkirim" value="{{Auth::user()->name}}" class="form-control">
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
                              <th>Jumlah Masuk</th>
                              <th>Harga HP</th>
                              <th>Jumlah Harga</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
								</div>
                <hr><br>
                <div id="bayar">
                
                <div class="row">
                    <div class="col-md-6">
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
                    <div hidden class="row">
                          <label class="col-lg-3">Status Pembayaran</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" id="status_pembayaran" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div> 
                     <div class="row">
                          <label class="col-lg-3">Nama Penerima</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" id="nama_penyetor" class="form-control" placeholder="Uang diterima oleh siapa?">
                                  </div>
                              </div>
                          </div>
                        </div> 
                        
                    </div>
                     <br>
                    <div class="col-md-6">
                      <div class="row">
                          <label class="col-lg-3">Total Hutang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="ongkos_kirim" class="form-control">
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
                          <label class="col-lg-3">Sisa Hutang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="number" readonly id="piutang" class="form-control" data-a-sign="" data-a-dec="," data-a-pad=false data-a-sep=".">
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
                Metode Pembayaran: <select class="form-control" id="jenis_pembayaran" onchange="CekBankAktif()">
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
                          <th>No Faktur</th>
                          <th>Suplayer</th>
                          <th>Kota</th>
                          <th>No HP</th>
                          <th>Total</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($transfer as $value){
                       ?>
                      <tr onclick="pilihbarang('{{$value->no_faktur}}','{{$value->nama_pemilik}}','{{$value->kota}}','{{$value->no_hp}}','{{$value->jumlah}}','{{$value->tgl_masuk}}')">
                          <td>{{$value->no_faktur}}</td>
                          <td>{{$value->nama_pemilik}}</td>
                          <td>{{$value->kota}}</td>
                          <td>{{$value->no_hp}}</td>
                          <td>{{$value->jumlah}}</td>
                      </tr>
                    <?php  } ?>
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

    function pilihbarangjasa(no_faktur,nama,kota,no_hp,jumlah,tgl_masuk){
      $('#transfer').modal('hide');
      document.getElementById("no_kwitansi").value = no_faktur;
      document.getElementById("tanggal_masuk").value = tgl_masuk;
      document.getElementById("nama").value = nama;
      document.getElementById("alamat").innerHTML = kota;
      document.getElementById("no_hp").value = no_hp;
      document.getElementById("ongkos_kirim").value = numberWithCommas(jumlah);

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
             cell8.innerHTML = pot;
             cell9.innerHTML = numberWithCommas(response['barang'][i]['sub_biaya']-pot);
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

    function pilihbarang(no_faktur,nama,kota,no_hp,jumlah,tgl_masuk){
      $('#transfer').modal('hide');
      document.getElementById("no_kwitansi").value = no_faktur;
      document.getElementById("tanggal_masuk").value = tgl_masuk;
      document.getElementById("nama").value = nama;
      document.getElementById("alamat").innerHTML = kota;
      document.getElementById("no_hp").value = no_hp;
      document.getElementById("ongkos_kirim").value = numberWithCommas(jumlah);

      $.ajax({
         url: 'pilihbarangmasuk/'+no_faktur,
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
           for (var i = 0; i < response['bm'].length; i++) {
             var table = document.getElementById("cart");
             var lastRow = table.rows.length;
             var row = table.insertRow(lastRow);
             row.id = lastRow;

             var cell1 = row.insertCell(0);
             var cell2 = row.insertCell(1);
             var cell3 = row.insertCell(2);
             var cell4 = row.insertCell(3);
             var cell5 = row.insertCell(4);

             cell1.innerHTML = response['bm'][i]['no_sku'];
             cell2.innerHTML = response['bm'][i]['nama_barang'];
             cell3.innerHTML = response['bm'][i]['jumlah'];
             cell4.innerHTML = response['bm'][i]['harga_hp'];
             var tots = Number(response['bm'][i]['harga_hp']) * Number(response['bm'][i]['jumlah']);
             cell5.innerHTML = tots;
           }
           if(response['bayar'].length > 0){
               var ddf = Number(jumlah) - Number(response['bayar'][0]['total_pembayaran']);
               document.getElementById("piutang").value = ddf;
           }else{
               var ddf = Number(jumlah);
               document.getElementById("piutang").value = ddf;
           }
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
      var no_faktur = document.getElementById("no_kwitansi").value;
      var status_pembayarans = document.getElementById("status_pembayaran").value;
      var tagihans = document.getElementById("piutang").value;
      var namas = document.getElementById("nama").value;

      if (pembayarans != "" && nama_penyetors != "" && tanggal_bayars != "" && no_faktur != "") {
        $.post("pembayaranhutang",
          {namas:namas,no_rekening_bank:no_rekening_bank,jenis_pembayaran:jenis_pembayaran, no_faktur:no_faktur, tagihan:tagihans, pembayaran:pembayarans, nama_penyetor:nama_penyetors, tanggal_bayar:tanggal_bayars,status_pembayaran:status_pembayarans, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
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
                        location.href="{{url('/prosespembayaran/')}}";
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
