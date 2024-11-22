<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'department' => DepartmentResource::make($this->whenLoaded('department')),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'position' => $this->position,
            'status' => $this->status,
            'image_url' => $this->when(file_exists(storage_path('app/public/employee_images/' . $this->id .'/' . $this->image_url)), function () {
                return [
                    'orignal' => Storage::disk('public')->url('employee_images/' . $this->id . '/' . $this->image_url),
                    'thumbnail_60_' => Storage::disk('public')->url('employee_images/' . $this->id . '/thumbnail_60_' . $this->image_url),
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
