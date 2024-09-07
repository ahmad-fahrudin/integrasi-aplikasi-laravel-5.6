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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Validasi Stok Kembali > <a href="https://stokis.app/?s=validasi+stok+kembali+dari+retur" target="_blank">Penjualan Retur</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
									<div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. Kwitansi</th>
                              <th>Nama Konsumen</th>
                              <th>Alamat</th>
                              <th>Tanggal Terkirim</th>
                              <th>Cabang</th>
                              <th>Nama Barang</th>
                              <th>Proses</th>
                              <th>Terkirim</th>
                              <th>Kembali</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($retur as $value) { ?>
                          <tr>
                              <td>{{$value->no_kwitansi}}</td>
                              <td>
                                  <?php
                                  if(isset($konsumen[$detail[$value->no_kwitansi]['id_konsumen']]['nama'])){
                                      echo $konsumen[$detail[$value->no_kwitansi]['id_konsumen']]['nama'];
                                  }else{
                                      echo $konsumen[$detail[$value->no_kwitansi]['id_konsumen']]['nama'];
                                  }
                                  ?></td>
                              <td>
                                  <?php
                                  if(isset($konsumen[$detail[$value->no_kwitansi]['id_konsumen']]['alamat'])){
                                      echo $konsumen[$detail[$value->no_kwitansi]['id_konsumen']]['alamat'];
                                  }else{
                                      echo $konsumen[$detail[$value->no_kwitansi]['id_konsumen']]['alamat'];
                                  }
                                  ?></td>
                              <td>{{tanggal($detail[$value->no_kwitansi]['tanggal_terkirim'])}}</td>
                              <td>{{$gudang[$detail[$value->no_kwitansi]['id_gudang']]}}</td>
                              <td>{{$barang[$value->id_barang]['nama_barang']}}</td>
                              <td>{{$value->proses}}</td>
                              <td>{{$value->terkirim}}</td>
                              <td>{{$value->temp_kembali}}</td>
                              <td>
                                <button onclick="Verifikasi('{{$value->no_kwitansi}}','{{$value->id}}','{{$value->id_barang}}','{{$detail[$value->no_kwitansi]['id_gudang']}}','{{$value->temp_kembali}}','{{$konsumen[$detail[$value->no_kwitansi]['id_konsumen']]['nama']}}','{{$barang[$value->id_barang]['nama_barang']}}')" class="btn btn-success">Verifikasi</button>
                                <button onclick="Cancel('{{$value->no_kwitansi}}','{{$value->id}}','{{$value->id_barang}}','{{$detail[$value->no_kwitansi]['id_gudang']}}','{{$value->temp_kembali}}','{{$konsumen[$detail[$value->no_kwitansi]['id_konsumen']]['nama']}}','{{$barang[$value->id_barang]['nama_barang']}}')" class="btn btn-danger">Reject</button>
                              </td>
                          </tr>
                        <?php  }?>
                      </tbody>
                  </table>
								</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    function Verifikasi(kwitansi,id_detail_barang_keluar,id_barang,id_gudang,retur,konsumen,barang){
      Swal.fire(
        'Verifikasi barang: \n'+barang+'\n dengan konsumen: \n'+konsumen+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {

          var tempids = id_detail_barang_keluar+",";
          var tempid_barangs = id_barang+",";
          var id_gudangs = id_gudang+",";
          var returs = retur+",";

          $.post("postreturnbarang",
            {no_kwitansi:kwitansi, id_detail_barang_keluar:tempids ,id_barang : tempid_barangs,id_gudang : id_gudangs,return:returs,
              _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
                {

                  Swal.fire({
                      title: 'Berhasil',
                      icon: 'success',
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Lanjutkan!'
                    }).then((result) => {
                      if (result.value) {
                        location.reload();
                      }
                    });

                }).fail(function(jqXHR, textStatus, errorThrown)
            {
                alert(textStatus);
            });

        }
      });
    }
    function Cancel(kwitansi,id_detail_barang_keluar,id_barang,id_gudang,retur,konsumen,barang){
      Swal.fire(
        'Reject barang: \n'+barang+'\n dengan konsumen: \n'+konsumen+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/cancelretur/')}}"+"/"+id_detail_barang_keluar;
        }
      });
    }
    </script>

@endsection
