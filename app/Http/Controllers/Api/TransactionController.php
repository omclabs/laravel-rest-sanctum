<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
  public function store(Request $request)
  {
    $fields = $request->validate([
      'amount' => 'required|numeric|min:0.000001',
    ]);

    try {
      DB::beginTransaction();
      $user_id = Auth::user()->id;
      $balance = Balance::where('user_id', $user_id)->first();

      if ($balance->amount_available < $fields['amount']) {
        return response()->json(format_return([], [], 422, 'Oopps insufficient balance'), 422);
      }

      Transaction::insert([
        'amount' => $fields['amount'],
        'user_id' => $user_id
      ]);

      $balance->decrement('amount_available', $fields['amount']);
      $balance->save();

      $data = [
        'user_id' => $user_id,
        'balance' => number_format($balance->amount_available, 6),
        'transaction' => number_format($fields['amount'], 6),
        'message' => 'success'
      ];

      DB::commit();
      sleep(30);
      return response()->json(format_return($data, [], 201, ''), 201);
    } catch (\Throwable $th) {
      dd($th->getMessage());
      DB::rollBack();
    }
  }
}
