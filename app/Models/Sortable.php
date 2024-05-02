<?php

namespace App\Models;

use Illuminate\Support\Arr;

class Sortable
{
    protected $currentUrl;
    protected $query=[];

    public function current($currentUrl)
    {
        $this->currentUrl = $currentUrl;
    }
    public function appends(array $query){
        $this->query=$query;
    }

    public function url($column): string
    {

        if ($this->isSortingBy($column)) {
            return $this->buildSortableUrl("{$column}-desc");
        }

        return $this->buildSortableUrl($column);
    }
    protected function buildSortableUrl($order): string
    {
        return $this->currentUrl.'?'.Arr::query(array_merge($this->query,['order' => $order]));
    }

    public function classes($column)
    {
        if ($this->isSortingBy($column)) {
            return 'link-sortable link-sorted-up';
        }

        if ($this->isSortingBy("{$column}-desc")) {
            return 'link-sortable link-sorted-down';
        }
        return 'link-sortable';
    }
    protected function isSortingBy($column): bool
    {
        return Arr::get($this->query,'order')== $column;
    }

}
