<section>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Avatar</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    require_once('Classes/Group.php');
    $groups=new Group();
    $allGroups=$groups->get_data();

    foreach ($allGroups as $group)
    {?>

    <tr>
      <th scope="row"><?php echo $group["gid"] ?></th>
      <td><?php echo $group["avatar"] ?></td>
      <td><?php echo $group["gname"] ?></td>
      <td><?php echo $group["description"] ?></td>
      <td><button class="btn"> Delete</button></td>
      <td><button class="btn"> Edit</button></td>
      <td><button class="btn"> Show</button></td>
    </tr>
    <?php }?>
  </tbody>
</table>
</section>