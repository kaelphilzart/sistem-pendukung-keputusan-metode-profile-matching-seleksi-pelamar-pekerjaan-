<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PT An-Namiroh Travelindo</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/img/favicon.ico" />
    <style>
    .toast-container {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 1000;
    }

    .toast {
      display: none;
      min-width: 300px;
      padding: 15px;
      margin-bottom: 10px;
      border-radius: 5px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      opacity: 0;
      transition: opacity 0.5s ease, bottom 0.5s ease;
    }

    .toast.show {
      display: block;
      opacity: 1;
      bottom: 30px;
    }

    .toast-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    .toast-body {
      padding: 10px 0;
      color: black;
    }

    .toast.success {
      background-color: #d4edda;
      border-left: 5px solid #28a745;
    }

    .toast.error {
      background-color: #f8d7da;
      border-left: 5px solid #dc3545;
    }

    .toast-header img {
      width: 16px;
      height: 16px;
      margin-right: 10px;
    }

    .toast-header .btn-close {
      cursor: pointer;
      background: none;
      border: none;
      font-size: 1.2em;
      line-height: 1;
      color: #000;
    }
  </style>
  </head>
  <body>
    <div class="container-scroller text-dark">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3 text-dark">Login</h3>
                <form  method="POST" action="{{ route('login-akun') }}">
                  @csrf
                  <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control p_input" id="email" name="email">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control p_input" id="password" name="password">
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                  </div>
                  <p class="sign-up">Apakah Kamu punya akun ?<a href="{{route('register')}}">Buat Akun</a></p>
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/settings.js"></script>
    <script src="../../assets/js/todolist.js"></script>
    <!-- endinject -->
    <div class="toast-container">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <img id="toast-icon" src="" class="rounded me-2" alt="" style="width: 16px; height: 16px;">
        <strong id="toast-title" class="me-auto"></strong>
        <button type="button" class="btn-close" onclick="closeToast()" aria-label="Close">&times;</button>
      </div>
      <div id="toast-body" class="toast-body"></div>
    </div>
  </div>

  <!-- JavaScript untuk Toast -->
  <script>
    function showToast(type, message) {
      var toast = document.getElementById('liveToast');
      var toastIcon = document.getElementById('toast-icon');
      var toastTitle = document.getElementById('toast-title');
      var toastBody = document.getElementById('toast-body');

      if (type === 'success') {
        toast.classList.add('success');
        toast.classList.remove('error');
        toastIcon.src = '/images/success.png';
        toastTitle.textContent = 'Berhasil';
      } else if (type === 'error') {
        toast.classList.add('error');
        toast.classList.remove('success');
        toastIcon.src = '/images/failed.png';
        toastTitle.textContent = 'Gagal';
      }

      toastBody.textContent = message;
      toast.classList.add('show');

      setTimeout(function () {
        toast.classList.remove('show');
      }, 3000);
    }

    function closeToast() {
      var toast = document.getElementById('liveToast');
      toast.classList.remove('show');
    }

    // Tampilkan toast jika ada sesi error atau success
    document.addEventListener('DOMContentLoaded', function () {
      @if(session('error'))
      showToast('error', '{{ session('error') }}');
      @elseif(session('success'))
      showToast('success', '{{ session('success') }}');
      @endif
    });
  </script>
  </body>
</html>