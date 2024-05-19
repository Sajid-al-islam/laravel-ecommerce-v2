<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Product\ProductVariant;
use App\Models\Product\ProductVariantValue;
use App\Models\Product\ProductVariantValueProduct;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variants = [
            "size" => [
                [
                    "title" => "xs",
                    "default_checked" => 0,
                ],
                [
                    "title" => "sm",
                    "default_checked" => 0,
                ],
                [
                    "title" => "md",
                    "default_checked" => 1,
                ],
                [
                    "title" => "l",
                    "default_checked" => 1,
                ],
                [
                    "title" => "xl",
                    "default_checked" => 1,
                ],
                [
                    "title" => "xxl",
                    "default_checked" => 0,
                ],
            ],
            // "color" => [
            //     [
            //         "title" => "white",
            //         "default_checked" => 0,
            //     ],
            //     [
            //         "title" => "skyblue",
            //         "default_checked" => 0,
            //     ],
            //     [
            //         "title" => "orange",
            //         "default_checked" => 0,
            //     ],
            // ],
        ];

        ProductVariant::truncate();
        ProductVariantValue::truncate();

        foreach ($variants as $variant => $variant_values) {
            $variant_data = ProductVariant::create([
                "title" => $variant,
            ]);
            foreach ($variant_values as $value) {
                $variant_value = ProductVariantValue::create([
                    "title" => $value["title"],
                    "product_variant_id" => $variant_data->id,
                    "default_checked" => $value["default_checked"],
                ]);
            }
        }

        $products = Product::select('id')->get();
        foreach ($products as $product) {
            foreach ([3,4,5] as $product_variant_value_id) {
                ProductVariantValueProduct::create([
                    "product_variant_id" => 1, // size id
                    "product_variant_value_id" => $product_variant_value_id,
                    "product_id" => $product->id,
                ]);
            }
        }
    }
}
