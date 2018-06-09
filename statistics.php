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
      <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header mdl-layout--fixed-tabs">
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
                  <li class="mdl-menu__item"><a href="logout.php" style="text-decoration: none;">Logout</a></li>
               </ul>
            </div>
            <!-- Tabs definition -->
            <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
               <a href="#fixed-tab-1" class="mdl-layout__tab is-active">Electric</a>
               <a href="#fixed-tab-2" class="mdl-layout__tab">Gas</a>
               <a href="#fixed-tab-3" class="mdl-layout__tab">Water</a>
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
                  <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
                     <li class="mdl-menu__item">User 2</li>
                     <li class="mdl-menu__item">User 3</li>
                     <li class="mdl-menu__item"><i class="material-icons">add</i>Add another account...</li>
                  </ul>
               </div>
            </header>
            <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
               <a class="mdl-navigation__link" href="home.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Home</a>
               <a class="mdl-navigation__link" href="profile.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">account_circle</i>Profile</a>
               <a class="mdl-navigation__link" href="weather.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">wb_sunny</i>Weather</a>
               <a class="mdl-navigation__link mdl-navigation__link--current" href="statistics.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">assessment</i>Statistics</a>
               <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">settings</i>Settings</a>              
               <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help_outline</i>Help</a>
            </nav>
         </div>
         <main class="mdl-layout__content mdl-color--grey-100">
            <!-- Button Turn off everything  -->
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="position:fixed; right:35px; bottom:20px;" onclick="turnoff()" id="btnturnoff"> All off </button>
            <!-- Tabs implementation -->
            <section class="mdl-layout__tab-panel is-active" id="fixed-tab-1">
               <div class="page-content">
                  <div class="mdl-grid portfolio-max-width">			  
                     <!-- Electric -->
                     <div class="mdl-cell mdl-cell--12-col" style="margin-top:10px; text-align:center;">
                        <h2 class="mdl-card__title-text" style="display:inline-block;
                           vertical-align:middle;"><img src="images/32x32/power.png" style="margin-right: 12px;">
                           </img>Electric energy consumption
                        </h2>
                     </div>		
                     <div class="mdl-cell mdl-cell--4-col"></div>		 
                     <!-- Living Room --> 		
                     <div class="mdl-cell mdl-cell--6-col; ">
                        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 100%;">
                           <thead>
                              <tr>
                                 <th class="mdl-data-table__cell--non-numeric">Room</th>
                                 <th>Energy Consumed (kWh)</th>
                                 <th>Cost ($)</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Living Room</td>
                                 <td>530</td>
                                 <td>$10.90</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Kitchen</td>
                                 <td>453</td>
                                 <td>$8.70</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Master Bedroom</td>
                                 <td>230</td>
                                 <td>$4.35</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Bedroom</td>
                                 <td>340</td>
                                 <td>$6.65</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Bathroom</td>
                                 <td>205</td>
                                 <td>$3.40</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Garden</td>
                                 <td>215</td>
                                 <td>$3.65</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>	 
                  </div>
                  <!-- End portfolio-max-width-->
               </div>
            </section>
            <section class="mdl-layout__tab-panel" id="fixed-tab-2">			
               <div class="page-content">
                  <div class="mdl-grid portfolio-max-width">
                     <!-- Gas -->
                     <div class="mdl-cell mdl-cell--12-col" style="margin-top:10px;text-align:center;">
                        <h2 class="mdl-card__title-text" style="display:inline-block;
                           vertical-align:middle;"><img src="images/32x32/gas.png" style="margin-right: 12px;">
                           </img>Gas consumption
                        </h2>
                     </div>
                     <div class="mdl-cell mdl-cell--4-col"></div>
                     <!-- Living Room --> 		
                     <div class="mdl-cell mdl-cell--6-col">
                        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                           <thead>
                              <tr>
                                 <th class="mdl-data-table__cell--non-numeric">Room</th>
                                 <th>Gas Consumed (kWh)</th>
                                 <th>Cost ($)</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Living Room</td>
                                 <td>530</td>
                                 <td>$10.90</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Kitchen</td>
                                 <td>453</td>
                                 <td>$8.70</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Master Bedroom</td>
                                 <td>230</td>
                                 <td>$4.35</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Bedroom</td>
                                 <td>340</td>
                                 <td>$6.65</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Bathroom</td>
                                 <td>205</td>
                                 <td>$3.40</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Garden</td>
                                 <td>215</td>
                                 <td>$3.65</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <!-- End portfolio-max-width-->
               </div>
            </section>
            <section class="mdl-layout__tab-panel" id="fixed-tab-3">
              <div class="page-content">
                  <div class="mdl-grid portfolio-max-width">
                     <!-- Water -->
                     <div class="mdl-cell mdl-cell--12-col" style="margin-top:10px;text-align:center;">
                        <h2 class="mdl-card__title-text" style="display:inline-block;
                           vertical-align:middle;"><img src="images/32x32/drop.png" style="margin-right: 12px;">
                           </img>Water consumption
                        </h2>
                     </div>
                     <div class="mdl-cell mdl-cell--4-col"></div>
                     <!-- Living Room --> 		
                     <div class="mdl-cell mdl-cell--6-col">
                        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                           <thead>
                              <tr>
                                 <th class="mdl-data-table__cell--non-numeric">Room</th>
                                 <th>Water Consumed (litres)</th>
                                 <th>Cost ($)</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Living Room</td>
                                 <td>530</td>
                                 <td>$10.90</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Kitchen</td>
                                 <td>453</td>
                                 <td>$8.70</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Master Bedroom</td>
                                 <td>230</td>
                                 <td>$4.35</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Bedroom</td>
                                 <td>340</td>
                                 <td>$6.65</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Bathroom</td>
                                 <td>205</td>
                                 <td>$3.40</td>
                              </tr>
                              <tr>
                                 <td class="mdl-data-table__cell--non-numeric">Garden</td>
                                 <td>215</td>
                                 <td>$3.65</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <!-- End portfolio-max-width-->
               </div>
            </section>
         </main>
      </div>
      <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
   </body>
</html>