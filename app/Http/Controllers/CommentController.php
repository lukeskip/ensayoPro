<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\Comment as Comment;
use Illuminate\Support\Facades\Validator;
use App\User as User;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::paginate(15);
        return view('reyapp.admin.comments')->with('comments',$comments);
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
    public function store(Request $request)
    {
        // Registramos las reglas de validación
        $rules = array(
            'title'         => 'required|max:255',
            'description'   => 'required|max:1000',
            'room_id'       => 'required|integer',       
        );

        // Validamos todos los campos
        $validator = Validator::make($request->all(), $rules);

        $room_id        = $request->room_id;
        $score          = $request->score;

        // Si la validación falla, nos detenemos y mandamos false
        if ($validator->fails()) {
            return response()->json(['success' => false,'message'=>'Hay campos con información inválida, por favor revísalos']);
        }

        $user_id = Auth::user()->id;
        $status  = 'pending';
        $comment = new Comment;
        $comment->title         = $request->title;
        $comment->description   = $request->description;
        $comment->room_id       = $request->room_id;
        $comment->user_id       = $user_id;
        $comment->status        = $status;

        $comment->save();
        $author = $comment->users->name;
        $date = $comment->created_at->format('d/m/Y');
        return response()->json(['success' => true,'message'=>'Tu comentario ha sido guardado','title' => $request->title,'description' => $request->description ,'author' => $author,'class' => $status,'date'=>$date]);
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
        $comment = Comment::find($id);
        $comment->status = $request->status;
        $comment->save();

        return response()->json(['success' => true,'message'=>'El comentario ha sido actualizado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::guest()){
            
            $user = User::find(Auth::user()->id)->id;
            $comment = Comment::find($id);
 
            // Revisamos que el comentario pertenezca al usuario loggeado
            if($comment->user_id == $user){
                $comment->delete();
                return response()->json(['success' => true,'message'=>'Tu comentario ha sido borrado','id'=>$comment->id]);   
            }
            
       
        }else{
            return response()->json(['success' => false,'message'=>'No puedes borrar este comentario','id'=>$comment->id]); 
        }
        
    }
}
