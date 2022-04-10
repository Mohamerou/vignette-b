<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Skydash Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('admindash/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('admindash/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('admindash/vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('admindash/css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('admindash/images/favicon.png') }}" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="{{ asset('admindash/images/logo.svg') }}" alt="logo">
              </div>
              <h4>Mairie du District</h4>
              <h6 class="font-weight-light">Se connecter pour continuer.</h6>
              <form class="pt-3" action="{{ route('postLogin') }}" method="POST">
                <div class="form-group">
                  <input name="phone" type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Telephone">
                </div>
                <div class="form-group">
                  <input name="password" type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Mot de passe">
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit" >Se Connecter</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Mot de passe oubli</a>
                </div>
                <div class="mb-2">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{ asset('admindash/vendors/js/vendor.bundle.base.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ asset('admindash/js/off-canvas.js') }}"></script>
  <script src="{{ asset('admindash/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('admindash/js/template.js') }}"></script>
  <script src="{{ asset('admindash/js/settings.js') }}"></script>
  <script src="{{ asset('admindash/js/todolist.js') }}"></script>
  <!-- endinject -->
</body>

</html>
