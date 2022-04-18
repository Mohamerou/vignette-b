      <header style="width: 95%; margin: auto;">
         <div class="header-top wow fadeIn" >
            <div class="container" >
               <a class="navbar-brand" href="/"><img style="width:50px; height:100px;" src="images/logo.png" alt="image"></a>
               <div class="right-header">
                  <div class="header-info">
                 
                     <div class="info-inner">
                       <!--  <span class="icontop"><img src="images/phone-icon.png" alt="#"></span>
                       <span class="iconcont"><a href="tel:+223 60 69 03 43">+223 60 69 03 43</a></span>  -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="header-bottom wow fadeIn">
            <div class="container">
               <nav class="main-menu">
                  <div class="navbar-header">
                     <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i class="fa fa-bars" aria-hidden="true"></i></button>
                  </div>
                  
                  <div id="navbar" class="navbar-collapse collapse">
                        

                     <ul class="nav navbar-nav">
                                    @if (Route::has('login'))
              
                    @auth
                     <li><a  data-scroll href="{{ url('/home') }}">Accueil</a></li>
                    @else
                        <li><a  data-scroll href="{{ route('login') }}">Se connecter</a></li>

                        @if (Route::has('register'))
                           <!-- <li><a data-scroll href="{{ route('register') }}">Créer un Compte</a></li> -->
                        @endif
                    @endauth
                
            @endif
                        
                        
                        
                     </ul>
                  </div>
               </nav>
            
            </div>
         </div>
      </header>