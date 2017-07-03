<?php
/*
|--------------------------------------------------------------------------------------
| INSTRUCTIONS TO BETTER WORK WITH This Controller
|--------------------------------------------------------------------------------------
| * Search secsion: +section (+article,+tag,+user,+category,...)
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Category;
use App\Article;
use App\Tag;
use Validator;
use App\Events\ArticleStatEvent;
class HandleController extends Controller
{
    public function home()
    {
        $articles = Article::where('active', 1)->paginate(8);
    	return view('partials.home')->with('articles', $articles);
    }

    public function home_create()
    {
    	return view('article.home-create');
    }

    /**************************************************************************************
     * ARTICLE (+article) Create new article with format normal
     **************************************************************************************
     * Passing category to view create article
     * Store article
     * FORMAT : 0
     **/
    
    public function article_create()
    {
        $cates = Category::all()->where('active', 1);
    	return view('article.create-article')->with('cates', $cates);
    }

    public function article_create_store(Request $request)
    {
        dd(auth()->user());
        $title = $request->get('title');
        $slug = $request->get('slug');
        $desc = $request->get('description');
        $content = $request->get('content');
        $thumb = $request->file('thumbnail');
        $cate = $request->get('category');
        $tag = $request->get('tags');
        $opencmt = $request->get('opencomment');
        $openedit = $request->get('openedit');
        $notify = $request->get('notify');
        Validator::extend('choose', function($attribute, $value, $parameters, $validator){
            return $value > 0;
        });
        Validator::extend('mintag', function($attribute, $value, $parameters, $validator){
            $t = explode(',', $value);
            if (count($t) < 1) {
                return false;
            }
            return true;
        });
        $message = array(
            'title.min' => 'Tiêu đề bài viết quá ngắn. Tối thiểu :min ký tự',
            'title.max' => 'Tiêu đề bài viết quá dài. Tối đa :max ký tự',
            'title.unique' => 'Dường như bài viết đã có trên website. Sử dụng chứ năng tìm kiếm để tra hoặc yêu cầu quyền chỉnh sửa bài viết từ tác giả.',
            'slug.min' => 'Tiêu đề bài viết quá ngắn. Tối thiểu :min ký tự',
            'slug.max' => 'Tiêu đề bài viết quá dài. Tối đa :max ký tự',
            'slug.unique' => 'Dường như bài viết đã có trên website. Sử dụng chứ năng tìm kiếm để tra hoặc yêu cầu quyền chỉnh sửa bài viết từ tác giả.',
            'description.min' => 'Mô tả quá ngắn để có cái nhìn tổng quát về bài viết.',
            'description.max' => 'Mô tả quá dài. Vui lòng thể hiện vào phần nội dung',
            'category.choose' => 'Hãy chọn một chủ đề cụ thể cho bài viết.',
            'content.min' => 'Nội dung quá ngắn. Hãy thể hiện lòng chân thành khi viết bài.',
            'thumbnail.mimes' => 'Định dạng ảnh chưa đúng. (.JPG, .PNG, .GIF, .BMP, .JPEG)',
            'thumbnail.between' => 'Kích thướt ảnh quá nhỏ hoặc quá lớn (tối đa: 2:max)',
            'tags.mintag' => 'Nhập ít nhất một thẻ cho bài viết'
            );
        $validate = $this->validate($request, [
            'title' => 'required|min:10|max:200|unique:articles,title',
            'slug' => 'required|min:10|max:200|unique:articles,slug',
            'description' => 'min:10|max:500',
            'content' => 'min:100',
            'category' => 'choose',
            'thumbnail' => 'mimes:jpg,png,gif,bmp,jpeg|between:1,2048',
            'tags' => 'required|mintag'
            ], $message);
        // if ($validate->fails()) {
        //     return redirect()->back()->withErrors($validate)->withInput();
        // }
        $public_image_url = url('/').'/public/images/upload/article/';
        $a = new Article;
        $a->title = $title;
        $a->slug = $slug;
        $a->description = $desc;
        $a->format = 0;
        $a->content = $content;
        $a->user_id = auth()->user()->id;
        $thumb = ($request->hasFile('thumbnail'))?md5(preg_replace('/.jpg$|.png$|.gif$|.bmp$|.jpeg$/i', '', $request->file('thumbnail')->getClientOriginalName())).'.'.$request->file('thumbnail')->getClientOriginalExtension():'default.jpg';
        $a->thumbnail = $public_image_url.$thumb;
        $a->opencomment = $request->get('opencomment');
        $a->openedit = $request->get('openedit');
        $a->notify = $request->get('notify');
        // $a->active = $request->get('active');
        if($a->save()){
            // Handle tag and store pivot
            $tgs = explode(',', $tag);
            for ($i=0; $i < count($tgs); $i++) { 
                $a->tags()->attach($tgs[$i]);
            }
            if ($request->hasFile('thumbnail')) {
                $request->file('thumbnail')->move(public_path().'/images/upload/article', $thumb);
            }
            $a->category()->attach($cate);
            $a->stat()->save(new Stat(['article_id' => $a->id]));
            return redirect()->route('ui.article.create-article')->with('flash_success', 'Add new article successful.');
        }else{
            return redirect()->back()->with('flash_error', 'Create new article is failed');
        }

    }


    /**************************************************************
     * Create new article with format mp3
     *
     * Passing category to view create article
     * Store article
     * FORMAT : 1
     **/
    
    public function article_upload_mp3()
    {
    	$cates = Category::all()->where('active', 1);
        return view('article.upload-mp3')->with('cates', $cates);
    }

    public function article_upload_mp3_store(Request $request)
    {
        $title = $request->get('title');
        $slug = $request->get('slug');
        $desc = $request->get('description');
        $author = ($request->has('author'))?$request->get('author'):NULL;
        $content = $request->get('content');
        $mp3 = $request->file('audio');
        $format = 1; // 0: normal - 1: mp3 - 2: video
        $cate = $request->get('category');
        $tag = $request->get('tags');
        $opencmt = $request->get('opencomment');
        $openedit = $request->get('openedit');
        $notify = $request->get('notify');
        Validator::extend('choose', function($attribute, $value, $parameters, $validator){
            return $value > 0;
        });
        Validator::extend('mintag', function($attribute, $value, $parameters, $validator){
            $t = explode(',', $value);
            if (count($t) < 1) {
                return false;
            }
            return true;
        });
        $message = array(
            'title.min' => 'Tiêu đề bài viết quá ngắn. Tối thiểu :min ký tự',
            'title.max' => 'Tiêu đề bài viết quá dài. Tối đa :max ký tự',
            'title.unique' => 'Dường như bài viết đã có trên website. Sử dụng chứ năng tìm kiếm để tra hoặc yêu cầu quyền chỉnh sửa bài viết từ tác giả.',
            'slug.min' => 'Tiêu đề bài viết quá ngắn. Tối thiểu :min ký tự',
            'slug.max' => 'Tiêu đề bài viết quá dài. Tối đa :max ký tự',
            'slug.unique' => 'Dường như bài viết đã có trên website. Sử dụng chứ năng tìm kiếm để tra hoặc yêu cầu quyền chỉnh sửa bài viết từ tác giả.',
            'description.min' => 'Mô tả quá ngắn để có cái nhìn tổng quát về bài viết.',
            'description.max' => 'Mô tả quá dài. Vui lòng thể hiện vào phần nội dung',
            'category.choose' => 'Hãy chọn một chủ đề cụ thể cho bài viết.',
            'content.min' => 'Nội dung quá ngắn. Hãy thể hiện lòng chân thành khi viết bài.',
            'audio.mimes' => 'Định dạng tệp âm thanh chưa đúng. (.mp3, .wma, .GIF, .BMP, .JPEG)',
            'audio.between' => 'Kích thướt ảnh quá nhỏ hoặc quá lớn (tối đa: 2:max)',
            'tags.mintag' => 'Nhập ít nhất một thẻ cho bài viết'
            );
        $validate = $this->validate($request, [
            'title' => 'required|min:2|max:200|unique:articles,title',
            'slug' => 'required|min:2|max:200|unique:articles,slug',
            'description' => 'min:10|max:500',
            'content' => 'min:100',
            'category' => 'choose',
            'audio' => 'mimes:mpga,3gp,m4a,wav,wma,amr|between:1,10240',
            'tags' => 'required|mintag'
            ], $message);
        // if ($validate->fails()) {
        //     return redirect()->back()->withErrors($validate)->withInput();
        // }
        $public_audio_url = url('/').'/public/audio/upload/';
        $a = new Article;
        $a->title = $title;
        $a->slug = $slug;
        $a->description = $desc;
        $a->format = $format;
        $a->content = $content;
        $audio = ($request->hasFile('audio'))?md5(preg_replace('/.jpg$|.png$|.gif$|.bmp$|.jpeg$/i', '', $request->file('audio')->getClientOriginalName())).'.'.$request->file('audio')->getClientOriginalExtension():'default.mp3';
        $a->thumbnail = $public_audio_url.$audio;
        $a->opencomment = $request->get('opencomment');
        $a->openedit = $request->get('openedit');
        $a->notify = $request->get('notify');
        // $a->active = $request->get('active');
        if($a->save()){
            // Handle tag and store pivot
            $tgs = explode(',', $tag);
            for ($i=0; $i < count($tgs); $i++) { 
                $a->tags()->attach($tgs[$i]);
            }
            if ($request->hasFile('audio')) {
                $request->file('audio')->move(public_path().'/audio/upload', $audio);
            }
            $a->category()->attach($request->get('category'));
            return redirect()->route('ui.article.create-article')->with('flash_success', 'Add new article successful.');
        }else{
            return redirect()->back()->with('flash_error', 'Create new article is failed');
        }
    }

    public function article_detail($slug="", Request $request)
    {
        $article = Article::where('slug', $slug)->where('active', 1)->get();
        // dd($article[0]->stat);
        if (count($article) > 0) {
            // event(new ArticleStatEvent('view', $article));
    	   return view('article.detail-article')->with('article', $article);
        }else{
            return redirect()->route('ui.home');
        }
    }
    public function article_detail_mp3($slug="", Request $request)
    {
        $article = Article::where('slug', $slug)->where('active', 1)->get();
        if (count($article) > 0) {
            return view('article.detail-mp3')->with('article', $article);
        }else{
            return redirect()->route('ui.home');
        }
    }

    public function article_detail_video($slug="", Request $request)
    {
        $article = Article::where('slug', $slug)->where('active', 1)->get();
        // dd(count($article));
        if (count($article) > 0) {
            return view('article.detail-mp3')->with('article', $article);
        }else{
            return redirect()->route('ui.home');
        }
    }
    

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function handle_req_article(Request $request)
    {
        if ($request->has('q')) {
            $q = $request->get('q');
            if ($q === 'l-t-t' ) {
                $k = $request->get('k');
                $t = Tag::select('title','id')->get();
                $a = array();
                foreach ($t as $tt) {
                    $a[] = array('label' => $tt->title, 'id' => $tt->id);
                }
                return array('l' => $a, 't' => $t);
            }
        }else{
            return false;
        }
    }
    /**************************************************************************************
     * TAG (+tag)
     **************************************************************************************
     * 
     * 
     **/
    public function tag_home(Request $request)
    {
        
        return view('tag.home-tag');
    }

    public function tag_detail($slug = '', Request $request)
    {
        $articles = Article::whereHas('tags', function($query) use ($slug){
            $query->where('slug', $slug);
        })->paginate(10);
        return view('tag.detail-tag')->with('articles', $articles);
    }

    /**************************************************************************************
     * CATEGORY (+category)
     **************************************************************************************
     * 
     * 
     **/
    public function category_detail($slug='', Request $request)
    {
        $articles = Article::whereHas('category', function($query) use ($slug){
            $query->where('slug', $slug);
        })->paginate(10);
        return view('category.detail-category')->with('articles', $articles);
    }

    /**************************************************************************************
     * search (+search)
     **************************************************************************************
     * 
     * 
     **/
    public function search_result(Request $request)
    {
        if ($request->has('q')) {
            $query = $request->get('q');
            $articles = Article::where('title', 'like', '%'.$query.'%')->orWhere('description', 'like', '%'.$query.'%')->orWhere('content', 'like', '%'.$query.'%')->where('active', 1)->paginate(10);
            return view('search.result')->with('articles', $articles);
        }
        else{
            $articles = Article::where('active', 1)->paginate(10);
            return view('search.result')->with('articles', $articles);
        }
    }

}
