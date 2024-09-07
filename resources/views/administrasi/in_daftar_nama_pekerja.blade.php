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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > Pekerjaan > <a href="https://stokis.app/?s=nama+pekerjaan+produksi" target="_blank">Data Nama Pekerjaan & Target</a></li>
                          </ol>
                      </nav>
                    </h4>

                    <hr>
                    <br>
                    <label><strong><h3>Data Pekerjaan & Target</h3></strong></label>
					<div class="table-responsive">
                <table id="examples6" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No. ID Pekerjaan</th>
                            <th>Nama Pekerjaan</th>
                            <th>Satuan</th>
                            <th>Divisi</th>
                            <th>Target Per Jam</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                     <tbody>
                        <?php $no=1; foreach($pekerjaan as $key => $value){ ?>
                            <tr>
                                <td>{{$value->no_id_pekerjaan}}</td>
                                <td>{{$value->nama_pekerjaan}}</td>
                                <td>{{$value->satuan}}</td>
                                <td>{{$value->nama_divisi}}</td>
                                <td>{{$value->target}}</td>
                                <td>
                                    <button class="btn btn-default" onclick="Edit('{{$value->no_id_pekerjaan}}','{{$value->nama_pekerjaan}}','{{$value->satuan}}','{{$value->id_divisi}}','{{$value->target}}')"><i class="icon-pencil"></i></button>
                                    <button class="btn btn-default" onclick="Hapus('{{$value->no_id_pekerjaan}}','{{$value->nama_pekerjaan}}')"><i class="icon-trash"></i></button>
                                </td>
                            </tr>
                        <?php $no++; } ?>
                    </tbody>   
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

                    <h4>Edit Nama Pekerjaan</h4>

                <hr>
                <form action="{{url('simpan_pekerjaan')}}" method="post"  enctype="multipart/form-data">
                    {{csrf_field()}}
                    No. ID Pekerjaan
                    <input type="text" name="no_id_pekerjaan" id="no_id_pekerjaan" class="form-control" readonly>
                    Nama Pekerjaan
                    <input type="text" maxlength="40" name="nama_pekerjaan" id="nama_pekerjaan" class="form-control">
                    Satuan
                    <input type="text" maxlength="10" name="satuan" id="satuan" class="form-control">
                    Divisi Pekerjaan
                    <select class="form-control" name="id_divisi" id="id_divisi">
                        <?php $no=1; foreach($divisi as $key => $value){ ?>
                            <option value="{{$value->id_divisi}}">{{$value->nama_divisi}}</option>
                        <?php } ?>
                    </select>
                    Target Per Jam
                    <input type="number" maxlength="10" name="target" id="target" class="form-control">
                    <br>
                    <center><button class="btn btn-success">Update</button></center>
                </form>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
    </div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>


function Hapus(id, nama) {
    Swal.fire({
        title: "Delete " + nama,
        text: 'Tindakan ini tidak bisa dibatalkan ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus !'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = "{{url('delete_pekerjaan')}}/" + id;
        }
    })
}

function Edit(no_id_pekerjaan, nama_pekerjaan, satuan, id_divisi, target) {
    document.getElementById("no_id_pekerjaan").value = no_id_pekerjaan;
    document.getElementById("nama_pekerjaan").value = nama_pekerjaan;
    document.getElementById("satuan").value = satuan;
    document.getElementById("id_divisi").value = id_divisi;
    document.getElementById("target").value = target;
    $('#editmodal').modal('show');
}
</script>
@endsection