<?php
namespace Portal\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Portal\Http\Requests;
use Portal\Models\User;
use Portal\Models\Subject;
use Portal\Models\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Auth;

class LogController extends Controller
{
    
public function __construct()
    {
        $this->middleware('admin');
    }

    

public function index()
    {
	$l = array();
        $logs = Log::orderBy('created_at', 'desc')->get();
		
	foreach($logs as $log)
	{
		//dd($log);
		if(User::find($log->user_id))
		{
			//var_dump($log);
		$l[] = array('user' => User::find($log->user_id)->getN(), 'action' => $log->action,
		'time' => $log->created_at,);
		}
	}
	$perPage = 50;   
    $page = Input::get('page', 1);
    if ($page > count($l) or $page < 1) { $page = 1; }
    $offset = ($page * $perPage) - $perPage;
    $perPageUnits = array_slice($l,$offset,$perPage, true);
    $l = new LengthAwarePaginator($perPageUnits, count($l), $perPage, $page);
	$l->setPath('/portal/logs');
	//$l->toArray();
	//dd($l['items']);
        return view('logs.index')->with('l', $l);
    }
    
	public function findLog(Request $request){
		$search = $request->search;
		$logs = Log::where('action','LIKE', "%{$search}%")->get();
		if(count($logs)){
		foreach($logs as $log)
	{
		//dd($log);
		if(User::find($log->user_id))
		{
			//var_dump($log);
		$l[] = array('user' => User::find($log->user_id)->getN(), 'action' => $log->action,
		'time' => $log->created_at,);
		}
	}
	$perPage = 50;   
    $page = Input::get('page', 1);
    if ($page > count($l) or $page < 1) { $page = 1; }
    $offset = ($page * $perPage) - $perPage;
    $perPageUnits = array_slice($l,$offset,$perPage, true);
    $l = new LengthAwarePaginator($perPageUnits, count($l), $perPage, $page);
	$l->setPath('/portal/searchlogs?search='.$request->search);
		}else{
			return back()->with('info', 'No results found');
			}
	//$l->toArray();
	//dd($l['items']);
        return view('logs.index')->with('l', $l);

		}
	
    
}
