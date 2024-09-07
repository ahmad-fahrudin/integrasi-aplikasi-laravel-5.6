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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Retur Penjualan > <a href="https://stokis.app/?s=input+dan+proses+retur+barang+dari+penjualan" target="_blank">Input Retur</a></li>
                             
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <!--label class="col-lg-3">No. Kwitansi</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="id" type="hidden" class="form-control">
                                    <input id="no_kwitansi" readonly type="text" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="caripenjualan()" type="button"><i class="fas fa-search"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div-->
                          <label class="col-lg-3">No. Kwitansi</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                    <div class="input-group">
                                      <input id="no_kwitansi"  type="text" class="form-control" placeholder="Ketik No. Kwitansi...">
                                      <input id="id" type="hidden" class="form-control">
                                      <div class="input-group-append">
                                          <button id="cari_barang" class="btn btn-outline-secondary" onclick="CariKwitansi()" type="button"><i class="fas fa-search"></i></button>
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
                                      <input type="date" id="tanggal_proses" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Status Order</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <select id="status_order" disabled class="form-control">
                                        <option value="terkirim">Terkirim</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-6"><strong>Konsumen</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">ID Konsumen</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="id_konsumen" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Kategori</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="kategori" type="text" readonly class="form-control">
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
                          <label class="col-lg-3">No. HP</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="no_hp" type="text" readonly class="form-control">
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
                                      <input id="nama_gudang" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-6"><strong>Petugas</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Sales</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="sales" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengembang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="pengembang" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Leader</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="leader" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Manager</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="manager" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Admin(P)</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="admin_p" type="text" readonly class="form-control">
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
                                  <input id="qc" type="text" readonly class="form-control">
                                </div>
                            </div>
                          </div>
                        </div>
                        <div hidden class="row">
                          <label class="col-lg-3">Dropper</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="dropper" readonly type="text" class="form-control">
                                    <input id="id_dropper" type="hidden" class="form-control">
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengirim</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="pengirim" readonly type="text" class="form-control">
                                    <input id="id_pengirim" type="hidden" class="form-control">
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Admin(G)</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="admin_g" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Admin(V)</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="admin_v" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Tanggal Terkirim</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" readonly id="tanggal_terkirim" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Tanggal Return</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" readonly id="tanggal_return" value="{{date('Y-m-d')}}" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Admin Pengembalian</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly value="{{Auth::user()->name}}" class="form-control">
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
                              <th>Jumlah Terkirim</th>
                              <th>Jumlah Retur</th>
                              <th>Harga Jual</th>
                              <th>Potongan</th>
                              <th>Jumlah Harga</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
								</div>
                <br>
                <center>
                  <button class="btn btn-success btn-lg" disabled id="save" onclick="Simpan()">Simpan</button>
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
                          <th>No. Kwitansi</th>
                          <th>Nama Konsumen</th>
                          <th>Cabang</th>
                          <th>Tanggal Terkirim</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($transfer as $value){ ?>
                      <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_kwitansi}}','{{$value->tanggal_proses}}','{{$value->id_konsumen}}','{{$value->nama_pemilik}}',
                                                '{{$value->alamat}}','{{$value->no_hp}}','{{$value->nama_gudang}}','{{$value->sales}}',
                                                '{{$value->pengembang}}','{{$value->leader}}','{{$value->manager}}','{{$value->admin_p}}','{{$value->kategori}}',
                                                '{{$value->qc}}','{{$value->dropper}}','{{$value->pengirim}}','{{$value->admin_g}}','{{$value->id_dropper}}','{{$value->id_pengirim}}','{{$value->admin_v}}'
                                                )">
                          <td>{{$value->no_kwitansi}}</td>
                          <td>{{$value->nama_pemilik}}</td>
                          <td>{{$value->nama_gudang}}</td>
                          <td>{{tanggal($value->tanggal_terkirim)}}</td>
                      </tr>
                     <?php } ?>
                     <?php foreach ($transfer2 as $value){ ?>
                       <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_kwitansi}}','{{$value->tanggal_proses}}','{{$value->id_konsumen}}','{{$value->nama_pemilik}}',
                                                 '{{$value->alamat}}','{{$value->no_hp}}','{{$value->nama_gudang}}','{{$value->sales}}',
                                                 '{{$value->pengembang}}','{{$value->leader}}','{{$value->manager}}','{{$value->admin_p}}','{{$value->kategori}}',
                                                 '{{$value->qc}}','{{$value->dropper}}','{{$value->pengirim}}','{{$value->admin_g}}','{{$value->id_dropper}}','{{$value->id_pengirim}}','{{$value->admin_v}}'
                                                 )">
                           <td>{{$value->no_kwitansi}}</td>
                           <td>{{$value->nama_pemilik}}</td>
                           <td>{{$value->nama_gudang}}</td>
                           <td>{{tanggal($value->tanggal_terkirim)}}</td>
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
                              <th>No. Telepon</th>
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

        <div class="modal fade" id="droppers" role="dialog">
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
                                <th>No. Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($dropper as $value){ ?>
                            <tr onclick="pilihdropper('{{$value->id}}','{{$value->nama}}')">
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

          <div class="modal fade" id="pengirims" role="dialog">
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
                                  <th>No. Telepon</th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($pengirim as $value){ ?>
                              <tr onclick="pilihpengirim('{{$value->id}}','{{$value->nama}}')">
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
                    <p id="jumlah"></p>
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
                    <input type="hidden" readonly id="index" class="form-control">
                    <input type="number" readonly id="terkirim" class="form-control">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-3">
                    <label>Jumlah Return :</label>
                  </div>
                  <div class="col-md-4">
                    <input id="return" value="0" min="0" class="form-control" type="number">
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
    var retur = [];

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

    function caridropper(){
      $('#droppers').modal('show');
    }

    function pilihdropper(id,nama){
      $('#droppers').modal('hide');
      document.getElementById("id_dropper").value = id;
      document.getElementById("dropper").value = nama;
    }

    function caripengirim(){
      $('#pengirims').modal('show');
    }

    function pilihpengirim(id,nama){
      $('#pengirims').modal('hide');
      document.getElementById("id_pengirim").value = id;
      document.getElementById("pengirim").value = nama;
    }

    function pilihbarang(id,no_kwitansi,tanggal_proses,id_konsumen,nama_pemilik,alamat,no_hp,nama_gudang,sales,
      pengembang,leader,manager,admin_p,kategori,qc,dropper,pengirim,admin_g,id_dropper,id_pengirim,admin_v){
      $('#transfer').modal('hide');
      document.getElementById("id").value = id;
      document.getElementById("no_kwitansi").value = no_kwitansi;
      document.getElementById("tanggal_proses").value = tanggal_proses;
      document.getElementById("id_konsumen").value = id_konsumen;
      document.getElementById("kategori").value = kategori;
      document.getElementById("nama").value = nama_pemilik;
      document.getElementById("alamat").innerHTML = alamat;
      document.getElementById("no_hp").value = no_hp;
      document.getElementById("nama_gudang").value = nama_gudang;
      document.getElementById("sales").value = sales;
      document.getElementById("pengembang").value = pengembang;
      document.getElementById("leader").value = leader;
      document.getElementById("manager").value = manager;
      document.getElementById("admin_p").value = admin_p;
      document.getElementById("qc").value = qc;
      document.getElementById("dropper").value = dropper;
      document.getElementById("pengirim").value = pengirim;
      document.getElementById("admin_g").value = admin_g;
      document.getElementById("id_dropper").value = id_dropper;
      document.getElementById("id_pengirim").value = id_pengirim;
      document.getElementById("admin_v").value = admin_v;

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
                 document.getElementById("tanggal_terkirim").value = response['barang'][0]['tanggal_terkirim'];
           tempid = [];
           tempid_barang = [];
           gudang = [];
           retur = [];
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
             retur[i] = 0;
             cell1.innerHTML = response['barang'][i]['no_sku'];
             cell2.innerHTML = response['barang'][i]['nama_barang'];

             if (response['barang'][i]['terkirim'] > 0) {
                cell3.innerHTML = "<p id=terkirim"+response['barang'][i]['key']+">"+response['barang'][i]['terkirim']+"</p>";
             }
             cell4.innerHTML = "<p id=retur"+response['barang'][i]['key']+">"+0+"</p>";
             cell5.innerHTML = numberWithCommas(response['barang'][i]['harga_jual']);
             cell6.innerHTML = "<p id=potongan"+response['barang'][i]['key']+">"+numberWithCommas(response['barang'][i]['sub_potongan'])+"</p>";
             cell7.innerHTML = "<p id=sub_total"+response['barang'][i]['key']+">"+numberWithCommas(response['barang'][i]['sub_total'])+"</p>";
             var a = '<button class="btn btn-default" onclick="editJumlah('+response['barang'][i]['key']+','+response['barang'][i]['proses']+','+response['barang'][i]['terkirim']+','+i;
             var b = ')"><i class="icon-pencil"></i></button>';
             cell8.innerHTML = a+",'"+response['barang'][i]['nama_barang']+"'"+b;
           }
         }
       });
    }

    function editJumlah(key,proses,terkirim,i,nama){
      document.getElementById("jumlah").innerHTML = nama;
      document.getElementById("id_detail").value = key;
      document.getElementById("terkirim").value = terkirim;
      document.getElementById("index").value = i;
      document.getElementById("return").value = 0;
      $('#edit').modal('show');
    }

    function rubah(){
      var terkirim = document.getElementById("terkirim").value;
      var id_detail = document.getElementById("id_detail").value;
      var index = document.getElementById("index").value;
      var returs = document.getElementById("return").value;

      if (Number(returs) <= Number(terkirim)) {
        var tmp = Number(terkirim - returs);
        retur[index] = returs;
        document.getElementById("retur"+id_detail).innerHTML = returs;
        document.getElementById("terkirim"+id_detail).innerHTML = tmp;
        document.getElementById("save").disabled = false;
        $('#edit').modal('hide');
      }else{
        alert("Melebihi Barang!");
      }
    }

    function Simpan(){
      //document.getElementById("save").disabled = true;
      var no_kwitansis = document.getElementById("no_kwitansi").value;
      var tempids = "";
      var tempid_barangs = "";
      var id_gudangs = "";
      var returs = "";

      for (var i = 0; i < tempid.length; i++) {
          if (retur[i]>0) {
            tempids += tempid[i]+",";
            tempid_barangs += tempid_barang[i]+",";
            id_gudangs += gudang[i]+",";
            returs += retur[i]+",";
          }
      }

      <?php if (Auth::user()->level == "3") { ?>

        if (no_kwitansis != "" && returs != "") {
        $.post("postreturnbarang",
          {no_kwitansi:no_kwitansis, id_detail_barang_keluar:tempids ,id_barang : tempid_barangs,id_gudang : id_gudangs,return:returs,
            _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
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
                    }else{
                      document.getElementById("save").disabled = true;
                    }
                  });

              }).fail(function(jqXHR, textStatus, errorThrown)
          {
              alert(textStatus);
          });
        }

        console.log(tempids);
        console.log(tempid_barangs);
        console.log(id_gudangs);
        console.log(returs);
        location.href="{{url('/inputreturn/')}}";

      <?php }else{ ?>

      if (no_kwitansis != "" && returs != "") {
      $.post("postpendingretur",
        {no_kwitansi:no_kwitansis, id_detail_barang_keluar:tempids ,id_barang : tempid_barangs,id_gudang : id_gudangs,return:returs,
          _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
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
                  }else{
                    document.getElementById("save").disabled = true;
                  }
                });

            }).fail(function(jqXHR, textStatus, errorThrown)
        {
            alert(textStatus);
        });
      }

      console.log(tempids);
      console.log(tempid_barangs);
      console.log(id_gudangs);
      console.log(returs);
      location.href="{{url('/inputreturn/')}}";

      <?php } ?>

    }
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function CariKwitansi(){
     
      var v = document.getElementById("no_kwitansi").value;
      setTimeout(function (){
        $.ajax({
           url: 'searchkwitansireturn/'+v,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             swal.close();
             console.log(response);
             if (response.length > 0) {
               pilihbarang(response[0]['id'],response[0]['no_kwitansi'],response[0]['tanggal_proses'],response[0]['id_konsumen'],response[0]['nama_pemilik'],
                          response[0]['alamat'],response[0]['no_hp'],response[0]['nama_gudang'],response[0]['sales'],response[0]['pengembang'],response[0]['leader'],
                          response[0]['manager'],response[0]['admin_p'],response[0]['kategori'],response[0]['qc'],response[0]['dropper'],response[0]['pengirim'],
                          response[0]['admin_g'],response[0]['id_dropper'],response[0]['id_pengirim'],response[0]['admin_v']);
             }else{
               Swal.fire({
                   title: 'Data Tidak Ada',
                   icon: 'success',
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Lanjutkan!'
                 });
             }

           }
         });
         }, 100);
    }
    </script>
@endsection
