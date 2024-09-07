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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pemasaran > Promo Diskon > <a href="https://stokis.app/?s=data+promo+diskon" target="_blank">Data Promo (Flash Sale)</a></li>
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
                              <th>Kategori Promo</th>
                              <th>Potongan Harga</th>
                              <th>Nama Barang</th>
                              <th>Mulai</th>
                              <th>Berakhir</th>
                              <th>Status</th>
                              <?php if (Auth::user()->level == "1"): ?>
                                <th>Tindakan</th>
                              <?php endif; ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; foreach ($promo as $datapromo) { ?>
                          <tr
                          <?php if ($datapromo->status == ""){
                             echo "style='background:#b7ffc6'";
                           }else{
                             echo "style='background:#dedede'";
                           } ?>
                          >
                              <td>{{$no}}</td>
                              <td>{{$datapromo->nama_promo}}</td>
                              <td align="right">{{ribuan($datapromo->persentase)}}</td>
                              <td>{{$nm_barang[$datapromo->id_barang]}}</td>
                              <td>{{$datapromo->start}}</td>
                              <td>{{$datapromo->end}}</td>
                              <td><?php if ($datapromo->status == ""){ ?>
                                Aktif
                              <?php }else{ echo $datapromo->status; } ?></td>
                              <?php if (Auth::user()->level == "1"): ?>
                              <td>
                                <button class="btn btn-default" onclick="edit('{{$datapromo->id}}')"><i class="icon-pencil"></i></button>
                                <button class="btn btn-default" onclick="Deleted('{{$datapromo->nama_promo}}','{{$datapromo->id}}')"><i class="icon-trash"></i></button>
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
          <form action="{{url('simpanpromo')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
          <br>
          <div class="row">
            <label class="col-lg-3">Kategori Promo</label>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" id="nama_promo" maxlength="30" required name="nama_promo" class="form-control">
                    </div>
                </div>
            </div>
          </div>
          <br>
          <input type="hidden" name="id" id="id" value="">
          <div class="row">
            <label class="col-lg-3">Barang</label>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <input id="nama_barang" type="text" class="form-control" placeholder="Pilih Barang" readonly style="background:#fff">
                        <input id="id_barang" name="id_barang" type="hidden" class="form-control">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" onclick="caribarang()" type="button"><i class="fas fa-folder-open"></i></button>
                        </div>
                      </div>
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
                        <input type="number" required id="persentase" name="persentase" class="form-control" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
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
                        <input type="date" id="start" required name="start" class="form-control" placeholder="Ketik nama Promo">
                    </div>
                </div>
            </div>
          </div>
          <br>
          <div class="row">
            <label class="col-lg-3">Promo Selesai</label>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-12">
                        <input type="date" id="end" required name="end" class="form-control">
                    </div>
                </div>
            </div>
          </div>
          
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

  <div class="modal fade" id="barang" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">

            <div class="table-responsive">
            <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                <thead>
                    <tr>
                        <th>No SKU</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach ($barang as $value){ ?>
                    <tr onclick="pilihbarang('{{$value->id}}','{{$value->nama_barang}}')">
                        <td>{{$value->no_sku}}</td>
                        <td>{{$value->nama_barang}}</td>
                    </tr>
                   <?php } ?>
                </tbody>
            </table>
          </div>

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
           url: 'getdetailpromo/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
              document.getElementById("nama_promo").value = response[0]['nama_promo'];
              document.getElementById("persentase").value = response[0]['persentase'];
              document.getElementById("start").value = response[0]['start'];
              document.getElementById("end").value = response[0]['end'];
              document.getElementById("id").value = response[0]['id'];
              document.getElementById("nama_barang").value = response[0]['nama_barang'];
              document.getElementById("id_barang").value = response[0]['id_barang'];
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
          location.href="{{url('/deletepromo/')}}"+"/"+value;
        }
      });
    }

    function caribarang(){
      $('#barang').modal('show');
    }
    function pilihbarang(id,nama){
      $('#barang').modal('hide');
      document.getElementById("id_barang").value = id;
      document.getElementById("nama_barang").value = nama;
    }
    </script>

@endsection
