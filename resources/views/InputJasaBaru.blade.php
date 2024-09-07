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
                              <li class="breadcrumb-item text-muted" aria-current="page">Layanan Jasa > <a href="https://stokis.app/?s=tambah+layanan+jasa" target="_blank">Tambah Layanan Jasa</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <div class="row">
                      <div class="col-md-8">
                        <form action="{{url('simpanjasa')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Kode</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-8">
                                      <input type="text" name="kode" class="form-control" value="JSU{{$number}}" readonly >
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Layanan Jasa</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-8">
                                      <input type="text" required name="nama_jasa" class="form-control" placeholder="Ketik nama layanan jasa...">
                                  </div>
                              </div>
                          </div>
                        </div>
                       
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Biaya Jasa</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-8">
                                      <input type="number" required name="biaya" class="form-control" placeholder="0">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                         <br>
                        <div class="row">
                          <label class="col-lg-3">Group</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-8">
                                      <input type="text" required name="kategori_jasa" class="form-control" placeholder="Isi Group / Kategori Jasa">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Waktu</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-8">
                                      <input type="text" required name="waktu" class="form-control" placeholder="Isi Waktu Pengerjaan">
                                  </div>
                              </div>
                          </div>
                        </div>
                       
                        <br>
                        <div hidden class="row">
                          <label class="col-lg-3">Poin</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-4">
                                      <input type="number" required name="poin" value="0" class="form-control" placeholder="0">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="aset/html5-qrcode.min.js"></script>
@endsection
