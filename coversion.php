<?php
    if(isset($_POST['convert'])){
        $dirpath=$_POST['path'];
        dir_scan($dirpath);
    } 

    function dir_scan($dir){
        $listdir=array_diff(scandir($dir), [".", ".."]);
        print_r($listdir);
        echo "<br>";
        foreach($listdir as $subdir){
            $file=$dir."\\".$subdir;
            if(is_file($file)){
                $parent_folder=basename(dirname($file));
                $output_path="compressed/".$parent_folder;
                if(is_dir($output_path)==false){
                    mkdir($output_path);
                }
                $image_name =  $subdir;
                echo "$image_name"."<br><br>";
                $image_extenstion=strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $extenstions_allowed = array('gif', 'png', 'jpg');
                if(in_array($image_extenstion, $extenstions_allowed)){
                    $mime_type = mime_content_type($file);
                    switch(strtolower(($mime_type)))
                    {
                        case 'image/jpeg':
                            $new_image = imagecreatefromjpeg($file);
                            if($new_image !== false){
                                $image_quality=60; 
                                $compressed_image_name = $output_path."/". basename($image_name);
                                imagejpeg($new_image, $compressed_image_name, $image_quality);
                                imagedestroy($new_image);
                                echo $image_name ." Compressed Successfully"."<br>";
                            }else {
                                    echo $image_name." Compressing Failed"."<br>";
                            }
                            break;

                        case 'image/png':
                            $image_quality=8;
                            $new_image = imagecreatefrompng($file);
                            if($new_image !== false){
                                $compressed_image_name = $output_path."/". basename($image_name);
                                imagejpeg($new_image, $compressed_image_name, $image_quality);
                                imagedestroy($new_image);
                                echo $image_name ." Compressed Successfully"."<br>";
                            }else {
                                    echo $image_name." Compressing Failed"."<br>";
                            }
                            break;
                            
                        case 'image/gif':
                            $new_image = imagecreatefromgif($file);
                            if($new_image !== false){
                                $compressed_image_name = $output_path."/". basename($image_name);
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
            }
            else if(is_dir($dir.$subdir)){
                echo $dir.$subdir ."<br>";
                dir_scan($dir.$subdir);
            }
            else{
                echo "erorr occoured<br>";
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