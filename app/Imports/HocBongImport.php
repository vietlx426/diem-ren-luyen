<?php
  
namespace App\Imports;
  
use App\Scholarship;
use Maatwebsite\Excel\Concerns\ToModel;
  
class HocBongImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Scholarship([
            'mahb'     => $row[0],
            'tenhb'    => $row[1],
			'tendvtt'    => $row[2], 
			'gthb'    => $row[5], 
			'soluong'    => $row[6], 
            
        ]);
    }
}