<?php
$files = $_FILES['uploadedName'] ?? null;
if($files !== null){
  $uploadSucces = true;
//kontrola chyby v souboru
if($files['error']!=0){
  echo $files['error']. nl2br("\n");
  $uploadSucces = false;
}

$targetDir = "uploads/";
$targetFile = $targetDir . basename($_FILES['uploadedName']['name']);
$filetype = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

//kontrola velikosti

if($files['size']>8_000_000){
  echo "Soubor je příliš velký". nl2br("\n");
  echo $files['size'];
  $uploadSucces = false;
}

if(!$uploadSucces){
  echo "Došlo k chybě uploadu";
} else{
//přesun souboru
  $typeoffile = mime_content_type($files['tmp_name']);
  if(strpos(strval($typeoffile), "image/") !== false || strpos(strval($typeoffile), "audio/") !== false || strpos(strval($typeoffile), "video/") !== false){
    if(move_uploaded_file($files['tmp_name'],$targetFile)){

      echo "Soubor '". basename($files['name']) ."' byl uložen.";
      
      $filename = $files['name'];
  
      if(strpos(strval($typeoffile), "image/") !== false){
        echo nl2br("\n");
        echo "<img src='uploads/". $filename . "' alt></img>";
      }
      elseif(strpos(strval($typeoffile), "audio/") !== false){
        echo nl2br("\n");
        echo "<audio src='uploads/".$filename."' controls></audio>";
      }
      else{
        echo nl2br("\n");
        echo "<video src='uploads/".$filename."' controls></video>";
      }
    }
    else{
      echo "Došlo k chybě uploadu";
    }
  }else{
    echo "Došlo k chybě uploadu, nenáhrál jsi obrázek nebo video nebo audio";
  }
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Document</title>
</head>
<body>
    <form method='post' action='' enctype='multipart/form-data'>
    <div class="mb-3">
      <lablel for="formFile" class="form-label">Zvolit soubor pro upload</label>
      <input class="btn btn-primary mb-3" class="form-control" type="file" name= "uploadedName" placeholder="Search" accept="video/*, image/*, audio/*"/>
      <input class="btn btn-primary mb-3" type="submit" value= "Nahrát" placeholder="Search" name="submit" />
    </div>
    </form>
</body>
</html>
