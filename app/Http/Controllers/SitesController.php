<?php

namespace App\Http\Controllers;

use App\Site;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SitesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->role == "admin") {
            //$sites = DB::table('sites')->get();
            $sites = Site::all();
        }
        else {
            //$sites = DB::table('sites')->where('user_id', $user->id)->get();
            $sites = $user->sites()->get();
        }
        return view('sites.index', [
            'sites' => $sites,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $randomVesselNames = [
            'The Blankney',
            'Beaver',
            'Quainton',
            'Churchill',
            'Thatcham',
            'Cowper',
            'Adelaide',
            'The Kildimo',
            'Infanta',
        ];

        return view('sites.create', [
            'namePlaceholder' => '"'.$randomVesselNames[array_rand($randomVesselNames)].'"',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $site = new Site();
        $site->name = $request->input('name');
        $site->user_id = auth()->user()->id;
        $site->type = $request->input('type');

        $site->save();

        return redirect()->route('sites.index');
    }
    public function show(Site $site)
    {
        $user = auth()->user();
        if ($user->role == "admin" || $user->id == $site->user_id) {
            return view('sites.show', ['site' => $site]);
        }
        else {
            return view('no-permission');
        }
    }
    public function export(Request $request)
    {
        $user = auth()->user();
        if ($user->role == "admin") {
            $sites = DB::table('sites')
                ->join('users', 'users.id', '=', 'sites.user_id')
                ->select('users.name as username', 'users.email', 'sites.*')
                ->get();
        }
        else {
            $sites = DB::table('sites')
                ->join('users', 'users.id', '=', 'sites.user_id')
                ->select('users.name as username', 'users.email', 'sites.*')
                ->where('user_id', $user->id)
                ->get();
        }

        $fileName = 'sites.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('id', 'user_id', 'username', 'email', 'name', 'type', 'created_at', 'updated_at');

        $callback = function() use($sites, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($sites as $site) {
                $row['id']  = $site->id;
                $row['user_id']    = $site->user_id;
                $row['username']    = $site->username;
                $row['email']    = $site->email;
                $row['name']    = $site->name;
                $row['type']    = $site->type;
                $row['created_at']  = $site->created_at;
                $row['updated_at']  = $site->updated_at;

                fputcsv($file, array($row['id'], $row['user_id'], $row['username'], $row['email'], $row['name'], $row['type'], $row['created_at'], $row['updated_at']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
