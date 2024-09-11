<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test PDF Template</title>
  <style>
    body {
      font-family: Helvetica, sans-serif;
      margin: 0;
      padding: 0;
    }

    header {
      text-align: center;
      padding: 20px 0;
      background-color: #f2f2f2;
    }

    footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      text-align: center;
      padding: 10px 0;
      background-color: #f2f2f2;
    }

    .content {
      padding: 20px;
    }
  </style>
</head>

<body>

  <header>
    <h1>Test PDF Template</h1>
  </header>

  <div class="content">
    <p>This is a test PDF template created using HTML.</p>
    <p>You can add your content here.</p>
  </div>

  <footer>
    FOOTER
  </footer>

  <!-- display page numbers -->
  <script type="text/php">
    if ( isset($pdf) ) {
      $x = 550;
      $y = 805;
      // $text = "{PAGE_NUM} of {PAGE_COUNT}";
      $text = "{PAGE_NUM}";
      $font = $fontMetrics->get_font("nhaas-reg", "regular");
      $size = 12;
      $color = array(0,0,0);
      $word_space = 0.0;  //  default
      $char_space = 0.0;  //  default
      $angle = 0.0;   //  default
      $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
  </script>

</body>

</html>