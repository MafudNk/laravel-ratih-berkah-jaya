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

<!-- Page Content -->
<div class="content">

  <!-- Dynamic Table with Export Buttons -->
  <div class="block block-rounded">
    <div class="block-header block-header-default">
      <h3 class="block-title">
        Tambah Mutasi
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
                  <label class="form-label" for="val-departemen">Nama Karyawan <span class="text-danger">*</span></label>

                  <select class="form-select" name="karyawan_id" id="karyawan_id" style="width: 100%;">
                    @foreach($karyawan as $kar)
                    <option value="{{$kar->id}}">{{$kar->name}}</option>
                    @endforeach
                  </select>

                </div>
                <div class="mb-4">
                  <label class="form-label" for="val-departemen">Nama Unker <span class="text-danger">*</span></label>

                  <select class="js-select2 form-select" id="unker" name="unit_kerja_id" style="width: 100%;">
                    
                   
                  </select>

                </div>

                <div class="mb-4">
                  <label class="form-label" for="val-departemen">Jabatan <span class="text-danger">*</span></label>

                  <select class="js-select2 form-select" name="jabatan_id" style="width: 100%;">
                     @foreach($jabatan as $jab)
                    <option value="{{$jab->jabatan_id}}">{{$jab->nama_jabatan}}</option>
                    @endforeach
                  </select>
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
<script>
  var selectElement = document.getElementById('karyawan_id');
  // Menambahkan event listener untuk perubahan pilihan
  // console.log(selectElement.value)
  selectElement.addEventListener('change', function() {
    var selectedValue = this.value; // Mendapatkan nilai yang dipilih
    // console.log(selectElement.value)

    // Mengirim permintaan AJAX ke backend Laravel
    fetch('mutasi_get/' + selectedValue)
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        // Data yang diterima dari backend Laravel
        // dapat digunakan untuk melakukan pembaruan pada halaman
        // atau menampilkan data yang diterima
        
        var optionsData = data.unker;
        var selectElement2 = document.getElementById('unker');
        optionsData.forEach(function(option) {
          var optionElement = document.createElement('option');
          optionElement.value = option.unit_kerja_id;
          optionElement.text = option.unit_kerja_nama;
          selectElement2.appendChild(optionElement);
        });

        // var optionsData2 = data.jabatan;
        // var selectElement3 = document.getElementById('jabatan');
        // optionsData2.forEach(function(option) {
        //   var optionElement = document.createElement('option');
        //   optionElement.value = option.jabatan_id;
        //   optionElement.text = option.nama_jabatan;
        //   selectElement3.appendChild(optionElement);
        // });

      })
      .catch(function(error) {
        console.log(error);
      });
  });
</script>
@endsection