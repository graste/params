<?php

namespace Params\Immutable;

use Params\ConfigurableArrayObject;

/**
 * Class that gives recursive read-only access to settings added via constructor.
 */
class ImmutableSettings extends ConfigurableArrayObject implements ImmutableSettingsInterface
{
    /**
     * Create a new instance with the given data as initial value set.
     *
     * The 'mutable' option will be set to false even if provided as true.
     *
     * @param array $data initial data
     * @param array $options
     */
    public function __construct(array $data = [], array $options = [])
    {
        $options[self::OPTION_MUTABLE] = false;
        parent::__construct($data, $options);
    }
}
