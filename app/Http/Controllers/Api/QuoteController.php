<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
  public function index(Request $request)
  {
    $source = 'https://api.chucknorris.io/jokes/random';

    try {
      $client = new Client();
      $res = $client->request('GET', $source, [
        'headers' => [
          'Accept' => 'application/json',
          'Content-type' => 'application/json'
        ]
      ]);

      $body = json_decode($res->getBody());

      return response()->json(format_return($body, [], 200, ''), 200);
    } catch (\Throwable $th) {
      return response()->json(format_return([], [], $th->getCode(), $th->getMessage()), $th->getCode());
    }
  }
}
