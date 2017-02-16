<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use Auth;
use Storage;
use Carbon\Carbon;
use App\Reply;
use App\User;
use Counter;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stories = Post::where('publish',1)->get();
        //return $stories;
        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        //return $storagePath.'/'.$stories[0]->image;
        return view('cric-blog.blog.index',compact('stories'));
    }

    public function storyIndex($id){
        $contents = Post::all();
        $stories = Post::where('id',$id)->get()->first();
        $comments = Comment::where('post_id',$id)->get();
        $replies = Reply::where('post_id',$id)->get();

        //$value = User::with('comments')->get();

        $comment_user = Comment::where('post_id',$id)->with('username')->get();
        
        //return $comment_user;
        $reply_user = Reply::where('post_id',$id)->with('replyes')->get();
        //return $reply_user;
       
       $count = 232;
        return view('cric-blog.blog.story',compact('stories','contents','comments','replies','comment_user','reply_user','count'));
    }

 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cric-blog.blog.editor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**/

        /*
        *   check for publishment
        */

        //Generate keywords
        $keywords = ['cricket','batting','bowling','filding','catch','bowled','lbw','runout','pitch','over','toss','records','fifty','century','ball','bat','ashes','cricketing','dismiss','team','xi','man','batsman','match','man-of-the-match','six','four','single','double','umpire','icc','bcb','vs','miss','legby'];
        // to be continue...

        $story = $request->story;
        $words = explode(" ",$story);
        $counter = 0;

        for( $i = 0; $i < sizeof($words); $i++){
            for($j = 0; $j < sizeof($keywords); $j++){
                if($words[$i] == strtolower($keywords[$j])){
                    $counter ++;
                }
            }
        }
        $percent = ($counter * 100) / sizeof($words);
        
        if($percent >= 1){
            $post = new Post;
            $path = $request->file('picture')->store('pictures');
            $post->user_id = Auth::user()->id;
            $post->title = $request->title;
            $post->post = $request->story;
            $post->image = $path;
            $post->caption = $request->caption;
            $post->viewer = 0;
            $post->publish = true;
        }else{
            $post = new Post;
            $path = $request->file('picture')->store('pictures');
            $post->user_id = Auth::user()->id;
            $post->title = $request->title;
            $post->post = $request->story;
            $post->image = $path;
            $post->caption = $request->caption;
            $post->viewer = 0;
            $post->publish = false;
        }
        



        $post->save();
        return redirect()->back();
        

    }

    public function storeComments(Request $request,$id){
        
        $comment = new Comment;
        $post = new Post;

        $comment->post_id = $id;
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->comment;
        $comment->save();
        


        return redirect()->back();
    }


    public function storeReplies(Request $request, $id1, $id2){
            
            $reply = new Reply;
            $reply->post_id = $id1;
            $reply->comment_id = $id2;
            $reply->user_id = Auth::user()->id;
            $reply->reply = $request->reply;
            $reply->save();

            return redirect()->back();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
