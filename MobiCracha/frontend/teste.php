<?php

echo "<h1>TESTE</h1>";

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<div id="telaPrint" style="background-color: #fff">
  <pre>
        dsadadadada
        asdadadsada
    
        adadada
    
        adadadasdada
      </pre>
</div>
<button onClick="gerarImagem()">img</button>

<script>

function gerarImagem(){           
    html2canvas(document.getElementById('telaPrint')).then(function (canvas) {
  var name = 'img-print';
  let xhr = new XMLHttpRequest();
  xhr.responseType = 'blob';
  xhr.onload = function () {
    let a = document.createElement('a');
    a.href = window.URL.createObjectURL(xhr.response);
    a.download = name + '.png';
    a.style.display = 'none';
    document.body.appendChild(a);
    a.click();
    a.remove()
  };
  xhr.open('GET', canvas.toDataURL("image/png", 1.0));
  xhr.send();
});

}
</script>


<!-- 
<div id="capture" style="padding: 10px; background: #f5da55">
    <h4 style="color: #000; ">Hello world!</h4>
</div>

<script>
html2canvas(document.querySelector("#capture")).then(canvas => {
    document.body.appendChild(canvas)
});
</script> -->

<?php

/*
$im = imagegrabscreen();
        imagepng($im, "teste.png");
        // imagedestroy($im);


        // $im = imagecreatefrompng('example.png');
        $size = min(imagesx($im), imagesy($im));
        $im2 = imagecrop($im, ['x' => 0, 'y' => 0, 'width' => 280, 'height' => 450]);
        if ($im2 !== FALSE) {
            imagepng($im2, 't.png');
            imagedestroy($im2);
        }
        imagedestroy($im);

        */