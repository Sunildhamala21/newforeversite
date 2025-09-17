<?php

namespace App\Exports;

use App\EmailSubscriber;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubscriberExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    public static $n = 1;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return EmailSubscriber::select('id', 'name', 'email', 'created_at')->get();
    }

    /**
     * @var Invoice
     */
    public function map($subscriber): array
    {
        return [
            self::$n++,
            $subscriber->name,
            $subscriber->email,
            formatDate($subscriber->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            'S.N',
            'Name',
            'Email',
            'Created At',
        ];
    }
}
