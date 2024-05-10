<?php

namespace App\Exports;

use App\Models\Activity;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Facades\Excel;

class LoanExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $userId = auth()->user()->id;
        return Activity::with('item')->where('user_id', $userId)->where('type', 'loan')->get();
    }

    public function headings(): array
    {
        return [
            ['List of Loan'],
            [
                'No',
                'Name Item',
                'Image',
                'Quantity',
                'Date',
            ]
        ];
    }

    public function map($activity): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            optional($activity->item)->name ?? '-',
            optional($activity->item)->image ? optional($activity->item)->image : '-',
            $activity->quantity ?? '-',
            $activity->created_at ? $activity->created_at->format('d-m-Y') : '-',
        ];
    }

    public function export()
    {
        return Excel::download(new LoanExport, 'loan.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
