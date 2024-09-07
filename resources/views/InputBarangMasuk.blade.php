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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Barang Masuk > <a href="https://stokis.app/?s=cara+input+barang+masuk+dari+pengadaan+barang+kulakan+dan+bonus+pembelian" target="_blank">Input Barang Musuk dari Pembelian</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="row">
                           
                          <label class="col-lg-3">Cabang</label>
                          <?php if(Auth::user()->level == "1"){ ?> 
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <select class="form-control" id="id_gudang" name="gudang">
                                        <?php foreach ($gudang as $value) { ?>
                                          <option value="{{$value->id}}">{{$value->nama_gudang}}</option>
                                        <?php } ?>
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <?php }else{ ?>
                             <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                        <select hidden class="form-control" id="id_gudang" name="gudang">
                                            <option selected value="{{Auth::user()->gudang}}">{{Auth::user()->gudang}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                          <?php } ?>
                              </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">No. Faktur</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <?php $digits = 3;
                                      $rand = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);?>
                                      <input type="text" id="no_faktur" readonly value="{{'FK-'.date('md').$rand.$number}}" class="form-control">
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
                                      <input readonly type="text" value="{{date('d-m-Y')}}" class="form-control">
                                      <input readonly type="hidden" id="tgl_masuk" value="{{date('Y-m-d')}}" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Kategori Stok Masuk</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <select class="form-control" name="kategori" id="kategori">
                                        <option value="kulakan">Kulakan</option>
                                        <option value="bonus">Bonus</option>
                                        <option value="non kulakan">Non Kulakan</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pembayaran</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <select class="form-control" name="kategori_pembelian" id="kategori_pembelian" onchange="ChangePembelian()">
                                        <option value="cash">Cash</option>
                                        <option value="hutang">Hutang</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="row" id="jenis_cash_panel">
                          <label class="col-lg-3"></label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <select class="form-control" name="jenis_cash" id="jenis_cash" onchange="Changecash()">
                                        <option value="tunai">Tunai</option>
                                        <option value="transfer">Transfer</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="row" id="jenis_rekening_panel" hidden>
                          <label class="col-lg-3"></label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <select class="form-control" name="jenis_rekening" id="jenis_rekening">
                                            <?php foreach($rekening as $key => $value){ ?>
                                                <option value="{{$value->id}}">{{$value->nama}}({{$value->no_rekening}})</option>
                                            <?php } ?>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                          <br>

                          <div class="row">
                            <label class="col-md-11"><strong>Supplier</strong></label>
                          </div>
                          <br>
                          <div class="row">
                            <label class="col-lg-3">ID Supplier</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-11">
                                      <div class="input-group">
                                        <input id="id_suplayer" type="text" class="form-control" placeholder="Pilih Supplier" readonly style="background:#fff">
                                        <input id="valsuplayer" type="hidden" class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" onclick="carisuplayer()" type="button"><i class="fas fa-folder-open"></i></button>
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
                                        <div class="input-group">
                                        <input id="nama_pemilik" name="nama_pemilik" type="text" disabled class="form-control">
                                        <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"><a href="{{url('inputsuplayer')}}" target="_blank"><i class="fas fa-plus"></i></a></button>
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
                                        <input id="alamat" name="alamat" type="text" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                          </div>
                          <br>
                          <div hidden class="row">
                            <label class="col-lg-3">No. Telpon</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-11">
                                        <input id="no_hp" name="no_hp" type="text" disabled class="form-control">
                                    </div>
                                </div>
                            </div>
                          </div>
                      </div>

                        <div class="col-md-6">
                        
                          <div class="row">
                            <label class="col-lg-3">Catatan</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-11">
                                        <input id="noted" name="noted" type="text" maxlength="50" class="form-control" placeholder="keterangan (opsional), ex: No. Faktur dari Supplier">
                                    </div>
                                </div>
                            </div>
                          </div>
                        <br><br>
                        <div class="row">
                          <label class="col-lg-6"><strong>Petugas</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengorder</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                    <div class="input-group">
                                      <input id="driver" type="text" class="form-control" placeholder="Pilih Pengorder / Driver Pembelian" readonly style="background:#fff">
                                      <input id="iddrv" name="driver" type="hidden" class="form-control">
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
                          <label class="col-lg-3">QC Penerima</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                    <div class="input-group">
                                      <input id="qc" type="text" class="form-control" placeholder="Pilih QC Gudang Penerima" readonly style="background:#fff">
                                      <input id="idqc" name="qc" type="hidden" class="form-control">
                                      <div class="input-group-append">
                                          <button class="btn btn-outline-secondary" onclick="cariqc()" type="button"><i class="fas fa-folder-open"></i></button>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div hidden class="row">
                          <label class="col-lg-3">Admin</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input readonly value="{{Auth::user()->name}}" type="text" class="form-control">
                                      <input readonly id="id_admin" value="{{Auth::user()->id}}" type="hidden" class="form-control">
                                  </div>
                              </div>
                          </div>
                          
                        </div>

                          
                          <br>
                          <div class="row">
                            <label class="col-lg-6"><strong>Barang</strong></label>
                          </div>
                          <div hidden class="row">
                        <label class="col-lg-3" >Barcode</label>
                            <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="input-group">
                                        <input id="barcodescan"  type="text" class="form-control" placeholder="" onchange="onbarcoding()"><div class="wrapper">
                                        </div>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary border-0" data-toggle="tooltip" data-placement="top" 
                                        title="Untuk scan dengan Barcode Scanner, silahkan klik pada kolom [ | ] terlebih dahulu. Atau Anda juga dapat mengetik langsung kode barcode disini.">
                                        <i data-feather="alert-circle" class="feather-icon"></i></button>
                                    </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            </div>
                        </div>
                          <br>
                          <div class="row">
                            <label class="col-lg-3">Kode Barang</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-11">
                                      <div class="input-group">
                                        <input id="id_barang"  type="text" class="form-control" placeholder="Pilih Barang" readonly style="background:#fff">
                                        <input id="valbarang" type="hidden" class="form-control">
                                        <div class="input-group-append">
                                            <button id="cari_barang" class="btn btn-outline-secondary" onclick="caribarang()" type="button"><i class="fas fa-folder-open"></i></button>
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
                                      <div class="input-group">
                                        <input disabled id="nama_barang" name="nama_barang" type="text" class="form-control">
                                        <input id="pcs_koli" name="pcs_koli" type="hidden" class="form-control">
                                        <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"><a href="{{url('inputbarangbaru')}}" target="_blank"><i class="fas fa-plus"></i></a></button>
                                     </div>
                                     </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                          
                          <br>
                          <div class="row">
                            <label class="col-lg-3">Harga HP</label>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input id="harga_hp" name="harga_hp" type="number" class="form-control" placeholder="Rp.">
                                    </div>
                                </div>
                            </div>
                          </div>
                          <br>
                        <div class="row">
                          <label class="col-lg-3">Satuan</label>
                          <div class="col-lg-4">
                              <div class="row">
                                  <div class="col-md-12">
                                      <select  id="satuan" name="satuan" class="form-control">
                                        <option value='Pcs'>Pcs</option>
                                        <option value='Kolian'>Kolian</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                          <div class="row">
                            <label class="col-lg-3">Jumlah</label>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input id="jumlah" name="jumlah" type="number" class="form-control" placeholder="Qty">
                                    </div>
                                </div>
                            </div>
                          </div>
                          <br><br>
                          <center><button id="tambah" onclick="tambah()" class="btn btn-primary btn-lg"> Tambah </button></center>
                        </div>
                      </div>

                    <br><br>
                  <br><br><hr><br>
				<div class="table-responsive">
                  <table id="cart" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No SKU</th>
                              <th>Nama Barang</th>
                              <th>Jumlah</th>
                              <th>Harga HP</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>

                      </tbody>
                  </table>
				</div>
                <br>
                <center>
                  <button onclick="Simpan()" id="save" class="btn btn-success btn-lg">Simpan</button>
                  <!--button class="btn btn-danger btn-lg">Batal</button-->
                </center><br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


<div class="modal fade" id="suplayer" role="dialog">
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
                      <th>ID Supplier</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th hidden>No. Telepon</th>
                  </tr>
              </thead>
              <tbody>
                <?php foreach ($suplayer as $value){ ?>
                  <tr onclick="pilihsuplayer('{{$value->id}}','{{$value->id_suplayer}}','{{$value->nama_pemilik}}','{{$value->alamat}}','{{$value->no_hp}}')">
                      <td>{{$value->id_suplayer}}</td>
                      <td>{{$value->nama_pemilik}}</td>
                      <td><?php echo $value->alamat; ?></td>
                      <td hidden>{{$value->no_hp}}</td>
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

  <div class="modal fade" id="drv" role="dialog">
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
                        <th hidden>NIK</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach ($driver as $value){ ?>
                    <tr onclick="pilihdriver('{{$value->id}}','{{$value->nama}}')">
                        <td hidden>{{$value->nik}}</td>
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

    <div class="modal fade" id="qcs" role="dialog">
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
                          <th hidden>NIK</th>
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>No. Telepon</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($qc as $value){ ?>
                      <tr onclick="pilihqc('{{$value->id}}','{{$value->nama}}')">
                          <td hidden>{{$value->nik}}</td>
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

      <div class="modal fade" id="barang" role="dialog">
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
                            <th>No SKU</th>
                            <th>Nama Barang</th>
                            <th>Item No.</th>
                            <th>Isi per Kolian</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($barang as $value){ ?>
                        <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_sku}}','{{$value->nama_barang}}','{{$value->part_number}}','{{$value->pcs_koli}}')">
                            <td>{{$value->no_sku}}</td>
                            <td>{{$value->nama_barang}}</td>
                            <td>{{$value->part_number}}</td>
                            <td>{{$value->pcs_koli}}</td>
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

        <div class="modal fade" id="popup" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                  <div class="table-responsive">
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
      var konten = document.getElementById("konten2");
        CKEDITOR.replace(konten,{
        language:'en-gb'
      });
      CKEDITOR.config.allowedContent = true;
    </script>
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


    var tempbarang = [];
    var tempjumlah = [];

    function carisuplayer(){
      $('#suplayer').modal('show');
    }
    function pilihsuplayer(sup,id,nama_pemilik,alamat,hp){
      $('#suplayer').modal('hide');
      document.getElementById("valsuplayer").value = sup;
      document.getElementById("id_suplayer").value = id;
      document.getElementById("nama_pemilik").value = nama_pemilik;
      //CKEDITOR.instances['konten2'].setData(alamat);
      document.getElementById("alamat").value = alamat;
      document.getElementById("no_hp").value = hp;
    }
    function caridriver(){
      $('#drv').modal('show');
    }
    function pilihdriver(id,nama){
      $('#drv').modal('hide');
      document.getElementById("iddrv").value = id;
      document.getElementById("driver").value = nama;
    }
    function cariqc(){
      $('#qcs').modal('show');
    }
    function pilihqc(id,nama){
      $('#qcs').modal('hide');
      document.getElementById("idqc").value = id;
      document.getElementById("qc").value = nama;
    }
    function caribarang(){
      $('#barang').modal('show');
    }
    function pilihbarang(barang,id,nama,part_number,koli){
      $('#barang').modal('hide');
      document.getElementById("valbarang").value = barang;
      document.getElementById("id_barang").value = id;
      document.getElementById("nama_barang").value = nama;
      document.getElementById("pcs_koli").value = koli;
      
      $.ajax({
             url: 'cekhargabarangmasuk/'+barang,
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(response){
               document.getElementById("harga_hp").value = response[0]['harga_hp'];
             }
           });
           
      
    }
    
    
    function onbarcoding(){
    var sdf = document.getElementById("barcodescan").value;
     $.ajax({
     url: 'getBarangMasukBarcode/'+sdf,
     type: 'get',
     dataType: 'json',
     async: false,
     success: function(response){
       if(response.length > 0){
         play();
         document.getElementById("valbarang").value = barang;
         document.getElementById("id_barang").value = id;
         document.getElementById("nama_barang").value = nama;
         document.getElementById("jumlah").value = 1;
      
      $.ajax({
             url: 'cekhargabarangmasuk/'+barang,
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(response){
               document.getElementById("harga_hp").value = response[0]['harga_hp'];
             }
      });
         document.getElementById("barcodescan").value = "";
         tambah();
       }
     }
   });
    }
    
    function play(){
    var audio = new Audio('aset/beep.wav');
    audio.play();
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
          tempbarang[lastRow]="";
          tempjumlah[lastRow]="";
        }
      });
    }
    
    function ChangePembelian(){
        var panel = document.getElementById("jenis_cash_panel");
        var panels = document.getElementById("jenis_rekening_panel");
        var kategori_pembelian = document.getElementById("kategori_pembelian").value;
        if(kategori_pembelian == "cash"){
            panel.hidden = false;
            Changecash();
        }else{
            panel.hidden = true;
            panels.hidden = true;
        }
    }
    
    function Changecash(){
        var panel = document.getElementById("jenis_rekening_panel");
        var jenis_cash = document.getElementById("jenis_cash").value;
        if(jenis_cash == "transfer"){
            panel.hidden = false;
        }else{
            panel.hidden = true;
        }
    }

    function tambah(){
       var a = parseInt(document.getElementById("jumlah").value);
      var b = document.getElementById("pcs_koli").value;
      if( $('#satuan').val() == "Pcs") {
        var c =a;
        } else {
        var c =a*b;
        };    
      var id_barang = document.getElementById("id_barang").value;
      var nama_barang = document.getElementById("nama_barang").value;
      var valueid = document.getElementById("valbarang").value;
      var harga_hp = document.getElementById("harga_hp").value;
      
      if (a > 0 && id_barang != "") {
        var table = document.getElementById("cart");
        var lastRow = table.rows.length;
        var row = table.insertRow(lastRow);
        row.id = lastRow;

        tempbarang[lastRow] = valueid;
        tempjumlah[lastRow] = c;

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        cell1.innerHTML = id_barang;
        cell2.innerHTML = nama_barang;
        cell3.innerHTML = c;
        cell4.innerHTML = harga_hp;
        cell5.innerHTML = '<button class="btn btn-default" onclick="deletecart('+lastRow+')"><i class="icon-trash"></i></button>';
        document.getElementById("id_barang").value = "";
        document.getElementById("nama_barang").value = "";
        document.getElementById("jumlah").value = "";
        document.getElementById("harga_hp").value = "";
        
           $.ajax({
             url: 'updatehargahpmasuk/'+valueid+'/'+harga_hp,
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(response){
             }
           });
        
      }else{
        alert("Isikan Jumlah Terlebih Dahulu!");
      }
    }

    function Simpan(){
      var e = document.getElementById("id_gudang");
      var id_gudangs = e.options[e.selectedIndex].value;

      var no_fakturs = document.getElementById("no_faktur").value;
      var tgl_masuks = document.getElementById("tgl_masuk").value;
      var suplayers = document.getElementById("valsuplayer").value;
      var drivers = document.getElementById("iddrv").value;
      var admins = document.getElementById("id_admin").value;
      var qcs = document.getElementById("idqc").value;
      var kategori = document.getElementById("kategori").value;
      
      var kategori_pembelian = document.getElementById("kategori_pembelian").value;
      var jenis_cash = document.getElementById("jenis_cash").value;
      var jenis_rekening = document.getElementById("jenis_rekening").value;
      var noted = document.getElementById("noted").value;
      if (suplayers != "" && drivers != "" && qcs != "") {
        var namabarang;
        var jumlahbarang;
        for (var i = 0; i < tempbarang.length; i++) {
          if (tempjumlah[i] > 0) {
            namabarang += ","+String(tempbarang[i]);
            jumlahbarang += ","+String(tempjumlah[i]);
            /*$.post("postbarangmasuk",
              {no_faktur:no_fakturs, tgl_masuk:tgl_masuks, suplayer:suplayers, id_gudang:id_gudangs, driver:drivers, admin:admins, qc:qcs, barang:tempbarang[i], jumlah:tempjumlah[i], _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
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
                            location.href="{{url('/barangmasuk/')}}";
                          }else{
                            location.href="{{url('/barangmasuk/')}}";
                          }
                        });
                  }).fail(function(jqXHR, textStatus, errorThrown)
              {
                  alert(textStatus);
              });*/
          }
        }
        $.post("postbarangmasuk",
          {jenis_rekening:jenis_rekening,kategori_pembelian:kategori_pembelian,jenis_cash:jenis_cash,no_faktur:no_fakturs, tgl_masuk:tgl_masuks, suplayer:suplayers, id_gudang:id_gudangs, driver:drivers, admin:admins, qc:qcs, barang:namabarang, jumlah:jumlahbarang, kategori:kategori,noted:noted,_token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
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
                        location.href="{{url('/barangmasuk/')}}";
                      }else{
                        location.href="{{url('/barangmasuk/')}}";
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
