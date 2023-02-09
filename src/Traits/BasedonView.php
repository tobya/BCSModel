<?php

  namespace BCS\Model\Traits;

  trait BasedonView
  {
    /**
     *
     * @param $options
     * @return bool
     * @throws \Exception
     */
    public function Save($options = []){
        throw new \Exception('Save() method Not implemented on this model as it is based on a view: ' . $this->table);
    }
  }
