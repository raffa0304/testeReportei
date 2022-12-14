<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Repositorio", "Commits", { role: "style" } ],
        @foreach($dados as $value)
          ["{{$value->name}}", {{$value->commit}}, "gold"],
        @endforeach
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Repositorios no Github",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafico</title>

    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <div class="divGrafico">
    <div class="saudacao"> 
    <a href="/" class="logout">Logout</a>
      <h1> Seja bem vindo {{ $nomeLogin }}</h1>
    </div>
    <div id="columnchart_values" style="width: 900px; height: 300px;" class="grafico"></div>
   </div>  
</body>
</html>