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
                          <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > <a href="https://stokis.app/?s=konfirmasi+pembayaran+bank+toko+online" target="_blank">Konfirmasi Pembayaran Transfer (Web Store)</a></li>
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
                          <th>Jumlah Pembayaran</th>
                          <th>Kurir</th>
                          <th>Status Pembayaran</th>
                          <th>Bukti Transfer</th>
                          <th>Tindakan</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($pembayaran as $value) { //dd($value);
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
                          <td>{{ribuan($value->gross_amount)}}</td>
                          <td>{{$value->kurir}} ({{$value->service}})</td>
                          <td>{{$value->transaction_status}}</td>
                          <td><img src="{{$value->bukti}}" width="100px" onclick="LihatGambar('{{$value->bukti}}')"></td>
                          <td><button onclick="Approve('{{$value->no_kwitansi}}')" class="btn btn-primary">Approve</button></td>
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


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <img src="" id="gambar_bukti" width="100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script>

  function LihatGambar(src){
    document.getElementById("gambar_bukti").src = src;
    $('#myModal').modal('show');
  }

  function Approve(id){
    Swal.fire(
      'Approve '+id+'?',
      'Apakah Anda Yakin?',
      'question'
    ).then((result) => {
      if (result.value) {
        location.href="{{url('/approvepembayaranmanual/')}}"+"/"+id;
      }
    });
  }

  </script>
@endsection
