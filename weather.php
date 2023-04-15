<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body style="background-image: url('white.jpg'); background-size:cover;">

  <section class="mt-5" >
    <div class="container py-5 h-60">
      <div class="row d-flex justify-content-center align-items-center h-60">
        <div class="col-md-10 col-lg-5 col-xl-8">

          <div class="card bg-dark text-white" >
            <div class="bg-image" style="border-radius: 35px;">
              <img src="gif3.gif"
                class="card-img" alt="weather" />
              <div class="mask" style="background-color: rgba(190, 216, 232, .5);"></div>
            </div>
            <div class="card-img-overlay text-dark p-5">
            <form method="GET" class="mb-2">
                <input type="text" name="city"  placeholder="Enter a city name" value="<?php echo isset($_GET['city']) ? $_GET['city'] : ''; ?>">
                <input type="submit" value="Search" class="btn btn-primary">
            </form>
                 <?php
                    function celsius($value){
                        $cel=($value-32)/1.8;
                        return round($cel,2);
                    }
                ?>
                <?php
                    if (isset($_GET['city']) && !empty($_GET['city'])) {
                        $city = urlencode($_GET['city']);
                        $api_="https://api.openweathermap.org/data/2.5/forecast?q={$city}&appid=a159834a33402f8a8b6b61c3f85db54e&units=imperial";
                        $data=file_get_contents($api_);
                        $cache = "cache.json";
                        file_put_contents($cache,$data);
                        $data=json_decode($data,true);

                        $forecasts = [];

                        foreach ($data['list'] as $forecast) {
                            $date = date('Y-m-d', $forecast['dt']);
                            if (!isset($forecasts[$date])) {
                                $forecasts[$date] = $forecast;
                            }
                        }
                    ?>
                    

            <h4 class="mb-0"><?php echo $data['city']['name'].', '.$data['city']['country'] ?></h4>
              <p class="display-2 my-3"><?php echo celsius($data['list'][0]['main']['temp']); ?> °C</p>

              <p class="mb-2">Feels Like: <strong><?php echo celsius($data['list'][0]['main']['feels_like']); ?> °C</strong></p>
              <h5 class="text-capitalize"><?php echo $data['list'][0]['weather'][0]['description']; ?></h5>
              <ul class="mt-5 pt-5 list-group list-group-horizontal position-relative overflow-auto w-100" style="opacity: 75%;">


              <?php $loop=0; foreach($forecasts as $f) { $loop++;
              if ($loop>5) {break;}
    ?>

    <div style="min-width: 20%; border-radius: 20px; padding:3px;">
        <li class="list-group-item my-3 " ><p class="fw-bold"><?php echo date('l',$f['dt']);?></p>
            <p>Minimum Temp: <strong><?php echo celsius($f['main']['temp_min']); ?> °C</strong></p>
            <p>Maximum Temp: <strong><?php echo celsius($f['main']['temp_max']); ?> °C</strong></p>
        </li>
    </div>

<?php } ?>

<?php 
    }
    else{
        echo "<p>Error: Invalid city name.</p>";
    }
?>

</ul>
</div>
</div>
</div>
</div>
</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>