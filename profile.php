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
      <link rel="stylesheet" href="material.cyan-light_blue.min.css">
      <link rel="stylesheet" href="styles.css">
	  <!-- jquery -->
	<script src="jquery-3.2.1.min.js"></script>
<script>
/* Set appliances according to xml file of current state
	IMPORTANT: 1) needs to be outside of (document).ready because it needs to set everything before it shows
	2) Each device must be of the class corresponding to the room in XML, and the id corresponding to the appliance + "-state" if its on/off or "-value" if it can be regulated.
*/
	refreshState()
         
         function refreshState(){
	$.ajax({
					type:"GET",
					url: "users.xml",  //LOAD USER SETTINGS
					dataType: "xml",
					success: function(xml){
					$(xml).find('user').each(function(){ //for each user
					if ($(this).attr('id') == "<?php echo $_SESSION['logged_user']; ?>"){ //take current user (ex:user1)
								$(this).find('room').each(function(){ //for each room						
									var roomid = $(this).attr('id');			
									//Set lights
									$(this).find('appliance').each(function(){ 
										var state = $(this).find('state').text();
										if (state == "on"){							
											$("#" + $(this).attr('id') + "-state" + "." + roomid).attr("checked", true );
										}
										else {	
											$("#" + $(this).attr('id') + "-state" + "." + roomid).attr("checked", false );									
										}
										var value = $(this).find('value').text();
										$("#" + $(this).attr('id') + "-value" + "." + roomid).attr('value',value);												
									});									
								});
								}
								});
								
								
					},
					error: function(req,err) { console.log('el error es: ' + err); }
				  });
		 }; 
		 
		 
		 
		  /* Saves changes after setting preferences */
		function savechanges(){
				$.ajax({
					type:"GET",
					url: "users.xml",
					dataType: "xml",
					success: function(xml){
							$(xml).find('user').each(function(){ //for each user
							if ($(this).attr('id') == "<?php echo $_SESSION['logged_user']; ?>"){ //take current user (ex:user1)
								$(this).find('room').each(function(){ //for each room						
									var roomid = $(this).attr('id');		
									$(this).find('appliance').each(function(){ 	//for each appliance 
									  //set state
								       var newstate = $("#" + $(this).attr('id') + "-state" + "." + roomid).is(":checked") ? "on" : "off";		
									   $(this).find('state').text(newstate);
									  
									   //set value
									   var newvalue = $("#" + $(this).attr('id') + "-value" + "." + roomid).val();	
									 if(typeof newvalue != "undefined"){									 
									 	$(this).find('value').text(newvalue);
									 }		
										});									
									});
							}							
						});
						
						var xmlString=jQ_xmlDocToString($(xml)) //Convert xml to string
						
						/* send modified  xml string to server*/    
						$.post('save_user_changes.php', {xml:xmlString },function (response){console.log(response)},'text')
						
					},
					error: function(req,err) { console.log('el error es: ' + err); }
				  });
			};
			
			
			/* Converts xml to string */
		  function jQ_xmlDocToString($xml) {
			/* unwrap xml document from jQuery*/
			var doc = $xml[0];
			var string;
			/* for IE*/
			if(window.ActiveXObject) {
				string = doc.xml;
			}
			// code for Mozilla, Firefox, Opera, etc.
			else {
				string = (new XMLSerializer()).serializeToString(doc);
			}
			return string;
			}
				  
$(document).ready(function()
      { 
	 //	
});
</script>
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
                  <li class="mdl-menu__item"><a href="logout.php" style="text-decoration: none;">Logout</a></li>
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
                  <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
                     <li class="mdl-menu__item">User 2</li>
                     <li class="mdl-menu__item">User 3</li>
                     <li class="mdl-menu__item"><i class="material-icons">add</i>Add another account...</li>
                  </ul>
               </div>
            </header>
            <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
               <a class="mdl-navigation__link" href="home.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Home</a>
               <a class="mdl-navigation__link mdl-navigation__link--current" href="profile.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">account_circle</i>Profile</a>
               <a class="mdl-navigation__link" href="weather.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">wb_sunny</i>Weather</a>
               <a class="mdl-navigation__link" href="statistics.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">assessment</i>Statistics</a>
               <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">settings</i>Settings</a>              
               <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help_outline</i>Help</a>
            </nav>
         </div>
         <main class="mdl-layout__content mdl-color--grey-100">
            <!-- Button Save Changes  -->
			<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="position:fixed; right:35px; top:100px;" onclick="savechanges()" id="btnsave"> Save Changes </button>			
            <div class="mdl-grid portfolio-max-width">
               <!-- Living room -->
               <div class="mdl-cell mdl-cell--12-col" style="margin-top:10px;">
                  <h2 class="mdl-card__title-text" style="display:inline-block;
                     vertical-align:middle;"><img src="images/64x64/livingroom.png" style="margin-right: 12px;">
                     </img>Living room
                  </h2>
               </div>
               <!-- LIGHTS & WINDOWS --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/bulb.png" style="margin-right: 12px;"></img>Ceiling Lights</td>
						   <td>
                              <input class="mdl-slider mdl-js-slider livingroom" type="range" id="ceilinglights-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="ceilinglights-state">
                                 <input type="checkbox" id="ceilinglights-state" class="mdl-switch__input livingroom" checked>
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/bulb.png" style="margin-right: 12px;"></img>Table Lights</td>
						   <td>
                              <input class="mdl-slider mdl-js-slider livingroom" type="range" id="tablelights-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="tablelights-state">
                                 <input type="checkbox" id="tablelights-state" class="mdl-switch__input livingroom">
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/bulb.png" style="margin-right: 12px;"></img>Sofa Lights</td>
						   <td>
                              <input class="mdl-slider mdl-js-slider livingroom" type="range" id="sofalights-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="sofalights-state">
                                 <input type="checkbox" id="sofalights-state" class="mdl-switch__input livingroom" checked>
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/blinds.png" style="margin-right: 12px;"></img>Windows</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider livingroom" type="range" id="windows-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="windows-state">
                                 <input type="checkbox" id="windows-state" class="mdl-switch__input livingroom" checked>
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <!-- ENTERTAINEMENT  --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/tv.png" style="margin-right: 12px;"></img>TV</td>
                           <td>
                              <div  style="float:right;">
							  <input class="mdl-slider mdl-js-slider livingroom" id="tv-value" type="range"
                                 min="0" max="1" value="0.3" step="0.1">   
                              </div>  							 
                           </td>
                           <td> 	
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="tv-state">
                                 <input type="checkbox" id="tv-state" class="mdl-switch__input livingroom" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>  							  
                           </td>
                        </tr>						
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/loudspeakers.png" style="margin-right: 12px;"></img>Loudspeakers</td>
						    <td>
                              <div  style="float:right;">
							  <input class="mdl-slider mdl-js-slider livingroom" id="loudspeakers-value" type="range"
                                 min="0" max="1" value="0" step="0.1">   
                              </div>  							 
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="loudspeakers-state">
                                 <input type="checkbox" id="loudspeakers-state" class="mdl-switch__input livingroom" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>					
                     </tbody>
                  </table>
               </div>
               <!-- HEAT & VENT  --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/thermostat.png" style="margin-right: 12px;"></img>Thermostat</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider livingroom" type="range"
                                 min="16" max="28" value="21" step="1">                       
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="thermostat-state">
                                 <input type="checkbox" id="thermostat-state" class="mdl-switch__input livingroom" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>							   
                        </tr>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/ventilation.png" style="margin-right: 12px;"></img>Ventilation</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider livingroom" type="range"
                                 min="0" max="5" value="0" step="1">                       
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="ventilation-state">
                                 <input type="checkbox" id="ventilation-state" class="mdl-switch__input livingroom" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <!-- DOORS  --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/doorhandle.png" style="margin-right: 12px;"></img>Front Door</td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="frontdoor-state">
                                 <input type="checkbox" id="frontdoor-state" class="mdl-switch__input livingroom" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/doorhandle.png" style="margin-right: 12px;"></img>Back door</td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="backdoor-state">
                                 <input type="checkbox" id="backdoor-state" class="mdl-switch__input livingroom" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
			   
			   <!-- Kitchen -->
               <div class="mdl-cell mdl-cell--12-col" style="margin-top:10px;">
                  <h2 class="mdl-card__title-text" style="display:inline-block;
                     vertical-align:middle;"><img src="images/64x64/kitchen.png" style="margin-right: 12px;">
                     </img>Kitchen
                  </h2>
               </div>
               <!-- LIGHTS & WINDOWS --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/bulb.png" style="margin-right: 12px;"></img>Ceiling Lights</td>
						   <td>
                              <input class="mdl-slider mdl-js-slider kitchen" type="range" id="ceilinglights-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="ceilinglights-state">
                                 <input type="checkbox" id="ceilinglights-state" class="mdl-switch__input kitchen" checked>
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/bulb.png" style="margin-right: 12px;"></img>Table Lights</td>
						   <td>
                              <input class="mdl-slider mdl-js-slider kitchen" type="range" id="tablelights-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="tablelights-state">
                                 <input type="checkbox" id="tablelights-state" class="mdl-switch__input kitchen">
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>                       
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/blinds.png" style="margin-right: 12px;"></img>Windows</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider kitchen" type="range" id="windows-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="windows-state">
                                 <input type="checkbox" id="windows-state" class="mdl-switch__input kitchen" checked>
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
              <!-- ENTERTAINEMENT  --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/tv.png" style="margin-right: 12px;"></img>TV</td>
                           <td>
                              <div  style="float:right;">
							  <input class="mdl-slider mdl-js-slider kitchen" id="tv-value" type="range"
                                 min="0" max="1" value="0.3" step="0.1">   
                              </div>  							 
                           </td>
                           <td> 	
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="tv-state">
                                 <input type="checkbox" id="tv-state" class="mdl-switch__input kitchen" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>  							  
                           </td>
                        </tr>						
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/loudspeakers.png" style="margin-right: 12px;"></img>Loudspeakers</td>
						    <td>
                              <div  style="float:right;">
							  <input class="mdl-slider mdl-js-slider kitchen" id="loudspeakers-value" type="range"
                                 min="0" max="1" value="0" step="0.1">   
                              </div>  							 
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="loudspeakers-state">
                                 <input type="checkbox" id="loudspeakers-state" class="mdl-switch__input kitchen" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>					
                     </tbody>
                  </table>
               </div>
			   <!-- HEAT & VENT  --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/thermostat.png" style="margin-right: 12px;"></img>Thermostat</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider kitchen" type="range"
                                 min="16" max="28" value="21" step="1">                       
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="thermostat-state">
                                 <input type="checkbox" id="thermostat-state" class="mdl-switch__input kitchen" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>							   
                        </tr>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/ventilation.png" style="margin-right: 12px;"></img>Ventilation</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider kitchen" type="range"
                                 min="0" max="5" value="0" step="1">                       
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="ventilation-state">
                                 <input type="checkbox" id="ventilation-state" class="mdl-switch__input kitchen" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
                <!-- DOORS  --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/doorhandle.png" style="margin-right: 12px;"></img>Back door</td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="backdoor-state">
                                 <input type="checkbox" id="backdoor-state" class="mdl-switch__input kitchen" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
			   
			   <!-- Master Bedroom -->
               <div class="mdl-cell mdl-cell--12-col" style="margin-top:10px;">
                  <h2 class="mdl-card__title-text" style="display:inline-block;
                     vertical-align:middle;"><img src="images/64x64/bedroom.png" style="margin-right: 12px;">
                     </img>Master Bedroom
                  </h2>
               </div>
              <!-- LIGHTS & WINDOWS --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/bulb.png" style="margin-right: 12px;"></img>Ceiling Lights</td>
						   <td>
                              <input class="mdl-slider mdl-js-slider masterbedroom" type="range" id="ceilinglights-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="ceilinglights-state">
                                 <input type="checkbox" id="ceilinglights-state" class="mdl-switch__input masterbedroom" checked>
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/bulb.png" style="margin-right: 12px;"></img>Bed Lights</td>
						   <td>
                              <input class="mdl-slider mdl-js-slider masterbedroom" type="range" id="bedlights-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="bedlights-state">
                                 <input type="checkbox" id="bedlights-state" class="mdl-switch__input masterbedroom">
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>                       
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/blinds.png" style="margin-right: 12px;"></img>Windows</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider masterbedroom" type="range" id="windows-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="windows-state">
                                 <input type="checkbox" id="windows-state" class="mdl-switch__input masterbedroom" checked>
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <!-- ENTERTAINEMENT  --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/tv.png" style="margin-right: 12px;"></img>TV</td>
                           <td>
                              <div  style="float:right;">
							  <input class="mdl-slider mdl-js-slider masterbedroom" id="tv-value" type="range"
                                 min="0" max="1" value="0.3" step="0.1">   
                              </div>  							 
                           </td>
                           <td> 	
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="tv-state">
                                 <input type="checkbox" id="tv-state" class="mdl-switch__input masterbedroom" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>  							  
                           </td>
                        </tr>						
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/loudspeakers.png" style="margin-right: 12px;"></img>Loudspeakers</td>
						    <td>
                              <div  style="float:right;">
							  <input class="mdl-slider mdl-js-slider masterbedroom" id="loudspeakers-value" type="range"
                                 min="0" max="1" value="0" step="0.1">   
                              </div>  							 
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="loudspeakers-state">
                                 <input type="checkbox" id="loudspeakers-state" class="mdl-switch__input masterbedroom" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>					
                     </tbody>
                  </table>
               </div>
			  <!-- HEAT & VENT  --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/thermostat.png" style="margin-right: 12px;"></img>Thermostat</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider masterbedroom" type="range"
                                 min="16" max="28" value="21" step="1">                       
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="thermostat-state">
                                 <input type="checkbox" id="thermostat-state" class="mdl-switch__input masterbedroom" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>							   
                        </tr>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/ventilation.png" style="margin-right: 12px;"></img>Ventilation</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider masterbedroom" type="range"
                                 min="0" max="5" value="0" step="1">                       
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="ventilation-state">
                                 <input type="checkbox" id="ventilation-state" class="mdl-switch__input masterbedroom" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
			   <!-- DOORS  --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/doorhandle.png" style="margin-right: 12px;"></img>Door</td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="door-state">
                                 <input type="checkbox" id="door-state" class="mdl-switch__input masterbedroom" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
			   
               <!-- Bedroom 2 -->
               <div class="mdl-cell mdl-cell--12-col" style="margin-top:10px;">
                  <h2 class="mdl-card__title-text" style="display:inline-block;
                     vertical-align:middle;"><img src="images/64x64/bedroom.png" style="margin-right: 12px;">
                     </img> Bedroom 2
                  </h2>
               </div>
              <!-- LIGHTS & WINDOWS --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/bulb.png" style="margin-right: 12px;"></img>Ceiling Lights</td>
						   <td>
                              <input class="mdl-slider mdl-js-slider bedroom2" type="range" id="ceilinglights-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="ceilinglights-state">
                                 <input type="checkbox" id="ceilinglights-state" class="mdl-switch__input bedroom2" checked>
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/bulb.png" style="margin-right: 12px;"></img>Bed Lights</td>
						   <td>
                              <input class="mdl-slider mdl-js-slider bedroom2" type="range" id="bedlights-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="bedlights-state">
                                 <input type="checkbox" id="bedlights-state" class="mdl-switch__input bedroom2">
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>                       
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/blinds.png" style="margin-right: 12px;"></img>Windows</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider bedroom2" type="range" id="windows-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="windows-state">
                                 <input type="checkbox" id="windows-state" class="mdl-switch__input bedroom2" checked>
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <!-- ENTERTAINEMENT  --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/tv.png" style="margin-right: 12px;"></img>TV</td>
                           <td>
                              <div  style="float:right;">
							  <input class="mdl-slider mdl-js-slider bedroom2" id="tv-value" type="range"
                                 min="0" max="1" value="0.3" step="0.1">   
                              </div>  							 
                           </td>
                           <td> 	
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="tv-state">
                                 <input type="checkbox" id="tv-state" class="mdl-switch__input bedroom2" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>  							  
                           </td>
                        </tr>						
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/loudspeakers.png" style="margin-right: 12px;"></img>Loudspeakers</td>
						    <td>
                              <div  style="float:right;">
							  <input class="mdl-slider mdl-js-slider bedroom2" id="loudspeakers-value" type="range"
                                 min="0" max="1" value="0" step="0.1">   
                              </div>  							 
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="loudspeakers-state">
                                 <input type="checkbox" id="loudspeakers-state" class="mdl-switch__input bedroom2" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>					
                     </tbody>
                  </table>
               </div>
			  <!-- HEAT & VENT  --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/thermostat.png" style="margin-right: 12px;"></img>Thermostat</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider bedroom2" type="range"
                                 min="16" max="28" value="21" step="1">                       
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="thermostat-state">
                                 <input type="checkbox" id="thermostat-state" class="mdl-switch__input bedroom2" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>							   
                        </tr>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/ventilation.png" style="margin-right: 12px;"></img>Ventilation</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider bedroom2" type="range"
                                 min="0" max="5" value="0" step="1">                       
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="ventilation-state">
                                 <input type="checkbox" id="ventilation-state" class="mdl-switch__input bedroom2" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>			   
			   
			   <!-- Bathroom -->
               <div class="mdl-cell mdl-cell--12-col" style="margin-top:10px;">
                  <h2 class="mdl-card__title-text" style="display:inline-block;
                     vertical-align:middle;"><img src="images/64x64/bathroom.png" style="margin-right: 12px;">
                     </img>Bathroom
                  </h2>
               </div>
               <!-- LIGHTS & WINDOWS --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/bulb.png" style="margin-right: 12px;"></img>Ceiling Lights</td>
						   <td>
                              <input class="mdl-slider mdl-js-slider bathroom" type="range" id="ceilinglights-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="ceilinglights-state">
                                 <input type="checkbox" id="ceilinglights-state" class="mdl-switch__input bathroom" checked>
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/bulb.png" style="margin-right: 12px;"></img>Mirror Lights</td>
						   <td>
                              <input class="mdl-slider mdl-js-slider bathroom" type="range" id="mirrorlights-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="mirrorlights-state">
                                 <input type="checkbox" id="mirrorlights-state" class="mdl-switch__input bathroom">
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>                       
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/blinds.png" style="margin-right: 12px;"></img>Windows</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider bathroom" type="range" id="windows-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="windows-state">
                                 <input type="checkbox" id="windows-state" class="mdl-switch__input bathroom" checked>
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <!-- HEAT & VENT  --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/thermostat.png" style="margin-right: 12px;"></img>Thermostat</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider bathroom" type="range"
                                 min="16" max="28" value="21" step="1">                       
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="thermostat-state">
                                 <input type="checkbox" id="thermostat-state" class="mdl-switch__input bathroom" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>							   
                        </tr>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/ventilation.png" style="margin-right: 12px;"></img>Ventilation</td>
                           <td>
                              <input class="mdl-slider mdl-js-slider bathroom" type="range"
                                 min="0" max="5" value="0" step="1">                       
                           </td>
						   <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="ventilation-state">
                                 <input type="checkbox" id="ventilation-state" class="mdl-switch__input bathroom" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>		
			  
			    <!-- Garden -->
               <div class="mdl-cell mdl-cell--12-col" style="margin-top:10px;">
                  <h2 class="mdl-card__title-text" style="display:inline-block;
                     vertical-align:middle;"><img src="images/64x64/garden.png" style="margin-right: 12px;">
                     </img>Garden
                  </h2>
               </div>
               <!-- LIGHTS & WINDOWS --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/bulb.png" style="margin-right: 12px;"></img>Lights</td>
						   <td>
                              <input class="mdl-slider mdl-js-slider garden" type="range" id="lights-value"
                                 min="0" max="1" value="0" step="0.1">                          
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="lights-state">
                                 <input type="checkbox" id="lights-state" class="mdl-switch__input garden" checked>
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
              <!-- ENTERTAINEMENT  --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>						
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/loudspeakers.png" style="margin-right: 12px;"></img>Loudspeakers</td>
						    <td>
                              <div  style="float:right;">
							  <input class="mdl-slider mdl-js-slider garden" id="loudspeakers-value" type="range"
                                 min="0" max="1" value="0" step="0.1">   
                              </div>  							 
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="loudspeakers-state">
                                 <input type="checkbox" id="loudspeakers-state" class="mdl-switch__input garden" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
						<tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/hottub.png" style="margin-right: 12px;"></img>Hot Tub</td>
						   <td>
                              <div  style="float:right;">
							  <input class="mdl-slider mdl-js-slider garden" id="hottube-value" type="range"
                                 min="0" max="1" value="0" step="0.1">   
                              </div>  							 
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="hottub-state">
                                 <input type="checkbox" id="hottub-state" class="mdl-switch__input garden" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>						
                     </tbody>
                  </table>
               </div>
               <!-- HEAT & VENT  --> 		
               <div class="mdl-cell mdl-cell--6-col">
                  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 85%;">
                     <tbody>
                        <tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/drop.png" style="margin-right: 12px;"></img>Sprinklers</td>
                            <td>
                              <div  style="float:right;">
							  <input class="mdl-slider mdl-js-slider garden" id="sprinklers-value" type="range"
                                 min="0" max="1" value="0" step="0.1">   
                              </div>  							 
                           </td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="sprinklers-state">
                                 <input type="checkbox" id="sprinklers-state" class="mdl-switch__input garden" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
						<tr>
                           <td class="mdl-data-table__cell--non-numeric"><img src="images/24x24/pool.png" style="margin-right: 12px;"></img>Pool Maintenance</td>
                           <td>
                              <div  style="float:right;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="pool-state">
                                 <input type="checkbox" id="pool-state" class="mdl-switch__input garden" >
                                 <span class="mdl-switch__label"></span>
                                 </label>
                              </div>
                           </td>
                        </tr>						
                     </tbody>
                  </table>
               </div>
			
            </div> <!-- End portfolio-max-width-->
         </main>
      </div>
      <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
   </body>
</html>