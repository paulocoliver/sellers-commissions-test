<?php
namespace App\Traits;

use \Illuminate\Validation\Validator;

/**
 * Trait hasValidation
 *
 * @package App\Traits
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait hasValidation {

    /**
     * Validation rules
     * @var array
     */
    protected static $validationRules = array();

    /**
     * Validation Custom Messages
     * @var array
     */
    protected static $validationCustomMessages = array();

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * Validation Custom Messages
     * @var array
     */
    protected $validation_attributes = [];

    /**
     * Listen for save event
     */
    protected static function bootHasValidation()
    {
        $fnValidator = function($model) {
            /** @var static $model */
            if (empty($model->validator)) {
                $model->setValidator();
            }
        };

        static::saving   ($fnValidator);
        static::deleting ($fnValidator);

        static::addEventsValidation();
    }

    protected static function addEventsValidation()
    {
        $validate = function($model) {
            /** @var static $model */
            return $model->validate();
        };
        static::creating($validate);
        static::updating ($validate);

        static::deleting(function($model) {
            /** @var static $model */
            return $model->validateDelete();
        });
    }

    protected function getValidationAttributes()
    {
        return array_merge($this->attributes, $this->validation_attributes);
    }

    /**
     * @param Validator $validator
     * @return $this
     */
    public function setValidator(Validator $validator=null)
    {
        if (empty($validator)) {
            if (!empty($this->validator))
                return $this;

            /** @var \Illuminate\Validation\Factory $factoryValidation */
            $factoryValidation = app ()->make ('validator');
            $validator = $factoryValidation->make([], []);
        }
        $this->validator = $validator;
        return $this;
    }

    /**
     * @return Validator
     */
    public function getValidator() {
        return $this->validator;
    }

    public function getValidationFillable()
    {
        return [];
    }

    public function hasValidationFill(array $attributes)
    {

        if (is_array($attributes)) {
            $fillable = $this->getValidationFillable();

            foreach ($fillable AS $key) {
                if (isset($attributes[$key])) {
                    $this->validation_attributes[$key] = $attributes[$key];
                }
            }
        }
    }

    public function fill(array $attributes)
    {
        $this->hasValidationFill($attributes);
        return parent::fill($attributes);
    }


    /**
     * Get the validation rules.
     *
     * @return array
     */
    protected function getValidationRules()
    {
        return static::$validationRules;
    }

    /**
     * Get the custom messages for the validator.
     *
     * @return array
     */
    protected function getValidationCustomMessages()
    {
        return static::$validationCustomMessages;
    }

    /**
     * Get the custom values on the validator.
     *
     * @return array
     */
    protected function getValidationValuesNames()
    {
        return [];
    }

    /**
     * Get the custom attributes on the validator.
     *
     * @return array
     */
    protected function getValidationAttributesNames()
    {
        return [];
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     */
    public function withValidator($validator) {}

    public function getDirtyAttributesRules()
    {
        $all_rules = $this->getValidationRules();
        $dirty = $this->getDirty();

        foreach ($all_rules as $field => $rules) {

            $rules = is_array($rules) ? $rules : explode('|', $rules);

            if (($k = array_search('validate_if_dirty', $rules)) !== false) {
                if (!$this->exists || array_key_exists($field, $dirty)) {
                    unset($rules[$k]);
                } else {
                    unset($all_rules[$field]);
                    continue;
                }
            }

            $all_rules[$field] = $rules;
        }

        return $all_rules;
    }


    /**
     * Validates current attributes against rules
     *
     * @return bool
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate()
    {
        static::fireModelEvent ('before_validate', false);

        if (empty($this->validator))
            $this->setValidator();

        $this->validator->setData($this->getValidationAttributes());
        $this->validator->setRules($this->getDirtyAttributesRules ());
        $this->validator->setCustomMessages ($this->getValidationCustomMessages ());
        $this->validator->setValueNames ($this->getValidationValuesNames ());
        $this->validator->setAttributeNames ($this->getValidationAttributesNames ());

        $this->withValidator ($this->validator);

        static::fireModelEvent ('validating', false);
        $this->validator->validate();
        static::fireModelEvent ('validated', false);

        return true;
    }

    /**
     * Add a message to the bag.
     *
     * @param  string  $key
     * @param  string  $message
     * @return $this
     */
    public function addErrorMessage($key, $message)
    {
        if (empty($this->validator))
            $this->setValidator();

        $this->validator->after(function () use ($key, $message) {
            $this->validator->errors()->add($key, $message);
        });

        return $this;
    }

    /**
     * Add messages to the bag.
     *
     * @param  array $messages
     * @return $this
     */
    public function addErrorMessages(array $messages)
    {
        if (empty($this->validator))
            $this->setValidator();

        $this->validator->after(function () use ($messages) {
            foreach ($messages as $key => $message) {
                $this->validator->errors()->add($key, $message);
            }
        });

        return $this;
    }

    /**
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateDelete()
    {
        $this->validator->validate();
        return true;
    }

    public static function onBeforeValidate(\Closure $callback)
    {
        static::registerModelEvent('before_validate', $callback);
    }

    public static function onValidating(\Closure $callback)
    {
        static::registerModelEvent('validating', $callback);
    }

    public static function onValidated(\Closure $callback)
    {
        static::registerModelEvent('validated', $callback);
    }
}