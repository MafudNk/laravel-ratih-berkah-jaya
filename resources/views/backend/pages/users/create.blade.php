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
        Tambah Karyawan
      </h3>

    </div>
    <div class="block-content block-content-full">

      <form class="js-validation" action="" method="POST">
        @csrf
        <div class="block block-rounded">

          <div class="block-content block-content-full">
            <!-- Regular -->

            <div class="row items-push">

              <div class="col-lg-6 col-xl-5">
                <div class="mb-4">
                  <label class="form-label" for="val-nama-karyawan">Nama Karyawan <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="val-nama-karyawan" name="name" placeholder="Nama Karyawan..">
                </div>
                <div class="mb-4">
                  <label class="form-label" for="val-tanggal-lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="val-tanggal-lahir" name="karyawan_tanggal_lahir" placeholder="Tanggal Lahir..">
                </div>
                <div class="mb-4">
                  <label class="form-label" for="val-tempat-lahir">Tempat Lahir <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="val-tempat-lahir" name="karyawan_kelahiran" placeholder="Tempat Lahir..">
                </div>
                <div class="mb-4">
                  <label class="form-label" for="val-nik">NIK <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="val-nik" name="karyawan_nik" placeholder="NIK..">
                </div>
                <div class="mb-4">
                  <label class="form-label" for="val-no-ktp">No KTP <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="val-no-ktp" name="karyawan_ktp" placeholder="No KTP..">
                </div>
                <div class="mb-4">
                  <label class="form-label" for="val-alamat-ktp">Alamat KTP <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="val-alamat-ktp" name="karyawan_alamat" placeholder="Alamat KTP..">
                </div>
                <div class="mb-4">
                  <label class="form-label" for="val-kota">Kota / Kabupaten<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="val-kota" name="karyawan_kota_id" placeholder="Kota..">
                  <!-- <select class="js-select2 form-select" id="val-kota" name="kota" style="width: 100%;" data-placeholder="Choose one..">
                    <option></option>
                    <option value="Surabaya">Surabaya</option>
                    <option value="Malang">Malang</option>
                    <option value="Probolinggo">Probolinggo</option>
                    <option value="Sidoarjo">Sidoarjo</option>
                    <option value="Gresik">Gresik</option>
                    <option value="Pacitan">Pacitan</option>
                    <option value="Magetan">Magetan</option>
                    <option value="Madiun">Madiun</option>
                    <option value="Ngawi">Ngawi</option>
                  </select> -->
                </div>
                <div class="mb-4">
                  <label class="form-label" for="val-kecamatan">Kecamatan <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="val-kecamatan" name="karyawan_kecamatan_id" placeholder="Kecamatan..">
                  <!-- <select class="js-select2 form-select" id="val-kecamatan" name="kecamatan" style="width: 100%;" data-placeholder="Choose one..">
                    <option></option>
                    <option value="Maospati">Maospati</option>
                    <option value="Parang">Parang</option>
                    <option value="Kawedanan">Kawedanan</option>
                    <option value="Poncol">Poncol</option>
                    <option value="Barat">Barat</option>
                    <option value="Pacitan">Pacitan</option>
                    <option value="Bendo">Bendo</option>
                    <option value="Karangrejo">Karangrejo</option>
                    <option value="Karas">Karas</option>
                  </select> -->
                </div>
                <!-- <div class="mb-4">
                      <label class="form-label" for="val-confirm-password">Confirm Password <span class="text-danger">*</span></label>
                      <input type="password" class="form-control" id="val-confirm-password" name="confirm-password" placeholder="..and confirm it!">
                    </div> -->

              </div>
              <div class="col-lg-6 col-xl-5">

                <div class="mb-4">
                  <label class="form-label" for="val-jabatan">Jabatan <span class="text-danger">*</span></label>
                  <select class="js-select2 form-select" name="jabatan_id" style="width: 100%;" data-placeholder="Choose one..">
                    @foreach($jabatan as $jb)
                    <option value='{{$jb->jabatan_id}}'>{{$jb->nama_jabatan}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-4">
                  <label class="form-label" for="val-unit-kerja">Unit Kerja <span class="text-danger">*</span></label>
                  <select class="js-select2 form-select" name="unit_kerja_id" style="width: 100%;" data-placeholder="Choose one..">
                    @foreach($unker as $unkers)
                    <option value='{{$unkers->unit_kerja_id}}'>{{$unkers->unit_kerja_nama}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-4">
                  <label class="form-label" for="val-username-login">Username <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="val-username-login" name="username" placeholder="Username..">
                </div>
                <div class="mb-4">
                  <label class="form-label" for="val-email">Email <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="val-email" name="email" placeholder="Your valid email..">
                </div>
                <div class="mb-4">
                  <label class="form-label" for="val-password">Password <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="val-password" name="password" placeholder="Choose a safe one..">
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
                <a href="{{ route('users.index') }}" type="submit" class="btn btn-alt-secondary">Back</a>
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