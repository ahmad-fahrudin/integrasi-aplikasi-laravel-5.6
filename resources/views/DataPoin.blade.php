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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pemasaran > Poin Hadiah > <a href="https://stokis.app/?s=data+riwayat+poin" target="_blank">Riwayat Poin</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                    <div class="col-md-4">
                      <form action="{{url('prosespoin')}}" method="post">
                        <p><strong>Catatan Transaksi</strong></p>
                        {{csrf_field()}}
                        Nama Karyawan:
                        <div class="row">
                          <div class="col-lg-12">
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="input-group">
                                      <input id="nama_investor" name="nama_konsumen" required type="text" readonly class="form-control" placeholder="Pilih Member" style="background-color:#fff">
                                      <input id="id" name="id_konsumen" type="hidden" required class="form-control">
                                      <div class="input-group-append">
                                          <button class="btn btn-outline-secondary" onclick="caribarang()" type="button"><i class="fas fa-folder-open"></i></button>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        Poin saat ini:
                        <div class="row">
                          <div class="col-lg-12">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="saldo" name="old_saldo" required type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        Jenis Transaksi:
                        <select required name="jenis" id="jenis" class="form-control">
                          <option value="out">Keluar</option>
                          <option value="in">Masuk</option>
                        </select>
                        <br>
                        Nominal:
                        <input required type="text" name="jumlah" class="form-control" data-a-sign="" id="nominal" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                        <br>
                        Catatan :
                        <input type="text" name="nama_jenis" class="form-control" placeholder="opsional">
                        <br>
                        Tanggal Transaksi:
                        <input required type="date" name="tgl_transaksi" value="{{date('Y-m-d')}}" class="form-control">
                        <br>
                        </div>
                        <br><br>
                         <div class="form-group">
                         <div class="col-4">
                        <input type="submit" value="Simpan" class="btn btn-primary form-control">
                        </div>
                        </div>
                      </form>
                      <br><br>
                    </div>
                    <?php endif; ?>
									<div class="table-responsive">
                  <table id="insentif_table" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>Tanggal</th>
                              <th>Keterangan Transaksi</th>
                              <th>Poin Masuk</th>
                              <th>Poin Keluar</th>
                              <th>Jumlah Poin</th>
                              <th>Admin</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; $jumlah = 0; foreach ($poin as $key => $value):?>
                          <tr>
                            <td>
                              <?php if ($value->tgl_verifikasi != ""){ ?>
                              {{tanggal($value->tgl_verifikasi)}}
                              <?php }else{ ?>
                              {{tanggal($value->tgl_transaksi)}}
                            <?php } ?></td>
                            <td>
                              {{$value->nama_jenis}} {{$value->no_trip}} ({{$value->nama_konsumen}})
                            </td>
                            <td align="right">
                              <?php if ($value->jenis == "in"): $jumlah += $value->jumlah;?>
                                {{ribuan($value->jumlah)}}
                              <?php endif; ?>
                            </td>
                            <td align="right">
                              <?php if ($value->jenis == "out"): $jumlah -= $value->jumlah;?>
                                {{ribuan($value->jumlah)}}
                              <?php endif; ?>
                            </td>
                            <td align="right">{{ribuan($jumlah)}}</td>
                            <td>
                              <?php if (isset($value->admin)): ?>
                                {{$admin[$value->admin]}}
                              <?php endif; ?>
                            </td>
                          </tr>
                        <?php $no++; endforeach; ?>
                      </tbody>
                  </table>
								</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="barang" role="dialog">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
              <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Nama Investor</th>
                          <th>Alamat</th>
                          <th>No HP</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($konsumen as $value){ ?>
                      <tr onclick="pilihbarang('{{$value->id}}','{{$value->nama_pemilik}}','{{$value->nik}}','{{$value->alamat}}','{{$value->no_hp}}','{{$value->poin}}')">
                          <td>{{$value->id_konsumen}}</td>
                          <td>{{$value->nama_pemilik}}</td>
                          <td><?=$value->alamat?></td>
                          <td>{{$value->no_hp}}</td>
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

      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-body">
              <br>
              <form action="{{url('/verifikasipenarikan')}}" method="post">
              {{csrf_field()}}
              Nama Karyawan<br><input type="text" id="nama" readonly class="form-control">
              Jumlah Penarikan<br><input type="text" id="jumlah" readonly class="form-control">
              <input type="hidden" name="id" id="ids">
              Administrasi Bank<br><input type="text" name="jumlah" id="in_jumlah" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep="." class="form-control"><br>
              <input type="submit" value="Verifikasi" class="form-control btn-success">
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
    new AutoNumeric('#nominal', "euroPos");
    new AutoNumeric('#in_jumlah', "euroPos");
    function caribarang(){
      $('#barang').modal('show');
    }
    function pilihbarang(id,nama,nik,alamat,hp,saldo){
      $('#barang').modal('hide');
      document.getElementById("id").value = id;
      document.getElementById("nama_investor").value = nama;
      document.getElementById("saldo").value = numberWithCommas(saldo);

      $.ajax({
         url: 'uppoin/'+id,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
         }
       });

    }
    function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    </script>
    <script>
        $("#insentif_table").DataTable(
          {
              "ordering": false,
              dom: 'Bfrtip',
              buttons: [
                {
                    extend: 'print',
                    columns: [ 0, 1, 2, 3 , 4 ,5],
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '10pt' );
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }
                },
                {

                    extend: 'excel',
                    title: namadon,
                    exportOptions: {
                           columns: [ 0, 1, 2, 3 , 4 ,5],
                           format: {
                                    body: function(data, row, column, node) {
                                      if(column===2){
                                        return data.split(".").join("");
                                      }
                                      if(column===1){
                                        var temp = data.split("                                  ").join("");
                                        temp = temp.split("<br>").join("-");
                                        temp = temp.split('<button class="btn btn-default" onclick="Load(').join("");
                                        temp = temp.split(')">').join("");
                                        temp = temp.split('</button>').join("");
                                        var res = temp.split("'");
                                        if (res.length > 1) {
                                          temp = res[0]+res[2];
                                        }
                                        return temp;
                                      }
                                      if(column===3){
                                        return data.split(".").join("");
                                      }
                                      if(column===4){
                                        return data.split(".").join("");
                                      }
                                      if(column===12){
                                        return data.split(".").join("");
                                      }
                                      if(column===13){
                                        return data.split(".").join("");
                                      }
                                      if(column===14){
                                        return data.split(".").join("");
                                      }
                                      if(column===15){
                                        return data.split(".").join("");
                                      }else{
                                        return data
                                      }
                                    }
                      }
                   }

                },
                {
                  extend: 'pdfHtml5',
                  orientation: 'landscape',
                  pageSize: 'A4',
                  title: namadon,
                    customize: function ( win ) {
                      win.defaultStyle.fontSize = 10
                    },
                    exportOptions: {
                      columns: [ 0, 1, 2, 3 , 4 ,5]
                    }
                }
              ]
          }
        ).page('last').draw('page');
    </script>
@endsection
