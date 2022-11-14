<?php
class Client
{
    private $properties = array();

    public function __construct($row)
    {
        $this->properties['TIN'] = $row['TIN'];
        $this->properties['address'] = $row['Address'];
        $this->properties['name'] = $row['Name'];
        $this->properties['NIN'] = $row['NIN'];
        $this->properties['username'] = $row['Username'];
        $this->properties['password'] = $row['Password'];
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
