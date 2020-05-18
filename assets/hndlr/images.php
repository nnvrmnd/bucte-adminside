<label class="form-control-label" for="select_file">Images</label>
<div class="row col-md-12 col-sm-12">
<?php
require 'db.hndlr.php';
 $stmnt = "SELECT * FROM content, content_images where  content_images.c_id = content.c_id and content.alias = ? ";
 $query = $db->prepare($stmnt);
 $param = ['homepage'];
 $query->execute($param);
 $result = $query->fetchAll();
 $count = $query->rowCount();
 $imageAlias = array("image-1", "image-2", "image-3");
 //print_r($result);
 $imageArray = [];
 if($count > 0)
 foreach($result as $data){
  array_push($imageArray, $data['image']);
  $imageLocation = $data['folder'] == '' ? "assets/img/no-image.png" : $data['folder']; 
  $imageStyle = $data['image'] ? "image-exist" : "no-image-size";
  $imageContStyle = $data['image'] ? "style='padding: 0px'": '';
  echo '
    <div class="col-md-4 col-sm-4">
        <div class="image-holder">
            <div class="no-image-container" '.$imageContStyle.'>
                <img class="'.$imageStyle.'" id="'.$data['image'].'1" src="'.$imageLocation.'">
                <div class="middle">
                    <div class="button-show">
                        <label class="btn btn-lg btn-secondary float-right" for="'.$data['image'].'"  title="Change Image"
                            style="background-color: #dee2e6f2">
                            <i class="fa fa-camera fa-lg" aria-hidden="true"></i>
                        </label>
                        <input type="file" id="'.$data['image'].'" name="'.$data['image'].'" accept="image/*" style="display:none">
                    </div>
                </div>
            </div>
        </div>
    </div>
   '; 
};

$imageNotExist = array_diff($imageAlias,  $imageArray);

foreach($imageNotExist as $image) {
    echo '
    <div class="col-md-4 col-sm-4">
        <div class="image-holder">
            <div class="no-image-container">
                <img class="no-image-size" id="'.$image.'1" src="assets/img/no-image.png">
                <div class="middle">
                    <div class="button-show">
                        <label  class="btn btn-lg btn-secondary float-right" for="'.$image.'" title="Change Image"
                            style="background-color: #dee2e6f2">
                            <i class="fa fa-camera fa-lg" aria-hidden="true"></i>
                        </label>
                        <input type="file" id="'.$image.'" name="'.$image.'" accept="image/*" style="display:none">
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';
  }
?>
   
</div>