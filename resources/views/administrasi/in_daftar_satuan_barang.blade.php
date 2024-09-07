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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > Upah Produksi > <a href="https://stokis.app/?s=upah+produksi+per+satuan+barang" target="_blank">Daftar Upah Per Hasil Pekerjaan</a></li>
                          </ol>
                      </nav>
                    </h4>

                    <hr>
                    <br>
            <div class="table-responsive">
                <table id="prc" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No. ID Pekerjaan</th>
                            <th>Nama Pekerjaan</th>
                            <th>Satuan</th>
                            <th>Divisi</th>
                            <th>Kategori Kerja</th>
                            <th>Per Satuan Hasil Pekerjaan</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($data as $key => $value){ ?>
                            <tr>
                                <td>{{$value->no_id_pekerjaan}}</td>
                                <td>{{$value->nama_pekerjaan}}</td>
                                <td>{{$value->satuan}}</td>
                                <td>
                                    <?php if(isset($divisi[$value->id_divisi])){ $div = $divisi[$value->id_divisi]->nama_divisi; ?>{{$div}} <?php }else{ $div = ''; } ?></td>
                                <td>{{$value->status_pekerja}}</td>
                                <td class="text-right">{{ribuan($value->harga_satuan)}}</td>
                                <td>
                                    <button class="btn btn-deafult" onclick="Edit('{{$value->id}}','{{$value->status_pekerja}}','{{$value->no_id_pekerjaan}}','{{$value->nama_pekerjaan}}','{{$div}}','{{$value->satuan}}','{{$value->harga_satuan}}')"><i class="icon-pencil"></i></button>
                                    <button class="btn btn-default" onclick="Hapus('{{$value->id}}','{{$value->nama_pekerjaan}}')"><i class="icon-trash"></i></button>
                                </td>
                            </tr>
                        <?php $no++; } ?>
                    </tbody>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


<div class="modal fade" id="edit" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
                
                    <h4>Edit Upah Satuan Per Barang</h4>
                
                <form action="{{url('simpan_satuan_barang')}}" method="post"  enctype="multipart/form-data">
                    {{csrf_field()}}
                <select class="form-control" name="status_pekerja" id="status_pekerja" readonly>
                    <option hidden value="tetap">Tetap</option>
                    <option hidden value="harian">Harian</option>
                    <option hidden value="peralihan 1">Peralihan 1</option>
                    <option hidden value="peralihan 2">Peralihan 2</option>
                    <option selected value="borongan">Borongan</option>
                </select>
                <input type="hidden" name="id" id="id">
                <br>
                No. ID Kerja:
                <input type="text" id="no_id_pekerjaan" name="no_id_pekerjaan" class="form-control" placeholder="Pilih Karyawan" required readonly>
                <br>
                Nama Pekerjaan:
                <input type="text" name="nama_pekerjaan"  class="form-control" id="nama_pekerjaan" readonly>
                <br>
                Divisi:
                <input type="text" name="nama_divisi"  class="form-control" id="nama_divisi" readonly>
                <br>
                Satuan:
                <input type="text" name="satuan"  class="form-control" id="satuan" readonly>
                <br>
                Harga Satuan Barang:
                <input type="number" name="harga_satuan"  class="form-control" id="harga_satuan"><br>
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
            location.href = "{{url('delete_satuan_barang')}}/" + id;
        }
    })
}

function Edit(id,status_pekerja, no_id_pekerjaan, nama_pekerjaan, nama_divisi, satuan,harga_satuan) {
    document.getElementById("id").value = id;
    document.getElementById("status_pekerja").value = status_pekerja;
    document.getElementById("no_id_pekerjaan").value = no_id_pekerjaan;
    document.getElementById("nama_pekerjaan").value = nama_pekerjaan;
    document.getElementById("nama_divisi").value = nama_divisi;
    document.getElementById("satuan").value = satuan;
    document.getElementById("harga_satuan").value = harga_satuan;
    $('#edit').modal('show');
}
</script>
@endsection