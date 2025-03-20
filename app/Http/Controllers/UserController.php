<?php

namespace App\Http\Controllers;

use App\Criteria\UserCriteriaCriteria;
use App\Exceptions\UserException;
use App\Models\Product;
use App\Models\User;
use App\Repositories\UserRepositoryRepositoryEloquent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $UserRepository;

    public function __construct(UserRepositoryRepositoryEloquent $userRepository )
    {
        $this->UserRepository = $userRepository;

    }
    public function search(request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');

        // Áp dụng UserCriteria
        $this->UserRepository->pushCriteria(UserCriteriaCriteria::class);
        $users = $this->UserRepository->getByCriteria(new UserCriteriaCriteria());
        if(sizeof($users)==0){
            throw new UserException('User Not Found');
        }

        return response()->json($users);

    }
    // ✅ 1️⃣ Lấy danh sách tất cả users
    public function index()
    {
        $users = $this->UserRepository->skipCriteria()->all();


        return response()->json(
            [
            "user"=>User::with(['Product','roles','Image'])->get(),
                "users"=>$users
        ], Response::HTTP_OK);
    }

    // ✅ 2️⃣ Tạo user mới
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);
            $user=new User();

            $user->name=$validated['name'];
            $user->email=$validated['email'];
            $user->password=$validated['password'];
            $user->save();
            $users = User::with(['Product'])->find($user->id);
            $user->roles()->attach([1,2,3]);
            $user->save();

            $product1 = new Product(['name' => 'MacBook Pro', 'brand' => 'ca']);
            $product2 = new Product(['name' => 'Samsung Galaxy', 'brand' => 'ca']);

            $users->Product()->saveMany([$product1, $product2]);

            return response()->json($user, Response::HTTP_CREATED);
        }catch (\Exception $exception){
            return response()->json([
                'error' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine()
            ], 500);
        }
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], Response::HTTP_OK);
    }

    // ✅ 3️⃣ Lấy thông tin 1 user theo ID
    public function show($id)
    {
        try {
            $user = User::with(['Product','roles','Image'])->find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ], Response::HTTP_NOT_FOUND);
            }
//            $user->name="ngu";
//            $user->roles()->detach(2);
//            $user->save();

            return response()->json([
                'user'=>$user,
                'check'=>"ss"
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    // ✅ 4️⃣ Cập nhật user
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:6',
        ]);

        $user->update([
            'name' => $validated['name'] ?? $user->name,
            'email' => $validated['email'] ?? $user->email,
            'password' => isset($validated['password']) ? Hash::make($validated['password']) : $user->password,
        ]);

        return response()->json($user, Response::HTTP_OK);
    }

    // ✅ 5️⃣ Xóa user
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], Response::HTTP_OK);
    }
}
