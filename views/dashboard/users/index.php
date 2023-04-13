<section class="userSection">
    <div class="d-flex justify-content-between">
    <form action="CreateUser" method="post">
        <button type="submit" class="btn btn-success mb-5 mt-3">Add New User</button>
    </form>
    <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color:#221f26;">
    Filter By Group
  </button>
  <ul class="dropdown-menu">
  <?php
    ob_start();
    $group = new Group();
    $groups = $group->getGroups();
    foreach ($groups as $g) {
        $gid = $g['gid'];
        $gname = $g['gname'];
        echo "<li><a class=dropdown-item href=/users/?group_name=\"$gname\">$gname</a></li>";}
        echo "<li><a class=dropdown-item href=/users/?group_name=all>ALL</a></li>"
        ?>
     </ul>
    </div>
    </div>
    
    <?php 
        $users=new User();
        if(isset( $_GET['group_name'])){
            if($_GET['group_name'] =="all"){
                $allUsers = $users->getData();
            }
            else{
                $allUsers = $users->filterUsersByGroup($_GET['group_name']);
            }
        }
        else{
            $allUsers = $users->getData();
        }       
        ?>
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
                    <?php
                        if ($user["deleted_at"] == null) { ?>
                        <a href="/users/delete/?id=<?php echo $user["uid"] ; ?>" class="btn btn-danger" ><i class='bx bx-trash' ></i></a>
                        <?php } 
                        else { ?>
                        <a href="/users/restore/?id=<?php echo $user["uid"] ; ?>" class="btn btn-success" ><i class='bx bx-recycle'></i></a>
                        <?php }
                    ?>    
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