<?php

namespace App\Traits;

trait NameTrait
{
    public function fullName1()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function fullName2()
    {
        return $this->first_name.' '.$this->middle_name.' '.$this->last_name;
    }

    public function fullName3()
    {
        return $this->last_name.', '.$this->first_name;
    }

    public function fullName4()
    {
        return $this->last_name.', '.$this->first_name.' '.$this->middle_name;
    }

    public function fullName5()
    {
        return $this->last_name.', '.$this->first_name.' '.$this->suffix;
    }
}
