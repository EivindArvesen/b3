    <div class="container">
      <hr>

      <footer>
        <div class="col-md-6">
          <p>&copy; <?php echo config('bbb_config.user'); ?> 2015</p>
        </div>
        <div class="col-md-6 text-right">
          <h4>Elsewhere</h4>
          <p>
            <a href="#">GitHub</a>&nbsp;&nbsp;&nbsp;
            <a href="#">Twitter</a>&nbsp;&nbsp;&nbsp;
            <a href="#">Facebook</a><br /><br />
          </p>
        </div>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="/themes/<?php echo config('bbb_config.theme'); ?>/base.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/themes/<?php echo config('bbb_config.theme'); ?>/ie10-viewport-bug-workaround.js"></script>
    <?php
    if (getenv('APP_ENV')=='local') {
      echo '<script src="/bower_components/livereload-js/dist/livereload.js"></script>';
    }
    ?>
  </body>
</html>

