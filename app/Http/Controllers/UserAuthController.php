<?PHP
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use Socialite;
use Auth;

class UserAuthController extends Controller
{
    public function SignInProcess($provider=null)
    {
        if(!config("services.$provider")) abort('404'); //處理不存在的服務應用程式
        return Socialite::driver($provider)->redirect();
    }

    public function SignInCallbackProcess($provider=null)
    {
        if(request()->error=="access_denied")
        {
            throw new Exception('授權失敗，存取錯誤');
        }
        //依照網域產出重新導向連結 (來驗證是否為發出時同一callback)
        if ($provider == 'facebook') {
            $redirect_url = env('FB_REDIRECT');
        }
        if ($provider == 'google') {
            $redirect_url = env('GOOGLE_CALLBACK_URL');
        }
        //取得第三方使用者資料
        $user = Socialite::driver($provider)
            ->redirectUrl($redirect_url)->user();

        if(is_null($user->email))
        {
            throw new Exception('未授權取得使用者 Email');
        }
        //取得資料
        $chkUser = User::where('email', $user->email)->first();
        if (empty($chkUser)) {
            $chkUser = User::create([
                'is_facebook' => ($provider == 'facebook')?1:0,
                'is_google'   => ($provider == 'google')?1:0,
                'name'        => $user->name,
                'email'       => $user->email,
                'password'    => bcrypt('test123456'),
            ]);
        }
        Auth::login($chkUser);
        return redirect()->route('home');
    }
}
?>