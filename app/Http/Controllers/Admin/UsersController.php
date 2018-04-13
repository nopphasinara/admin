<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use App\Http\Requests\Admin\User\IndexUser;
use App\Http\Requests\Admin\User\StoreUser;
use App\Http\Requests\Admin\User\UpdateUser;
use App\Http\Requests\Admin\User\DestroyUser;
use Brackets\AdminListing\Facades\AdminListing;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Brackets\AdminAuth\Services\ActivationService;
use Brackets\AdminAuth\Facades\Activation;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  IndexUser $request
     * @return Response|array
     */
    public function index(IndexUser $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(User::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'email', 'first_name', 'last_name', 'activated', 'forbidden', 'language'],

            // set columns to searchIn
            ['id', 'email', 'first_name', 'last_name', 'language']
        );

        if ($request->ajax()) {
            return ['data' => $data, 'activation' => Config::get('admin-auth.activations.enabled')];
        }

        return view('admin.user.index', ['data' => $data, 'activation' => Config::get('admin-auth.activations.enabled')]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('admin.user.create');

        return view('admin.user.create',[
            'activation' => Config::get('admin-auth.activations.enabled'),
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUser $request
     * @return Response|array
     */
    public function store(StoreUser $request)
    {
        // Sanitize input
        $sanitized = $request->getModifiedData();

        // Store the User
        $user = User::create($sanitized);

        // But we do have a roles, so we need to attach the roles to the user
        $user->roles()->sync(collect($request->input('roles', []))->map->id->toArray());

        if ($request->ajax()) {
            return ['redirect' => url('admin/users'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return Response
     */
    public function show(User $user)
    {
        $this->authorize('admin.user.show', $user);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return Response
     */
    public function edit(User $user)
    {
        $this->authorize('admin.user.edit', $user);

        $user->load('roles');

        return view('admin.user.edit', [
            'user' => $user,
            'activation' => Config::get('admin-auth.activations.enabled'),
            'roles' => Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUser $request
     * @param  User $user
     * @return Response|array
     */
    public function update(UpdateUser $request, User $user)
    {
        // Sanitize input
        $sanitized = $request->getModifiedData();

        // Update changed values User
        $user->update($sanitized);

        // But we do have a roles, so we need to attach the roles to the user
        if($request->input('roles')) {
            $user->roles()->sync(collect($request->input('roles', []))->map->id->toArray());
        }

        if ($request->ajax()) {
            return ['redirect' => url('admin/users'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DestroyUser $request
     * @param  User $user
     * @return Response|bool
     */
    public function destroy(DestroyUser $request, User $user)
    {
        $user->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
    * Resend activation e-mail
    *
    * @param    \Illuminate\Http\Request  $request
    * @param    User $user
    * @return  array|\Illuminate\Http\Response
    */
    public function resendActivationEmail(Request $request, ActivationService $activationService, User $user)
    {
        if(Config::get('admin-auth.activations.enabled')) {

            $response = $activationService->handle($user);
            if($response == Activation::ACTIVATION_LINK_SENT) {
                if ($request->ajax()) {
                    return ['message' => trans('brackets/admin-ui::admin.operation.succeeded')];
                }

                return redirect()->back();
            } else {
                if ($request->ajax()) {
                    return ['message' => trans('brackets/admin-ui::admin.operation.failed')];
                }

                return redirect()->back();
            }
        } else {
            if ($request->ajax()) {
                return ['message' => trans('brackets/admin-ui::admin.operation.not_allowed')];
            }

            return redirect()->back();
        }
    }
    
}
