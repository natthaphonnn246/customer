<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class MessageApiService
{
    private string $endpoint;

    public function __construct()
    {
        $this->endpoint = 'https://api.line.me/v2/bot/message/push';
    }

    public function sendRegisterSuccess(string $lineUserId, string $customer_name, string $register_by, string $created_at): void
    {
        Http::withToken(config('services.line.channel_token'))
            ->post($this->endpoint, [
                'to' => $lineUserId,
                'messages' => [
                    $this->registerSuccessFlex($customer_name, $register_by, $created_at),
                ],
            ]);
    }

    private function registerSuccessFlex(string $customer_name, string $register_by, string $created_at): array
    {
        return [
            'type' => 'flex',
            'altText' => "ลงทะเบียนสำเร็จ โดย: {$register_by}",
            'contents' => [
                'type' => 'bubble',
                'size' => 'mega',
                'header' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'backgroundColor' => '#E33939',
                    'paddingAll' => '20px',
                    'contents' => [
                        [
                            'type' => 'text',
                            'text' => 'ลงทะเบียนสำเร็จ',
                            'weight' => 'bold',
                            'size' => 'lg',
                            'color' => '#FFFFFF',
                        ],
                        [
                            'type' => 'text',
                            'text' => 'กรุณารอตรวจสอบเอกสาร',
                            'size' => 'sm',
                            'color' => '#FFFFFF',
                            'margin' => 'sm',
                        ],
                    ],
                ],
                'body' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'spacing' => 'md',
                    'contents' => [
                        [
                            'type' => 'text',
                            'text' => "วันที่ : {$created_at}",
                            'weight' => 'bold',
                            'size' => 'md',
                        ],
                        [
                            'type' => 'text',
                            'text' => "ลงทะเบียนโดย : {$register_by}",
                            'weight' => 'bold',
                            'size' => 'md',
                        ],
                        [
                            'type' => 'text',
                            'text' => "ชื่อร้าน : {$customer_name}",
                            'weight' => 'bold',
                            'size' => 'md',
                        ],
                        [
                            'type' => 'text',
                            'text' => "สถานะเอกสาร :",
                            'weight' => 'bold',
                            'size' => 'md',
                        ],
                        [
                            'type' => 'text',
                            'text' => ' รอดำเนินการ',
                            'weight' => 'bold',
                            'size' => 'md',
                            'color' => '#E33939',
                        ],
                        [
                            'type' => 'text',
                            'text' => "1. SAP : รอดำเนินการ\n2. WEB : รอดำเนินการ",
                            'wrap' => true,
                            'size' => 'sm',
                        ],
                        [
                            'type' => 'separator',
                            'margin' => 'lg',
                        ],
                        [
                            'type' => 'text',
                            'text' => "หลังจากส่งเอกสารครบ\nทีมงานจะติดต่อกลับภายใน 1 วันทำการ ขอบคุณครับ",
                            'wrap' => true,
                            'size' => 'sm',
                            'margin' => 'lg',
                        ],
                    ],
                ],
            ],
        ];
    }
    public function sendWebSuccess(string $lineUserId, string $customer_name, string $customer_code, string $password, string $sale_area, string $updated_at): void
    {
        Http::withToken(config('services.line.channel_token'))
            ->post($this->endpoint, [
                'to' => $lineUserId,
                'messages' => [
                    $this->webSuccessFlex($customer_name, $customer_code, $password, $sale_area, $updated_at),
                ],
            ]);
    }

    private function webSuccessFlex(string $customer_name, string $customer_code, string $password, string $sale_area, string $updated_at): array
    {
        return [
            'type' => 'flex',
            'altText' => 'WEB เปิดโค้ดร้านยา: '.$customer_code.' '. $customer_name . ' เรียบร้อย',
            'contents' => [
                'type' => 'bubble',
                'size' => 'mega',
                'header' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'backgroundColor' => '#1DB446',
                    'paddingAll' => '20px',
                    'contents' => [
                        [
                            'type' => 'text',
                            'text' => 'เปิดโค้ดเรียบร้อย',
                            'weight' => 'bold',
                            'size' => 'lg',
                            'color' => '#FFFFFF',
                        ],
                        [
                            'type' => 'text',
                            'text' => 'แจ้งรหัสเข้าใช้งานตามรายละเอียดได้เลยครับ',
                            'size' => 'sm',
                            'color' => '#FFFFFF',
                            'margin' => 'sm',
                        ],
                    ],
                ],
                'body' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'spacing' => 'md',
                    'contents' => [
                        [
                            'type' => 'text',
                            'text' => "วันที่ : {$updated_at}",
                            'weight' => 'bold',
                            'size' => 'md',
                        ],
                        [
                            'type' => 'text',
                            'text' => "ชื่อร้าน : {$customer_name}",
                            'weight' => 'bold',
                            'size' => 'md',
                        ],
                        [
                            'type' => 'text',
                            'text' => "User : {$customer_code}\nPass : {$password}\n เขตการขาย : {$sale_area}",
                            'wrap' => true,
                            'size' => 'sm',
                        ],
                        [
                            'type' => 'text',
                            'text' => "สถานะเอกสาร :",
                            'weight' => 'bold',
                            'size' => 'md',
                        ],
                        [
                            'type' => 'text',
                            'text' => 'ดำเนินการแล้ว',
                            'weight' => 'bold',
                            'size' => 'md',
                            'color' => '#1DB446',
                        ],
                        [
                            'type' => 'text',
                            'text' => "1. SAP : ดำเนินการแล้ว\n2. WEB : ดำเนินการแล้ว",
                            'wrap' => true,
                            'size' => 'sm',
                        ],
                        [
                            'type' => 'separator',
                            'margin' => 'lg',
                        ],
                        [
                            'type' => 'text',
                            'text' => "หลังจากที่ได้รับข้อความนี้แล้ว\nกรุณาตอบกลับมายังแชตนี้เพื่อยืนยันอีกครั้ง ขอบคุณครับ",
                            'wrap' => true,
                            'size' => 'sm',
                            'margin' => 'lg',
                        ],
                    ],
                ],
            ],
        ];
    }

    public function sendSapSuccess(string $lineUserId, string $customer_name, string $customer_code, string $saleArea, string $updated_at): void
    {
            // array $lineUserIds
 /*        foreach ($lineUserIds as $lineUserId) {

            try {
                Http::withToken(config('services.line.channel_token'))
                    ->post($this->endpoint, [
                        'to' => $lineUserId,
                        'messages' => [
                            $this->sapSuccessFlex(
                                $customer_name,
                                $customer_code,
                                $saleArea
                            ),
                        ],
                    ]);
        
            } catch (\Throwable $e) {
                logger()->error('LINE send failed', [
                    'line_user_id' => $lineUserId,
                    'error' => $e->getMessage(),
                ]);
            }
        } */
            // 1 user
        Http::withToken(config('services.line.channel_token'))
            ->post($this->endpoint, [
                'to' => $lineUserId,
                'messages' => [
                    $this->sapSuccessFlex($customer_name, $customer_code, $saleArea, $updated_at),
                ],
            ]);
    }

    private function sapSuccessFlex(string $customer_name, string $customer_code, string $saleArea, string $updated_at): array
    {
        return [
            'type' => 'flex',
            'altText' => 'SAP เปิดโค้ดเรียบร้อย ชื่อร้านยา: '.$customer_code.' '. $customer_name,
            'contents' => [
                'type' => 'bubble',
                'size' => 'mega',
                'header' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'backgroundColor' => '#F5AD27',
                    'paddingAll' => '20px',
                    'contents' => [
                        [
                            'type' => 'text',
                            'text' => 'SAP เปิดโค้ดเรียบร้อย',
                            'weight' => 'bold',
                            'size' => 'lg',
                            'color' => '#FFFFFF',
                        ],
                        [
                            'type' => 'text',
                            'text' => 'กำลังดำเนินการเปิดบัญชี WEB',
                            'size' => 'sm',
                            'color' => '#FFFFFF',
                            'margin' => 'sm',
                        ],
                    ],
                ],
                'body' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'spacing' => 'md',
                    'contents' => [
                        [
                            'type' => 'text',
                            'text' => "วันที่ : {$updated_at}",
                            'weight' => 'bold',
                            'size' => 'md',
                        ],
                        [
                            'type' => 'text',
                            'text' => "ชื่อร้าน : {$customer_name}",
                            'weight' => 'bold',
                            'size' => 'md',
                        ],
                        [
                            'type' => 'text',
                            'text' => "User : {$customer_code}\n Pass : -\n เขตการขาย : {$saleArea}",
                            'wrap' => true,
                            'size' => 'sm',
                        ],
                        [
                            'type' => 'text',
                            'text' => "สถานะเอกสาร :",
                            'weight' => 'bold',
                            'size' => 'md',
                        ],
                        [
                            'type' => 'text',
                            'text' => ' กำลังดำเนินการ',
                            'weight' => 'bold',
                            'size' => 'md',
                            'color' => '#F5AD27',
                        ],
                        [
                            'type' => 'text',
                            'text' => "1. SAP : ดำเนินการแล้ว\n2. WEB : กำลังดำเนินการ",
                            'wrap' => true,
                            'size' => 'sm',
                        ],
                        [
                            'type' => 'separator',
                            'margin' => 'lg',
                        ],
                        [
                            'type' => 'text',
                            'text' => "หลังจากที่ได้รับข้อความนี้แล้ว\nกรุณารอ WEB ดำเนินการเปิดบัญชี ขอบคุณครับ",
                            'wrap' => true,
                            'size' => 'sm',
                            'margin' => 'lg',
                        ],
                    ],
                ],
            ],
        ];
    }
}
