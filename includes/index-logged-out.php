<div class='panel panel-default login-panel'>
  <div class='panel-heading'>
    <h3 class='panel-title'>Kirjautuminen</h3>
  </div>
  <div class='panel-body'>
    <form accept-charset='UTF-8' role='form' method='post'>
      <fieldset>
        <div class='form-group'>
          <label for="email">Sähköposti</label>
          <input id="email" class='form-control'  name='email' type='text' value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email'],ENT_QUOTES,"UTF-8");}?>">
          <?php
          if(isset($_POST['email'])){
            print("<div class='custom-alert'>". $theaccount->getError($emailError) . "</div>");
            }
          ?> 
        </div>
        <div class='form-group'>
          <label for="passwd">Salasana</label>
          <input class='form-control' id="passwd" name='passwd' type='password' value="" autocomplete="off">
        </div>
        <div class='checkbox'>
          <label>
            <input name='remember' type='checkbox' value='Remember Me'> Muista käyttäjätunnus
          </label>
        </div>
          <?php
          if(isset($_POST['email'])){
            print("<div class='custom-alert'>". $message->getMessageBody() . "</div><br>");
            }
          ?> 
        <input type="hidden" name="token" value='<?php echo Token::generate(); ?>'>
        <input class='btn btn-lg btn-success btn-block' type='submit' value='Kirjaudu sisään' name='login'>
      </fieldset>
    </form>

    <a href="#"  data-toggle="modal" data-target="#tos">
      Käyttöehdot
    </a>
    <div class="modal fade" id="tos" tabindex="-1" role="dialog" aria-labelledby="tosLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="tosLabel">Käyttöehdot</h4>
          </div>
          <div class="modal-body">
           Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-primary" data-dismiss="modal">Sulje</button>

         </div>
       </div>
     </div>
   </div>




 </div>

</div>
