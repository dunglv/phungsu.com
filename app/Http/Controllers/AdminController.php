<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Category;
use App\Article;
use App\Tag;
use App\Stat;
use App\Comment;
use App\User;
use Validator;
use Mail;
class AdminController extends Controller
{
    public function __construct()
    {
        // dd(count(request()->segments()));
        // dd(get_class_methods(url()));
    }
    public function home()
    {
    	return view('admin.partials.home');
    }

    // +article
    public function article_home()
    {
    	$articles = Article::where('active', 1)->paginate(10);
    	return view('admin.article.home')->with(['articles'=>$articles]);
    }
    public function article_create()
    {
    	$articles = Article::inRandomOrder()->where('active', 1)->get();
    	return view('admin.article.create-home')->with(['articles' => $articles]);
    }

    public function article_create_normal()
    {
    	$cates = Category::all()->where('active', 1);
    	return view('admin.article.create-article')->with('cates', $cates);
    }

    public function article_create_normal_store(Request $request)
    {
    	// dd(auth()->user()->id);
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
            return redirect()->route('ad.a.create-article-normal')->with('flash_success', 'Add new article successful.');
        }else{
            return redirect()->back()->with('flash_error', 'Create new article is failed');
        }
    }

    public function article_create_mp3()
    {
    	$cates = Category::all()->where('active', 1);
        return view('admin.article.upload-mp3')->with('cates', $cates);
    }

    public function article_create_mp3_store(Request $request)
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
            'audio.required' => 'Chọn một tệp tin âm thanh mp3 để upload.',
            'audio.mimes' => 'Định dạng tệp âm thanh chưa đúng. (.mp3, .wma, .amr)',
            'audio.between' => 'Kích thướt ảnh quá nhỏ hoặc quá lớn (tối đa: 2:max)',
            'tags.mintag' => 'Nhập ít nhất một thẻ cho bài viết'
            );
        $validate = $this->validate($request, [
            'title' => 'required|min:2|max:200|unique:articles,title',
            'slug' => 'required|min:2|max:200|unique:articles,slug',
            'description' => 'min:10|max:500',
            'content' => 'min:100',
            'category' => 'choose',
            'audio' => 'required|mimes:mpga|between:1,10240', 
            //'audio' => 'mimes:mpga,3gp,m4a,wav,wma,amr|between:1,10240',

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
        $a->user_id = auth()->user()->id;
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
             $a->stat()->save(new Stat(['article_id' => $a->id]));
            return redirect()->route('ad.a.create-article-mp3')->with('flash_success', 'Add new article successful.');
        }else{
            return redirect()->back()->with('flash_error', 'Create new article is failed');
        }
    }

    public function article_detail_normal($slug ='', Request $request)
    {
    	$article = Article::where('slug', $slug)->where('active', 1)->get();
        if (count($article) > 0) {
            $sames = Article::whereHas('category', function($q) use($article){
                $q->where('id', $article[0]->category[0]->id);
            })->where('id', '<>', $article[0]->id)->get();
            $comments = Comment::whereHas('article', function($q) use ($slug){
                $q->where('slug', $slug);
            })->where('parent', NULL)->paginate(10);
            event(new ArticleStatEvent('view', $article[0]));
    	    return view('admin.article.detail-article')->with(['article' => $article, 'comments' => $comments, 'sames' => $sames]);
        }else{
            return redirect()->route('ad.home');
        }
    }

    public function article_detail_mp3($slug="", Request $request)
    {
    	$article = Article::where('slug', $slug)->where('active', 1)->get();
        $comments = Comment::whereHas('article', function($q) use ($slug){
            $q->where('slug', $slug);
        })->where('parent', NULL)->paginate(10);

        if (count($article) > 0) {
            return view('admin.article.detail-mp3')->with(['article' => $article, 'comments' => $comments]);
        }else{
            return redirect()->route('ad.home');
        }
    }

    public function article_pending()
    {
    	$articles = Article::where('active', 0)->paginate(10);
        return view('admin.article.pending')->with(['articles'=>$articles]);
    }

    public function article_locked($value='')
    {
    	$articles = Article::where('active', 2)->paginate(10);
        return view('admin.article.pending')->with(['articles'=>$articles]);
    }

    public function article_edit_normal($id='')
    {
        $a = Article::find($id);
        $cates = Category::all()->where('active', 1);
        // dd($cates);
        if ($a->count()  > 0) {
            return view('admin.article.edit-normal')->with(['article'=>$a, 'cates' => $cates]);
        }else{
            return redirect()->back();
        }
    }

    public function article_edit_normal_update($id, Request $request)
    {
        // dd(auth()->user()->id);
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
            'description.min' => 'Mô tả quá ngắn để có cái nhìn tổng quát về bài viết.',
            'description.max' => 'Mô tả quá dài. Vui lòng thể hiện vào phần nội dung',
            'category.choose' => 'Hãy chọn một chủ đề cụ thể cho bài viết.',
            'content.min' => 'Nội dung quá ngắn. Hãy thể hiện lòng chân thành khi viết bài.',
            'thumbnail.mimes' => 'Định dạng ảnh chưa đúng. (.JPG, .PNG, .GIF, .BMP, .JPEG)',
            'thumbnail.between' => 'Kích thướt ảnh quá nhỏ hoặc quá lớn (tối đa: 2:max)',
            'tags.mintag' => 'Nhập ít nhất một thẻ cho bài viết'
            );
        $validate = $this->validate($request, [
            'title' => 'required|min:10|max:200',
            'slug' => 'required|min:10|max:200',
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
        $a = Article::find($id);
        $a->title = $title;
        $a->slug = $slug;
        $a->description = $desc;
        $a->format = 0;
        $a->content = $content;
        $a->user_id = auth()->user()->id;
        $thumb = ($request->hasFile('thumbnail'))?md5(preg_replace('/.jpg$|.png$|.gif$|.bmp$|.jpeg$/i', '', $request->file('thumbnail')->getClientOriginalName())).'.'.$request->file('thumbnail')->getClientOriginalExtension():NULL;
        $a->thumbnail = $public_image_url.$thumb;
        $a->opencomment = $request->get('opencomment');
        $a->openedit = $request->get('openedit');
        $a->notify = $request->get('notify');
        // $a->active = $request->get('active');
        if($a->save()){
            // Handle tag and store pivot
            $tgs = explode(',', $tag);
            // for ($i=0; $i < count($tgs); $i++) { 
            //     // $a->tags()->sync($tgs[$i]);
            // }
            $a->tags()->sync($tgs);
            $a->category()->sync([$cate]);
            if ($request->hasFile('thumbnail')) {
                $request->file('thumbnail')->move(public_path().'/images/upload/article', $thumb);
                // if (file_exists(filename)) {
                //     # code...
                // }
            }
            $a->stat()->save(new Stat(['article_id' => $a->id]));
            return redirect()->route('ad.a.edit-normal', $id)->with(['status' => 1, 'label' => 'success', 'message' => 'Update article']);
        }else{
            return redirect()->back()->with(['status' => 0, 'label' => 'danger', 'message' => 'Update article']);
        }
    }

    public function article_active($id='')
    {
        $a = Article::find($id);
        if ($a->count() > 0) {
            if ($a->active == 0) {
                $a->active = 1;
            }elseif($a->active == 1){
                $a->active = 0;
            }
            if ($a->save()) {
                return redirect()->back()->with(['status' => 1, 'label' => 'success', 'message' => 'Change state of article is']);
            }else{
                return redirect()->back()->with(['status' => 0, 'label' => 'danger', 'message' => 'Change state of article is']);

            }
        }else{
            return redirect()->back();
        }
    }

    // +category
    public function category_home()
    {
    	$categories = Category::where('active', 1)->paginate(10);
        return view('admin.category.home')->with(['categories' => $categories]);
    }

    public function category_create()
    {
    	return view('admin.category.create');
    }

    public function category_store(Request $request)
    {
        $message = array();
        $this->validate($request, [
            'title' => 'required|min:2|max:200|unique:categories,title',
            'description' => 'min:10|max:500',
            'thumbnail' => 'mimes:jpg,jpeg,png,gif,bmp|between:1,10240'
            //'audio' => 'mimes:mpga,3gp,m4a,wav,wma,amr|between:1,10240',

            ], $message);
        $public_audio_url = url('/').'/public/audio/upload/';

        $c = new Category;
        $c->title = $request->get('title');
        $c->slug = $request->get('slug');
        $c->description = ($request->has('description'))?$request->get('description'):NULL;
        $c->active = $request->get('active');
        $thumb = ($request->hasFile('thumbnail'))?md5(preg_replace('/.jpg$|.png$|.gif$|.bmp$|.jpeg$/i', '', $request->file('thumbnail')->getClientOriginalName())).'.'.$request->file('thumbnail')->getClientOriginalExtension():NULL;

        if ($c->save()) {
            if ($request->hasFile('thumbnail')) {
                $request->file('thumbnail')->move(public_path().'/images/upload', $thumb);
            }
            return redirect()->back()->with(['status' => 1, 'message' => 'Add new category', 'label' => 'success']);
        }else{
            return redirect()-back()->with(['status' => 0, 'message' => 'Add new category', 'label' => 'error']);
        }
    }

    public function category_edit($id = '')
    {
        $c = Category::find($id);
        if ($c->count() > 0) {
    	   return view('admin.category.edit')->with(['category' => $c]);
        }else{
            return redirect()->back();
        }
    }

    public function category_update($id = '', Request $request)
    {
    	$message = array();
        $this->validate($request, [
            'title' => 'required|min:2|max:200',
            'description' => 'min:10|max:500',
            'thumbnail' => 'mimes:jpg,jpeg,png,gif,bmp|between:1,10240'
            //'audio' => 'mimes:mpga,3gp,m4a,wav,wma,amr|between:1,10240',

            ], $message);
        $public_audio_url = url('/').'/public/audio/upload/';

        $c = Category::find($id);
        $c->title = $request->get('title');
        $c->slug = $request->get('slug');
        $c->description = ($request->has('description'))?$request->get('description'):NULL;
        $c->active = $request->get('active');
        $thumb = ($request->hasFile('thumbnail'))?md5(preg_replace('/.jpg$|.png$|.gif$|.bmp$|.jpeg$/i', '', $request->file('thumbnail')->getClientOriginalName())).'.'.$request->file('thumbnail')->getClientOriginalExtension():NULL;

        if ($c->save()) {
            if ($request->hasFile('thumbnail')) {
                $request->file('thumbnail')->move(public_path().'/images/upload', $thumb);
            }
            return redirect()->back()->with(['status' => 1, 'message' => 'Update category', 'label' => 'success']);
        }else{
            return redirect()-back()->with(['status' => 0, 'message' => 'Update category', 'label' => 'error']);
        }
    }

    public function category_active($id = '')
    {
        $c = Category::find($id);
        if ($c->count() > 0) {
            if ($c->active === 0 ) {
                $c->active = 1;
            }else{
                $c->active = 0;
            }
            if($c->save()){
                 return redirect()->back()->with(['status' => 1, 'message' => 'Change status category', 'label' => 'success']);;
            }else{
                 return redirect()->back()->with(['status' => 0, 'message' => 'Change status', 'label' => 'error']);;
            }
        }else{
            return redirect()->back();
        }
    }

    public function category_pending($value='')
    {
    	$categories = Category::where('active', 0)->paginate(10);
        return view('admin.category.pending')->with(['categories' => $categories]);
    }

    public function category_locked($value='')
    {
    	$categories = Category::where('active', 2)->paginate(10);
        return view('admin.category.locked')->with(['categories' => $categories]);
    }

    public function category_delete()
    {
    	# code...
    }

    public function category_destroy()
    {
    	# code...
    }

    // +tag
    public function tag_home()
    {
    	$tags = Tag::where('active', 1)->paginate(10);
        return view('admin.tag.home')->with(['tags' => $tags]);
    }

    public function tag_create()
    {
    	return view('admin.tag.create');
    }

    public function tag_store(Request $request)
    {
    	$message = array();
        $this->validate($request, [
            'title' => 'required|min:2|max:100',
            'description' => 'min:10|max:200',
            'thumbnail' => 'mimes:jpg,jpeg,png,gif,bmp|between:1,10240'
            //'audio' => 'mimes:mpga,3gp,m4a,wav,wma,amr|between:1,10240',

            ], $message);
        $public_audio_url = url('/').'/public/audio/upload/';

        $t = new Tag;
        $t->title = $request->get('title');
        $t->slug = $request->get('slug');
        $t->description = ($request->has('description'))?$request->get('description'):NULL;
        $t->active = $request->get('active');
        $thumb = ($request->hasFile('thumbnail'))?md5(preg_replace('/.jpg$|.png$|.gif$|.bmp$|.jpeg$/i', '', $request->file('thumbnail')->getClientOriginalName())).'.'.$request->file('thumbnail')->getClientOriginalExtension():NULL;

        if ($t->save()) {
            if ($request->hasFile('thumbnail')) {
                $request->file('thumbnail')->move(public_path().'/images/upload', $thumb);
            }
            return redirect()->back()->with(['status' => 1, 'message' => 'Add new tag', 'label' => 'success']);
        }else{
            return redirect()-back()->with(['status' => 0, 'message' => 'Add new tag', 'label' => 'error']);
        }
    }

    public function tag_edit($value='')
    {
    	# code...
    }

    public function tag_update($value='')
    {
    	# code...
    }

    public function tag_pending($value='')
    {
    	$tags = Tag::where('active', 0)->paginate(10);
        return view('admin.tag.home')->with(['tags' => $tags]);
    }

    public function tag_locked($value='')
    {
    	$tags = Tag::where('active', 2)->paginate(10);
        return view('admin.tag.home')->with(['tags' => $tags]);
    }

    public function tag_delete()
    {
    	# code...
    }

    public function tag_destroy($value='')
    {
    	# code...
    }

    // +user
    public function user_home($value='')
    {
    	$users = User::where('active', 1)->where('auth', 0)->paginate(10);
        return view('admin.user.home')->with('users', $users);
    }

    public function user_pending($value='')
    {
    	$users = User::where('active', 0)->where('auth', 0)->paginate(10);
        return view('admin.user.home')->with('users', $users);
    }

    public function user_locked($value='')
    {
    	$users = User::where('active', 2)->where('auth', 0)->paginate(10);
        return view('admin.user.home')->with('users', $users);
    }

    public function user_delete($value='')
    {
    	# code...
    }

    public function user_destroy($value='')
    {
    	# code...
    }

    public function activation_email()
    {
        Mail::send('article.create-home', ['title' => 'Test', 'message' => 'Test mesage'], function ($message)
         {
            $message->from('no-reply@scotch.io', 'Scotch.IO');
            $message->to('vietdungchipro@gmail.com');
        });
    }

}
