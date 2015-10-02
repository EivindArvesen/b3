    <footer>
      <div class="container">
        <hr>
        <div class="col-xs-6">
          <p>&copy; <?php echo config('bbb_config.user') . ' ' . date("Y"); ?></p>
        </div>
        <div class="col-xs-6 text-right">
          {{-- <h4>Elsewhere</h4> --}}
          <p>
            <a href="#">GitHub</a>&nbsp;&nbsp;&nbsp;
            <a href="#">Twitter</a>&nbsp;&nbsp;&nbsp;
            <a href="#">Facebook</a><br /><br />
          </p>
        </div>
      </div> <!-- /container -->
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/themes/<?php echo config('bbb_config.theme'); ?>/jquery.min.js"></script>
    <script src="/themes/<?php echo config('bbb_config.theme'); ?>/base.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/themes/<?php echo config('bbb_config.theme'); ?>/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

