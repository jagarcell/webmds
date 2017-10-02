<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Groups;
use App\Products;
use App\GroupsDescriptions;
use App\ProductsDescriptions;
use App\Languages;

class MainMenuController extends Controller
{
    /**
     * Create a n(es)w controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function translatedGroupUpdate(Request $request){
        $groupid = $request->get('groupid');
        $lang = $request->get('lang');
        $description = $request->get('description');

        $groups = (new Groups(['lang' => $lang]))->where('groupid', $groupid)->with('groupsdescriptions')->get();
        $group = $groups[0]["groupsdescriptions"][0];
        $group->description = $description;
        $group->update();
        return json_encode($group);
    }

    public function translatedProductUpdate(Request $request)
    {
        $productid = $request->get('productid');
        $lang = $request->get('lang');
        $description = $request->get('description');

        $products = (new Products(['lang' => $lang]))->where('productid', $productid)->with('productsdescriptions')->get();

        $product = $products[0]['productsdescriptions'][0];
        $product->description = $description;
        $product->update();
        return;
    }

    public function productsingroup(Request $request)
    {
        $groupid = $request->get("groupid");
        $lang = $request->get("lang");

        $productsinthisgroup = (new Products(['lang' => $lang]))->where('groupid', $groupid)->with('productsdescriptions')->get();

        return json_encode($productsinthisgroup);
    }

    public function productbyid(Request $request)
    {
        $productid = $request->get("productid");
        $lang = $request->get("lang");
        $product = (new Products(['lang' => $lang]))->where('productid', $productid)->with('productsdescriptions')->get();
        return json_encode($product);
    }

    public function groups(Request $request)
    {
        $lang = $request->get("lang");
        $groups = (new Groups(['lang' => $lang]))->where('id', '>=', 0)->with('groupsdescriptions')->get();
        return(json_encode($groups));
    }

    public function groupbyid(Request $request)
    {
        $lang = $request->get("lang");
        $groupid = $request->get("groupid");

        $groups = (new Groups(['lang' => $lang]))->where('groupid', $groupid)->with('groupsdescriptions')->get();
        return json_encode($groups);
    }

    public function adminpanel($fromLang, $toLang)
    {
        $lang = session('lang');
        $languages = (new Languages())->where('id', '>=', 0)->orderBy('lang')->get();

        $fromLangKey = 0;
        $toLangKey = 0;
        foreach ($languages as $key => $language) {
            # code...
            if($language->lang == $fromLang)
            {
                $fromLangKey = $key;
            }
            if($language->lang == $toLang)
            {
                $toLangKey = $key;
            }
        }

        $groups = (new Groups(['lang' => $languages[$fromLangKey]->lang]))->where('id', '>=', 0)->with('groupsdescriptions')->get();

        App::setLocale($lang);
        return view('adminpanel', 
            ['languages' => $languages, 
            'fromLangKey' => $fromLangKey, 
            'toLangKey' => $toLangKey,
            'groups' => $groups,]
            );
    }

    public function import()
    {
        if(($handle = fopen(public_path() . '/products.csv', 'r')) != FALSE)
        {
            $dataArray = array();

            $i = 0;
            $languages = (new Languages())->where('id', '>=', 0)->get();

            while(($data = fgetcsv($handle, 0, '#')) != FALSE)
            {
                echo count($data) . "  -- " . "$data[1]  --  $data[2]  --  $data[14]  -- $data[15]<br>";

                foreach ($languages as $key => $language) {
                    # code...
                    $groups = new Groups(['lang' => $language->lang]);
                    if($groups->where('groupid', $data[14])->get()->isEmpty())
                    {
                        $groups->groupid = $data[14];
                        $groups->menuposition = $i++;
                        $groups->save();
                    }

                    $groupsdescriptions = new GroupsDescriptions();
                    if($groupsdescriptions->where('groupid', $data[14])->where('lang', $language->lang)->get()->isEmpty())
                    {
                        $groupsdescriptions->groupid = $data[14];
                        $groupsdescriptions->description = $data[15];
                        $groupsdescriptions->lang = $language->lang;
                        $groupsdescriptions->save();
                    }

                    $products = new Products(['lang' => $language->lang]);
                    if($products->where('productid', $data[1])->get()->isEmpty())
                    {
                        $products->productid = $data[1];
                        $products->groupid = $data[14];
                        $products->stockqty = 0;
                        $products->price = 0;
                        $products->newproduct = FALSE;
                        $products->featureproduct = FALSE;
                        $products->slideproduct = FALSE;
                        $products->image = $data[16];
                        $products->discount = 0;
                        $products->save();
                    }

                    $productsdescriptions = new ProductsDescriptions();
                    if($productsdescriptions->where('productid', $data[1])->where('lang', $language->lang)->get()->isEmpty())
                    {
                        $productsdescriptions->productid = $data[1];
                        $productsdescriptions->lang = $language->lang;
                        $productsdescriptions->description = $data[2];
                        $productsdescriptions->save();
                    }
                }
            }
        }
        return;
    }

    public function welcome()
    {
        $lang = session('lang');

        $groups = (new Groups(['lang' => $lang]))->orderBy('menuposition')->with('groupsdescriptions')->get();

        $slideproducts = (new Products(['lang' => $lang]))->where('slideproduct', TRUE)->with('productsdescriptions')->get();
        

        $featureproducts = (new Products(['lang' => $lang]))->where('featureproduct', TRUE)->with('productsdescriptions')->get();

        $newproducts = (new Products(['lang' => $lang]))->where('newproduct', TRUE)->with('productsdescriptions')->get();

        $languages = (new Languages())->all();

        App::setLocale($lang);

        return view('welcome', 
            ['groups' => $groups, 
            'slideproducts' => $slideproducts, 
            'featureproducts' => $featureproducts,
            'newproducts' => $newproducts,
            'languages' => $languages,]
            );
    }

    public function about()
    {
        App::setLocale(session('lang'));
        return view('about');
    }

    public function contact()
    {
        App::setLocale(session('lang'));
        return view('contact');
    }

    public function delivery()
    {
        App::setLocale(session('lang'));
        return view('delivery');
    }

    public function news()
    {
        App::setLocale(session('lang'));
        return view('news');
    }

    public function products($group)
    {
        $lang = session('lang');

        $groups = (new Groups(['lang' => $lang]))->where('groupid', $group)->with('groupsdescriptions')->get();
        $products = (new Products(['lang' => $lang]))->where('groupid', $group)->with('productsdescriptions')->get();

        $prods = array();

        foreach ($products as $key => $product) {
            # code...
            array_push($prods, $product->productsdescriptions[0]->description);
        }
        App::setLocale($lang);
        return view('products', ['groups' => $groups, 'prods' => $prods, 'products' => $products]);
    }
}
