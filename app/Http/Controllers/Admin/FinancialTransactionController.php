<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinancialTransaction;
use App\Exports\FinancialTransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class FinancialTransactionController extends Controller
{
    public function index()
    {
        $transactions = FinancialTransaction::latest()->take(5)->get();
        $income = FinancialTransaction::where('type', 'income')->sum('amount');
        $expense = FinancialTransaction::where('type', 'expense')->sum('amount');
        $balance = $income - $expense;
        $categoryTotals = FinancialTransaction::selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderBy('category')
            ->get();


        return view('admin.finance.index', compact('transactions', 'income', 'expense', 'balance', 'categoryTotals'));
    }

    public function create($type)
    {
        if (!auth()->user()->can_manage_facility) {
            return redirect()->route('admin.finance.index')->with('error', 'You do not have permission to access this part of the module.');
        }


        if (!in_array($type, ['income', 'expense'])) {
            abort(404);
        }

        return view('admin.finance.create', compact('type'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
        ]);

        FinancialTransaction::create($validated);

        return redirect()->route('admin.finance.index')->with('success', 'Transaction added successfully!');
    }

    public function history(Request $request)
    {
        $type = $request->input('type'); // 'income' or 'expense'
        $category = $request->input('category');
        $search = $request->input('search');

        $transactions = FinancialTransaction::query()
            ->when($type, fn($q) => $q->where('type', $type))
            ->when($category, fn($q) => $q->where('category', $category))
            ->when($search, fn($q) => $q->where('description', 'like', "%$search%"))
            ->latest()
            ->paginate(5);

        $categories = FinancialTransaction::select('category')->distinct()->pluck('category');

        return view('admin.finance.history', compact('transactions', 'type', 'category', 'search', 'categories'));
    }

    public function edit($id)
    {
        if (!auth()->user()->can_manage_facility) {
            return redirect()->route('admin.finance.history')->with('error', 'You do not have permission to access this part of the module.');
        }

        $transaction = FinancialTransaction::findOrFail($id);
        return view('admin.finance.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $transaction = FinancialTransaction::findOrFail($id);
        $transaction->update($request->all());

        return redirect()->route('admin.finance.history')->with('success', 'Transaction updated.');
    }

    public function destroy($id)
    {
        if (!auth()->user()->can_manage_facility) {
            return redirect()->route('admin.finance.history')->with('error', 'You do not have permission to access this part of the module.');
        }

        FinancialTransaction::findOrFail($id)->delete();
        return redirect()->route('admin.finance.history')->with('success', 'Transaction deleted.');
    }

    public function categorySummary()
    {
        $summary = FinancialTransaction::select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->get();

        return response()->json($summary);
    }

    public function export()
    {
        if (!auth()->user()->can_manage_facility) {
            return redirect()->route('admin.finance.history')->with('error', 'You do not have permission to access this part of the module.');
        }
        
        return Excel::download(new FinancialTransactionsExport, 'financial_transactions.xlsx');
    }
}
