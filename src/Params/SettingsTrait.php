<?php

namespace Params;

use Params\Immutable\ImmutableSettingsTrait;
use Params\Settings;
use ArrayAccess;
use InvalidArgumentException;

/**
 * Trait that contains a Settings instance to use for nestable configuration
 * settings.
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
     * @param array $data associative array or ArrayAccess implementing object
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return Settings self instance for fluent API
     *
     * @throws \InvalidArgumentException on wrong data type given
     */
    public function addSettings($data = array(), $replace = true)
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
     * @param mixed $settings Either array or ArrayAccess implementing object.
     *
     * @throws \InvalidArgumentException on wrong data type given
     */
    public function setSettings($settings)
    {
        if (is_array($settings) || $settings instanceof ArrayAccess) {
            $this->settings = new Settings($settings);
        } else {
            throw new InvalidArgumentException(
                "Invalid argument given. Only the 'array' or 'ArrayAccess' implementing objects are supported."
            );
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
