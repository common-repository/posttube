/*  JavaScript for postTube
 *  version 1.1
 *  (c) 2008 Alakhnor
 *--------------------------------------------------------------------------*/

	var Urls = new Array();
	var Imgs = new Array();
	var Thbs = new Array();
	var Ids = new Array();
	var Cpts = new Array();
	var Icns = new Array();
	var Event = 'play';
	var CurrentFile = "";

	function showTags(xmlDoc, theTag, thePlace) {

		function getTag(tag) { 
			var tmp='';
			xx=x[i].getElementsByTagName(tag);     
			try { tmp=xx[0].firstChild.data; } 
			catch(er) { tmp=''; }    
			return(tmp); 
		}

		var xx; var x; var txt;
		x = xmlDoc.getElementsByTagName(theTag);
		txt='<a id="playlisttop"></a><table class="vidtable">'; 

		try {
			for (i=0; i<x.length; i++) {
	 
				Urls[i]=getTag("location"); Imgs[i]=getTag("image"); Thbs[i]=getTag("thumb"); Ids[i]=getTag("id"); Cpts[i]=getTag("counter"); Icns[i]=getTag("icons");  //getTag("title"); getTag("creator"); getTag("info");

				txt+='<tr style="width: '+trwidth+'px" onclick="play('+i+')" title="'+Titlemsg+'" class="playlistlo" onmouseover="this.className = \'playlisthi\';" onmouseout="this.className = \'playlistlo\';">';
				if (showthumb) {
					txt+='<td><img src="'+getTag("thumb")+'" class="vidthumb" style="width: '+tdwidth+'px; height: '+tdheight+'px;" alt="Click to Play"></td>';
				}
				txt+='<td class="vidtd" style="width: '+vidtdwidth+'px; height: '+tdheight+'px;" ><p><b>'+getTag("title")+'</b>'
				if (showthumb) txt+='<br>'; else txt+='&nbsp;';
				txt+=bystring+getTag("creator");
				if (showthumb) txt+='<br>'; else txt+='&nbsp;-&nbsp;';
				txt+=viewstring+getTag("counter")+timestring;
				txt+='</p>';
				txt+='</td></tr>';
			}
		} catch(e) {};

		txt+="</table>";

		jQuery(thePlace).html(txt);

	}

	function createPlayer(theFile, theImg, theID, start, icons) {

		var s = new SWFObject(playerpath,"mpl",pwidth,pheight,"7");
		s.addParam("allowfullscreen", "true");
		s.addParam("wmode", "transparent");
		s.addVariable("file", theFile);
		s.addVariable("width", pwidth);
		s.addVariable("height", pheight);
		s.addVariable("backcolor", "0x000000");
		s.addVariable("screencolor", "0x000000");
		s.addVariable("displaywidth", pwidth);
		s.addVariable("displayheight", pheight);
		s.addVariable("id", theID);
		s.addVariable("callback", callbackref);
		s.addVariable("enablejs", "true");
		s.addVariable("javascriptid", "mpl"); 
		if (start) s.addVariable("autostart", "true");
		if (!icons) s.addVariable("showicons", "false");
		if (theImg != "") s.addVariable("image", theImg);
		s.write("placeholder");
	}

	function play(number) {
		var ext = get_extension(Urls[number]);
		if (CurrentFile == Urls[number]) {
			sendEvent("playpause", 0);		
		} else {
			CurrentFile = Urls[number];
			if (ext == '.mp3') {
				createPlayer(Urls[number], Imgs[number], Ids[number], true, Icns[number]);
			} else {
				createPlayer(Urls[number], "", Ids[number], true, Icns[number]);
			}
		}
	}

	function thisMovie(movieName) {
		if(navigator.appName.indexOf("Microsoft") != -1) {
			return window[movieName];
		} else {
			return document[movieName];
		}
	};

	function sendEvent(typ,prm) { thisMovie("mpl").sendEvent(typ,prm); };

	function loadXMLDoc(theFile) {
		var xmlDoc = jQuery.ajax({
			url: theFile,
			async: false
		}).responseXML.documentElement;
		showTags(xmlDoc, 'track', '#writeroot');
	}

	jQuery(document).ready(function() {
		jQuery(document).ready(function() {jQuery("#winicon1").jqDrag(); });
		loadXMLDoc(callbackInit);
		try{
		createPlayer(fileInit, imageInit, vidInit, false, IconInit);
		}
		catch(e){}
	});

        function get_extension(file) {
		if (file != "") {
			nbchar = file.length;
			extension = file.substring(nbchar-4,nbchar); 
			extension=extension.toLowerCase(); 
			return extension; 
		}
	}
