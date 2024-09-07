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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > Upah Produksi > <a href="https://stokis.app/?s=upah+produksi+per+kategori+kerja" target="_blank">Data Upah Per Kategori Kerja</a></li>
                          </ol>
                      </nav>
                    </h4>

                    <hr>
                    <br>
                    
					<div class="table-responsive">
                <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Kategori Kerja</th>
                            <th>Shift 1 /Jam</th>
                            <th>Shift 2 /Jam</th>
                            <th>Lembur /Jam</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($data as $key => $value){ ?>
                            <tr>
                                <td>{{$value->status_pekerja}}</td>
                                <td class="text-right">{{ribuan($value->shift1)}}</td>
                                <td class="text-right">{{ribuan($value->shift2)}}</td>
                                <td class="text-right">{{ribuan($value->lembur)}}</td>
                                <td>
                                    <button class="btn btn-default" onclick="Edit('{{$value->id}}','{{$value->status_pekerja}}','{{$value->shift1}}','{{$value->shift2}}','{{$value->lembur}}')"><i class="icon-pencil"></i></button>
                                    <button hidden class="btn btn-default" onclick="Hapus('{{$value->id}}','{{$value->status_pekerja}}')"><i class="icon-trash"></i></button>
                                </td>
                            </tr>
                        <?php $no++; } ?>
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
                    <h4>Edit Upah Kerja</h4>
                <form action="{{url('simpan_upah_kategori_kerja')}}" method="post"  enctype="multipart/form-data">
                    {{csrf_field()}}
                <select hidden class="form-control" name="status_pekerja" id="status_pekerja" readonly>
                    <option value="harian">Harian</option>
                    <option value="borongan">Borongan</option>
                    <option value="peralihan hb-bh">Perubahan 1</option>
                    <option value="peralihan 1">Peralihan 1</option>
                    <option value="peralihan 2">Peralihan 2</option>
                </select>
                <input type="hidden" name="id" id="id">
                <br>
                Shift 1 /Jam:
                <input type="number" name="shift1"  class="form-control" id="shift1">
                Shift 2 /Jam:
                <input type="number" name="shift2"  class="form-control" id="shift2">
                Lembur /Jam:
                <input type="number" name="lembur"  class="form-control" id="lembur">
                <br>
                <button class="btn btn-success">Update</button>
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
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = "{{url('delete_upah_kategori_kerja')}}/" + id;
        }
    })
}

function Edit(id,status_pekerja, shift1, shift2, lembur) {
    document.getElementById("id").value = id;
    document.getElementById("status_pekerja").value = status_pekerja;
    document.getElementById("shift1").value = shift1;
    document.getElementById("shift2").value = shift2;
    document.getElementById("lembur").value = lembur;
    $('#editmodal').modal('show');
}
</script>
@endsection