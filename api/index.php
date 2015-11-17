<?php
require 'vendor/autoload.php';
require 'database/ConnectionGuest.php';
require 'guests/GuestsService.php';

$app = new \Slim\Slim();


$app->get('/', function() use ( $app ) {
    echo "Welcome to Guests REST API";
});

/*
HTTP GET /api/guests
RESPONSE 200 OK 
[
  {
    "id": "1",
    "name": "Lidy Segura",
    "email": "lidyber@gmail.com"
  },
  {
    "id": "2",
    "name": "Edy Segura",
    "email": "edysegura@gmail.com"
  }
]
*/

$app->get('/api/guests', function() use ( $app ) {
    $guests = GuestsService::listGuests();
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($guests);
    
});

/*HTTP POST /api/guests
REQUEST Body 
{
	"name": "Lidy Segura",
	"email": "lidyber@gmail.com"
}

RESPONSE 200 OK 
{
  "name": "This is a test",
  "email": "test@gmail.com",
  "id": "1"
}

*/
$app->post('/api/guests', function() use ( $app ) {
    $guestJson = $app->request()->getBody();
    $newguest = json_decode($guestJson, true);
    if($newguest) {
        $guest = GuestsService::add($newguest);
        echo " {$guest} added";
    }
    else {
        $app->response->setStatus(400);
        echo "Malformat JSON";
    }
});


/*
HTTP DELETE /api/guests/:id
RESPONSE 200 OK 
{
  "status": "true",
  "message": "Guest deleted!"
}

*/
$app->delete('/api/guests/:id', function($id) use ( $app ) {
    if(GuestsService::delete($id)) {
      echo "Guest deleted!";
    }
    else {
      $app->response->setStatus('404');
      echo "Guest with id = $id not found";
    }
});

/*
HTTP DELETE /api/guests/x
RESPONSE 404 NOT FOUND 
{
  "status": "false",
  "message": "Guest with x does not exit"
}
*/
$app->delete('/api/guests/', function() use ( $app ) {
    if(GuestsService::delete($guests)) {
      echo "Guest deleted!";
    }
    else {
      $app->response->setStatus('404');
      echo "Guest with x does not exit";
    }
});


$app->run();
?>