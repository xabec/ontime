<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class TableComponent extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $sortAsc = true;

    public $hasSearch = true;

    public $hasNew = false;

    public $paginationTheme = 'bootstrap';

    public $hasDateSearch = true;

    protected $listeners = ['resourceDeleted'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function resourceDeleted()
    {
        // No need to do anything
        //we just reload the data
    }
}
