<?php

namespace ActiveGenerator\JetstreamToolbox\Livewire\DataTable;

trait WithSorting
{
    public $sortField = '';
    public $sortDirection = 'asc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection == "asc" ? "desc": "asc";
        } else {
            $this->sortField = $field;
            $this->sortDirection = "asc";
        }
    }

    public function applySorting($query)
    {
        if ($this->sortField) {
            $query->orderBy($this->sortField, $this->sortDirection);
            // dd($this->sortField, $this->sortDirection);
        }

        return $query;
    }
}
