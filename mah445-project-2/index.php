<?php include("includes/init.php");

const SEARCH_FIELDS = [
  "all" => "All Pictures",
  "nature" => "Nature",
  "festival" => "Festival",
  "snow" => "Snow",
  "old" => "Old",
  "sport" => "Sport",
  "water" => "Water",
  "tree" => "Tree"
];
if (isset($_GET['tag_chosen'])){
  $search_on = TRUE;

  $option = filter_input(INPUT_GET, 'tag_chosen', FILTER_SANITIZE_STRING);
  if (in_array($option, array_keys(SEARCH_FIELDS))) {
    $option = $option;
  } else {
    array_push($messages, "Invalid category for search.");
    $search_on= FALSE;
  }




}


function display(){
  global $db, $search_on, $option, $tag;


  if ($search_on){
    if ($option != 'all'){
    $tag_sql = "SELECT tags.id FROM tags WHERE (tags.tag LIKE '%' || :tag || '%') ";
    $params = array(
      ':tag' => $option
    );

    $result = exec_sql_query($db, $tag_sql, $params);
    if ($result) {

      foreach ($result as $x){
        $image_tags_sql = "SELECT DISTINCT images.id, images.file_ext FROM image_tags INNER JOIN tags ON image_tags.tag_id = :tagid INNER JOIN images ON images.id = image_tags.image_id";
        $params = array(
          ':tagid' => $x["id"]
        );
        $result_two = exec_sql_query($db, $image_tags_sql, $params);

        if ($result_two) {
          foreach ($result_two as $ress) {
            ?>
            <a href="photo.php?<?php echo http_build_query(
              array(
                'post_id' => strtolower($ress['id']),
                'extt_id' => $ress["file_ext"])); ?>">

               <img src="uploads/<?php echo $ress["id"]?>.<?php echo $ress["file_ext"];?>">

            </a>
            <?php
          }
        } else {
          echo '<p><strong>No files uploaded yet. Try uploading a file!</strong></p>';
        }
      }
    }
  }
  else{
    $records = exec_sql_query($db, "SELECT * FROM images")->fetchAll(PDO::FETCH_ASSOC);

    if (count($records) > 0) {
      foreach ($records as $record) {
      //   echo "<a href=photo.php? " . http_build_query(array(
      //     'post_id' =>
      //   )) >
      //  <img src=\"uploads/". $record["id"] . "." . $record["file_ext"] . "\" class = imgTimeline> </a>";
      $queryoo = "photo.php?".http_build_query(array(
        'post_id' => ($record['id']),
        'extt_id' => $record["file_ext"]));
      ?>
      <a href="photo.php?<?php echo http_build_query(array(
        'post_id' => ($record['id']),
        'extt_id' => $record["file_ext"])); ?>">

         <img src="uploads/<?php echo $record["id"]?>.<?php echo $record["file_ext"];?>">

      </a>
      <?php
      }
    } else {
      echo '<p><strong>No files uploaded yet. Try uploading a file!</strong></p>';
    }
  }
  }
  else{
    $records = exec_sql_query($db, "SELECT * FROM images")->fetchAll(PDO::FETCH_ASSOC);

    if (count($records) > 0) {
      foreach ($records as $record) {
      //   echo "<a href=photo.php? " . http_build_query(array(
      //     'post_id' =>
      //   )) >
      //  <img src=\"uploads/". $record["id"] . "." . $record["file_ext"] . "\" class = imgTimeline> </a>";
      ?>
      <a href="photo.php?<?php echo http_build_query(array(
        'post_id' => ($record['id']),
        'extt_id' => $record["file_ext"])); ?>">

         <img src="uploads/<?php echo $record["id"]?>.<?php echo $record["file_ext"];?>">

      </a>
      <?php
      }
    } else {
      echo '<p><strong>No files uploaded yet. Try uploading a file!</strong></p>';
    }
  }
}

function display_tags_option(){
  global $db, $image;

  $tag_join_sql = "SELECT tags.tag FROM tags WHERE tags.id > 7" ;
  $params = array();
  $result = exec_sql_query($db, $tag_join_sql, $params);

  foreach($result as $x){
      ?>

      <option value="<?php echo $x["tag"];?>"><?php echo $x["tag"];?></option>

      <?php

  }

}

if (isset($_POST["submit_upload"])) {

  $upload_info = $_FILES["box_file"];
  if($upload_info['error'] == UPLOAD_ERR_OK){
    $base_name = basename($upload_info['id']);
    $upload_ext = strtolower( pathinfo($base_name, PATHINFO_EXTENSION) );
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

    $sql="INSERT INTO images(file_ext, description) VALUES (:file_ext, :description)";
    $params=array(
      // ':base_name' => $base_name,
      ':file_ext' => $upload_ext,
      ':description' => $description
    );

    exec_sql_query($db, $sql, $params);

    $lastId = $db->lastInsertId("id");
    $last_file_ext = $db->lastInsertId("file_ext");
    // $new_path = "../uploads/documents/$lastId.$upload_info[type]" ;
    $new_path = "uploads/$lastId.$upload_ext";
    move_uploaded_file( $_FILES["box_file"]["tmp_name"], $new_path );

  }
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/site.css">
  <title>People Of Cornell - A Photoshow</title>
</head>

<body>

  <div class="logoR">
          <a href="index.php">
          <img src="uploads/back2.png" alt="Logo" class="logo_image">
          </a>
      </div>
  <div class = "container">

    <div class="navBar">

    <form action="" method="get">
      <div class=selectOption>
        <label for="tags" id = "TagLabel" > Tags </label>
        <select name="tag_chosen" id="tags">
          <option value="all">All Pictures</option>
          <option value="nature">Nature</option>
          <option value="festival">Festival</option>
          <option value="snow">Snow</option>
          <option value="old">Old</option>
          <option value="sport">Sport</option>
          <option value="water">Water</option>
          <option value="tree">Tree</option>
          <?php display_tags_option();?>
        </select>
        <input type="submit" name="submit" value="Submit">
      </form>


      </div>

    <div class ="uploadyap">
      <form id="uploadFile" method = "post" enctype= "multipart/form-data" action="index.php">

      <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />

      <!-- <div class="uploadBut">
        <label for="box_file">Upload Fileee:</label>
        <input id="box_file" type="file" name="box_file">
      </div> -->

      <div class= "uploadBut group_label_input" >
        <input type="file" id="ButUploadHidden" name="box_file"  />
        <label for="ButUploadHidden" id="UploadLab">
          📷 Upload Image
        </label>

      </div>
      <div class="group_label_input">
        <label for="box_desc">Description:</label>
        <input type="text" id="box_desc" name="description"/>
      </div>

      <div class="group_label_input">
        <span></span>
        <button name="submit_upload" class="plus_Button" type="submit"> ⇧ </button>

      </div>
    </form>
  </div>

    </div>


    <div class="row-of-pictures">
    <ul>

      <?php

      echo "<h2> ". $option . " </h2>";
      display();

      ?>
    </ul>

    </div>


    <div>


      <!-- Plus sign -->
      <!-- N-ve sign -->

      <!-- Menu button + Delete button -->
    </div>


</body>

</html>
