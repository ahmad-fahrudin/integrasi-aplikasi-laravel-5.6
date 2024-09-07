@extends('template/nav')
@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Kinerja Karyawan</li>
            </ol>
        </div>
        <div class="section-wrapper">
            <label class="section-title">EDIT KINERJA KARYAWAN</label>
            <div class="row">
                <div class="col-md-6">
                    No Job:
                    <input type="text" name="no_job"  class="form-control" id="no_job" value="{{$data[0]->no_job}}" readonly>
                    Tanggal:
                    <input type="date" name="tanggal"  class="form-control" id="tanggal" value="{{$data[0]->tanggal}}" readonly>
                    <br>
                    <b>Pilih Karyawan:</b><br>
                    No ID Karyawan
                    <div class="table-wrapper">
                        <div class="input-group">
                            <input type="text" id="id_karyawan" name="id_karyawan" value="{{$data[0]->id_karyawan}}" readonly
                            class="form-control" placeholder="Pilih"readonly>
                        </div>
                    </div> 
                    Nama Karyawan:
                    <input type="text" name="nama_karyawan"  class="form-control" id="nama_karyawan" value="{{$karyawan[0]->nama_karyawan}}" readonly>
                    Alamat:
                    <input type="text" name="alamat"  class="form-control" id="alamat" value="{{$karyawan[0]->alamat_karyawan}}" readonly>   
                </div>
                <div class="col-md-6">
                    Divisi:
                    <input type="text" name="divisi"  class="form-control" value="{{$divisi->nama_divisi}}" readonly>
                    <input type="hidden" name="divisi"  class="form-control" id="divisi" value="{{$data[0]->divisi}}" readonly>
                    Supervisor:
                    <input type="text" name="supervisor"  class="form-control" value="{{$supervisor->name}}" readonly>
                    <input type="hidden" name="supervisor"  class="form-control" id="supervisor" value="{{$data[0]->supervisor}}" readonly>
                    <br>
                    Nama Pekerjaan:
                    <select name="nama_pekerjaan"  class="form-control" id="nama_pekerjaan">
                    <?php foreach ($pekerjaan as $key => $value) { ?>
                        <option value="{{$value->no_id_pekerjaan}} - {{$value->nama_pekerjaan}}">{{$value->nama_pekerjaan}}</option>
                    <?php } ?>
                    </select>
                    Kategori Kerja:
                    <select name="kategori_kerja"  class="form-control" id="kategori_kerja">
                        <?php foreach ($kategori as $key => $value) { ?>
                            <option>{{$value->shift_kerja}}</option>
                        <?php } ?>
                        <option>lembur</option>
                    </select>
                    Jumlah:
                    <input type="number" name="jumlah"  class="form-control" id="jumlah">
                    Jam Kerja:
                    <input type="number" name="jam_kerja"  class="form-control" id="jam_kerja">
                    <br>
                    <button class="btn btn-teal btn-sm" onclick="Tambah()">&emsp;TAMBAH DATA&emsp;</button>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table id="cart" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-white">Nama Pekerjaan</th>
                            <th class="text-white">Kategori Kerja</th>
                            <th class="text-white">Jumlah</th>
                            <th class="text-white">Jam Kerja</th>
                            <th class="text-white">Tindakan</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $nos=1; foreach($data as $key => $value){ ?>
                            <tr id="{{$nos}}">
                                <td><p id="nama_pekerjaan{{$nos}}">{{$value->nama_pekerjaan." - ".$value->nm_pk}}</p></td>
                                <td><p id="kategori_kerja{{$nos}}">{{$value->kategori_kerja}}</p></td>
                                <td><input type="number" id="jumlah{{$nos}}" value="{{$value->jumlah}}"></td>
                                <td><input type="number" id="jam_kerja{{$nos}}" value="{{$value->jam_kerja}}"></td>
                                <td><button class="btn btn-danger btn-sm" onclick="deletecart({{$nos}})">Delete</button></td>
                            </tr>
                        <?php $nos++; } ?>
                    </tbody>
                </table>
            </div>
            <br>
            <center><button class="btn btn-teal btn-sm" id="save" onclick="Simpan()">SIMPAN DATA</button></center>
        </div>
        </div>
    </div>
</div>


<div id="capmi" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body pd-20">
                <table id="datatable2" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th>No ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($karyawan as $key => $value){ ?>
                        <tr>
                            <td>{{$value->id_karyawan}}</td>
                            <td>{{$value->nama_karyawan}}</td>
                            <td>{{$value->alamat_karyawan}}</td>
                            <td>{{$value->no_hp}}</td>
                            <td>
                                <button class="btn btn-primary btn-sm"
                                    onclick="Pilih('{{$value->id_karyawan}}','{{$value->nama_karyawan}}','{{$value->id_divisi}}','{{$value->alamat_karyawan}}')">Pilih Data</button></td>
                        </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function CariKaryawan() {
    $('#capmi').modal('show');
}

function Pilih(id_karyawan, nama_karyawan, id_divisi, alamat_karyawan) {
    document.getElementById("id_karyawan").value = id_karyawan;
    document.getElementById("nama_karyawan").value = nama_karyawan;
    document.getElementById("alamat").value = alamat_karyawan;
    $('#capmi').modal('hide');
}
var jmldata = {{$nos - 1}};
function Tambah(){
    var table = document.getElementById("cart");
    var lastRow = table.rows.length;
    var row = table.insertRow(lastRow);
    row.id = lastRow;
    jmldata = Number(jmldata) + 1;
    var nama_pekerjaan = document.getElementById("nama_pekerjaan").value;
    var kategori_kerja = document.getElementById("kategori_kerja").value;
    var jumlah = document.getElementById("jumlah").value;
    var jam_kerja = document.getElementById("jam_kerja").value;

    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);

    cell1.innerHTML = "<p id=nama_pekerjaan" + jmldata + ">" + nama_pekerjaan + "</p>";
    cell2.innerHTML = "<p id=kategori_kerja" + jmldata + ">" + kategori_kerja + "</p>";
    cell3.innerHTML = "<input type='number' id=jumlah" + jmldata + " value='"+jumlah+"'>";
    cell4.innerHTML = "<input type='number' id=jam_kerja" + jmldata + " value='"+jam_kerja+"'>";
    cell5.innerHTML = '<button class="btn btn-danger btn-sm" onclick="deletecart('+jmldata+')">Delete</button>';
}

function deletecart(lastRow){
    Swal.fire(
    'Delete this?',
    'Apakah Anda Yakin?',
    'question'
    ).then((result) => {
    if (result.value) {
        var row = document.getElementById(lastRow);
        row.parentNode.removeChild(row);
    }
    });
}

function Simpan(){
    var no_job = document.getElementById("no_job").value;
    var tanggal = document.getElementById("tanggal").value;
    var id_karyawan = document.getElementById("id_karyawan").value;
    var divisi = document.getElementById("divisi").value;
    var supervisor = document.getElementById("supervisor").value;
    var nama_pekerjaan = "";
    var kategori_kerja = "";
    var jumlah = "";
    var jam_kerja = "";
    for(var i=1; i <= jmldata; i++){
        var elem = document.getElementById("nama_pekerjaan"+i);
        if (typeof(elem) != 'undefined' && elem != null){
            var a = document.getElementById("nama_pekerjaan"+i).innerHTML;
            nama_pekerjaan += a+"|";
            var b = document.getElementById("kategori_kerja"+i).innerHTML;
            kategori_kerja += b+"|";
            var c = document.getElementById("jumlah"+i).value;
            jumlah += c+"|";
            var d = document.getElementById("jam_kerja"+i).value;
            jam_kerja += d+"|";
        }
    }
    console.log(jmldata);
    $.post("{{url('savekinerjakaryawan')}}",
        {no_job:no_job, tanggal:tanggal, no_id_karyawan:id_karyawan, divisi:divisi,
            supervisor:supervisor, nama_pekerjaan:nama_pekerjaan, kategori_kerja:kategori_kerja, jumlah:jumlah,
            jam_kerja:jam_kerja, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
            {
                Swal.fire({
                    title: 'Berhasil',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Lanjutkan!'
                    }).then((result) => {
                    if (result.value) {
                        document.getElementById("save").disabled = true;
                        location.href="{{url('/data_penilaian_kinerja/')}}";
                    }else{
                        document.getElementById("save").disabled = true;
                        location.href="{{url('/data_penilaian_kinerja/')}}";
                    }
                });
            }).fail(function(jqXHR, textStatus, errorThrown)
        {
            alert(textStatus);
    });

}

</script>
@endsection