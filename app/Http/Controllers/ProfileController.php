<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\User;
use App\Models\SocialWork;
use App\Models\UserSubscription;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\UserSubscriptionStatus;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        try{
            $social_works = SocialWork::all();
            $genders = Gender::all();
            $roles = Role::all();
            $subscriptions = Subscription::all();
            return view('profile.create')->with([
                'social_works' => $social_works,
                'genders' => $genders,
                'roles' => $roles,
                'subscriptions' => $subscriptions
            ]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al mostrar el formulario de creacion de usuario');
        }
    }

    public function show($id)
    {
        try{
            $userSubscriptions = UserSubscription::with('user')->where('user_id', $id)->get(); //check null?
            $user = $userSubscriptions->first()->user; //recupero el usuario
            
            return view('profile.profile')->with([
                'user' => $user,
                'userSubscriptions' => $userSubscriptions,
            ]);
        }
        catch (Exception $e){
            return redirect()->back()->withErrors('Error al mostrar el usuario');            
        }
    }

    public function index()
    {
        try{
            $subscriptions = Subscription::all();
            $users = User::latest()->get();
            $monthlyRevenue = 0;
            $usersWithoutSubscription = 0;
            $ages = 0;
            $usersWithoutBirthday = 0;
            foreach ($users as $user) {
                if($this->getAge($user) != 0){
                    $ages += $this->getAge($user); 
                }
                else{
                    $usersWithoutBirthday++;
                }

                if($user->subscriptions()->latest()->first() != null){
                    $monthlyRevenue = $monthlyRevenue + $user->subscriptions()->latest()->first()->month_price;  
                }  
                else{
                    $usersWithoutSubscription++;
                }        
            }

            $menUsers = $users->filter(function($user){
                return $user->gender->id === 1;
            })->count();

            return view('profile.index',)->with([
                'users' => $users, 
                'menUsers' => $menUsers,
                'monthlyRevenue' => $monthlyRevenue, 
                'usersWithoutSubscription' => $usersWithoutSubscription,
                'averageAges' => (floor($ages/($users->count() - $usersWithoutBirthday))),
                'subscriptions' => $subscriptions,
            ]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al mostrar los usuarios');            
        }
    }

    public function update(request $request, $profile_id){
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|nullable|string|max:255',
                'primary_phone' => 'required|string|min:9',
                // 'gender_id' => 'required',
            ]);

            $user = User::findOrFail($profile_id);
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->gender_id = Gender::findOrFail($request->gender_id)->id;
            $user->email = $request->email;
            $user->start_date = $request->start_date;
            $user->primary_phone = $request->primary_phone;
            $user->social_work_id = $request->social_work_id; 
            
            if($request->secundary_phone != null){
                $user->secundary_phone = $request->secundary_phone;
            }
            if($request->address != null){
                $user->address = $request->address;
            }
            if($request->birthday != null){
                $user->birthday = $request->birthday;
            }
            if($request->personal_information != null){
                $user->personal_information = $request->personal_information;
            }

            $user->save();        
     
            if(UserSubscription::where('user_id', $profile_id)->latest()->get()->isNotEmpty()){
                $user_subscriptionOld = UserSubscription::where('user_id', $profile_id)->latest()->first();
                $user_subscriptionOld->user_subscription_status_id = UserSubscriptionStatus::where('name','Inactiva')->first()->id;
                $user_subscriptionOld->user_subscription_status_updated_at = now();
                $user_subscriptionOld->save();
            }

            if($request->subscriptionIdSelected != 'sinSubscripcion'){
                $user_subscription = new UserSubscription();
                $user_subscription->user_id = $profile_id;
                $user_subscription->subscription_id = $request->subscriptionIdSelected;
                $user_subscription->start_date = now();
                $user_subscription->user_subscription_status_updated_at = now();
                $user_subscription->user_subscription_status_id = UserSubscriptionStatus::where('name','Activa')->first()->id;
                $user_subscription->save();
                }
          
            
            return redirect()->route('profile.index')->withSuccess('Se guardaron los cambios con exito');
        }
        catch(Exception $e){
            dd($e->getMessage());
            return redirect()->back()->withErrors('Error al editar el usuario');     
        }
    }

    public function store(Request $request)
    {
        
            $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|nullable|string|max:255',
                'primary_phone' => 'required|string|min:9',
                'gender_id' => 'required',
            ]);

            //dd($request->social_work_id);
            $user = new User();
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->gender_id = Gender::findOrFail($request->gender_id)->id;
            $user->email = $request->email;
            $user->primary_phone = $request->primary_phone;
            $user->start_date = $request->start_date;
            $user->password = 'password';
            $user->role_id = Role::where('name', 'Usuario')->first()->id;
            $user->social_work_id = $request->social_work_id;
                   
            if($request->secundary_phone != NULL){
                $user->secundary_phone = $request->secundary_phone;
            }

            if($request->address != NULL){
                $user->address = $request->address;
            }

            if($request->birthday != NULL){
                $user->birthday = $request->birthday;
            }

            if($request->personal_information != NULL){
                $user->personal_information = $request->personal_information;
            }

          
            $user->save();
            if($request->subscriptionIdSelected != 'sinSubscripcion'){
                $user_subscription = new UserSubscription();
                $user_subscription->user_id = $user->id;
                $user_subscription->subscription_id = $request->subscriptionIdSelected;
                $user_subscription->start_date = now();
                $user_subscription->user_subscription_status_id = 1;
                $user_subscription->user_subscription_status_updated_at = now();
                $user_subscription->save();
            }   
            
            return redirect()->route('profile.index')->withSuccess('Se guardaron con exito los cambios.');
       
       
    }

    public function edit($profile_id)
    {
        try{
            $userSubscriptions = null;
            $user = User::findOrFail($profile_id);
            $genders = Gender::all();
            $socialWorks = SocialWork::all();
            $subscriptions = Subscription::all();
            $activeSubscription = null;

            if(UserSubscription::with('user')->where('user_id', $profile_id)->get()->isNotEmpty()){
                $userSubscriptions = UserSubscription::with('user')->where('user_id', $profile_id)->get();
                $user = $userSubscriptions->first()->user; 
                $activeSubscription = $user->lastSubscription->first->get(); 
            }

            return view('profile.edit')->with([
                'user' => $user,
                'genders' => $genders,
                'userSubscriptions' => $userSubscriptions,
                'activeSubscription' => $activeSubscription,
                'socialWorks' => $socialWorks,
                'subscriptions' => $subscriptions,
            ]);
        }
        catch (Exception $e){
            return redirect()->back()->withErrors('Error al editar el usuario');   
        }         
    }

    public function destroy($profile_id)
    {
        try{
            $user = User::findOrFail($profile_id);
            $user->delete();

            return redirect()->route('profile.index')->withSuccess('Se elimino con éxito al usuario');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al eliminar el usuario');   
        }
    }

    public function getAge($user)
    {
        $hoy = now();
        $edad = 0;
        if($user->birthday != null){
            $edad = $hoy->diff($user->birthday->format('Y-m-d'))->y;
             
        }
        return $edad;
    }

    public function updateSubscription($profile_id)
    {
        try{
            
            if(UserSubscription::where('user_id', $profile_id)->latest()->get()->isNotEmpty()){
                $user_subscriptionOld = UserSubscription::where('user_id', $profile_id)->latest()->first();
                $user_subscriptionOld->user_subscription_status_id = 2;
                $user_subscriptionOld->user_subscription_status_updated_at = now();
                $user_subscriptionOld->save();
            }

            if($_GET['newSubscription_id'] != 'sinSubscripcion'){
                $user_subscription = new UserSubscription();
                $user_subscription->user_id = $profile_id;
                $user_subscription->subscription_id = $_GET['newSubscription_id'];
                $user_subscription->start_date = now();
                $user_subscription->user_subscription_status_updated_at = now();
                $user_subscription->user_subscription_status_id = 1;
                $user_subscription->save();
            }
                  
            return redirect()->route('profile.index')->withSuccess('Se guardo la nueva suscripcion');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al guardar la nueva suscripcion del usuario');   
        }
    }

    public function usersWhoLeft()
    {
        try{
            $users = User::has('lastAssistance')->with('lastAssistance')->get(); 
            
            $usersLeft = $users
                ->filter(function($user){
                    return $user->lastAssistance->first()->date->diffInDays(now()) >= 30;
                });

            return view('profile.usersWhoLeft')->with([
                'usersLeft' => $usersLeft,                
            ]);

        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al mostrar los usuarios que dejaron');
        }

    }

    public function changeSubscriptionStore(Request $request, $profile_id)
    {
        try{   
            if(UserSubscription::where('user_id', $profile_id)->latest()->get()->isNotEmpty()){
                $userSubscriptionOld = UserSubscription::where('user_id', $profile_id)->latest()->first();
                $userSubscriptionOld->user_subscription_status_id = UserSubscriptionStatus::where('name','Inactiva')->first()->id;
                $userSubscriptionOld->user_subscription_status_updated_at = now();
                $userSubscriptionOld->save();
            }  

            if($request->subscriptionIdSelected != 'sinSubscripcion'){
                $userSubscription = new UserSubscription();
                $userSubscription->user_id = $profile_id;
                $userSubscription->subscription_id = $request->subscriptionIdSelected;
                $userSubscription->start_date = now();
                $userSubscription->user_subscription_status_updated_at = now();
                $userSubscription->user_subscription_status_id = UserSubscriptionStatus::where('name','Activa')->first()->id;
                $userSubscription->save();  
            }

            return redirect()->route('profile.changeSubscription')->withSuccess('Se guardaron los cambios de suscripción');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al guardar el cambio de suscripcion');
        }
    }


    public function changeSubscription($profile_id = null)
    {
        try{
            $userSelected = null;
            $userSubscription = null;

            if($profile_id != null){
                $userSelected = User::findOrFail($profile_id);
                $userSubscription = UserSubscription::where('user_id', $userSelected->id)->latest()->first();
            }
            else{
                if(isset($_GET['user']) && $_GET['user'] != 'withoutUser'){
                    $userSelected = User::findOrFail($_GET['user']);
                    if($userSelected->lastSubscription()->get()->isNotEmpty()){
                        $userSubscription = UserSubscription::where('user_id', $userSelected->id)->latest()->first();
                    }
                    else{
                        $userSubscription = 'sinSubscripcion';
                    }
                }
            }

            return view('profile.changeSubscription')->with([
                'subscriptions' => Subscription::all(),
                'users' => User::all(),
                'userSelected' => $userSelected,
                'userSubscription' => $userSubscription,
            ]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al seleccionar usuario');
        }
    }    

}
