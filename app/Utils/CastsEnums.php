<?php
/**
 *  Copyright (c) 2018 Webbing Brasil (http://www.webbingbrasil.com.br)
 *  All Rights Reserved
 *
 *  This file is part of the android project.
 *
 * @project exercicioemcasa
 * @file CastsEnums.php
 * @author Danilo Andrade <danilo@webbingbrasil.com.br>
 * @date 31/08/18 at 16:57
 * @copyright  Copyright (c) 2017 Webbing Brasil (http://www.webbingbrasil.com.br)
 */

/**
 * Created by PhpStorm.
 * User: Danilo
 * Date: 23/08/2018
 * Time: 17:24
 */

namespace App\Utils;


trait CastsEnums
{

    /**
     * Get an attribute from the model.
     *
     * @param  string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if ($this->isEnumAttribute($key)) {
            return $this->getAttributeValue($key);
        }
        return parent::getAttribute($key);
    }

    /**
     * Returns whether the attribute was marked as enum
     *
     * @param $key
     *
     * @return bool
     */
    private function isEnumAttribute($key)
    {
        return isset($this->enums[$key]);
    }

    /**
     * Get a plain attribute (not a relationship).
     *
     * @param  string $key
     * @return mixed
     */
    public function getAttributeValue($key)
    {
        if ($this->isEnumAttribute($key)) {
            $class = $this->getEnumClass($key);
            return new $class($this->getAttributeFromArray($key));
        }
        return parent::getAttributeValue($key);
    }

    /**
     * Returns the enum class.
     *
     * @param $key
     *
     * @return mixed
     */
    private function getEnumClass($key)
    {
        return $this->enums[$key];
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if ($this->isEnumAttribute($key)) {
            $enumClass = $this->getEnumClass($key);
            if (!$value instanceof $enumClass) {
                $value = new $enumClass($value);
            }
            $this->attributes[$key] = $value->getValue();
            return $this;
        }
        parent::setAttribute($key, $value);
    }
}
