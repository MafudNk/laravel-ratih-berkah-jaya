@extends('layouts.simple')

@section('content')
<!-- Hero -->
<div id="page-container">

  <!-- Main Container -->
  <main id="main-container">
    <!-- Page Content -->
    <div class="hero-static d-flex align-items-center">
      <div class="content">
        <div class="row justify-content-center push">
          <div class="col-md-8 col-lg-6 col-xl-4">
            <!-- Sign In Block -->
            <div class="block block-rounded mb-0">
              <div class="block-header block-header-default">
                <h3 class="block-title">Sign In</h3>
                <div class="block-options">
                </div>
              </div>
              <div class="block-content">
                <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
                  <h1 class="h2 mb-1">Sistem Informasi Penilaian Karyawan</h1>


                  <!-- Sign In Form -->
                  <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js) -->
                  <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                  <form class="js-validation-signin" action="{{ route('login.perform') }}" method="post">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="py-3">
                      @include('layouts.partials.messages')
                      <div class="mb-4">
                        <input type="text" class="form-control form-control-alt" id="login-username" name="username" placeholder="Username">
                      </div>
                      @if ($errors->has('username'))
                      <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                      @endif
                      <div class="mb-4">
                        <input type="password" class="form-control form-control-alt form-control-lg" id="login-password" name="password" placeholder="Password">
                      </div>
                      @if ($errors->has('password'))
                      <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                      @endif

                    </div>
                    <div class="row mb-4">
                      <div class="col-md-6 col-xl-5">
                        <button type="submit" class="btn w-100 btn-alt-primary">
                          <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> Sign In
                        </button>
                      </div>
                    </div>
                  </form>
                  <!-- END Sign In Form -->
                </div>
              </div>
            </div>
            <!-- END Sign In Block -->
          </div>
        </div>
        <div class="fs-sm text-muted text-center">

        </div>
      </div>
    </div>
    <!-- END Page Content -->
  </main>
  <!-- END Main Container -->
</div>
<!-- END Hero -->
@endsection