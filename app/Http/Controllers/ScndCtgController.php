<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Tctg;
use App\models\Sctg;
use App\models\Home;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ScndCtgController extends Controller
{
    public function listOutput($id_MPC)
    {
        $data = SCtg::where('id_MPCategory', $id_MPC)->get();
        $category = Home::where('id', $id_MPC)->get();
        
        return view('scndcatg', ['data' => $data, 'category' => $category]);
    }

    public function categoryAddView($id)
    {
        if (Auth::check()) {
            $category = Home::all();
            $itemCategory = Home::where('id', $id)->get();

            return view('SCtgAdd', [
            'category' => $category,
            'itemCategory' => $itemCategory
        ]);   
        }
        return redirect('/');
    }

    public function categoryAdd(Request $req)
    {
        $Sctg = new Sctg();
        
        $Sctg->id_MPCategory = $req->input('id_category');
        $Sctg->LatName = $req->input('latName');
        $Sctg->name = $req->input('name');
        $img = $req->file('image');
        if($img != null){
        $imgData = file_get_contents($img->getRealPath());
        $Sctg->image = $imgData;
        }        
        $Sctg->save();
        
        $data = SCtg::latest()->first();
        $category = Home::where('id', $data->id_MPCategory)->get();
        $data = SCtg::where('id_MPCategory', $data->id_MPCategory)->get();
        
        
        return view('scndcatg', ['data' => $data, 'category' => $category]);
        return redirect('/');
    }

    public function categoryUpdateView($id)
    {
        if (Auth::check()) {
            $data = Sctg::findOrFail($id);
            $category = Home::all();
            $MainCategory = Home::where('id', $data->id_MPCategory)->get();

            return view('SCtgUpdate', [
                'data' => $data,
                'category' => $category,
                'MainCategory' => $MainCategory
            ]);   
        }
        return redirect('/');
    }

    public function categoryUpdate(Request $req, $id)
    {
        if (Auth::check()) {
            $data = Sctg::findOrFail($id);

            $data->id_MPCategory = $req->input('id_category');
            $data->LatName = $req->input('latName');
            $data->name = $req->input('name');
            $img = $req->file('image');
            if($img != null){
                $imgData = file_get_contents($img->getRealPath());
                $data->image = $imgData;
            }
            $data->save();
    
            $data = Sctg::findOrFail($id);
            $category = Home::all();
            $MainCategory = Home::where('id', $data->id_MPCategory)->get();

            return view('SCtgUpdate', [
                'data' => $data,
                'category' => $category,
                'MainCategory' => $MainCategory
            ]);  
        }
        return redirect('/');
    } 

    public function categoryDelete($id)
    {
        if (Auth::check()) {
            $cat = SCtg::findOrFail($id);
        
            if ($cat) {
                $id_Category = $cat->id_MPCategory;

                $items = TCtg::where('id_SecondCategory', $id)->get();
                foreach($items as $el){
                    if($el != null){
                        Session::flash('status', 'Невозможно удалить категорию пока в ней находятся объекты');
                        return redirect()->back();
                    }
                }
                
                $cat->delete();

                return redirect()->back();

            } else {
                Session::flash('status', 'Объект не найдены');
                return redirect()->back();
            }
        }
        return redirect('/');
    }
}