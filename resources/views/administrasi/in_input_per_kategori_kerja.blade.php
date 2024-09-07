@extends('template/nav')
@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Input Upah Per Kategori Kerja</li>
            </ol>
        </div>
        <div class="section-wrapper">
            <form action="{{url('tambah_upah_kategori_kerja')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <label class="section-title">Input Upah Per Kategori Kerja</label>
                <hr>
                Status Kerja:
                <select class="form-control" name="status_pekerja" id="status_pekerja">
                    <option value="harian">Harian</option>
                    <option value="borongan">Borongan</option>
                    <option value="peralihan hb-bh">Perubahan HB-BH</option>
                    <option value="peralihan 1">Peralihan 1</option>
                    <option value="peralihan 2">Peralihan 2</option>
                </select>
                <br>
                Shift 1 / Jam:
                <input type="text" name="shift1"  class="form-control" id="shift1">
                Shift 2 / Jam:
                <input type="text" name="shift2"  class="form-control" id="shift2">
                Lembur / Jam:
                <input type="text" name="lembur"  class="form-control" id="lembur"><br>
                <button class="btn btn-teal btn-sm"  id="save-btn">&emsp;SIMPAN DATA&emsp;</button>
            </form>
        </div>
        </div>
    </div>
</div>

<script>
function CariKaryawan() {
    $('#capmi').modal('show');
}

function Pilih(no_id_pekerjaan, nama_divisi, nama_pekerjaan,satuan, id_divisi) {
    document.getElementById("no_id_pekerjaan").value = no_id_pekerjaan;
    document.getElementById("nama_pekerjaan").value = nama_pekerjaan;
    document.getElementById("nama_divisi").value = nama_divisi;
    document.getElementById("satuan").value = satuan;
    $('#capmi').modal('hide');
}
</script>
@endsection