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

    protected const NAME_FIELD = 'name';
    protected const EMAIL_FIELD = 'email';
    protected const PASS_FIELD = 'password';
    protected const PASS_CONFIRMATION_FIELD = 'password_confirmation';

    public function fields(): void
    {
        $this->addField(
            TextField::make(static::NAME_FIELD)
                ->setLabel('Name')
        )->addField(
            TextField::make(static::EMAIL_FIELD)
                ->setLabel('E-mail')
        )->addField(
            PasswordField::make(static::PASS_FIELD)
                ->setLabel('Senha')
        )->addField(
            PasswordField::make(static::PASS_CONFIRMATION_FIELD)
                ->setLabel('Confirmar Senha')
        );
    }

    public function layout(): void
    {
        $this->addColumn(12, function (FormColumn $column) {
            $column->withFields(static::NAME_FIELD.'|6', static::EMAIL_FIELD.'|6');
        })
            ->addColumn(12, function (FormColumn $column) {
                $column->withFields(static::PASS_FIELD.'|6', static::PASS_CONFIRMATION_FIELD.'|6');
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
        $fields = [static::NAME_FIELD, static::EMAIL_FIELD];

        if(!empty($data[static::PASS_FIELD]) || !$instance->exists()) {
            $fields[] = static::PASS_FIELD;
        }

        if(!empty($data[static::PASS_FIELD])) {
            $data[static::PASS_FIELD] = bcrypt($data[static::PASS_FIELD]);
        }

        $this->save($instance, Arr::only($data, $fields));

        $this->notify('User saved')
            ->setLevelSuccess()
            ->setAutoHide();
    }

    /**
     * @param $id
     */
    public function delete($id): void
    {
        User::findOrFail($id)->delete();
    }
}
