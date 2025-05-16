<?php

namespace App\Exports;

use App\Models\ChatHistory;
use Maatwebsite\Excel\Concerns\FromCollection;

class ChatHistoryExport implements FromCollection
{
    protected $records;

    public function __construct($records)
    {
        $this->records = $records;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->records;
    }
}
