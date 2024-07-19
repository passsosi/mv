<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Fctg;
use App\models\Tctg;
use App\models\Sctg;
use App\models\Item;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class FourCtgController extends Controller
{
    public function categoryUpdateView($id)
    {
        if (Auth::check()) {
            $data = Fctg::findOrFail($id);
            $category = TCtg::where('have_4category', 1)->get();
            $SecondCategory = TCtg::where('id', $data->id_third_category)->get();
            return view('FCtgUpdate', [
                'data' => $data,
                'category' => $category,
                'SecondCategory' => $SecondCategory
        ]);    
        }
        return redirect('/');
    }

    public function categoryUpdate(Request $req, $id)
    {
        if (Auth::check()) {
            $data = Fctg::findOrFail($id);

            $data->id_third_category = $req->input('id_category');
            $data->latName = $req->input('latName');
            $data->name = $req->input('name');
            $img = $req->file('image');
            if($img){
                $imgData = file_get_contents($img->getRealPath());
                $data->image = $imgData;
            }
            
    
            $data->save();
    
            $data = Fctg::findOrFail($id);
            $category = TCtg::where('have_4category', 1)->get();
            $SecondCategory = TCtg::where('id', $data->id_SecondCategory)->get();
            return view('TCtgUpdate', [
                'data' => $data,
                'category' => $category,
                'SecondCategory' => $SecondCategory
            ]);
        }
        return redirect('/');
    } 

    public function categoryAddView()
    {
        if (Auth::check()) {
            $category = TCtg::where('have_4category', 1)->get();

            return view('FCtgAdd', [
            'category' => $category
        ]);   
        }
        return redirect('/');
    }

    public function categoryAdd(Request $req)
    {
        $Fctg = new Fctg();

        $Fctg->id_third_category = $req->input('id_category');
        $Fctg->latName = $req->input('latName');
        $Fctg->name = $req->input('name');
        $img = $req->file('image');
        $imgData = file_get_contents($img->getRealPath());
        $Fctg->image = $imgData;        
        $Fctg->save();
        
        $data = Fctg::latest()->first();
        $category = TCtg::where('have_4category', 1)->get();
        $SecondCategory = TCtg::where('id', $data->id_SecondCategory)->get();

        return view('FCtgUpdate', [
            'data' => $data,
            'category' => $category,
            'SecondCategory' => $SecondCategory
        ]);
        return redirect('/');
    }

    public function categoryDelete($id)
    {
        if (Auth::check()) {
            $cat = FCtg::findOrFail($id);
        
            if ($cat) {
                $id_Category = $cat->id_third_category;

                $items = Item::where('id_4category', $id)->get();
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