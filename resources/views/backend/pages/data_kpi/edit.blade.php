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
<!-- <script src="{{ asset('js/oneui.app.min.js') }}"></script> -->
<!-- Page JS Code -->
<!-- @vite(['resources/js/pages/karyawan.js']) -->
<!-- <script>One.helpersOnLoad(['jq-select2']);</script> -->
@endsection

@section('content')
<div class="content">

  <!-- Dynamic Table with Export Buttons -->
  <div class="block block-rounded">
    <div class="block-header block-header-default">
      <h3 class="block-title">
        Edit KPI
      </h3>
     
    </div>
    <div class="block-content block-content-full">
     
    <form class="js-validation" action="{{ route('data_kpis.update', $value->data_kpi_id) }}" method="POST">
      @csrf
      @method('patch')
            <div class="block block-rounded">
              
              <div class="block-content block-content-full">
                <!-- Regular -->
               
                <div class="row items-push">
                 
                  <div class="col-lg-12 col-xl-8">
                    <!-- <div class="mb-4">
                      <label class="form-label" for="val-kode-kpi">Kode KPI <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="val-kode-kpi" name="val-kode-kpi" placeholder="">
                    </div> -->
                    <div class="mb-4">
                      <label class="form-label" for="val-nama-kpi">Nama KPI <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="val-nama-kpi" name="nama_indikator" value="{{$value->nama_indikator}}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="val-password">Nilai 0 <span class="text-danger">*</span></label>
                      <textarea type="password" class="form-control" id="val-password" name="nilai_0" >{{$value->nilai_0}}</textarea>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="val-password">Nilai 5 <span class="text-danger">*</span></label>
                      <textarea type="password" class="form-control" id="val-password" name="nilai_5">{{$value->nilai_5}}</textarea>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="val-password">Nilai 10 <span class="text-danger">*</span></label>
                      <textarea type="password" class="form-control" id="val-password" name="nilai_10" >{{$value->nilai_10}}</textarea>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="val-password">Nilai 15 <span class="text-danger">*</span></label>
                      <textarea type="password" class="form-control" id="val-password" name="nilai_15" >{{$value->nilai_15}}</textarea>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="val-password">Bobot <span class="text-danger">*</span></label>
                      <input type="number" class="form-control" name="bobot" value="{{ $value->bobot }}" />
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