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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pemasaran > Voucher Diskon > <a href="https://stokis.app/?s=buat+kode+voucher+diskon" target="_blank">Buat Kode Voucher</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                          <form action="{{url('insertvoucher')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Kode Voucher</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" maxlength="10" required name="kode_voucher" class="form-control" placeholder="Ketik kode voucher...">
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
                                      <input type="number" required name="potongan" class="form-control" placeholder="0">
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
                          <label class="col-lg-3">Promo Berakhir</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="date" required name="end" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Jumlah Voucher</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="number" required name="jumlah" class="form-control" placeholder="0">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Minimal Pembelian</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="number" required name="minimal" class="form-control" placeholder="0">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
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
