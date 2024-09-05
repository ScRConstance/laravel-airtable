<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Zadorin\Airtable\Client;

class GetDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Schema::hasTable('api_site')) {
            $api_site = DB::table('api_site')->first();
        }
        if(isset($api_site->access_key)) {
            $client = new Client($api_site->access_key, $api_site->base_id);
        }
        else {
            $client = new Client(env("AIRTABLE_KEY"), env("AIRTABLE_BASE"));
        }
        $tableModels = 'models';
        $parents = $client->table($tableModels)
            ->select('*')
            ->orderBy(['parents' => 'desc'])
            ->orderBy(['number' => 'desc'])
            ->execute()
            ->asArray();
        $parent_number = '';
        return view('api.getdata', [
            'items' => $parents,
            'parent_number' => $parent_number,
        ]);
    }

}
