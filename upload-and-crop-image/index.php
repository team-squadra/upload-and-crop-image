<html>  
    <head>  
        <title>Make Price Range Slider using JQuery with PHP Ajax</title>  
		
		<script src="jquery.min.js"></script>  
		<script src="bootstrap.min.js"></script>
		<script src="croppie.js"></script>
		<link rel="stylesheet" href="bootstrap.min.css" />
		<link rel="stylesheet" href="croppie.css" />
    </head>  
    <body>  
        <div class="container">
          <br />
      <h3 align="center">Image Crop & Upload using JQuery with PHP Ajax</h3>
      <br />
      <br />
			<div class="panel panel-default">
  				<div class="panel-heading">Select Profile Image</div>
  				<div class="panel-body" align="center">
  					<input type="file" name="upload_image" id="upload_image" />
  					<br />
            <div id="uploaded_image"></div>
  				</div>
  			</div>
  		</div>
    </body>  
</html>

<div id="uploadimageModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" style=" height: 500px;">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title">Crop & Upload Image</h4>
      		</div>
      		<div class="modal-body">
        		<div class="row">
  					<div class="col-md-8 text-center">
						  <div id="image_demo" style="width:350px; margin-top:30px"></div>
  					</div>
  					<div class="col-md-4" style="padding-top:30px;">
  						<br />
  						<br />
  						<br/>
						  <button class="btn btn-success crop_image">Crop & Upload Image</button>
					</div>
				</div>
      		</div>
    	</div>
    </div>
</div>



<div>
  <form method="post">

    <button id="info_button"  name="gg">sfsdfsdf</button>

  </form>
</div>

<script>  
$(document).ready(function(){

	$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:200,
      type:'square' //circle
    },
    boundary:{
      width:300,
      height:300
    }
  });

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  }); 

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"upload.php",
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
          $('#uploadimageModal').modal('hide');
          $('#uploaded_image').html(data);
        }
      });
    })
  });

});  
</script>


<?php
if(isset($_POST["gg"]))
{
// Create connection
$conn = new mysqli("localhost", 'root', '','img');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM image";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo "<table>";
    while($row = $result->fetch_assoc()) {
        echo '
        <tr>
          <td><img src="data:image/png;base64,'.base64_encode($row["image"]).'"/></td>
        </tr>

        ';
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
}
?>