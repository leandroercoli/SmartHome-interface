<?php
   session_start();
   //Check if user is logged in
   if(!isset($_SESSION['logged_user'])){
	   header("Location: index.html");
	   exit();
   }
   ?>
<!doctype html>
<!--
   Material Design Lite
   Copyright 2015 Google Inc. All rights reserved.
   
   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at
   
       https://www.apache.org/licenses/LICENSE-2.0
   
   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License
   -->
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
      <title>Smart Home</title>
      <!-- Add to homescreen for Chrome on Android -->
      <meta name="mobile-web-app-capable" content="yes">
      <link rel="icon" sizes="192x192" href="images/android-desktop.png">
      <!-- Add to homescreen for Safari on iOS -->
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <meta name="apple-mobile-web-app-title" content="Material Design Lite">
      <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">
      <!-- Tile icon for Win8 (144x144 + tile color) -->
      <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
      <meta name="msapplication-TileColor" content="#3372DF">
      <link rel="shortcut icon" href="images/pageicon.png">
      <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
      <!--
         <link rel="canonical" href="http://www.example.com/">
         -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.cyan-light_blue.min.css">
      <link rel="stylesheet" href="styles.css">
   </head>
   <body>
      <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
         <header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
            <div class="mdl-layout__header-row">
			    <span class="mdl-layout__title" style="position:fixed;">
                     <div class="portfolio-logo"></div>
               </span>
               <div class="mdl-layout-spacer"></div>
               <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
               <i class="material-icons">more_vert</i>
               </button>
               <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
                  <li class="mdl-menu__item">About</li>
                  <li class="mdl-menu__item">Contact</li>
                  <li class="mdl-menu__item">Legal information</li>
               </ul>
            </div>
         </header>
         <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
            <header class="demo-drawer-header">
               <img src="images/user.png" class="demo-avatar">
               <div class="demo-avatar-dropdown">
                  <span><?php echo $_SESSION['logged_user']; ?></span>
                  <div class="mdl-layout-spacer"></div>
                  <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                  <i class="material-icons" role="presentation">arrow_drop_down</i>
                  <span class="visuallyhidden">Accounts</span>
                  </button>
                  <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
                  <li class="mdl-menu__item"><a href="logout.php" style="text-decoration: none;">Logout</a></li>
               </ul>
               </div>
            </header>
            <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
               <a class="mdl-navigation__link" href="home.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Home</a>
               <a class="mdl-navigation__link" href="profile.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">account_circle</i>Profile</a>
               <a class="mdl-navigation__link mdl-navigation__link--current" href="weather.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">wb_sunny</i>Weather</a>
               <a class="mdl-navigation__link" href="statistics.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">assessment</i>Statistics</a>
               <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">settings</i>Settings</a>              
               <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help_outline</i>Help</a>
            </nav>
         </div>
         <main class="mdl-layout__content mdl-color--grey-100">
            <!-- Button Turn off everything  -->
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="position:fixed; right:35px; bottom:20px;" onclick="turnoff()" id="btnturnoff"> All off </button>
            <div class="mdl-grid portfolio-max-width">
               <!-- Living room -->
               <div class="mdl-cell mdl-cell--12-col" style="margin-top:10px;">
                  <h2 class="mdl-card__title-text" style="display:inline-block;
                     vertical-align:middle;"><img src="images/64x64/weather.png" style="margin-right: 12px;">
                     </img>Weather
                  </h2>
               </div>
               <!-- LIGHTS & WINDOWS --> 		
               <div class="mdl-cell mdl-cell--6-col">
               
			   <!-- weather widget start --><div id="m-booked-weather-bl250-76780"> <div class="booked-wzs-250-175 weather-customize" style="background-color:#1a487a;width:430px;" id="width3"> <div class="booked-wzs-250-175_in"> <div class="booked-wzs-250-175-data"> <div class="booked-wzs-250-175-left-img wrz-03"> <a target="_blank" href="http://www.booked.net/"> <img src="//s.bookcdn.com/images/letter/logo.gif" alt="booked.net" /> </a> </div> <div class="booked-wzs-250-175-right"> <div class="booked-wzs-day-deck"> <div class="booked-wzs-day-val"> <div class="booked-wzs-day-number"><span class="plus">+</span>27</div> <div class="booked-wzs-day-dergee"> <div class="booked-wzs-day-dergee-val">&deg;</div> <div class="booked-wzs-day-dergee-name">C</div> </div> </div> <div class="booked-wzs-day"> <div class="booked-wzs-day-d">H: <span class="plus">+</span>30&deg;</div> <div class="booked-wzs-day-n">L: <span class="plus">+</span>22&deg;</div> </div> </div> <div class="booked-wzs-250-175-info"> <div class="booked-wzs-250-175-city">Paris </div> <div class="booked-wzs-250-175-date">Sunday, 28 May</div> <div class="booked-wzs-left"> <span class="booked-wzs-bottom-l">See 7-Day Forecast</span> </div> </div> </div> </div> <a target="_blank" href="http://www.booked.net/weather/paris-18145"> <table cellpadding="0" cellspacing="0" class="booked-wzs-table-250"> <tr> <td>Mon</td> <td>Tue</td> <td>Wed</td> <td>Thu</td> <td>Fri</td> <td>Sat</td> </tr> <tr> <td class="week-day-ico"><div class="wrz-sml wrzs-18"></div></td> <td class="week-day-ico"><div class="wrz-sml wrzs-18"></div></td> <td class="week-day-ico"><div class="wrz-sml wrzs-18"></div></td> <td class="week-day-ico"><div class="wrz-sml wrzs-18"></div></td> <td class="week-day-ico"><div class="wrz-sml wrzs-18"></div></td> <td class="week-day-ico"><div class="wrz-sml wrzs-18"></div></td> </tr> <tr> <td class="week-day-val"><span class="plus">+</span>27&deg;</td> <td class="week-day-val"><span class="plus">+</span>23&deg;</td> <td class="week-day-val"><span class="plus">+</span>23&deg;</td> <td class="week-day-val"><span class="plus">+</span>26&deg;</td> <td class="week-day-val"><span class="plus">+</span>27&deg;</td> <td class="week-day-val"><span class="plus">+</span>22&deg;</td> </tr> <tr> <td class="week-day-val"><span class="plus">+</span>18&deg;</td> <td class="week-day-val"><span class="plus">+</span>17&deg;</td> <td class="week-day-val"><span class="plus">+</span>15&deg;</td> <td class="week-day-val"><span class="plus">+</span>18&deg;</td> <td class="week-day-val"><span class="plus">+</span>20&deg;</td> <td class="week-day-val"><span class="plus">+</span>16&deg;</td> </tr> </table> </a> </div> </div><script type="text/javascript"> var css_file=document.createElement("link"); css_file.setAttribute("rel","stylesheet"); css_file.setAttribute("type","text/css"); css_file.setAttribute("href",'https://s.bookcdn.com/css/w/booked-wzs-widget-275.css?v=0.0.1'); document.getElementsByTagName("head")[0].appendChild(css_file); function setWidgetData(data) { if(typeof(data) != 'undefined' && data.results.length > 0) { for(var i = 0; i < data.results.length; ++i) { var objMainBlock = document.getElementById('m-booked-weather-bl250-76780'); if(objMainBlock !== null) { var copyBlock = document.getElementById('m-bookew-weather-copy-'+data.results[i].widget_type); objMainBlock.innerHTML = data.results[i].html_code; if(copyBlock !== null) objMainBlock.appendChild(copyBlock); } } } else { alert('data=undefined||data.results is empty'); } } </script> <script type="text/javascript" charset="UTF-8" src="https://widgets.booked.net/weather/info?action=get_weather_info&ver=6&cityID=18145&type=3&scode=124&ltid=3458&domid=&anc_id=6932&cmetric=1&wlangID=1&color=1a487a&wwidth=430&header_color=ffffff&text_color=333333&link_color=08488D&border_form=1&footer_color=ffffff&footer_text_color=333333&transparent=0"></script><!-- weather widget end -->
			   
				</div>   				
			
            </div> <!-- End portfolio-max-width-->
         </main>
      </div>
      <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
   </body>
</html>