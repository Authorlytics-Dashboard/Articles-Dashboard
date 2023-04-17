<?php 
    $db = new Group('groups',"GroupsErrors.log",'gid');
    $current_index = isset($_GET["page"]) && is_numeric($_GET["page"])? (int)$_GET["page"]: 0;
    $rowCount = $db->getCount('groups');
    $next_index = $current_index + 5 <= $rowCount? $current_index + 5: $current_index;
    $previous_index = ($current_index - 5 > 0)? $current_index - 5 : 0;
?>  

<section class="groupSection">
  <div class="d-flex justify-content-between" >
  <form method="get" action="/groups/">
    <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Search" name="query" value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
      </div>
    </div>
  </form>
  <form action="CreateGroup" method="post">
    <button type="submit" class="btn btn-success mb-5 mt-3">Add New Group</button>
  </form>
  </div>
 
<?php 
$groups=new Group('groups',"GroupsErrors.log",'gid');
if(isset($_GET['query'])) {
  $items = $groups->search(array("column" => "gname", "value" => $_GET['query']),
  array("column" => "description", "value" => $_GET['query']));
} else{
  $items = $db->get_all_records_paginated(array(), $current_index);
}


    if (count($items) > 0) {
  ?>
  <table class="table text-center">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Avatar</th>
        <th scope="col">Name</th>
        <th scope="col">Description</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        foreach ($items as $group){
      ?>
        <tr>
          <th scope="row"><?php echo $group["gid"] ?></th>
          <td>
            <?php if ($group["avatar"]) { ?>
              <img src='../assets/Images/<?php echo $group['avatar'] ?>' class='rounded-circle img-thumbnail' alt='Avatar' style='width:30px; height:30px;'>
            <?php } else { ?>
              <p>No Avatar</p>
            <?php } ?>
          </td>
          <td><?php echo $group["gname"] ?></td>
          <td><?php echo $group["description"] ?></td>
          <td>
            <?php
            if ($group["deleted_at"] == null) { ?>
              <a href="/groups/delete/?id=<?php echo $group["gid"] ; ?>" class="btn btn-danger" ><i class='bx bx-trash' ></i></a>
            <?php } else { ?>
              <a href="/groups/restore/?id=<?php echo $group["gid"] ; ?>" class="btn btn-success" ><i class='bx bx-recycle'></i></a>
            <?php }
            ?>
              <a href="/groups/edit/?id=<?php echo $group["gid"] ; ?>" class="btn btn-primary"><i class='bx bxs-edit'></i></a>
            <a href="/groups/show/?id=<?php echo $group["gid"] ; ?>" class="btn btn-dark"><i class='bx bx-show-alt' style="color: #fff;"></i></a>
          </td>
        </tr>
      <?php }?>
    </tbody>
  </table>
  
  <?php
  } else {
    echo "No results found.";
  }
  ?>
        <div class="d-flex justify-content-center gap-2" >
            <button class="btn btn-dark">
                <a href="<?php echo "/groups/"."?page=".$previous_index; ?>" class="text-light"> << Previous</a>
            </button>
            <button class=" btn btn-dark" >        
                <a href="<?php echo "/groups/"."?page=".$next_index; ?>" class="text-light">Next >></a>
            </button>
        </div>
</section>
<?php
  if(isset($_POST['query'])){
    $name = $_POST['query'];
    $obj = new Group('groups',"GroupsErrors.log",'gid');
    $d=  $obj->search('gname' , $name);
  }
?>