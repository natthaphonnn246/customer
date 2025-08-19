<?php

namespace App\Enums;

enum CustomerStatusEnum: string
{
  // เอาไว้ใช้แทนค่าคงที่ครับ

  // ประโยชน์
  // - อ่านง่ายขึ้น
  // - ป้องกันการพิมพ์ผิดของ string
  // - รวมค่าที่เกี่ยวข้องอยู่ที่เดียว

  // เวลาใช้ก็เรียกใช้แบบนี้ครับ CustomerStatusEnum::Waiting
  // เช่น
  //
  // if ($status === 'รอดำเนินการ') {
  //   echo "ลูกค้ารอการดำเนินการ";
  // }
  //
  // if ($status === CustomerStatusEnum::Waiting) {
  //   echo "ลูกค้ารอการดำเนินการ";
  // }

  case Waiting = 'รอดำเนินการ';
  case Registration = 'ลงทะเบียนใหม่';
}
