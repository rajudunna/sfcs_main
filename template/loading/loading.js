 // Loading Start

 function myLoad1() {
     document.getElementById("overlay").style.display = 'block';
     document.getElementById("load1").style.display = 'inline';
     document.getElementById("load2").style.display = 'none';
     document.getElementById("load3").style.display = 'none';
     document.getElementById("load4").style.display = 'none';
     document.getElementById("load5").style.display = 'none';
 }

 function myLoad2() {
     document.getElementById("overlay").style.display = 'block';
     document.getElementById("load2").style.display = 'inline';
     document.getElementById("load1").style.display = 'none';
     document.getElementById("load3").style.display = 'none';
     document.getElementById("load4").style.display = 'none';
     document.getElementById("load5").style.display = 'none';
 }

 function myLoad3() {
     document.getElementById("overlay").style.display = 'block';
     document.getElementById("load3").style.display = 'inline';
     document.getElementById("load1").style.display = 'none';
     document.getElementById("load2").style.display = 'none';
     document.getElementById("load4").style.display = 'none';
     document.getElementById("load5").style.display = 'none';
 }

 function myLoad4() {
     document.getElementById("overlay").style.display = 'block';
     document.getElementById("load4").style.display = 'inline';
     document.getElementById("load1").style.display = 'none';
     document.getElementById("load2").style.display = 'none';
     document.getElementById("load3").style.display = 'none';
     document.getElementById("load5").style.display = 'none';
 }

 function myLoad5() {
     document.getElementById("overlay").style.display = 'block';
     document.getElementById("load5").style.display = 'inline';
     document.getElementById("load1").style.display = 'none';
     document.getElementById("load2").style.display = 'none';
     document.getElementById("load3").style.display = 'none';
     document.getElementById("load4").style.display = 'none';
 }

 // Loading Stop
 function myLoadStop() {
     document.getElementById("overlay").style.display = 'none';
     document.getElementById("load1").style.display = 'none';
     document.getElementById("load2").style.display = 'none';
     document.getElementById("load3").style.display = 'none';
     document.getElementById("load4").style.display = 'none';
     document.getElementById("load5").style.display = 'none';
 }