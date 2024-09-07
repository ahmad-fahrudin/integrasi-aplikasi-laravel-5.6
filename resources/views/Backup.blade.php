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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > <a href="https://stokis.app/?s=backup+database" target="_blank">Backup & Restore Database</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-6"><strong>Export Database</strong></label>
                        </div>
                        <div class="row">
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <button class="btn btn-success" onclick="location.href='{{url('download_database')}}';"><i class="fa fa-download" aria-hidden="true"></i> Unduh Database</button>
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <br><br><br>
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
                                      <input name="file" type="file" class="form-control"><br>
                                      <button class="btn btn-danger" disabled="disabled"><i class="icon-lock"></i> Upload Database</button>
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
