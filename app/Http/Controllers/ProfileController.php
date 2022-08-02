<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Gender;
use App\Models\Payment;
use App\Models\User;
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
            $genders = Gender::all();
            $roles = Role::all();
            $subscriptions = Subscription::all();
            return view('profile.create')->with([
                'genders' => $genders,
                'roles' => $roles,
                'subscriptions' => $subscriptions
            ]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al mostrar el formulario de creacion de usuario');
        }
    }

    public function show($profile_id)
    {
        try{
            $user = User::findOrFail($profile_id);
            $userSubscriptions = UserSubscription::where('user_id', $profile_id)
                ->orderBy('user_subscription_status_id','asc')
                ->get();

            $userPayments = Payment::whereHas('userSubscription', function($query) use ($profile_id){
                $query->where('user_id', $profile_id);
            })
            ->with(['userSubscription', 'userSubscription.subscription', 'paymentStatus'])
            ->get();

            return view('profile.show')->with([
                'user' => $user,
                'userSubscriptions' => $userSubscriptions,
                'userPayments' => $userPayments,
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
            $ages = 0;
            $usersWithoutBirthday = 0;
            
            foreach ($users as $user) {
                if($user->getAge() != 0){
                    $ages += $user->getAge();
                }
                else{
                    $usersWithoutBirthday++;
                }     
            }

            $menUsers = $users->filter(function($user){
                return $user->gender->id === Gender::MAN;
            })->count();

            return view('profile.index',)->with([
                'users' => $users, 
                'menUsers' => $menUsers,
                'averageAges' => (floor($ages/($users->count() - $usersWithoutBirthday))),
                'subscriptions' => $subscriptions,
                'totalUsersWithActiveSubscription' => User::has('lastSubscription')->count(),
            ]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al mostrar los usuarios');            
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $profile_id){
        try{
            
            $user = User::findOrFail($profile_id);
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->gender_id = Gender::findOrFail($request->gender_id)->id;
            $user->email = $request->email;
            $user->start_date = $request->start_date;
            $user->primary_phone = $request->primary_phone;

            if($request->social_work != NULL)
                $user->social_work = $request->social_work; 
            else
                $user->social_work = "No definida";            

            $user->secondary_phone = $request->secondary_phone;
            $user->address = $request->address;
            $user->birthday = $request->birthday;
            $user->personal_information = $request->personal_information;
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
                $user_subscription->user_subscription_status_id = UserSubscriptionStatus::where('name',UserSubscriptionStatus::ACTIVE)->first()->id;
                $user_subscription->save();
            }          
            
            return redirect()->route('profile.index')->withSuccess('Se guardaron los cambios con exito');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al actualizar al usuario');     
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        try{
            $user = new User();
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->gender_id = Gender::findOrFail($request->gender_id)->id;
            $user->email = $request->email;
            $user->primary_phone = $request->primary_phone;
            $user->start_date = $request->start_date;
            $user->password = 'password';
            $user->role_id = Role::USER;

            if($request->social_work != NULL)
                $user->social_work = $request->social_work;
            else
                $user->social_work = "No definida";            
                   
            if($request->secondary_phone != NULL){
                $user->secondary_phone = $request->secondary_phone;
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
            
            return redirect()->route('profile.index')->withSuccess('Se guardaron con exito los cambios');
        }
        catch (Exception $e){
            return redirect()->back()->withErrors('Error al guardar al usuario');
        }      
       
    }

    public function edit($profile_id)
    {
        try{
            $userSubscriptions = null;
            $user = User::findOrFail($profile_id);
            $genders = Gender::all();
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
                  
            return redirect()->route('profile.index')->withSuccess('Se guardo el nuevo plan');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al guardar el nuevo plan del usuario');   
        }
    }

    public function usersWhoLeft()
    {
        try{
            $users = User::has('lastAssistances')
                ->with('lastAssistances', 'lastSubscription')
                ->get(); 
            
            $usersLeft = $users
                ->filter(function($user){
                    return $user->lastAssistances->first()->date->diffInDays(now()) > 31;
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

            return redirect()->route('profile.changeSubscription')->withSuccess('Se guardaron los cambios del plan');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al guardar el cambio de plan');
        }
    }


    public function changeSubscription($profile_id = null)
    {
        try{
            $userSelected = null;
            $userSubscription = null;

            if($profile_id != null){
                $userSelected = User::findOrFail($profile_id);
                $userSubscription = $userSelected->lastSubscription()->get();
                if ($userSubscription->isEmpty()){
                    $userSubscription = 'sinSubscripcion';
                }
                else{
                    $userSubscription = $userSelected->lastSubscription()->first();
                }
            }
            else{
                if(isset($_GET['user']) && $_GET['user'] != 'withoutUser'){
                    $userSelected = User::findOrFail($_GET['user']);
                    if($userSelected->lastSubscription()->get()->isNotEmpty()){
                        $userSubscription = $userSelected->lastSubscription()->first();
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
