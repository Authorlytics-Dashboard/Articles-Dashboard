<?php     
    $groupId = $_GET['id'];
    // get data of group by its id and show it in fields 
    $group = new Group();
    $g = $group ->showGroupByID($groupId);
    $g = $g[0];
?>

<section class="groupSection ">
    <div class="showGroup d-flex gap-5 mx-auto "  style=" width:600px; background-color: rgba(255, 255, 255, 0.397); border-radius:20px;" >
        <div class="groupImg " >
            <img  style="border-radius:20px; width: 300px; height:400px;" src="../../../assets/Images/<?php echo $g['avatar'] ?>" alt="">
        </div>
        <div class="d-flex flex-column">
            <h1><?php echo $g["gname"]; ?></h1>
            <h4><?php echo $g["description"]; ?></h4>
        </div>
    </div>

</section>