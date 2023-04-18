<?php     
    $groupId = $_GET['id'];
    // get data of group by its id and show it in fields 
    $group = new Group('groups',"GroupsErrors.log",'gid');
    $g = $group ->getRecordByID($groupId);
    $g = $g[0];
    $handler = new MYSQLHandler();
    $sql = "SELECT * FROM users INNER JOIN groups ON users.gid = groups.gid where groups.gid = $groupId";
    $img = "SELECT users.avatar FROM users INNER JOIN groups ON users.gid = groups.gid where groups.gid = users.gid;";
    $results = $handler->get_results($sql);
?>


<section class="groupSection ">
  <div class="showGroup d-flex gap-5 mx-auto"  style=" width:fit-content; border-radius:20px;" >
    <div class="card">
      <div class="card-title"><?php echo $g["gname"]; ?></div>
        <div class="card-info">
          <span>
            <img  style="border-radius:20px; width: 116px; height:121px;" src="../../../assets/Images/<?php echo $g['avatar'] ?>" alt="">
          </span>
          <p><?php echo $g["description"]; ?></p>
        </div>
    </div>
  </div>

  <hr>

  <h4>Group users:</h4>
  <hr>
  <table class="table text-center">
    <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Member Since</th>
          </tr>
    </thead>
  <?php 
    foreach ($results as $row) { ?>
      <tbody>
        <tr>
          <td>
            <?php echo $row['username']; ?>
          </td>
          <td>
            <?php echo $row['email']; ?>
          </td>
          <td>
            <?php echo date('F j, Y g:i A', strtotime($row["subscription_date"])); ?>
          </td>
        </tr>
    </tbody>
    <?php }?>
  </table> 
</section>