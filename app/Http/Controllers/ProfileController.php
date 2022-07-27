<?php

namespace App\Http\Controllers;

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
        $social_works = SocialWork::all();
        $roles = Role::all();
        $subscriptions = Subscription::all();
        return view('profile.create')->with('social_works', $social_works)->with('roles', $roles)->with('subscriptions', $subscriptions);
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
        $subscriptions = Subscription::all();
        $users = User::latest()->get();
        $monthlyRevenue = 0;
        $usersWithoutSubscription = 0;
        $ages = 0;
        $usersWithoutBirthday = 0;
        foreach ($users as $user) {
            if($this->getAge($user) != 0){
                $ages += $this->getAge($user); 
            }else{
                $usersWithoutBirthday++;
            }

            if($user->subscriptions()->latest()->first() != null){
                $monthlyRevenue = $monthlyRevenue + $user->subscriptions()->latest()->first()->month_price;  
            }  
            else{
                $usersWithoutSubscription++;
            }        
        }

        return view('profile.index',)->with([
            'users' => $users, 
            'monthlyRevenue' => $monthlyRevenue, 
            'usersWithoutSubscription' => $usersWithoutSubscription,
            'averageAges' => (floor($ages/($users->count() - $usersWithoutBirthday))),
            'subscriptions' => $subscriptions,
        ]);
    }

    public function updateSubscription($profile_id)
    {
        if(UserSubscription::where('user_id', $profile_id)->latest()->first() != null){
            $user_subscriptionOld = UserSubscription::where('user_id', $profile_id)->latest()->first();
            $user_subscriptionOld->user_subscription_status_id = 2;
            $user_subscriptionOld->user_subscription_status_updated_at = now();
            $user_subscriptionOld->save();

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



    public function update(request $request, $profile_id){
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|nullable|string|max:255',
                'primary_phone' => 'required|string|min:9'
            ]);


            $user = User::findOrFail($profile_id);
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->social_work_id = $request->social_work_id;
            $user->start_date = $request->start_date;
            $user->primary_phone = $request->primary_phone;

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

            if($user->lastSubscription()->first() != null){
                $user_subscriptionOld = UserSubscription::where('user_id', $profile_id)->latest()->first();
                $user_subscriptionOld->user_subscription_status_id = 2;
                $user_subscriptionOld->user_subscription_status_updated_at = now();
                $user_subscriptionOld->save();
            }
            
            $user_subscription = new UserSubscription();
            $user_subscription->user_id = $profile_id;
            $user_subscription->subscription_id = $request->subscriptionIdSelected;
            $user_subscription->start_date = now();
            $user_subscription->user_subscription_status_updated_at = now();
            $user_subscription->user_subscription_status_id = 1;
            $user_subscription->save();
            

            return redirect()->route('profile.index')->withSuccess('Se guardaron los cambios con exito');
        }catch(Exception $e){}
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|nullable|string|max:255',
            'primary_phone' => 'required|string|min:9'
        ]);
    
        $user = new User();
        //Actualizo los atributos del usuario
        $user->name = $request->name;
        $user->last_name = $request->last_name;
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
        //Creo la nueva userSubscription si es que cambio la subscripcion
            $user_subscription = new UserSubscription();
            $user_subscription->user_id = $user->id;
            $user_subscription->subscription_id = $request->subscriptionIdSelected;
            $user_subscription->start_date = now();
            $user_subscription->user_subscription_status_id = 1;
            $user_subscription->user_subscription_status_updated_at = now();
            $user_subscription->save();

        return redirect()->route('profile.index')->withSuccess('Se guardaron con exito los cambios.');
   }

    public function edit($profile_id)
    {
        $user = User::findOrFail($profile_id);
        $social_works = SocialWork::all();
        $roles = Role::all();
        $age = 0;
        if($user->birthday != null){
            $age = $this->getAge($user);
        }
        $subscriptions = Subscription::all();
        $user_subscription = UserSubscription::where('user_id', $profile_id)->latest()->first();//Me traigo el ultimo userSubscription

        if($user_subscription != null){
            $subscriptionAdded = Subscription::findOrFail($user_subscription->subscription_id);
        }else{//Este usuario no tiene una subscripcion
            $subscriptionAdded = null;
        }
        return view('profile.edit')->with('user', $user)->with('social_works', $social_works)->with('roles', $roles)->with('age', $age)->with('subscriptions', $subscriptions)->with('my_subscription', $subscriptionAdded);
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

    public function destroy($profile_id)
    {
        $user = User::findOrFail($profile_id);
        $user->delete();

        return redirect()->route('profile.index')->withSuccess('Se elimino con éxito al usuario');
    }


    public function changeSubscriptionStore(Request $request, $profile_id)
    {
        try{
            $userSubscriptionOld = UserSubscription::where('user_id', $profile_id)->latest()->first();
            $userSubscriptionOld->user_subscription_status_id = UserSubscriptionStatus::where('name','Inactiva')->first()->id;
            $userSubscriptionOld->user_subscription_status_updated_at = now();
            $userSubscriptionOld->save();
            

            $userSubscription = new UserSubscription();
            $userSubscription->user_id = $profile_id;
            $userSubscription->subscription_id = $request->subscriptionIdSelected;
            $userSubscription->start_date = now();
            $userSubscription->user_subscription_status_updated_at = now();
            $userSubscription->user_subscription_status_id = UserSubscriptionStatus::where('name','Activa')->first()->id;
            $userSubscription->save();

            return view('profile.changeSubscription')->with([
                'subscriptions' => Subscription::all(),
                'users' => User::all(),
                'userSelected' => null,
                'userSubscription' => null
            ])->with('success', 'Exito al guardar los cambios de suscripcion');
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
                if(isset($_GET['user'])){
                    $userSelected = User::findOrFail($_GET['user']);
                    $userSubscription = UserSubscription::where('user_id', $userSelected->id)->latest()->first();
                }
            }

            return view('profile.changeSubscription')->with([
                'subscriptions' => Subscription::all(),
                'users' => User::all(),
                'userSelected' => $userSelected,
                'userSubscription' => $userSubscription
            ]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al seleccionar usuario');
        }
    }    


}
