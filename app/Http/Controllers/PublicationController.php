<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Collaboration;
use App\Models\Collaborator;
use App\User;
use App\Http\Requests\PublicationRequest;
use Auth;
use DB;
use App\Models\Link;
use App\Models\Menu;
use App\Models\Content;


class PublicationController extends Controller
{
    //////////////////////////////////////////////////////////////////////////
    // publications list controller
    public function list(Request $request) {

      $user=User::where('id',Auth::id())->first();

      if ($user->type =="admin")
      $query=DB::select("
          select * from publications
          where user =".Auth::id()."
      ");

      else $query=DB::select("
          select * from publications p
          where exists (
            select * from collaborations c,collaborators cl
            where c.collaborator=cl.id
            and cl.profile=\"".Auth::id()."\"
            and c.publication=p.id
          )
        ");

      $data= [
        'title' => 'Publications',
        'publications' => $query,
      ];

      return view('publications/pubList',$data);

    }

    //////////////////////////////////////////////////////////////////////////
    // Goto create publication page controller
    public function creation(Request $request){

      $user = User::where('id',Auth::id())->first();

      if($user->type != 'admin') return redirect()->route('access_denied');

      $query = DB::select("
        select * from users u
        where u.type=\"profile\"
        and exists (
            select * from collaborators c
            where c.profile=u.id
            and c.user=\"".Auth::id()."\"
          )
      ");

      $data= [
        'title' => 'Edit Publication',
        'collaborators' => $query,
        'create' => true,
      ];
      return view('publications/pubForm',$data);

    }

    //////////////////////////////////////////////////////////////////////////
    // create new publication controller
    public function create(PublicationRequest $request){

      // check for admin account
      $user = User::where('id',Auth::id())->first();
      if($user->type != 'admin') return redirect()->route('access_denied');

      // create publication from request data
      $pub=Publication::create([
          'title' => $request->title,
          'description' => $request->description,
          'user' => Auth::id(),
      ]);

      $pub->url = str_replace(' ', '', $user->name.'/'.$pub->id);
      $pub->save();

      // create collaborations from request data
      $input = $request->toArray();
      foreach ($input as $key => $value) {
        if(substr($key,0,6) === 'collab'){
          $collaboration=Collaboration::create([
              'role' => $value,
              'collaborator' => Collaborator::where('profile',substr($key,6))->first()->id,
              'publication' => $pub->id,
          ]);
        }
      }

      // redirection to publications list
      return redirect()->route('publication.list');
    }

    ///////////////////////////////////////////////////////////////////////////
    // Goto update existing publication page controller
    public function modification(Request $request, $pub){

      $user = User::where('id',Auth::id())->first();
      $publication = Publication::where('id',$pub)->first();
      if(is_null($publication)) return redirect()->route('access_denied');
      if ($publication->user != $user->id) return redirect()->route('access_denied');

      $query = DB::select(DB::raw("
        select * from users u
        where u.type=\"profile\"
        and exists (
            select * from collaborations c,collaborators cl
            where c.collaborator=cl.id
            and cl.profile=u.id
            and c.publication=\"".$pub."\"
          )
      "));

      foreach ($query as $collab) {
        $collab->role=(DB::select("
          select role from collaborations c, collaborators cl, users p
          where c.collaborator=cl.id
          and cl.profile=p.id
          and p.id=\"".$collab->id."\"
          and publication=\"".$pub."\"
        "))['0']->role;
      }

      $data= [
        'title' => 'Edit Publication',
        'collaborators' => $query,
        'publication' => Publication::where('id',$pub)->first(),
        'create' => false,
      ];
      return view('publications/pubForm',$data);

    }

    ///////////////////////////////////////////////////////////////////////////
    // update an existing publication controller
    public function update(PublicationRequest $request, $pub){

      // check for user admin and its possession of publication
      $user = User::where('id',Auth::id())->first();
      $publication = Publication::where('id',$pub)->first();
      if(is_null($publication->id)) return redirect()->route('error1');
      if($publication->user != $user->id) return redirect()->route('access_denied');
      if($user->type != 'admin') return redirect()->route('access_denied');

      // update title & desc
      $publication->title=$request->title;
      $publication->description=$request->description;
      $publication->save();

      // update role for collaborators
      $input = $request->toArray();
      foreach ($input as $key => $value) {
        if(substr($key,0,6) === 'collab'){
          $collab=Collaborator::where('profile',substr($key,6))->first();
          $collaboration=Collaboration::where('collaborator',$collab->id)
                                     ->where('publication',$pub)->first();
          ;
          $collaboration->role=$value;
          $collaboration->save();
        }
      }

      // return back to publication edit
      return redirect()->route('publication.update',['pub'=>$publication->id]);
    }

    ///////////////////////////////////////////////////////////////////////////
    // Manage publication page controller
    public function manage(Request $request, $pub){

      $publication=Publication::where('id',$pub)->first();

      $contents=DB::select("
          select * from contents
          where publication=".$pub."
      ");

      foreach($contents as $content) {
          $content->publication=$publication->title;
          $content->owner=User::where('id',$publication->user)->first()->name;
          $content->creator=User::where('id',$content->creator)->first()->name;
      }

      $data = [
        'publication'=>$pub,
        'contents'=>$contents,
        'selected'=>$publication->selected,
        'rows'=>$publication->rows,
        'scroll'=>$publication->scroll,
      ];

      return view('publications/partition',$data);

    }

    ///////////////////////////////////////////////////////////////////////////
    // view publication controller
    public function view(Request $request, $pub){

      $publication=Publication::where('id',$pub)->first();
      $contents=DB::select("select * from contents where publication=".$pub);
      $menu=Menu::where('admin_id',$publication->user)->first();
      $links=Link::where('menu_id',$menu->id)->get();

      $rows=0;
      foreach($contents as $content) {
        $offset=$content->top+$content->height;
        if($offset>$rows) $rows=$offset;
      }
      $data = [
        'rows' => $rows,
        'publication' => $publication,
        'contents' => $contents,
        'links' => $links,
        'menu' => $menu,
      ];

      return view('publications/view',$data);

    }

    ///////////////////////////////////////////////////////////////////////////
    // delete publication controller
    public function delete(Request $request, $pub){

      // check for user admin and its possession of publication
      $user = User::where('id',Auth::id())->first();
      $publication = Publication::where('id',$pub)->first();
      if(is_null($publication->id)) return redirect()->route('error1');
      if($publication->user != $user->id) return redirect()->route('access_denied');
      if($user->type != 'admin') return redirect()->route('access_denied');

      // delete the publication
      $publication->delete();

      // redirect to publications list
      return redirect()->route('publication.list');
    }

}
