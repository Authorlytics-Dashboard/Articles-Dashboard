<?php     
    $groupId = $_GET['id'];
    // get data of group by its id and show it in fields 
    $group = new Group();
    $g = $group ->showGroupByID($groupId);
    $g = $g[0];
?>

<section class="groupSection">
    <h5><?php echo $g["gname"]; ?></h5>
    <h5><?php echo $g["description"]; ?></h5>
    <img src="../../../assets/Images/<?php echo $g['avatar'] ?>" alt="">
</section>