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

    public function productsingroup()
    {
        $id = $_GET["id"];
        $lang = $_GET["lang"];

        $group = (new Groups(['lang' => $lang]))->where('id', $id)->get();
        $productsinthisgroup = (new Products(['lang' => $lang]))->where('groupid', $group[0]->groupid)->with('productsdescriptions')->get();

        return json_encode($productsinthisgroup);
    }

    public function grouptranslationupdate()
    {
        $toGroupChanged = $_POST["toGroupChanged"];
        $toGroupsDescriptionsId = $_POST["toGroupsDescriptionsId"];
        $toGroups = $_POST["toGroups"];

        $groupsdescriptions = new GroupsDescriptions();
        foreach ($toGroups as $key => $group) {
            # code...
            if($toGroupChanged[$key] == "Y")
            {
                $groupdescription = $groupsdescriptions->find($toGroupsDescriptionsId[$key]);
                echo "$groupdescription->description<br>";
                $groupdescription->description = $group;
                echo "$group<br>";
                $groupdescription->update();
            }
        }
        return;
        $productchangedid = $_POST["productchangedid"];
        $productchanged = $_POST["productchanged"];
        $translatedproduct = $_POST["translatedproduct"];

        $productsdescriptions = new ProductsDescriptions();
        foreach ($productchanged as $key => $product) {
            # code...
            if($productchanged[$key] == "Y")
            {
                $productsdescriptions->find($productchangedid[$key]);
                echo "$key - $productsdescriptions->description - $productchangedid[$key]<br>";
            }
        }

        return;

        $groupsdescriptions = new GroupsDescriptions();
        foreach ($groups as $key => $group) {
            # code...
            if($groupchanged[$key]){
                $groupdescription = $groupsdescriptions->find($groupsdescriptionsid[$key]);
                $groupdescription->description = $group;
                $groupdescription->update();
            }
        }
        return redirect()->back();
    }

    public function groups()
    {
        $lang = $_GET["lang"];
        $groups = (new Groups(['lang' => $lang]))->where('id', '>=', 0)->with('groupsdescriptions')->get();
        return(json_encode($groups));
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

        $groups = (new Groups(['lang' => $languages[$fromLangKey]->lang]))->where('id', '>=', 0)->get();

        $translatedgroups = (new Groups(['lang' => $languages[$toLangKey]->lang]))->where('id', '>=', 0)->with('groupsdescriptions')->get();

        $maxGroupProductsCount = 0;
        $products = new Products(['lang' => $languages[$fromLangKey]->lang]);
        foreach ($groups as $key => $group) {
            # code...
            $productscount = count($products->where('groupid', $group->groupid)->get());
            if($productscount > $maxGroupProductsCount)
            {
                $maxGroupProductsCount = $productscount;
            }
        }

        App::setLocale($lang);
        return view('adminpanel', 
            ['languages' => $languages, 
            'fromLangKey' => $fromLangKey, 
            'toLangKey' => $toLangKey,
            'groups' => $groups,
            'translatedgroups' => $translatedgroups,
            'maxGroupProductsCount' => $maxGroupProductsCount,]);
    }

    public function import()
    {
        if(($handle = fopen(public_path() . '/products.csv', 'r')) != FALSE)
        {
            $dataArray = array();

            $i = 0;
            while(($data = fgetcsv($handle, 0, '#')) != FALSE)
            {
                echo count($data) . "  -- " . "$data[1]  --  $data[2]  --  $data[14]  -- $data[15]<br>";

                $groups = new Groups(['lang' => 'es']);
                if($groups->where('groupid', $data[14])->get()->isEmpty())
                {
                    $groups->groupid = $data[14];
                    $groups->menuposition = $i++;
                    $groups->save();
                }

                $groupsdescriptions = new GroupsDescriptions();
                if($groupsdescriptions->where('groupid', $data[14])->where('lang', 'es')->get()->isEmpty())
                {
                    $groupsdescriptions->groupid = $data[14];
                    $groupsdescriptions->description = $data[15];
                    $groupsdescriptions->lang = 'es';
                    $groupsdescriptions->save();
                }

                $products = new Products(['lang' => 'es']);
                if($products->where('productid', $data[1])->get()->isEmpty())
                {
                    $products->productid = $data[1];
                    $products->group = $data[14];
                    $products->stockqty = 0;
                    $products->price = 0;
                    $products->newproduct = FALSE;
                    $products->featureproduct = FALSE;
                    $products->slideproduct = FALSE;
                    $products->image = $data[1];
                    $products->discount = 0;
                    $products->save();
                }

                $productsdescriptions = new ProductsDescriptions();
                if($productsdescriptions->where('productid', $data[1])->where('lang', 'es')->get()->isEmpty())
                {
                    $productsdescriptions->productid = $data[1];
                    $productsdescriptions->lang = 'es';
                    $productsdescriptions->description = $data[2];
                    $productsdescriptions->save();
                }

                $groups = new Groups(['lang' => 'en']);
                if($groups->where('groupid', $data[14])->get()->isEmpty())
                {
                    $groups->groupid = $data[14];
                    $groups->menuposition = $i++;
                    $groups->save();
                }

                $groupsdescriptions = new GroupsDescriptions();
                if($groupsdescriptions->where('groupid', $data[14])->where('lang', 'en')->get()->isEmpty())
                {
                    $groupsdescriptions->groupid = $data[14];
                    $groupsdescriptions->description = $data[15];
                    $groupsdescriptions->lang = 'en';
                    $groupsdescriptions->save();
                }

                $products = new Products(['lang' => 'en']);
                if($products->where('productid', $data[1])->get()->isEmpty())
                {
                    $products->productid = $data[1];
                    $products->group = $data[14];
                    $products->stockqty = 0;
                    $products->price = 0;
                    $products->newproduct = FALSE;
                    $products->featureproduct = FALSE;
                    $products->slideproduct = FALSE;
                    $products->image = $data[1];
                    $products->discount = 0;
                    $products->save();
                }

                $productsdescriptions = new ProductsDescriptions();
                if($productsdescriptions->where('productid', $data[1])->where('lang', 'en')->get()->isEmpty())
                {
                    $productsdescriptions->productid = $data[1];
                    $productsdescriptions->lang = 'en';
                    $productsdescriptions->description = $data[2];
                    $productsdescriptions->save();
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
        
        $slides = array();
        $discounts = array();

        foreach ($slideproducts as $key => $slideproduct) {
            # code...
            array_push($slides, $slideproduct->productsdescriptions[0]->description);
            array_push($discounts, $slideproduct->discount);
        }

        $featureproducts = (new Products(['lang' => $lang]))->where('featureproduct', TRUE)->with('productsdescriptions')->get();

        $feature = array();
        foreach ($featureproducts as $key => $featureproduct) {
            # code...
            array_push($feature, $featureproduct->productsdescriptions[0]->description);
        }

        $newproducts = (new Products(['lang' => $lang]))->where('newproduct', TRUE)->with('productsdescriptions')->get();

        $new = array();
        foreach ($newproducts as $key => $newproduct) {
            # code...
            array_push($new, $newproduct->productsdescriptions[0]->description);
        }

        $languages = (new Languages())->all();

        App::setLocale($lang);

        return view('welcome', 
            ['groups' => $groups, 
            'slides' => $slides, 
            'discounts' => $discounts,
            'featureproducts' => $feature,
            'newproducts' => $new,
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
        return view('products', ['groups' => $groups, 'products' => $prods]);
    }
}
