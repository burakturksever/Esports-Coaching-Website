<nav>
  <style>
    .cNavButton {
    width: 200px !important;
    height: 60% !important;
    border-radius: 20px !important;
    font-size: 1.2em !important;
    font-family: 'Roboto', sans-serif !important;
    } 
    .cNavButton:hover {
      filter: brightness(120%);     
    }
    .btn {
      text-transform: none;
    }
  </style>
    <div class="nav-wrapper grey darken-3">
      <a href="index.php" class="brand-logo" style="margin: 0 0 0 1.2em;">e-Sports Coaching</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down" style="margin: 0 3em 0 0">
        <li>You are logged in as <span class="red-text" style="font-size: 1.1em"><?=isset($_SESSION["username"]) ? $_SESSION["username"] : ""?></span></li>
        <li><a href="logout.php" class="grey-text">Logout</a></li>
      </ul>
    </div>
</nav>