<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class NavCategoryController extends Controller
{
    public function get_nav()
    {
        $categories = $this->make_category_tree_array();
        $category_html = "";
        foreach ($categories as $key=>$category){
            $category_html .= $this->cats($category, $key);
        }
        return response()->json(["html"=>$category_html]);
    }

    function buildCategories($children, $parent_id)
    {
        $result = array();
        foreach ($children as $row) {
            if ($row->parent_id == $parent_id) {
                if (Category::where('parent_id', $row->id)->where('status', 1)->exists()) {
                    $children = Category::where('parent_id', $row->id)->where("status", 1)->get();
                    $temp_category = [];
                    $temp_category['id'] = $row->id;
                    $temp_category['name'] = $row->name;
                    $temp_category['parent'] = $parent_id;
                    $temp_category['child'] = $this->buildCategories($children, $row->id);
                    $result[] = $temp_category;
                } else {
                    $temp_category['id'] = $row->id;
                    $temp_category['name'] = $row->name;
                    $temp_category['parent'] = $parent_id;
                    $temp_category['child'] = [];
                    $result[] = $temp_category;
                }
            }
        }
        return $result;
    }

    public function make_category_tree_array()
    {
        $categories = Category::where("status", 1)
            ->where('parent_id', 0)
            ->get();

        $all_category = [];

        foreach ($categories as $key => $item) {
            $module = $item->name . '_' . $item->id;
            if (Category::where('parent_id', $item->id)->where('status', 1)->exists()) {
                $children = Category::where('parent_id', $item->id)->where("status", 1)->get();
                $temp_category = [];
                $temp_category['id'] = $item->id;
                $temp_category['name'] = $item->name;
                $temp_category['parent'] = null;
                $temp_category['child'] = $this->buildCategories($children, $item->id);
                $all_category[] = $temp_category;
            } else {
                $temp_category['id'] = $item->id;
                $temp_category['name'] = $item->name;
                $temp_category['parent'] = null;
                $temp_category['child'] = [];
                $all_category[] = $temp_category;
            }
        }

        return $all_category;
    }

    function drop_down_cat_print($category)
    {
        $data = [
            "id" => $category['id'],
            "category_name" => str_replace(' ', '-', strtolower($category['name']))
        ];
        $html = "";

        // if (Product::whereJsonContains('selected_categories', $category['id'])->exists()) {
            $html .=  "  <li>
                        <a href=\"" . route('category_product', $data) . "\" class='" . (count($category['child']) ? 'nf600' : '') . "'>" .
                $category['name']
                . "</a>
                    </li>";
        // } else {
        //     $html .=  "";
        // }
        foreach ($category['child'] as $child) {
            $html .= $this->drop_down_cat_print($child);
        }

        return $html;
    }

    function cats($category, $key)
    {
        $html = "";
        $data = [
            "id" => $category['id'],
            "category_name" => str_replace(' ', '-', strtolower($category['name']))
        ];
        // echo " <li><a href=\"".route('category_product', $data)."\">". $category['name'];
        $html .= "
            <li>
                <div class=\"nav_title\"> ";
        $html .= "      <a href=\"" . route('category_product', $data) . "\"> " . $category['name'] . " </a>";

        if (count($category['child'])) {
            $html .= "      <div onclick=\"show_dropdown()\" class=\"show_more\">
                            <i class='fa text-light fa-plus-square-o'></i>
                        </div>";
        }

        $html .= "</div>";

        if (count($category['child'])) {
            $html .=   "
                    <div class=\"drop_down2 \">
                        <ul class=\"simple_ul\">";
            foreach ($category['child'] as $child) {
                $html .= $this->drop_down_cat_print($child);
            }
            $html .= "
                        </ul>
                    </div>
                </li>
            ";
        } else {
            $html .= "</li>";
        }

        return $html;
    }
}
