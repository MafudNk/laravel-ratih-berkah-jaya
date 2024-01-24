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
<script src="{{ asset('js/lib/oneui.app.min.js') }}"></script>
<!-- <script src="{{ asset('js/oneui.app.min.js') }}"></script> -->
<!-- Page JS Code -->
<!-- @vite(['resources/js/pages/karyawan.js']) -->
<script>
  One.helpersOnLoad(['jq-select2']);
</script>
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
        Tambah Unit Kerja
      </h3>

    </div>
    <div class="block-content block-content-full">

      <form class="js-validation" action="" method="POST">
        @csrf
        <div class="block block-rounded">

          <div class="block-content block-content-full">
            <!-- Regular -->

            <div class="row items-push">

              <div class="col-lg-12 col-xl-5">
                <div class="mb-4">
                  <label class="form-label" for="val-departemen">Nama Departemen <span class="text-danger">*</span></label>

                  <select class="js-select2 form-select" id="val-kecamatan" name="departemen_id" style="width: 100%;" data-placeholder="Choose one..">
                    @foreach($departemen as $dep)><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                    <option value="{{$dep->departemen_id}}">{{$dep->departemen_nama}}</option>
                    <!-- <option value="Jahit">Jahit</option>
                    <option value="Packing">Packing</option>
                    <option value="Gudang Logistik">Gudang Logistik</option>
                    <option value="SDM">SDM</option> -->
                    @endforeach
                  </select>

                </div>
                <div class="mb-4">
                  <label class="form-label" for="val-unker">Unit Kerja <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="val-unker" name="unit_kerja_nama" placeholder="Your valid unker..">
                </div>

              </div>
            </div>
            <!-- END Regular -->

            <!-- END Advanced -->


            <!-- END Third Party Plugins -->

            <!-- Submit -->
            <div class="row items-push">
              <div class="col-lg-12">
                <button type="submit" class="btn btn-alt-primary">Submit</button>
              </div>
            </div>
            <!-- END Submit -->
          </div>
        </div>
      </form>

    </div>
  </div>
  <!-- END Dynamic Table with Export Buttons -->
</div>
<!-- END Page Content -->
@endsection