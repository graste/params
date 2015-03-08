<?php

namespace Params;

use InvalidArgumentException;
use Params\ConfigurableArrayObject;
use Params\Immutable\ImmutableSettingsTrait;
use Params\Settings;

/**
 * Trait that contains a Settings instance to use for nestable mutable configuration settings.
 */
trait SettingsTrait
{
    use ImmutableSettingsTrait;

    /**
     * Sets a given value for the specified key.
     *
     * @param mixed $key name of entry
     * @param mixed $value value to set for the given key
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return Settings self instance for fluent API
     *
     * @throws \InvalidArgumentException on empty string or null key given
     */
    public function setSetting($key, $value, $replace = true)
    {
        $this->getSettings()->set($key, $value, $replace);

        return $this;
    }

    /**
     * Adds the given data (key/value pairs) to the current data.
     *
     * @param array|ConfigurableArrayObject $data associative array or ConfigurableArrayObject implementing object
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return Settings self instance for fluent API
     *
     * @throws \InvalidArgumentException on wrong data type given
     */
    public function addSettings($data = [], $replace = true)
    {
        $this->getSettings()->add($data, $replace);

        return $this;
    }

    /**
     * Removes the given key from the internal array.
     *
     * @param mixed $key name of key to remove
     *
     * @return Settings self instance for fluent API
     */
    public function removeSetting($key)
    {
        $this->getSettings()->remove($key);

        return $this;
    }

    /**
     * Delete all internal data.
     *
     * @return Settings self instance for fluent API
     */
    public function clearSettings()
    {
        $this->getSettings()->clear();

        return $this;
    }

    /**
     * Set an object's settings.
     *
     * @param array|ConfigurableArrayObject $settings Either array or ConfigurableArrayObject implementing object.
     *
     * @throws \InvalidArgumentException on wrong data type given
     */
    public function setSettings($settings)
    {
        if ($settings instanceof ConfigurableArrayObject) {
            $this->settings = new Settings((array)$settings);
        } elseif (is_array($settings)) {
            $this->settings = new Settings($settings);
        } else {
            throw new InvalidArgumentException('Only arrays or ConfigurableArrayObject instances are supported.');
        }

        return $this;
    }

    /**
     * Used internally to ensure that the settings property is created.
     */
    protected function ensureSettingsCreated()
    {
        if (null === $this->settings) {
            $this->settings = new Settings();
        }
    }
}
