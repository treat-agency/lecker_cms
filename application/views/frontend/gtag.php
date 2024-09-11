  <!-- GTAG FUNCTIONALITY START -->

  <!-- Google tag (gtag.js) -->

  <script>
    const gtagID = 'XXX';
  </script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=XXX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'XXX'); -->
  </script>



  <!-- DENY OR GRANT GTAG -->

  <?php if ($cookie_mark == 'true') : ?>

    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('consent', 'default', {
        'ad_storage': 'granted',
        'analytics_storage': 'granted'
      });
      gtag('set', 'ads_data_redaction', true);
    </script>


  <? else : ?>

    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('consent', 'default', {
        'ad_storage': 'denied',
        'analytics_storage': 'denied'
      });
      gtag('set', 'ads_data_redaction', true);
    </script>


  <? endif; ?>


  <!-- GTAG FUNCTIONALITY END -->



  <!-- end  custom script -->