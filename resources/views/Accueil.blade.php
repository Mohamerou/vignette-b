
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
                        <a href="" class="typewrite" style="color: white" data-period="2000" data-type='[ "ikaVignetti", "La Vignette en un click", "Facile et Rapide !" ]'>
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
      <div id="time-table" class="time-table-section" style="margin-top: 30%">
         <div class="container">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
               <div class="row">
                  <div class="service-time one" style="background:#2895f1;">
                     <span class="info-icon"><img width="150px" height="100px" src="images/vignette.jpeg" aria-hidden="true"></span>
                     <h3>Une vignette a portée de main</h3>
                     <p>Finie les contrefacons de vignette;<br><br><br><br></p>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
               <div class="row">
                  <div class="service-time middle" style="background:#0071d1;">
                     <span class="info-icon"><img src="images/qr.png" aria-hidden="true"></span> 
                     <h3>Traçabilité de vos engins</h3>
                     <div class="time-table-section">
                        <p>Avec <b>IKAVIGNETTI</b> la securité de votre vignette est garantie;<br> Tous vos engin sont enregistre et surveillé par les commisariats de police permettant de les retrouvés facilement en cas de vol <br> </p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
               <div class="row">
                  <div class="service-time three" style="background:#0060b1;">
                     <span class="info-icon"><img width="150px" height="100px" src="images/rangprvignette.jpg" aria-hidden="true"></span>
                     <h3>Les Rang !!!</h3>
                     <p><p>Gagnez du temps avec la plateforme <b>IKAVIGNETTI</b>. Obtenez vos vignette à seulement quelques click sur votre smartphone ou votre ordinateur. </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      <footer id="footer" class="footer-area wow fadeIn">
         
      </footer>
      @endsection

