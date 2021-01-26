<?php

namespace ActiveGenerator\JetstreamToolbox\Livewire\DataTable;

trait WithBulkActions
{
    public $selectPage = false;
    public $selectAll = false;
    public $selected = [];

    // public function renderingWithBulkActions()
    // {
    //     if ($this->selectAll) $this->selectPageRows();
    // }

    public function updatedSelected()
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function addToSelection($add) {
        $this->selected = collect($this->selected)->merge($add)->unique();
    }

    public function subtractFromSelection($subtract) {
        $this->selected = collect($this->selected)->diff($subtract)->unique();
    }

    public function updatedSelectPage($value) {
        if ($value) {
            $this->addToSelection($this->pluckPage());
        } else {
            $this->subtractFromSelection($this->pluckPage());
        }
    }

    public function pluckPage() {
        return $this->rows->pluck('id')->map(fn($id) => (string) $id);
    }

    public function pluckAll() {
        return $this->rowsQuery->pluck('id')->map(fn($id) => (string) $id);
    }

    public function selectAll() {
        $this->selectAll = true;
        $this->selectPage = true;
        $this->addToSelection($this->pluckAll());
    }

    public function deselectAll() {
        $this->selectAll = false;
        $this->selectPage = false;
        $this->selected = [];
    }

    public function getSelectedRowsQueryProperty()
    {
        return (clone $this->rowsQuery)
            ->whereKey($this->selected);
    }
}
