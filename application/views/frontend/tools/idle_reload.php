<!-- script snippet to reload a page on idle -->

<script>
  function inactivityTime() {
    let minutes = 0.1; // minutes until reload
    let timer;

    window.onload = timerReset;

    // specify the listeners you need here
    document.onkeypress = timerReset;
    document.onmousemove = timerReset;
    document.onmousedown = timerReset;
    document.ontouchstart = timerReset;
    document.onclick = timerReset;
    document.onscroll = timerReset;
    document.onkeypress = timerReset;

    function timerElapsed() {
      // console.log("timer elapsed");
      location.reload();
    };

    function timerReset() {
      // console.log("resetting timer");
      clearTimeout(timer);
      timer = setTimeout(timerElapsed, minutes * 60 * 1000);
    }
  };

  inactivityTime();
</script>