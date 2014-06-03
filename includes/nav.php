  <nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navi">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">SKLV-järjestelmä</a>
      </div>

      <div class="collapse navbar-collapse" id="navi">

       <?php if(isset($_SESSION["account"])){
        include 'includes/nav-links-normal.php';
      } ?>

      

      <?php  if(isset($_SESSION["account"])) {
        include 'includes/nav-links-right.php';}
        ?>


      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
