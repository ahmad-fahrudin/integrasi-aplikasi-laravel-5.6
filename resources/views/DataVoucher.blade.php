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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pemasaran > Voucher Diskon > <a href="https://stokis.app/?s=data+voucher+diskon" target="_blank">Data Voucher</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                  <br>
									<div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Kode Voucher</th>
                              <th>Potongan Harga</th>
                              <th>Jumlah Voucher</th>
                              <th>Minimal Pembelian</th>
                              <th>Voucher Terpakai</th>
                              <th>Promo Mulai</th>
                              <th>Promo Berakhir</th>
                              <th>Status</th>
                              <?php if (Auth::user()->level == "1"): ?>
                                <th>Tindakan</th>
                              <?php endif; ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; foreach ($voucher as $datapromo) { ?>
                          <tr
                          <?php if ($datapromo->status == ""){
                             echo "style='background:#b7ffc6'";
                           }else{
                             echo "style='background:#dedede'";
                           } ?>
                          >
                              <td>{{$no}}</td>
                              <td>{{$datapromo->kode_voucher}}</td>
                              <td align="right">{{ribuan($datapromo->potongan)}}</td>
                              <td>{{ribuan($datapromo->jumlah)}}</td>
                              <td>{{ribuan($datapromo->minimal)}}</td>
                              <td>{{ribuan($datapromo->available)}}</td>
                              <td>{{$datapromo->start}}</td>
                              <td>{{$datapromo->end}}</td>
                              <td><?php if ($datapromo->status == ""){ ?>
                                Aktif
                              <?php }else{ echo $datapromo->status; } ?></td>
                              <?php if (Auth::user()->level == "1"): ?>
                              <td>
                                <button class="btn btn-default" onclick="edit('{{$datapromo->id}}')"><i class="icon-pencil"></i></button>
                                <button class="btn btn-default" onclick="Deleted('{{$datapromo->kode_voucher}}','{{$datapromo->id}}')"><i class="icon-trash"></i></button>
                              </td>
                              <?php endif; ?>
                          </tr>
                         <?php $no++;} ?>
                      </tbody>
                  </table>
		            </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="editmodal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="{{url('simpanvoucher')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
          <br>
          <div class="row">
            <label class="col-lg-3">Kode Voucher</label>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" required maxlength="10" name="kode_voucher" id="kode_voucher" class="form-control" placeholder="Ketik kode voucher...">
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
                        <input type="number" required name="potongan" id="potongan" class="form-control" placeholder="0">
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
                        <input type="date" required name="start" id="start" class="form-control">
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
                        <input type="date" required name="end" id="end" class="form-control">
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
                        <input type="number" required name="jumlah" id="jumlah" class="form-control">
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
                        <input type="number" required name="minimal" id="minimal" class="form-control">
                    </div>
                </div>
            </div>
          </div>
          
          <br>
          <input type="hidden" name="id" id="id" value="">
          <br>
          <center>
            <button class="btn btn-success btn-lg">Update</button>
          </center>
         </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



  <script>
    var konten = document.getElementById("konten2");
      CKEDITOR.replace(konten,{
      language:'en-gb'
    });
    CKEDITOR.config.allowedContent = true;
  </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    function edit(value)
    {
        $.ajax({
           url: 'getdetailvoucher/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
              document.getElementById("kode_voucher").value = response[0]['kode_voucher'];
              document.getElementById("potongan").value = response[0]['potongan'];
              document.getElementById("start").value = response[0]['start'];
              document.getElementById("end").value = response[0]['end'];
              document.getElementById("id").value = response[0]['id'];
              document.getElementById("jumlah").value = response[0]['jumlah'];
              document.getElementById("minimal").value = response[0]['minimal'];
               $('#editmodal').modal('show');
           }
         });
    }

    function Deleted(name,value)
    {
      Swal.fire(
        'Delete '+name+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/deletevoucher/')}}"+"/"+value;
        }
      });
    }

    </script>

@endsection
