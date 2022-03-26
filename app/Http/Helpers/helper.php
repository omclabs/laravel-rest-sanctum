<?php

function format_return($data, $error, $code, $message = '')
{
  return [
    'datas' => $data,
    'errors' => $error,
    'code' => $code,
    'message' => $message
  ];
}
