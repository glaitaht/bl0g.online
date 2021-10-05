<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Auth;
use DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()// posts contoller'ın index fonksiyonu anasayfadaki cardların bilgisini gönderiyor 
    {
        $posts = Post::orderBy('created_at','desc')->paginate(6); //en son yazılandan geriye doğru 6şarlı gönderiyor
        return view('posts.index')->with('posts', $posts);//posts klasöründeki index dosyasını kullanarak geriye view gönderiyor.
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //gelen bilgiler ile yeni post girdisi oluşturuyor
    {
        $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Handle File Upload
        if($request->hasFile('cover_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
		
	    // make thumbnails
	    $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('cover_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage\cover_images\\'.$thumbStore);
		
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Create Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->postBody = $request->input('body');
        $post->category_id = $request->input('category');
        $post->user_id = auth()->user()->id;
        $post->imageToShow = $fileNameToStore;
        $post->save();

        return redirect('/postDetails')->with('success', 'Yazı oluşturuldu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) // herhangi bir post tıklandığında bu fonksiyon çalışıyor
    {
        $post = Post::find($id);// o postu bulup
        return view('posts.show')->with('post',$post);//geriye döndürüyor
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) // herhangi bir post editlenecek ise bu rota çalışıyor
    {
        if(Auth::check() and Auth::user()->isAdmin == 1){//eğer kullanıcı giriş yaptıysa ve admin yetkisi var ise görebiliryor
            $categories = DB::select("select id, category_name from categories");//geriye kategori
            $post = Post::find($id);//ve postu döndürüyor
            return view('posts.maker.edit')->with('post',$post)->with('categories',$categories);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)// post editlenirken kullanılan form elemanları ile gelen bilgi burada işlenip veritabanına aktarılıyor
    {
        $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'body' => 'required'
        ]);
		$post = Post::find($id);
        if($request->hasFile('cover_image')){
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
            Storage::delete('storage\cover_images\\'.$post->cover_image);
	        $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('cover_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save(public_path('storage\cover_images\\'.$thumbStore));
        }
        $post->title = $request->input('title');
        $post->postBody = $request->input('body');
        $post->category_id = $request->input('category');
        if($request->hasFile('cover_image')){
            $post->imageToShow = $fileNameToStore;
        }
        $post->save();
        return redirect('/postDetails')->with('success', 'Yazı başarıyla değiştirildi');//bittikten sonra anasayfaya yönleniyor
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)//eğer post silinecek ise bu rota çalışıyor
    {
        $post = Post::find($id);//gönderilen id'ye ait post bulunuyor 
        
        if (!isset($post)){//var mı diye kontrol ediliyor
            return redirect('/postDetails')->with('error', 'Yazı bulunamadı.');
        }

        if(Auth::check() and Auth::user()->isAdmin == 1){//admin yetkisi var mı diye kontrol edilip
            if($post->cover_image != 'noimage.jpg'){
                Storage::delete('storage\cover_images\\'.$post->cover_image);
            }
            DB::table('comments')->where('post_id',$id)->delete();
            $post->delete();//siliniyor
            return redirect('/postDetails')->with('success', 'Yazı silindi');
        }

        return redirect('/postDetails')->with('error', 'Yetkisiz deneme');
        
    }
}
