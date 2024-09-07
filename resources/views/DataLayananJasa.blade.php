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
                              <li class="breadcrumb-item text-muted" aria-current="page">Layanan Jasa > <a href="https://stokis.app/?s=daftar+layanan+jasa" target="_blank">Daftar Layanan Jasa</a></li>
                          </ol>
                      </nav>
                    </h4>
				<div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>Kode</th>
                              <th>Layanan Jasa</th>
                              <th class="text-right">Biaya Jasa</th>
                              <th>Group</th>
                              <th>Waktu</th>
                              <th hidden class="text-right">Poin</th>
                              <?php if (Auth::user()->level == "1"): ?>
                              <th>Tindakan</th>
                              <?php endif; ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($jasa as $key => $value):?>
                          <tr>
                            <td>{{$value->kode}}</td>
                            <td>{{$value->nama_jasa}}</td>
                            
                            <td class="text-right">{{ribuan($value->biaya)}}</td>
                            <td>{{$value->kategori_jasa}}</td>
                            <td>{{$value->waktu}}</td>
                            <td hidden class="text-right">{{$value->poin}}</td>
                            <?php if (Auth::user()->level == "1"): ?>
                            <td>
                              <button class="btn btn-secondary btn-sm" onclick="Edit('{{$value->kode}}','{{$value->nama_jasa}}','{{$value->biaya}}','{{$value->kategori_jasa}}','{{$value->waktu}}','{{$value->poin}}')">Edit</button>
                              <button class="btn btn-danger btn-sm" onclick="Delete('{{$value->kode}}','{{$value->nama_jasa}}')">Delete</button>
                            </td>
                            <?php endif; ?>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                  </table>
								</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="edit" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            <br>
            <form action="{{url('/updatejasa')}}" method="post">
            {{csrf_field()}}
            Kode<br>
            <input type="text" id="kode" readonly name="kode" class="form-control"><br>

            Nama Jasa<br>
            <input type="text" id="nama_jasa" name="nama_jasa" class="form-control"><br>
            

            Biaya Jasa<br>
            <input type="text" name="biaya" id="biaya" class="form-control"><br>
            
            Group<br>
            <input type="text" name="kategori_jasa" id="kategori_jasa" class="form-control"><br>
            
            Waktu<br>
            <input type="text" name="waktu" id="waktu" class="form-control"><br>
            
            
            Poin<br>
            <input type="text" name="poin" id="poin" class="form-control"><br>
            <input type="submit" value="Simpan" class="form-control btn-success">
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
    function Edit(kode,jasa,biaya,kategori_jasa,waktu,poin){
      document.getElementById("kode").value = kode;
      document.getElementById("nama_jasa").value = jasa;
      document.getElementById("biaya").value = biaya;
      document.getElementById("kategori_jasa").value = kategori_jasa;
      document.getElementById("waktu").value = waktu;
      document.getElementById("poin").value = poin;
      $('#edit').modal('show');
    }

    function Delete(kode,jasa){
      Swal.fire(
        'Delete '+jasa+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/deletejasa/')}}"+"/"+kode;
        }
      });
    }
    </script>
@endsection
