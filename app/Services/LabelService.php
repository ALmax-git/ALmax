<?php
// app/Services/LabelService.php

namespace App\Services;

use App\Models\Label;
use Illuminate\Support\Str;

class LabelService
{
    public function createLabel($productId, $variantId = null, $status = 'new')
    {
        return Label::create([
            'product_id' => $productId,
            'variant_id' => $variantId,
            'qr_key' => 'ALmax-' . Str::random(16),
            'serial_number' => '0x' . strtoupper(Str::random(10)),
            'status' => $status,
        ]);
    }

    public function bulkCreateLabels($productId, $variantId = null, $quantity = 1, $status = 'new')
    {
        $labels = [];

        for ($i = 0; $i < $quantity; $i++) {
            $labels[] = $this->createLabel($productId, $variantId, $status);
        }

        return $labels;
    }

    public function deactivateLabel($labelId)
    {
        $label = Label::findOrFail($labelId);
        $label->status = 'inactive';
        $label->save();

        return $label;
    }
}
