<?php

$api_account = '';
$api_license_key = '';

require dirname(__FILE__) . '/vendor/autoload.php';
use GeoIp2\WebService\Client;

if($_GET) {
    if(isset($_GET['ip-address'])) {

        $ip = $_GET['ip-address'];
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $client = new Client($api_account, $api_license_key);
            $record = $client->city($ip);
            if($record) {
                $city_name = $record->city->name;
                $postal_code = $record->postal->code;
            }
        } else {
            $error = "$ip is not a valid IP address";
        }

    }
}

if(isset($_SERVER['REMOTE_ADDR'])) $place_ip = $_SERVER['REMOTE_ADDR'];

?><!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
  <main role="main" class="flex-shrink-0">
      <div class="container">
          <h1 class="mt-5">IP Lookup</h1>
          <form class="form-inline">
              <div class="form-group mx-sm-3 mb-2">
                  <label for="ip-address" class="sr-only">Password</label>
                  <input type="text" class="form-control" name="ip-address" id="ip-address" placeholder="<?=@$place_ip?>" value="<?=@$ip?>">
              </div>
              <button type="submit" class="btn btn-primary mb-2">Search</button>
          </form>

          <? if(@$record): ?>
          <p class="lead">City name: <?=@$city_name?></p>
          <p class="lead">Postal code: <?=@$postal_code?></p>
          <? elseif(@$error): ?>
          <p class="lead"><?=@$error?></p>
          <? endif; ?>
      </div>
  </main>

  </body>
</html>