<?php

namespace Stanislavz\PhpOop\Model;

class ClassInformator
{
    /**
     * @param $object
     * @return array
     * @throws \ReflectionException
     */
    public function getPublicMethods($object): array
    {
        $reflection = $this->reflectionFactory($object);
        $publicMethodsList = [];
        $publicMethods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($publicMethods as $currentObject) {
            $publicMethodsList[] = [
                'name'  => $currentObject->name,
                'class' => $currentObject->class
            ];
        }

        return $publicMethodsList;
    }

    /**
     * @param $object
     * @return array
     * @throws \ReflectionException
     */
    public function getConstants($object): array
    {
        $parents = class_parents($object);
        $parents[\get_class($object)] = \get_class($object);
        $parents = array_reverse($parents);
        $constantsList = [];

        foreach ($parents as $className => $classData) {
            $obj = new \ReflectionClass($className);
            $constantsList[$className] =  $obj->getConstants();
        }

        return $constantsList;
    }

    /**
     * @param $object
     * @return \ReflectionClass
     * @throws \ReflectionException
     */
    private function reflectionFactory($object): \ReflectionClass
    {
        return new \ReflectionClass(\get_class($object));
    }
}
