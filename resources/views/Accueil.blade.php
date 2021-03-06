
  @extends('layouts.main')
  @section('content')
    

   <body class="clinic_version" style="width: 95%; margin: auto;">
      <!-- LOADER -->
      <div id="preloader" >
         <img class="preloader" src="images/loaders/heart-loading2.gif" alt="">
      </div>
      <!-- END LOADER -->

      <div id="home" class="parallax first-section wow fadeIn" data-stellar-background-ratio="0.4" style="background-image:url('images/bgm.jpg');">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12">
                  <div class="text-contant">
                     <h2><br><br>
                        <span class="center"><span class="icon"><img src="images/ika-icon.png" alt="#" /></span></span>
                        <a href="" class="typewrite" style="color: white" data-period="2000" data-type='[ "BIENVENUE SUR ikaVignetti", "LA Vignette en un click", "Très facile et Très rapide !" ]'>
                        <span class="wrap"></span>
                        </a>
                     </h2>
                  </div>
               </div>
            </div>
            <!-- end row -->
         </div>
         <!-- end container -->
      </div>
      <!-- end section -->

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
               <div class="row">
                  <div class="service-time middle" style="background:#0071d1;">
                     <span class="info-icon"><img src="images/qr.png" aria-hidden="true"></span> 
                     <h3>Tatalement numerique et securisé</h3>
                     <div class="time-table-section">
                        <p>Avec <b>IKAVIGNETTI</b> la securité de vignette est garantie à 100%;<br> aucune corruption de vignette n'est possible Tous vos engin sont enregistre et surveillé par les commisariats de police permettant de les retrouvés facilement en cas de vol <br> </p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
               <div class="row">
                  <div class="service-time three" style="background:#0060b1;">
                     <span class="info-icon"><img src="images/rangprvignette.jpg" aria-hidden="true"></span>
                     <h3>Finie les Rang !</h3>
                     <p><p>Avec <b>IKAVIGNETTI</b> plus de souci lors la prise ou du renouvellement de vos vignettes <br> Obtenez vos vignette à partir de quelques click sur votre smartphone ou votre ordinateur </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      <footer id="footer" class="footer-area wow fadeIn">
         
      </footer>
      @endsection

