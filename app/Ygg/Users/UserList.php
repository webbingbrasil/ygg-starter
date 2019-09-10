<?php

namespace App\Ygg\Users;

use App\Data\Entities\User;
use Ygg\Resource\AbstractResource;
use Ygg\Resource\Field;
use Ygg\Resource\ResourceQueryParams;

class UserList extends AbstractResource
{
    public function fields(): void
    {
        $this->addField(
            Field::make('name')
                ->setLabel('Name')
                ->setSortable()
        )->addField(
            Field::make('email')
                ->setLabel('E-mail')
                ->setSortable()
        );
    }

    public function config(): void
    {
        $this
            ->setInstanceIdAttribute('id')
            ->setDefaultSort('name')
            ->withSearch()
            ->withPagination();
    }

    public function layout(): void
    {
        $this->addColumn('name', 2);
        $this->addColumn('email', 8);
    }

    public function data(ResourceQueryParams $params)
    {
        /** @var User $query */
        $query = User::orderBy($params->sortedBy(), $params->sortedDir());

        if ($params->hasSearch()) {
            $query->search($params->searchTerm());
        }

        return $this->transform($query->paginate());
    }
}
