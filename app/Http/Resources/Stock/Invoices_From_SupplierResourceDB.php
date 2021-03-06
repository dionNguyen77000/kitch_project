<?php

namespace App\Http\Resources\Stock;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Invoices_From_SupplierResourceDB extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
                'id' => $this->id,
                'user'=> $this->user,
                'img'=> $this->img,
                'img_three'=> $this->img_three,
                'img_two'=> $this->img_two  ,
                'img_thumbnail'=> $this->img_thumbnail  ,
                'supplier'=> $this->supplier  ,
                'supplier_invoice_number'=> $this->supplier_invoice_number , 
                // 'received_date'=> Carbon::parse($this->received_date)->format('d-M-Y H:i:s'),
                'received_date'=> $this->received_date,  
                // 'received_date'=> date("Y-m-d H:i:s", strtotime($this->received_date)),  
                // date("Y-m-d\TH:i:s", strtotime($this->received_date)),  
                'total_price'=> $this->total_price,  
                'orders_to_supplier_id'=> $this->orders_to_supplier_id,  
                'Note'=> $this->Note , 
                'paid'=> $this->paid,  
          
        ];
    }
    // public function toArray($request)
    // {
    //     return parent::toArray($request);
    // }
}
