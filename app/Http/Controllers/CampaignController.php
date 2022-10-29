<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Http\Traits\CsvResolvent;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Campaign\StoreCampaignRequest;
use App\Http\Requests\Campaign\StoreCampaignUserRequest;
use App\Models\CampaignUser;

class CampaignController extends Controller
{
    use CsvResolvent;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignRequest $request)
    {
        $campaign = Campaign::create([
            'name' => $request->input('name'),
            'date' => $request->input('date').'-01'
        ]);

        $datas = $this->csvToCollection($request->file('file'));

        $importend = collect();
        $notImportend = collect();

        foreach ($datas as $data) {
     
            $validator = Validator::make($data, (new StoreCampaignUserRequest)->rules($data, $campaign) );
   
            if ($validator->fails()) {
                $notImportend->push(['data' => $data , 'errors' => $validator->errors()]);
            } else {
                $CampaignUser = $campaign->users()->create($validator->validated());
                if($CampaignUser) {
                    $importend->push(['data' => $data]);
                }
            }

        }

        return response()->json([
            'success' => true,
            'importend' => $importend,
            'notImportend' => $notImportend
        ]);
    }
}
