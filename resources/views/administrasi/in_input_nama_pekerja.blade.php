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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > Pekerjaan > <a href="https://stokis.app/?s=nama+pekerjaan+produksi" target="_blank">Buat Nama Pekerjaan Baru</a></li>
                          </ol>
                      </nav>
                    </h4>

                    <hr>         
                <div class="row">
                    <div class="col-md-4">
                <form action="{{url('tambah_nama_pekerjaan')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <label class="section-title">Input Nama Pekerjaan</label>
                <hr>
                No. ID Pekerjaan:
                <input type="text" name="no_id_pekerjaan"  class="form-control" id="no_id_pekerjaan" value="P{{$number}}" readonly>
                <br>
                Nama Divisi:
                <select class="form-control" name="id_divisi">
                    <?php $no=1; foreach($divisi as $key => $value){ ?>
                        <option value="{{$value->id_divisi}}">{{$value->nama_divisi}}</option>
                    <?php } ?>
                </select>
                <br>
                Nama Pekerjaan:
                <input type="text" name="nama_pekerjaan"  class="form-control" id="nama_pekerjaan" placeholder="isi nama pekerjaan">
                <br>
                Nama Satuan:
                <input type="text" name="satuan"  class="form-control" id="satuan" placeholder="isi satuan hasil dari Target Pekerjaan, ex: Pcs, Kotak, Sesi, ...">
                <br>
                Target Per Jam:
                <input type="number" name="target"  class="form-control" id="target" min="0" value="0" step="0.1">
                <br>
                <center><button class="btn btn-primary btn-lg"  id="save-btn">&emsp;Tambah&emsp;</button></center>
                </form>   
                </div>
                </div>      
             </div>
            </div>
          </div>
        </div>
      </div>
    </div>           
            
@endsection