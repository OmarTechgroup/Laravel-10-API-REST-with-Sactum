<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostsRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class postcontroller extends Controller
{
    //
    public function index(Request $request)
    {

        $query = Post::query();
        $perpage = 1;
        $page = request()->input('page', 1);
        $search = request()->input('search');

        if ($search) {

            $query->whereRaw("title LIKE '%" . $search . "%'");
        }

        $total = $query->count();
        $resultat = $query->offset(($page - 1) * $perpage)->limit($page)->get();

        try {

            $query = Post::query();
            $perpage = 2;
            $page = request()->input('page', 1);
            $search = request()->input('search');

            if ($search) {

                $query->whereRaw("title LIKE '%" . $search . "%'");
            }

            $total = $query->count();
            $resultat = $query->offset(($page - 1) * $perpage)->limit($perpage)->get();


            //recupereration de la liste des post
            return response()->json([
                'status' => 200,
                'message' => 'La Liste des Post a été Récuperer avec Succées !',
                'current_page' => $page,
                'last_page' => ceil($total / $perpage),
                'items' => $resultat

            ]);
        } catch (Exception $th) {
            return response()->json($th);
        }
    }

    public function store(CreatePostsRequest $request)
    {

        try {
            $post = new Post();

            $post->title = $request->title;
            $post->description = $request->description;
            $post->user_id = auth()->user()->id;
            $post->save();

            return response()->json([
                'status' => 200,
                'message' => 'post cree avec succées !',
                'data' => $post
            ]);
        } catch (Exception $th) {
            return response()->json($th);
        }
    }



    public function update(UpdatePostRequest $request, Post $post, )
    {


        try {



            $post->title = $request->title;
            $post->description = $request->description;

            if ($post->user_id == auth()->user()->id) {
                #verifie si le post a ete crée par le meme utilisateur (id) pour modifier
                $post->save();
            } else {
                #en cas de non 
                return response()->json([
                    'status' => 422,
                    'message' => "vous n'etes pas le createur de ce post",
                ]);
            }


            return response()->json([
                'status' => 200,
                'message' => 'Post modifier avec Succées',
                'data' => $post
            ]);

        } catch (Exception $th) {

            return response()->json($th);
        }

    }



    public function delete(Post $post)
    {

        try {

            if ($post->user_id == auth()->user()->id) {

                #verifie si le post a ete crée par le meme utilisateur (id) pour supprimer
                $post->delete();


                return response()->json([
                    'status' => 200,
                    'message' => 'Post Supprimer avec succes !',
                    'data' => $post
                ]);

            } else {
                #en cas de non 
                return response()->json([
                    'status' => 422,
                    'message' => "vous n'etes pas le l'auteur  de ce post",
                ]);
            }





        } catch (Exception $th) {
            return response()->json($th);
        }
    }
}
