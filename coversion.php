<?php
    if(isset($_POST['convert'])){
        $dirpath=$_POST['name'];
        
        $output_path="compressed/";
        foreach( $_FILES['file']['tmp_name'] as $key => $tmp_name ){
            $image_tmp_name =  $_FILES['file']['tmp_name'][$key];
            $image_name =  $_FILES['file']['name'][$key];
            echo "$image_name"."<br><br>";
            $image_extenstion=strtolower(pathinfo($_FILES['file']['name'][$key], PATHINFO_EXTENSION));
            $extenstions_allowed = array('gif', 'png', 'jpg');
            if(in_array($image_extenstion, $extenstions_allowed)){
                $mime_type = mime_content_type($image_tmp_name);
                // image_compression($image_tmp_name, $image_name, $output_path, $image_quality);
                switch(strtolower(($mime_type)))
                {
                    case 'image/jpeg':
                        $new_image = imagecreatefromjpeg($image_tmp_name);
                        if($new_image !== false){
                            $image_quality=60; 
                            $compressed_image_name = $output_path. basename($image_name);
                            imagejpeg($new_image, $compressed_image_name, $image_quality);
                            imagedestroy($new_image);
                            echo $image_name ." Compressed Successfully"."<br>";
                        }else {
                                echo $image_name." Compressing Failed"."<br>";
                        }
                        break;

                    case 'image/png':
                        $image_quality=8;
                        $new_image = imagecreatefrompng($image_tmp_name);
                        if($new_image !== false){
                            $compressed_image_name = $output_path . basename($image_name);
                            imagejpeg($new_image, $compressed_image_name, $image_quality);
                            imagedestroy($new_image);
                            echo $image_name ." Compressed Successfully"."<br>";
                        }else {
                                echo $image_name." Compressing Failed"."<br>";
                        }
                        break;
                        
                    case 'image/gif':
                        $new_image = imagecreatefromgif($image_tmp_name);
                        if($new_image !== false){
                            $compressed_image_name = $output_path. 'converted_' . basename($image_name);
                            imagejpeg($new_image, $compressed_image_name);
                            imagedestroy($new_image);
                            echo $image_name ." Compressed Successfully"."<br>";
                        }else {
                                echo $image_name." Compressing Failed"."<br>";
                        }
                        break;
                    default:
                        return false;
                }
            }
            else{
                echo "Please Upload Image with extention .gif, .png, .jpg";
            }
        }
    } 
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" id="path" name="path">
        <!--   -->
        <button type="submit" name="convert" class="btn btn-primary">Conversion</button>
    </form>
    <div class="text-primary">
    </div>
</body>
</html>