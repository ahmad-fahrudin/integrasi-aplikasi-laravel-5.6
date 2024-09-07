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
                          <li class="breadcrumb-item text-muted" aria-current="page">SDM > Member > <a href="https://stokis.app/?s=naik+level+member" target="_blank">Pengajuan Member Naik Level</a></li>
                      </ol>
                  </nav>
                </h4>
                <hr>
              <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Email</th>
                          <th>No HP</th>
                          <th>Akun Saat ini</th>
                          <th>Pengajuan ke</th>
                          <th>Tindakan</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($akun as $key => $value){ ?>
                    <tr>
                        <td>{{$no}}</td>
                        <td>{{$value->name}}</td>
                        <td>{{$value->email}}</td>
                        <td>{{$value->no_hp}}</td>
                        <td>{{status_konsumen($value->level)}}</td>
                        <td>{{status_konsumen($value->level+1)}}</td>
                        <td>
                            <button onclick="Approve('{{$value->id}}','{{$value->level+1}}','{{$value->name}}','{{status_konsumen($value->level+1)}}')" class="btn btn-primary">Verifikasi</button>
                            <button onclick="Cancel('{{$value->id}}','{{$value->level+1}}','{{$value->name}}','{{status_konsumen($value->level+1)}}')" class="btn btn-danger">Cancel</button>
                        </td>
                    </tr>
                    <?php $no++; } ?>
                  </tbody>
              </table>
              <br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script>
  function Approve(id,level,nama,status){
      Swal.fire(
        'Approve Pengajuan '+nama+' sebagai '+status+' ?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/approvepengajuan/')}}"+"/"+id+"/"+level;
        }
      });
  }
  function Cancel(id,level,nama,status){
      Swal.fire(
        'Batal Pengajuan '+nama+' sebagai '+status+' ?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/cancelpengajuan/')}}"+"/"+id+"/"+level;
        }
      });
  }
  </script>
@endsection
