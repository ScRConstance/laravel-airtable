<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Zadorin\Airtable\Client;

class InsertDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('api.insertindex');
    }
    public function insertdata()
    {
        $client = new Client(env("AIRTABLE_KEY"), env("AIRTABLE_BASE"));
        $tableModels = 'models';
        $dataset = $client->table($tableModels)
            ->select('*')
            ->paginate(100);
        while ($items = $dataset->nextPage()) {
            $items = $items->asArray();
            foreach ($items as $item)
            {
                DB::table('models')
                    ->updateOrInsert(
                        ['number' => $item["number"]],
                        ['description' => $item["description"] ?? "",
                            'unit' => $item["unit"] ?? "",
                            'note' => $item["note"] ?? "",
                            'interchangeable_with' => $item["interchangeable_with"] ?? "",
                            'parents' => isset($item["parents"]) ? serialize($item["parents"]) : "",
                            'children' => isset($item["children"]) ? serialize($item["children"]) : "",
                            'services' => isset($item["services"]) ? serialize($item["services"]) : "",
                        ]
                    );
            }
        }
        $msg = "Table models transfer Successful ". PHP_EOL;

        $tableModels = 'drawings';
        $dataset = $client->table($tableModels)
            ->select('*')
            ->paginate(100);
        if ($dataset->nextPage() != "NULL") {
            $items = $dataset->execute()->asArray();
            foreach ($items as $item)
            {
                DB::table('drawings')
                    ->updateOrInsert(
                        ['name' => $item["name"]],
                        ['model_model' => isset($item["model_model"]) ? serialize($item["model_model"]) : ""]
                    );
            }
        }
        $msg .= "Table drawings transfer Successful ". PHP_EOL;

        $tableModels = 'services';
        $dataset = $client->table($tableModels)
            ->select('*')
            ->paginate(100);
        if ($dataset->nextPage() != "NULL") {
            $items = $dataset->execute()->asArray();
            foreach ($items as $item)
            {
                DB::table('services')
                    ->updateOrInsert(
                        ['id' => $item["id"]],
                        ['name' => $item["name"] ?? "",
                            'instructions' => $item["instructions"] ?? "",
                            'condition' => $item["condition"] ?? "",
                            'recurring' => $item["recurring"] ?? "0",
                            'calendar_interval' => $item["calendar_interval"] ?? "",
                            'calendar_interval_unit' => $item["calendar_interval_unit"] ?? "",
                            'running_hours_interval' => $item["running_hours_interval"] ?? "",
                            'alternative_interval' => $item["alternative_interval"] ?? "",
                            'alternative_interval_description' => $item["alternative_interval_description"] ?? "",
                            'service_group' => $item["service_group"] ?? "",
                            'model' => isset($item["model"]) ? serialize($item["model"]) : "",
                        ]
                    );
            }
        }
        $msg .= "Table services transfer Successful ". PHP_EOL;

        return view('api.insertdata', [
            'msg' => $msg,
        ]);
    }
}
