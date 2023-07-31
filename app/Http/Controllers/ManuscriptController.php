<?php

namespace App\Http\Controllers;

use App\Models\Manuscript;
use App\Models\Manuscripts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Arrays;

class ManuscriptController extends Controller
{
    // Get Default manuscripts
    function index(){
        return DB::table('manuscripts')->paginate(15);
    }

    function nbrManuscriptsPerPage($page){
        return DB::table('manuscripts')->paginate($page);
    }
    // Get data PerPage
//    public function searchByTitle($title){
//        //var_dump($title);
//        return DB::table('manuscripts')->where('title','like','%'.$title.'%')->paginate(15);
//    }

    // Get manuscript by uuid
    public function manuscriptByUuid($uuid){
        return DB::table('manuscripts')->where('uuid','=',$uuid)->first();
    }

    // Get 10 manuscripts by class
    public function manuscriptsByClass($class){
        return DB::table('manuscripts')->where('class','like','%'.$class.'%')
            ->take(10)
            ->get();
    }

    // List Libraries
    public function librariesList(){
        return DB::table('manuscripts')
            ->select('lib')
            ->distinct('lib')
            ->simplePaginate(15);
    }
    // Search In List Libraries
    public function searchInLibrariesList($lib){
        return DB::table('manuscripts')
            ->select('lib')
            ->where('lib','like','%'.$lib.'%')
            ->distinct('lib')
            ->simplePaginate(15);
    }
    // Subject List
    public function subjectList(){
        return DB::table('manuscripts')
            ->select('class')
            ->distinct('class')
            ->simplePaginate(15);
    }
    // Search In Subject List
    public function searchInSubjectList($class){
        //var_dump($lot);
        return DB::table('manuscripts')
            ->select('class')
            ->where('class','like','%'.$class.'%')
            ->distinct('class')
            ->simplePaginate(15);
    }
    // paperNum List
    public function paperNumList(){
        return DB::table('manuscripts')
            ->select('paperNum')
            ->distinct()
            ->simplePaginate(15);
    }
    // Search In paperNum List
    public function searchInPaperNumList($paper){
        return DB::table('manuscripts')
            ->select('paperNum')
            ->where('paperNum','like','%'.$paper.'%')
            ->distinct()
            ->simplePaginate(15);
    }
    public function countManuscripts(){
        return DB::table('manuscripts')->count();
    }
    public function searchByElements(Request $request){
        $result = json_decode($request->getContent(), true);
        $title = $request->input('title');
        $perPage = $request->input('perPage');
        $subjects = $result['subjects'] ?? null;
        $library = $result['library'] ?? null;
        $paperNum = $result['paperNum'] ?? null;
        $query = Manuscripts::select('*');
        if ($request->has('title')) {
            $query->where('title','like','%'.$title.'%');
        }
        if ($subjects && count($subjects)>0) {
             $query->whereIn('class',$subjects);
       } if ($library && count($library)>0) {
             $query->whereIn('lib',$library);
       } if ($paperNum && count($paperNum)>0) {
             $query->whereIn('paperNum',$paperNum);
       }
        $query = $query->paginate($perPage);
        return $query;
    }
}
