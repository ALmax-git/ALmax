<div class="row g-4">
  <div class="col-sm-12 col-xl-6">
    <div class="bg-secondary h-100 rounded p-4">
      <h6 class="mb-4">{{ _app('sys_req') }}</h6>
      <canvas id="line-chart"></canvas>
    </div>
  </div>
  <div class="col-sm-12 col-xl-6">
    <div class="h-100 bg-secondary rounded p-4">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h6 class="mb-0">{{ _app('calendar') }}</h6>
        <a href="#">{{ _app('show_all') }}</a>
      </div>
      <div id="calender"></div>
    </div>
  </div>
</div>

<script src="{{ asset('build/assets/lib/chart/chart.min.js') }}"></script>

<script>
  var ctx = document.getElementById("line-chart").getContext("2d");
  var systemdChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: [],
      datasets: [{
        label: "{{ _app('req_min') }}",
        fill: true,
        lineTension: 0.3,
        borderColor: "rgba(22, 22, 235, .7)",
        backgroundColor: "rgba(22, 22, 235, .3)",
        data: []
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  function fetchsystemdData() {
    fetch('/systemd')
      .then(response => response.json())
      .then(data => {
        systemdChart.data.labels = data.map(entry => entry.created_at.substring(11, 16)); // Extract HH:mm
        systemdChart.data.datasets[0].data = data.map(entry => entry.count);
        systemdChart.update();
      })
      .catch(error => console.error("Error fetching data:", error));

    // Fetch data every 2 minutes (120,000 milliseconds)
    setTimeout(fetchsystemdData, 120000);
  }

  // Start fetching data on page load
  fetchsystemdData();
</script>
