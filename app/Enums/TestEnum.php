<?php

namespace App\Enums;

enum TestStatusEnum: string
{
  // ตัวอย่างครับ
  case Pending = 'pending';
  case Success = 'success';
  case Canceled = 'canceled';
}
