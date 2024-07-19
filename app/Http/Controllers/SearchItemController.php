<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Item;
use App\models\Image;
use App\models\Tctg;
use App\models\Fctg;
use App\models\Documents;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class SearchItemController extends Controller
{

    public function searchOutput()
    {
        $data = Item::all();
        $category3 = TCtg::where('have_4category', 0)->get();
        $category4 = FCtg::all();
        $category = $category3->merge($category4);
//dd($category);
        return view('search', [
            'data' => $data,
            'cat' => $category
        ]);
    }
    
    public function search(Request $req)
    {
        $search = $req->input('search');
    
        $items = Item::where('name', 'like', '%' . $search . '%')
            ->orWhere('latName', 'like', '%' . $search . '%')  //поиск по латинскому названию
            ->get();
        $images = Image::all();
        return view('search-data', ['search_data' => $items, 'images' => $images]);
    }
}