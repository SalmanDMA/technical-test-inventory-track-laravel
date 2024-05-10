<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Facades\Excel;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [['List of Users'], [
            'No',
            'Name',
            'Email',
            'Role',
            'Address',
            'Phone',
        ]];
    }

    public function map($user): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $user->name == null ? '-' : $user->name,
            $user->email == null ? '-' : $user->email,
            $user->role == null ? '-' : $user->role,
            $user->address == null ? '-' : $user->address,
            $user->phone == null ? '-' : $user->phone,
        ];
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
