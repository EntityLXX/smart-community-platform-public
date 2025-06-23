<?php

namespace App\Exports;

use App\Models\FinancialTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FinancialTransactionsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return FinancialTransaction::select('id', 'type', 'category', 'description', 'amount', 'date')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Type', 'Category', 'Description', 'Amount', 'Date'];
    }
}
