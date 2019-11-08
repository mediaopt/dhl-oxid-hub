<?php

function getMethod($object, $method)
{
    $reflectionObject = new ReflectionObject($object);
    $reflectionMethod = $reflectionObject->getMethod($method);
    $reflectionMethod->setAccessible(true);
    return $reflectionMethod;
}

function getProperty($object, $property)
{
    $reflectionObject = new ReflectionObject($object);
    $reflectionProperty = $reflectionObject->getProperty($property);
    $reflectionProperty->setAccessible(true);
    return $reflectionProperty->getValue($object);
}
