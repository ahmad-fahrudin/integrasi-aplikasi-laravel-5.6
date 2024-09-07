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
                                        <li class="breadcrumb-item text-muted" aria-current="page">Where House Manage >
                                            Master >
                                            <a href="#" target="_blank">Product</a>
                                        </li>
                                    </ol>
                                </nav>
                            </h4>
                            <hr>
                            <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                                <p><strong>Filter Berdasarkan</strong></p>
                                <form action="{{ url('datareturn') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <select name="id_gudang" class="form-control">
                                                            <option value="" disabled selected hidden> Search By
                                                            </option>
                                                            <option value="">Option 1</option>
                                                            <option value="">Option 2</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-lg-5">
                                                        <input type="text" id="nama_barang" name="nama_barang"
                                                            onchange="change()" value="" class="form-control"
                                                            placeholder="Search Value">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <button class="btn btn-success btn-md">Filter
                                                            Data</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="table-responsive">
                                <table id="dr" class="table table-striped table-bordered no-wrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Managed</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Barcode</th>
                                            <th>Min Stock</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
