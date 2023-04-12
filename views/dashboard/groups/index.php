<section>

<form action="CreateGroup" method="post">
<button type="submit" class="btn btn-success mb-5 mt-3">Add New Group</button>
</form>
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
      <td>
        <?php if ($group["avatar"]) { ?>
          <img src='assets/Images/<?php echo $group['avatar'] ?>' class='rounded-circle img-thumbnail' alt='Avatar' style='width:30px; height:30px;'>
        <?php } else { ?>
          <p>No Avatar</p>
        <?php } ?>
      </td>
      <td><?php echo $group["gname"] ?></td>
      <td><?php echo $group["description"] ?></td>
      <td>
            <button class="btn btn-danger"><i class='bx bx-trash' ></i></button>
            <button class="btn btn-primary"><i class='bx bxs-edit'></i></button>
            <button class="btn btn-dark"><i class='bx bx-show-alt' style="color: #fff;"></i></button>
     </td>
    </tr>
    <?php }?>
  </tbody>
</table>
</section>