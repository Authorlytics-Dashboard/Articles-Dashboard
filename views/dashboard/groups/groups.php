<section>
<table class="table text-center">
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
      <td>
            <button class="btn btn-danger"><i class='bx bx-trash' ></i></button>
            <a href="/groups/edit/?id=<?php echo $group["gid"] ; ?>" class="btn btn-primary"><i class='bx bxs-edit'></i></a>
            <button class="btn btn-dark"><i class='bx bx-show-alt' style="color: #fff;"></i></button>
     </td>
    </tr>
    <?php }?>
  </tbody>
</table>
</section>