<?php


namespace Mediaopt\DHL\Api\ProdWS;

class DocumentReferenceList
{

    /**
     * @var DocumentReferenceType $documentReference
     */
    protected $documentReference = null;

    /**
     * @param DocumentReferenceType $documentReference
     */
    public function __construct($documentReference)
    {
      $this->documentReference = $documentReference;
    }

    /**
     * @return DocumentReferenceType
     */
    public function getDocumentReference()
    {
      return $this->documentReference;
    }

    /**
     * @param DocumentReferenceType $documentReference
     * @return DocumentReferenceList
     */
    public function setDocumentReference($documentReference)
    {
      $this->documentReference = $documentReference;
      return $this;
    }

}
