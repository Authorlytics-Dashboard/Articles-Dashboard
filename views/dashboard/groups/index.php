<section class="groupSection">
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
<?php 
$groups=new Group();
if(isset($_GET['query'])) {
  $searchedGroups = $groups->search(array("column" => "gname", "value" => $_GET['query']),
  array("column" => "description", "value" => $_GET['query']));
} else {
  $searchedGroups = $groups->getData();
}

if (count($searchedGroups) > 0) {
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
      foreach ($searchedGroups as $group)
      {?>
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
            <a href="/groups/delete/?id=<?php echo $group["gid"] ; ?>" class="btn btn-danger" ><i class='bx bx-trash' ></i></a>
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
</section>
<?php
if(isset($_POST['query'])){
  $name = $_POST['query'];
  $obj = new Group();
  $d=  $obj->search('gname' , $name);
  var_dump($d);
}

?>