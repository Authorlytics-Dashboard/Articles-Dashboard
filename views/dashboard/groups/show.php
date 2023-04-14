<?php     
    $groupId = $_GET['id'];
    // get data of group by its id and show it in fields 
    $group = new Group();
    $g = $group ->showGroupByID($groupId);
    $g = $g[0];
    $handler = new MYSQLHandler();
    $sql = "SELECT * FROM users INNER JOIN groups ON users.gid = groups.gid where groups.gid = $groupId";
    $img = "SELECT users.avatar FROM users INNER JOIN groups ON users.gid = groups.gid where groups.gid = users.gid;";
    $results = $handler->get_results($sql);
?>
<style>
  .card {
    --cardbg: 245, 245, 245;
    --cardBase: 112,53,62;
    --cardText: 100, 100, 100;
    --cardTextBtn: 106, 16, 88;
    --cardsquares: 156, 113, 227;
    display: flex;
    flex-flow: column nowrap;
    place-items: center;
    text-align: center;
    border: 1px solid #ccc;
    box-shadow: 0 0 3em rgba(var(--cardBase), .25),
    inset 0 -.25em 1px rgba(var(--cardBase), .125);
    border-radius: 4px;
    background: rgba(var(--cardbg), 1);
    position: relative;
    width: 300px;
    height: 390px;
    perspective: 1000px;
    z-index: 0;
    transition: all 1s ease-out;
  }

  .card:hover {
    filter: grayscale(0%);
    scale: 1.025;
    box-shadow: 0 0 5em rgba(var(--cardBase), .5);
  }

  .card::after,
  .card::before {
    content: '';
    width: 200px;
    height: 50%;
    display: block;
    background-color: rgba(var(--cardsquares), .5);
    filter: blur(10px);
    position: absolute;
    transition: all 1s ease-out;
    opacity: .1;
    z-index: 0;
  }

  .card:hover::after,
  .card:hover::before {
    opacity: .5;
    rotate: 60deg;
  }

  .card:hover::after {
    translate: 100% 0;
  }

  .card:hover::before {
    translate: -100% 0;
  }

  .card .card-title {
    color: rgba(var(--cardText), .75);
    font-size: 1.1em;
    font-weight: 600;
    margin: .5em;
    position: relative;
    transition: all .3s ease-out;
    z-index: 100;
    text-shadow: 0px 0px 0px rgba(var(--cardText), .25);
  }

  .card:hover h3 {
    color: rgba(var(--cardText), 1);
    text-shadow: 0px 8px 5px rgba(var(--cardText), .35);
  }

  .card:hover span {
    filter: grayscale(0%);
  }

  /* Inner card */
  .card-info::after {
    left: -6rem;
    bottom: 0;
  }

  .card-info::before {
    right: -6rem;
    top: 1rem;
  }

  /* Avatar container */
  .card-info span {
    color: rgba(var(--cardBase), 1);
    display: flex;
    place-items: center;
    text-align: center;
    border-radius: 50%;
    overflow: hidden;
    background-color: rgba(var(--cardBase), .5);
    height: 120px;
    width: 50%;
    box-shadow: inset 0px 2px 4px rgba(var(--cardBase), .95),
    inset 0px 2px 40px rgba(var(--cardbg), .95);
    position: relative;
    transition: all .3s ease-out .1s;
    filter: grayscale(75%);
    z-index: 0;
  }

  .card-info span:hover .avatar {
    scale: 1.5;
  }

  .avatar {
    transition: all .3s ease-out;
    position: relative;
  }

  /* Inner card container and UI */
  .card-info {
    --angle: 0deg;
    display: flex;
    flex-flow: column nowrap;
    place-items: center;
    padding: 1em;
    margin: 0 .75em;
    color: rgba(var(--cardText), 1);
    background-color: rgba(250, 246, 246, 1);
    transition: all .5s ease-out;
    animation: animateBorder 10s linear infinite reverse;
    border: .15em solid;
    position: relative;
    z-index: 10;
    border-image: linear-gradient(var(--angle), rgba(var(--cardbg), 1), rgba(var(--cardBase), .5), rgba(var(--cardbg), 1)) 1;
  }

  .card-info p {
    color: rgba(var(--cardText), 1);
    line-height: 1.25em;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 3;
    font-size: 1em;
    margin: 1em 0;
    transition: all .3s ease-out .3s;
    width: 230px;
  }

  /* .card-info .btn {
    display: block;
    padding: 8px 16px;
    background-color: rgba(var(--cardBase), .35);
    color: rgba(var(--cardTextBtn), .75);
    text-decoration: none;
    border-radius: 4px;
    font-size: .85em;
    transition: all 0.3s ease-in-out;
  } */

  @keyframes animateBorder {
    to {
      --angle: 360deg;
    }
  }
  


  .userCard {
 width: 190px;
 height:  136px;
 background-image: linear-gradient(163deg, #00ff75 0%, #3700ff 100%);
 border-radius: 20px;
 transition: all .3s;
}

.userCard2 {
 width: 190px;
 height:  136px;
 background-color: #1a1a1a;
 transition: all .2s;
}

.userCard2 h5{
  font-size:15px;
}

.userCard2:hover {
 transform: scale(0.98);
 border-radius: 20px;
}

.userCard:hover {
 box-shadow: 0px 0px 30px 1px rgba(0, 255, 117, 0.30);
}
</style>
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
          <?php echo $row['uname']; ?>
        </td>
        <td>
          <?php echo $row['email']; ?>
        </td>
        <td>
          <?php echo "Member Since: " . date('F j, Y g:i A', strtotime($row["subscription_date"])); ?>
          
        </td>
      </tr>
  </tbody>
  <?php }?>
</table> 

</section>