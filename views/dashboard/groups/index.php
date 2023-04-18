<?php 
    $db = new Group('groups',"GroupsErrors.log",'gid');
    $current_index = isset($_GET["page"]) && is_numeric($_GET["page"])? (int)$_GET["page"]: 0;
    $rowCount = $db->getCount('groups');
    $next_index = $current_index + 5 <= $rowCount? $current_index + 5: $current_index;
    $previous_index = ($current_index - 5 > 0)? $current_index - 5 : 0;
?>  

<style>
  .button {
  position: relative;
  width: 150px;
  height: 40px;
  cursor: pointer;
  display: flex;
  align-items: center;
  border: none;
  background-color: #70353e;
}

.button, .button__icon, .button__text {
  transition: all 0.3s;
}

.button .button__text {
  transform: translateX(15px);
  color: #fff;
  font-weight: 600;
}

.button .button__icon {
  position: absolute;
  transform: translateX(109px);
  height: 100%;
  width: 39px;
  background-color: #70353e;
  display: flex;
  align-items: center;
  justify-content: center;
}

.button .svg {
  width: 30px;
  stroke: #fff;
}

.button:hover {
  background: #70353e;
}

.button:hover .button__text {
  color: transparent;
}

.button:hover .button__icon {
  width: 148px;
  transform: translateX(0);
}

.button:active .button__icon {
  background-color: #70353e;
}

.button:active {
  border: 1px solid #70353e;
}
/* search */
.search {
  display: flex;
  align-items: center;
  justify-content: space-between;
  text-align: center;
}

.search__input {
  font-family: inherit;
  font-size: inherit;
  background-color: #f4f2f2;
  border: none;
  color: #646464;
  padding: 0.7rem 1rem;
  border-radius: 30px;
  width: 12em;
  transition: all ease-in-out .5s;
  margin-right: -2rem;
}

.search__input:hover, .search__input:focus {
  box-shadow: 0 0 1em #00000013;
}

.search__input:focus {
  outline: none;
  background-color: #f0eeee;
}

.search__input::-webkit-input-placeholder {
  font-weight: 100;
  color: #ccc;
}

.search__input:focus + .search__button {
  background-color: #f0eeee;
}

.search__button {
  border: none;
  background-color: #f4f2f2;
  margin-top: .1em;
}

.search__button:hover {
  cursor: pointer;
}

.search__icon {
  height: 1.3em;
  width: 1.3em;
  fill: #b4b4b4;
}

/* next and prev */
.custom-btn a{
    text-decoration: none;
}
.custom-btn {
  width: 130px;
  height: 40px;
  color: #fff;
  border-radius: 5px;
  padding: 10px 25px;
  font-family: 'Lato', sans-serif;
  font-weight: 500;
  background: transparent;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  display: inline-block;
  box-shadow: inset 2px 2px 2px 0px rgba(255,255,255,.5),
                    7px 7px 20px 0px rgba(0,0,0,.1),
                    4px 4px 5px 0px rgba(0,0,0,.1);
  outline: none;
  font-size: 15px;
}

.btn-2 {
  background: #70353e;
  border: none;
}

.btn-2:before {
  height: 0%;
  width: 2px;
}

.btn-2:hover {
  box-shadow: 4px 4px 6px 0 rgba(255,255,255,.5),
              -4px -4px 6px 0 rgba(116, 125, 136, .5), 
    inset -4px -4px 6px 0 rgba(255,255,255,.2),
    inset 4px 4px 6px 0 rgba(0, 0, 0, .4);
}

</style>

<section class="groupSection">
  <div class="d-flex justify-content-between" >
  <form method="get" action="/groups/">
    <div class="search mb-3">
        <input type="text" class="search__input" placeholder="Search" name="query" value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
        <button class="search__button"type="submit">
            <svg class="search__icon" aria-hidden="true" viewBox="0 0 24 24">
                <g>
                    <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                </g>
            </svg>
        </button>
    </div>
  </form>
  <form action="groups/create" method="post">
    
    <button type="submit" class="button">
      <span class="button__text">New Group</span>
      <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
    </button>
  </form>
  </div>

  <?php 
    $groups=new Group();
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
    <button class="custom-btn btn-2">
        <a href="<?php echo "/groups/"."?page=".$previous_index; ?>" class="text-light">
            <i class='bx bx-chevrons-left' ></i>Previous
        </a>
    </button>
    <button class="custom-btn btn-2">
        <a href="<?php echo "/groups/"."?page=".$next_index; ?>" class="text-light">Next 
            <i class='bx bx-chevrons-right' ></i>
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