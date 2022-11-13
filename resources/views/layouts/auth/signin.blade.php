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
							<form class="form w-100" novalidate="novalidate" action="{{ route('register-sa') }}" method="POST">
								<div class="text-center mb-11">
									<h1 class="text-dark fw-bolder mb-3">S'enregistrer</h1>
									<div class="text-gray-500 fw-semibold fs-6">Entrez vos informations</div>
								</div>
								@if (Session::has('success'))
                                    <div class="alert alert-success mb-3">{{ Session::get('success') }}</div>
                                @endif
                                @if (Session::has('fail'))
                                    <div class="alert alert-danger mb-3">{{ Session::get('fail') }}</div>
                                @endif

                                @csrf
								<div class="row mb-4">
                                    <div class="col-12 mb-3">
									    <input type="text" placeholder="Entrez votre nom et prénom" name="noms" autocomplete="off" class="form-control bg-transparent" value="{{ old('noms') }}" />
										<span class="text-danger">@error('noms') {{ $message }} @enderror</span>
                                    </div>
                                    <div class="col-md-6 mb-3">
									    <input type="text" placeholder="Entrez votre téléphone" name="phone" autocomplete="off" class="form-control bg-transparent" value="{{ old('phone') }}" />
                                    </div>
                                    <div class="col-md-6 mb-3">
									    <input type="email" placeholder="Entrez votre mail" name="mail" autocomplete="off" class="form-control bg-transparent" value="{{ old('mail') }}" />
										<span class="text-danger">@error('mail') {{ $message }} @enderror</span>
                                    </div>
                                    <div class="col-12 mb-3">
									    <input type="text" placeholder="Entrez votre adresse" name="addresse" autocomplete="off" class="form-control bg-transparent" value="{{ old('addresse') }}" />
                                    </div>
								</div>
								<div class="fv-row mb-4">
									<input type="text" placeholder="Entrez votre nom d'utilisateur" name="username" autocomplete="off" class="form-control bg-transparent" value="{{ old('username') }}" />
									<span class="text-danger">@error('username') {{ $message }} @enderror</span>
								</div>
								<div class="fv-row mb-8">
									<input type="password" placeholder="Entrez votre mot de passe" name="pasword" autocomplete="off" class="form-control bg-transparent" value="{{ old('pasword') }}" />
									<span class="text-danger">@error('pasword') {{ $message }} @enderror</span>
								</div>
								<div class="d-grid mb-10">
									<button type="submit" class="btn btn-primary">
										<span class="indicator-label">S'enregistrer</span>
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