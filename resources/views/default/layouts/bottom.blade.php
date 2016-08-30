    <footer>
      <div class="container">
      <div class="row">
        <hr>
        <div class="col-xs-6">
          <p>&copy; {{config('bbb_config.user') . ' ' . date("Y")}}</p>
        </div>
        <!--
        <div class="col-xs-4 text-center">
          <p>Powered by <a href="#">B3</a></p>
        </div>
        -->
        <div class="col-xs-6 text-right">
          {{-- <h4>Elsewhere</h4> --}}
          <p>
            @if (config('bbb_config.github') !== '')
              <a href="https://www.github.com/{{config('bbb_config.github')}}">GitHub</a>
            @endif
            @if (config('bbb_config.twitter') !== '')
              <a href="https://twitter.com/{{config('bbb_config.twitter')}}">Twitter</a>
            @endif
            @if (config('bbb_config.facebook') !== '')
              <a href="https://www.facebook.com/{{config('bbb_config.facebook')}}">Facebook</a>
            @endif
          </p>
        </div>
      </div>
      </div> <!-- /container -->
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/themes/{{config('bbb_config.theme')}}/jquery.min.js"></script>
    <script src="/themes/{{config('bbb_config.theme')}}/base.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/themes/{{config('bbb_config.theme')}}/ie10-viewport-bug-workaround.js"></script>
    <script src="/themes/{{config('bbb_config.theme')}}/main.js"></script>
  </body>
</html>

