<?php     
    $groupId = $_GET['id'];
    // get data of group by its id and show it in fields 
    $group = new Group();
    $g = $group ->showGroupByID($groupId);
    $g = $g[0];
    $handler = new MYSQLHandler();
    $sql = "SELECT * FROM users INNER JOIN groups ON users.gid = groups.gid where groups.gid = $groupId";
    $results = $handler->get_results($sql);
?>
<style>
    .card {
  width: 252px;
  height: 265px;
  background: white;
  border-radius: 30px;
  box-shadow: 15px 15px 30px #bebebe,
             -15px -15px 30px #ffffff;
  transition: 0.2s ease-in-out;
}

.img {
  width: 100%;
  height: 50%;
  border-top-left-radius: 30px;
  border-top-right-radius: 30px;
  background: linear-gradient(#e66465, #9198e5);
  display: flex;
  align-items: top;
  justify-content: right;
}

.save {
  transition: 0.2s ease-in-out;
  border-radius: 10px;
  margin: 20px;
  width: 30px;
  height: 30px;
  background-color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
}

.text {
  margin: 20px;
  display: flex;
  flex-direction: column;
  align-items: space-around;
}

.save .svg {
  transition: 0.2s ease-in-out;
  width: 15px;
  height: 15px;
}

.icon-box {
  margin-top: 15px;
  width: 70%;
  padding: 10px;
  background-color: #e3fff9;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: left;
}

.icon-box svg {
  width: 17px;
}

.text .h3 {
  font-family: 'Lucida Sans' sans-serif;
  font-size: 15px;
  font-weight: 600;
  color: black;
}

.text .p {
  font-family: 'Lucida Sans' sans-serif;
  color: #999999;
  font-size: 13px;
}

.icon-box .span {
  margin-left: 10px;
  font-family: 'Lucida Sans' sans-serif;
  font-size: 13px;
  font-weight: 500;
  color: #9198e5;
}

.card:hover {
  cursor: pointer;
  box-shadow: 0px 10px 20px rgba(0,0,0,0.1);
}

.save:hover {
  transform: scale(1.1) rotate(10deg);
}

.save:hover .svg {
  fill: #ced8de;
}
</style>
<section class="groupSection ">
    <div class="showGroup d-flex gap-5 mx-auto "  style=" width:600px; background-color: rgba(255, 255, 255, 0.397); border-radius:20px;" >
        <div class="groupImg " >
            <img  style="border-radius:20px; width: 300px; height:400px;" src="../../../assets/Images/<?php echo $g['avatar'] ?>" alt="">
        </div>
        <div class="d-flex flex-column">
            <h1><?php echo $g["gname"]; ?></h1>
            <h4><?php echo $g["description"]; ?></h4>
            <?php 
                foreach ($results as $row) { ?>
                <h1><?php echo $row['uname']; ?></h1>
            <?php }?>
        </div>
    </div>


    <!--  -->

    <div class="card">
        <div class="img">
            <div class="save">
    <svg class="svg" width="683" height="683" viewBox="0 0 683 683" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#clip0_993_25)">
        <mask id="mask0_993_25" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="683" height="683">
        <path d="M0 -0.00012207H682.667V682.667H0V-0.00012207Z" fill="white"></path>
        </mask>
        <g mask="url(#mask0_993_25)">
        <path d="M148.535 19.9999C137.179 19.9999 126.256 24.5092 118.223 32.5532C110.188 40.5866 105.689 51.4799 105.689 62.8439V633.382C105.689 649.556 118.757 662.667 134.931 662.667H135.039C143.715 662.667 151.961 659.218 158.067 653.09C186.451 624.728 270.212 540.966 304.809 506.434C314.449 496.741 327.623 491.289 341.335 491.289C355.045 491.289 368.22 496.741 377.859 506.434C412.563 541.074 496.752 625.242 524.816 653.348C530.813 659.314 538.845 662.667 547.308 662.667C563.697 662.667 576.979 649.395 576.979 633.019V62.8439C576.979 51.4799 572.48 40.5866 564.447 32.5532C556.412 24.5092 545.489 19.9999 534.133 19.9999H148.535Z" stroke="#CED8DE" stroke-width="40" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
        </g>
        </g>
        <defs>
        <clipPath id="clip0_993_25">
        <rect width="682.667" height="682.667" fill="white"></rect>
        </clipPath>
        </defs>
            </svg>
            </div>
        </div>

        <div class="text">
            <p class="h3"> <?php echo $g["gname"]; ?></p>
            <p class="p"><?php echo $g["description"]; ?></p>

            <div class="icon-box">
            <svg version="1.1" class="svg" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve">
        <g>
            <path style="fill:#3D6687;" d="M165,68.715l-26.327-26.327l37.363-37.363c3.739-3.739,9.801-3.739,13.54,0l12.786,12.786
                c3.739,3.739,3.739,9.801,0,13.54L165,68.715z"></path>
            <path style="fill:#3D6687;" d="M234.998,101.725l-26.327-26.327l37.363-37.363c3.739-3.739,9.801-3.739,13.54,0l12.786,12.786
                c3.739,3.739,3.739,9.801,0,13.54L234.998,101.725z"></path>
            <path style="fill:#3D6687;" d="M445.507,349.222l26.327,26.327l37.363-37.363c3.739-3.739,3.739-9.801,0-13.54l-12.787-12.787
                c-3.739-3.739-9.801-3.739-13.54,0L445.507,349.222z"></path>
            <path style="fill:#3D6687;" d="M408.054,279.224l26.327,26.327l37.363-37.363c3.739-3.739,3.739-9.801,0-13.54l-12.786-12.786
                c-3.739-3.739-9.801-3.739-13.54,0L408.054,279.224z"></path>
        </g>
        <g>
            <path style="fill:#CCDFED;" d="M443.378,458.836L276.261,234.948L52.372,67.83c-7.845-5.856-8.673-17.309-1.75-24.232
                l22.953-22.954c10.277-10.277,25.733-13.35,39.158-7.785l272.626,112.989l112.989,272.626c5.564,13.427,2.491,28.882-7.785,39.158
                l-22.953,22.953C460.688,467.51,449.234,466.683,443.378,458.836z"></path>
            <path style="fill:#CCDFED;" d="M181.785,507.029L104.93,404.848L2.75,327.993c-3.349-2.518-3.694-7.418-0.73-10.381l11.782-11.782
                c7.939-7.939,19.965-10.129,30.193-5.499l113.895,51.558l51.558,113.895c4.63,10.228,2.439,22.254-5.499,30.193l-11.783,11.782
                C189.203,510.722,184.303,510.378,181.785,507.029z"></path>
        </g>
        <g>
            <path style="fill:#BAD5E5;" d="M209.448,465.784l-17.656-39.003l0,0L180.8,437.772c-9.575,9.575-25.407,8.461-33.546-2.361
                l-31.288-41.599l-0.098,0.097L7.359,312.273l0,0l-5.34,5.34c-2.963,2.963-2.618,7.862,0.73,10.381l102.181,76.855l76.855,102.181
                c2.518,3.349,7.418,3.694,10.381,0.73l11.783-11.783C211.887,488.038,214.078,476.012,209.448,465.784z"></path>
            <path style="fill:#BAD5E5;" d="M497.749,427.311c0.462-0.999,0.894-2.01,1.261-3.045c0.754-2.12,1.283-4.309,1.628-6.528
                c0.991-6.38,0.291-13.038-2.289-19.265l-16.424-39.63l-1.043-2.517c-0.973,7.762-4.471,15.169-10.243,20.941l-22.953,22.953
                c-6.923,6.923-18.375,6.096-24.232-1.75L290.651,220.557L52.357,41.862l-1.735,1.735c-4.549,4.549-5.73,11.047-3.795,16.634
                c1.01,2.917,2.855,5.589,5.545,7.597l145.464,108.579l78.425,58.539l58.539,78.425l108.579,145.464
                c2.008,2.691,4.681,4.535,7.597,5.545c5.587,1.935,12.086,0.754,16.635-3.795l22.953-22.953
                C493.61,434.588,496.005,431.079,497.749,427.311z"></path>
        </g>
        <path style="fill:#61AFF6;" d="M104.914,432.283L104.914,432.283c-17.494,8.348-35.767-9.925-27.419-27.419l0,0
            c18.554-38.883,42.253-75.095,70.46-107.661L341.791,73.417c28.676-33.108,69.054-53.832,112.672-57.831l11.885-1.089
            c16.568-1.519,30.453,12.365,28.935,28.934l-1.089,11.885c-3.999,43.617-24.724,83.995-57.831,112.672L212.576,361.824
            C180.009,390.03,143.799,413.73,104.914,432.283z"></path>
        <path style="fill:#399AEA;" d="M494.193,55.316l1.089-11.885c1.519-16.568-12.366-30.453-28.935-28.934l-11.885,1.089
            c-0.155,0.014-0.309,0.034-0.464,0.048c-4.103,43.439-24.793,83.633-57.783,112.208L81.614,428.357
            c5.715,5.643,14.603,8.077,23.3,3.926l0,0c38.883-18.553,75.095-42.253,107.661-70.459l223.786-193.836
            C469.469,139.311,490.194,98.934,494.193,55.316z"></path>
        <path style="fill:#FFFFFF;" d="M400.892,56.26c-4.215-0.36-7.923,2.765-8.285,6.978c-0.36,4.214,2.765,7.924,6.978,8.285
            c22.969,1.966,36.702,15.7,38.667,38.667c0.161,1.871,0.981,3.528,2.213,4.76c1.542,1.542,3.729,2.418,6.071,2.218
            c4.215-0.361,7.339-4.07,6.978-8.285C450.92,78.531,431.246,58.856,400.892,56.26z"></path>
        <path style="fill:#CCDFED;" d="M446.539,117.17c4.215-0.361,7.339-4.07,6.978-8.285c-1.271-14.849-6.637-27.132-15.331-36.121
            c-2.36,4.942-4.957,9.768-7.785,14.46c4.392,6.071,7.067,13.778,7.853,22.967c0.161,1.871,0.981,3.528,2.213,4.76
            C442.01,116.493,444.197,117.371,446.539,117.17z"></path>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
            </svg>
            <p class="span">Business Trip
            </p></div>
        </div>
    </div>

</section>