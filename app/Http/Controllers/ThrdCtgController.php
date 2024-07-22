<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Fctg;
use App\models\Tctg;
use App\models\Sctg;
use App\models\Item;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ThrdCtgController extends Controller
{
    public function listOutput($id_SC)
    {
        $data = TCtg::where('id_SecondCategory', $id_SC)->orderBy('view_order', 'asc')->get();
        $category = Sctg::where('id', $id_SC)->get();

        return view('thrdcatg', ['data' => $data, 'category' => $category]);
    }

    public function Order(Request $req){
        if (Auth::check()) {
        $data = Tctg::findOrFail($req->id);
        $data->view_order = $req->order;
        $data->save();
        return redirect()->back();
        }
        return redirect('/');
    }

    public function categoryAddView($id)
    {
        if (Auth::check()) {
            $category = SCtg::all();
            $itemCategory = SCtg::where('id', $id)->get();

            return view('TCtgAdd', [
            'category' => $category,
            'itemCategory' => $itemCategory
        ]);   
        }
        return redirect('/');
    }

    public function categoryAdd(Request $req)
    {
        $Tctg = new Tctg();
        if($req->input('h4c') != null){
        $Tctg->have_4category = 1;
        }else{
            $Tctg->have_4category = 0;
        }
        $Tctg->id_SecondCategory = $req->input('id_category');
        $Tctg->latName = $req->input('latName');
        $Tctg->name = $req->input('name');
        $img = $req->file('image');
        $imgData = file_get_contents($img->getRealPath());
        $Tctg->image = $imgData;        
        $Tctg->save();
        
        $data = TCtg::latest()->first();
        $category = Sctg::where('id', $data->id_SecondCategory )->get();
        $data = TCtg::where('id_SecondCategory', $data->id_SecondCategory )->get();
        

        return view('thrdcatg', ['data' => $data, 'category' => $category]);
        return redirect('/');
    }

    public function categoryUpdateView($id)
    {
        if (Auth::check()) {
            $data = Tctg::findOrFail($id);
            $category = SCtg::all();
            $SecondCategory = SCtg::where('id', $data->id_SecondCategory)->get();

            return view('TCtgUpdate', [
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
            $data = Tctg::findOrFail($id);

            $data->id_SecondCategory = $req->input('id_category');
            $data->latName = $req->input('latName');
            $data->name = $req->input('name');
            $img = $req->file('image');
            $imgData = file_get_contents($img->getRealPath());
            $data->image = $imgData;
    
            $data->save();
    
            $data = Tctg::findOrFail($id);
            $category = SCtg::all();
            $SecondCategory = SCtg::where('id', $data->id_SecondCategory)->get();
            return view('TCtgUpdate', [
                'data' => $data,
                'category' => $category,
                'SecondCategory' => $SecondCategory
            ]);
        }
        return redirect('/');
    } 

    public function categoryDelete($id)
    {
        if (Auth::check()) {
            $cat = TCtg::findOrFail($id);
        
            if ($cat) {
                $id_Category = $cat->id_SecondCategory;

                if($cat->have_4category == 0){
                    $items = Item::where('id_category', $id)->get();
                    foreach($items as $el){
                        if($el != null){
                            Session::flash('status', 'Невозможно удалить категорию пока в ней находятся объекты');
                            return redirect()->back();
                        }
                    }
                }
                else{
                    $items = FCtg::where('id_third_category', $id)->get();
                    foreach($items as $el){
                        if($el != null){
                            Session::flash('status', 'Невозможно удалить категорию пока в ней находятся объекты');
                            return redirect()->back();
                        }
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