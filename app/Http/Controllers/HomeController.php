<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use App\Helpers\Utils;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\DataExport;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /*
       This function will import the xlsx file and will process and download the php file for translation
    */
    public function process(Request $request){
      $request->validate([
        'csv_file' => 'required|file'
      ]);


      if($request->file('csv_file')->getClientOriginalExtension() == 'xlsx' || $request->file('csv_file')->getClientOriginalExtension() == 'csv'){

      $data=[];

        $array = Excel::toArray(new User, $request->file('csv_file'));
        if(!empty($array)){
          if(isset($array[0])){
            if(is_array($array[0])){
              array_shift($array[0]);
              foreach($array[0] as $arr){
                if(is_array($arr) AND !empty($arr)){
                  if(!empty($arr[0])){
                    $temp = &$data;
                    foreach(explode(' | ', $arr[0]) as $key) {
                      $temp = &$temp[$key];
                    }
                    $temp = htmlentities($arr[1],ENT_QUOTES);
                  }
                }
              }
              if(!empty($data)){
                $exportdata = '<?php'."\n\n return ".Utils::varExport($data).";";
                return response()->phpfiledownload($exportdata);
              }

            }
          }
        }
      }
      return redirect('/')->with('error', 'Please check the upload file. Its not correct!');
    }


    /*
    This will show the php file import form
    */
    function phpform(Request $request){
      return view('phpform');
    }

    /*
    This function will process the php file
    */
    function processphpform(Request $request){
      $request->validate([
        'phpfile' => 'required|file'
      ]);
      if($request->file('phpfile')->getClientOriginalExtension() != 'php'){
        return redirect('php-to-excel')->with('error', 'Please check the upload file. Its not correct!');
      }

      try{
          $myArray = include $request->file('phpfile');
          $data=Utils::recursive_implode($myArray);
      }catch(Exception $e){
        return redirect('php-to-excel')->with('error', 'Please check the upload file. Its not correct!');
      }
      return Excel::download(new DataExport($data), 'download.xlsx');
    }


    /*
    Demo Page
    */
    function demopage(){
      return view('demopage');
    }


}
