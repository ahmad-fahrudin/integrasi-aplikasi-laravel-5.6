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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pemasaran > Promo Diskon > <a href="https://stokis.app/?s=membuat+promo+diskon+untuk+periode+waktu+tertentu" target="_blank">Buat Periode Promo (Flash Sale)</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                          <form action="{{url('insertpromo')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Kategori Promo</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" required maxlength="30" name="nama_promo" class="form-control" placeholder="Ketik nama promo...">
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
                                    <div class="input-group">
                                      <input id="nama_barang" type="text" class="form-control" placeholder="Pilih Barang" readonly style="background:#fff">
                                      <input id="id_barang" name="id_barang" type="hidden" class="form-control">
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
                          <label class="col-lg-3">Potongan Harga</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="number" required name="persentase" class="form-control" placeholder="0">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Promo Mulai</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="date" required name="start" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Promo Selesai</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="date" required name="end" class="form-control">
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
                      <tr onclick="pilihbarang('{{$value->id}}','{{$value->nama_barang}}')">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
function caribarang(){
  $('#barang').modal('show');
}
function pilihbarang(id,nama){
  $('#barang').modal('hide');
  document.getElementById("id_barang").value = id;
  document.getElementById("nama_barang").value = nama;
}
</script>


@endsection
