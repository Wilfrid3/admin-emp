<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
		<title>Dreamemp - Admin</title>
		<meta charset="utf-8" />
		<meta name="description" content="Application d'administration de Dreamemp" />
		<meta name="keywords" content="Dreamemp Admin" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" />
		
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		
		<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
		<!--begin::Theme mode setup on page load-->
		<script>
            var defaultThemeMode = "light"; 
            var themeMode; 
            if ( document.documentElement ) {
                if ( document.documentElement.hasAttribute("data-theme-mode")) {
                    themeMode = document.documentElement.getAttribute("data-theme-mode");
                } else  if ( localStorage.getItem("data-theme") !== null ) {
                    themeMode = localStorage.getItem("data-theme"); 
                } else {
                        themeMode = defaultThemeMode; 
                }
            } 
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; 
            } 
            document.documentElement.setAttribute("data-theme", themeMode); 
        </script>
		<!--end::Theme mode setup on page load -->
		
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<style>body { background-image: url({{asset('assets/media/auth/bg3.jpg')}}); } [data-theme="dark"] body { background-image: url({{asset('assets/media/auth/bg3-dark.jpg')}}); }</style>
			<div class="d-flex flex-column flex-column-fluid flex-lg-row">
				<div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
					<div class="d-flex flex-center flex-lg-start flex-column">
						<a href="index-2.html" class="mb-7">
							<img alt="Logo" src="assets/media/logos/nav-logo-white.png" />
						</a>
						<h2 class="text-white fw-normal m-0 text-md-center">Veuillez vous connecter pour accéder à votre tableau de bord</h2>
					</div>
				</div>
				<div class="d-flex flex-center w-lg-50 p-10">
					<div class="card rounded-3 w-md-550px">
						<div class="card-body p-10 p-lg-20">
							<form class="form w-100" novalidate="novalidate" action="{{ route('login-user') }}" method="POST">
								<div class="text-center mb-5">
									<h1 class="text-dark fw-bolder mb-3">Connexion</h1>
									<div class="text-gray-500 fw-semibold fs-6">Entrez vos identifiants</div>
								</div>
								@if (Session::has('success'))
                                    <div class="alert alert-success mb-8">{{ Session::get('success') }}</div>
                                @endif
                                @if (Session::has('fail'))
                                    <div class="alert alert-danger mb-8">{{ Session::get('fail') }}</div>
                                @endif
                                @if (Session::has('info'))
                                    <div class="alert alert-info mb-8">{{ Session::get('info') }}</div>
                                @endif

                                @csrf
								<div class="fv-row mb-4">
									<input type="text" placeholder="Entrez votre nom d'utilisateur" name="username" autocomplete="off" class="form-control bg-transparent" value="{{ old('username') }}" />
									<span class="text-danger">@error('username') {{ $message }} @enderror</span>
								</div>
								<div class="fv-row mb-8">
									<input type="password" placeholder="Entrez votre mot de passe" name="pasword" autocomplete="off" class="form-control bg-transparent" value="{{ old('pasword') }}" />
									<span class="text-danger">@error('pasword') {{ $message }} @enderror</span>
								</div>
								<div class="d-grid mb-10">
									<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
										<span class="indicator-label">Se connecter</span>
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
	</body>

</html>