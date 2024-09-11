<style>
  .prettySmall {
    font-size: 0.8em;
    /* text-align: center; */
    color: black;
    text-decoration: none !important;
  }

  td:has(.markerColor) {
    position: relative;
    background-color: white;
  }

  td:has(.markerColor):hover {
    background-color: black;
    cursor: pointer;
  }

  td:has(.markerColor):hover a{
    color: white;

  }

  td .markerColor:before {
    content: "";

    position: absolute;
    bottom: 0;
    left: 0;

    width: 0px;
    height: 0px;
    border-style: solid;
    border-width: 10px 0 0 10px;
    rotate: 180deg;
  }

  td .markerred:before {
    border-color: red transparent transparent transparent;
  }

  td .markergreen:before {
    border-color: green transparent transparent transparent;
  }

  td .markerblue:before {
    border-color: blue transparent transparent transparent;
  }

  td:has(.teaserImageHolder):hover {
    background-color: black;
    cursor: pointer;
  }


  @media screen and (max-width: 1000px) {

    tr > td:nth-child(n+5) {
        display: none;
    }
    thead tr > td:nth-child(n+4) {
        display: none;
    }

  }


</style>


<td class="tdArt" >
    <? if($link != ''): ?>
      <a class="markerColor marker<?= $color ?>" href="<?= $link  ?>">
    <? endif ?>

    <div class="tableLink">
      <?= $text ?>
    </div>

    <? if($link != ''): ?>
        </a>
    <? endif ?>

  <? if(isset($pretty_url)): ?>
    <div class="prettySmall"><?= $pretty_url ?></div>
  <? endif ?>

</td>