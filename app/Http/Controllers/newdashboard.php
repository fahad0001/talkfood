<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;


use App\Http\Controllers\restdashboard;


use App\Restaurant;

use App\Food;

use App\Http\Requests;

use DB;
use App\Quotation;
use App\Category;
use App\SubMenu;


use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\Response;


use Illuminate\Support\Facades\Input;



class newdashboard extends Controller
{
	
	
	// 	Update Availibility Status of All Resturants
	public function updateAvailibility($status)
	{
		
		
		$rests=Restaurant::paginate(15);
		
		
		Restaurant::query()->update(['rest_avail' => $status]);
		
		
		return view('admin.index',compact('rests'));
		
		
	}
	
	
	
	//C	ategory Submenu
	public function index()
	{
		
		
		$rests=Restaurant::paginate(15);
		
		
		return view('admin.food.index',compact('rests'));
		
		
	}
	
	
	
	// 	Veiw All Categories
	public function viewCategory($id) {
		
		
		//$		user = Input::get('search');
		
		
		$userData = Restaurant::where('rest_id', $id)->first();
		
		
		$catDetail = Category::where('rest_id', $userData->rest_id)->paginate(15);
		
		
		return view('admin.food.category', compact('catDetail'));
		
		
	}
	
	
	//C	reate Category
	public function createCategory($id) {
		
		
		$category = new Category();
		
		
		$category->cate_name = Input::get('CategoryType');
		
		
		$category->rest_id = $id;
		
		//r		est_id which is auto increment will be used
		$category->save();
		
		
		$catDetail = Category::where('rest_id', $id)->paginate(15);
		
		
		$restId=$id;
		
		
		return view('admin.food.category', compact('catDetail','restId'))->with('success', 'Successfully added');
		
		
	}
	
	
	//D	elete Categories
	public function deleteCategory($id) {
		
		
		$cateDetail = Category::where('cate_id', $id)->first();
		
		
		$restId=$cateDetail->rest_id;
		
		
		Category::where('cate_id', $id)->delete();
		
		
		$catDetail = Category::where('rest_id', $restId)->paginate(15);
		
		
		return view('admin.food.category', compact('catDetail','restId'))->with('success', 'Successfully deleted');
		
		
	}
	
	
	public function MenuItem($id) {
		$categs = Category::where('rest_id', $id)->get();
		return view('admin.food.food', compact('categs'));
		
	}
	
	
	public function createMenuItem() 
	{
		
		$subcount = Input::get('submenutext');
		$categs = Category::where('cate_id', Input::get('categ_id'))->first();
		
		if(!Input::has('option')) {
			
			Food::create([
			'food_name' => Input::get('food'),
			'food_desc' => Input::get('description'),
			'food_price' => Input::get('price'),
			'cate_id' => Input::get('categ_id'),
			'food_pic_path' => '',
			'rest_id' => $categs->rest_id,
			'submenu_status' => false
			]);
			
		}
		
		else {
			
			$food = Food::create([
			'food_name' => Input::get('food'),
			'food_desc' => Input::get('description'),
			'food_price' => Input::get('price'),
			'cate_id' => Input::get('categ_id'),
			'food_pic_path' => '',
			'rest_id' => $categs->rest_id,
			'submenu_status' => true
			]);
			
			
			foreach(Input::get('option') as $s) {
				foreach($s['subopt'] as $e) {
					
					SubMenu::create([
					'name' => $e['name'],
					'desc' => "",
					'price' => $e['price'],
					'option' => $s['name'],
					'type'=>$s['type'],
					'food_id' => $food->food_id
					]);
					
				}
				
			}
			
		}
		
		return redirect("/admin/viewmenuitem/$categs->rest_id");
		
	}
	
	
	public function viewMenuItem($id) {
		$userData = Restaurant::where('rest_id', $id)->first();
		$foodDetail = Food::with('foodCategory')->where('rest_id', $userData->rest_id)->orderBy('food_id','Desc')->paginate(15);
		return view('admin.food.viewFood', compact('foodDetail'));
	}

        public function deleteMenuItem($id) {
        //$user = Auth::user();
        //$rest = Restaurant::where('rest_user_id', $user->id)->first();
        $food=Food::where('food_id',$id)->first();
        Food::where('food_id',$id)->delete();
        if($food->submenu_status==true){
        SubMenu::where('food_id',$id)->delete();
        }
        return redirect("/admin/viewmenuitem/$food->rest_id");
        
    }
        public function editMenuItem($id) {
        // $user = Auth::user();
        // $rest = Restaurant::where('rest_user_id', $user->id)->first();
        $food = Food::where('food_id', $id)->first();
        $categs = Category::where('rest_id', $food->rest_id)->get();
        $submenu=  SubMenu::where('food_id',$id)->get();
         $opt = DB::table('menu_option')
                ->select('type', 'option')
                ->where('food_id', $id)
                ->distinct()
                ->get();
        return view('admin.food.editFood', compact('food', 'categs','submenu','opt'));
    }
	
        public function doEditMenuItem($id) {
        
             $subcount = Input::get('submenutext');
        // $user = Auth::user();
        // $rest = Restaurant::where('rest_user_id', $user->id)->first();
        $food = Food::where('food_id', $id)->first();
       if(!Input::has('option')) {
            Food::where('food_id',$id)->update([
                'food_name' => Input::get('food'),
                'food_desc' => Input::get('description'),
                'food_price' => Input::get('price'),
                'cate_id' => Input::get('categ_id'),
                'food_pic_path' => '',
                'rest_id' => $food->rest_id,
                'submenu_status' => false
            ]);
             SubMenu::where('food_id',$id)->delete();
            
        } else {
            $food = Food::where('food_id',$id)->update([
                        'food_name' => Input::get('food'),
                        'food_desc' => Input::get('description'),
                        'food_price' => Input::get('price'),
                        'cate_id' => Input::get('categ_id'),
                        'food_pic_path' => '',
                        'rest_id' => $food->rest_id,
                        'submenu_status' => true
            ]);
           // $subcount = Input::get('submenutext');
             SubMenu::where('food_id',$id)->delete();
          
                foreach(Input::get('option') as $s) {
                
              //  return var_dump($s);
                
                    foreach($s['subopt'] as $e) {
                        
                        
                           SubMenu::create([
                    'name' => $e['name'],
                    'desc' => "",
                    'price' => $e['price'],
                    'option' => $s['name'],
                    'type'=>$s['type'],
                    'food_id' =>$id
                ]);
//                        
                    }
              
            }
             
           
        }



        return redirect("/admin/viewmenuitem/$food->rest_id");
        
//        $food = Food::where('food_id', $id)->first();
//        $food->food_name = Input::get('food');
//        $food->food_desc = Input::get('description');
//        $food->food_price = Input::get('price');
//        $food->cate_id = Input::get('categ_id');
//        $food->save();
//        return redirect('/restaurant/viewmenuitem');
    }
	
	public function autocomplete()
	{
		
		
		// 		$term = Input::get('term');
		
		
		// 		$term="the";
		
		
		
		$results = array();
		
		
		$rests = Restaurant::all();
		
		
		foreach ($rests as $query)
		{
			
			
			$results[] = [ 'name' => $query->rest_name, 'code' => $query->rest_name ];
			
			
		}
		
		
		return Response::json($results);
		
		
	}
	
	
}


