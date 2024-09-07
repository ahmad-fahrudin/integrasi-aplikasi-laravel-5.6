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
                          <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Orderan Web Store > <a href="https://stokis.app/?s=cara+input+resi+pengiriman+web+store" target="_blank">Input Resi Pengiriman</a></li>
                      </ol>
                  </nav>
                </h4>
                <hr>
              <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>No. Kwitansi</th>
                          <th>Tanggal Order</th>
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>Kota/Kabupaten</th>
                          <th>Gudang</th>
                          <th>Metode Pembayaran</th>
                          <th>Kurir</th>
                          <th>Status Pembayaran</th>
                          <th>Keterangan</th>
                          <th>Tindakan</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($order as $value) {
                      if($value->cod > 0){ $metpe="COD"; }else{ $metpe ="Online Payment"; }
                      if($value->transaction_status == "settlement"){ $value->transaction_status="Lunas"; }
                      ?>
                      <tr <?php if ($value->status_barang == "kirim ulang"): ?>
                        style="background:#ffc8c8;"
                      <?php endif; ?>>
                          <td>{{$value->no_kwitansi}}</td>
                          <td>{{date("d-m-Y", strtotime($value->tanggal_order))}}</td>
                          <td>{{$value->nama_pemilik}}</td>
                          <td><?php echo $value->alamat; ?></td>
                          <td>
                            <?php if (is_numeric($value->kota)) {
                              echo $data_kabupaten[$value->kota];
                            }else{
                              echo $value->kota;
                            }?>
                          </td>
                          <td>{{$value->nama_gudang}}</td>
                          <td>{{$metpe}}</td>
                          <td>{{$value->kurir}} ({{$value->service}})</td>
                          <td>{{$value->transaction_status}}</td>
                          <td>{{$value->keterangan}}</td>
                          <td><button onclick="InputKwitansi('{{$value->no_kwitansi}}')" class="btn btn-primary">Input Resi</button></td>
                      </tr>
                     <?php } ?>
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

<div class="modal fade" id="resi" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="{{url('simpan_kurir')}}" method="post">
          {{csrf_field()}}
          <center><h2>Input Resi</h2></center><br>
          No Kwitansi:
          <input type="text" name="no_kwitansi" id="no_kwitansi" class="form-control" readonly><br>
          No Resi:
          <input type="text" name="no_resi" id="no_resi" class="form-control">
          <br>
          <center><button class="btn btn-primary">Simpan Resi</button></center>
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
    function InputKwitansi(id){
      document.getElementById("no_kwitansi").value = id;
      $('#resi').modal('show');
    }
  </script>
@endsection
