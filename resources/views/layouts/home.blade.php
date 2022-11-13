@extends('baselayout')

@section('content')

<section class="banner-section" style="margin-top: 0px;">

    <div id="banner-slide" class="owl-carousel">
        <div class="item slidehome1">
            <div class="container">
                {{-- <div class="banner-heading title1">
                    <p class="title-part1">ACTE DE NAISSANCE</p>
                    <p class="title-part2">POUR TOUT LE MONDE</p>
                    <p class="title1-part1"><span style="font-weight: bold;">“</span> Lo doonul talibeem, mënulo doone <br> serignam. <span style="font-weight: bold;">”</span></p>
                    <p class="title1-part2">On ne peut devenir maître d'une <br> chose qu'on a pas étudiée</p>
                    <p class="title1-part3">Proverbe Wolof</p>
                </div> --}}
                <!-- <div class="banner-forms" style="width: 640px;">
                    <form class="banner-form" action="">
                        <div class="input-group-form form-style form-br col-md-3 col-12"> <i class="fas fa-map-marker-alt text-warning"></i>
                            <input class="input-style-form" type="text" placeholder="Search
                                    Location" name="going">
                        </div>
                        <div class="input-group-form form-style col-md-6 col-12">
                            <input class="input-style-form" type="text" placeholder="Search School, Online eductional centers, etc" name="going">
                        </div>
                        <button class="btn button-form col-md-3 col-12" type="submit">Search Now</button>
                    </form>
                </div> -->
            </div>
        </div>
        <div class="item" style="background: url({{asset('assets/img/banner/affiche2.png')}}); background-repeat: no-repeat; background-size: 100% 100vh; background-attachment: fixed; width: 100%; height: 100vh;">
            <div class="container">
                {{-- <div class="banner-heading title2">
                    <p class="title2-part1"><span style="font-weight: bold;">“</span>« Le bonheur est un hôte discret, dont on ne constate souvent l'existence que  <br> par son acte de décès. "<span style="font-weight: bold;">”</span></p>
                    <p class="title2-part2">Avec la recherche tout est possible</p>
                    <p class="title2-part3">Proverbe dioula</p>
                </div> --}}
            </div>
        </div>
        <div class="item" style="background: url({{asset('assets/img/banner/affiche3.png')}}); background-repeat: no-repeat; background-size: 100% 100vh; background-attachment: fixed; width: 100%; height: 100vh;">
            <div class="container">
                {{-- <div class="banner-heading title3">
                    <p class="title3-part1 text-center">LE MARIAGE</p>
                    <p class="title3-part2 text-center">le mariage n'est ni un poison,ni un medicament. c'est une confiture,une friandise<br> C'est la mort morale de toute independance.</p>
                    <p class="title3-part3">Carlo Goldoni</p>
                </div> --}}
            </div>
        </div>
        <div class="item" style="background: url({{asset('assets/img/banner/affiche4.png')}}); background-repeat: no-repeat; background-size: 100% 100vh; background-attachment: fixed; width: 100%; height: 100vh;">
            <div class="container">
                {{-- <div class="banner-heading title4">
                    <p class="title4-part1 text-left">L'ACTE </p>
                    <p class="title4-part2 text-left"> DE NAISSANCE</p>
                    <p class="title4-part3 text-center">est un ACTE d'amour entre la mere et l'enfant <br> La joiussance douloureuse pour l'un etpour l'autre...<br>Nous l'a prenons d'une irréductible volonté feminine de partager l'univers.</p>
                    <p class="title4-part4 text-left">Dominique BLONDEAU.</p>
                </div> --}}
            </div>
        </div>
    </div>
</section>

<section class="featured-section bg-grey">
    <div class="container">
        <div class="section-heading d-flex align-items-center">
            <div class="heading-content">
                <h2><span class="text-weight">A propos du système</span> GNAEC <span class="header-right"></span></h2>
                <p>Services de la plateforme...</p>
                <p>GNAEC est une application de gestion numerique des actes d'etat civil au cameroun qui viendra faciliter la conception et l'atablissement des actes de maniere numerique</p>
                <p>ce systeme met egalement a votre disposition des informations utile a votre culture et vous informe egalement sur l'historique des registre et leurs usage</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="featured-card bg-primary">
                    <h2 class="text-white">Actes de naissance</h2>
                    <p class="text-white">"L'acte de naissance est un acte d'amour entre la mere et l'enfant, une jouissance douloureuse pour l'un et pour l'autre"</p>
                    <a href="#" class="text-white">View More<i class="fas fa-caret-right right-nav-grey"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="featured-card bg-success">
                    <h2 class="text-white">Actes de mariage</h2>
                    <p class="text-white">"Le mariage est la traduction en prose du poème de l'amour, c'est la volonté a deux de créer l'unique.Quand on aime on aime pour la vie."</p>
                    <a href="#" class="text-white">View More <i class="fas fa-caret-right right-nav-white"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="featured-card bg-danger">
                    <h2 class="text-white">Actes de décès</h2>
                    <p class="text-white">"La mort n'est pas la plus grande perte que nous subissons dans a vie, le pire c'est ce qui meurt en nous quand nous vivont"</p>
                    <a href="#" class="text-white">View More <i class="fas fa-caret-right right-nav-white"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="blog-sections">
    <div class="container">
        <div class="section-heading d-flex align-items-center">
            <div class="heading-content">
                <h2><span class="text-weight">Pubilications de</span> BANS de mariage <span class="header-right"></span></h2>
                <p>Consultez les récentes publications de bans de mariages</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="blog-box blog-grid-box">
                    <div class="blog-grid-box-img">
                        <a href="blog_detail.php">
                            <img src="{{asset('assets/img/mariage/ma.jpg')}}" class="img-fluid" alt="">
                        </a>
                    </div>
                    <div class="blog-grid-box-content">
                        <div class="blog-avatar text-center">
                            <p>Posted on 24-01-2021</p>
                        </div>
                        <h4><a href="blog_detail.php">Contrary to popular belief, Lorem Ipsum is</a></h4>
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum</p>
                        <a href="#" class="text-primary">Voir Plus <i class="fas fa-caret-right right-nav"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="blog-box blog-grid-box">
                    <div class="blog-grid-box-img">
                        <a href="blog_detail.php">
                            <img src="{{asset('assets/img/mariage/ma.jpg')}}" class="img-fluid" alt="">
                        </a>
                    </div>
                    <div class="blog-grid-box-content">
                        <div class="blog-avatar text-center">
                            <p>Posted on 24-01-2021</p>
                        </div>
                        <h4><a href="blog_detail.php">The standard chunk of Lorem Ipsum used</a></h4>
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum</p>
                        <a href="#" class="text-primary">Voir Plus <i class="fas fa-caret-right right-nav"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="blog-box blog-grid-box">
                    <div class="blog-grid-box-img">
                        <a href="blog_detail.php">
                            <img src="{{asset('assets/img/mariage/ma.jpg')}}" class="img-fluid" alt="">
                        </a>
                    </div>
                    <div class="blog-grid-box-content">
                        <div class="blog-avatar text-center">
                            <p>Posted on 24-01-2021</p>
                        </div>
                        <h4><a href="blog_detail.php">The standard Lorem Ipsum passage, used</a></h4>
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum</p>
                        <a href="#" class="text-primary">Voir Plus <i class="fas fa-caret-right right-nav"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection