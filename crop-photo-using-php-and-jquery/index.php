<!--
* Author : Ali Aboussebaba
* Email : bewebdeveloper@gmail.com
* Website : http://www.bewebdeveloper.com
* Subject : Crop photo using PHP and jQuery
-->
<!DOCTYPE html>
<html lang="en">
<head>
<title>Crop photo using PHP and jQuery</title>
<style type="text/css">
* {
    margin: 0;
    padding: 0;
}
body {
    padding: 10px;
    background: #eaeaea;
    text-align: center;
    font-family: arial;
    font-size: 12px;
    color: #333333;
}
.container {
    width: 1000px;
    height: auto;
    background: #ffffff;
    border: 1px solid #cccccc;
    border-radius: 10px;
    margin: auto;
    text-align: left;
}
.header {
    padding: 10px;
}
.main_title {
    background: #cccccc;
    color: #ffffff;
    padding: 10px;
    font-size: 20px;
    line-height: 20px;
}
.content {
    padding: 50px 10px 10px 10px;
    min-height: 100px;
    text-align: center;
}
.upload_btn {
    background: #cccccc;
    color: #333333;
    border: 1px solid #999999;
    border-radius: 10px;
    font-size: 16px;
    line-height: 30px;
    font-weight: bold;
    display: inline-block;
    padding: 0 10px 0 10px;
    cursor: pointer;
}
#photo_container {
    padding: 50px 0 0 0;
}
.upload_btn:hover {
    background: #eaeaea;
}
/* footer --------------------------*/
.footer {
    padding: 10px;
    text-align: right;
}
.footer a {
    color: #999999;
    text-decoration: none;
}
.footer a:hover {
    text-decoration: underline;
}

/* popup --------------------------*/
#popup_upload,
#popup_crop {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0, 0 ,0, 0.7);
    z-index: 99;
    text-align: center;
    display: none;
    overflow: auto;
}
.form_upload {
    width: 300px;
    height: 140px;
    border: 1px solid #999999;
    border-radius: 10px;
    background: #ffffff;
    color: #666666;
    margin: auto;
    margin-top: 160px;
    padding: 10px;
    text-align: left;
    position: relative;
}
.form_upload h2 {
    border-bottom: 1px solid #999999;
    padding: 0 0 5px 0;
    margin: 0 0 20px 0;
}
.upload_frame {
    width: 0;
    height: 0;
    display: none;
}
.file_input {
    width: 97%;
    background: #eaeaea;
    border: 1px solid #999999;
    border-radius: 5px;
    color: #333333;
    padding: 1%;
    margin: 0 0 20px 0;
}
#upload_btn {
    background: #cccccc;
    color: #333333;
    border: 1px solid #999999;
    border-radius: 10px;
    float: right;
    line-height: 20px;
    font-size: 14px;
    font-weight: bold;
    font-family: arial;
    display: block;
    padding: 5px;
    cursor: pointer;
}
#upload_btn:hover {
    background: #eaeaea;
}
.close {
    position: absolute;
    display: block;
    right: 10px;
    cursor: pointer;
    font-size: 20px;
    line-height: 16px;
    width: 18px;
    height: 18px;
    border: 1px solid #cccccc;
    border-radius: 5px;
    background: #F0F0F0;
    text-align: center;
    font-weight: bold;
}
.close:hover {
    background: #cccccc;
}
#loading_progress {
    float: left;
    line-height: 18px;
    padding: 8px 0 0 0;
}
#loading_progress img {
    float: left;
    margin: 0 5px 0 0;
    width: 16px !important;
}
.form_crop {
    width: auto;
    height: auto;
    display: inline-block;
    border: 1px solid #999999;
    border-radius: 10px;
    background: #ffffff;
    color: #666666;
    margin: auto;
    margin-top: 40px;
    padding: 10px;
    text-align: left;
    position: relative;
}
.form_crop h2 {
    border-bottom: 1px solid #999999;
    padding: 0 0 5px 0;
    margin: 0 0 20px 0;
}
#target {
    background-color: #ccc;
    width: 500px;
    height: 330px;
    font-size: 24px;
    display: block;
}
#crop_btn {
    background: #cccccc;
    color: #333333;
    border: 1px solid #999999;
    border-radius: 10px;
    float: right;
    line-height: 30px;
    font-size: 14px;
    font-weight: bold;
    font-family: arial;
    display: block;
    padding: 5px;
    margin: 10px 0 0 0;
    cursor: pointer;
}
#crop_btn:hover {
    background: #eaeaea;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/jquery.Jcrop.min.css" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/jquery.Jcrop.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="main_title">Crop photo using PHP and jQuery</h1>
        <div class="content">
            <span class="upload_btn" onclick="show_popup('popup_upload')">Edit</span>
            <div id="photo_container">
            </div>
        </div><!-- content -->    
    </div><!-- container -->

    <!-- The popup for upload new photo -->
    <div id="popup_upload">
        <div class="form_upload">
            <span class="close" onclick="close_popup('popup_upload')">x</span>
            <h2>Upload photo</h2>
            <form action="upload_photo.php" method="post" enctype="multipart/form-data" target="upload_frame" onsubmit="submit_photo()">
                <input type="file" name="photo" id="photo" class="file_input">
                <div id="loading_progress"></div>
                <input type="submit" value="Upload photo" id="upload_btn">
            </form>
            <iframe name="upload_frame" class="upload_frame"></iframe>
        </div>
    </div>

    <!-- The popup for crop the uploaded photo -->
    <div id="popup_crop">
        <div class="form_crop">
            <span class="close" onclick="close_popup('popup_crop')">x</span>
            <h2>Crop photo</h2>
            <!-- This is the image we're attaching the crop to -->
            <img id="cropbox" />
            
            <!-- This is the form that our event handler fills -->
            <form>
                <input type="hidden" id="x" name="x" />
                <input type="hidden" id="y" name="y" />
                <input type="hidden" id="w" name="w" />
                <input type="hidden" id="h" name="h" />
                <input type="hidden" id="photo_url" name="photo_url" />
                <input type="button" value="Crop Image" id="crop_btn" onclick="crop_photo()" />
            </form>
        </div>
    </div>
</body>
</html>
