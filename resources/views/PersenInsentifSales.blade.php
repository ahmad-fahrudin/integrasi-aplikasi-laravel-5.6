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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > insentif Pemasaran > <a href="https://stokis.app/?s=insentif+sales+marketing" target="_blank">Sales Marketing (Supplier & Distributor)</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <form action="{{url('savepersenfee1')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                        <strong>Persentase Selisih Harga Jual - Harga HPP</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Team Pengembangan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="itung_a" class="form-control" value="{{$pfee[1]->itung_a}}" placeholder="50">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga HPP
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
                                      <input type="text" name="itung_b" class="form-control" value="{{$pfee[1]->itung_b}}" placeholder="40">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga HPP
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
                                      <input type="text" name="stokis" class="form-control" value="{{$pfee[1]->stokis}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga HPP
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        
                        
                        <strong>Persentase Pembagian Fee Team Pengembangan</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Sales / CS</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="sales" class="form-control" value="{{$pfee[1]->sales}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengembang Toko</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pengembang" class="form-control" value="{{$pfee[1]->pengembang}}" placeholder="40">
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
                                      <input type="text" name="leader" class="form-control" value="{{$pfee[1]->leader}}" placeholder="15">
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
                                      <input type="text" name="manager" class="form-control" value="{{$pfee[1]->manager}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Dropper</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="dropper" class="form-control" value="{{$pfee[1]->dropper}}" placeholder="1">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengirim</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pengirim" class="form-control" value="{{$pfee[1]->pengirim}}" placeholder="15">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Helper</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="helper" class="form-control" value="{{$pfee[1]->helper}}" placeholder="5">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Admin Gudang</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="admin_g" class="form-control" value="{{$pfee[1]->admin_g}}" placeholder="1">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Admin Penjualan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="admin_v" class="form-control" value="{{$pfee[1]->admin_v}}" placeholder="1">
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
                                      <input type="text" name="admin_k" class="form-control" value="{{$pfee[1]->admin_k}}" placeholder="1">
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
                                      <input type="text" name="qc" class="form-control" value="{{$pfee[1]->qc}}" placeholder="1">
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
