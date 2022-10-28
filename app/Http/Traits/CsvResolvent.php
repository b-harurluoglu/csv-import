<?php

namespace App\Http\Traits;

trait CsvResolvent {

    public function CsvToCollection($file) {

        $filePath = $file->getRealPath();
        $datas = collect(array_map('str_getcsv', file($filePath)))->slice(1);

        $mappedCollection = $datas->map(function($item, $key) {		
            $item = explode(';',$item[0]);
            return [
                    'row_id' => $key,
                    'name' => $item[0],
                    'surname' => $item[1],
                    'email' => $item[2],
                    'employee_id' => $item[3],
                    'phone' => $this->phoneNumberExtract($item[4]),
                    'point' => $item[5]
                ];
        });
        
        return $mappedCollection;
    }

    protected function phoneNumberExtract($phoneNumber)
    {
        $phoneNumber = trim(preg_replace('/\D/', "", $phoneNumber));

        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = substr($phoneNumber, 1);
        }

        return $phoneNumber;
    }
}