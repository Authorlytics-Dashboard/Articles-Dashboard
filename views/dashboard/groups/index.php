<?php 
    $db = new Group('groups',"GroupsErrors.log",'gid');
    $current_index = isset($_GET["page"]) && is_numeric($_GET["page"])? (int)$_GET["page"]: 0;
    $rowCount = $db->getCount('groups');
    $next_index = $current_index + 5 <= $rowCount? $current_index + 5: $current_index;
    $previous_index = ($current_index - 5 > 0)? $current_index - 5 : 0;
?>

<section class="groupSection">
    <div class="d-flex justify-content-between">
        <form method="get" action="/groups/">
            <div class="search mb-3">
                <?php ob_start();?>
                <input type="text" class="search__input" placeholder="Search" name="query"
                    value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                <button class="search__button" type="submit">
                    <svg class="search__icon" aria-hidden="true" viewBox="0 0 24 24">
                        <g>
                            <path
                                d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                            </path>
                        </g>
                    </svg>
                </button>
            </div>
        </form>
        <form action="groups/create" method="post">
            <button type="submit" class="button">
                <span class="button__text">New Group</span>
                <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor"
                        height="24" fill="none" class="svg">
                        <line y2="19" y1="5" x2="12" x1="12"></line>
                        <line y2="12" y1="12" x2="19" x1="5"></line>
                    </svg></span>
            </button>
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
                    <img src='../assets/Images/<?php echo $group['avatar'] ?>' class='rounded-circle img-thumbnail'
                        alt='Avatar' style='width:30px; height:30px;'>
                    <?php } else { ?>
                    <p>No Avatar</p>
                    <?php } ?>
                </td>
                <td><?php echo $group["gname"] ?></td>
                <td><?php echo $group["description"] ?></td>
                <td>
                    <?php
            if ($group["deleted_at"] == null) { ?>
                    <a href="/groups/delete/?id=<?php echo $group["gid"] ; ?>" class="btn btn-danger"><i
                            class='bx bx-trash'></i></a>
                    <?php } else { ?>
                    <a href="/groups/restore/?id=<?php echo $group["gid"] ; ?>" class="btn btn-success"><i
                            class='bx bx-recycle'></i></a>
                    <?php }
            ?>
                    <a href="/groups/edit/?id=<?php echo $group["gid"] ; ?>" class="btn btn-primary"><i
                            class='bx bxs-edit'></i></a>
                    <a href="/groups/show/?id=<?php echo $group["gid"] ; ?>" class="btn btn-dark"><i
                            class='bx bx-show-alt' style="color: #fff;"></i></a>
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
    <div class="d-flex justify-content-center gap-2">
        <button class="custom-btn btn-2">
            <a href="<?php echo "/groups/"."?page=".$previous_index; ?>" class="text-light">
                <i class='bx bx-chevrons-left'></i>Previous
            </a>
        </button>
        <button class="custom-btn btn-2">
            <a href="<?php echo "/groups/"."?page=".$next_index; ?>" class="text-light">Next
                <i class='bx bx-chevrons-right'></i>
            </a>
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