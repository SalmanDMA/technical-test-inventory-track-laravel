<?php

namespace App\Exports;

use App\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Facades\Excel;

class ActivityExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if (auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin') {
            return Activity::all();
        } else {
            return Activity::where('user_id', auth()->user()->id)->get();
        };
    }

    public function headings(): array
    {
        return [
            ['List of Activities'],
            [
                'No',
                'User Name',
                'User Email',
                'Avatar',
                'Item Name',
                'Item Image',
                'Quantity',
                'Date',
                'Type',
            ]
        ];
    }

    public function map($activity): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            optional($activity->user)->name ?? '-',
            optional($activity->user)->email ?? '-',
            optional($activity->user)->avatar ? optional($activity->user)->avatar : '-',
            optional($activity->item)->name ?? '-',
            optional($activity->item)->image ? optional($activity->item)->image : '-',
            $activity->quantity ?? '-',
            $activity->created_at ? $activity->created_at->format('d-m-Y') : '-',
            $activity->type ?? '-',
        ];
    }

    public function export()
    {
        return Excel::download(new ActivityExport, 'activity.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
