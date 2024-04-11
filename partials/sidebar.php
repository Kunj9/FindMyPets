<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: "Lato", sans-serif;
}

.sidebar {
  height: 100%;
  width: 0;
  z-index: 1;
  top: 115px;
  left: 0;
  background-color: #dcdcdc;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
  position: absolute;

}

.sidebar a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #000;
  display: block;
  transition: 0.3s;
}

.sidebar a:hover {
  color: #c7c7c7;
}

.sidebar .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

.openbtn {
  font-size: 20px;
  cursor: pointer;
  background-color: #48d1cc;
  color: white;
  padding: 10px 15px;
  border: none;
}

.openbtn:hover {
  background-color: #cfecec;
}

#main {
  transition: margin-left .5s;
  padding: 16px;
}

/* For smaller screens, adjust sidebar size dynamically */
@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}
</style>
</head>
<body>

<div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  <a href="#">Profile</a>
  <a href="userhistory.php">My Posts</a>
  <a href="#">Pet Groomers</a>
  <a href="#">Pet Sitters</a>
</div>

<div id="main">
  <button class="openbtn" onclick="openNav()">☰ More </button>
</div>

<script>
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>
   
</body>
</html> 
