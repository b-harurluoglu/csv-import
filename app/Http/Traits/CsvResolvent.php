<?php

namespace App\Http\Traits;

trait CsvResolvent {

    public function csvToCollection($file) {

        $filePath = $file->getRealPath();
        $datas = collect(array_map('str_getcsv', file($filePath)))->slice(1);

        $mappedCollection = $datas->map(function($item, $key) {		
            $item = explode(';',$item[0]);
            return [
                    'row_id' => $key,
                    'name' => $item[0],
                    'surname' => $item[1],
                    'email' => $this->purgeEmail($item[2]),
                    'employee_id' => $item[3],
                    'phone' => $this->purgePhoneNumber($item[4]),
                    'point' => $item[5]
                ];
        });
        
        return $mappedCollection;
    }

    protected function purgePhoneNumber($phoneNumber)
    {
        $phoneNumber = trim(preg_replace('/\D/', "", $phoneNumber));

        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = substr($phoneNumber, 1);
        }

        return $phoneNumber;
    }

    protected function purgeEmail($email) {
        return str_replace(
            ['ğ', 'ü',  'ö', 'ı', 'ş', 'ç'],
            ['g', 'u',  'o', 'i', 's', 'c'],
            strtolower($email)
        );
    }
}