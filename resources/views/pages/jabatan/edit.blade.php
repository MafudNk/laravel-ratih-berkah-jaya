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
    <div class="block-content block-content-full">
     
    <form class="js-validation" action="{{ route('jabatans.update', $data->jabatan_id) }}" method="POST">
    @csrf
    @method('patch')
            <div class="block block-rounded">
              
              <div class="block-content block-content-full">
                <!-- Regular -->
               
                <div class="row items-push">
                 
                  <div class="col-lg-12 col-xl-5">
                    <div class="mb-4">
                      <label class="form-label" for="val-departemen">Nama Jabatan <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="val-departemen" name="nama_jabatan" value="{{ $data->nama_jabatan }}">
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