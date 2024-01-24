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
  <div class="block block-rounded">
    <div class="block-header block-header-default">
      <h3 class="block-title">
        Master Jabatan
      </h3>
      <div class="block-option">
        <a href="{{ route('jabatans.create') }}" class="btn btn-sm btn-alt-primary">
          Tambah Jabatan
        </a>
      </div>
    </div>
    <div class="container-fluid">
      @include('layouts.partials.messages')
    </div>
    <div class="block-content block-content-full">
      <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons fs-sm">
        <thead>
          <tr>
            <th class="text-center" style="width: 80px;">#</th>
            <th>Nama Jabatan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1 ?>
          @foreach($jabatans as $key=>$data) <tr>
            <td class="text-center">{{ $key+1 }}</td>
            <td class="fw-semibold">
              {{$data->nama_jabatan}}
            </td>
            
            <td>
              <a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" href="{{ route('jabatans.edit', $data->jabatan_id) }}" data-bs-toggle="tooltip" aria-label="Update" data-bs-original-title="Update">
                <i class="fa fa-fw fa-pencil"></i>
              </a>
              <a class="btn btn-sm btn-alt-info js-bs-tooltip-enabled" href="{{ route('jabatans.data_kpi', $data->jabatan_id) }}" data-bs-toggle="tooltip" aria-label="Tambah Data KPI" data-bs-original-title="Tambah Data KPI">
                <i class="fa fa-fw fa-paper-plane"></i>
              </a>
             
            </td>
            </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <!-- END Dynamic Table with Export Buttons -->
</div>
<!-- END Page Content -->
@endsection