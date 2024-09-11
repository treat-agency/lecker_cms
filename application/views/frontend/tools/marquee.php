<!-- reusable, css-only marquee / scrolling text banner -->


<?
  $scrollText = ($lang == LANG_DE) ? "German text..." : "English text...";
  $divider = "–";
  $link = "";
?>


<div class="marqueeBanner">
  <div class="closeMarqueeBanner">x</div>

  <a href="<?= $link ?>" class="marquee">
    <div class="marqueeElems">
      <p><?= $scrollText ?></p>
      <p><?= $divider ?></p>
      <p aria-hidden="true"><?= $scrollText ?></p>
      <p><?= $divider ?></p>
      <p aria-hidden="true"><?= $scrollText ?></p>
      <p><?= $divider ?></p>
    </div>

    <div aria-hidden="true" class="marqueeElems">
      <p><?= $scrollText ?></p>
      <p><?= $divider ?></p>
      <p><?= $scrollText ?></p>
      <p><?= $divider ?></p>
      <p><?= $scrollText ?></p>
      <p><?= $divider ?></p>
    </div>
  </a>
</div>


<script>
  $('.closeMarqueeBanner').on('click', function() {
    $(this).parent().remove();
  })
</script>


<style>
  .marqueeBanner {
    --space: 2rem;

    overflow: hidden;
    background: white;
    width: 100vw;
    height: 50px;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 10000;
    display: flex;
    align-items: center;
    gap: var(--space);
  }

  .closeMarqueeBanner {
    position: absolute;
    right: 0;
    top: 0;
    height: 50px;
    width: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    background: white;
    font-size: 20px;
    cursor: pointer;
  }

  .marquee {
    --duration: 60s;
    --gap: var(--space);

    display: flex;
    overflow: hidden;
    user-select: none;
    gap: var(--gap);
    width: 100%;
  }

  .marqueeElems {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: space-around;
    gap: var(--gap);
    min-width: 100%;
    animation: scroll var(--duration) linear infinite;
  }

  @media (prefers-reduced-motion: reduce) {
    .marqueeElems {
      animation-play-state: paused;
    }
  }

  @keyframes scroll {
    0% {
      transform: translateX(0);
    }

    100% {
      transform: translateX(calc(-100% - var(--gap)));
    }
  }
</style>