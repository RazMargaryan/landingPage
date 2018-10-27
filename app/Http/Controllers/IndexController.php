<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Page;
use App\Service;
use App\People;
use App\Portfolio;
class IndexController extends Controller
{
    public function index(Request $request)
    {

        $pages = Page::all();
        $services = Service::where('id', '<', 20)->get();
        $portfolios = Portfolio::get(array('name', 'filter', 'images'));
        $peoples = People::take(3)->get();
        $tags = Portfolio::distinct()->pluck('filter');
        $menu = [];
        foreach ($pages as $page) {
            $item = array('title' => $page->name, 'alias' => $page->alias);
            array_push($menu, $item);
        }
        $item = array('title'=>'Services','alias'=>'service');
        array_push($menu, $item);
        $item = array('title'=>'Portfolio','alias'=>'Portfolio');
        array_push($menu, $item);
        $item = array('title'=>'Team','alias'=>'team');
        array_push($menu, $item);
        $item = array('title'=>'Contact','alias'=>'contact');
        array_push($menu, $item);
        //dd($pages);
        return view('site.index',array(
            'menu'=>$menu,
            'pages'=>$pages,
            'services'=>$services,
            'portfolios'=>$portfolios,
            'peoples' => $peoples,
            'tags'=>$tags,
        ));
    }
}