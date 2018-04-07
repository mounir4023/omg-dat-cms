<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Mail\UserMessageCreated;
use App\Models\Publication;
use App\User;
use App\Models\Collaboration;
use App\Models\Content;


////////////////////////////////////////////////////////////////////////////////
////////////////////////// Dashboard Page /////////////////////////////

Route::get('/', function () {
  if(Auth::check())
  {
    return redirect()->route('dashboard');
  }
  return redirect()->route('login_admin');
})->name('password.request');

Route::get('/dashboard',function(){
  if(Auth::check()) return view('home');
  return redirect('login');
})->name('dashboard');


////////////////////////////////////////////////////////////////////////////////
////////////////////////// Publications Pages /////////////////////////////

////////////////////////// Publications list
Route::get('/publications', function () {

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
})->name('publication.list');

////////////////////////// GOTO Create Publication Page
Route::get('publications/new', function () {

  $user = User::where('id',Auth::id())->first();

  if($user->type != 'admin'){
    dd('you can\'t');
  }

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
});

////////////////////////// GETFROM Create Publication Page
Route::post('/publications/new',[
  'as' => 'publication.create',
  'uses' => 'PublicationController@create'
]);

////////////////////////// GOTO Update Publication Page
Route::get('/publications/{pub}', function ($pub) {

  $user = User::where('id',Auth::id())->first();
  $publication = Publication::where('id',$pub)->first();
  if(is_null($publication)) dd('what is dat');
  if ($publication->user != $user->id) dd('not yours');

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
});

////////////////////////// GETFROM Update Publication Page
Route::post('/publications/{pub}',[
  'as' => 'publication.update',
  'uses' => 'PublicationController@update'
]);

////////////////////////// Publication Delete Request
Route::post('/publications/delete/{pub}',[
  'as' => 'publication.delete',
  'uses' => 'PublicationController@delete'
]);

////////////////////////// Goto Partitionning Page
Route::get('/publications/manage/{pub}', function ($pub) {
  $contents=DB::select("
      select * from contents
      where publication=".$pub."
  ");

  $publication=Publication::where('id',$pub)->first();

  $data = [
    'publication'=>$pub,
    'contents'=>$contents,
    'selected'=>$publication->selected,
    'rows'=>$publication->rows,
    'scroll'=>$publication->scroll,
  ];
  return view('publications/partition',$data);
})->name('publication.manage');

////////////////////////// AJAX Content Position
Route::post('/ajax',[
  'as' => 'content.ajax',
  'uses' => 'ContentController@ajax'
]);


////////////////////////////////////////////////////////////////////////////////
////////////////////////// Contents Pages /////////////////////////////

////////////////////////// POST Create Content
Route::post('/contents/create/{pub}',[
  'as' => 'content.create',
  'uses' => 'ContentController@create'
]);

////////////////////////// POST Update Content
Route::post('/contents/update/{cnt}',[
  'as' => 'content.update',
  'uses' => 'ContentController@update'
]);

////////////////////////// POST Delete Content
Route::post('/contents/delete',[
  'as' => 'content.delete',
  'uses' => 'ContentController@delete'
]);

////////////////////////// Text Content list per user
Route::get('/contents/text', function () {

  $user = User::where('id',Auth::id())->first();
  if($user->type == 'admin')
  $contents=DB::select("
      select c.* from contents c , publications p
      where c.publication=p.id
      and p.user=".Auth::id()."
      and c.type=\"text\"
  ");
  else {
  $contents=DB::select("
      select c.* from contents c,publication p
      where c.publication=p.id
      and c.type=\"text\"
      and exists (
          select * from collaborations cb, collaborators cl
          where cb.publication=p.id
          and cl.profile=".$user->id."
          and ( cb.role=\"editor\" or cb.role=\"publicator\" )
      )
  ");
  }

  // adding publication title
  foreach($contents as $content) {
    $content->publication=DB::select("
        select title from publications
        where id=".$content->publication."
    ")[0]->title;
  }
  // adding creator name
  foreach($contents as $content) {
    $content->creator=DB::select("
        select u.name from collaborators cl,users u
        where cl.profile=u.id
        and cl.id=".$content->creator."
    ")[0]->name;
  }

  $data= [
    'title' => 'Contents',
    'contents' => $contents,
    'type' =>"text",
  ];
  return view('contents/cntList',$data);
})->name('content.list');

////////////////////////// GOTO Content fill page
Route::get('/contents/{type}/{cnt}', function ($type, $cnt) {
  $data= [
    'title' => 'Text Contents',
    'type' => $type,
  ];
  return view('contents/text',$data);
})->name('content.fill');

////////////////////////// GOTO Static files management
Route::get('/files', function () {
  $data = [
      'title' => 'files',
        ];
  return view('contents/files',$data);
})->name('content.manage');

////////////////////////////////////////////////////////////////////////////////
////////////////////////// Users Pages /////////////////////////////

///////////////////////// Collaborators List
Route::get('/collaborators', function () {
    $data = [
        'title' => 'collaborators',
          ];
  return view('collaborators/clbList',$data);
});

///////////////////////// GOTO User Profile
Route::get('/profile', function () {
  $data = [
      'title' => 'profiles',
        ];
  return view('auth/profile',$data);
});

///////////////////////// GETFROM User Profile
Route::post('/profile',[
    'as' => 'update_profile',
    'uses' => 'ProfileUpdaterController@update'
]);

///////////////////////// GOTO ADMIN LOGIN PAGE
Route::get('/login',function () {
    $data=[
      'collab' => false,
    ];
    return view('auth/login',$data);
  })->name('login_admin');

///////////////////////// GOTO COLLAB LOGIN PAGE
Route::get('/collaborators/login',function () {
    $data=[
      'collab' => true,
    ];
    return view('auth/login',$data);
  })->name('login_collab');

///////////////////////// GETFROM ADMIN LOGIN PAGE
Route::post('/login',[
  'as' =>'login',
  'uses'=>'LoginController@check',
  ]);

///////////////////////// GETFROM COLLAB LOGIN PAGE
Route::post('/collaborators/login',[
  'as' =>'collabLogin',
  'uses'=>'LoginController@check',
]);

///////////////////////// GOTO COLLAB CREATE PAGE

Route::get('/collaborators/register', function () {
  $data=[
    'collab' => true,
  ];
  return view('auth/register',$data);
})->name('collab.register.get');

///////////////////////// GETFROM COLLAB CREATE PAGE
Route::post('/collaborators/register', [
  'as' => 'collab.register.create',
  'uses' => 'RegistrationController@collab_store'
]);

///////////////////////// ADMIN REGISTER WITH MAIL CONFIRMATION
Route::get('/register', function () {
  $data=[
    'collab' => false,
  ];
  return view('auth/register',$data);
})->name('register.get');

Route::post('/register', [
  'as' => 'register.create',
  'uses' => 'RegistrationController@store'
]);

Route::get('/mail-register',function(){
  $data=[
    'error_name' => '=\'D',
    'error_msg' => 'Thank you for your registration, Manage your content with easiness !!!'
  ];
  return view('alerts/msg',$data);
})->name('email');

Route::post('/mail-register',[
  'as' => 'mail.confirm',
  'uses' => 'RegistrationController@confirmation'
]);

Route::get('/user/confirmation/{token}','RegistrationController@confirmation')->name('confirmation');



////////////////////////////////////////////////////////////////////////////////
////////////////////////// Errors Pages /////////////////////////////


Route::get('/error1',function(){
  $data=[
    'error_name' => 'Login error',
    'error_msg' => 'Your account is not validated, please check your email for confirmation'
  ];

  return view('alerts/msg',$data);
})->name('not_validated_error');

Route::get('/error2',function(){
  $data=[
    'error_name' => 'Login error',
    'error_msg' => 'You entered a wrong password'
  ];
  return view('alerts/msg',$data);
})->name('credentials_error');

Route::get('/error3',function(){
  $data=[
    'error_name' => 'Login error',
    'error_msg' => 'This account doesn\'t exist'
  ];
  return view('alerts/msg',$data);
})->name('not_exists_error');
