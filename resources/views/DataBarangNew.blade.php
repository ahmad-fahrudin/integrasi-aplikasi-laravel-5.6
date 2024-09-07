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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > Master Barang > <a href="https://stokis.app/?s=edit+hapus+data+barang+stok+gudang" target="_blank">Edit Data Per Barang</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-12"><strong>Barang</strong></label>
                        </div>
                        <br>
                        <form action="{{url('updatebarang')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                        
                        <div class="row">
                          <label class="col-lg-3">No. SKU</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="input-group">
                                      <input id="sku" type="text" readonly class="form-control" placeholder="Pilih No. SKU Barang" style="background:#fff">
                                      <input id="id" name="id" type="hidden" class="form-control">
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
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="nama_barang" required name="nama_barang" maxlength="40" type="text" class="form-control" placeholder="Nama Barang dan Type Produk">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Item No.</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="part_number" name="part_number" maxlength="40" type="text" class="form-control" placeholder="Kode Identifikasi Produk (No.Reg / No. Part / ...)">
                                  </div>
                              </div>
                          </div>
                        </div>
                    
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Group</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                     <input id="kategori" required name="kategori" maxlength="40" type="text" class="form-control" placeholder="Group Item / Kategori Produk">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Status Barang</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <!--input id="branded" name="branded" type="text" class="form-control"-->
                                      <select  id="branded" name="branded" class="form-control">
                                        <option disabled selected>-- Pilih Status --</option>
                                        <option value='0'>Umum</option>
                                        <option value='1'>PKP</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                       
                         <br>
                        <div class="row">
                          <label class="col-lg-3">Satuan Pcs</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <select id="satuan_pcs" name="satuan_pcs" class="form-control">
                                          <option value="Pcs">Pcs</option>
                                          <option value="Set">Set</option>
                                          <option value="Botol">Botol</option>
                                          <option value="Kg">Kg</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Satuan Kolian</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <select id="satuan_koli" name="satuan_koli" class="form-control">
                                          <option value="Koli">Koli</option>
                                          <option value="Ball">Ball</option>
                                          <option value="Dus">Dus</option>
                                          <option value="Kodi">Kodi</option>
                                          <option value="Lusin">Lusin</option>
                                          <option value="Unit">Unit</option>
                                          <option value="Karung">Karung</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                    
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pcs Per Kolian</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="pcs_koli" id="pcs_koli" class="form-control" placeholder="Isi Per Kolian">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Lokasi Kulakan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="lokasi" name="lokasi" type="text" maxlength="30" class="form-control" placeholder="nama kota/kab lokasi pembelian">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                       <br>
                        
                        <div class="row">
                          <label class="col-lg-3">Catatan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="keterangan" name="keterangan" type="text" maxlength="50" class="form-control" placeholder="Keterangan (Opsional)">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                         <div hidden id="qr-reader" style="width:100%"></div>
                        <div hidden id="qr-reader-results"></div>
                        
                        <div class="row">
                          <label class="col-lg-3">Barcode</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="id_barcode" maxlength="25" class="form-control" id="barcode" placeholder="Kode Barkode Produk">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <center>
                          <button class="btn btn-success btn-lg">Simpan</button>
                        </center>
                      </form>
                      <button class="btn btn-danger btn-sm" id="del_barang" onclick="Deleted()" style="visibility:hidden;"><i class="icon-trash"></i> Hapus Data Barang</button>
                      </div>
                    </div>

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
              <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>No SKU</th>
                          <th>Nama</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($barang as $value){ ?>
                      <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_sku}}','{{$value->nama_barang}}','{{$value->branded}}','{{$value->part_number}}','{{$value->kategori}}','{{$value->pcs_koli}}','{{$value->satuan_pcs}}','{{$value->satuan_koli}}','{{$value->lokasi}}','{{$value->keterangan}}','{{$value->id_barcode}}')">
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

      <script src="aset/html5-qrcode.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
      <script>

      function docReady(fn) {
          // see if DOM is already available
          if (document.readyState === "complete"
              || document.readyState === "interactive") {
              // call on next available tick
              setTimeout(fn, 1);
          } else {
              document.addEventListener("DOMContentLoaded", fn);
          }
      }

      docReady(function () {
          var resultContainer = document.getElementById('qr-reader-results');
          var lastResult, countResults = 0;
          function onScanSuccess(decodedText, decodedResult) {
              if (decodedText !== lastResult) {
                  ++countResults;
                  lastResult = decodedText;
                  // Handle on success condition with the decoded message.
                  document.getElementById("barcode").value = decodedText;
                  //console.log(decodedText);
              }
          }

          var html5QrcodeScanner = new Html5QrcodeScanner(
              "qr-reader", { fps: 10, qrbox: 250 });
          html5QrcodeScanner.render(onScanSuccess);
      });

      function caribarang(){
        $('#barang').modal('show');
      }
      var del = "";
      var name_del = "";
      function pilihbarang(id,sku,nama,branded,part_number,kategori,pcs_koli,satuan_pcs,satuan_koli,lokasi,keterangan,id_barcode){
        $('#barang').modal('hide');
        document.getElementById("sku").value = sku;
        document.getElementById("nama_barang").value = nama;
        document.getElementById("id").value = id;
        
        
        if (Number(branded) == 0) {
          document.getElementById("branded").value = 0;
        }else{
          document.getElementById("branded").value = 1;
        }
        document.getElementById("part_number").value = part_number;
        document.getElementById("kategori").value = kategori;
        document.getElementById("satuan_pcs").value = satuan_pcs;
        document.getElementById("satuan_koli").value = satuan_koli;
        document.getElementById("pcs_koli").value = pcs_koli;
        document.getElementById("lokasi").value = lokasi;
        document.getElementById("keterangan").value = keterangan;
        document.getElementById("barcode").value = id_barcode;
        del = id;
        name_del = nama;
        document.getElementById("del_barang").style.visibility = "visible";
      }
      function Deleted()
      {
        Swal.fire(
          'Delete '+name_del+'?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            location.href="{{url('/deleteBarang/')}}"+"/"+del;
          }
        });
      }
      
      </script>
@endsection
