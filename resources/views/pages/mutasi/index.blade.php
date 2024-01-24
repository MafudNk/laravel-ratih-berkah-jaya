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

<!-- Page Content -->
<div class="content">

  <!-- Dynamic Table with Export Buttons -->
  <div class="block block-rounded">
    <div class="block-header block-header-default">
      <h3 class="block-title">
        Transaksi Mutasi Karyawan
      </h3>
      <div class="block-option">
        <a href="{{ route('karyawans.mutasi_create') }}" class="btn btn-sm btn-alt-primary">
          Mutasi Karyawan
        </a>
      </div>
    </div>
    <div class="block-content block-content-full">
      <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/tables_datatables.js -->
      <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons fs-sm">
        <thead>
          <tr>
            <th class="text-center" style="width: 80px;">#</th>
            <th>Nama Karyawan</th>
            <th>Nama Unit Kerja Lama</th>
            <th>Nama Departemen Lama</th>
            <th>Nama Jabatan Lama</th>
            <th>Nama Unit Kerja Baru</th>
            <th>Nama Departemen Baru</th>
            <th>Nama Jabatan Baru</th>
            <!-- <th>Action</th> -->
            <!-- <th class="d-none d-sm-table-cell" style="width: 30%;">Email</th>
            <th style="width: 15%;">Registered</th> -->
          </tr>
        </thead>
        <tbody>
          @foreach($mutasi as $key=>$d) <tr>
            <td class="text-center">{{ $key+1 }}</td>
            <td class="fw-semibold">
              {{$d->name}}
            </td>
            <td class="fw-semibold">
             {{$d->unit_kerja_nama_lama}}
            </td>
            <td class="fw-semibold">
             {{$d->departemen_nama_lama}}
            </td>
            <td class="fw-semibold">
             {{$d->nama_jabatan_lama}}
            </td>
            <td class="fw-semibold">
             {{$d->unit_kerja_nama_baru}}
            </td>
            <td class="fw-semibold">
             {{$d->departemen_nama_baru}}
            </td>
            <td class="fw-semibold">
             {{$d->nama_jabatan_baru}}
            </td>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <!-- END Dynamic Table with Export Buttons -->
</div>
<!-- END Page Content -->
@endsection