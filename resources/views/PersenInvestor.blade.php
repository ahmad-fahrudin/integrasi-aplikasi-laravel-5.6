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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > <a href="https://stokis.app/?s=bagi+hasil+investor" target="_blank">Bagi Hasil Investor</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                    <div class="col-md-12">
                        <form action="{{url('saveperseninvest')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                    <div class="row">
                      <div class="col-md-6">
                        <h2>Bagi Hasil Projek Pengadaan Barang</h2><br>
                        <strong>Jika Harga Jual > Harga Net</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Bagi hasil Projek</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pengadaanbasilA" class="form-control" maxlength="4" value="{{$pinvest[0]->pengadaanbasilA}}" placeholder="50">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga HPP - Harga HP
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>Jika Harga Jual < Harga Net & > Harga HPP</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Bagi hasil Projek</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pengadaanbasilB" class="form-control" maxlength="4" value="{{$pinvest[0]->pengadaanbasilB}}" placeholder="25">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga HPP - Harga HP
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>Jika Harga Jual < Harga HPP & > Harga HP</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Bagi hasil Projek</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pengadaanbasilC" class="form-control" maxlength="4" value="{{$pinvest[0]->pengadaanbasilC}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga HP
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>Jika Lock Saldo 3 Bulan</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Investor</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="number" name="pengadaanLS3" class="form-control" maxlength="4" value="{{$pinvest[0]->pengadaanLS3}}" placeholder="70">
                                  </div>
                                  <div class="col-md-10">
                                      % * Bagi hasil Projek
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>Jika Lock Saldo 6 Bulan</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Investor</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="number" name="pengadaanLS6" class="form-control" maxlength="4" value="{{$pinvest[0]->pengadaanLS6}}" placeholder="85">
                                  </div>
                                  <div class="col-md-10">
                                      % * Bagi hasil Projek
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>Jika Lock Saldo 12 Bulan</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Investor</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="number" name="pengadaanLS12" class="form-control" maxlength="4" value="{{$pinvest[0]->pengadaanLS12}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Bagi hasil Projek
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>Persentase Team Pengembang Investasi</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengembang Investor</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="number" name="pengadaan_P" class="form-control" maxlength="4" value="{{$pinvest[0]->pengadaan_P}}" placeholder="15">
                                  </div>
                                  <div class="col-md-10">
                                      % * Bagihasil Projek
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Leader</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="number" name="pengadaan_L" class="form-control" maxlength="4" value="{{$pinvest[0]->pengadaan_L}}" placeholder="5">
                                  </div>
                                  <div class="col-md-10">
                                      % * Bagihasil Projek
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        
                        
                    </div>

                      <div class="col-md-6">
                          <h2>Bagi Hasil Investasi Deposit</h2>
                          <br>
                        <strong>Jika Lock Investasi 3 Bulan</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Investor</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-3">
                                      <input name="investasiLS3" type="decimal" step="0.1" class="form-control" placeholder="0" data-a-sign="" data-a-dec="," value="{{$pinvest[0]->investasiLS3}}" placeholder="1" >
                                  </div>
                                  <div class="col-md-8">
                                      % * Lock Investasi (Per Bulan)
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>Jika Lock Investasi 6 Bulan</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Investor</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-3">
                                      <input name="investasiLS6" type="decimal" step="0.1" class="form-control" placeholder="0" data-a-sign="" data-a-dec="," value="{{$pinvest[0]->investasiLS6}}" placeholder="1.5">
                                  </div>
                                  <div class="col-md-8">
                                      % * Lock Investasi (Per Bulan)
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>Jika Lock Investasi 12 Bulan</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Investor</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-3">
                                      <input name="investasiLS12" type="decimal" step="0.1" class="form-control" placeholder="0" data-a-sign="" data-a-dec="," value="{{$pinvest[0]->investasiLS12}}" placeholder="2">
                                  </div>
                                  <div class="col-md-8">
                                      % * Lock Investasi (Per Bulan)
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>Persentase Team Pengembang Investasi</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengembang Investor</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-3">
                                      <input type="number" name="investasi_P" type="decimal" step="0.1" class="form-control" placeholder="0" data-a-sign="" data-a-dec="," value="{{$pinvest[0]->investasi_P}}" placeholder="0.15">
                                  </div>
                                  <div class="col-md-8">
                                      % * Lock Investasi (Per Bulan)
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Leader</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-3">
                                      <input type="number" name="investasi_L" type="decimal" step="0.1" class="form-control" placeholder="0" data-a-sign="" data-a-dec="," value="{{$pinvest[0]->investasi_L}}" placeholder="0.05">
                                  </div>
                                  <div class="col-md-8">
                                      % * Lock Investasi (Per Bulan)
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        
                        
                        
                        <br>
                        </div>
                        </div>
                        </div>
                        </div>

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
@endsection
