<?php 
namespace dopler_core;

class Registry
{
    use TSingleton;

    protected static array $properties = array();

    public function setProperty($name, $value)
    {
        self::$properties[$name] = $value;
    }
    public function getProperty($name)
    {
        return self::$properties[$name] ?? null;
    }
    public function getProperties()
    {
        return self::$properties;
    }
}

?>