<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($data, $statusCode= 200): array
    {
        return 
        [
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'location'=> $this->location,
        ];
    }
    /**
     * إرجاع استجابة نجاح مع رسالة
     *
     * @param string $message رسالة النجاح
     * @param int $statusCode رمز الحالة
     * @return \Illuminate\Http\JsonResponse
     */
    // public function success($message = 'تمت العملية بنجاح', $statusCode = 200)
    // {
    //     return response()->json([
    //         'success' => true,
    //         'message' => $message
    //     ], $statusCode);
    // }
}
