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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > insentif Pemasaran > <a href="https://stokis.app/?s=insentif+level+membership+referral" target="_blank">Membership Network (Multi Level Marketing Referral)</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                    <div class="col-md-12">
                        <form action="{{url('savepersenfee')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                    <div class="row">
                      <div class="col-md-6">
                         <strong>#1. Jika Member Retail => Pereferral Member Reseller</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Reseller]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralUR" class="form-control" value="{{$pfee[0]->pereferralUR}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Reseller
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 1 <br>[Level Agen]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline1UR" class="form-control" value="{{$pfee[0]->upline1UR}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Reseller - Harga Agen
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 2 <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline2UR" class="form-control" value="{{$pfee[0]->upline2UR}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Agen - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>#2. Jika Member Retail => Pereferral Member Agen</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Agen]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralUA" class="form-control" value="{{$pfee[0]->pereferralUA}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Agen
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 1 <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline1UA" class="form-control" value="{{$pfee[0]->upline1UA}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Agen - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>#3. Jika Member Retail => Pereferral Member Distributor</strong><br>
                        <strong>#OR Jika Member Retail => Pereferral Member Pengembang</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralUD" class="form-control" value="{{$pfee[0]->pereferralUD}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>#4. Jika Member Reseller => Pereferral Member Agen</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Agen]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralRA" class="form-control" value="{{$pfee[0]->pereferralRA}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Agen
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 1 <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline1RA" class="form-control" value="{{$pfee[0]->upline1RA}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Agen - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>#5. Jika Member Reseller => Pereferral Member Distributor</strong><br>
                        <strong>#OR Jika Member Reseller => Pereferral Member Pengembang</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralRD" class="form-control" value="{{$pfee[0]->pereferralRD}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>#6. Jika Member Agen => Pereferral Member Distributor</strong><br>
                        <strong>#OR Jika Member Agen => Pereferral Member Pengembang</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralAD" class="form-control" value="{{$pfee[0]->pereferralAD}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                    
                        
                        <br>
                        <strong>Persentase Selisih Harga Net - Harga HPP</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Team Pengembangan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="itung_a" class="form-control" value="{{$pfee[0]->itung_a}}" placeholder="50">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Net - Harga HPP
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
                                      <input type="text" name="itung_b" class="form-control" value="{{$pfee[0]->itung_b}}" placeholder="30">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Net - Harga HPP
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Bagihasil Stokis<br>Pengelola Cabang</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="stokis" class="form-control" value="{{$pfee[0]->stokis}}" placeholder="20">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Net - Harga HPP
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
                                      <input type="text" name="sales" class="form-control" value="{{$pfee[0]->sales}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengembang Jaringan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pengembang" class="form-control" value="{{$pfee[0]->pengembang}}" placeholder="50">
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
                                      <input type="text" name="leader" class="form-control" value="{{$pfee[0]->leader}}" placeholder="20">
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
                                      <input type="text" name="manager" class="form-control" value="{{$pfee[0]->manager}}" placeholder="10">
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
                                      <input type="text" name="dropper" class="form-control" value="{{$pfee[0]->dropper}}" placeholder="1">
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
                                      <input type="text" name="pengirim" class="form-control" value="{{$pfee[0]->pengirim}}" placeholder="3">
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
                                      <input type="text" name="helper" class="form-control" value="{{$pfee[0]->helper}}" placeholder="2">
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
                                      <input type="text" name="admin_g" class="form-control" value="{{$pfee[0]->admin_g}}" placeholder="1">
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
                                      <input type="text" name="admin_v" class="form-control" value="{{$pfee[0]->admin_v}}" placeholder="1">
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
                                      <input type="text" name="admin_k" class="form-control" value="{{$pfee[0]->admin_k}}" placeholder="1">
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
                                      <input type="text" name="qc" class="form-control" value="{{$pfee[0]->qc}}" placeholder="1">
                                  </div>
                                  <div class="col-md-10">
                                      % * Team Pengembangan
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                    </div>

                      <div class="col-md-6">
                          <strong>#7. Jika Member Retail => Pereferral Member Retail</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Retail]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralUU" class="form-control" value="{{$pfee[0]->pereferralUU}}" placeholder="50">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Reseller
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 1 <br>[Level Reseller]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline1UU" class="form-control" value="{{$pfee[0]->upline1UU}}" placeholder="50">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Reseller
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 2 <br>[Level Agen]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline2UU" class="form-control" value="{{$pfee[0]->upline2UU}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Reseller - Harga Agen
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 3 <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline3UU" class="form-control" value="{{$pfee[0]->upline3UU}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Agen - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>#8. Jika Member Reseller => Pereferral Member Reseller</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Reseller]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralRR" class="form-control" value="{{$pfee[0]->pereferralRR}}" placeholder="50">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Agen
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 1 <br>[Level Agen]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline1RR" class="form-control" value="{{$pfee[0]->upline1RR}}" placeholder="50">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Agen
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 2 <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline2RR" class="form-control" value="{{$pfee[0]->upline2RR}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Agen - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <br>
                        <strong>#9. Jika Member Agen => Pereferral Member Agen</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Agen]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralAA" class="form-control" value="{{$pfee[0]->pereferralAA}}" placeholder="15">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 1 <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline1AA" class="form-control" value="{{$pfee[0]->upline1AA}}" placeholder="85">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>#10. Jika Member Distributor => Pereferral Member Distributor</strong><br>
                        <strong>#OR Jika Member Pengembang => Pereferral Member Distributor</strong><br>
                        <strong>#OR Jika Member Distributor => Pereferral Member Pengembang</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralDD" class="form-control" value="{{$pfee[0]->pereferralDD}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Fee Pengembang
                                  </div>
                              </div>
                          </div>
                        </div>
                        -> Berbagi: Fee Pengembang akan berkurang sesuai persentase diatas.
                        <br>
                        <br>
                        <strong>#11. Jika Member Reseller => Pereferral Member Retail</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Retail]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralRU" class="form-control" value="{{$pfee[0]->pereferralRU}}" placeholder="25">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Agen
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 1 <br>[Level Reseller]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline1RU" class="form-control" value="{{$pfee[0]->upline1RU}}" placeholder="25">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Agen
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 2 <br>[Level Agen]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline2RU" class="form-control" value="{{$pfee[0]->upline2RU}}" placeholder="50">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Agen
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 3 <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline3RU" class="form-control" value="{{$pfee[0]->upline3RU}}" placeholder="100">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Agen - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <br>
                        <strong>#12. Jika Member Agen => Pereferral Member Retail</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Retail]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralAU" class="form-control" value="{{$pfee[0]->pereferralAU}}" placeholder="15">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 1 <br>[Level Reseller]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline1AU" class="form-control" value="{{$pfee[0]->upline1AU}}" placeholder="15">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 2 <br>[Level Agen]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline2AU" class="form-control" value="{{$pfee[0]->upline2AU}}" placeholder="15">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 3 <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline3AU" class="form-control" value="{{$pfee[0]->upline3AU}}" placeholder="55">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>#13. Jika Member Distributor => Pereferral Member Retail</strong><br>
                        <strong>#OR Jika Member Pengembang => Pereferral Member Retail</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Retail]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralDU" class="form-control" value="{{$pfee[0]->pereferralDU}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Fee Pengembang
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 1 <br>[Level Reseller]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline1DU" class="form-control" value="{{$pfee[0]->upline1DU}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Fee Pengembang
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 2 <br>[Level Agen]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline2DU" class="form-control" value="{{$pfee[0]->upline2DU}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Fee Pengembang
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 3 <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline3DU" class="form-control" value="{{$pfee[0]->upline3DU}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Fee Pengembang
                                  </div>
                              </div>
                          </div>
                        </div>
                        -> Berbagi: Fee Pengembang akan berkurang sejumlah persentase diatas.
                        <br>
                        <br>
                        <strong>#14. Jika Member Agen => Pereferral Member Reseller</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Reseller]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralAR" class="form-control" value="{{$pfee[0]->pereferralAR}}" placeholder="15">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 1 <br>[Level Agen]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline1AR" class="form-control" value="{{$pfee[0]->upline1AR}}" placeholder="15">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 2 <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline2AR" class="form-control" value="{{$pfee[0]->upline2AR}}" placeholder="70">
                                  </div>
                                  <div class="col-md-10">
                                      % * Selisih Harga Jual - Harga Distributor
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <strong>#15. Jika Member Distributor => Pereferral Member Reseller</strong><br>
                        <strong>#OR Jika Member Pengembang => Pereferral Member Reseller</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Reseller]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralDR" class="form-control" value="{{$pfee[0]->pereferralDR}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Fee  Pengembang
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 1 <br>[Level Agen]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline1DR" class="form-control" value="{{$pfee[0]->upline1DR}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Fee Pengembang
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 2 <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline2DR" class="form-control" value="{{$pfee[0]->upline2DR}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Fee Pengembang
                                  </div>
                              </div>
                          </div>
                        </div>
                        -> Berbagi: Fee Pengembang akan berkurang sejumlah persentase diatas.
                        <br>
                        <br>
                        <strong>#16. Jika Member Distributor => Pereferral Member Agen</strong><br>
                        <strong>#OR Jika Member Pengembang => Pereferral Member Agen</strong>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pereferral <br>[Level Agen]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="pereferralDA" class="form-control" value="{{$pfee[0]->pereferralDA}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Fee  Pengembang
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Upline 1 <br>[Level Distributor]</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-2">
                                      <input type="text" name="upline1DA" class="form-control" value="{{$pfee[0]->upline1DA}}" placeholder="10">
                                  </div>
                                  <div class="col-md-10">
                                      % * Fee Pengembang
                                  </div>
                              </div>
                          </div>
                        </div>
                        -> Berbagi: Fee Pengembang akan berkurang sejumlah persentase diatas.
                        <br>
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
