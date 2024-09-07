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
                              <li class="breadcrumb-item text-muted" aria-current="page">SDM > Supplier Barang > <a href="https://stokis.app/?s=input+supplier+barang" target="_blank">Input Supplier Baru</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                          <form action="{{url('inputsuplayeract')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                        <div class="row">
                          <label class="col-lg-3">ID Supplier</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="id_suplayer" readonly class="form-control" value="{{'SPL'.date('ymd').$number}}">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Supplier</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" required maxlength="40" name="nama_pemilik" class="form-control" placeholder="Ketik nama Supplier / Produsen">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Alamat<br>(Jalan, Desa RT/RW, Kecamatan)</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <textarea name="alamat" maxlength="50" id="konten" required class="form-control"></textarea>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Kabupaten/Kota</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" maxlength="30" required name="kota" class="form-control" placeholder="Ketik nama Kabupaten/Kota">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">No. Telepon</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" maxlength="13" required name="no_hp" class="form-control" placeholder="Ketik No. HP / Whatsapp">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Catatan<br>(Share Lokasi & Keterangan Usaha)</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <textarea name="keterangan" id="konten2" maxlength="100" class="form-control"></textarea>
                                      <!--input type="text" required name="keterangan" class="form-control"-->
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

    <script>
      var konten = document.getElementById("konten");
        CKEDITOR.replace(konten,{
        language:'en-gb'
      });
      CKEDITOR.config.allowedContent = true;
    </script>
    <script>
      var konten2 = document.getElementById("konten2");
        CKEDITOR.replace(konten2,{
        language:'en-gb'
      });
      CKEDITOR.config.allowedContent = true;
    </script>

@endsection
