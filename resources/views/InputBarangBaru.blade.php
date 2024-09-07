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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > Master Barang > <a href="https://stokis.app/?s=input+nama+barang+baru" target="_blank">Input Nama Barang Baru</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <form action="{{url('insertbarang')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                        <div id="qr-reader" style="width:100%"></div>
                        <div id="qr-reader-results"></div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Barcode</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="id_barcode" maxlength="30" class="form-control" id="barcode" placeholder="Kode Barcode Produk">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">No. SKU</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="no_sku" class="form-control" readonly value="{{$no_sku}}">
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
                                      <input type="text" required name="nama_barang" maxlength="50" class="form-control" placeholder="Nama barang dan Type produk">
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
                                      <input type="text" name="part_number" maxlength="50" class="form-control" placeholder="Kode identifikasi produk (No. Reg / No. Part /...)">
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
                                      <input type="checkbox" name="branded" value="1"> <b>PKP</b> (Tandai sebagai produk dengan status khusus).
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
                                    <input type="text" required name="kategori" maxlength="50" class="form-control" placeholder="Group Item / Kategori Produk">
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
                                      <select name="satuan_pcs" class="form-control">
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
                                      <select name="satuan_koli" class="form-control">
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
                                      <input type="number" required name="pcs_koli" value="1" class="form-control" placeholder="Isi Per Kolian">
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
                                      <textarea name="lokasi" class="form-control" maxlength="30" placeholder="Nama kota/kab lokasi pembelian"></textarea>
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
                                      <textarea name="keterangan" class="form-control" maxlength="60" placeholder="Keterangan (Opsional)"></textarea>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <center>
                          <button class="btn btn-success btn-lg">Simpan</button>
                        </center>
                       </form>
                      </div>
                    </div>

                    <!--form method="post" action="{{url('/import/import_excel')}}" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-6"><strong>Import Database</strong></label>
                        </div>
                        <div class="row">
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      {{ csrf_field() }}
                                      <input name="file" type="file">
                                      <button class="btn btn-success">Upload Database</button>
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    </form-->

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="aset/html5-qrcode.min.js"></script>
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

    
</script>
@endsection
