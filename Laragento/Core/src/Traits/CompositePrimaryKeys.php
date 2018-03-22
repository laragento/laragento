<?php

namespace Laragento\Core\Traits;

trait CompositePrimaryKeys {

    protected $ignoredPrimaryKeys = [];


    protected function setIgnoredPrimaryKeys($ignoredPrimaryKeys)
    {
        $this->ignoredPrimaryKeys = $ignoredPrimaryKeys;
    }

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query )
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            if (!in_array($keyName,$this->ignoredPrimaryKeys)) {
                $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
            }

        }
        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
