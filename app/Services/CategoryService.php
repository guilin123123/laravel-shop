<?php
namespace App\Services;

use App\Models\Category;

class CategoryService
{
    // 这是一个递归方法
    // $patentId 参数代表要获取子类目的父类目 ID,null 代表获取所有根类目
    // $allCategories 参数代表数据库中所有的类目. 如果是null代表需要从数据库中查询
    public function getCategoryTree($parentId = null, $allCategories = null)
    {
        if (is_null($allCategories)) {
            // 一次性取出所有类目
            $allCategories = Category::all();
        }

        return $allCategories
            // 所有类目中挑选父类目ID为 $parentId的类目
            ->where('parent_id', $parentId)
            // 遍历这些类目, 并用返回值构建一个新的集合
            ->map(function (Category $category) use ($allCategories){
                $data = ['id' => $category->
                id, 'name' => $category->name];

                // 如果当前类目不是父类目,则直接返回
                if (!$category->is_directory) {
                    return $data;
                }
                // 否则递归调用本方法, 将返回值放入children 字段中
                $data['children'] = $this->getCategoryTree($category->id, $allCategories);

                return $data;
            });
    }
}
