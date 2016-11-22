    <footer>
      <div class="container">
      <div class="row">
        <div class="col-sm-4">
          <p>&copy; {{date("Y")}} <a href="mailto:{{config('b3_config.email')}}">{{config('b3_config.user')}}</a></p>
        </div>

        <div class="col-sm-4 text-center">
          <p>Powered by <a href="https://github.com/eivind88/b3">B3</a></p>
        </div>

        <div class="col-sm-4 text-right">
          <p>
            @if (config('b3_config.github') !== '')
              <a href="https://www.github.com/{{config('b3_config.github')}}">GitHub</a>
            @endif
            @if (config('b3_config.twitter') !== '')
              <a href="https://twitter.com/{{config('b3_config.twitter')}}">Twitter</a>
            @endif
            @if (config('b3_config.facebook') !== '')
              <a href="https://www.facebook.com/{{config('b3_config.facebook')}}">Facebook</a>
            @endif
          </p>
        </div>
      </div>
      </div> <!-- /container -->
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/themes/{{config('b3_config.theme')}}/assets/dist/jquery.min.2a055a6f6193b209.js"></script>
    <script src="/themes/{{config('b3_config.theme')}}/assets/dist/base.min.700893705ebbf955.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/themes/{{config('b3_config.theme')}}/assets/ie10-viewport-bug-workaround.js"></script>
    <script src="/themes/{{config('b3_config.theme')}}/assets/dist/main.min.75af0bbd89c8dece.js"></script>
  </body>
</html>

