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
                                            Inventory >
                                            <a href="#" target="_blank">Location</a>
                                        </li>
                                    </ol>
                                </nav>
                            </h4>
                            <hr>
                            {{-- <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                                <p><strong>Filter Berdasarkan</strong></p>
                                <form action="" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <select name="list_product" class="form-control">
                                                            <option value="" disabled selected hidden> Search By
                                                            </option>
                                                            <option value="product_managed">Managed</option>
                                                            <option value="product_type">Type</option>
                                                            <option value="product_code">Code</option>
                                                            <option value="min_stock">Min Stock</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-lg-5">
                                                        <input type="text" id="product_name" name="product_name"
                                                            value="" class="form-control" placeholder="Search Value">
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
                            </div> --}}

                            <div class="table-responsive">
                                <table id="dr" class="table table-striped table-bordered no-wrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>Address</th>
                                            <th>Open</th>
                                            <th>Closed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listLocations as $location)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $location['location_code'] }}</td>
                                                <td>{{ $location['location_name'] }}</td>
                                                <td>{{ $location['contact'] }}</td>
                                                <td>{{ $location['address'] }}</td>
                                                <td>{{ $location['open_hours'] }}</td>
                                                <td>{{ $location['closed_hours'] }}</td>
                                            </tr>
                                        @endforeach
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
