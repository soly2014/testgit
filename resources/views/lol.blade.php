<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Loading overlay-load - Demo by Roko C.B</title>
  <style type="text/css">
      
      *{margin:0;}

body{
  font: 200 16px/1 Helvetica, Arial, sans-serif;
}

img{width:32.2%;}

#overlay-load{
  position:fixed;
  z-index:99999;
  top:0;
  left:0;
  bottom:0;
  right:0;
  background:rgba(0,0,0,0.9);
  transition: 1s 0.4s;
}
#progress-load{
  height:1px;
  background:#fff;
  position:absolute;
  width:0;
  top:50%;
}
#progstat{
  font-size:0.7em;
  letter-spacing: 3px;
  position:absolute;
  top:50%;
  margin-top:-40px;
  width:100%;
  text-align:center;
  color:#fff;
}
  </style>
</head>
<body>

  

      <div id="overlay-load">
        <div id="progstat"></div>
        <div id="progress-load"></div>
      </div>

      <div id="container">
        <img src="http://placehold.it/3000x3000/cf5">
        <img src="http://placehold.it/3000x3000/f0f">
        <img src="http://placehold.it/3000x3000/fb1">
        <img src="http://placehold.it/3000x3000/ada">
        <img src="http://placehold.it/3000x3000/045">
        <img src="http://placehold.it/3000x3000/b00">
        <img src="http://placehold.it/3000x3000/41b">
        <img src="http://errrrrrrrrrror.it/errorImage">
        <img src="http://placehold.it/3000x3000/098">
        <img src="http://placehold.it/3000x3000/987">
        <img src="http://placehold.it/3000x3000/f25">
        <img src="http://placehold.it/3000x3000/526">
        <img src="http://placehold.it/3000x3000/826">
        <img src="http://placehold.it/3000x3000/ad6">
        <img src="http://placehold.it/3000x3000/74c">
        <img src="http://placehold.it/3000x3000/b40">
        <img src="http://placehold.it/3000x3000/cc7">
        <img src="http://placehold.it/3000x3000/112">
        <img src="http://placehold.it/3000x3000/113">
      </div>
  
  
    
      <script type="text/javascript">
          ;(function(){
  function id(v){return document.getElementById(v); }
  function loadbar() {
    var ovrl = id("overlay-load"),
        prog = id("progress-load"),
        stat = id("progstat"),
        img = document.images,
        c = 0;
        tot = img.length;

    function imgLoaded(){
      c += 1;
      var perc = ((100/tot*c) << 0) +"%";
      prog.style.width = perc;
      stat.innerHTML = "Loading "+ perc;
      if(c===tot) return doneLoading();
    }
    function doneLoading(){
      ovrl.style.opacity = 0;
      setTimeout(function(){ 
        ovrl.style.display = "none";
      }, 1200);
    }
    for(var i=0; i<tot; i++) {
      var tImg     = new Image();
      tImg.onload  = imgLoaded;
      tImg.onerror = imgLoaded;
      tImg.src     = img[i].src;
    }    
  }
  document.addEventListener('DOMContentLoaded', loadbar, false);
}());
      </script>

</body>
</html>