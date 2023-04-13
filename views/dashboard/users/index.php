<section class="userSection">

    <form action="CreateUser" method="post">
        <button type="submit" class="btn btn-success mb-5 mt-3">Add New User</button>
    </form>
    <?php 
  $users=new User();
  $allUsers = $users->getData();?>
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Avatar</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Mobile</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
      foreach ($allUsers as $user)
      {?>
            <tr>
                <th scope="row"><?php echo $user["uid"] ?></th>
                <td>
                    <?php if ($user["avatar"]) { ?>
                    <img src='../assets/Images/<?php echo $user['avatar'] ?>' class='rounded-circle img-thumbnail'
                        alt='Avatar' style='width:30px; height:30px;'>
                    <?php } else { ?>
                    <p>No Avatar</p>
                    <?php } ?>
                </td>
                <td><?php echo $user["uname"] ?></td>
                <td><?php echo $user["email"] ?></td>
                <td><?php echo $user["mobile"] ?></td>
                <td>
                    <a href="/users/delete/?id=<?php echo $user["uid"] ; ?>" class="btn btn-danger"><i
                            class='bx bx-trash'></i></a>
                    <a href="/users/edit/?id=<?php echo $user["uid"] ; ?>" class="btn btn-primary"><i
                            class='bx bxs-edit'></i></a>
                    <a href="/users/show/?id=<?php echo $user["uid"] ; ?>" class="btn btn-dark"><i
                            class='bx bx-show-alt' style="color: #fff;"></i></a>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</section>