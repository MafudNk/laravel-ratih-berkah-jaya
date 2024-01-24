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
        Master Karyawan
      </h3>
      <div class="block-option">
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-alt-primary">
          Tambah Karyawan
        </a>
      </div>
    </div>
    <div class="container-fluid">
      @include('layouts.partials.messages')
    </div>
    <div class="block-content block-content-full">
      <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/tables_datatables.js -->
      <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons fs-sm">
        <thead>
          <tr>
            <th class="text-center" style="width: 80px;">#</th>
            <th>Nama</th>
            <th class="d-none d-sm-table-cell" style="width: 30%;">Email</th>
            <th style="width: 15%;">Alamat</th>
            <th>Role</th>
            <th style="width: 15%;">Action</th>
          </tr>
        </thead>
        <tbody>

          @foreach($users as $key=>$user)
          <tr>
            <td class="text-center">{{ $key+1 }}</td>
            <td class="fw-semibold">
              <a href="javascript:void(0)">{{$user->name}}</a>
            </td>
            <td class="d-none d-sm-table-cell">
              {{$user->email}}
            </td>
            <td class="text-muted">
              {{$user->karyawan_alamat}}
            </td>
            <td>
              @foreach($user->roles as $role)
              <span class="badge bg-primary">{{ $role->name }}</span>
              @endforeach
            </td>
            <td>
              @if($user->is_aktif == 0)
              <a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" href="{{ route('users.edit', $user->id) }}" data-bs-toggle="tooltip" aria-label="Update" data-bs-original-title="Update">
                <i class="fa fa-fw fa-pencil"></i>
              </a>
              <!-- <a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" href="javascript:void(0)" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                <i class="fa fa-fw fa-times"></i>
              </a> -->
              {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
              <a class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" href="javascript:void(0)" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                <i class="fa fa-fw fa-times"></i>
              </a>
              {!! Form::close() !!}
            </td>
            @else
            <span class="badge bg-danger">Karyawan Non Aktif</span>
            @endif
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