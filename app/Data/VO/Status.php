<?php

namespace App\Data\VO;

use App\Utils\AbstractEnum;

/**
 * Class Status
 * @method static ACTIVE()
 * @method static INACTIVE()
 * @package App\Data\VO
 */
class Status extends AbstractEnum
{
    protected const DEFAULT = self::ACTIVE;

    public const INACTIVE = 0;
    public const ACTIVE = 1;

    protected static function boot() {
        self::setLabels([
           self::ACTIVE => trans('labels.active'),
           self::INACTIVE => trans('labels.inactive'),
        ]);
    }
}
