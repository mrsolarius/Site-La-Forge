function menuResponsive() {
  var x = document.getElementById("bardenavigation");
  var icon = document.getElementById("nav-icon");
  if (x.className === "topnav") {
    x.className += " responsive";
    icon.className += "open";
    x.style.backgroundColor=red;
  } else {
    x.className = "topnav";
    icon.className = "";
  }
}

