<?php include("includes/init.php");



if (isset($_GET['post_id'])){
    echo "YOLOOO!";
    $image = filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_STRING);
    $exten = filter_input(INPUT_GET,  'extt_id', FILTER_SANITIZE_STRING);
    echo $image;
}

function display_tags(){
    global $db, $image;

    $tag_join_sql = "SELECT DISTINCT tags.tag FROM image_tags INNER JOIN images ON image_tags.image_id = :images INNER JOIN tags ON tags.id = image_tags.tag_id";
    $params = array(
        ':images' => $image
    );
    $result = exec_sql_query($db, $tag_join_sql, $params);

    foreach($result as $x){
        ?>

        <li> <?php echo $x["tag"];?> </li>

        <?php

    }

}

function display_tags_choices(){
    global $db, $image;

    $tag_join_sql = "SELECT DISTINCT tags.tag FROM image_tags INNER JOIN images ON image_tags.image_id = :images INNER JOIN tags ON tags.id = image_tags.tag_id";
    $params = array(
        ':images' => $image
    );
    $result = exec_sql_query($db, $tag_join_sql, $params);

    foreach($result as $x){
        ?>

        <input type="checkbox" id="tag1" name="tag1" value="<?php echo $x["tag"] ?>">
            <label for="tag1"> <?php echo $x["tag"] ?> </label><br>
        <?php
    }

}
if (isset($_POST["addButton"])){
    $added_tag = filter_input(INPUT_POST, 'tag1', FILTER_SANITIZE_STRING);
    echo "TAG to be added is";
    echo $added_tag;
    $addTag = FALSE;
    if ($added_tag != " "){
        echo "OKAY";
        $addTag = TRUE;
        $sql_check = "SELECT tags.id FROM tags WHERE (tags.tag LIKE '%' || :tag || '%') ";
        $params = array(
            ':tag' => $added_tag
          );
        $resulttt = exec_sql_query($db, $sql_check, $params);
        if(count($resulttt)>0){
            echo "ALready exists";
            foreach($resulttt as $x){
            $sql_add_two = "INSERT INTO image_tags (tag_id,image_id) VALUES (:tagid, :img)";
            $params = array(
                ':tagid' => $x['id'],
                ':img' => $image
            );
            exec_sql_query($db, $sql_add_two, $params);
            }
        }
        else{
            echo " A new tag";
            $sql_add_new = "INSERT INTO tags (tag) VALUES (:tag)";
            $params = array(
                ':tag' => $added_tag
              );
            exec_sql_query($db, $sql_add_new, $params);
            $sql_checkk = "SELECT tags.id FROM tags WHERE (tags.tag LIKE '%' || :tag || '%') ";
            $params = array(
            ':tag' => $added_tag
            );
            $records = exec_sql_query($db, $sql_checkk, $params);

            foreach($records as $r){
            echo "its tag id is";
            echo $r['id'];
            echo " And its picture again is ";
            echo $image;
            $sql_add_two = "INSERT INTO image_tags(tag_id, image_id) VALUES (:tagid, :img)";
            $params = array(
                ':tagid' => $r['id'],
                ':img' => $image
            );
            exec_sql_query($db, $sql_add_two, $params);
            }
        }
    }
}

if (isset($_POST["removeButton"])){
    $tag_removed = filter_input(INPUT_POST, 'tag1', FILTER_SANITIZE_STRING);
    echo "WE in ";
    echo $tag_removed;
    $sql_check = "SELECT tags.id FROM tags WHERE (tags.tag LIKE '%' || :tag || '%') ";
    $params = array(
        ':tag' => $tag_removed
      );
    $resulttt = exec_sql_query($db, $sql_check, $params);

    foreach($resulttt as $x){
        echo "OYAAA";
        echo "The id to be deleted is   ";
        echo $x['id'];
        $sql_add_two = "UPDATE image_tags
        SET tag_id = NULL
        WHERE image_tags.tag_id = :tagid ";
        $params = array(
            ':tagid' => $x['id'],
        );
        exec_sql_query($db, $sql_add_two, $params);
        }


    $sql = "DELETE FROM tags WHERE tags.tag = :tag";
    $params = array(
        ':tag' => $tag_removed
    );
    exec_sql_query($db, $sql, $params);


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

<div>
    <a href="index.php"> HOME </a>

    <div class="photoCenter">

    <?php

    $sql = "SELECT * FROM images WHERE ( images.id LIKE '%' || :taa || '%') ";
    $params = array(
      ':taa' => $image
    );
    $result = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <img src="uploads/<?php echo $image?>.<?php echo $exten;?>">;



    </div>


</div>

<h2> Tags </h2>
    <ul>
        <?php
        display_tags();
        ?>
    </ul>

<!-- Add Tag form -->
<div class= "add_Tag " >
    <h3> Add tag </h3>
    <form method="post" action="<?php $queryoo ?>" id="addTag">
        <div>
        <label for="name">Tag name</label>
        <input type="text" name="tag1" id="tag1">
        </div>
        <!-- <input type="submit" value="Save" name="addButton" id="submitButton"> -->
        <button class="plus_Button" type="submit" name="addButton" id="submitButton"> + </button>
    </form>
</div>

<div class="remove_Tag">
    <h3> Remove tag </h3>
    <form method="post" action="<?php $queryoo ?>" id="addTag">
        <div>
            <?php display_tags_choices(); ?>
        </div>
            <button class="minus_Button" name="removeButton" type="submit"> − </button>
            <!-- <input type="submit" value="Save" id="submitButton"> -->
    </form>
</div>
