<?php

namespace App\Exports;


use App\HocBong;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Facades\Excel;
 
class ExportController implements FromCollection
{
    public function collection()
    {
    	return HocBong::select('id','tenhb')->get();
    }
}
