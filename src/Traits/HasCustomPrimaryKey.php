<?php

  namespace BCS\Model\Traits;

  trait HasCustomPrimaryKey
  {

    /**
     * Since models from the older BCS tables don't use id as their id field,
     * bugs can be introduced when ->id is used accidentally.
     * This function will ensure that $Course->id will return an id rather than null
     * @return mixed
     */
    public function getIDattribute(){
        return $this->{$this->primaryKey};
    }

    /**
     * Since primaryKey is not id it is sometimes useful to be able to know what
     * it is.
     * @return mixed
     */
    public function getprimaryKey(){
        return $this->primaryKey;
    }
  }
