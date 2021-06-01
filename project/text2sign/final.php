<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="GILL" >
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="js/ie-emulation-modes-warning.js"></script>
<link href="https://fonts.googleapis.com/css?family=Baloo" rel="stylesheet"> 
<link href="css/custom.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  <title>ISL : Avatar Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Access-Control-Allow-Origin" content="*">
<meta http-equiv="Access-Control-Allow-Methods" content="GET">
<link rel="stylesheet" href="css/cwasa.css">
<script type="text/javascript" src="avatar_files/allcsa.js"></script>
<!-- <link rel="stylesheet" href="http://vhg.cmp.uea.ac.uk/tech/jas/vhg2021/cwa/cwasa.css" /> -->
<!-- <script type="text/javascript" src="http://vhg.cmp.uea.ac.uk/tech/jas/vhg2021/cwa/allcsa.js"></script> -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript">
/*
  TUavatarLoaded : Global variable to tell if avatar is loaded or not

  This will be set to TRUE in allcsa.js after the avatar
  would have loaded successfully
*/
var TUavatarLoaded = false;

/*
  avatarbusy : Binary lock variable to be checked before
  giving control to next word to be played  
*/
var avatarbusy = false;

</script>
</head>
<body onload="CWASA.init();">
<div class="container-flex" id="avatar_wrapper" style="display:none;">
    
    <div style="width:800px; margin:0 auto;">
    <div class="CWASAPanel av0" >
        <div class="divAv av0">
          <canvas class="canvasAv av0" ondragstart="return false" width="411" height="443"></canvas>
        </div> 
      </div>
    </div>

    <br>
    <br>
    <br>
    <div style="width:800px; margin:0 auto;">
    <br>
            <label>Enter text</label>
            <textarea id="engtext" class="form-control" style="height:80px;"></textarea><br>
            <button type="button" id="playeng" class="btn btn-dark">Play</button>
    </div>
    
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
/*
  Hide debugger
*/

/*
  Global SigmlData is a 
  javascript object
*/
var SigmlData;
var lookup = {};

$(document).ready(function() {

  var loadingTout = setInterval(function() {
      if(TUavatarLoaded) {
        clearInterval(loadingTout);
        console.log("MSG: Avatar loaded successfully !");

        setTimeout(function() {
          /*
            When the avatar has loaded
            the loading message is hidden and main wrapper is shown
          */
          $("#loading").hide();
          $(".divCtrlPanel").hide();
          $("#avatar_wrapper").show();

          /*
            As the avatar is shown a hello test is started
            in order to load all the avatar playing dependencies
          */
          console.log("MSG: Starting hello test.");
          // $("#currentWord").text("Hello");
        //   $(".txtaSiGMLText").val('<sigml><hns_sign gloss="d"><hamnosys_nonmanual></hamnosys_nonmanual><hamnosys_manual><hamparbegin/><hamcee12/><hamplus/><hamfinger2/><hamthumbacrossmod/><hamparend/><hamparbegin/><hamextfingeru/><hampalml/><hamplus/><hamextfingeru/><hampalmr/><hamparend/><hamparbegin/><hamindexfinger/><hamfingerside/><hamplus/><hamfingertip/><hamthumb/><hamindexfinger/><hamparend/><hamtouch/><hamchest/></hamnosys_manual></hns_sign></sigml>');


          
        //   $(".txtaSiGMLText").val('<sigml><hns_sign gloss="b"><hamnosys_nonmanual></hamnosys_nonmanual><hamnosys_manual><hamsymmlr/><hampinchopen/><hamextfingeru/><hampalml/><hamparbegin/><hamfingertip/><hamthumb/><hamindexfinger/><hamplus/><hamfingertip/><hamthumb/><hamindexfinger/><hamparend/><hamtouch/><hamchest/><hamclose/></hamnosys_manual></hns_sign></sigml>');
          
          // $(".txtaSiGMLText").val('<sigml><hns_sign gloss="hello"><hamnosys_nonmanual><hnm_mouthpicture picture="hVlU"/></hamnosys_nonmanual><hamnosys_manual><hamflathand/><hamthumboutmod/><hambetween/><hamfinger2345/><hamextfingeru/><hampalmd/><hamshouldertop/><hamlrat/><hamarmextended/><hamswinging/><hamrepeatfromstart/></hamnosys_manual></hns_sign></sigml>');
          // $(".bttnPlaySiGMLText").click();
          console.log("MSG: Ending hello test");
      
          /*
            After the hello has been played the main control 
            panel is displayed      
          */
          setTimeout(function() {
            $("#hellomsg").hide();
            $("#leftSide").slideDown();
          }, 100);
    
        }, 60);
      }
  }, 20);

  // keep loading things here
  // load all sigml files into cache

  $.getJSON( "SignFiles/signdump.json", function( data ) {
    SigmlData = data;

    // make the lookup table
    for (i = 0, len = SigmlData.length; i < len; i++) {
        lookup[SigmlData[i].w] = SigmlData[i].s;
    }
  });

});  

alltabhead = ["menu1-h"];
alltabbody = ["menu1"];

function activateTab(tabheadid, tabbodyid)
{
    for(x = 0; x < alltabhead.length; x++)
        $("#"+alltabhead[x]).css("background-color", "white");
    $("#"+tabheadid).css("background-color", "#d5d5d5");
    for(x = 0; x < alltabbody.length; x++)
        $("#"+alltabbody[x]).hide();
    $("#"+tabbodyid).show();
	
}


// clear button code
$("#btnClearEng").click(function(){
    $("#engtext").val("");
});
/*
  Code for the avatar player goes here
*/

/*
  When play english button is clicked
*/
$("#playeng").click(function() {

  console.log("Started parsing");

  input = $("#engtext").val().trim().replace(/\r?\n/g, ' '); // change newline to space while reading

  if(input.length == 0)
    return;

  input = input.toLocaleLowerCase();

  console.log("sending request to get root words");

  $.getJSON( "lemmatizer/lemstem.php?l=" + input, function(data) {
    console.log("Got root words");
    console.log(data);
    $("#debugger").text("Play sequence " + JSON.stringify(data));

    /*
      Code to play avatar
    */
  
    playseq = Array();
    for(i = 0; i < data.length; i++)
      playseq.push(data[i]);

    // start playing only if length of data received
    // was more than 0

    if(data.length > 0) {
      var playtimeout = setInterval(function() {

          if(playseq.length == 0 || data.length == 0) {
            clearInterval(playtimeout);
            console.log("Clear play interval");
            avatarbusy=false;
            return;
          }

          if(avatarbusy == false) {
            avatarbusy = true; // this is set to flase in allcsa.js      

            word2play = playseq.shift();    
            // weblog("Playing sign :" + word2play);
            if(lookup[word2play]==null) {
            //   weblog("<span style='color:red;'>SiGML not available for word : " + word2play + "</span>");
              avatarbusy=false;
              
              // break word2play into chars and unshift them to playseq
                for(i = word2play.length - 1; i >= 0; i--)
                  playseq.unshift(word2play[i]);
            

            } else {
              data2play = lookup[word2play];
              console.log(data2play);
              $("#currentWord").text(word2play);
              $(".txtaSiGMLText").val(data2play);
              $(".bttnPlaySiGMLText").click();
            }
          } else {
            console.log("Avatar is still busy");

            // check if error occured then reset the avatar to free
            errtext = $(".statusExtra").val();
            if(errtext.indexOf("invalid") != -1) {
            //   weblog("<span style='color:red;'>Error: " + errtext + "</span>");
              avatarbusy = false;
            }
          }
      }, 500);
    }

  });

});


/*
  function to play example sentences
*/
function playsign(line)
{
  $("#engtext").val(line);
  $("#playeng").click();
}

/*window.onerror = function() {
    alert("Error caught");
};*/
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113307373-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-113307373-1');
</script>

</body></html>
