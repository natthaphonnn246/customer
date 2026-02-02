<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LineAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\MessageApiService;


class LineController extends Controller
{
/*     public function loginLine(Request $request)
    {
        $code = $request->user()->user_code;
        $user_name = User::select('name', 'admin_area','user_code')->where('user_code', $code)->first();

        return view('portal/privacy-setting', compact(
            'code',
            'user_name'
        ));
    } */

    public function index()
    {
        $userLine = DB::table('line_accounts_tb')
                                        ->join('users', function (JoinClause $join) {
                                            $join->on('users.line_user_id', '=', 'line_accounts_tb.line_user_id');
                                        })
                                        ->select(
                                            'line_accounts_tb.id',
                                            'users.name',
                                            'line_accounts_tb.ip_address',
                                            'line_accounts_tb.display_name',
                                            'line_accounts_tb.picture_url',
                                            'line_accounts_tb.status_line',
                                            'line_accounts_tb.created_at'
                                            ) // ระบุชัดเจน
                                        ->get();

        // $userLine = DB::table('line_accounts_tb')->get();
        return view('webpanel/line-connect', compact('userLine'));
    }

    public function connectLine(Request $request)
    {
        //ตรวจสอบก่อนว่า login ยัง
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'message' => 'กรุณาล็อกอินก่อนเชื่อมบัญชี LINE'
            ], 401);
        }

        $idToken = $request->input('idToken');

        // ตรวจสอบ token กับ LINE
        $response = Http::asForm()->post(
            'https://api.line.me/oauth2/v2.1/verify',
            [
                'id_token'  => $idToken,
                'client_id' => config('services.line.channel_id'),
            ]
        );
        
        // Log::info('LINE verify response:', ['body' => $response->body()]);

/*         Log::info('LINE VERIFY DEBUG', [
            'id_token_exists' => !empty($idToken),
            'client_id' => config('services.line.channel_id'),
            'status' => $response->status(),
            'body' => $response->body(),
        ]); */
        
        if ($response->failed()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token or verification failed'
            ], 401);

        }

        $ip = $request->ip();
        $user_agent = $request->userAgent();
        $status_line = true;

        //
        $data = $response->json();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update([
            'line_logout_user' => 0,
            'status_line'      => 1,
        ]);

        // prevent LINE duplicated use
        $exists = User::where('line_user_id', $data['sub'])
                    ->where('id', '!=', $user->id)
                    ->exists();
    
        if ($exists) {
            return response()->json(['error' => 'LINE ID ถูกใช้ไปแล้ว'], 409);
        }
    
        // Update users table
        /** @var \App\Models\User $user */
        $user->line_user_id = $data['sub'];
        $user->save();

        $line = LineAccount::updateOrCreate(
            ['line_user_id' => $data['sub']],  
            [ 
                'display_name'      => $data['name'] ?? null,
                'picture_url'       => $data['picture'] ?? null,
                'ip_address'        => $ip,
                'user_agent'        => $user_agent,
                'status_line'       => $status_line,

            ]
        );

        $lineId = $user->line_user_id;

        if($lineId) {

            $message = 'เชื่อมต่อไลน์ผ่านเว็บไซต์สำเร็จ';

            $headers = [
                'Content-Type: application/json',
                "Authorization: Bearer {$this->accessToken}",
            ];
    
            $payload = [
                'to' => $lineId,
                'messages' => [
                    [
                        'type' => 'text',
                        'text' => $message,
                    ],
                ],
            ];
            $result = $this->pushMsg($headers, $payload);

            if (!$result['success']) {
                return response()->json([
                    'token' => '',
                    'status' => false,
                    'message' => 'เชื่อม LINE เรียบร้อย'
                ]);
            }
        }

        $liff_token = $line->createToken('liff_token')->plainTextToken;
        $line->update(['liff_token' => $liff_token]);

        return response()->json([
            'token' => $liff_token,
            'status' => true,
            'message' => 'เชื่อม LINE เรียบร้อย'
        ]);

    }

    //ลูกค้ายกเลิกเชื่อมต่อไลน์
    public function logoutLine(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        // line_account
        $line = LineAccount::where('line_user_id', $user->line_user_id)->first();
        $userCheck = User::where('line_user_id', $user->line_user_id)->first();

        if ($line) {
            $line->update([
                'line_user_id' => null,
                'liff_token'   => null,
                'status_line'  => 1,
            ]);
        }

        // user
        $userCheck->update([
            'line_user_id'       => null,
            'status_line'        => 0,
            'line_logout_user'   => 1,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }
    public function logoutLineNoToken(Request $request)
    {
        $lineUserId = $request->input('line_user_id');

        if (!$lineUserId) {
            return response()->json([
                'status' => 'error',
                'message' => 'line_user_id required'
            ], 400);
        }

        // /** @var \App\Models\User $user */
        $user = User::where('line_user_id', $lineUserId)->first();

        if ($user) {
            $user->update([
                'line_user_id'     => null,
                'status_line'      => 0,
                'line_logout_user' => 1,
            ]);
        }

        $line = LineAccount::where('line_user_id', $lineUserId)->first();

        if ($line) {
            $line->update([
                'line_user_id' => null,
                'liff_token'   => null,
                'status_line'  => 0,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }
    
    //แอดมินลบ Token ทีละลูกค้า
    public function revokeLineToken(Request $request)
    {
        // $user = User::findOrFail($request->id);
    
        $user = User::findOrFail($request->id);
        
        $line = LineAccount::where('line_user_id', $user->line_user_id)->first();
    
        if ($line) {
            $line->update([
                'line_user_id' => null,
                'liff_token'   => null,
                'status_line'  => 0,
            ]);
        }
    
        $user->update([
            'line_user_id' => null,
            'status_line'  => 0,
            'line_logout_admin'  => 1,
        ]);
    
        return redirect()->back()->with('status_line', 'ยกเลิกการเชื่อมต่อ LINE แล้ว');
    }
    //แอดมินลบ Tokens ทั้งหมด
    public function revokeAllLineTokens()
    {
        // ลบ token ของทุก account
        LineAccount::query()->update([
            'line_user_id' => null,
            'liff_token'   => null,
            'status_line'  => 0,
        
        ]);

        User::query()->update([
            'line_user_id' => null,
            'status_line'  => 0,
            'line_logout_admin'  => 1,
        ]);

        return redirect()->back()->with('status_line', 'ยกเลิกการเชื่อมต่อ LINE ทั้งหมด');
    }

    protected $accessToken;
    public function __construct()
    {
        $this->accessToken = env('LINE_CHANNEL_ACCESS_TOKEN'); // จะดึงค่าจาก .env
    }

    public function send($lineId, $message)
    {
        $headers = [
            'Content-Type: application/json',
            "Authorization: Bearer {$this->accessToken}",
        ];

        /* $payload = [
            'to' => $lineId,
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $message,
                ],
            ],
        ]; */

        if (is_string($message)) {
            $payload = [
                'to' => $lineId,
                'messages' => [
                    [
                        'type' => 'text',
                        'text' => $message,
                    ],
                ],
            ];

        } else if (is_array($message) && array_is_list($message)) {
            $payload = [
                'to' => $lineId,
                'messages' => $message
            ];
            
        } else if (is_array($message)) {
            $payload = [
                'to' => $lineId,
                'messages' => [
                    $message
                ],
            ];
        }

        $this->pushMsg($headers, $payload);
       

    }

    /**
     * Send a push message to the LINE Messaging API.
     *
     * @param array $headers
     * @param array $payload
     * @return bool|string Response from LINE API or false on failure
     */
    function pushMsg(array $headers, array $payload)
    {
        $url = 'https://api.line.me/v2/bot/message/push';

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HEADER => false,
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            error_log('LINE pushMsg error: ' . $error);
        }

        /* curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch); */

        // ดึง HTTP status code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        // decode response เป็น array
        // $responseData = json_decode($response, true);
        $responseData = is_string($response) ? json_decode($response, true) : null;

           // return ทั้งสถานะและข้อความ
        return [
            'success' => $httpCode === 200,
            'http_code' => $httpCode,
            'response' => $responseData
        ];

        // return $response;

 
    }

    function example($lineId)
    {
        $lineId = 'xxxxxxxxxxxxxx';
        if (empty($lineId)) {
            return 'Line ID is required.';
        }
        
        $message = 'Hello, this is a test message!';

        $this->send($lineId, $message);
    }

    function sendConnect()
    {

        $guestIdCookie = request()->cookie('guest_id');
        
        $guestIdDb = strlen($guestIdCookie) > 512 ? hash('sha256', $guestIdCookie) : $guestIdCookie;

        $userId = LineAccount::where('line_cookie_id', $guestIdDb)
                                // ->where('liff_token', '!=', '')
                                ->first(['line_user_id'])?->line_user_id;
        // dd($userId);

        $lineId = $userId;
        $message = 'เชื่อมต่อไลน์ผ่านเว็บไซต์สำเร็จ';

        $this->send($lineId, $message);
        // dd($success);
        
        return redirect('/profile/line')->with('successfully', 'ส่งข้อความแจ้งเตือนไปยัง LINE สำเร็จ');

    }

    function sendRewards(Request $request)
    {
        
       /*  $guestId = request()->cookie('guest_id');

        $userId = LineAccount::where('line_cookie_id',  $guestId)->first(['line_user_id'])?->line_user_id; */
        // dd($userId);

        //Line OA : ลงทะเบียนลูกค้าใหม่กับเรา

        if(Auth::check()) {

            $userId = Auth::user()?->line_user_id; 

            if($userId) {

                $flex = [
                    "type" => "flex",
                    "altText" => "เอกสารที่ต้องใช้ในการเปิดโค้ด",
                    "contents" => [
                        "type" => "bubble",
                        "size" => "mega",
                        "header" => [
                            "type" => "box",
                            "layout" => "vertical",
                            "backgroundColor" => "#1DB446",
                            "paddingAll" => "20px",
                            "contents" => [
                                [
                                    "type" => "text",
                                    "text" => "เอกสารที่ใช้เปิดโค้ด",
                                    "weight" => "bold",
                                    "size" => "lg",
                                    "color" => "#FFFFFF"
                                ],
                                [
                                    "type" => "text",
                                    "text" => "กรุณาเตรียมเอกสารและข้อมูลต่อไปนี้",
                                    "size" => "sm",
                                    "color" => "#E0FFE7",
                                    "margin" => "sm"
                                ]
                            ]
                        ],
                        "body" => [
                            "type" => "box",
                            "layout" => "vertical",
                            "spacing" => "md",
                            "contents" => [
                                [
                                    "type" => "text",
                                    "text" => "📄 เอกสารที่ต้องใช้",
                                    "weight" => "bold",
                                    "size" => "md",
                                    "margin" => "md"
                                ],
                                [
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "margin" => "sm",
                                    "spacing" => "sm",
                                    "contents" => [
                                        [ "type" => "text", "text" => "1. ใบอนุญาตขายยา คลินิก สถานพยาบาล (อัปเดตปีปัจจุบัน)", "wrap" => true, "size" => "sm" ],
                                        [ "type" => "text", "text" => "2. ใบประกอบวิชาชีพ", "wrap" => true, "size" => "sm" ],
                                        [ "type" => "text", "text" => "3. สำเนาบัตรประชาชน", "wrap" => true, "size" => "sm" ],
                                        [ "type" => "text", "text" => "4. ใบ ภ.พ.20 (ถ้ามี)", "wrap" => true, "size" => "sm" ],
                                        [ "type" => "text", "text" => "5. อีเมล (ถ้ามี)", "wrap" => true, "size" => "sm" ]
                                    ]
                                ],
                
                                [
                                    "type" => "separator",
                                    "margin" => "lg"
                                ],
                
                                [
                                    "type" => "text",
                                    "text" => "📌 ข้อมูลสำหรับจัดส่งสินค้า",
                                    "weight" => "bold",
                                    "size" => "md",
                                    "margin" => "lg"
                                ],
                                [
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "spacing" => "sm",
                                    "margin" => "sm",
                                    "contents" => [
                                        [ "type" => "text", "text" => "🏠 ที่อยู่จัดส่งสินค้า", "wrap" => true, "size" => "sm" ],
                                        [ "type" => "text", "text" => "☎️ เบอร์โทรศัพท์ติดต่อ", "wrap" => true, "size" => "sm" ]
                                        // [ "type" => "text", "text" => "📮 อีเมล (ถ้ามี)", "wrap" => true, "size" => "sm" ]
                                    ]
                                ],
                
                                [
                                    "type" => "separator",
                                    "margin" => "lg"
                                ],
                
                                [
                                    "type" => "text",
                                    "text" => "หลังจากส่งเอกสารครบ ไม่เกิน 1 วันทำการ\nทางเราจะแจ้งรายละเอียดการสั่งสินค้าพร้อมกับคูปองส่วนลดสุดพิเศษ 🤩",
                                    "wrap" => true,
                                    "size" => "sm",
                                    "color" => "#444444",
                                    "margin" => "lg"
                                ]
                            ]
                        ]
               /*          "footer" => [
                            "type" => "box",
                            "layout" => "vertical",
                            "spacing" => "md",
                            "paddingAll" => "15px",
                            "contents" => [
                                [
                                    "type" => "button",
                                    "style" => "primary",
                                    "color" => "#1DB446",
                                    "action" => [
                                        "type" => "message",
                                        "label" => "ส่งเอกสาร",
                                        "text" => "ขอส่งเอกสารเปิดโค้ด"
                                    ]
                                ],
                                [
                                    "type" => "button",
                                    "style" => "secondary",
                                    "action" => [
                                        "type" => "message",
                                        "label" => "สอบถามเพิ่มเติม",
                                        "text" => "สอบถามเพิ่มเติม"
                                    ]
                                ]
                            ]
                        ] */
                    ]
                ];
                
                $lineId = $userId;
                $message = $flex;
                // $message = 'ลงทะเบียนลูกค้าใหม่กับเรา';
        
                $this->send($lineId, $message);
        
        
                return response()->json([
                    'status' => 'successfully_rewards' ,
                ]);

            }

        }

       
    }

    public function loginLine(Request $request) {


     /*    $guestId = $request->cookie('guest_id'); 
        dd($guestId); */
/* 
        $guestIdCookie = request()->cookie('guest_id');
        
        $guestIdDb = strlen($guestIdCookie) > 512 ? hash('sha256', $guestIdCookie) : $guestIdCookie;

        $userId = LineAccount::where('line_cookie_id', $guestIdDb)->first(['line_user_id', 'liff_token']); */
        if(Auth::check()) {

            $code = Auth::user()->user_id;
            // dd($code);
            $user_name = User::select('name', 'admin_area','user_code')->where('user_code', $code)->first();
    
            $lineUserId = Auth::user()?->line_user_id;

            $lineAccount = null;

            if($lineUserId) {

                $lineAccount = LineAccount::where('line_user_id', $lineUserId)
                                        ->first(['line_user_id', 'liff_token']);

            }

            $user = Auth::user();

            $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

            $id = $request->user()->admin_area;

            $status_all = DB::table('customers')->select('status')
                        ->where('admin_area', $id)
                        ->whereNotIn('customer_status', ['inactive'])
                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                        ->whereNotIn('customer_id', $code_notin)
                        ->count();

            $status_waiting = DB::table('customers')->where('admin_area', $id)
                            ->where('status', 'รอดำเนินการ')
                            ->whereNotIn('customer_status', ['inactive'])
                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                            ->whereNotIn('customer_id', $code_notin)
                            ->count();
                            // dd($count_waiting);
            $status_action = DB::table('customers')->where('admin_area', $id)
                            ->where('status', 'ต้องดำเนินการ')
                            ->whereNotIn('customer_status', ['inactive'])
                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                            ->whereNotIn('customer_id', $code_notin)
                            ->count();

            $status_completed = DB::table('customers')->where('admin_area', $id)
                            ->where('status', 'ดำเนินการแล้ว')
                            ->whereNotIn('customer_status', ['inactive'])
                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                            ->whereNotIn('customer_id', $code_notin)
                            ->count();

            $status_alert = $status_waiting + $status_action;

          return match ($user->role) {
            
                1 => view('admin.my-account-admin', compact(
                    'lineAccount',
                    'user',
                    'code',
                    'user_name'
                )),

                2 => view('webpanel.my-account', compact(
                    'lineAccount',
                    'user',
                    'code',
                    'user_name'
                )),

                0 => view('portal.portal-my-account', compact(
                    'lineAccount',
                    'user',
                    'code',
                    'user_name',
                    'status_alert',
                    'status_all',
                    'status_waiting',
                    'status_action',
                    'status_completed'
                    
                )),

                default => view('portal.my-account', compact(
                    'lineAccount',
                    'user',
                    'code',
                    'user_name'
                )),
            };


       /*      return view('portal/my-account', compact(
                                                        'lineAccount',
                                                        'user',
                                                        'code',
                                                        'user_name'
                                                    )); */

        }

    }
    //profile user
 /*    public function profileUser()
    {
        if(Auth::check()) {
            $user = Auth::user();
            
            return view('portal/profile-line', compact('user'));
        }
    } */


}
