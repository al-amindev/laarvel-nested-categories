<?php

use Illuminate\Support\Facades\DB;

class Categories
{
   
    public function allCategories()
    {
            $categories = DB::table('categories')->get()->groupBy('parent_id')->toArray();
            return $this->nestedCategories($categories[""], $categories);
    }

    private function nestedCategories($categories, $allCategories, $newCategories = [])
    {
        foreach ($categories as $key => $cat) {
            $newCategories[$key] = (array)$cat;
            if (isset($allCategories[$cat->id])) {
                $newCategories[$key]['children'] = $this->nestedCategories($allCategories[$cat->id], $pCat, $newCategories);
            }
        }

        return $newCategories;
    }
}
