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
        $this->setDefaultSort('name', 'asc');
    }

    public function layout(): void
    {
        $this->addColumn('name', 2);
        $this->addColumn('email', 8);
    }

    public function data(ResourceQueryParams $params): array
    {
        return User::orderBy($params->sortedBy(), $params->sortedDir())->get()->toArray();
    }
}
