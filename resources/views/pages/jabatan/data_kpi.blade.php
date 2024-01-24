@extends('layouts.backend')

@section('css')
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
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
<script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('content')
<!-- Page Content -->
<div class="content">

  <!-- Dynamic Table with Export Buttons -->
  <div class="block block-rounded">
    <div class="block-header block-header-default">
      <h3 class="block-title">
        Edit Jabatan
      </h3>

    </div>
    <div class="container-fluid">
      @include('layouts.partials.messages')
    </div>
    <div class="block-content block-content-full">


      <div class="block block-rounded">

        <div class="block-content block-content-full">
          <!-- Regular -->

          <div class="row items-push">

            <div class="col-lg-12 col-xl-5">
              <div class="mb-4">
                <label class="form-label" for="val-departemen">Nama Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="val-departemen" name="nama_jabatan" disabled value="{{ $data->nama_jabatan }}">
              </div>
            </div>
          </div>
          <!-- END Regular -->
          <div class="block-option">
            <a href="{{ route('jabatans.data_kpi_create' , $data->jabatan_id) }}" class="btn btn-sm btn-alt-primary">
              Tambah Indikator
            </a>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-vcenter">
              <thead>
                <tr>
                  <th class="text-center" style="width: 5%;">
                    #
                  </th>
                  <th>Nama Indikator</th>
                  <th style="width: 5%;">Bobot</th>
                  <th style="width: 15%;">Nilai 0</th>
                  <th style="width: 15%;">Nilai 5</th>
                  <th style="width: 15%;">Nilai 10</th>
                  <th style="width: 15%;">Nilai 15</th>
                  <th class="text-center" style="width: 100px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data_kpi as $key => $dt)
                <tr>
                  <td class="text-center">
                    {{$key+1}}
                  </td>
                  <td class="fw-semibold fs-sm">
                    {{$dt->nama_indikator}}
                  </td>
                  <td class="fs-sm">{{$dt->bobot}}</td>
                  <td class="fs-sm">{{$dt->nilai_0}}</td>
                  <td class="fs-sm">{{$dt->nilai_5}}</td>
                  <td class="fs-sm">{{$dt->nilai_10}}</td>
                  <td class="fs-sm">{{$dt->nilai_15}}</td>
                  <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['jabatans.destroy_data_kpi', $dt->data_detail_kpi_id],'style'=>'display:inline']) !!}
                    <button type="submit" class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                        <i class="fa fa-fw fa-times"></i>
                      </button>
                    {!! Form::close() !!}
                    <!-- <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                        <i class="fa fa-fw fa-times"></i>
                      </button>
                    </div> -->
                  </td>
                  @endforeach
                </tr>
              </tbody>
            </table>
          </div>
          <!-- END Advanced -->


          <!-- END Third Party Plugins -->

          <!-- Submit -->
          <div class="row items-push">
            <div class="col-lg-12">
              <a href="{{ route('jabatans.index') }}" class="btn btn-alt-info">Kembali</a>
            </div>
          </div>
          <!-- END Submit -->
        </div>
      </div>

    </div>
  </div>
  <!-- END Dynamic Table with Export Buttons -->
</div>
<!-- END Page Content -->
@endsection