<?php
class Bicycle
{
    private $properties = array();

    public function __construct($data)
    {
        $this->properties['identifyNumber'] = $data['IdentifyNumber'];
        $this->properties['uniqueName'] = $data['UniqueName'];
        $this->properties['status'] = $data['Status'];
        $this->properties['image'] = $data['image'];
    }

    public function &__get($name)
    {
        if (!array_key_exists($name, $this->properties))
            throw new Exception("Trying to access non-existing property $name");
        return $this->properties[$name];
    }

    public function __set($name, $value)
    {
        if (!array_key_exists($name, $this->properties))
            throw new Exception("Trying to access non-existing property $name");
        $this->properties[$name] = $value;
    }
}
