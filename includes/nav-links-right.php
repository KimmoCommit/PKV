
<form method='post'>
  <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
     <a href='#' class='dropdown-toggle' data-toggle='dropdown'><?php print($account->getfName()) ?> <?php print($account->getlName()) ?> <b class='caret'></b></a>
     <ul class="dropdown-menu">
      <li><a href="accprofile.php">Profiili</a></li>
       <li><a href="#">Asetukset</a></li>
       <li class="divider"></li>
       <li><a href="?logout">Kirjaudu ulos</a></li>
     </ul>
   </li>
 </ul>
</form>