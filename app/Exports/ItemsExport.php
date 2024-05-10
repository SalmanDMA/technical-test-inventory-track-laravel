<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Facades\Excel;

class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Item::all();
    }

    public function headings(): array
    {
        return [
            ['List of Items'],
            [
                'No',
                'Name Item',
                'Image',
                'Availability',
                'Quanity',
            ]
        ];
    }

    public function map($item): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $item->name == null ? '-' : $item->name,
            $item->image == null ? '-' : $item->image,
            $item->availability == null ? '-' : $item->availability,
            $item->quantity == null ? '-' : $item->quantity
        ];
    }

    public function export()
    {
        return Excel::download(new ItemsExport, 'items.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
