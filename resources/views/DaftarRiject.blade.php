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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Validasi Stok Kembali > <a href="https://stokis.app/?s=validasi+stok+kembali+dari+rijek+stok" target="_blank">Stok Rijek</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>

									<div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. Reject</th>
                              <th>Nama Suplayer</th>
                              <th>Alamat</th>
                              <th>No. Telepon</th>
                              <th>Tanggal Input</th>
                              <th>QC</th>
                              <th>Driver</th>
                              <th>Admin Input</th>
                              <th>Cabang</th>
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>Jumlah Riject</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($reject as $value) { ?>
                          <tr>
                              <td>{{$value->no_reject}}</td>
                              <td>{{$value->nama_pemilik}}</td>
                              <td><?=$value->alamat?></td>
                              <td>{{$value->no_hp}}</td>
                              <td>{{tanggal($value->tanggal_input)}}</td>
                              <td>{{$karyawan[$value->qc]}}</td>
                              <td>{{$karyawan[$value->driver]}}</td>
                              <td>{{$admin[$value->admin_g]}}</td>
                              <td>{{$value->nama_gudang}}</td>
                              <td>{{$value->no_sku}}</td>
                              <td>{{$value->nama_barang}}</td>
                              <td>{{$value->jumlah}}</td>
                              <td><button class="btn btn-success" onclick="Validasi('{{$value->id_val}}','{{$value->no_reject}}','{{$value->nama_barang}}')">Validasi</button>
                                  <button class="btn btn-danger" onclick="Batal('{{$value->id_val}}','{{$value->no_reject}}','{{$value->nama_barang}}')">Batalkan</button></td>
                          </tr>
                         <?php } ?>
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
        function Validasi(id,no_reject,barang){
          Swal.fire(
            'Validasi '+no_reject+'?',
            'dengan barang '+barang,
            'question'
          ).then((result) => {
            if (result.value) {
              location.href = 'validasiriject/'+id;
            }
          });
        }

        function Batal(id,no_reject,barang){
          Swal.fire(
            'Validasi '+no_reject+'?',
            'dengan barang '+barang,
            'question'
          ).then((result) => {
            if (result.value) {
              location.href = 'batalriject/'+id;
            }
          });
        }
    </script>
@endsection
