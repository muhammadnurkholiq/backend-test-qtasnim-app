<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $item_name = $request->query('item_name');
        $sort_by = $request->query('sort_by', 'transaction_date');
        $order = $request->query('order', 'asc');

        $query = Transaction::query();

        if ($item_name) {
            $query->where('item_name', 'like', '%' . $item_name . '%');
        }
        if ($start_date) {
            $query->where('transaction_date', '>=', $start_date);
        }
        if ($end_date) {
            $query->where('transaction_date', '<=', $end_date);
        }

        $query->orderBy($sort_by, $order);

        $transactions = $query->get();

        if ($transactions->isEmpty()) {
            return response()->json(['message' => 'No transactions found'], 404);
        }

        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string',
            'stock' => 'required|integer',
            'quantity_sold' => 'required|integer',
            'transaction_date' => 'required|date',
            'item_type' => 'required|string',
        ]);

        $transaction = Transaction::create($request->all());
        return response()->json($transaction, 201);
    }

    public function show($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return response()->json($transaction);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->update($request->all());
        return response()->json($transaction);
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->delete();
        return response()->json(['message' => 'Transaction deleted']);
    }

    public function getSoldItems()
    {
        $query = Transaction::query();
        $transactions = $query->get();

        if ($transactions->isEmpty()) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return response()->json($transactions);
    }
}
