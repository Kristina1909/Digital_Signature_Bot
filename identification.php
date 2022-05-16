<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ідентифікація</title>
</head>
<body onload = "configure();">
<div class="container">
    <div id="my_camera">

    </div>
    <div id="results" style="visibility: hidden; position: absolute;">

    </div>

    <button type="button" onclick="saveSnap();">Save</button>
</div>


<script type="text/javascript" src="assets/webcam.min.js"></script>
<script type="text/javascript">
    function configure(){
        Webcam.set({
            width: 480,
            height: 360,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('#my_camera');
    }

    function saveSnap(){
        Webcam.snap(function(data_uri){
            document.getElementById('results').innerHTML = '<img id = "webcam" src = "'+data_uri+'">'
        });

        Webcam.reset();

        var identification_image = document.getElementById("webcam").src;
        Webcam.upload(identification_image, 'function_id.php', function (code, text){
            alert('Фото успішно збережено, поверніться в бот!');
        });
    }
</script>
</body>
</html>

