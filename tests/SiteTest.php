<?php


use PHPUnit\Framework\TestCase;
use Controller\Site;
use Src\Request;
use Model\User;

class SiteTest extends TestCase
{
    /* -------------------------------------------------
     *  ТЕСТЫ РЕГИСТРАЦИИ
     * -------------------------------------------------*/

    /**
     * @dataProvider signupProvider
     * @runInSeparateProcess
     */
    public function testSignup($httpMethod, $userData, $expect)
    {
        if ($userData['login'] === 'login_is_busy') {
            $existingUser = User::first();
            $userData['login'] = $existingUser ? $existingUser->login : 'dummy';
        }

        $request = $this->createMock(Request::class);
        $request->method = $httpMethod;
        $request->method('all')->willReturn($userData);

        $site = new Site();
        $result = $site->signup($request);

        if (!empty($result)) {
            $this->expectOutputRegex('/' . preg_quote($expect, '/') . '/');
            return;
        }

        $this->assertTrue((bool)User::where('login', $userData['login'])->count());

        User::where('login', $userData['login'])->delete();
    }

    public static function signupProvider(): array
    {
        return [
            ['GET',  ['login'=>'', 'email'=>'', 'password'=>''], '<h3></h3>'],

            ['POST', ['login'=>'', 'email'=>'', 'password'=>''],
                '<h3>{"login":["Поле login пусто"],"email":["Поле email пусто"],"password":["Поле password пусто"]}</h3>'
            ],

            ['POST', ['login'=>'login_is_busy','email'=>'test@test.com','password'=>'adminA1'],
                '<h3>{"login":["Поле login должно быть уникально"]}</h3>'
            ],

            ['POST', ['login'=>md5(time()), 'email'=>'test@test.com','password'=>'adminA1'],
                'Location: /hello'
            ],
        ];
    }

    /* -------------------------------------------------
     *  ТЕСТЫ АВТОРИЗАЦИИ
     * -------------------------------------------------*/

    /**
     * @dataProvider loginProvider
     * @runInSeparateProcess
     */
    public function testLogin($httpMethod, $credentials, $expect)
    {
        $user = User::first() ?: User::create([
            'login'    => 'root11',
            'email'    => 'root11@test.com',
            'password' => password_hash('root', PASSWORD_BCRYPT)
        ]);

        if ($credentials['login'] === 'valid') {
            $credentials['login']    = $user->login;
            $credentials['password'] = 'root';
        }

        $request = $this->createMock(Request::class);
        $request->method = $httpMethod;
        $request->method('all')->willReturn($credentials);

        $site = new Site();
        $result = $site->login($request);

        if (!empty($result)) {
            $this->expectOutputRegex('/' . preg_quote($expect, '/') . '/');
            return;
        }

        $this->assertContains($expect, xdebug_get_headers());
    }

    public static function loginProvider(): array
    {
        return [
            ['GET',  ['login'=>'', 'password'=>''], '<h3></h3>'],

            ['POST', ['login'=>'wrong', 'password'=>'x'],
                '<h3>{"login":["Неверный логин или пароль"]}</h3>'
            ],

            ['POST', ['login'=>'valid', 'password'=>'root'], 'Location: /']
        ];
    }
}
