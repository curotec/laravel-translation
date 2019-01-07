<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\Utils;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\DataExport;
use App\Exports\ExcelExport;
use ZanySoft\Zip\Zip;
use Storage;
use App\User;
use App\Imports\DataImport;

class MultipleController extends Controller
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

    function phpzipform(){
      return view('zipupload');
    }

    function processphpzipform(Request $request){
      $request->validate([
        'zipfile' => 'required|file|mimes:zip'
      ]);

      $is_valid = Zip::check($request->file('zipfile'));

      if(!$is_valid){
        return redirect('php-files-to-excel')->with('error', 'Please check the upload file. Its not correct!');
      }
      $filename = str_replace('.zip','',$request->file('zipfile')->getClientOriginalName());
      $path='temp/'.uniqid();
      $zip = Zip::open($request->file('zipfile'));
      $zip->extract(storage_path('app/'.$path));
      $files=Storage::allFiles($path);
      if(!empty($files)){
        return (new ExcelExport($files,storage_path('app').'/',$path))->download($filename.'.xlsx');
        //return redirect('php-files-to-excel')->with('status', 'Downloading!');
      }
    }

    function multiplesheetform(){
      //echo phpinfo();
      return view('multiplesheet');
    }

    function processmultiplesheets(Request $request){
      $request->validate([
        'csv_file' => 'required|file'
      ]);
      $filename=str_replace('.xlsx','',$request->file('csv_file')->getClientOriginalName());
      $filename = str_replace('.csv','',$filename);
      $excel_path=$request->file('csv_file')->storeAs('tmp', uniqid().'.'.$request->file('csv_file')->getClientOriginalExtension());

      //Storage::put('tmp/'.uniqid().'.'.$request->file('csv_file')->getClientOriginalExtension(), $exportdata);
      //echo $excel_path = $request->file('csv_file')->store('tmp');
      if($request->file('csv_file')->getClientOriginalExtension() == 'xlsx' || $request->file('csv_file')->getClientOriginalExtension() == 'csv'){

      $data=[];

        $array = Excel::toArray(new User, $request->file('csv_file'));
        $Import = new DataImport();
        $ts = Excel::import($Import, $excel_path);
        if(!empty($array)){
        $folder=uniqid();
        $del_folder='tmp/'.$folder;
        $folder_path=$del_folder.'/'.$filename;
        $root_folder_path=storage_path('app').'/'.$del_folder;
        $base_folder_path=storage_path('app').'/'.$folder_path;
        Storage::makeDirectory($folder_path);
        $zip = Zip::create($root_folder_path.'/'.$filename.'.zip');
          if(!empty($Import->sheetNames)){
            $counter=0;
            foreach($Import->sheetNames as $sheet => $sheetname){
              $data=[];
              if(isset($array[$counter])){
                if(is_array($array[$counter])){
                  array_shift($array[$counter]);
                  foreach($array[$counter] as $arr){
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
                    Storage::put($folder_path.'/'.$sheetname.'.php', $exportdata);
                  }
                }
              }
              $counter++;
            }
          }
          $zip->add($base_folder_path);
          $zip->close();
          Storage::delete($excel_path);
          return Storage::download($del_folder.'/'.$filename.'.zip');
        }
      }
      return redirect('excel-sheets-to-zip')->with('error', 'Please check the upload file. Its not correct!');
    }

}
