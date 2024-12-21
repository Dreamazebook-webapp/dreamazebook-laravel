<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PreviewController extends Controller
{
    
    public function previewBook(Request $request, $bookid)
    {
        // 确认子书是否存在
        $childBook = DB::table('picbook')
            ->where('id', $bookid)
            ->first();

        if (!$childBook) {
            return redirect('/')->withErrors('Child book not found.');
        }

        // 从请求或 session 中获取参数
        $gender = session('gender', $request->query('gender', $childBook->gender));
        $skincolor = session('skin_color', $request->query('skin_color', $childBook->skincolor));
        $language = session('language', $request->query('language', $childBook->language));

        // 验证子书是否匹配用户定制
        if ($childBook->gender != $gender || $childBook->skincolor != $skincolor || $childBook->language != $language) {
            return redirect('/')->withErrors('Book customization does not match.');
        }

        // 查询购物车中是否存在子书
        $cartItem = DB::table('shoppingcart')->where('pbid', $bookid)->first();

        // 查询页面图片
        $pagepics = DB::table('bookpics')
            ->where('pbid', $childBook->id)
            ->orderBy('pagenum')
            ->get();


        // 渲染视图
        return view('preview', [
            'childBook' => $childBook,
            'pagepics' => $pagepics,
        ]);
    }




    public function loadMorePages(Request $request, $bookid)
    {
        $page = $request->query('page', 1);
        $limit = 10;

        // Fetch pages with pagination
        $pages = DB::table('bookpics')
            ->where('pbid', $bookid)
            ->orderBy('pagenum')
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        if ($pages->isEmpty()) {
            return response()->json(['message' => 'No more pages available'], 404);
        }

        return response()->json($pages);
    }

    public function savePreview(Request $request, $bookid)
    {
        // 保存用户对预览的设置或结果
    }
}
