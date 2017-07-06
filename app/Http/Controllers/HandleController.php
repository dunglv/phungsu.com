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
use App\Stat;
use App\Comment;
use App\User;
use Validator;
use App\Events\ArticleStatEvent;
use Carbon\Carbon;
class HandleController extends Controller
{
    public function home()
    {
        $articles = Article::where('active', 1)->orderBy('id', 'desc')->take(4)->get();
        $categories = Category::where('active', 1)->take(4)->get();
    	return view('partials.home')->with(['articles' => $articles, 'categories' => $categories]);
    }

    public function home_create()
    {
        $articles = Article::inRandomOrder()->where('active', 1)->get();
    	return view('article.create-home')->with(['articles' => $articles]);
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
            return redirect()->route('ui.article.create-article')->with('flash_success', 'Add new article successful.');
        }else{
            return redirect()->back()->with('flash_error', 'Create new article is failed');
        }
    }

    public function article_detail($slug="", Request $request)
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
    	    return view('article.detail-article')->with(['article' => $article, 'comments' => $comments, 'sames' => $sames]);
        }else{
            return redirect()->route('ui.home');
        }
    }
    public function article_detail_mp3($slug="", Request $request)
    {
        $article = Article::where('slug', $slug)->where('active', 1)->get();
        $comments = Comment::whereHas('article', function($q) use ($slug){
            $q->where('slug', $slug);
        })->where('parent', NULL)->paginate(10);

        if (count($article) > 0) {
            return view('article.detail-mp3')->with(['article' => $article, 'comments' => $comments]);
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
        $latests = Article::whereHas('tags', function($query) use ($slug){
            $query->where('slug', $slug);
        })->orderBy('id', 'desc')->take(4)->get();

        $articles = Article::whereHas('tags', function($query) use ($slug){
            $query->where('slug', $slug);
        })->paginate(10);
        return view('tag.detail-tag')->with(['articles' => $articles, 'latests' => $latests]);
    }

    /**************************************************************************************
     * CATEGORY (+category)
     **************************************************************************************
     * 
     * 
     **/
    public function category_detail($slug='', Request $request)
    {
        $latests =  Article::whereHas('category', function($query) use ($slug){
            $query->where('slug', $slug);
        })->where('active', 1)->orderBy('id', 'desc')->take(4)->get();
        $articles = Article::whereHas('category', function($query) use ($slug){
            $query->where('slug', $slug);
        })->where('active', 1)->paginate(10);
        return view('category.detail-category')->with(['articles' => $articles, 'latests' => $latests]);
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
            $latests = Article::where('title', 'like', '%'.$query.'%')->orWhere('description', 'like', '%'.$query.'%')->orWhere('content', 'like', '%'.$query.'%')->where('active', 1)->orderBy('id', 'desc')->take(4)->get();
            $articles = Article::where('title', 'like', '%'.$query.'%')->orWhere('description', 'like', '%'.$query.'%')->orWhere('content', 'like', '%'.$query.'%')->where('active', 1)->paginate(10);
            return view('search.result')->with(['articles' => $articles, 'latests' => $latests]);
        }
        else{
            $latests = Article::where('active', 1)->orderBy('id', 'desc')->take(4)->get();
            $articles = Article::where('active', 1)->paginate(10);
            return view('search.result')->with(['articles' => $articles, 'latests' => $latests]);
        }
    }

    /**************************************************************************************
     * comment (+comment)
     **************************************************************************************
     * CURD new comment
     * 
     * 
     **/
    public function comment_store($slug, Request $request)
    {
        if ($request->has('comment_edit') && !empty($request->get('comment_edit'))) {
            $cmt = Comment::find($request->get('comment_edit'));
            if ($cmt->count() > 0) {
                $cmt->comment = $request->get('comment');
                if ($cmt->save()) {
                    return redirect(url()->previous().'#cmt_'.$request->get('comment_edit'));
                }
            }
        }
        $article = Article::where('slug', $slug)->get();
        $comment = new Comment;
        $comment->comment = $request->comment;
        $edit =  (empty($request->edit) || $request->has('edit'))?NULL:$request->get('edit');
        $comment->edit = json_encode(array('comment'=>$edit, 'time'=>Carbon::now()));
        $comment->parent = !empty($request->get('parent'))?$request->get('parent'):NULL;
        $comment->active = 1;
        if ($comment->save()) {
            $comment->article()->attach($article[0]->id, array('user_id' => auth()->user()->id));
            return redirect(url()->previous().'#cmt_'.$comment->id);
        }
    }

    public function handle_req_comment(Request $request)
    {
        if ($request->has('q')) {
            //Check request from user, if delete comment then continute
            if ($request->get('q') === base64_encode('d-c-r')) {
                //Get id from comment to delete
                $comment = Comment::find($request->get('id'));
                //Check comment is a parent of orther comments, if parent then delete children comment
                if (is_null($comment->parent) || empty($comment->parent)) {
                    $child = Comment::where('parent', $comment->id)->get();
                    //Send id sub comment to ajax
                    $a = array();
                    if($comment->delete()){
                        foreach ($child as $ch) {
                            $a[] = $ch->id;
                            $cmt = Comment::find($ch->id);
                            $cmt->delete();
                        }
                        return array('status' => 'OK', 'scmt' => $a);
                    }else{
                        return array('status' => 'Fail');
                    }
                }else{
                    if($comment->delete()){
                        return array('status' => 'OK');
                    }else{
                        return array('status' => 'Fail');
                    }
                }
                
            }
        }
    }

    //+user
    public function logout()
    {
        if (Auth::check()) {
            if (Auth::logout()) {
                return redirect('/');
            }else{
                return redirect('/');
            }
        }else{
            return redirect()->back();
        }
    }

    public function user_detail(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            return view('user.profile-me')->with('user', $user);
        }else{
            return redirect('/');
        }
        
    }

    public function user_change_password(Request $request)
    {
        return view('user.change-password');
    }

    public function user_change_password_update(Request $request)
    {
        $message = array(
            'old_password.oldpassword' => 'Mật khẩu cũ không đúng. Vui lòng nhập chính xác mật khẩu đã đăng ký trước đó.'
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
                return redirect()->back()->with(['status' => 1, 'label' => 'success', 'message' => 'Thay đổi mật khẩu mới thành công. Bây giờ bạn có thể đăng nhập bằng mật khẩu vừa đổi.']);
            }else{
                return redirect()->back()->with(['status' => 0, 'label' => 'danger', 'message' => 'Thay đổi mật khẩu mới không thành công. Vui lòng kiểm tra chính xác thông tin nhập vào.']);
            }
        }else{
            return redirect()->back();
        }
    }

    public function user_update_profile(Request $request)
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
            return redirect()->back()->with(['status'=>1, 'label' => 'success', 'message' => 'Cập nhật thông tin cá nhân thành công']);
        }else{
            return redirect('/');
        }
    }

    public function user_setting()
    {
        return view('user.setting')->with(['user' => auth()->user()]);
    }

    public function user_deactivate(Request $request)
    {
        if (Auth::check()) {
            return view('user.deactivate')->with('user', Auth::user());
        }
    }

    public function user_manage(Request $request)
    {
        if (auth()->check()) {
            $articles = Article::whereHas('user', function($q){
                $q->where('id', auth()->user()->id);
            })->orderBy('id', 'desc')->paginate(5);
            $comments = Comment::whereHas('user', function($q){
                $q->where('id', auth()->user()->id);
            })->paginate(5, ['*'], 'cpage');
            return view('user.manage')->with(['user'=>auth()->user(), 'articles' => $articles, 'comments' => $comments]);
        }else{
            return redirect()->back();
        }
    }


    // +you
    public function you_contribute(Request $request)
    {
        $ctb = $request->has('idea')?$request->get('idea'):NULL;
        if (!empty($ctb)) {
            
        }
        return view('user.contribute');
    }

}
