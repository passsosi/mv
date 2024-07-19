<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Sctg;
use App\models\Home;
use App\models\HomeContent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function listOutput()
    {
        return view('home', ['data' => Home::all(), 'content'=> HomeContent::First()]);
    }

    public function categoryAddView()
    {
        if (Auth::check()) {
            return view('homeAdd');   
        }
        return redirect('/');
    }

    public function categoryAdd(Request $req)
    {
        $Home = new Home();
        
        $Home->name = $req->input('name');
        $img = $req->file('image');
        if($img != null){
        $imgData = file_get_contents($img->getRealPath());
        $Home->image = $imgData; 
        }       
        $Home->save();
        
        $data = $Home::latest()->first();

        return view('HomeUpdate', ['data' => $data,]);
        return redirect('/');
    }

    public function categoryUpdateView($id)
    {
        if (Auth::check()) {
            $data = Home::findOrFail($id);

            return view('homeUpdate', ['data' => $data,]);   
        }
        return redirect('/');
    }

    public function categoryUpdate(Request $req, $id)
    {
        if (Auth::check()) {
            $Home = Home::findOrFail($id);

            $Home->name = $req->input('name');
            $img = $req->file('image');
            if($img != null){
                $imgData = file_get_contents($img->getRealPath());
                $Home->image = $imgData;  
            }
            $Home->save();
    
            $data = Home::findOrFail($id);

            return view('homeUpdate', ['data' => $data,]);  
        }
        return redirect('/');
    } 

    public function categoryDelete($id)
    {
        if (Auth::check()) {
            $cat = Home::findOrFail($id);
        
            if ($cat) {
                $items = SCtg::where('id_MPCategory', $id)->get();
                foreach($items as $el){
                    if($el != null){
                        Session::flash('status', 'Невозможно удалить категорию пока в ней находятся объекты');
                        return redirect()->back();
                    }
                }
                $cat->delete();;

                return redirect('/');

            } else {
                Session::flash('status', 'Объект не найдены');
                return redirect()->back();
            }
        }
        return redirect('/');
    }

    public function contentIMGUpdate(Request $req, $id)
    {
        if (Auth::check()) {
            $content = HomeContent::findOrFail($id);

            $img = $req->file('image');
            if($img != null){
                $imgData = file_get_contents($img->getRealPath());
                $content->Image = $imgData;  
            }
            $content->save();

            return view('home', ['data' => Home::all(), 'content'=> HomeContent::First()]);
        }
        return redirect('/');
    } 

    public function contentDescUpdate(Request $req, $id)
    {
        if (Auth::check()) {
            $content = HomeContent::findOrFail($id);

            $content->Description = $req->input('desc');
            $content->save();

            return view('home', ['data' => Home::all(), 'content'=> HomeContent::First()]);
        }
        return redirect('/');
    } 
}

