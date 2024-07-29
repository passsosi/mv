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

class ItemController extends Controller
{

    public function listOutput($id_Category)
    {
        $CtgData = Tctg::where('id', $id_Category)->get();
        if($CtgData[0]->have_4category == 0){
            $data = Item::where('id_Category', $id_Category)->orderBy('name', 'asc')->get();
            $images = Image::all();
            $category = Tctg::where('id', $id_Category)->get();
            return view('list', [
                    'data' => $data,
                    'images' => $images,
                    'category' => $category
                ]);
        }
        else{
            $data = FCtg::where('id_third_category', $id_Category)->orderBy('view_order', 'asc')->get();
            $category = Tctg::where('id', $id_Category)->get();
            return view('FourthCtg', [
                'data' => $data,
                'category' => $category
            ]);
        }
    }

    public function latSort($id_Category)
    {
        $category_id = Tctg::where('id', $id_Category)->pluck('id');
        if($category_id->isEmpty()){
            $data = Item::where('id_4Category', $id_Category)->orderBy('latName', 'asc')->get();
            $images = Image::all();
            $category = Fctg::where('id', $id_Category)->get();
           
            return view('list', [
                    'data' => $data,
                    'images' => $images,
                    'category' => $category
                ]);
        }
        else{
            $data = Item::where('id_Category', $id_Category)->orderBy('latName', 'asc')->get();
            $images = Image::all();
            $category = Tctg::where('id', $id_Category)->get();
            return view('list', [
                    'data' => $data,
                    'images' => $images,
                    'category' => $category
                ]);
        }
    }

    public function rusSort($id_Category)
    {
        $category_id = Tctg::where('id', $id_Category)->pluck('id');
        if($category_id->isEmpty()){
            $data = Item::where('id_4Category', $id_Category)->orderBy('name', 'asc')->get();
            $images = Image::all();
            $category = Fctg::where('id', $id_Category)->get();
           
            return view('list', [
                    'data' => $data,
                    'images' => $images,
                    'category' => $category
                ]);
        }
        else{
            $data = Item::where('id_Category', $id_Category)->orderBy('name', 'asc')->get();
            $images = Image::all();
            $category = Tctg::where('id', $id_Category)->get();
            return view('list', [
                    'data' => $data,
                    'images' => $images,
                    'category' => $category
                ]);
        }
    }

    public function list4Output($id_Category)
    {
        $data = Item::where('id_4category', $id_Category)->orderBy('name', 'asc')->get();
        $images = Image::all();
        $category = Fctg::where('id', $id_Category)->get();
        return view('list', [
                'data' => $data,
                'images' => $images,
                'category' => $category
            ]);
    }

    public function itemOutput($id_item)
    {
        $data = Item::where('id', $id_item)->get();
        $images = Image::where('id_item', $id_item)->get();
        $docs = Documents::where('id_item', $id_item)->get();
        $cat_id = $data[0]->id_category;
        if(!$cat_id){
            $cat_id = $data[0]->id_4category;
            $cat = FCtg::where('id', $cat_id)->get();
        }else{
            $cat = TCtg::where('id', $cat_id)->get();
        }

        return view('item', [
            'data' => $data,
            'documents' => $docs,
            'images' => $images,
            'cat' => $cat
        ]);   
    }

    public function itemUpdate($id_item)
    {
        if (Auth::check()) {
            $data = Item::findOrFail($id_item);
            $images = Image::where('id_item', $id_item)->get();
            $docs = Documents::where('id_item', $id_item)->get();
            $category3 = TCtg::where('have_4category', 0)->get();
            $category4 = FCtg::all();
            $category = $category3->concat($category4);

            $itemCategory = TCtg::where('id', $data->id_category)->get();
            if($itemCategory->isEmpty()){
                $itemCategory = FCtg::where('id', $data->id_4category)->get();
            }
            return view('update', [
                'data' => $data,
                'images' => $images,
                'documents' => $docs,
                'category' => $category,
                'itemCategory' => $itemCategory
        ]);    
        }
        return redirect('/');
    }

    public function itemUpload(Request $req, $id_item)
    {
        $item = Item::findOrFail($id_item);
        $category_id = Tctg::where('name', $req->id_category)->pluck('id');
        if($category_id->isEmpty()){
            $category_id = Fctg::where('name', $req->id_category)->pluck('id');
            $item->id_4category = $category_id[0];
            $item->id_category = null;
            
        }
        else{
            $item->id_category = $category_id[0];
            $item->id_4category = null;
        }
        $item->latName = $req->input('latName');
        $item->name = $req->input('name');
        $item->description = $req->input('desc');
        $item->save();
        
        
        if($req->file('image') != null)
        foreach ($req->file('image') as $img){
            $image = new Image();
            $image->id_item = $id_item;
            $imgData = file_get_contents($img->getRealPath());
            $image->image = $imgData;
            $image->save();
        }

        if ($req->file('file') != null) {
            foreach ($req->file('file') as $fl) {
                $file = new Documents();
                $file->id_item = $id_item;
                $flData = file_get_contents($fl->getRealPath());
                $file->file = $flData;
                $format = $fl->getClientOriginalExtension();
                $file->format = $format;
                $name = $fl->getClientOriginalName();
                $file->name = $name;

                $file->save();
            }
        }

        $data = Item::findOrFail($item->id);
        $CtgData = Tctg::where('id', $data->id_category)->get();
        if($CtgData->isEmpty()){
            $category = Fctg::where('id', $data->id_4category)->get();
            $data = Item::where('id_4category', $data->id_4category)->get();
            $images = Image::all();
            
            return view('list', [
                    'data' => $data,
                    'images' => $images,
                    'category' => $category
                ]);
        }
        else{
            $category = Tctg::where('id', $data->id_category)->get();
            $data = Item::where('id_Category', $data->id_category)->get();
            $images = Image::all();
            
            return view('list', [
                    'data' => $data,
                    'images' => $images,
                    'category' => $category
                ]);
        }  
    }

    public function itemAddView($id)
    {
        if (Auth::check()) {
            $category3 = TCtg::where('have_4category', 0)->get();
            $category4 = FCtg::all();
            $category = $category3->concat($category4);
            $itemCategory = TCtg::where('id', $id)->get();
            if($itemCategory->isEmpty()){
                $itemCategory = FCtg::where('id', $id)->get();
            }

            return view('add', [
            'category' => $category,
            'itemCategory' => $itemCategory
        ]);   
        }
        return redirect('/');
    }

    public function itemAdd(Request $req)
    {
        $item = new Item();
        $category_id = Tctg::where('name', $req->id_category)->pluck('id');
        if($category_id->isEmpty()){
            $category_id = Fctg::where('name', $req->id_category)->pluck('id');
            $item->id_4category = $category_id[0];
        }
        else{
            $item->id_category = $category_id[0];
        }
        $item->latName = $req->input('latName');
        $item->name = $req->input('name');
        $item->description = $req->input('desc');
        $item->save();
        $item = Item::latest()->first();
        
        if($req->file('image') != null)
        foreach ($req->file('image') as $img){
            $image = new Image();
            $image->id_item = $item->id;
            $imgData = file_get_contents($img->getRealPath());
            $image->image = $imgData;
            $image->save();
        }

        if ($req->file('file') != null) {
            foreach ($req->file('file') as $fl) {
                $file = new Documents();
                $file->id_item = $item->id;
                $flData = file_get_contents($fl->getRealPath());
                $file->file = $flData;
                $format = $fl->getClientOriginalExtension();
                $file->format = $format;
                $name = $fl->getClientOriginalName();
                $file->name = $name;
                $file->save();
            }
        }

        $data = Item::findOrFail($item->id);
        $CtgData = Tctg::where('id', $data->id_category)->get();
        if($CtgData->isEmpty()){
            $category = Fctg::where('id', $data->id_4category)->get();
            $data = Item::where('id_4category', $data->id_4category)->get();
            $images = Image::all();
            
            return view('list', [
                    'data' => $data,
                    'images' => $images,
                    'category' => $category
                ]);
        }
        else{
            $category = Tctg::where('id', $data->id_category)->get();
            $data = Item::where('id_Category', $data->id_category)->get();
            $images = Image::all();
            
            return view('list', [
                    'data' => $data,
                    'images' => $images,
                    'category' => $category
                ]);
        }
    }

    public function imgDelete($id)
    {
        $image = Image::where('id', $id)->get();

        if ($image) {
            $image->each(function ($img) {
            $img->delete();
            });

            foreach ($image as $img){
            $id_item = $img->id_item;
            }

            $data = Item::findOrFail($id_item);
            $images = Image::where('id_item', $id_item)->get();
            $docs = Documents::where('id_item', $id_item)->get();
            $category3 = TCtg::where('have_4category', 0)->get();
            $category4 = FCtg::all();

            $category = $category3->merge($category4);
            $itemCategory = TCtg::where('id', $data->id_category)->get();
            
            return view('update', [
                'data' => $data,
                'images' => $images,
                'documents' => $docs,
                'category' => $category,
                'itemCategory' => $itemCategory
            ]);

        } else {
            Session::flash('status', 'Объект не найдены');
            return redirect()->back();
        }
    }
    
    public function docsDelete($id)
    {
        $docs = Documents::where('id', $id)->get();

        if ($docs) {
            $docs->each(function ($doc) {
            $doc->delete();
            });

            foreach ($docs as $doc){
            $id_item = $doc->id_item;
            }
            
            return redirect()->back();

        } else {
            Session::flash('status', 'Объект не найдены');
            return redirect()->back();
        }
    }

    public function itemDelete($id_item)
    {
        if (Auth::check()) {
            $item = Item::findOrFail($id_item);
        
            if ($item) {
                $id_Category = $item->id_category;
                $id_4Category = $item->id_4category;

                $images = Image::where('id_item', $id_item)->get();
                $docs = Documents::where('id_item', $id_item)->get();

                foreach ($images as $img){
                    $img->delete();
                }
                foreach ($docs as $doc){
                    $doc->delete();
                }
                $item->delete();

                return redirect()->back();
            } else {
                Session::flash('status', 'Объект не найдены');
                return redirect()->back();
        }
        }
        return redirect('/');
    }

    public function imgUpdateView($id)
    {
        if (Auth::check()) {
            $data = Image::where('id', $id)->get();
            return view('imgUpdating', ['data' => $data]);    
        }
        return redirect('/');
    }

    public function imgUpdate($id, Request $req)
    {
        if (Auth::check()) {
            $data = Image::findOrFail($id);
            $data->location = $req->input('location');
            $data->author = $req->input('author');
            $data->date = $req->input('date');
            $data->save();
            $data = Image::where('id', $id)->get();
            return view('imgUpdating', ['data' => $data]); 
            }
        return redirect('/');
    }
}