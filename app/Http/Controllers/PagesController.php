<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PostsController;
use DB;
use Auth;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Hash;

class PagesController extends Controller
{
    public function category($id){
        $posts = DB::table('posts')->where('category_id', $id)->paginate(6);
        return view('posts.category')->with('posts',$posts);
    }

    public function searcher(Request $req){
        $searched_content = $req;
        return view('pages.searched')->with('searched_content',$searched_content);
    }

    public function commenter(Request $req){
        $comment = $req;
        return view('doers.success')->with('comment',$comment);
    }

    public function aboutus(){
        $adminInfos = DB::table('admins')->get();
        return view('pages.aboutus')->with('adminInfos',$adminInfos);
    }

    public function sended(Request $req){
        $messageToSend = $req->input();
        session()->put('success', 'Mesajınız başarıyla gönderildi.');
        return view('doers.sended')->with('messageToSend', $messageToSend);
    }

    public function adminControl(){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            return view('pages.adminPanel');
        }
    }

    public function categories(){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $categories = DB::select("select * from categories");
            return view('pages.categories')->with('categories',$categories);
        }
    }

    public function deleteCategory($id){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $categories = DB::select("select * from categories where id = (?)",[$id]);
            return view('posts.maker.forCategory.delete')->with('categories',$categories);
        }
    }

    public function catdel(Request $req, $id){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $category = DB::select("select * from categories where id = (?)",[$id]);
            
            //Check if post exists before deleting
            if (!isset($category)){
                return redirect('/categories')->with('error', 'Kategori bulunamadı.');
            }

            if(Auth::check() and Auth::user()->isAdmin == 1){
                DB::table('categories')->delete($id);
                return redirect('/categories')->with('success', 'Kategori silindi');
            }

            return redirect('/categories')->with('error', 'Yetkisiz deneme');
        }
    }

    public function newCategory(){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $categories = DB::select("select * from categories");
            return view('posts.maker.forCategory.create')->with('categories',$categories);
        }
    }

    public function catadd(Request $req){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $this->validate($req, [
                'title' => 'required',
                'body' => 'required'
            ]);
            
            $title = $req->input('title');
            $body = $req->input('body');
            $user_id = auth()->user()->id;
            DB::table('categories')->insert(
                ['category_name' => $title, 'category_info' => $body, 'added_by' => $user_id ]
            );
            return redirect('/categories')->with('success', 'Kategori oluşturuldu');
        }
    }

    public function editCategory($id){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $category = DB::select("select * from categories where id = (?)" ,[$id]);
            return view('posts.maker.forCategory.edit')->with('category',$category);
        }
    }

    public function catedt(Request $req,$id){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $this->validate($req, [
                'title' => 'required',
                'body' => 'required'
            ]);
            
            $title = $req->input('title');
            $body = $req->input('body');
            $user_id = auth()->user()->id;
            DB::table('categories')->where('id',$id)->update(array(
                'category_name'=>$title, 'category_info'=>$body, 'added_by'=>$user_id
            ));
            return redirect('/categories')->with('success', 'Kategori düzenlendi');
        }
    }

    public function postDetails(){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $posts = Post::orderBy('created_at','desc')->get();
            return view('pages.yazilar')->with('posts', $posts);
        }
    }

    public function deleter($id){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $post = Post::find($id);
            return view('posts.maker.delete')->with('post',$post);
        }
    }

    public function create(){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $categories = DB::select("select id, category_name from categories");
            return view('posts.maker.create')->with('categories',$categories);
        }
    }
    
    public function comments(){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $comments = DB::select("select * from comments where adminApprv = 0");
            return view('pages.comments')->with('comments', $comments);
        }
    }
    
    public function comacc(Request $req,$id){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            DB::table('comments')->where('id',$id)->update(array(
                'adminApprv' => 1
            ));
            return redirect('/comments')->with('success', 'Yorum onaylandı');
        }
    }

    public function comdel(Request $req,$id){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            DB::table('comments')->delete($id);
            return redirect('/comments')->with('success', 'Yorum silindi');
        }
    }
    
    public function searched(){
        if(Auth::check() and Auth::user()->isAdmin == 1){
        $searches = DB::select("select * from searches order by created_at desc");
        return view('pages.searched4A')->with('searches',$searches);
        }
    }

    public function users(){
        if(Auth::check() and Auth::user()->isAdmin == 1){
        $users = DB::select("select * from users where adminApprv = 0");
        return view('pages.users')->with('users',$users);
        }
    }

    public function allOfUsers(){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $users = DB::select("select * from users");
            return view('pages.allOfUsers')->with('users',$users);
        }
    }

    public function admacc($id){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            DB::table('users')->where('id',$id)->update(array(
                'isAdmin' => 1
            ));
            return redirect('allOfUsers')->with('success', 'Üyeye admin yetkisi verildi');
        }
    }

    public function admdel($id){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            DB::table('users')->where('id',$id)->update(array(
                'isAdmin' => 0
            ));
            return redirect('allOfUsers')->with('success', 'Üyeden admin yetkisi alındı');
        }
    }
    
    public function usacc(Request $req,$id){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            DB::table('users')->where('id',$id)->update(array(
                'adminApprv' => 1
            ));
            return redirect('/users')->with('success', 'Kullanıcı onaylandı');
        }
    }
    
    public function usdel(Request $req,$id){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            DB::table('users')->delete($id);
            return redirect('/users')->with('success', 'Kullanıcı silindi');
        }
    }
    
    public function aboutMe(){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $id= Auth::user()->id;
            $adminInfos =DB::select("select * from admins where user_id = (?)" ,[$id]);
            return view('pages.aboutMe')->with('adminInfos', $adminInfos);
        }
    }
    
    public function abMeEd(Request $request,$id){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $this->validate($request, [
                'phone' => 'required',
                'about_admin' => 'required' ,
                'address' => 'required',
                'lnkd' => 'required' ,
                'ins' => 'required' ,
                'fb' => 'required'
            ]);

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
            
                    $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
                $thumb = Image::make($request->file('cover_image')->getRealPath());
                $thumb->resize(80, 80);
                $thumb->save(public_path('storage\cover_images\\'.$thumbStore));
            }
            
            $now = Carbon::now()->toDateTimeString();
            $aid = Auth::user()->id;
            $phone = $request->input('phone');
            $about_admin = $request->input('about_admin');
            $address = $request->input('address');
            $lnkd = $request->input('lnkd');
            $ins = $request->input('ins');
            $fb = $request->input('fb');
            if($request->hasFile('cover_image')){
                $image = $fileNameToStore;
                DB::table('admins')->where('user_id',$aid)->update(array(
                    'imageToShow'=>$fileNameToStore
                ));
            }
            DB::table('admins')->where('user_id',$aid)->update(array(
                'phone_number'=>$phone, 'address'=>$address, 'about_admin'=>$about_admin, 
                'linkedin_link'=>$lnkd, 'instagram_link'=>$ins, 'facebook_link'=>$fb, 'updated_at' => $now
            ));
            return redirect('/aboutMe')->with('success', 'Bilgileriniz güncellendi.');
        }
    }
    
    public function contacts(){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $contacts =DB::select("select * from contacts where messageFor = -1 order by created_at desc");
            return view('pages.contacts')->with('contacts', $contacts);
        }
    }
    
    public function contact($id){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $contact = DB::select("select * from contacts where id = (?)",[$id]);
            DB::table('contacts')->where('id',$id)->update(array(
                'seen' => 0
            ));
            return view('pages.contact')->with('contact', $contact);
        }
    }
    
    public function reply(Request $request,$id){
        if(Auth::check() and Auth::user()->isAdmin == 1){
            $mesaj = $request->input('mesaj');
            $messageFor = $id;
            $messageNo = $request->input('messageNo');
            $now = Carbon::now()->toDateTimeString();
            $user_id =  Auth::user()->id;
            DB::table('contacts')->insert(
                ['message' => $mesaj, 'messageFor' => $messageFor, 'user_id' => $user_id, 'created_at' => $now]
            );
            $contact = DB::select("select * from contacts where id = (?)",[$messageNo]);
            return view('pages.contact')->with('contact', $contact);
        }
    }
    
    public function messagesForMe(){
        if(Auth::check()){
            $contact = DB::select("select * from contacts where user_id = (?) or messageFor = (?) order by created_at asc", [Auth::user()->id,Auth::user()->id]);
            return view('pages.messagesToMe')->with('contact', $contact);
        }
    }
    
    public function changePass(){
        if(Auth::check()){
            return view('pages.changePass');
        }
    }

    public function changeIt(Request $request, $id){
        if(Auth::check() and $id == Auth::user()->id){
            $old = $request->input('old');
            $new = $request->input('new');
            $new2 = $request->input('new2');
            $hashedPassword = Auth::user()->getAuthPassword();
            if(Hash::check($old, $hashedPassword)){
                if($new == $new2){
                    $new = Hash::make($new);
                    DB::table('users')->where('id',Auth::user()->id)->update(array(
                        'password' => $new
                    ));
                    return redirect('/')->with('success', 'Şifreniz başarıyla değiştirildi.');
                }
                return redirect('/changePass')->with('error', 'Şifreniz değiştirilmedi. Yeni şifreler eşleşmeli.');
            }
            return redirect('/changePass')->with('error', 'Şifre değiştirilmedi. Eski şifrenizi yanlış girdiniz.');
        }
    }
}
