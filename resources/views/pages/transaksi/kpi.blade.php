@extends('layouts.backend')

@section('css')
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
@endsection

@section('js')
<!-- jQuery (required for DataTables plugin) -->
<script src="{{ asset('js/lib/jquery.min.js') }}"></script>

<!-- Page JS Plugins -->
<script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

<!-- Page JS Code -->
@vite(['resources/js/pages/datatables.js'])
@endsection

@section('content')
<!-- Hero -->
<!-- <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-2">
            DataTables Example
          </h1>
          <h2 class="fs-base lh-base fw-medium text-muted mb-0">
            Plugin Integration
          </h2>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="javascript:void(0)">Examples</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              DataTables
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div> -->
<!-- END Hero -->

<!-- Page Content -->
<div class="content">


    <!-- Dynamic Table with Export Buttons -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Penilaian Data KPI
            </h3>
            <div class="block-option">
                <!-- <a href="/create/data_kpi" class="btn btn-sm btn-alt-primary">
          Tambah Data KPI
        </a> -->
            </div>
        </div>
        <div class="block-content block-content-full">
            <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/tables_datatables.js -->
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full fs-sm">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">#</th>
                        <th>Nama KPI</th>
                        <th></th>
                        <!-- <th class="d-none d-sm-table-cell" style="width: 30%;">Email</th>
            <th style="width: 15%;">Registered</th> -->
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i < 21; $i++) <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td class="fw-semibold">
                            <a href="javascript:void(0)">Joko {{$i}}</a>
                        </td>
                        <td><a href="/transaksi_create/data_kpi" class="btn btn-sm btn-alt-primary">
                                Isi nilai KPI
                            </a></td>
                        <!-- <td class="d-none d-sm-table-cell">
              client{{ $i }}<span class="text-muted">@example.com</span>
            </td>
            <td class="text-muted">
              {{ rand(2, 10) }} days ago
            </td> -->
                        </tr>
                        @endfor
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Dynamic Table with Export Buttons -->
</div>
<!-- END Page Content -->
@endsection