<? 

// maybe deleted at some point


$cutArray = array_slice($report, 0 , 12); 


$cities = array();
$number = array();

foreach($cutArray as $elem) {
    $cities[] = $elem['city'];
    $number[] = $elem['number'];
}

?>

<script>
    var cities = <?php echo json_encode($cities); ?>;
    var number = <?php echo json_encode($number); ?>;

    console.log(cities)
    console.log(number)
</script>


<div>
  <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: cities,
      datasets: [{
        label: '# of visits',
        data: number,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
