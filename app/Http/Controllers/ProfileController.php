<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SocialWork;
use App\Models\UserSubscription;
use App\Models\Role;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $social_works = SocialWork::all();
        $roles = Role::all();
        $subscriptions = Subscription::all();
        return view('profile.create')->with('social_works', $social_works)->with('roles', $roles)->with('subscriptions', $subscriptions);
    }

    public function index($id)
    {
        $user = User::findOrFail($id);
        $age = $this->getAge($user);
        $subscription = $user->subscriptions()->first()->name;
        $user_subscription = UserSubscription::where('user_id', $id)->first();
        $subscriptionAdded = Subscription::findOrFail($user_subscription->subscription_id);
        return view('profile.profile')->with('user', $user)->with('age', $age)->with('subscription', $subscription)->with('my_subscription', $subscriptionAdded);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|nullable|string|max:255',
            //'email'         => 'required|string|email|max:255', ARREGLAR
            //                Rule::unique('users')->ignore(Auth::user()->id),
            //'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id, //. Auth::user()->email,
            //'current_password' => 'nullable|required_with:new_password',
            //'new_password' => 'nullable|min:8|max:12|required_with:current_password',
            //'password_confirmation' => 'nullable|min:8|max:12|required_with:new_password|same:new_password',
            'primary_phone' => 'required|string|min:10'
        ]);

        //Actualizo la userSubscription
        $user_subscription = UserSubscription::findOrFail($id);
        $user_subscription->subscription_id = $request->subscriptionIdSelected;
        $user_subscription->save();
        //

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->primary_phone = $request->primary_phone;
        
        if($request->secundary_phone != NULL){
            $user->secundary_phone = $request->secundary_phone;
        }

        if($request->address != NULL){
            $user->address = $request->address;
        }

        if($request->birthday != NULL){
            $user->birthday = $request->birthday;
        }

        if($request->start_date != NULL){
            $user->start_date = $request->start_date;
        }

        if($request->personal_information != NULL){
            $user->personal_information = $request->personal_information;
        }

        if($request->social_work_id != $user->social_work_id){
            $user->social_work_id = $request->social_work_id;
        }
        
        if($request->role_id != $user->role_id){
            $user->role_id = $request->role_id;
        }
    
        /*if ($request->input('new_password') != NULL) {

            if (Hash::check($request->input('current_password'), $user->password)) {
                if($request->new_password != NULL  && $request->new_password === $request->password_confirmation){
                    $user->password = $request->input('new_password');
                }
            } else {
                return redirect()->back()->withInput();
            }
        }*/

        if ($request->input('new_password') != NULL) { //VER ESTO DE LAS CONTRASEÑAS
            if ($request->input('new_password') === $request->input('password_confirmation')) {
                    bcrypt($request->password_confirmation);
                    $user->password = $request->password_confirmation;
            } else {
                return redirect()->back()->withError('Las contraseñas no coinciden');
            }
        }

        $user->save();

        return redirect()->route('home')->withSuccess('Se guardaron con exito los cambios.');
    }

    public function edit($id){
        $user = User::findOrFail($id);
        $social_works = SocialWork::all();
        $roles = Role::all();
        $age = $this->getAge($user);
        $subscriptions = Subscription::all();
        $user_subscription = UserSubscription::where('user_id', $id)->latest()->first();//Me traigo el ultimo userSubscription
        $subscriptionAdded = Subscription::findOrFail($user_subscription->subscription_id);
        return view('profile.edit')->with('user', $user)->with('social_works', $social_works)->with('roles', $roles)->with('age', $age)->with('subscriptions', $subscriptions)->with('my_subscription', $subscriptionAdded);
    }

    public function getAge($user){
        $hoy = now();
        $edad = $hoy->diff($user->birthday->format('Y-m-d'));
        return $edad;
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('home')->with('success', 'Se elimino con éxito');
    }

    public function store(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->primary_phone = $request->primary_phone;
       
        //if($user->secundary_phone != NULL){
            $user->secundary_phone = $request->secundary_phone;
        //}

        //if($user->secundary_phone != NULL){
            $user->address = $request->address;
        //}
        $user->birthday = $request->birthday;
        $user->start_date = $request->start_date;
        $user->personal_information = $request->personal_information;
        $user->social_work_id = $request->social_work_id;
        $user->password = $request->password;
        $user->role_id = $request->role_id;

        $user->save();

        //Creo la user subscription asociada
        $user_subscription = new UserSubscription();
        $user_subscription->user_id = $user->id;
        $user_subscription->subscription_id = $request->subscription;
        $user_subscription->start_date = now();
        $user_subscription->save();
        //
        
        return redirect('home')->with('success','Se creo con exito el nuevo usuario');
    }


}
