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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > insentif Pemasaran > <a href="https://stokis.app/?s=insentif+petugas+layanan+jasa" target="_blank">Layanan Jasa</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <form action="{{url('savepersenfee2')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                        <strong>Bagi Hasil Layanan Jasa</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Team Pengembangan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="itung_a" class="form-control" value="{{$pfee[2]->itung_a}}" placeholder="40">
                                  </div>
                                  <div class="col-md-10">
                                      % * Biaya Jasa
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Perusahaan (Operasional)</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="itung_b" class="form-control" value="{{$pfee[2]->itung_b}}" placeholder="50">
                                  </div>
                                  <div class="col-md-10">
                                      % * Biaya Jasa
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Bagihasil Stokis <br>Pengelola Cabang</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="stokis" class="form-control" value="{{$pfee[2]->stokis}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Biaya Jasa
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                         <strong>Jika dikerjakan oleh 1 Petugas</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Petugas</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="petugas1a" class="form-control" value="{{$pfee[2]->petugas1a}}" placeholder="70">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>Jika dikerjakan oleh 2 Petugas</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Petugas 1</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="petugas1b" class="form-control" value="{{$pfee[2]->petugas1b}}" placeholder="50">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Petugas 2</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="petugas2b" class="form-control" value="{{$pfee[2]->petugas2b}}" placeholder="20">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>Jika dikerjakan oleh 3 Petugas</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Petugas 1</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="petugas1c" class="form-control" value="{{$pfee[2]->petugas1c}}" placeholder="40">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Petugas 2</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="petugas2c" class="form-control" value="{{$pfee[2]->petugas2c}}" placeholder="15">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Petugas 3</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="petugas3c" class="form-control" value="{{$pfee[2]->petugas3c}}" placeholder="15">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>Persentase Pembagian Fee Pengembangan</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengembang Member</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pengembang" class="form-control" value="{{$pfee[2]->pengembang}}" placeholder="15">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
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
                                      <input type="text" name="leader" class="form-control" value="{{$pfee[2]->leader}}" placeholder="6">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Manager</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="manager" class="form-control" value="{{$pfee[2]->manager}}" placeholder="4">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Admin Keuangan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="admin_k" class="form-control" value="{{$pfee[2]->admin_k}}" placeholder="1">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Kasir</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="sales" class="form-control" value="{{$pfee[2]->sales}}" placeholder="1">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">QC</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="qc" class="form-control" value="{{$pfee[2]->qc}}" placeholder="3">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
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
@endsection
