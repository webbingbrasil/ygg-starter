<?php

namespace App\Ygg\Users;

use App\Data\Entities\User;
use Illuminate\Support\Arr;
use Ygg\Fields\PasswordField;
use Ygg\Fields\TextField;
use Ygg\Form\AbstractForm;
use Ygg\Form\Eloquent\WithFormEloquentUpdater;
use Ygg\Layout\Form\FormColumn;

class UserForm extends AbstractForm
{
    use WithFormEloquentUpdater;

    public function fields(): void
    {
        $this->addField(
            TextField::make('name')
                ->setLabel('Name')
        )->addField(
            TextField::make('email')
                ->setLabel('E-mail')
        )->addField(
            PasswordField::make('password')
                ->setLabel('Senha')
        )->addField(
            PasswordField::make('password_confirmation')
                ->setLabel('Confirmar Senha')
        );
    }

    public function layout(): void
    {
        $this->addColumn(12, function (FormColumn $column) {
            $column->withFields('name|6', 'email|6');
        })
            ->addColumn(12, function (FormColumn $column) {
                $column->withFields('password|6','password_confirmation|6');
            });
    }

    public function find($id): array
    {
        return $this->transform(
            User::findOrFail($id)
        );
    }

    public function update($id, array $data)
    {
        $instance = $id ? User::findOrFail($id) : new User();
        $fields = ['name', 'email'];

        if(!$instance->exists() || !empty($data['password'])) {
            $fields[] = 'password';
        }

        if(!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $this->save($instance, Arr::only($data, $fields));

        $this->notify('User saved')
            ->setLevelSuccess()
            ->setAutoHide(true);
    }

    /**
     * @param $id
     */
    public function delete($id): void
    {
        User::findOrFail($id)->delete();
    }
}
