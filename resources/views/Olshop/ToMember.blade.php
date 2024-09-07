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
                          <li class="breadcrumb-item text-muted" aria-current="page">SDM > member > <a href="https://stokis.app/?s=akun+member+online" target="_blank">Buat Akun Member Area</a></li>
                      </ol>
                  </nav>
                </h4>
                <hr>
                <label><h4>Data Member (Non Akun Member)</h4></label>
                <br><br>

              <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>No.</th>
                          <th>Nama Konsumen</th>
                          <th>Alamat</th>
                          <th>No. Telepon</th>
                          <th>Tindakan</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($akun as $key => $value){ ?>
                    <tr>
                        <td align="center">{{$no}}</td>
                        <td>{{$value->nama_pemilik}}</td>
                        <td><?=$value->alamat?></td>
                        <td>{{$value->no_hp}}</td>
                        <td>
                            <button onclick="Approve('{{$value->id}}','{{$value->nama_pemilik}}')" class="btn btn-primary">Buat Akun Member</button>
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
<div class="modal fade" id="detail" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        <h3>Buat Akun Member</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <br>    
            <form action="{{url('simpantomember')}}" method="post">
            {{csrf_field()}}
            Email:
            <input type="email" required name="email" id="email" class="form-control" onchange="cekemail()" placeholder="Ketik Email untuk Login Member Area">
            <b class="text-danger" id="notemail" hidden>Email Sudah Terdaftar!<br></b>
            <br>
            NIK:
            <input hidden type="number" name="nik" id="nik" class="form-control" placeholder="Ketik No. ID Card / KTP">
            <input type="hidden" name="id" id="id">
            <br>
            <input type="submit" value="PROSES" id="btnsave" class="btn btn-success" disabled>
            </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script>
  
    function cekemail(){
      var email = document.getElementById("email").value;
      $.ajax({
         url: '{{url("cekemailava")}}/'+email,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
            if(Number(response) > 0){
                document.getElementById("btnsave").disabled = true;
                document.getElementById("notemail").hidden = false;
            }else{
                document.getElementById("btnsave").disabled = false;
                document.getElementById("notemail").hidden = true;
            }
         }
       });
      return false;
  }
  
  function Approve(id,nama){
      document.getElementById("id").value = id;
      $('#detail').modal('show');
  }
  </script>
@endsection
