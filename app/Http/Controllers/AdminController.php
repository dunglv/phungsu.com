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
use App\Mail\UserMail;
class AdminController extends Controller
{
    public function __construct()
    {
        // dd(count(request()->segments()));
        // dd(get_class_methods(url()));
    }
    public function home()
    {
        $users = User::all();
        $articles = Article::all();
        $comments = Comment::all();
        $latest_a = Article::where('active', 1)->orderBy('id', 'desc')->take(10)->get();
        $latest_u = User::where('auth', 0)->orderBy('id', 'desc')->take(10)->get();
        $latest_c = Comment::where('active', 1)->orderBy('id', 'desc')->take(10)->get();
    	return view('admin.partials.home')->with(array('articles' => $articles, 'users' => $users, 'comments' => $comments, 'latest_a' => $latest_a, 'latest_u' => $latest_u, 'latest_c' => $latest_c));
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
        return view('admin.article.locked')->with(['articles'=>$articles]);
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
            return redirect()->route('ad.a.edit-normal', $id)->with(['status' => 1, 'label' => 'Thành công', 'alert' => 'success', 'message' => 'Cập nhật bài viết thành công']);
        }else{
            return redirect()->back()->with(['status' => 0, 'label' => 'Lỗi', 'alert' => 'danger', 'message' => 'Cập nhật bài viết không thành công']);
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
                return redirect()->back()->with(['status' => 1, 'label' => 'Thành công', 'alert' => 'success', 'message' => 'Thay đổi trạng thái bài viết thành công']);
            }else{
                return redirect()->back()->with(['status' => 0, 'label' => 'Lỗi', 'alert' => 'danger', 'message' => 'Thay đôi trạng thái bài viết không thành công']);
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
            return redirect()->back()->with(['status' => 1, 'alert' => 'success', 'message' => 'Thêm chủ đề thành công', 'label' => 'Thành công']);
        }else{
            return redirect()-back()->with(['status' => 0, 'alert' => 'danger', 'message' => 'Thêm chủ đề thất bại', 'label' => 'Lỗi']);
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
            return redirect()->back()->with(['status' => 1, 'alert' => 'success', 'message' => 'Cập nhật chủ đề thành công', 'label' => 'Thành công']);
        }else{
            return redirect()-back()->with(['status' => 0, 'alert' => 'danger', 'message' => 'Cập nhật chủ đề thất bại', 'label' => 'Lỗi']);
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
                 return redirect()->back()->with(['status' => 1, 'alert' => 'success', 'message' => 'Thay đổi trạng thái chủ đề thành công', 'label' => 'Thành công']);
            }else{
                 return redirect()->back()->with(['status' => 0, 'alert' => 'danger', 'message' => 'Thay đổi trạng thái chủ đề thất bại', 'label' => 'Lỗi']);
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
            'title' => 'required|min:2|max:100|unique:tags,title',
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
            return redirect()->back()->with(['status' => 1, 'message' => 'Thêm mới thẻ thành công', 'alert' => 'success', 'label' => 'Thành công']);
        }else{
            return redirect()-back()->with(['status' => 0, 'message' => 'Thêm mới thẻ không thành công', 'alert' => 'danger', 'label' => 'Lỗi']);
        }
    }

    public function tag_edit($id='')
    {
    	$t = Tag::find($id);
        if ($t->count() > 0) {
            return view('admin.tag.edit')->with(['tag' => $t]);
        }else{
            return redkirect()->back();
        }
    }

    public function tag_update($id='', Request $request)
    {
    	$message = array();
        $this->validate($request, [
            'title' => 'required|min:2|max:100',
            'description' => 'min:10|max:200',
            'thumbnail' => 'mimes:jpg,jpeg,png,gif,bmp|between:1,10240'
            //'audio' => 'mimes:mpga,3gp,m4a,wav,wma,amr|between:1,10240',

            ], $message);
        $public_audio_url = url('/').'/public/audio/upload/';

        $t = Tag::find($id);
        $t->title = $request->get('title');
        $t->slug = $request->get('slug');
        $t->description = ($request->has('description'))?$request->get('description'):NULL;
        $t->active = $request->get('active');
        $thumb = ($request->hasFile('thumbnail'))?md5(preg_replace('/.jpg$|.png$|.gif$|.bmp$|.jpeg$/i', '', $request->file('thumbnail')->getClientOriginalName())).'.'.$request->file('thumbnail')->getClientOriginalExtension():NULL;

        if ($t->save()) {
            if ($request->hasFile('thumbnail')) {
                $request->file('thumbnail')->move(public_path().'/images/upload', $thumb);
            }
            return redirect()->back()->with(['status' => 1, 'message' => 'Cập nhật thẻ thành công', 'alert' => 'success', 'label' => 'Thành công']);
        }else{
            return redirect()-back()->with(['status' => 0, 'message' => 'Cập nhật thẻ không thành công', 'alert' => 'danger', 'label' => 'Lỗi']);
        }
    }

    public function tag_pending($value='')
    {
    	$tags = Tag::where('active', 0)->paginate(10);
        return view('admin.tag.pending')->with(['tags' => $tags]);
    }

    public function tag_locked($value='')
    {
    	$tags = Tag::where('active', 2)->paginate(10);
        return view('admin.tag.locked')->with(['tags' => $tags]);
    }

    public function tag_active($id='')
    {
        $t = Tag::find($id);
        if ($t->count() > 0) {
            if ($t->active === 0) {
                $t->active = 1;
            }elseif($t->active === 1){
                $t->active = 0;
            }
            if ($t->save()) {
                return redirect()->back()->with(['status' => 1, 'message' => 'Thay đổi trạng thái thẻ thành công', 'alert' => 'success', 'label' => 'Thành công']);
            }else{
                return redirect()->back()->with(['status' => 0, 'message' => 'Thay đổi trạng thái thẻ không thành công', 'alert' => 'danger', 'label' => 'Lỗi']);
            }
        }else{
            return redirect()->back();
        }
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
        return view('admin.user.pending')->with('users', $users);
    }

    public function user_deactive($value='')
    {
    	$users = User::where('active', 2)->where('auth', 0)->paginate(10);
        return view('admin.user.locked')->with('users', $users);
    }

    public function user_lock($id='')
    {
        $u = User::find($id);
        if ($u->count() > 0) {
            if ($u->active === '1' || $u->active === '0') {
                $u->active = 2;
            }elseif($u->active === '2'){
                $u->active = 1;
            }

            if ($u->save()) {
                return redirect()->back()->with(['status' => 1, 'message' => 'Thay đổi trạng thái thành viên thành công', 'label' => 'Thành công', 'alert' => 'success']);
            }else{
                return redirect()->back()->with(['status' => 0, 'message' => 'Thay đổi trạng thái thành viên thành công', 'label' => 'Lỗi', 'alert' => 'danger']);
            }
        }else{
            return redirect()->back();
        }
    }

    public function user_auth($id='')
    {
        $u = User::find($id);
        if ($u->count() < 1) {
            return redirect()->back();
        }
        return view('admin.user.auth')->with(['user' => $u]);
    }

    public function user_auth_update($id='', Request $request)
    {
    	$u = User::find($id);
        if ($u->count() < 1) {
            return redirect()->back();
        }else{
            $u->auth = $request->get('auth');
            if ($u->save()) {
                 return redirect()->back()->with(['status' => 1, 'message' => 'Phân quyền thành công', 'label' => 'Thành công', 'alert' => 'success']);
            }else{
                 return redirect()->back()->with(['status' => 0, 'message' => 'Phân quyền không thành công', 'label' => 'Lỗi', 'alert' => 'danger']);
            }
        }
    }

    public function user_profile()
    {
        $user = auth()->user();
        return view('admin.user.profile')->with('user', $user);
    }

    public function user_profile_update(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->name = ($request->has('name'))?$request->get('name'):NULL;
        $user->fullname = ($request->has('fullname'))?$request->get('fullname'):NULL;
        $user->gender = ($request->has('gender'))?$request->get('gender'):NULL;
        $user->phone = ($request->has('phone'))?$request->get('phone'):NULL;
        $user->address = ($request->has('address'))?$request->get('address'):NULL;
        $user->religion = ($request->has('religion'))?$request->get('religion'):NULL;
        $user->bio = ($request->has('bio'))?$request->get('bio'):NULL;
        if ($user->save()) {
            return redirect()->back()->with(['status'=>1, 'label' => 'Thành công', 'alert' => 'success', 'message' => 'Cập nhật thông tin cá nhân thành công']);
        }else{
            return redirect()->back()->with(['status'=>0, 'label' => 'Lỗi', 'alert' => 'danger', 'message' => 'Cập nhật thông tin cá nhân không thành công']);
        }
    }

    public function user_change_password()
    {
        return view('admin.user.change-password');
    }

    public function user_change_password_update(Request $request)
    {
        $message = array(
            'old_password.oldpassword' => 'Mật khẩu cũ không đúng. Vui lòng nhập chính xác mật khẩu đã đăng ký trước đó.',
            'password_confirmation.same' => 'Xác nhận mật khẩu không trùng khớp'
            );
        Validator::extend('oldpassword', function ($attribute, $value)
        {
            if (Auth::check()) {
                $pass = auth()->user()->password;
            }else{
                $pass ='';
            }
            return \Hash::check($value, $pass); 
        });
        $this->validate($request, [
            'old_password' => 'required|oldpassword',
            'password' => 'required|min:8|max:20',
            'password_confirmation' => 'required|same:password'
            ], $message);

        if (Auth::check()) {
            $o_pass = $request->get('old_password');
            $n_pass = $request->get('password');
            $user = User::find(auth()->user()->id);
            $user->password = bcrypt($n_pass);
            if ($user->save()) {
                return redirect()->back()->with(['status' => 1, 'label' => 'Thành công', 'alert' => 'success', 'message' => 'Thay đổi mật khẩu mới thành công. Bây giờ bạn có thể đăng nhập bằng mật khẩu vừa đổi.']);
            }else{
                return redirect()->back()->with(['status' => 0, 'label' => 'Lỗi', 'alert' => 'danger',  'message' => 'Thay đổi mật khẩu mới không thành công. Vui lòng kiểm tra chính xác thông tin nhập vào.']);
            }
        }else{
            return redirect()->back();
        }
    }

    public function user_delete($id='', Request $request)
    {
        # code...
    }

    public function user_destroy($value='')
    {
    	# code...
    }


    public function finish_register()
    {
        return view('mail.register-finish');
    }

    public function activation_email_do(Request $request)
    {
        if ($request->has('email') && $request->has('key')) {
            $email = $request->get('email');
            $key = $request->get('key');
            $user = User::whereHas('active_users', function($q) use($key){
                $q->where('key', $key);
            })->where('email', $email)->get();

            if ($user->count() > 0) {
                $user[0]->active = 1;
                // $user[0]->active_users()->active = 1;
                $user[0]->active_users(['active'=>1])->save();
                $user[0]->save();
            }
        }
    }
    public function activation_email_success()
    {
        return view('mail.active-user');
    }

}
